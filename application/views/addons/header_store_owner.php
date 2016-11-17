<div class="menu-icon">&nbsp;</div>
<div class="title"><?php echo $title;?></div>
<div class="logo" data-url='account/store_owner_dashboard'>&nbsp;</div>
<div class="top-left-actions">
<div class='message-alerts-icon' onClick="document.location.href='<?php echo BASE_URL."message/home";?>'"><div></div><div><?php echo ($this->native_session->get('__unread_count')? $this->native_session->get('__unread_count'): '0');?></div><div></div></div>
</div>