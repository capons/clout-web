<?php
if(!empty($message))
{
	echo "<table class='normal-table' style='width:100%;max-width:1000px;'>

<tr><td style='width:1%;'><button id='backtoinbox' name='backtoinbox' class='btn green' style='min-width:80px;max-width:80px;'>Back</button></td><td class='h3' style='width:99%; word-wrap: break-word;'><b>".html_entity_decode($message['subject'], ENT_QUOTES)."</b></td></tr>

<tr><td colspan='2' style='padding:0px;'><table cellpadding='0' border='0' cellspacing='0' style='width:100%;font-weight:bold;'><tr><td style='width:99%;'>FROM: ".$message['sender']." <".$message['sender_type']."></td><td style='align:right;width:1%;white-space:nowrap;'>".format_epoch_date($message['date_received'], 'm/d/Y h:ia')."</td></tr></table></td></tr>

<tr><td colspan='2' style='word-wrap: break-word;'>".html_entity_decode($message['details'], ENT_QUOTES)."</td></tr>";
	
	if(!empty($message['attachment_url'])) echo "<tr><td colspan='2'><span class='attachment'>&nbsp;</span><a href='".API_PUBLIC_URL."assets/uploads/".$message['attachment_url']."' target='_blank'>".$message['attachment_url']."</a></td></tr>";
	
	echo "</table>";
}
else if(!empty($msg)) echo format_notice($this, $msg); 
?>