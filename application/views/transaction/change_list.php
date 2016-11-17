<?php 
if(!empty($changeList))
{
?><table>
<thead><tr><th>Date</th><th># Users</th><th>Description of Edit</th><th>Flag</th><th>Admin</th><th>Admin Level</th><th>Status</th></tr></thead>

<tbody>
 

<?php
$listCount = count($changeList);
$i = 0;

foreach($changeList AS $row)
{
	$i++;
	
echo "<tr>
<td>".format_epoch_date($row['last_update'], 'm/d/Y h:ia')."</td>

<td>".(!empty($row['contributors'])? $row['contributors']: 'N/A')."</td>

<td>".real_tags(html_entity_decode($row['description'], ENT_QUOTES)).(!empty($row['flag_count'])? " <a href='javascript:;' class='view-flags' id='".$row['id']."' data-category='transaction' data-name='view-flags-".$row['id']."'>".$row['flag_count']." Flags</a>": "")."</td>
 
<td nowrap>".
(!empty($row['flag_count'])? '+': '')."<a href='javascript:;' class='add-flag' id='".$row['id']."' data-category='transaction' data-name='add-flags-".$row['id']."'>Flag</a></td>

<td>".$row['last_admin_name']."</td>

<td>".$row['last_admin_level']."</td>

<td><span class=''>".$row['latest_status']."</span>";

# Check whether you need to stop the loading of the next pages
if($i == $listCount && ((!empty($n) && $listCount < $n) || (empty($n) && $listCount < NUM_OF_ROWS_PER_PAGE))){ 
	echo "<input name='paginationdiv__changessearch".$descriptorId."_stop' id='paginationdiv__changessearch".$descriptorId."_stop' type='hidden' value='1' />";
}

echo "</td>
</tr>";
}
 
?>

 
</tbody>
</table>
 <?php 
}
 
else {
	echo "<table><tr><td class='instruction-row'>".
	format_notice($this, "WARNING: No change history could be found for this descriptor.").
	"<input name='paginationdiv__changessearch".$descriptorId."_stop' id='paginationdiv__changessearch".$descriptorId."_stop' type='hidden' value='1' /></td></tr></table>"; 
}?>