<ul>
<li<?php if ($page == '') { ?> class="active"<?php } ?>><a href="<?php echo BASE_URL_ADMIN;?>" title="<?php echo $tl["menu"]["m"];?>"><img src="img/nav/chats.png" alt="chats" /></a></li>
<li<?php if ($page == 'leads') { ?> class="active"<?php } ?>><a href="index.php?p=leads" title="<?php echo $tl["menu"]["m1"];?>"><img src="img/nav/leads.png" alt="leads" /></a></li>
<?php if ($LS_SPECIALACCESS) { ?>
<li<?php if ($page == 'emails') { ?> class="active"<?php } ?>><a href="index.php?p=emails" title="<?php echo $tl["menu"]["m8"];?>"><img src="img/nav/emails.png" alt="leads" /></a></li>
<li<?php if ($page == 'files') { ?> class="active"<?php } ?>><a href="index.php?p=files" title="<?php echo $tl["menu"]["m2"];?>"><img src="img/nav/files.png" alt="files" /></a></li>
<li<?php if ($page == 'response') { ?> class="active"<?php } ?>><a href="index.php?p=response" title="<?php echo $tl["menu"]["m3"];?>"><img src="img/nav/response.png" alt="response" /></a></li>
<?php } ?>
<li<?php if ($page == 'users') { ?> class="active"<?php } ?>><a href="index.php?p=users" title="<?php echo $tl["menu"]["m4"];?>"><img src="img/nav/users.png" alt="users" /></a></li>
<?php if ($LS_SPECIALACCESS) { ?>
<li<?php if ($page == 'settings') { ?> class="active"<?php } ?>><a href="index.php?p=settings" title="<?php echo $tl["menu"]["m5"];?>"><img src="img/nav/settings.png" alt="settings" /></a></li>
<li<?php if ($page == 'logs') { ?> class="active"<?php } ?>><a href="index.php?p=logs" title="<?php echo $tl["menu"]["m6"];?>"><img src="img/nav/logs.png" alt="logs" /></a></li>
<?php } ?>

</ul>