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
    die('ajax/[available.php] config.php not exist');
}
require_once '../../config.php';

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] && !isset($_SESSION['idhash'])) {
	die("Nothing to see here");
}

if (file_exists(APP_PATH.'operator/lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'operator/lang/'.LS_LANG.'.ini', true);
} else {
    trigger_error('Translation file not found');
}

if (is_numeric($_GET['id'])) {

$result = $lsdb->query('SELECT name, contact, email, convid, initiated FROM '.DB_PREFIX.'sessions WHERE convID = "'.smartsql($_GET['id']).'"');

if ($lsdb->affected_rows > 0) {

	$row = $result->fetch_assoc();

	$ts = $row['initiated'];
	$ts = strftime("%X %P",$ts);
?>
<table>
<tr>
<th><h4><img src="img/user.png" alt="Name" /> <?php echo $tl['user']['u'];?></h4></th>
<th><h4><img src="img/contact.png" alt="to be contacted?" /> <?php echo $tl['general']['g60'];?></h4></th>
<th><h4><img src="img/email.png" alt="Email address" /> <?php echo $tl['user']['u1'];?></h4></th>
<th><h4><img src="img/not_available_s.png" alt="Terminate Conversation" /> <?php echo $tl['general']['g61'];?></h4></th>
</tr><tr>
<td><?php echo $row['name'];?></td>
<td><?php echo $row['contact'];?></td>
<td><?php echo $row['email'];?></td>
<td><a href="#" onclick='parent.$.fn.colorbox({href:"ajax/delconv.php?id=<?php echo $row['convid'];?>",opacity:0.9}); return false;' class="delete_convo"><?php echo $tl['general']['g62'];?></a></td>
</tr>
</table>

<?php

} } else {
	echo $tl['general']['g79'];
}
?>