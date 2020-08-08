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
if (!defined('LS_PREVENT_ACCESS')) {
die('You cannot access this file directly.');
}

ob_start();

// Start the session
session_start();

if (empty($_SESSION['guest_userid']) || empty($_SESSION['convid']) || LS_base::lsCheckSession($_SESSION['guest_userid'], $_SESSION['convid'])) {
	
	// Destroy Session
	session_destroy();
	
	ls_redirect(LS_rewrite::lsParseurl('start', '', '', '', ''));
}

if (LS_FEEDBACK) {

	$parseurl = LS_rewrite::lsParseurl('feedback', $_SESSION['convid'], '', '', '');

} else {

	$parseurl = LS_rewrite::lsParseurl('stop', $_SESSION['convid'], '', '', '');

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $tl["general"]["g"];?> - <?php echo LS_TITLE;?></title>
	<meta charset="utf-8">
	<meta name="author" content="Live Support Rhino" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/lsajax.js"></script>
	
	<!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 
	 <script type="text/javascript">
	 $(document).ready(function(){
	 		var intervalID = setInterval("getInput();", <?php echo LS_CLIENT_REFRESH;?>);
	 		getInput();
	 		setChecker('<?php echo $_SESSION['guest_userid'];?>');
	 		setInterval("setChecker('<?php echo $_SESSION['guest_userid'];?>');", 10000);
	 });
	 	
	 	ls.ls_submit = "<?php echo $tl['general']['g22'];?>";
	 </script>
	 
</head>
<body>

<!--- Container -->
		<div class="container">
			<h1 class="heading_solid"><img src="img/logo.png" alt="logo" /> <?php echo $tl["general"]["g"];?> - <?php echo LS_TITLE;?></h1>
			
			<div class="logout"><a href="<?php echo $parseurl;?>" class="red small_text"><?php echo $tl["general"]["g15"];?></a></div>
				
		<!--- Chat output -->
		<div id="chatOutput"></div>
		
		<div id="client_input_container">
		<!-- Client Input -->
			<form action="javascript:sendInput();" name="messageInput" id="MessageInput">
				<div id="msgError" class="status-failure"></div>
				<input type="text" name="message" id="message" class="input_field wide" />
				<input type="submit" class="input_field submit" id="chat_s_button" value="<?php echo $tl["general"]["g11"];?>" />
				
				<input type="hidden" name="userID" id="userID" value="<?php echo $_SESSION['guest_userid'];?>" />
				<input type="hidden" name="userName" id="userName" value="<?php echo $_SESSION['guest_name'];?>" />
				<input type="hidden" name="convID" id="convID" value="<?php echo $_SESSION['convid'];?>" />
				
			</form>	
		
		</div>
		
		<!-- Do not remove copyright, except you paid for it -->
		<div class="centered_container pale_blue copyright"><a href="https://www.livesupportrhino.com">Live Support powered by Rhino</a></div>
		
		<div id="typing"><img src="img/typing.png" width="16" height="16" alt="typing" /></div>
		
		</div>
</body>
</html>
<?php ob_flush(); ?>