<div class="padded-box">
<h2><?php echo $tl["general"]["g81"].' '.$page3;?></h2>

<div id="archive">
<ul>
<?php if (isset($USER_FEEDBACK) && is_array($USER_FEEDBACK)) foreach($USER_FEEDBACK as $v) {

	echo '<li class="user"><span class="user_said">'.$v['time'].' - '.$tl['general']['g86'].':</span><br /><span class="usr_rate">'.$tl['general']['g85'].': </span>'.$v['vote'].'/5<br />'.$tl['general']['g54'].': '.$v['name'].'<br />'.$tl['general']['g88'].': '.$v['comment'].'<br />'.$tl['login']['l5'].': '.$v['email'].'<br />'.$tl['general']['g87'].': '.gmdate('H:i:s', $v['support_time']).'</li>';
	
	$count++;
    
} else {  

	echo '<li class="user">'.$tl["errorpage"]["data"].'</li>';

} ?>
</ul>
</div>

<?php if (isset($USER_FEEDBACK) && is_array($USER_FEEDBACK)) { ?>

<h2><?php echo $tl["general"]["g89"];?></h2>
<p><?php echo '<strong>'.$tl["general"]["g90"].':</strong> '.gmdate('H:i:s', $USER_SUPPORTT).'<br /><strong>'.$tl["general"]["g91"].':</strong> '.round(($USER_VOTES / $count), 2);?>/5</p>



<div id="thank-you"></div>

<div id="contact-container">
<form id="cSubmit" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<input type="hidden" name="convid" value="<?php echo $page2;?>">
	<label for="email"><?php echo $tl["general"]["g93"];?></label>
	<input type="text" name="email" id="email" class="inputbig" placeholder="<?php echo $tl["general"]["g68"];?>">
	<input type="submit" id="formsubmit" name="formsubmit" value="<?php echo $tl["general"]["g4"];?>" class="input_field submit">
	<input type="hidden" name="email_feedback" value="1" />
</form>
</div>

<?php } ?>

</div>

<script type="text/javascript" src="../js/contact.js"></script>

<script type="text/javascript">
	ls.main_url = "<?php echo BASE_URL;?>";
	ls.lsrequest_uri = "<?php echo LS_PARSE_REQUEST;?>";
	ls.ls_submit = "<?php echo $tl['general']['g4'];?>";
	ls.ls_submitwait = "<?php echo $tl['general']['g67'];?>";
</script>
