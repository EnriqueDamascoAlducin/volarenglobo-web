<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="ustatus">
<div class="bar_available<?php if ($lsuser->getVar("available") == 0) { echo ' not_available'; } ?>" id="available_user"><?php echo $tl["general"]["g"];?></div>
<div class="bar_alert" id="sound_alert"><?php echo $tl["general"]["g2"];?></div>
</div>

<div class="clear"></div>

<section>

<p><?php echo $tl["general"]["g84"];?></p>

<div class="content-border">

<table class="table">
<tr class="content-title">
<td class="content-go">#</td>
<td><?php echo $tl["general"]["g54"];?></td>
<td><?php echo $tl["login"]["l5"];?></td>
</tr>
<?php if (isset($CEMAILS_ALL) && is_array($CEMAILS_ALL)) foreach($CEMAILS_ALL as $v) { ?>
<tr>
<td class="content-go"><?php echo $v["id"];?></td>
<td><?php echo $v["name"];?></td>
<td><?php echo $v["email"];?></td>
</tr>
<?php } ?>
</table>

<?php if (isset($CEMAILS_ALL) && is_array($CEMAILS_ALL)) { ?>

<div class="ustatus">
<a href="index.php?p=emails&amp;sp=export" class="button"><?php echo $tl["general"]["g83"];?></a>
</div>

<div class="clear"></div>

<?php } ?>

</div>

</section>

<div id="msg_box">
<p></p>
</div>

<script type="text/javascript" src="js/page.ajax.js"></script>

<!-- JavaScript for select all -->
<script type="text/javascript">
		$(document).ready(function()
		{
		
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