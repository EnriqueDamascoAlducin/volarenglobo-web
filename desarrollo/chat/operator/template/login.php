<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="content-login">

<div class="loginF">
<form id="login_form" class="ls_form" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
<input<?php if ($ErrLogin) echo ' class="error"';?> type="text" name="username" id="username" value="" placeholder="<?php echo $tl["login"]["l1"];?>" />
<input<?php if ($ErrLogin) echo ' class="error"';?> type="password" name="password" id="password" value="" placeholder="<?php echo $tl["login"]["l2"];?>" />
<label><?php echo $tl["login"]["l4"];?></label>
<?php echo $tl["general"]["g19"];?> <input type="radio" name="lcookies" value="1" /> <?php echo $tl["general"]["g18"];?> <input type="radio" name="lcookies" value="0" checked="checked" />

<p><button type="submit" name="logID" class="button"><?php echo $tl["login"]["l3"];?></button></p>
<input type="hidden" name="action" value="login" />
</form>

<?php if ($ErrLogin) { ?>
<a class="lost-pwd" href="#"><?php echo $tl["error"]["f"];?></a>
<?php } ?>

</div>

<div class="forgotP">
<h3><?php echo $tl["login"]["l6"];?></h3>
<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
	<input type="text" name="lsE" id="email" class="inputbig<?php if ($errorfp) { ?> error<?php } ?>" value="" placeholder="<?php echo $tl["login"]["l5"];?>" />
<p><button type="submit" name="forgotP" class="button block"><?php echo $tl["general"]["g4"];?></button></p>
</form>
<?php if ($errorfp) { ?><div class="status-failure"><?php echo $errorfp["e"];?></div><?php } ?>
<a class="lost-pwd" href="#"><?php echo $tl["general"]["g3"];?></a>
</div>

<span class="logo">&nbsp;</span>

<?php if (isset($_SESSION['password_recover'])) {

	echo '<div class="status-ok">'.$tl['login']['l7'].'</div>';

} ?>

</div>

<script type="text/javascript">

$(document).ready(function() {
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$(".lost-pwd").click(function(e) {
		e.preventDefault();
		$(".loginF").slideToggle();
		$(".forgotP").slideToggle();
	});
	
	<?php if ($errorfp) { ?>
		$(".loginF").hide();
		$(".forgotP").show();
	<?php } ?>
		
});

</script>

<?php include_once APP_PATH.'operator/template/footer.php';?>