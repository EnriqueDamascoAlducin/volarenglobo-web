<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php if ($page) { ?><?php echo ucwords($page);?> - <?php } echo LS_TITLE;?></title>
	<meta charset="utf-8">
	<meta name="description" content="Live Support Rhino" />
	<meta name="keywords" content="Your premium Live Support from Rhino" />
	<meta name="author" content="Live Support Rhino" />
	<?php if ($page == 'success' or $page == 'logout' or $page == '404' or $page == 'error') { ?>
	<meta http-equiv="refresh" content="1;URL=<?php if ($page == '404') { echo BASE_URL_ADMIN; } else { echo $_SERVER['HTTP_REFERER']; } ?>" />
	<?php } ?>
	<link rel="shortcut icon" href="<?php echo BASE_URL_ORIG;?>favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />	
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" src="../js/colorbox-min.js"></script>
	
	<!--[if lt IE 10]>
		<script type="text/javascript" src="../js/ie.js"></script>
	<![endif]-->
	
	<!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 
</head>
<body>
<div id="container">

<?php if ($LS_PROVED) { echo '<div class="content">';?>

<header>
	<h1><a href="<?php echo BASE_URL_ADMIN;?>"><img src="img/logo.png" width="128" height="128" alt="logo" class="img" /></a><?php echo LS_TITLE;?></h1>
	<div class="logout"><?php echo $LS_WELCOME_NAME;?>&nbsp;|&nbsp;<a href="index.php?p=logout" title="<?php echo $tl["logout"]["l"];?>" onclick="if(!confirm('<?php echo $tl["logout"]["l2"];?>'))return false;"><?php echo $tl["logout"]["l"];?></a></div>
<nav>
<?php include_once APP_PATH.'operator/template/navbar.php';?>
</nav>

</header><!-- #header -->

<?php } ?>

<div class="clear"></div>