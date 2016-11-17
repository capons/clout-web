<table>
<tr><td class="sub-list-header">Permissions</td></tr>
<tbody>
<?php 
if(!empty($permissionList))
{
	foreach($permissionList AS $category=>$permissions){
		# Determine if all or some are selected
		if(empty($selectedPermissions[$category])) {
			$scope = 'none';
		} else {
			$permissionIds = array_keys($permissions);
			$selectedPermissionIds = array_keys($selectedPermissions[$category]);
			
			$diff = array_diff($permissionIds, $selectedPermissionIds);
			$scope = !empty($diff)? 'custom': 'all';
		}
		
		echo "<tr>
		<td><div class='accordion-row'><div>
			<table><tr>
			<td style='width:97%;'>".ucwords(str_replace('_', ' ', $category))."</td>
			<td style='width:1%;'><input type='radio' id='selectgroup_".$category."_all' name='selectgroup_".$category."' value='all' ".($scope == 'all'? ' checked': '')."/><label for='selectgroup_".$category."_all'>All</label></td>
			<td style='width:1%;'><input type='radio' id='selectgroup_".$category."_none' name='selectgroup_".$category."' value='none' ".($scope == 'none'? ' checked': '')."/><label for='selectgroup_".$category."_none'>None</label></td>
			<td style='width:1%;'><input type='radio' id='selectgroup_".$category."_custom' name='selectgroup_".$category."' value='custom' ".($scope == 'custom'? ' checked': '')."/><label for='selectgroup_".$category."_custom'>Custom</label></td>
			</tr></table>
			</div>
		<div>";
		
		echo "<table class='normal-list-table' style='border: 0px;'>";
		foreach($permissions AS $permissionId=>$row){
			echo "<tr><td style='width:1%; border-right:0px;'><input id='permission_".$row['permission_id']."' name='permissionids[]' type='checkbox' value='".$row['permission_id']."' class='bigcheckbox' ".(!empty($selectedPermissionIds) && in_array($permissionId, $selectedPermissionIds)? ' checked':'')."><label for='permission_".$row['permission_id']."'></label></td>
			<td>".$row['name']."</td></tr>";
		}
		
		echo "</table></div>
		</div></td>
		</tr>";
	}
}?>

</tbody>
</table>
