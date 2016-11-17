<?php 
echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />
<link rel='stylesheet' href='".base_url()."assets/css/clout.list.css' type='text/css' media='screen' />"; 

echo "<span class='h3'>Type: ".ucwords(str_replace('_',' ',$access['group_type']))."</span><br>";
echo "<table class='list-table' style='width:100%;'>";

if(!empty($access['rules'])){
	echo "<tr><td colspan='2' class='header'>Rules</td></tr>";
	foreach($access['rules'] AS $rule) echo "<tr><td colspan='2'>".$rule['name']."</td></tr>";
}

if(!empty($access['permissions'])){
	echo "<tr><td colspan='2'>&nbsp;</td></tr>
	<tr><td colspan='2' class='header'>Permissions</td></tr>
	<tr><td class='sub-header' style='width:1%;'>Category</td><td class='sub-header'>Permission</td></tr>";

	foreach($access['permissions'] AS $category=>$list) {
		foreach($list AS $row) echo "<tr><td>".ucwords(str_replace('_',' ',$row['category']))."</td><td>".$row['name']."</td></tr>";
	}
}

if(empty($access['rules']) && empty($access['permissions'])) echo "<tr><td>".format_notice($this, 'WARNING: No permissions are set on this group.')."</td></tr>";

echo "</table>";

?>