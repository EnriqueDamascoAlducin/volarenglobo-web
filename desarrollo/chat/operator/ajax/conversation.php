<?php

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 6 May 1998 03:10:00 GMT");

/*======================================================================*\
|| #################################################################### ||
|| # Rhino 1.4                                                        # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright 2012 Rhino All Rights Reserved.                        # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| #   ---------------- Rhino IS NOT FREE SOFTWARE ----------------   # ||
|| #                 http://www.livesupportrhino.com                  # ||
|| #################################################################### ||
\*======================================================================*/

// Start the session
session_start();

if (!file_exists('../../config.php')) {
    die('ajax/[response.php] config.php not exist');
}
require_once '../../config.php';

if(!$_SERVER['HTTP_X_REQUESTED_WITH'] && !isset($_SESSION['idhash'])) {
	die("Nothing to see here");
}

if (file_exists(APP_PATH.'operator/lang/'.LS_LANG.'.ini')) {
    $tl = parse_ini_file(APP_PATH.'operator/lang/'.LS_LANG.'.ini', true);
} else {
    trigger_error('Translation file not found');
}

if (!is_numeric($_GET['id'])) die("There is no such message!");

// remove timeout- prevents session duplication
$timeout_remove = 43200;

	$new = array();
	$updated = array();
	$current = array();
	$closed = array();
	$count = 0;
	
	$result = $lsdb->query('SELECT * FROM '.DB_PREFIX.'sessions WHERE status = "open"');
	
	if ($lsdb->affected_rows > 0) {
		
		while ($row = $result->fetch_assoc()) {
			
			if ($row['status'] == "open") {
			
				if (((time() - $row['initiated']) > $timeout_remove) && $row['answered'] == 0) {
					
					$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET status = "closed", ended = "'.time().'" WHERE id = "'.$row['id'].'"');
					
					$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET
					name = "System",
					message = "'.smartsql($tl['general']['g72']).'",
					convid = "'.$row['id'].'",
					time = NOW(),
					class = "notice"');
				}
				
				if ($row['answered'] > $row['updated']) {
					
					if ((time() - $row['answered']) > LS_INACTIV) {
						
						$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET status = "closed", ended = "'.time().'" WHERE id = "'.$row['id'].'"');
						
						$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET
						name = "System",
						message = "'.smartsql($tl['general']['g72']).'",
						convid = "'.$row['id'].'",
						time = NOW(),
						class = "notice"');
					}
				}
		
		
		if ($row['updated'] > $row['answered']) {
			if(($row['updated'] == 0) && ($row['answered'] == 0)) {
				$new[$count]["name"] = $row['name'];		
				$new[$count]["convid"] = $row['convid'];
				if ($row['u_typing']) $new[$count]["typing"] = '<img src="../img/typing.png" width="16" height="16" alt="typing" /> ';	
			} else {
				$updated[$count]["name"] = $row['name'];
                $updated[$count]["convid"] = $row['convid'];
                if ($row['u_typing']) $updated[$count]["typing"] = '<img src="../img/typing.png" width="16" height="16" alt="typing" /> ';
			}
			
		} elseif (($row['updated'] == 0) && ($row['answered'] == 0)) {
			$new[$count]["name"] = $row['name'];
            $new[$count]["convid"] = $row['convid'];
            if ($row['u_typing']) $new[$count]["typing"] = '<img src="../img/typing.png" width="16" height="16" alt="typing" /> ';
            
		} else {
			$current[$count]["name"] = $row['name'];
            $current[$count]["convid"] = $row['convid'];
            if ($row['u_typing']) $current[$count]["typing"] = '<img src="../img/typing.png" width="16" height="16" alt="typing" /> ';
	}
	}
	
	if ($row['status'] == "closed") {
		if (((time() - $row['ended']) > LS_END_FLUSH) && $row['hide'] != "yes") {
		
			$lsdb->query('UPDATE '.DB_PREFIX.'sessions SET hide = "yes" WHERE id = "'.$row['id'].'"');
			
			$lsdb->query('INSERT INTO '.DB_PREFIX.'transcript SET 
			name = "System",
			message = "'.smartsql($tl['general']['g73']).'",
			convid = "'.$row['id'].'",
			class = "notice"');
			
		} else if ($row['hide'] == "no") {
			$closed[$count]["name"] = $row['name'];
		    $closed[$count]["convid"] = $row['convid'];
		}
	}
	
	if ($row['hide'] == "yes") {
		if((time() - $row['ended']) > $timeout_remove) {
		
			$lsdb->query('DELETE FROM '.DB_PREFIX.'transcript WHERE convid = "'.$row['convid'].'"');
			$lsdb->query('DELETE FROM '.DB_PREFIX.'sessions WHERE id = "'.$row['id'].'"');
			
		}
	}
$count = $count + 1;
}

	shuffle($new);
	shuffle($updated);
	shuffle($current);
	shuffle($closed);
	sort($new);
	sort($updated);
	sort($current);
	sort($closed);
	$newTotal = count($new);
	$updatedTotal = count($updated);
	$currentTotal = count($current);
	$closedTotal = count($closed);
	if (($newTotal + $updatedTotal + $currentTotal + $closedTotal ) == 0 ) { 
?>
	<script type="text/javascript">
		activeConv = "open";
		getInfo('open');
	</script>
<?php
	}
	echo '<ul id="chat-list">';
	
	for($i = 0; $i < $newTotal; $i ++ ) {
		echo '<li class="new">';
		echo '<a href="javascript:void(0)" onclick="ls.activeConv = '.$new[$i]["convid"].';getInfo(ls.activeConv); getInput(ls.activeConv);">'.$new[$i]["typing"].$new[$i]["name"].'</a>';
	    echo '</li>';
	}
	for($i = 0; $i < $updatedTotal; $i ++ ) {
		echo '<li class="updated">';
		echo '<a href="javascript:void(0)" onclick="ls.activeConv = '.$updated[$i]["convid"].';getInfo(ls.activeConv);getInput(ls.activeConv);">'.$updated[$i]["typing"].$updated[$i]["name"].'</a>';
	    echo '</li>';
	}
	for($i = 0; $i < $currentTotal; $i ++ ) {
		echo '<li class="current">';
		echo '<a href="javascript:void(0)" onclick="ls.activeConv = '.$current[$i]["convid"].';getInfo(ls.activeConv); getInput(ls.activeConv);">'.$current[$i]["typing"].$current[$i]["name"].'</a>';
	    echo '</li>';
	}
	for($i = 0; $i < $closedTotal; $i ++ ) {
		echo '<li class="ended">';
		echo '<a href="javascript:void(0)" onclick="ls.activeConv = '.$closed[$i]["convid"].';getInfo(ls.activeConv);getInput(ls.activeConv);">'.$closed[$i]["typing"].$closed[$i]["name"].'</a>';
	    echo '</li>';
	}

echo '</ul>';
}
?>