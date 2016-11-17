<?php 
echo "<input type='text' data-type='".str_replace('_', ' ', $t)."' id='".$t."_".$d."' name='".$t."_".$d."' value='".html_entity_decode(restore_bad_chars($v), ENT_QUOTES)."' class='smalltextfield submit-focus-out' style='width:".(!empty($w)? $w: '80')."px;'/>";

if(!empty($h)) echo "<input type='hidden' id='".$t."_".$d."__hidden' name='".$t."_".$d."__hidden' value='".html_entity_decode(restore_bad_chars($h), ENT_QUOTES)."' />";

?>