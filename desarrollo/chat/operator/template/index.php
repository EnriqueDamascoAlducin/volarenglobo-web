<?php include_once APP_PATH.'operator/template/header.php';?>

<div class="ustatus">
<div class="bar_available<?php if ($lsuser->getVar("available") == 0) { echo ' not_available'; } ?>" id="available_user"><?php echo $tl["general"]["g"];?></div>
<div class="bar_alert" id="sound_alert"><?php echo $tl["general"]["g2"];?></div>
</div>

<div class="clear"></div>

<section>
	
		<div class="grid-s">
			<div class="heading_solid">
			<h3><img src="img/identity.png" width="32" alt="identity" /> <?php echo $tl["general"]["g5"];?></h3>
			</div>
			<div id="currentConv"></div>
		</div>
	
		<div class="grid-m">
			<!--- Chat container -->
			<div class="chatContainer">
				<div class="heading_solid">
				<h3><img src="img/userm.png" width="32" alt="user" /> <?php echo $tl["general"]["g6"];?></h3>
				</div>
				<!--- user info output -->
				<div id="user-info">
				</div>
				<!--- chat output -->
				<div id="chatOutput"></div>
					<!--- Input form -->
					<form name="messageInput" id="MessageInput" action="javascript:sendInput(ls.activeConv);">
					
					<select name="standard" id="response" class="input_field">
					<option value="0"><?php echo $tl["general"]["g7"];?></option>
					
					<?php if (isset($LV_RESPONSES) && is_array($LV_RESPONSES)) foreach($LV_RESPONSES as $r) { ?>
					
					<option value="<?php echo $r["id"];?>"><?php echo $r["title"];?></option>
					
					<?php } ?>
					
					</select>
					
					<input type="text" name="message" id="message" class="input_field wide" />
					<input type="submit" class="input_field submit" id="chat_s_button" value="<?php echo $tl["general"]["g4"];?>" />
				
					<select name="files" id="files" class="input_field">
					<option value="0"><?php echo $tl["general"]["g8"];?></option>
					
					<?php if (isset($LV_FILES) && is_array($LV_FILES)) foreach($LV_FILES as $f) { ?>
					
					<option value="<?php echo $f["id"];?>"><?php echo $f["name"];?></option>
					
					<?php } ?>
					
					</select>
					<button name="sendFile" value="send" id="sendFile" class="button" onClick="javascript:sharedFiles();"><?php echo $tl["general"]["g4"].' '.$tl["general"]["g9"];?></button>
					
					<input type="hidden" name="userID" id="userID" value="<?php echo $lsuser->getVar("id");?>" />
					<input type="hidden" name="userName" id="userName" value="<?php echo $lsuser->getVar("username");?>" />
					<input type="hidden" name="operatorName" id="operatorName" value="<?php echo $lsuser->getVar("name");?>" />
								
					</form>
			</div>
		</div>
			
</section>

<div class="clear"></div>

<script type="text/javascript" src="js/index.ajax.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	setChecker(<?php echo $lsuser->getVar("id");?>);
	        setInterval("setChecker(<?php echo $lsuser->getVar("id");?>);", 10000);
	setTimer(<?php echo $lsuser->getVar("id");?>);
	        setInterval("setTimer(<?php echo $lsuser->getVar("id");?>);", 120000);
	        
		$(".delete_convo").colorbox({opacity:0.9});
});

		ls.main_url = "<?php echo BASE_URL_ADMIN;?>";
		ls.main_lang = "<?php echo LS_LANG;?>";
		ls.ls_submit = "<?php echo $tl['general']['g69'];?>";
		ls.ls_submitwait = "<?php echo $tl['general']['g70'];?>";
		// set refresh rate of conversations list
		ls.convRefresh = <?php echo LS_ADMIN_REFRESH;?>;
		// set refresh rate of chat window 
		ls.chatRefresh = <?php echo LS_CONV_REFRESH;?>;
		// by default we want to retrieve dashboard
		ls.activeConv = "open";
		// set up auto refresh to pull new entries into chat window
		ls.intervalID = setInterval("getInput(ls.activeConv);", ls.chatRefresh);
</script>

<?php include_once APP_PATH.'operator/template/footer.php';?>