<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="ustatus">
<div class="bar_available<?php if ($lsuser->getVar("available") == 0) { echo ' not_available'; } ?>" id="available_user"><?php echo $tl["general"]["g"];?></div>
<div class="bar_alert" id="sound_alert"><?php echo $tl["general"]["g2"];?></div>
</div>

<div class="clear"></div>

<section>

<div class="content-border">

<form class="ls_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table">
<tr class="content-title">
<td class="content-go">#</td>
<td class="content-go"><input type="checkbox" id="ls_delete_all" /></td>
<td><?php echo $tl["login"]["l1"];?></td>
<td><?php echo $tl["general"]["g12"];?></td>
<td><?php echo $tl["general"]["g11"];?></td>
<td><?php echo $tl["general"]["g10"];?></td>
<td><?php echo $tl["general"]["g13"];?></td>
<td><?php echo $tl["general"]["g14"];?></td>
<td class="content-go"><a href="index.php?p=logs&amp;sp=truncate&amp;ssp=go"><img src="img/icontrun.png" width="14" height="16" alt="truncate" onclick="if(!confirm('<?php echo $tl["error"]["e34"];?>'))return false;" /></a></td>
<td class="content-go"><button type="submit" name="delete" id="button_delete" class="delete-button" onclick="if(!confirm('<?php echo $tl["error"]["e33"];?>'))return false;"></button></td>
</tr>
<?php if (isset($LS_LOGINLOG_ALL) && is_array($LS_LOGINLOG_ALL)) foreach($LS_LOGINLOG_ALL as $v) { ?>
<tr>
<td class="content-go"><?php echo $v["id"];?></td>
<td class="content-go"><input type="checkbox" name="ls_delete_log[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><?php echo $v["name"];?></td>
<td><?php echo $v["fromwhere"];?></td>
<td><?php echo $v["ip"];?></td>
<td><?php echo $v["usragent"];?></td>
<td><?php echo $v["time"]; ?></td>
<td class="content-go"><?php if ($v["access"] == '1') { ?><img src="img/success.png" alt="success" /><?php } else { ?><img src="img/not_available_s.png" alt="nonsuccess" /><?php } ?></td>
<td></td>
<td class="content-go"><a href="index.php?p=logs&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>"><img src="<?php echo BASE_URL_ADMIN;?>img/delete.png" width="14" height="16" alt="delete" onclick="if(!confirm('<?php echo $tl["error"]["e33"];?>'))return false;" /></a></td>
</tr>
<?php } ?>
</table>
</form>
</div>

</section>

<div id="msg_box">
<p></p>
</div>

<script type="text/javascript" src="<?php echo BASE_URL_ADMIN;?>js/page.ajax.js"></script>

<!-- JavaScript for select all -->
<script type="text/javascript">
		$(document).ready(function()
		{
		
		setChecker(<?php echo $lsuser->getVar("id");?>);
		        setInterval("setChecker(<?php echo $lsuser->getVar("id");?>);", 10000);
		setTimer(<?php echo $lsuser->getVar("id");?>);
		        setInterval("setTimer(<?php echo $lsuser->getVar("id");?>);", 120000);
		
			$("#ls_delete_all").click(function() {
			$("#button_delete").toggleClass("highlight-delete");
				var checked_status = this.checked;
				$(".highlight").each(function()
				{
					this.checked = checked_status;
				});
			});
			$(".highlight").click(function() {
			$("#button_delete").addClass("highlight-delete");
			});					
		});
		
		ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
		ls.main_lang = "<?php echo LS_LANG;?>";
		ls.ls_submit = "<?php echo $tl['general']['g69'];?>";
		ls.ls_submitwait = "<?php echo $tl['general']['g70'];?>";
</script>

		
<?php include_once APP_PATH.'operator/template/footer.php';?>