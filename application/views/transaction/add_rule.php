<?php 
$containerLayer = !empty($ruleId)? 'editrule__'.$descriptorId.'_'.$ruleId: 'more_rule__'.$descriptorId;

echo "<table class='normal-table microform ignoreclear'>
		
		<tr>
		<td style='width:1%;'><select id='criteria_".$descriptorId."__rulecriteria' name='criteria_".$descriptorId."__rulecriteria' class='small-drop-down' value='' style='min-width:200px;' placeholder='Select a Criteria'/>".get_option_list($this, 'rulecriteria')."</select></td>
		<td><input type='text' class='smalltextfield' id='rulesearch_".$descriptorId."' name='rulesearch_".$descriptorId."' placeholder='Enter Rule Search Phrase' value='' style='width:344px;' /></td>
		</tr>
		
		<tr>
		<td><select id='action_".$descriptorId."__ruleaction' name='action_".$descriptorId."__ruleaction' class='small-drop-down' value='' style='min-width:200px;' placeholder='Select an Action' onchange=\"toggleLayersOnCondition('matchfieldcontainer_".$descriptorId."','matchfieldcontainer_".$descriptorId."')\"/>".get_option_list($this, 'ruleactions')."</select></td>
		<td>
		<div id='matchfieldcontainer_".$descriptorId."'><input type='radio' id='matchcategory_".$descriptorId."_store' name='matchcategory_".$descriptorId."[]' value='store' onclick=\"updateMatchField('store')\" checked /><label class='text-label' for='matchcategory_".$descriptorId."_store'>Store</label> &nbsp; 
		<input type='radio' id='matchcategory_".$descriptorId."_chain' name='matchcategory_".$descriptorId."[]' value='chain' onclick=\"updateMatchField('chain')\" /><label class='text-label' for='matchcategory_".$descriptorId."_chain'>Chain</label>
		
		 &nbsp;&nbsp; <input type='text' data-val='area' data-id='matchsearchfield' class='smalltextfield searchable optional' id='matchstore_".$descriptorId."__storenames' name='matchstore_".$descriptorId."__storenames' placeholder='Search for a Store' value='' style='width:200px;' /></div>
		 <input type='hidden' id='area' name='area' value='matchsearch' /></td>
		</tr>
		
		<tr>
		<td colspan='2'>
		<button id='save_".$descriptorId."' name='save_".$descriptorId."' class='green smallbtn save-new-rule' data-value='".$descriptorId."'>Save</button>
		&nbsp; <button id='cancel_".$descriptorId."' name='cancel_".$descriptorId."' class='grey smallbtn' onclick=\"toggleLayersOnCondition('".$containerLayer."', '".$containerLayer."')\">Cancel</button>
		
		<input type='hidden' id='action' name='action' value='".base_url()."transaction/add_rule/d/".$descriptorId."' />
		</td>
		</tr>
		
		</table>";

?>