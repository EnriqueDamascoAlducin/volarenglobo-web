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

// Start the session
session_start();

if (!file_exists('../../config.php')) {
    die('ajax/[response.php] config.php not exist');
}
require_once '../../config.php';

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] && !isset($_SESSION['idhash'])) {
	die("Nothing to see here");
}

if (!is_numeric($_GET['id'])) die("There is no such message!");

$result = $lsdb->query('SELECT name, path FROM '.DB_PREFIX.'files WHERE id = "'.smartsql($_GET['id']).'"');

if ($lsdb->affected_rows > 0) {

	$row = $result->fetch_assoc();
	
	$message = '<a href="'.str_replace('operator/ajax/', '', BASE_URL).$row['path'].'" target="blank">'.$row['name'].'</a>';
	
	$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
	name = "'.smartsql($_GET['oname']).'",
	message = "'.smartsql($message).'",
	user = "'.smartsql($_GET['uid'].'::'.$_GET['uname']).'",
	convid = "'.$_GET['conv'].'",
	time = NOW(),
	class = "download"');

}
?>