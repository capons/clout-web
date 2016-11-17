<?php
if(!empty($ruleSettingsList))
{
	$rowCount = count($ruleSettingsList);
	$i = 0;
	foreach($ruleSettingsList AS $row)
	{
		$i++;
		
		echo "<tr id='".$row['rule_id']."'>
<td>".$row['rule_id']."</td>
<td>".ucwords(str_replace('_', ' ', $row['category']))."</td>
<td>".ucwords(str_replace('_', ' ', $row['user_type']));

		if($row['user_type'] != 'system' && !empty($row['user_groups'])) {
			echo "<br>(Applied on: ".ucwords(str_replace('_', ' ', $row['user_groups'])).")";
		}
		
		echo "</td>
<td>".$row['name']."</td>
<td>".format_inline_edit('setting', $row['description'], $row['rule_id'])."</td>
<td>".($row['user_type'] == 'system'? 'all': format_number($row['user_count'], 3,0))."</td>
<td><div id='rule_setting_".$row['rule_id']."' data-actionurl='setting/change_rule_setting_status/d/".$row['rule_id']."' data-type='rule setting' class='toggle-radio ".($row['status'] == 'active'? 'on': '')."'></div>";


# Continuous scroll target
if($i == $rowCount) echo "<div id='scrolltarget'></div>";

echo "</td>
</tr>";
}
	
	
}
# No descriptors left to show
else {
	echo "<tr><td colspan='7'>".format_notice($this, 'WARNING: There are no more rule settings in this list.')."</td></tr>";
}
?>