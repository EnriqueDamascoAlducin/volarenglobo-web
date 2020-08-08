<?php include_once APP_PATH.'operator/template/header.php';?>

<section>

<div class="content-border">
<?php if ($errors) { ?>
<div class="status-failure"><?php echo $errors["e"].$errors["e1"];?></div>
<?php } ?>
<form class="ls_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g47"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g16"];?></h3></td>
	<td><input type="text" name="title" class="inputbig<?php if ($errors["e1"]) { ?> error<?php } ?>" value="<?php echo $LS_FORM_DATA["title"];?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g49"];?></h3></td>
	<td><textarea name="response" cols="60" rows="5" class="input_field"><?php echo $LS_FORM_DATA["message"];?></textarea></td>
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