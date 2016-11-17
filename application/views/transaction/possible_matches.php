<table class='microform ignoreclear'>

<tr>
<td class='instruction-row' colspan='2'>
<table><tr><td>Add or update matching rules attached to this descriptor below.</td></tr>
</table>
</td>
</tr>




<tr>
<td class="location-details-row" style="vertical-align:top;width: 99%;">
<?php

echo "<table class='normal-list-table' style='border: 0px;' data-msg='Are you sure you want to remove this rule? \nIt will be permanently removed from this descriptor.'>";
if(!empty($ruleList)){
	echo "<tr><td>&nbsp;</td><td class='light-bold'>Action</td><td class='light-bold'>Search Criteria</td><td class='light-bold'>Map To</td></tr>";
	
	foreach($ruleList AS $row){
		echo "<tr>
		<td width='1%' id='".$row['rule_category'].'-'.$row['id']."' class='list-delete-icon confirm' data-category='transaction'  data-type='delete_match_rule' data-action='submitted' style='min-width:35px; padding-right: 10px;'>&nbsp;
		<input type='hidden' id='ruleid_".$descriptorId."_".$row['id']."' name='ruleid_".$descriptorId."[]' value='".$row['rule_category'].'-'.$row['id']."' /></td>
		<td width='1%'>".strtoupper($row['rule_action'])."</td>
		<td width='78%'>".strtoupper(str_replace('_', ' ', $row['search_criteria'])).": ".$row['search_string_clean']."</td> 
		<td width='20%'>".($row['rule_action'] == 'match'? strtoupper($row['rule_category']).": ".$row['target_name']: '&nbsp;')."</td>
		</tr>";
	}
}

echo "<tr class='add-more-row'>
		<td colspan='4'>
		<a href='javascript:;' class='add-more-link' data-target='more_rule__".$descriptorId."'>Add Rule</a>
	<br><div id='more_rule__".$descriptorId."' style='display:none;'>";
$this->load->view('transaction/add_rule', array('descriptorId'=>$descriptorId));
echo "</div>
		</td> 
	  </tr>
</table>";

?>
</td>
	
		<td style="vertical-align:top; width: 1%;">
			<table class='normal-table'>
			
				<tr>
					<td style="white-space:nowrap;">
						<button id='save_rule_<?php echo $descriptorId;?>' name='save_rule_<?php echo $descriptorId;?>' class='btn blue submitmicrobtn submit-to-type' onclick="changeAreaHtml('more_rule__<?php echo $descriptorId;?>', '')" style='max-width: 70px;' data-type='possible_matches'>Save</button> 
						<button id='cancel_rule_<?php echo $descriptorId;?>' name='cancel_rule_<?php echo $descriptorId;?>' class='btn grey cancel-list-btn' style='max-width: 70px;'>Cancel</button>
						<input type='hidden' id='errormessage' name='errormessage' value='Please add or select a rule' />
						<input type='hidden' id='action' name='action' value='<?php echo base_url().'transaction/update_possible_matches/action/submit';?>' />
						<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
					</td>
				</tr>
						
				<tr>
					<td style="padding-top:15px;"><input type='radio' id='verify_<?php echo $descriptorId;?>_confirm' name='verify_<?php echo $descriptorId;?>' value='confirm-<?php echo $descriptorId;?>' checked/>
						<label class='text-label' for='verify_<?php echo $descriptorId;?>_confirm'>Verified By <?php echo $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');?></label>
					</td>
				</tr>
				
				<tr>
					<td>
						<input type='radio' id='verify_<?php echo $descriptorId;?>_flag' name='verify_<?php echo $descriptorId;?>' value='flag-<?php echo $descriptorId;?>' onchange="showHideOnChecked('flag_<?php echo $descriptorId;?>_problems', 'verify_<?php echo $descriptorId;?>_flag');"/>
						<label class='text-label' for='verify_<?php echo $descriptorId;?>_flag'>Flag Problem</label>
					</td>
				</tr>
				
				<tr>
					<td>
						<div id='flag_<?php echo $descriptorId;?>_problems' style='padding-top:0px; padding-left:20px; display:none;'>
						<?php
						foreach($problemFlags AS $flag){
							echo "<input type='checkbox' id='flag_".$descriptorId."_".$flag['id']."' name='flag_".$descriptorId."[]' value='".$flag['id']."'/><label class='text-label' for='flag_".$descriptorId."_".$flag['id']."'>".$flag['name']."</label><br>";
						}
						echo "<textarea class='optional' name='flag_".$descriptorId."_notes' id='flag_".$descriptorId."_notes' style='width:200px;height:70px' placeholder='Notes'></textarea>";
						?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>