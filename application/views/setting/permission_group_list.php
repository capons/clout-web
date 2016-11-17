<?php
if(!empty($permissionGroupList))
{
	$rowCount = count($permissionGroupList);
	$i = 0;
	foreach($permissionGroupList AS $row)
	{
		$i++;

	echo "<tr id='".$row['group_id']."'>
<td>".$row['group_id']."</td>
<td>";
	
	if($row['is_removable'] == 'Y'){
		 echo "<span id='".$row['group_id']."' class='list-delete-icon confirm' data-category='setting'  data-type='delete_permission_group' data-action='submitted' style='width:30px; padding-right: 20px;'>&nbsp;</span>";
	}
	
	echo "<a href='".base_url()."setting/add_group/id/".format_id($row['group_id']).'/t/'.(!empty($groupCategory)? $groupCategory: 'all')."'>".$row['group_name']."</a></td>
<td>".$row['permission_summary']."</td>
<td>".$row['user_count']."</td>
<td><div id='status_groupstatus_".$row['group_id']."' data-actionurl='setting/change_group_status/d/".$row['group_id']."' data-type='permission group' class='toggle-radio ".($row['status'] == 'active'? 'on': 'off')."'></div>";


# Continuous scroll target
if($i == $rowCount) echo "<div id='scrolltarget'></div>";

echo "</td>
</tr>";
}
	
	
}
# No descriptors left to show
else {
	echo "<tr><td colspan='5'>".format_notice($this, 'WARNING: There are no more permission groups in this list.')."</td></tr>";
}
?>