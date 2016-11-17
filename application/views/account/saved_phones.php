<?php
if(!empty($savedPhones)){
	if(!empty($msg)) echo format_notice($this, $msg);
 
 	foreach($savedPhones AS $phone) echo "<div class='radio-item".($phone['is_active'] == 'N'? ' temporary': '')."' data-type='phone' data-id='".$phone['contact_id']."'><div><input type='radio' id='telephone_".$phone['contact_id']."' name='usertelephones' value='".$phone['telephone']."'  ".($phone['is_primary'] == 'Y'? 'checked': '')."/></div><div><label for='telephone_".$phone['contact_id']."'>".format_telephone($phone['telephone']).($phone['is_active'] == 'N'? '*': '')."</label></div></div>";
}

echo "<br /><br />* = Pending &nbsp; &nbsp; &nbsp; Click on contact to activate";
?>