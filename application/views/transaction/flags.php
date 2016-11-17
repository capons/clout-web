<table>
<?php
if(!empty($area) && $area == 'change_flag_list')
{
	if(!empty($flagList)){
		foreach($flagList AS $row){
			echo "<tr>
			<td><div class='list-delete-icon' data-category='transaction' data-type='delete_change_flag' data-action='submitted' id='".$row['flag_id']."'></div></td>
			<td>".$row['flag_name']."</td>
			</tr>";
		}
	}
}


else if(!empty($area) && $area == 'flag_form')
{
	echo "<tr><td><input type='text' id='changeflaglist".$i."__changeflaglist' name='changeflaglist".$i."__changeflaglist' class='smalltextfield searchable' value='' style='width:100%;' placeholder='Select a Flag'/>
	<br><a href='javascript:;' id='changeflaglink".$i."' onclick=\"removeFlagClass('changeflaglist".$i."__changeflaglist', 'searchable', 'Enter a Flag Name', 'changeflaglink".$i."');\">Add a New Flag</a></td></tr>
	<tr><td><button id='addflagbtn_".$i."' name='addflagbtn_".$i."' class='smallbtn green list-item-post' data-category='transaction' data-type='add_flag' data-action='approved' style='min-width:150px; width:200px;'>Add</button></td></tr>";
}

if(!empty($msg))
{
	echo "<tr><td>".format_notice($this,$msg)."</td></tr>";
}
?>
</table>