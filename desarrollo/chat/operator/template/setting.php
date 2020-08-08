<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="ustatus">
<div class="bar_available<?php if ($lsuser->getVar("available") == 0) { echo ' not_available'; } ?>" id="available_user"><?php echo $tl["general"]["g"];?></div>
<div class="bar_alert" id="sound_alert"><?php echo $tl["general"]["g2"];?></div>
</div>

<div class="clear"></div>

<section>

<div class="content-border">
<?php if ($errors) { ?>
<div class="status-failure"><?php echo $errors["e"].$errors["e1"].$errors["e2"].$errors["e3"].$errors["e4"].$errors["e5"].$errors["e6"].$errors["e7"];?></div>
<?php } ?>
<form class="ls_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g15"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g16"];?></h3></td>
	<td><input type="text" name="ls_title" class="inputbig" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'title') { echo $v["value"]; } } ?>" placeholder="<?php echo $tl["general"]["g16"];?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["login"]["l5"];?></h3><?php echo $tl["help"]["h"];?></td>
	<td><input type="text" name="ls_email" class="inputbig<?php if ($errors["e1"]) { ?> error<?php } ?>" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'email') { echo $v["value"]; } } ?>" placeholder="<?php echo $tl["login"]["l5"];?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g92"];?></h3></td>
	<td><input type="radio" name="ls_feedback" value="1"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'feedback' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?> <input type="radio" name="ls_feedback" value="0"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'feedback' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g96"];?></h3></td>
	<td><input type="radio" name="ls_captcha" value="1"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'captcha' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?> <input type="radio" name="ls_captcha" value="0"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'captcha' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g97"];?></h3></td>
	<td><input type="radio" name="ls_captchac" value="1"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'captchachat' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?> <input type="radio" name="ls_captchac" value="0"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'captchachat' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g98"];?></h3></td>
	<td><input type="radio" name="ls_smilies" value="1"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'smilies' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g19"];?> <input type="radio" name="ls_smilies" value="0"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'smilies' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g18"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g20"].'/'.$tl["general"]["g21"];?></h3></td>
	<td><input type="radio" name="ls_shttp" value="0"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'sitehttps' && $v["value"] == '0') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g20"];?> <input type="radio" name="ls_shttp" value="1"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'sitehttps' && $v["value"] == '1') { ?> checked="checked"<?php } } ?> /> <?php echo $tl["general"]["g21"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g22"];?></h3></td>
	<td><select name="ls_lang" size="1" class="input_field">
	<?php if (isset($lang_files) && is_array($lang_files)) foreach($lang_files as $lf) { ?><option value="<?php echo $lf;?>"<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'lang' && $v["value"] == $lf) { ?> selected="selected"<?php } } ?>><?php echo ucwords($lf);?></option><?php } ?>
	</select></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g23"];?></h3></td>
	<td><input<?php if ($errors["e2"]) { ?> class="error"<?php } ?> type="text" name="ls_date" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'dateformat') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g24"];?></h3></td>
	<td><input<?php if ($errors["e3"]) { ?> class="error"<?php } ?> type="text" name="ls_time" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'timeformat') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g25"];?></h3></td>
	<td><select name="ls_timezone_server" size="1" class="input_field">
	<?php include_once "timezoneserver.php";?>
	</select></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g44"];?></h3></td>
	<td><input type="text" name="ls_avatwidth" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'useravatwidth') { echo $v["value"]; } } ?>" placeholder="<?php echo $tl["general"]["g42"];?>" /> <input type="text" name="ls_avatheight" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'useravatheight') { echo $v["value"]; } } ?>" placeholder="<?php echo $tl["general"]["g43"];?>" /></td>
</tr>
</table>
<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g17"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g26"];?></h3><?php echo $tl["help"]["h1"];?></td>
	<td><input type="text" name="ls_client" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'client_refresh') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g27"];?></h3></td>
	<td><input type="text" name="ls_admin" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'admin_refresh') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g28"];?></h3></td>
	<td><input type="text" name="ls_conf" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'conv_refresh') { echo $v["value"]; } } ?>" /></td>
</tr>
</table>
<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g31"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g29"];?></h3><?php echo $tl["help"]["h2"];?></td>
	<td><input type="text" name="ls_inactiv" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'inactiv') { echo $v["value"]; } } ?>" /></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g30"];?></h3></td>
	<td><input type="text" name="ls_flush" value="<?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'end_flush') { echo $v["value"]; } } ?>" /></td>
</tr>
</table>
<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g32"];?></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g33"];?></h3></td>
	<td><textarea name="offline_message" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'offline_message') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g34"];?></h3></td>
	<td><textarea name="login_message" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'login_message') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g35"];?></h3></td>
	<td><textarea name="welcome_message" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'welcome_message') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g36"];?></h3></td>
	<td><textarea name="leave_message" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'leave_message') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g37"];?></h3></td>
	<td><textarea name="thankyou_message" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'thankyou_message') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g80"];?></h3></td>
	<td><textarea name="feedback_message" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'feedback_message') { echo $v["value"]; } } ?></textarea></td>
</tr>
<tr>
	<td class="go"><h3><?php echo $tl["general"]["g82"];?></h3></td>
	<td><textarea name="thankyou_feedback" cols="60" rows="5" class="input_field"><?php if (isset($LS_SETTING) && is_array($LS_SETTING)) foreach($LS_SETTING as $v) { if ($v["varname"] == 'thankyou_feedback') { echo $v["value"]; } } ?></textarea></td>
</tr>
</table>

<table class="table">
<tr>
<td class="content-title" colspan="2"><?php echo $tl["general"]["g71"];?> | <?php echo $tl["general"]["host"];?><input type="checkbox" name="hostname" id="hostname" value="off"<?php if($_SESSION['show_host'] == 'off') echo ' checked="checked"';?> /></td>
</tr>
<?php if (isset($get_buttons) && is_array($get_buttons)) { 

	if($_SESSION['show_host'] == 'off') { 
		$b_host = parse_url(BASE_URL_ORIG, PHP_URL_PATH);
	} else {
		$b_host = BASE_URL_ORIG;
	}

	foreach($get_buttons as $v) {

$buttoncode = htmlentities('<!-- live support rhino button --><a href="'.$b_host.'index.php?p=start&amp;lang='.LS_LANG.'" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf(\'opera\') != -1 && window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open(\''.$b_host.'index.php?p=start&amp;lang='.LS_LANG.'\', \'lsr\', \'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,width=540,height=550,resizable=1\');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="'.$b_host.'index.php?p=b&amp;i='.$v['name'].'&amp;lang=en" width="'.$v['width'].'" height="'.$v['height'].'" alt="" /></a><!-- end live support rhino button -->');
?>

<tr>
	<td class="go"><img src="<?php echo BASE_URL_ORIG;?>img/buttons/<?php echo LS_LANG;?>/<?php echo $v['name'];?>_on.png" width="<?php echo $v['width'];?>" height="<?php echo $v['height'];?>" alt=""/></td>
	<td><textarea cols="100" rows="5" class="input_field" readonly="readonly"><?php echo $buttoncode;?></textarea></td>
</tr>
<?php } } ?>
</table>

<div class="ustatus">
<button type="submit" name="save" class="button"><?php echo $tl["general"]["g38"];?></button>
</div>
<div class="clear"></div>
</form>
</div>		
</section>

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
                
	$("#hostname").change(function() {
	    $(this).closest("form").submit();
	});
	
});

		ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
		ls.main_lang = "<?php echo LS_LANG;?>";
		ls.ls_submit = "<?php echo $tl['general']['g69'];?>";
		ls.ls_submitwait = "<?php echo $tl['general']['g70'];?>";
</script>

<?php include_once APP_PATH.'operator/template/footer.php';?>