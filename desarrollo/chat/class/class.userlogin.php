<?php

/*======================================================================*\
|| #################################################################### ||
|| # Rhino 1.4                                                        # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright 2012 Rhino All Rights Reserved.                        # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| #   ---------------- Rhino IS NOT FREE SOFTWARE ----------------   # ||
|| #                 http://www.livesupportrhino.com                  # ||
|| #################################################################### ||
\*======================================================================*/

class LS_userlogin
{

	protected $name = '', $email = '', $pass = '', $time = '';
	var $username;     //Username given on sign-up
	
	public function __construct() {
	        $this->username = '';
	    }
	   
	function lsChecklogged(){
	
	      /* Check if user has been remembered */
	      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
	         $_SESSION['username'] = $_COOKIE['cookname'];
	         $_SESSION['idhash'] = $_COOKIE['cookid'];
	      }
	
	      /* Username and idhash have been set */
	      if(isset($_SESSION['username']) && isset($_SESSION['idhash']) && $_SESSION['username'] != $this->username) {
	         /* Confirm that username and userid are valid */
	         if(!LS_userlogin::lsConfirmidhash($_SESSION['username'], $_SESSION['idhash'])) {
	            /* Variables are incorrect, user not logged in */
	            unset($_SESSION['username']);
	            unset($_SESSION['idhash']);
	            
	            return false;
	         }
	         
	         // Return the user data
	         return LS_userlogin::lsUserinfo($_SESSION['username']);
	      }
	      /* User not logged in */
	      else{
	         return false;
	      }
	   }
	
	public static function lsCheckuserdata($username, $pass)
	{
	
		// The new password encrypt with hash_hmac
		$passcrypt = hash_hmac('sha256', $pass, DB_PASS_HASH);
		
		if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $username)) {
			return false;
		}
	
		global $lsdb;
		$lsdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE LOWER(username) = "'.strtolower($username).'" AND password = "'.$passcrypt.'" AND access = 1');
		if ($lsdb->affected_rows > 0) {
			return true;
		} else {
			return false;
		}
			
	}
	
	public static function lsLogin($name, $pass, $remember)
	{
		
		// The new password encrypt with hash_hmac
		$passcrypt = hash_hmac('sha256', $pass, DB_PASS_HASH);
	
		global $lsdb;
		
		// Generate new idhash
		$nidhash = LS_userlogin::generateRandID();
		
		// Set session in database
		$sql = 'UPDATE '.DB_PREFIX.'user SET session = "'.smartsql(session_id()).'", idhash = "'.smartsql($nidhash).'", forgot = IF (forgot != 0, 0, 0), lastactivity = "'.time().'" WHERE username = "'.$name.'" AND password = "'.$passcrypt.'"';
		$result = $lsdb->query($sql);
		
		$_SESSION['username'] = $name;
		$_SESSION['idhash'] = $nidhash;
		
		// Check if cookies are set previous (wrongly) and delete
		if ($_COOKIE['cookname'] || $_COOKIE['cookid']) {
			setcookie("cookname", $name, time() - LS_COOKIE_TIME, LS_COOKIE_PATH);
			setcookie("cookid",   $nidhash, time() - LS_COOKIE_TIME, LS_COOKIE_PATH);
		}
		
		// Now check if remember is selected and set cookies new...
		if ($remember) {
			setcookie("cookname", $name, time() + LS_COOKIE_TIME, LS_COOKIE_PATH);
			setcookie("cookid",   $nidhash, time() + LS_COOKIE_TIME, LS_COOKIE_PATH);
		}
		
	}
	
	public static function lsConfirmidhash($username, $idhash)
	{
	
		global $lsdb;
		
		if (isset($username)) {
		
		    $sql = 'SELECT idhash FROM '.DB_PREFIX.'user WHERE LOWER(username) = "'.smartsql(strtolower($username)).'" AND access = 1';
		    $result = $lsdb->queryRow($sql);
		    
		    if ($lsdb->affected_rows < 1) {
		    
		    	return false;
		        
		    } else {
		    
		    	$result['idhash'] = stripslashes($result['idhash']);
		    	$idhash = stripslashes($idhash);
		    			    	
		    	/* Validate that userid is correct */
		    	if(!is_null($result['idhash']) && $idhash == $result['idhash']) {
		    		return true; //Success! Username and idhash confirmed
		    	} else {
		    		return false; //Indicates idhash invalid
		    	}
		    
		    }
		} else {
			return false;
		}
			
	}
	
	public static function lsUserinfo($username)
	{
	
			global $lsdb;
			$sql = 'SELECT * FROM '.DB_PREFIX.'user WHERE LOWER(username) = "'.smartsql(strtolower($username)).'" AND access = 1';
			$result = $lsdb->queryRow($sql);
			if (!$result || $lsdb->affected_rows < 1) {
			   return NULL;
			} else {
				return $result;
			}
			
	}
	
	public static function lsUpdatelastactivity($userid)
	{
	
			global $lsdb;
			$lsdb->query('UPDATE '.DB_PREFIX.'user SET lastactivity = "'.time().'" WHERE id = "'.smartsql($userid).'"');
			
	}
	
	public static function lsForgotpassword($email, $time)
	{
	
			global $lsdb;
			$lsdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE email="'.smartsql($email).'" AND access = 1 LIMIT 1');
			if ($lsdb->affected_rows > 0) {
				if ($time != 0) {
				$lsdb->query('UPDATE '.DB_PREFIX.'user SET forgot = "'.smartsql($time).'" WHERE email="'.smartsql($email).'"');
				}
			    return true;
			} else {
			    return false;
			}
			
	}
	
	public static function lsForgotactive($forgotid)
	{
	
			global $lsdb;
			$lsdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE forgot = "'.smartsql($forgotid).'" AND access = 1 LIMIT 1');
			if ($lsdb->affected_rows > 0) {
			    return true;
			} else
			    return false;
			
	}
	
	public static function lsWriteloginlog($username, $url, $ip, $agent, $success)
	{
	
			global $lsdb;
			if ($success == 1) {
			
				$lsdb->query('UPDATE '.DB_PREFIX.'loginlog SET access = 1 WHERE ip = "'.smartsql($ip).'" AND time = NOW()');
			} else {
			
				$lsdb->query('INSERT INTO '.DB_PREFIX.'loginlog SET name = "'.smartsql($username).'", fromwhere = "'.smartsql($url).'", ip = "'.smartsql($ip).'", usragent = "'.smartsql($agent).'", time = NOW(), access = 0');
			}
			
	}
	
	public static function lsLogout($userid)
	{
	
			global $lsdb;
			// Delete cookies from this page
			setcookie('cookname', '', time() - LS_COOKIE_TIME, LS_COOKIE_PATH);
			setcookie('cookid', '', time() - LS_COOKIE_TIME, LS_COOKIE_PATH);
			
			// Update Database to session NULL
			$lsdb->query('UPDATE '.DB_PREFIX.'user SET session = NULL, idhash = NULL, available = 0 WHERE id = "'.$userid.'"');
			
			// Unset the main sessions
			unset($_SESSION['username']);
			unset($_SESSION['idhash']);
			
			// Destroy session and generate new one for that user
			session_destroy();
			session_regenerate_id();
			
	}
	
	public static function generateRandStr($length){
	   $randstr = "";
	   for($i=0; $i<$length; $i++){
	      $randnum = mt_rand(0,61);
	      if($randnum < 10){
	         $randstr .= chr($randnum+48);
	      }else if($randnum < 36){
	         $randstr .= chr($randnum+55);
	      }else{
	         $randstr .= chr($randnum+61);
	      }
	   }
	   return $randstr;
	}
	
	private static function generateRandID(){
	   return md5(LS_userlogin::generateRandStr(16));
	}
}
?>