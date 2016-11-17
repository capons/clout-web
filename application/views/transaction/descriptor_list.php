<?php
if(!empty($descriptorList))
{
	$rowCount = count($descriptorList);
	$i = 0;
	foreach($descriptorList AS $row)
	{
		$i++;
	echo "<tr id='".$row['descriptor_id']."'>
<td class='inner-select hide-icon ignore-content' data-category='transaction' data-type='change_history'><div class='checkbox-table'><div><input id='select_".$row['descriptor_id']."' name='selectall[]' type='checkbox' value='".$row['descriptor_id']."' class='bigcheckbox'><label for='select_".$row['descriptor_id']."'></label></div><div>".$row['description']."</div></div></td>
<td class='inner-select' data-category='transaction' data-type='descriptor_scope'>".$row['scope']."</td>
<td class='inner-select' data-category='transaction' data-type='descriptor_category'>".(!empty($row['category'])? $row['category']: '&nbsp;')."</td>
<td class='inner-select ignore-content' data-category='transaction' data-type='descriptor_location'>".(!empty($row['sample_chain'])? $row['sample_chain'].' &nbsp;|&nbsp; ': '&nbsp;').(!empty($row['store_match_count'])? $row['store_match_count']: '0')." locations</td>
<td class='inner-select ignore-content' data-category='transaction' data-type='possible_matches'>".$row['possible_matches']."</td>
<td>$".format_number($row['affected_amount'], 100, 2, TRUE, TRUE, TRUE)."</td>
<td>".format_number($row['affected_number'])."</td>
<td>".$row['status'];

# Continuous scroll target
if($i == $rowCount) echo "<div id='scrolltarget'></div>";

echo "</td>
</tr>

<tr><td class='detail-row' colspan='8'><div id='row_".$row['descriptor_id']."_details' style='display:none;'>";
$this->load->view('transaction/change_list_container', array('descriptorId'=>$row['descriptor_id']));
echo "</div></td></tr>";
}
	
	
}
# No descriptors left to show
else {
	echo "<tr><td colspan='8'>".format_notice($this, 'WARNING: There are no more descriptors in this list.')."</td></tr>";
}
?>