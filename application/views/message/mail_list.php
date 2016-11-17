<?php

$stopHtml = "<input name='paginationdiv__mailsearch_stop' id='paginationdiv__mailsearch_stop' type='hidden' value='1' />";

if(!empty($messageList))
{
	
	echo "<table class='normal-list-table-row with-checks' width='100%'>
<tr class='header'><td><input id='selectallcheck' name='selectallcheck' type='checkbox' value='selectall' class='bigcheckbox'><label for='selectallcheck'></label></td><td>From</td><td>Message</td><td class='down'>Date</td></tr>";

	$listCount = count($messageList);
	$i = 0;
	   
	foreach($messageList AS $row){
		$i++;
		# Highlights for unread messages
		if($row['is_read'] == 'N'){
			$boldStart = "<b>";
			$boldEnd = "</b>";
		} else {
			$boldStart = "";
			$boldEnd = "";
		}
		
		echo "<tr ".($row['is_alert'] == 'Y'? "class='alert'": '').">
<td><input id='select_".$row['message_id']."' name='select_".$row['message_id']."' type='checkbox' value='".$row['message_id']."' class='bigcheckbox'><label for='select_".$row['message_id']."'></label></td>
<td>".$boldStart.$row['sender_name'].$boldEnd."</td>
<td style='cursor:pointer;' class='view-mail-details' data-id='".$row['message_id']."'>".$boldStart.$row['subject'].$boldEnd;
		
		if(!empty($row['attachment_url'])){
			echo "<span class='attachment'>&nbsp;</span>";
		}
		
		echo "</td>
<td>".$boldStart.format_epoch_date($row['date_received'], 'm/d/Y h:ia').$boldEnd;
		 
		 # Check whether you need to stop the loading of the next pages
		if($i == $listCount && ((!empty($n) && $listCount < $n) || (empty($n) && $listCount < NUM_OF_ROWS_PER_PAGE))){
		 echo $stopHtml;
		}
		  echo "</td>
</tr>";
	}
	
	echo "</table>";
	
	
}
else echo format_notice($this, "WARNING: There are no more messages.").$stopHtml;
?>