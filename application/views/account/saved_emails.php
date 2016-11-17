<?php
if(!empty($savedEmails)){
 if(!empty($msg)) echo format_notice($this, $msg);
 
 foreach($savedEmails AS $email) echo "<div class='radio-item".($email['is_active'] == 'N'? ' temporary': '')."' data-type='email' data-id='".$email['contact_id']."'><div><input type='radio' id='email_".$email['contact_id']."' name='useremails' value='".$email['email_address']."' ".($email['is_primary'] == 'Y'? 'checked': '')."/></div><div><label for='email_".$email['contact_id']."'>".$email['email_address'].($email['is_active'] == 'N'? '*': '')."</label></div></div>";
}
?>