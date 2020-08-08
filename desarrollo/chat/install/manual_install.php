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
    die('[manual_install.php] db.php not exist');
}
require_once '../include/db.php';

/* NO CHANGES FROM HERE */

// Get the ls DB class
if (LS_MYSQL_CONNECTION == 1) {
	require_once '../class/class.db.php';
} else {
	require_once '../class/class.dbn.php';
}

function smartsql($value)
{
	global $lsdb;
    if (!is_int($value)) {
        $value = $lsdb->real_escape_string($value);
    }
    return $value;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Manual Installation - Rhino</title>
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
h1 {
	font-size: 20px;
	margin: 15px 20px;
}
h2 {
	font-size: 14px;
}
</style>
<body>

<div id="container">

<header><h1>Welcome to the manual installation for Rhino</h1></header><!-- #header -->

<section>

<div id="installation">
<p><h2>Manual Installation - Rhino</h2>
<?php if (isset($_POST['minstall'])) {

// MySQL/i connection
if (DB_USER && DB_PASS) {
$lsdb = new ls_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$lsdb->set_charset("utf8");
}

if (DB_PREFIX != '') {
$lsdb->query('RENAME TABLE archive TO '.DB_PREFIX.'archive, files TO '.DB_PREFIX.'files, leads TO '.DB_PREFIX.'leads, loginlog TO '.DB_PREFIX.'loginlog, responses TO '.DB_PREFIX.'responses, setting TO '.DB_PREFIX.'setting, transcript TO '.DB_PREFIX.'transcript, user TO '.DB_PREFIX.'user, user_stats TO '.DB_PREFIX.'user_stats, sessions TO '.DB_PREFIX.'sessions');
}
	
// The new password encrypt with hash_hmac
$passcrypt = hash_hmac('sha256', $_POST['pass'], DB_PASS_HASH);
 
$lsdb->query('INSERT INTO '.DB_PREFIX.'user SET
	username = "'.smartsql($_POST['username']).'",
	usergroupid = 3,
	password = "'.$passcrypt.'",
	email = "'.smartsql($_POST['email']).'",
	name = "'.smartsql($_POST['name']).'",
	time = NOW(),
	access = 1');
	
@$lsdb->query('ALTER DATABASE '.DB_NAME.' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci');
	
// Finally close all db connections
$lsdb->ls_close();
    
?>

<div class="status-ok">Installation successful, please delete or rename the <strong>install</strong> directory. You can now log in, in your <a href="../operator/">administration</a> panel.</div>

<?php
    
} else {

if (file_exists('../config.php')) {

?>

<h2>Have you created and insert the database with phpMyAdmin (database/mysql_manual_insert.sql)?</h2>
Have you uploaded all files?<br /><br />
Yes? Then we are ready to install the Gecko manually!

<div class="border">
<form name="user" method="post" action="manual_install.php" enctype="multipart/form-data">
<table class="table">
<tr>
	<td>Name <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="name" title="Name" /></td>
</tr>
<tr>
	<td>Username <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="username" title="Username" /></td>
</tr>
<tr>
	<td>Password <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="pass" title="Password" /></td>
</tr>
<tr>
	<td>Email <span class="complete">*</span></td>
	<td><input type="text" value="" size="30" maxlength="30" name="email" title="Email" /></td>
</tr>
</table>
</div>
<input style="float:right;" type="submit" value="Send" name="minstall" />
</form>

<?php } else { ?>
<input type="button" value="Refresh page" onclick="history.go(0)" />
<?php } } ?>

</div>

<br /><br />

</section>

<footer>Copyright 2012 by <a href="https://www.livesupportrhino.com">Live Support - Rhino</a></footer>

</div><!-- #container -->
</body>
</html>