<?php
if(!empty($transactionList))
{
	$rowCount = count($transactionList);
	$i = 0;
	foreach($transactionList AS $row)
	{
		$i++;
		echo "<tr id='".$row['transaction_id']."'>
<td>
	<div class='checkbox-table'>
		<div>
			<input id='select_".$row['transaction_id']."' name='selectall[]' type='checkbox' value='".$row['transaction_id']."' class='bigcheckbox'>
			<label for='select_".$row['transaction_id']."'></label>
		</div>
		<div>".$row['description']."</div>
	</div>
</td>
<td class='inner-select' data-category='transaction' data-type='transaction_category'>".$row['category']."</td>
<td class='inner-select ignore-content' data-category='transaction' data-type='store_match";
$subViewKeys = array('raw_descriptor','raw_address','raw_place_type','transaction_id','store_name','store_address','store_city','store_state',
		'store_zipcode','store_website','store_telephone','rule_store_name','rule_name_pattern','rule_address_pattern','rule_city_pattern',
		'rule_place_type','rule_id'
);		

foreach($row AS $key=>$value) if(in_array($key, $subViewKeys)) echo "/".$key."/".(!empty($value)? replace_bad_chars($value): '_'); 
echo "'>".(!empty($row['store_match'])? $row['store_match']: '&nbsp;')."</td>
<td>".format_epoch_date($row['transaction_date'], 'm/d/Y H:i')."</td>
<td>$".format_number($row['amount'], 100, 2, TRUE, TRUE, TRUE)."</td>
<td class='inner-select' data-category='transaction' data-type='transaction_status'>".$row['match_status']."</td>
<td>".format_id($row['user_id'])."</td>
<td>".$row['place_type']."</td>
<td>".$row['transaction_type'];
		# Continuous scroll target
		if($i == $rowCount) echo "<div id='scrolltarget'></div>";

		echo "</td>
</tr>

<tr><td class='detail-row' colspan='9'>
	<div id='row_".$row['transaction_id']."_details'>";
		$this->load->view('transaction/store_match', $row);
		echo "</div>
	</td>
</tr>";
	}
	
	
}
# No transactions left to show
else {
	echo "<tr><td colspan='9'>".format_notice($this, 'WARNING: There are no more transactions in this list.')."</td></tr>";
}
?>