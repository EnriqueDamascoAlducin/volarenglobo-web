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
    die('ajax/[retrieve.php] config.php not exist');
}
require_once '../config.php';

// Import the language file
if (file_exists(APP_PATH.'lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'lang/'.LS_LANG.'.ini', true);
} else {
    $tl = parse_ini_file(APP_PATH.'lang/en.ini', true);
}

// Get the special lang var once for the time
define('LS_DAY', $tl['general']['g17']);
define('LS_HOUR', $tl['general']['g18']);
define('LS_MINUTE', $tl['general']['g19']);
define('LS_MULTITIME', $tl['general']['g20']);
define('LS_AGO', $tl['general']['g21']);

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] || !isset($_SESSION['guest_userid'])) {
	die("Nothing to see here");
}

if (is_numeric($_GET['id']) && ($_SESSION['guest_userid'] == $_GET['userid'])) {

$result = $lsdb->query('SELECT * FROM '.DB_PREFIX.'transcript WHERE convid = "'.smartsql($_GET['id']).'"');

if ($lsdb->affected_rows > 0) {

echo '<ul>';

	while ($row = $result->fetch_assoc()) {

		echo '<li class="'.$row['class'].'"><span class="response_sum">'.LS_base::lsTimesince($row['time'], LS_DATEFORMAT, LS_TIMEFORMAT).' '.$row['name'].' '.$tl['general']['g14'].' :</span><br />'.stripcslashes($row['message']).'</li>';	
	}
	
	echo "</ul>";
}
}
?>