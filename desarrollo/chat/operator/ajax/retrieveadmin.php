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

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] && !isset($_SESSION['idhash'])) {
	die("Nothing to see here");
}

if (file_exists(APP_PATH.'operator/lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'operator/lang/'.LS_LANG.'.ini', true);
} else {
    trigger_error('Translation file not found');
}

// Get the special lang var once for the time
define('LS_DAY', $tl['general']['g74']);
define('LS_HOUR', $tl['general']['g75']);
define('LS_MINUTE', $tl['general']['g76']);
define('LS_MULTITIME', $tl['general']['g77']);
define('LS_AGO', $tl['general']['g78']);

if (is_numeric($_GET['id'])) {

$result = $lsdb->query('SELECT * FROM '.DB_PREFIX.'transcript WHERE convid = "'.smartsql($_GET['id']).'"');

if ($lsdb->affected_rows > 0) {

	echo '<ul class="chat_display">';

	while ($row = $result->fetch_assoc()) {

		if ($row['class'] == "notice") {
		
			echo '<li class="'.$row['class'].'"><span class="user_said">'.$row['name'].' '.$tl['general']['g66'].' :</span><br />'. stripcslashes($row['message']).'</li>';  	
		
		} else {
		
			echo '<li class="'.$row['class'].'"><span class="user_said">'.LS_base::lsTimesince($row['time'], JAK_DATEFORMAT, JAK_TIMEFORMAT).' - '.$row['name'].' '.$tl['general']['g66'].' :</span><br />'.stripcslashes($row['message']).'</li>';  	
		}		
	}
	
	echo "</ul>";
}
} else {
	
	echo false;

}
?>