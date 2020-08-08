<?php include_once APP_PATH.'operator/template/header.php';?>

<?php if ($LS_SPECIALACCESS) { ?>
<div class="ustatus">
<div class="bar_available<?php if ($lsuser->getVar("available") == 0) { echo ' not_available'; } ?>" id="available_user"><?php echo $tl["general"]["g"];?></div>
<div class="bar_alert" id="sound_alert"><?php echo $tl["general"]["g2"];?></div>
<a class="submenu" href="index.php?p=users&amp;sp=newuser"><?php echo $tl["menu"]["m7"];?></a>
</div>
<?php } ?>

<div class="clear"></div>

<section>

<div class="content-border">
<form class="ls_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table">
<tr class="content-title">
<td class="content-go">#</td>
<td class="content-go"><input type="checkbox" id="ls_delete_all" /></td>
<td><?php echo $tl["user"]["u"];?></td>
<td><?php echo $tl["user"]["u1"];?></td>
<td><?php echo $tl["user"]["u2"];?></td>
<td class="content-go"></td>
<td class="content-go"><button type="submit" name="lock" id="button_lock" class="lock-button"></button></td>
<td class="content-go"></td>
<td class="content-go"><button type="submit" name="delete" id="button_delete" class="delete-button" onclick="if(!confirm('<?php echo $tl["user"]["al"];?>'))return false;"></button></td>
</tr>
<?php if (isset($LS_USER_ALL) && is_array($LS_USER_ALL)) foreach($LS_USER_ALL as $v) { ?>
<tr>
<td class="content-go"><?php echo $v["id"];?></td>
<td class="content-go"><input type="checkbox" name="ls_delete_user[]" class="highlight" value="<?php echo $v["id"];?>" /></td>
<td><a href="index.php?p=users&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><?php echo $v["name"];?></a></td>
<td><?php echo $v["email"];?></td>
<td><a href="index.php?p=users&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><?php echo $v["username"];?></a></td>
<td class="content-go"><a href="index.php?p=users&amp;sp=stats&amp;ssp=<?php echo $v["id"];?>&amp;sssp=<?php echo $v["username"];?>" class="read_stats"><img src="img/stats.png" width="18" height="16" alt="edit" /></a></td>
<td class="content-go"><a href="index.php?p=users&amp;sp=lock&amp;ssp=<?php echo $v["id"];?>"><img src="img/<?php if ($v["access"] == '1') { ?>lockedno<?php } else { ?>locked<?php } ?>.png" width="14" height="16" alt="img/<?php if ($v["access"] == '0') { ?>locked<?php } else { ?>notlocked<?php } ?>" /></a></td>
<td class="content-go"><a href="index.php?p=users&amp;sp=edit&amp;ssp=<?php echo $v["id"];?>"><img src="img/edit.png" width="14" height="16" alt="edit" /></a></td>
<td class="content-go"><a href="index.php?p=users&amp;sp=delete&amp;ssp=<?php echo $v["id"];?>"><img src="img/delete.png" width="14" height="16" alt="delete" onclick="if(!confirm('<?php echo $tl["user"]["al"];?>'))return false;" /></a></td>
</tr>
<?php } ?>
</table>
</form>
</div>
	
</section>

<div id="msg_box">
<p></p>
</div>

<script type="text/javascript" src="js/page.ajax.js"></script>

<!-- JavaScript for select all -->
<script type="text/javascript">
		$(document).ready(function() {
		
		setChecker(<?php echo $lsuser->getVar("id");?>);
		        setInterval("setChecker(<?php echo $lsuser->getVar("id");?>);", 10000);
		setTimer(<?php echo $lsuser->getVar("id");?>);
		        setInterval("setTimer(<?php echo $lsuser->getVar("id");?>);", 120000);
		
			$("#ls_delete_all").click(function() {
			$("#button_lock").toggleClass("highlight-lock");
			$("#button_delete").toggleClass("highlight-delete");
				var checked_status = this.checked;
				$(".highlight").each(function()
				{
					this.checked = checked_status;
				});
			});
			$(".highlight").click(function() {
			$("#button_lock").addClass("highlight-lock");
			$("#button_delete").addClass("highlight-delete");
			});
			
			$(".read_stats").colorbox({opacity:0.9});
						
		});
		
		ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
		ls.main_lang = "<?php echo LS_LANG;?>";
		ls.ls_submit = "<?php echo $tl['general']['g69'];?>";
		ls.ls_submitwait = "<?php echo $tl['general']['g70'];?>";
</script>

		
<?php include_once APP_PATH.'operator/template/footer.php';?>