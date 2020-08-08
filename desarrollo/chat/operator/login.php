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

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('LS_ADMIN_PREVENT_ACCESS')) {
die('You cannot access this file directly.');
}

// Login IN
if (!empty($_POST['action']) && $_POST['action'] == 'login') {

    $username = smartsql($_POST['username']);
    $userpass = smartsql($_POST['password']);
    
    // Security fix
    $valid_agent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
    $valid_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    
    // Write the log file each time someone tries to login before
    $lsuserlogin->lsWriteloginlog($username, $_SERVER['REQUEST_URI'], $valid_ip, $valid_agent, 0);

    $user_check = $lsuserlogin->lsCheckuserdata($username, $userpass);
    if ($user_check == true) {
    
    	// Now login in the user
        $lsuserlogin->lsLogin($username, $userpass, $_POST['lcookies']);
        
        // Write the log file each time someone login after to show success
        $lsuserlogin->lsWriteloginlog($username, '', $valid_ip, '', 1);
        	
        // Unset the recover message
        unset($_SESSION['password_recover']);
        
        ls_redirect(BASE_URL);

    } else {
        $errors = '1';
        $ErrLogin = $tl['error']['l'];
    }
}

// Forgot password
 if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['forgotP'])) {
 	$defaults = $_POST;
 
 	if ($defaults['lsE'] == '' || !filter_var($defaults['lsE'], FILTER_VALIDATE_EMAIL)) {
 	    $errors['e'] = $tl['error']['e19'];
 	}
 	
 	// transform user email
     $femail = filter_var($_POST['lsE'], FILTER_SANITIZE_EMAIL);
     $fwhen = time();
 	
 	// Check if this user exist
     $user_check = $lsuserlogin->lsForgotpassword($femail, $fwhen);
     
     if (!$errors['e'] && !$user_check) {
         $errors['e'] = $tl['error']['e19'];
     }
     
     if (count($errors) == 0) {
         	$mail = new PHPMailer(); // defaults to using php "mail()"
         	$mail->SetFrom(LS_EMAIL, LS_TITLE);
         	$address = $femail;
         	$mail->AddAddress($address, $fusername);
         	$mail->Subject = LS_TITLE.' - '.$tl['login']['l13'];
         	$mail->Body = $tl['login']['l14'].' '.BASE_URL.html_entity_decode(LS_rewrite::lsParseurl($tl['login']['l12'], $fwhen, '', '', ''));
         	
         	if ($mail->Send()) {
         		$_SESSION['password_recover'] = 1;
         		ls_redirect(BASE_URL);     	
         	}
 
     } else {
         $errorfp = $errors;
     }
}

$template = 'login.php';

?>