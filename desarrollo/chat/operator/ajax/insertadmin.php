<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

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

if (!file_exists('../../config.php')) {
    die('ajax/[available.php] config.php not exist');
}
require_once '../../config.php';

if (file_exists(APP_PATH.'operator/lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'operator/lang/'.LS_LANG.'.ini', true);
} else {
    trigger_error('Translation file not found');
}

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] && !isset($_SESSION['idhash'])) {
	die("Nothing to see here");
}

if (is_numeric($_GET['id']) && is_numeric($_GET['uid'])) {

$result = $lsdb->query('SELECT * FROM '.DB_PREFIX.'sessions WHERE id = "'.smartsql($_GET['id']).'"');

if ($lsdb->affected_rows > 0) {

	$row = $result->fetch_assoc();
	
		define('BASE_URL_IMG', str_replace('operator/ajax/', '', BASE_URL));
		
		$message = $_GET['msg'];
		
		$message = trim($message);
		
		$message = replace_urls($message);
		
		if (LS_SMILIES) {
	
			require_once '../../class/class.smileyparser.php';	
			
			// More dirty custom work and smiley parser
			$smileyparser = new LS_smiley(); 
			$message = $smileyparser->parseSmileytext($message);
			
		}

		if ($row['status'] == "closed" && $row['hide'] == "no") {
			$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET status = "open", updated = "'.$row['updated'].'" WHERE id = "'.$_GET['id'].'"');
		}
		
		if ($message != "") {
		
		if ($row['hide'] == "no") {
		
			$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
			name = "'.smartsql($_GET['oname']).'",
			message = "'.smartsql($message).'",
			user = "'.smartsql($_GET['uid'].'::'.$_GET['uname']).'",
			convid = "'.$_GET['id'].'",
			time = NOW(),
			class = "admin"');
			
			$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET
			answered = "'.time().'",
			o_typing = 0
			WHERE id = "'.$_GET['id'].'"');
		}
		
		} else if ($row['hide'] == "yes") {
		
			$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
			name = "'.smartsql($_GET['oname']).'",
			message = "'.smartsql($tl['general']['g64']).'",
			convid = "'.$_GET['id'].'",
			class = "notice"');
			
			$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET
			answered = "'.time().'",
			o_typing = 0
			WHERE id = "'.$_GET['id'].'"');
			
		}
		
		echo "success";
	}
}
?>