<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="ustatus">
<div class="bar_available<?php if ($lsuser->getVar("available") == 0) { echo ' not_available'; } ?>" id="available_user"><?php echo $tl["general"]["g"];?></div>
<div class="bar_alert" id="sound_alert"><?php echo $tl["general"]["g2"];?></div>
</div>

<div class="clear"></div>

<section>
	
		<div class="grid-m">
			<div class="heading_solid">
			<h3><?php echo $tl["general"]["g46"];?></h3>
			</div>
			
			<table class="table">
			<tr class="content-title">
			<td class="content-go">#</td>
			<td><?php echo $tl["general"]["g16"];?></td>
			<td><?php echo $tl["general"]["g49"];?></td>
			<td><?php echo $tl["general"]["g47"];?></td>
			<td><?php echo $tl["general"]["g48"];?></td>
			
			</tr>
			<?php if (isset($RESPONSES_ALL) && is_array($RESPONSES_ALL)) foreach($RESPONSES_ALL as $v) { ?>
			<tr>
			<td class="content-go"><?php echo $v["id"];?></td>
			<td><?php echo $v["title"];?></td>
			<td><?php echo $v["message"];?></td>
			<td class="content-go"><a href="index.php?p=response&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>" class="edit_user"><img src="img/edit.png" width="14" height="16" alt="edit" /></a></td>
			<td class="content-go"><a href="index.php?p=response&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>"><img src="img/delete.png" width="14" height="16" alt="delete" onclick="if(!confirm('<?php echo $tl["error"]["e31"];?>'))return false;" /></a></td>
			</tr>
			<?php } ?>
			</table>
			
		</div>
	
		<div class="grid-s">
		
				<div class="heading_solid">
				<h3><?php echo $tl["general"]["g45"];?></h3>
				</div>
				
				<?php if ($errors) { ?>
				<div class="status-failure"><?php echo $errors["e"].$errors["e1"];?></div>
				<?php } ?>
				
				<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
					<label for="title"><?php echo $tl["general"]["g16"];?></label>
					<input type="text" name="title" class="inputbig">
					<label for="response"><?php echo $tl["general"]["g49"];?></label>
					<textarea name="response" class="input_field inputbig" cols="30" rows="5"></textarea>
					
					<div class="ustatus">
						<input type="submit" name="insert_response" value="<?php echo $tl["general"]["g38"];?>" class="input_field submit">
					</div>
					
					<div class="clear"></div>

				</form>
		</div>
			
</section>

<div class="clear"></div>

<div id="msg_box">
<p></p>
</div>

<script type="text/javascript" src="js/page.ajax.js"></script>

<script type="text/javascript">
$(document).ready(function(){
		setChecker(<?php echo $lsuser->getVar("id");?>);
		        setInterval("setChecker(<?php echo $lsuser->getVar("id");?>);", 10000);
		setTimer(<?php echo $lsuser->getVar("id");?>);
		        setInterval("setTimer(<?php echo $lsuser->getVar("id");?>);", 120000);
});

		ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
		ls.main_lang = "<?php echo LS_LANG;?>";
		ls.ls_submit = "<?php echo $tl['general']['g69'];?>";
		ls.ls_submitwait = "<?php echo $tl['general']['g70'];?>";
</script>

<?php include_once APP_PATH.'operator/template/footer.php';?>