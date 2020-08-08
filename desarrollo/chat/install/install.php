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

if (!file_exists('../include/db.php')) {
    die('[install.php] include/db.php not exist');
}
require_once '../include/db.php';

/* NO CHANGES FROM HERE */

// Get the ls DB class
if (LS_MYSQL_CONNECTION == 1) {
	require_once '../class/class.db.php';
} else {
	require_once '../class/class.dbn.php';
}

// Absolute Path
define('DIR_APPLICATION', str_replace('\'', '/', realpath(dirname(__FILE__))) . '/');
define('DIR_Rhino', str_replace('\'', '/', realpath(DIR_APPLICATION . '../')) . '/');

function smartsql($value)
{
	global $lsdb;
    if (!is_int($value)) {
        $value = $lsdb->real_escape_string($value);
    }
    return $value;
}

// Errors is array
$errors = array();
// Show form
$show_form = true;
// Check if db has content already
$check_db_content = false;

// MySQL/i connection
if (DB_USER && DB_PASS) {

	@$linkdb = mysql_connect(DB_HOST.':'.DB_PORT, DB_USER, DB_PASS, DB_NAME);
	@mysql_select_db(DB_NAME);

	@$result = mysql_query('SELECT title FROM '.DB_PREFIX.'departments WHERE id = 1 LIMIT 1');
	
	if ($result) {
	    $check_db_content = true;
	}
	
	// Finally close all db connections
	@mysql_close($linkdb);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Installation Rhino</title>
	<meta charset="utf-8">
	<meta name="author" content="Rhino (http://www.livesupportrhino.com)" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="../operator/css/screen.css" type="text/css" media="screen" />
</head>
<style type="text/css">
header {
	background-color: #222;
	height: 60px;
}
#container {
	background: #fff;
}
section {
	width:800px;margin:50px auto 0em;
}
header h1 {
	font-size: 28px;
	margin: 15px 20px;
	color: #fff;
	text-shadow: 0 1px 0 #000;
	font-weight: normal;
}
h2 {
	font-size: 14px;
}
</style>
<body>

<div id="container">
<header><h1>Welcome to the installation for Rhino</h1></header><!-- #header -->

<section>

<div id="installation">
<p><h2>Welcome to the installation for Rhino</h2>
<?php if (isset($_POST['install']) && $_GET['step'] == 2) {

// MySQL/i connection
if (DB_USER && DB_PASS) {
$lsdb = new ls_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$lsdb->set_charset("utf8");
}

$lsdb->query("CREATE TABLE ".DB_PREFIX."archive (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `user` varchar(100) NOT NULL,
  `convid` int(11) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `class` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$lsdb->query("CREATE TABLE ".DB_PREFIX."files (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(300) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$lsdb->query("CREATE TABLE ".DB_PREFIX."leads (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `transcript` int(11) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$lsdb->query("CREATE TABLE ".DB_PREFIX."loginlog (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `fromwhere` varchar(255) DEFAULT NULL,
  `ip` char(15) NOT NULL,
  `usragent` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$lsdb->query("CREATE TABLE ".DB_PREFIX."responses (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `message` varchar(3000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2");

$lsdb->query("INSERT INTO ".DB_PREFIX."responses VALUES(1, 'Assist Today', 'How can we assist you today?')");

$lsdb->query("CREATE TABLE ".DB_PREFIX."sessions (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(200) NOT NULL,
  `convid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `initiated` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `ended` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `answered` int(11) NOT NULL,
  `u_typing` smallint(1) unsigned NOT NULL DEFAULT '0',
  `o_typing` smallint(1) unsigned NOT NULL DEFAULT '0',
  `contact` varchar(3) NOT NULL DEFAULT 'no',
  `hide` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

$lsdb->query("CREATE TABLE ".DB_PREFIX."setting (
  `varname` varchar(100) NOT NULL DEFAULT '',
  `groupname` varchar(50) DEFAULT NULL,
  `value` mediumtext,
  `defaultvalue` mediumtext,
  `optioncode` mediumtext,
  `datatype` enum('free','number','boolean','bitfield','username','integer','posint') NOT NULL DEFAULT 'free',
  `product` varchar(25) DEFAULT '',
  PRIMARY KEY (`varname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

$lsdb->query("INSERT INTO ".DB_PREFIX."setting VALUES('version', 'version', '1.4', '1.4', NULL, 'free', 'rhino'), ('thankyou_message', 'setting', 'Thank you for your message. We will be in touch as soon as possible!', 'Thank you for your message.  We will be in touch as soon as possible!', 'textarea', 'free', 'rhino'), ('title', 'setting', 'Live Support - Rhino', 'Live Support - Rhino', 'input', 'free', 'rhino'), ('client_refresh', 'setting', '5000', '5000', 'input', 'number', 'rhino'), ('email', 'setting', '', 'ls_rhino', 'input', 'free', 'rhino'), ('sitehttps', 'setting', '0', '0', 'yesno', 'boolean', 'rhino'), ('dateformat', 'setting', 'd.m.Y', 'd.m.Y', 'input', 'free', 'rhino'), ('timeformat', 'setting', ' - H:i', 'h:i A', 'input', 'free', 'rhino'), ('leave_message', 'setting', 'None of our representatives are currently available. Please use the form below to send us an email.', 'None of our representatives are currently available.  Please use the form below to send us an email.', 'textarea', 'free', 'rhino'), ('welcome_message', 'setting', 'Welcome, a representative will be with you shortly', 'Welcome, a representative will be with you shortly', 'textarea', 'free', 'rhino'), ('feedback_message', 'setting', 'Please rate the conversation and let us know what we can improve.', 'Please rate the conversation and let us know what we can improve.', 'textarea', 'free', 'rhino'), ('thankyou_feedback', 'setting', 'Thank you for taking the time to give us your feedback.', 'Thank you for taking the time to give us your feedback.', 'textarea', 'free', 'rhino'), ('timezoneserver', 'setting', 'Europe/Zurich', 'Europe/Zurich', 'select', 'free', 'rhino'), ('lang', 'setting', 'en', 'en', 'input', 'free', 'rhino'), ('useravatwidth', 'setting', '150', '150', 'input', 'free', 'rhino'), ('useravatheight', 'setting', '113', '113', 'input', 'free', 'rhino'), ('login_message', 'setting', 'Please type your name to begin. Entering your email address is optional, although if you would like to be contacted in the future, please add your email address and tick the checkbox before starting your session.', 'Please type your name to begin. Entering your email address is optional, although if you would like to be contacted in the future, please add your email address and tick the checkbox before starting your session.', 'textarea', 'free', 'rhino'), ('offline_message', 'setting', 'None of our representatives are available right now, although you are welcome to leave a message!', 'None of our representatives are available right now, although you are welcome to leave a message!', 'textarea', 'free', 'rhino'), ('inactiv', 'setting', '600', '600', 'input', 'number', 'rhino'), ('end_flush', 'setting', '300', '300', 'input', 'number', 'rhino'), ('conv_refresh', 'setting', '5000', '5000', 'number', 'number', 'rhino'), ('admin_refresh', 'setting', '3000', '3000', 'input', 'number', 'rhino'), ('feedback', 'setting', '1', '1', 'yesno', 'boolean', 'rhino'), ('captcha', 'setting', '1', '1', 'yesno', 'boolean', 'rhino'), ('captchachat', 'setting', '1', '1', 'yesno', 'boolean', 'rhinopro'), ('smilies', 'setting', '1', '1', 'yesno', 'boolean', 'rhino'), ('updated', 'setting', '".time()."', '".time()."', 'time', 'number', 'rhino')");

$lsdb->query('CREATE TABLE '.DB_PREFIX.'transcript (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `user` varchar(100) NOT NULL,
  `convid` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `class` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$lsdb->query('CREATE TABLE '.DB_PREFIX.'user (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `available` smallint(1) unsigned NOT NULL DEFAULT 0,
  `username` varchar(100) DEFAULT NULL,
  `password` char(64) NOT NULL,
  `idhash` varchar(32) DEFAULT NULL,
  `session` varchar(32) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `picture` varchar(255) NOT NULL DEFAULT \'/standard.png\',
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT 0,
  `hits` int(11) unsigned NOT NULL DEFAULT 0,
  `access` smallint(1) unsigned NOT NULL DEFAULT 0,
  `forgot` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

$lsdb->query('CREATE TABLE '.DB_PREFIX.'user_stats (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `vote` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `comment` text,
  `support_time` int(10) unsigned NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

// Finally close all db connections
$lsdb->ls_close();

?>
<div class="status-ok">Database installed successfully.</div>
<form id="company" method="post" action="install.php?step=3" enctype="multipart/form-data">
<input style="float:right;" type="submit" value="Setup Administrator" name="user" />
</form>
<?php } elseif (isset($_POST['user']) && $_GET['step'] == 3) { ?>
Last Step - Create Admin<br /><br />
<?php

if (isset($_POST['user']) && isset($_POST['pass'])) {

if ($_POST['email'] == '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['e'] = 'Please insert a valid email address.<br />';
}

if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $_POST['username'])) {
	$errors['e1'] = 'Please insert a valid username (A-Z,a-z,0-9,-_).';
}

if (count($errors) == 0) {

// MySQL/i connection
if (DB_USER && DB_PASS) {
$lsdb = new ls_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$lsdb->set_charset("utf8");
}

// The new password encrypt with hash_hmac
$passcrypt = hash_hmac('sha256', $_POST['pass'], DB_PASS_HASH);
 
$lsdb->query('INSERT INTO '.DB_PREFIX.'user SET
	username = "'.smartsql($_POST['username']).'",
	password = "'.$passcrypt.'",
	email = "'.smartsql($_POST['email']).'",
	name = "'.smartsql($_POST['name']).'",
	time = NOW(),
	access = 1');

$lsdb->query('UPDATE '.DB_PREFIX.'setting SET value = "'.smartsql($_POST['email']).'" WHERE varname = "email"');

@$lsdb->query('ALTER DATABASE '.DB_NAME.' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci');
    
// Finally close all db connections
$lsdb->ls_close();

echo '<div class="status-ok">Installation successful, please delete or rename the <strong>install</strong> directory. You can now log in, in your <a href="../operator/">operator</a> panel.</div>';

$show_form = false;

} else {
   $errors = $errors;
} } 

if ($show_form) { 

if ($errors) {
 echo '<div class="status-failure">'.$errors["e"].$errors["e1"].'</div>';
} ?>

<div class="border">
<form name="user" method="post" action="install.php?step=3" enctype="multipart/form-data">
<table class="table">
<tr>
	<td>Name <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="name" placeholder="Name" /></td>
</tr>
<tr>
	<td>Username <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="username" placeholder="Username" /></td>
</tr>
<tr>
	<td>Password <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="pass" placeholder="Password" /></td>
</tr>
<tr>
	<td>Email <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="email" placeholder="Email" /></td>
</tr>
</table>
</div>
<input style="float:right;" type="submit" value="Finish" name="user" />
</form>
<?php } } if (!isset($_GET['step'])) { ?>
<br />
<p><strong>First the include/db.php.new file</strong></p>
<p>
	<ul>
	<li>Please rename this file to <strong>db.php</strong></li>
	<li>Open the file in a text editor.</li>
	<li>The db.php file is commented throughout, so you should be able to work out what values to enter for the variables yourself.</li>
	<li>When you have finished, save the file.</li>
</ul>
<br />
<strong>Upload</strong>
	<ul>
	<li>Upload all files and folders in the <strong>upload</strong> directory with your preferred FTP program.</li>
	<li>Folder permissions (<strong>CHMOD 777</strong>): <strong>cache</strong>/, <strong>files</strong>/</li>
</ul>
<br />
<strong>Install the database.</strong>
	<ul>
	<li>Point your browser at <strong>http://www.yourdomain.com/install/install.php</strong> (where www.yourdomain.com is the URL of your Site).</li>
</ul>
<br />
<strong>Configuration and finishing</strong>
	<ul>
	<li>Please delete or rename the <strong>install</strong> folder!</li>
	<li>Point your browser at: <strong>http://www.yourdomain.com/operator/</strong></li>
	<li>Sign in with your login information.</li>
	<li>Configure your website.</li>
</ul>
<br />
<strong>Help for FTP, MySQL and PHP</strong>
	<ul>
	<li>Go to our <a href="http://www.livesupportrhino.com">support</a> website.</li>
</ul>

</p>
<br />
<?php

// Test for the config.php File

if (@file_exists('../config.php')) {
	
	$data_file = '<strong style="color:green">config.php available</strong>';
} else {
	
	$data_file = '<strong style="color:red">config.php not available!</strong>';
}

// Connect to the database

@$linkdb = mysql_connect(DB_HOST.':'.DB_PORT, DB_USER, DB_PASS, DB_NAME);

if ($linkdb && DB_USER && DB_PASS) {
 
    $conn_data = '<strong style="color:green">Database connection available</strong>';
} else {
 
	$conn_data = '<strong style="color:red">Could not connect to the database!</strong>';
@mysql_close($linkdb);
}

// Database exist

@$dlink = mysql_select_db(DB_NAME);

if ($dlink) {
 
    $data_exist = '<strong style="color:green">Database available</strong>';
} else {
 
	$data_exist = '<strong style="color:red">Could not find the database!</strong>';
@mysql_close($dlink);
}

// Test the minimum PHP version
		$php_version = PHP_VERSION;

		if (version_compare($php_version, '5.2.0') < 0)
		{
			$result_php = '<strong style="color:red">You need a higher version of PHP (min. PHP 5.2)!</strong>';
		}
		else
		{
			$passed['php'] = true;

			// We also give feedback on whether we're running in safe mode
			$result_safe = '<strong style="color:green">PHP Version: '.phpversion().', Safe Mode deactivated, perfect.';
			if (@ini_get('safe_mode') || strtolower(@ini_get('safe_mode')) == 'on')
			{
				$result_safe .= ', Safe Mode activated, bad.';
			}
			$result_safe .= '</strong>';
		}
			
			
$dirc = DIR_Rhino."/files";
$writec = false;
// Now really check
			if (file_exists($dirc) && is_dir($dirc))
			{
				if (@is_writable($dirc))
				{
					$writec = true;
				}
				$existsc = true;
			}

			@$passedc['files'] = ($existsc && $passedc['files']) ? true : false;

			@$existsc = ($existsc) ? '<strong style="color:green">Found folder (cmsfiles)</strong>' : '<strong style="color:red">Folder not found! (cmsfiles)</strong>';
			@$writec = ($writec) ? '<strong style="color:green">permission set</strong>' : (($existsc) ? '<strong style="color:red">permission not set (check guide)!</strong>' : '');
			
// GD Graphics Support

if (!extension_loaded("gd")) {

	$gd_data = '<strong style="color:orange">GD-Libary not available</strong>';
} else {
	$gd_data = '<strong style="color:green">GD-Libary available</strong>';
}


?>
<br />

Before we start with the installation, the script will recheck the settings, everything green means ready to go!
<br /><br />
<table width="100%" class="table">
<tr>
	<td><strong>What we check</strong></td>
	<td><strong>Result</strong></td>
</tr>
<tr>
	<td>config.php:</td>
	<td><?=$data_file?></td>
</tr>
<tr>
	<td>Database connection</td>
	<td><?=$conn_data?></td>
</tr>
<tr>
	<td>Database</td>
	<td><?=$data_exist?></td>
</tr>
<tr>
	<td>PHP Version and Safe Mode:</td>
	<td><?=@$result_php?> <?=$result_safe?></td>
</tr>
<tr>
	<td valign="top">Folders:</td>
	<td><?=$writec?></td>
</tr>
<tr>
	<td>GD Library Support:</td>
	<td><?=$gd_data?></td>
</tr>
</table>

<?php if (file_exists('../config.php') AND ($linkdb) AND ($dlink) && !$check_db_content) { ?>
<form name="company" method="post" action="install.php?step=2">
<input style="float:right;" type="submit" value="Install Database" name="install" />
</form>
<?php } elseif ((file_exists('../config.php') AND ($linkdb) AND ($dlink) && $check_db_content)) { ?>
<form name="company" method="post" action="install.php?step=3">
<input style="float:right;" type="submit" value="(Database exist already) Create User" name="userf" />
</form>
<?php } else { ?>
<input type="button" value="Refresh page" onclick="history.go(0)" />
<?php } } ?>
</p>

<br /><br />

</div>

</section>

<footer>Copyright 2012 by <a href="https://www.livesupportrhino.com">Live Support - Rhino</a></footer>

</div><!-- #container -->
</body>
</html>