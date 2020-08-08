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

// Check if the user has access to this file
if (!LS_USERID_RHINO || !LS_ADMINACCESS) {
    ls_redirect(BASE_URL);
}

// The DB connections data
require_once '../class/class.export.php';

// All the tables we need for this plugin
$errors = array();
$lstable = DB_PREFIX.'leads';

switch ($page1) {
  	case 'export':
  	
  		$sql = 'SELECT name, email FROM '.$lstable.' WHERE email != "Not Set" GROUP BY email ORDER BY id DESC';
  		$result = $lsdb->query($sql);
  		if ($lsdb->affected_rows > 0) {
  		while ($row = $result->fetch_assoc()) {
  		        // collect each record into $_data
  		        $lsdata[] = $row;
  		    }
  		}
  		    
  		emailExport::createFile($lsdata);
  	    
  	break;
	default:
	
		$sql = 'SELECT id, name, email FROM '.$lstable.' WHERE email != "Not Set" GROUP BY email ORDER BY id DESC';
		$result = $lsdb->query($sql);
		if ($lsdb->affected_rows > 0) {
		while ($row = $result->fetch_assoc()) {
		        // collect each record into $_data
		        $lsdata[] = $row;
		    }
		}
		
		$CEMAILS_ALL = $lsdata;
		// Call the template
		$template = 'emails.php';
}
?>