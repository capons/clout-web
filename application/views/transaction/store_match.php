<table class='microform ignoreclear'>

<tr>
	<td class='instruction-row' colspan='3'>
		<table><tr><td>Update this transaction's store match.</td></tr></table>
	</td>
</tr>




<tr>

<td style="vertical-align:top;width: 49%;" id='raw-record-div'>
	<table class='normal-table'>
		<tr><td>Descriptor</td><td><?php echo $raw_descriptor;?></td></tr>
		<tr><td>Address</td><td><?php echo $raw_address;?></td></tr>
		<tr><td>Place Type</td><td><?php echo $raw_place_type;?></td></tr>
	</table>
</td>
<td style="vertical-align:middle;width: 1%;padding:5px;"><button id='copyrawrecord' name='copyrawrecord' data-source='raw-record-div' data-destination='final-record-div' class='green smallbtn' style="min-width:30px;max-width:30px;">&gt;&gt;</button> </td>
<td style="vertical-align:top;width: 50%;" id='final-record-div'>
	<table class='normal-table'>
		<tr><td>Name</td><td><input name='storename_<?php echo $transaction_id;?>' id='storename_<?php echo $transaction_id;?>' type='text' class='smalltextfield' placeholder='Store Name' style='width:100%;' value='<?php echo !empty($store_name)? $store_name: '';?>'></td></tr>
		<tr><td>Address</td><td>
			<table>
				<tr>
					<td colspan='2'><input name='storeaddress_<?php echo $transaction_id;?>' id='storeaddress_<?php echo $transaction_id;?>' type='text' class='smalltextfield' placeholder='Address' style='width:100%;' value='<?php echo !empty($store_address)? $store_address: '';?>'></td>
				</tr>
				<tr>
					<td><input name='storecity_<?php echo $transaction_id;?>' id='storecity_<?php echo $transaction_id;?>' type='text' class='smalltextfield' placeholder='City' style='width:100%;' value='<?php echo !empty($store_city)? $store_city: '';?>'></td>
					<td><select id='states_<?php echo $transaction_id;?>__states' name='states_<?php echo $transaction_id;?>__states' class="small-drop-down" style="min-width:100px;"><?php echo get_option_list($this, 'states', 'select', '', array('selected'=>(!empty($store_state)? $store_state: '')));?></select></td>
				</tr>
				<tr>
					<td colspan='2'><input name='storezipcode_<?php echo $transaction_id;?>' id='storezipcode_<?php echo $transaction_id;?>' type='text' class='smalltextfield' placeholder='Zip Code' value='<?php echo !empty($store_zipcode)? $store_zipcode: '';?>'></td>
				</tr>
			</table>
		</td></tr>
		<tr><td>Website</td><td><input name='storewebsite_<?php echo $transaction_id;?>' id='storewebsite_<?php echo $transaction_id;?>' type='text' class='smalltextfield' placeholder='Store Website' style='width:100%;' value='<?php echo !empty($store_website)? $store_website: '';?>'></td></tr>
		<tr><td>Telephone</td><td><input name='storetelephone_<?php echo $transaction_id;?>' id='storetelephone_<?php echo $transaction_id;?>' type='text' class='smalltextfield numbersonly' placeholder='Store Telephone' style='width:100%;' value='<?php echo !empty($store_telephone)? $store_telephone: '';?>'></td></tr>
	</table>
</td>
</tr>


<tr><td colspan='3'><div id='matchrule_<?php echo $transaction_id;?>' class='closable-div microform'>
<table class='normal-table'>
	<tr><td colspan='2' style='font-weight:bold;'>Edit Rule Used to Match Store</td></tr>
	<tr>
		<td style='width:1%;'>Command</td><td style='white-space:nowrap;'><input type='radio' id='rulecommand_<?php echo $transaction_id;?>_match' name='rulecommand_<?php echo $transaction_id;?>' value='match' /><label for='rulecommand_<?php echo $transaction_id;?>_match'>Match</label> &nbsp; 
			<input type='radio' id='rulecommand_<?php echo $transaction_id;?>_reject' name='rulecommand_<?php echo $transaction_id;?>' value='reject' /><label for='rulecommand_<?php echo $transaction_id;?>_reject'>Reject</label></td>
		<td style='width:1%;'>Store</td><td><input name='rulestorename_<?php echo $transaction_id;?>' id='rulestorename_<?php echo $transaction_id;?>' type='text' class='smalltextfield searchable' placeholder='Store Name' style='width:100%;' value='<?php echo !empty($rule_store_name)? $rule_store_name: '';?>'>
			<input name='rulestoreid_<?php echo $transaction_id;?>' id='rulestoreid_<?php echo $transaction_id;?>' type='hidden' value='<?php echo !empty($rule_store_id)? $rule_store_id: '';?>'></td>
	</tr>
	<tr>
		<td style='white-space:nowrap;'>Name Pattern</td><td><input name='rulenamepattern_<?php echo $transaction_id;?>' id='rulenamepattern_<?php echo $transaction_id;?>' type='text' class='smalltextfield searchable' placeholder='Name Pattern' style='width:100%;' value='<?php echo !empty($rule_name_pattern)? $rule_name_pattern: '';?>'></td>
		<td style='white-space:nowrap;'>Address Pattern</td><td><input name='ruleaddresspattern_<?php echo $transaction_id;?>' id='ruleaddresspattern_<?php echo $transaction_id;?>' type='text' class='smalltextfield searchable' placeholder='Address Pattern' style='width:100%;' value='<?php echo !empty($rule_address_pattern)? $rule_address_pattern: '';?>'></td>
	</tr>
	<tr>
		<td style='white-space:nowrap;'>City Pattern</td><td><input name='rulecitypattern_<?php echo $transaction_id;?>' id='rulecitypattern_<?php echo $transaction_id;?>' type='text' class='smalltextfield searchable' placeholder='City Pattern' style='width:100%;' value='<?php echo !empty($rule_city_pattern)? $rule_city_pattern: '';?>'></td>
		<td style='white-space:nowrap;'>Place Type</td><td><select id='ruleplacetype_<?php echo $transaction_id;?>__placetypes' name='ruleplacetype_<?php echo $transaction_id;?>__placetypes' class="small-drop-down" style="min-width:100px;"><?php echo get_option_list($this, 'placetypes', 'select', '', array('selected'=>(!empty($rule_place_type)? $rule_place_type: '')));?></select></td>
	</tr>
	<tr>
		<td colspan='4'>
		<button id='saverule_<?php echo $transaction_id;?>' name='saverule_<?php echo $transaction_id;?>' class='green smallbtn submitmicrobtn'>Add Rule</button>
		<input name='action' id='action' type='hidden' value='<?php echo base_url().'transaction/add_rule'.(!empty($rule_id)? '/id/'.$rule_id: '');?>'>
		</td>
	</tr>
</table></div>
</td></tr>

<tr><td colspan='3'>
<table class='normal-table'>
	<tr><td><input name='matchsearch_<?php echo $transaction_id;?>' id='matchsearch_<?php echo $transaction_id;?>' type='text' class='smalltextfield searchable' placeholder='Search..' style='width:100%;' value=''></td>
		<td style='white-space:nowrap;'><input type='radio' id='searchtype_<?php echo $transaction_id;?>_system' name='searchtype_<?php echo $transaction_id;?>' value='system' selected><label for='searchtype_<?php echo $transaction_id;?>_system'>System</label> &nbsp; 
			<input type='radio' id='searchtype_<?php echo $transaction_id;?>_google' name='searchtype_<?php echo $transaction_id;?>' value='google'><label for='searchtype_<?php echo $transaction_id;?>_google'>Google</label></td>
		<td style='width:80px;'></td>
	
	<td style='white-space:nowrap;text-align:right;'>
		<button id='cancel_<?php echo $transaction_id;?>' name='cancel_<?php echo $transaction_id;?>' class='grey smallbtn' data-value='<?php echo $transaction_id;?>'>Cancel</button>
		<button id='unqualify_<?php echo $transaction_id;?>' name='unqualify_<?php echo $transaction_id;?>' class='black smallbtn' data-value='<?php echo $transaction_id;?>'>Unqualify</button>
	</td>
	</tr>
</table>
</td></tr>

<tr>
	<td colspan='3'><div id='matchsearch_<?php echo $transaction_id;?>__div'></div></td>
</tr>
</table>