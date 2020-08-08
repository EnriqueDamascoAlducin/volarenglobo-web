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

// prevent direct php access
define('LS_ADMIN_PREVENT_ACCESS', 1);

if (!file_exists('config.php')) {
    die('[index.php] config.php not found');
}
require_once 'config.php';

$page = ($temppa ? filter_var($temppa, FILTER_SANITIZE_STRING) : '');
$page1 = ($temppa1 ? filter_var($temppa1, FILTER_SANITIZE_STRING) : '');
$page2 = ($temppa2 ? filter_var($temppa2, FILTER_SANITIZE_STRING) : '');
$page3 = ($temppa3 ? filter_var($temppa3, FILTER_SANITIZE_STRING) : '');
$page4 = ($temppa4 ? filter_var($temppa4, FILTER_SANITIZE_STRING) : '');
$page5 = ($temppa5 ? filter_var($temppa5, FILTER_SANITIZE_STRING) : '');
$page6 = ($temppa5 ? filter_var($temppa6, FILTER_SANITIZE_STRING) : '');

$LS_SPECIALACCESS = false;
$LS_UNDELETABLE = false;

// Only the SuperAdmin in the config file see everything
if ($lsuser->lsSuperadminaccess(LS_USERID_RHINO)) {
	$LS_SPECIALACCESS = true;
	$LS_UNDELETABLE = true;
	define('LS_SUPERADMINACCESS', true);
} else {
	define('LS_SUPERADMINACCESS', false);
}

// Only the Admin's in the config can have access
if ($lsuser->lsAdminaccess(LS_USERID_RHINO)) {
	define('LS_ADMINACCESS', true);
} else {
	define('LS_ADMINACCESS', false);
}

// All other user will be redirect to the homepage, nothing else to do for this people
if (LS_USERID_RHINO && !LS_ADMINACCESS) {
		ls_redirect(BASE_URL_ORIG);
}

if (file_exists(APP_PATH.'operator/lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'operator/lang/'.LS_LANG.'.ini', true);
} else {
    trigger_error('Translation file not found');
}

// Define for template the real request
$realrequest = substr($getURL->lsRealrequest(), 1);
define('LS_PARSE_REQUEST', $realrequest);

// We need the template folder, title, author and lang as template variable
$LS_CMSLANG = LS_LANG;
$LS_CONTACT_FORM = LS_CONTACTFORM;
$LS_REGISTER_FORM = LS_REGISTER;
define('LS_PAGINATE_ADMIN', 1);

// First check if the user is logged in
if (LS_USERID_RHINO) {

// Get the name from the user for the welcome message
$LS_WELCOME_NAME = $lsuser->getVar("name");
}

// Now get the forgot password link into the right shape
$P_FORGOT_PASS_ADMIN = LS_rewrite::lsParseurl($tl['login']['l12'], '', '', '', '');

// Delete the conversation if whish so
if (isset($_POST['delete_conv'])) {

	// check to see if conversation is to be stored
	$result = $lsdb->query('SELECT convid, name, email, contact FROM '.DB_PREFIX.'sessions WHERE convid = "'.$_POST['id'].'"');
	$row = $result->fetch_assoc();
	
	// Archive the Conversation
	archive_conversation($row['convid'], $row['name'], $row['email']);

	$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET status = "closed", ended = "'.time().'", hide = "yes"  WHERE convid = "'.$row['convid'].'"');
	
	$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
	name = "'.$lsuser->getVar("name").'",
	message = "'.smartsql($tl['general']['g63']).'",
	user = "'.$lsuser->getVar("username").'",
	convid = "'.$row['convid'].'",
	time = NOW(),
	class = "notice"');
}

$checkp = 0;

if (!isset($_SERVER['HTTP_REFERER'])) {
    $_SERVER['HTTP_REFERER'] = '';
}

// home
    if ($page == '') {
        #show login page only if the admin is not logged in
        #else show homepage
        if (!LS_USERID_RHINO) {
            require_once 'login.php';
        } else {
        	$LS_PROVED = 1;
        	$LS_PAGE_ACTIVE = 1;
            $html_title = $tl['menu']['m'];
            
            $template = 'index.php';
        }
        $checkp = 1;
       	}
   if ($page == 'logout') {
        $checkp = 1;
        if (LS_USERID_RHINO) {
            $lsuserlogin->lsLogout(LS_USERID_RHINO);
            $LS_PROVED = 1;
            $html_title = $tl['logout']['l'];
            $template = 'success.php';
        }
    }
    if ($page == 'forgot') {
    	if (LS_USERID_RHINO) {
    	    ls_redirect(BASE_URL);
    	}
        require_once 'forgot.php';
        $html_title = $tl['general']['g94'];
        $LS_PROVED = 0;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'success') {
        if (!LS_USERID_RHINO) {
            ls_redirect(BASE_URL);
        }
        $template = 'success.php';
        $LS_PROVED = 1;
        $checkp = 1;
    }
    if ($page == 'error') {
        if (!LS_USERID_RHINO) {
            ls_redirect(BASE_URL);
        }
        $template = 'error.php';
        $LS_PROVED = 1;
        $checkp = 1;
    }
    if ($page == '404') {
        if (!LS_USERID_RHINO) {
            ls_redirect(BASE_URL);
        }
        // Go to the 404 Page
        $LS_PROVED = 1;
        $html_title = '404 / ' . LS_TITLE;
        $template = '404.php';
        $checkp = 1;
    }
    if ($page == 'logs') {
        require_once 'logs.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'files') {
        require_once 'files.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'response') {
        require_once 'response.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'leads') {
        require_once 'leads.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'emails') {
        require_once 'emails.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'settings') {
        require_once 'setting.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
    if ($page == 'users') {
        require_once 'user.php';
        $LS_PROVED = 1;
        $LS_PAGE_ACTIVE = 1;
        $checkp = 1;
    }
     
// if page not found

if ($checkp == 0) {
    ls_redirect(BASE_URL.'index.php?p=404');
}

if (isset($template) && $template != '') {
	include_once APP_PATH.'operator/template/'.$template;
}

// Get the plugin template
if (isset($plugin_template) && $plugin_template != '') {
	
	include_once APP_PATH.$plugin_template;
}
    
// Finally close all db connections
$lsdb->ls_close();
?>