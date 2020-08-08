<?php include_once APP_PATH.'operator/template/header.php';?>

<section>

<div class="content-border">
<?php if ($errors) { ?>
<div class="status-failure"><?php echo $errors["e"].$errors["e1"].$errors["e2"].$errors["e3"].$errors["e4"].$errors["e5"].$errors["e6"];?></div>
<?php } ?>
<form class="ls_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g40"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["user"]["u"];?></h3></td>
	<td><input type="text" name="ls_name" class="inputbig<?php if ($errors["e1"]) { ?> error<?php } ?>" value="<?php echo $_REQUEST["ls_name"]; ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["user"]["u1"];?></h3></td>
	<td><input type="text" name="ls_email" class="inputbig<?php if ($errors["e2"]) { ?> error<?php } ?>" value="<?php echo $_REQUEST["ls_email"]; ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["user"]["u2"];?></h3></td>
	<td><input<?php if ($errors["e3"] || $errors["e4"]) { ?> class="error"<?php } ?> type="text" name="ls_username" value="<?php echo $_REQUEST["ls_username"]; ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["user"]["u3"];?></h3></td>
	<td><input type="radio" name="ls_access" value="1" checked="checked" /> <?php echo $tl["general"]["g19"];?> <input type="radio" name="ls_access" value="0" /> <?php echo $tl["general"]["g18"];?></td>
</tr>
</table>

<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g39"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["user"]["u4"];?></h3></td>
	<td><input<?php if ($errors["e5"] || $errors["e6"]) { ?> class="error"<?php } ?> type="text" name="ls_password" value="" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["user"]["u5"];?></h3></td>
	<td><input<?php if ($errors["e5"] || $errors["e6"]) { ?> class="error"<?php } ?> type="text" name="ls_confirm_password" value="" /></td>
</tr>
</table>

<div class="ustatus">
<button type="submit" name="save" class="button"><?php echo $tl["general"]["g38"];?></button>
</div>

<div class="clear"></div>

</form>
</div>		
</section>
		
<?php include_once APP_PATH.'operator/template/footer.php';?>