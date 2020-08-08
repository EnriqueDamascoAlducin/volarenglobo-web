<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1980 03:10:00 GMT");

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

// Start the session
session_start();

if (!file_exists('../config.php')) {
    die('ajax/[available.php] config.php not exist');
}
require_once '../config.php';

// Import the language file
if (file_exists(APP_PATH.'lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'lang/'.LS_LANG.'.ini', true);
} else {
    $tl = parse_ini_file(APP_PATH.'lang/en.ini', true);
}

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] || !isset($_SESSION['guest_userid'])) {
	die("Nothing to see here");
}

if (is_numeric($_GET['conv'])) {

$result = $lsdb->query('SELECT * FROM '.DB_PREFIX.'sessions WHERE userid = "'.smartsql($_GET['userid']).'"');

if ($lsdb->affected_rows > 0) {

	$row = $result->fetch_assoc();
	
		define('BASE_URL_IMG', str_replace('include/', '', BASE_URL));
		
		$message = $_GET['msg'];
		
		$message = filter_var($message, FILTER_SANITIZE_STRING);
		
		$message = trim($message);
		
		$message = replace_urls($message);
		
		if (LS_SMILIES) {
	
			require_once '../class/class.smileyparser.php';	
			
			// More dirty custom work and smiley parser
			$smileyparser = new LS_smiley(); 
			$message = $smileyparser->parseSmileytext($message);
		}
		
		if ($row['status'] == "open" && $message != "") {
		
			$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
			name = "'.smartsql($_GET['name']).'",
			message = "'.smartsql($message).'",
			user = "'.smartsql($_GET['userid']).'",
			convid = "'.smartsql($_GET['conv']).'",
			time = NOW(),
			class = "user"');
			
			$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET
			updated = "'.time().'",
			u_typing = 0
			WHERE userid = "'.smartsql($_GET['userid']).'"');
			
			echo 1;
		
		} elseif ($row['status'] != "open") {
		
			$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
			name = "'.smartsql($_GET['name']).'",
			message = "'.smartsql($tl['general']['g13']).'",
			user = "'.smartsql($_GET['userid']).'",
			convid = "'.smartsql($_GET['conv']).'",
			time = NOW(),
			class = "notice"');
			
			$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET
			updated = "'.time().'",
			u_typing = 0
			WHERE userid = "'.smartsql($_GET['userid']).'"');
			
			echo 1;
			
		} else {
		
			echo $tl['error']['e2'];
		}
		
		
	}
}
?>