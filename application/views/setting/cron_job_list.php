<?php
if(!empty($cronJobList))
{
	$rowCount = count($cronJobList);
	$i = 0;
	foreach($cronJobList AS $row)
	{
		$i++;
		
		echo "<tr id='".$row['id']."'>
<td>".$row['id']."</td>
<td>".ucwords(str_replace('_', ' ', $row['job_type']))."</td>
<td>".ucwords(str_replace('_', ' ', $row['activity_code']))."</td>
<td>".$row['cron_details']."</td>
<td>".format_epoch_date($row['start_time'], 'm/d/Y h:ia')."</td>
<td>".format_epoch_date($row['end_time'], 'm/d/Y h:ia')."</td>
<td>".strtoupper($row['result'])."</td>
<td>".$row['total_records']."</td>
<td>".ucwords(str_replace('_', ' ', $row['repeat_code']))."</td>
<td><div id='cron_job_".$row['id']."' data-actionurl='setting/change_job_status/d/".$row['id']."' data-type='cron job' class='toggle-radio ".($row['is_done'] == 'N'? 'on': '')."'></div>";


# Continuous scroll target
if($i == $rowCount) echo "<div id='scrolltarget'></div>";

echo "</td>
</tr>";
}
	
	
}
# No descriptors left to show
else {
	echo "<tr><td colspan='10'>".format_notice($this, 'WARNING: There are no more cron jobs in this list.')."</td></tr>";
}
?>