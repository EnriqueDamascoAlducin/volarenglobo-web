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

class LS_user
{
	private $data;
	private $lsvar = 0;
	private $useridarray;
	private $username = '';
	private $userid = '';
	
	public function __construct($row)
	{
		/*
		/	The constructor
		*/
		
		$this->data = $row;
	}
	
	function lsAdminaccess($lsvar)
	{
		$useridarray = explode(',', LS_ADMIN);
		// check if userid exist in db.php
		if (in_array($lsvar, $useridarray)) {
			return true;
		} else {
			return false;
		}
	
	}
	
	function lsSuperadminaccess($lsvar)
	{
		$useridarray = explode(',', LS_SUPERADMIN);
		// check if userid exist in db.php
		if (in_array($lsvar, $useridarray)) {
			return true;
		} else {
			return false;
		}
	
	}
	
	function lsModuleaccess($userid, $accessids)
	{
		$useridarray = explode(',', $accessids);
		// check if user is superadmin
		if (LS_SUPERADMINACCESS) {
			return true;
		} else if (in_array($userid, $useridarray)) {
			return true;
		} else {
			return false;
		}
	
	}
	
	function getVar($lsvar)
	{
		
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		return $d[$lsvar];
		
	}
}
?>