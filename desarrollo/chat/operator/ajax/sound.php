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

if (!is_numeric($_GET['id'])) die("There is no such user!");

$result = $lsdb->query('SELECT answered, updated FROM '.DB_PREFIX.'sessions WHERE status = "open"');

if ($lsdb->affected_rows > 0) {

	while ($row = $result->fetch_assoc()) {
			
			$newConv = 0;
		
			// check for new conversations
			if($row['answered'] == 0) {
				$newConv = 1;
			}
			if($row['updated'] > $row['answered']) {
				$newConv = 2;
			}		
	}
	
	echo $newConv;
} else {

	echo false;
}
?>