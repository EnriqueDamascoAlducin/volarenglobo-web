<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="content-login">

<div class="loginF">

<h3><?php echo $tl['general']['g94'];?></h3>

<?php if ($errorsf) { ?>
<div class="status-failure"><?php echo $errorsf["e"].$errorsf["e1"];?></div>
<?php } ?>

	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<label for="email"><?php echo $tl["login"]["l5"];?></label>
	<input type="text" name="f_email" class="inputbig<?php if ($errorsf["e"]) { ?> error<?php } ?>" value="" />
	<label for="password"><?php echo $tl["login"]["l2"];?></label>
	<input type="password" name="f_pass" class="inputbig<?php if ($errorsf["e1"]) { ?> error<?php } ?>" value="" />
	<label for="password"><?php echo $tl["login"]["l9"];?></label>
	<input type="password" name="f_newpass" class="inputbig<?php if ($errorsf["e1"]) { ?> error<?php } ?>" value="" />
	<button type="submit" name="newP" class="button block"><?php echo $tl["login"]["l8"];?></button>
	</form>

</div>

<span class="logo">&nbsp;</span>

</div>

<?php include_once APP_PATH.'operator/template/footer.php';?>