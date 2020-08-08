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

$succesfully = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Update Rhino Light 1.4</title>
	<meta charset="utf-8">
	<meta name="author" content="Rhino (http://www.livesupportrhino.com)" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="../operator/css/screen.css" type="text/css" media="screen" />
</head>
<style type="text/css">
#container {background-color:#fff;}
header {
	background-color: #222;
	height: 60px;
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
li {
	list-style: square;
	margin-left: 25px;
	font-size: 16px;
}
</style>
<body>

<div id="container">
<header><h1>Update Rhino Light 1.4</h1></header><!-- #header -->

<section>

<div id="installation">
<h2>Update Rhino Light 1.4</h2>
<?php 

// MySQL/i connection
if (DB_USER && DB_PASS) {
$lsdb = new ls_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$lsdb->set_charset("utf8");
}

$result = $lsdb->query('SELECT value FROM '.DB_PREFIX.'setting WHERE varname = "version"');
$row = $result->fetch_assoc();
if ($row["value"] == "1.4") { $succesfully = 1; ?>

<div class="status-ok">Your Rhino Light is already up to date!</div>

<!-- Plugin is not installed let's display the installation script -->
<?php } else { if (isset($_POST['update_1_4'])) { 

if ($row['value'] == "1.1.8") {

$lsdb->query("INSERT INTO ".DB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ('captcha', 'setting', '1', '1', 'yesno', 'boolean', 'rhino'), ('updated', 'setting', '".time()."', '".time()."', 'time', 'number', 'rhino')");

$lsdb->query("ALTER TABLE ".DB_PREFIX."sessions ADD `u_typing` SMALLINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `answered`, ADD `o_typing` SMALLINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `u_typing`");

}

if ($row['value'] == "1.1.8" || $row['value'] == "1.2") {

$lsdb->query("INSERT INTO ".DB_PREFIX."setting (`varname`, `groupname`, `value`, `defaultvalue`, `optioncode`, `datatype`, `product`) VALUES ('smilies', 'setting', '1', '1', 'yesno', 'boolean', 'rhino'), ('captchachat', 'setting', '1', '1', 'yesno', 'boolean', 'rhino')");

$lsdb->query('DELETE FROM '.DB_PREFIX.'setting WHERE `varname` = "filepath"');

$lsdb->query('UPDATE '.DB_PREFIX.'setting SET value = "'.time().'" WHERE varname = "updatetime"');

}
 
$lsdb->query('UPDATE '.DB_PREFIX.'setting SET value = "1.4" WHERE varname = "version"');

// Now let us delete the define cache file
$cachedefinefile = '../'.LS_CACHE_DIRECTORY.'/define.php';
if (file_exists($cachedefinefile)) {
	unlink($cachedefinefile);
}

$succesfully = 1;

?>
<div class="status-ok">Update successful, please delete or rename the <strong>install</strong> directory and then go to your <a href="../operator/">operator</a> panel.</div>
<?php } } if (!$succesfully) { ?>
<p><br /><br />Do you have a <strong>backup</strong> from your files and database?<br />
Have you replaced all files?<br /><br />
Yes? Then we are ready to run the update!

<?php if (file_exists('../config.php')) { ?>
<form name="company" method="post" action="update.php" enctype="multipart/form-data">
<input style="float:right;" type="submit" value="Update to 1.4" name="update_1_4" />
</form>
<?php } } ?>
</p>

<br /><br />

</div>

</section>

<footer>Copyright 2012 by <a href="https://www.livesupportrhino.com">Live Support - Rhino</a></footer>

</div><!-- #container -->
</body>
</html>