<?php

/*======================================================================*\
|| #################################################################### ||
|| # Rhino Pro 1.1                                                    # ||
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

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] && !isset($_SESSION['guest_userid'])) {
	die("Nothing to see here");
}

if (is_numeric($_GET['conv'])) {

$result = $lsdb->query('UPDATE '.DB_PREFIX.'sessions SET u_typing = 1 WHERE convid = "'.smartsql($_GET['conv']).'"');

if ($result) {
	echo json_encode(array('tid' => 1));
}

} else {
	echo json_encode(array('tid' => 0));
}
?>