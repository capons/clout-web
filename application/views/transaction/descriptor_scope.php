<table class='microform ignoreclear'>

<tr>
<td class='instruction-row' colspan='2'>
<table><tr><td>Is the &ldquo;Transaction Descriptor&rdquo; above used at only one store, or is it used accross multiple products or addresses?  Or something else?  Select from the list below.</td></tr>
</table>
</td>
</tr>




<tr>
<td style="vertical-align:top;width: 99%;">
<?php
if(!empty($scopeList)){
echo "<table class='normal-table'>";
foreach($scopeList AS $row){
	echo "<tr>
	<td width='1%'><input type='radio' id='scope_".$descriptorId."_".$row['scope_id']."' name='scope_".$descriptorId."[]' value='".$row['scope_id']."' ".($row['is_selected'] == 'Y'? 'checked': '')."/><label class='text-label' for='scope_".$descriptorId."_".$row['scope_id']."'>".$row['scope_name']."</label></td>
	</tr>";
}

echo "</table>";
}
?>
</td>

<td style="vertical-align:top; width: 1%;">
<table class='normal-table'>

<tr><td style="white-space:nowrap;"><button id='save_scope_<?php echo $descriptorId;?>' name='save_scope_<?php echo $descriptorId;?>' class='btn blue submitmicrobtn submit-to-type' style='max-width: 70px;' data-type='descriptor_scope'>Save</button> 
<button id='cancel_scope_<?php echo $descriptorId;?>' name='cancel_scope_<?php echo $descriptorId;?>' class='btn grey cancel-list-btn' style='max-width: 70px;'>Cancel</button>
<input type='hidden' id='errormessage' name='errormessage' value='Please confirm the scope of this descriptor' />
<input type='hidden' id='action' name='action' value='<?php echo base_url().'transaction/update_descriptor_scope/action/submit';?>' />
<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
</td></tr>

<tr><td style="padding-top:15px;"><input type='radio' id='verify_<?php echo $descriptorId;?>_confirm' name='verify_<?php echo $descriptorId;?>' value='confirm-<?php echo $descriptorId;?>' checked/><label class='text-label' for='verify_<?php echo $descriptorId;?>_confirm'>Verified By <?php echo $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');?></label></td></tr>

<tr><td><input type='radio' id='verify_<?php echo $descriptorId;?>_flag' name='verify_<?php echo $descriptorId;?>' value='flag-<?php echo $descriptorId;?>' onchange="showHideOnChecked('flag_<?php echo $descriptorId;?>_problems', 'verify_<?php echo $descriptorId;?>_flag');"/><label class='text-label' for='verify_<?php echo $descriptorId;?>_flag'>Flag Problem</label></td></tr>

<tr><td><div id='flag_<?php echo $descriptorId;?>_problems' style='padding-top:0px; padding-left:20px; display:none;'><?php
foreach($problemFlags AS $flag){
	echo "<input type='checkbox' id='flag_".$descriptorId."_".$flag['id']."' name='flag_".$descriptorId."[]' value='".$flag['id']."'/><label class='text-label' for='flag_".$descriptorId."_".$flag['id']."'>".$flag['name']."</label><br>";
}
echo "<textarea name='flag_".$descriptorId."_notes' id='flag_".$descriptorId."_notes' class='optional' style='width:200px;height:70px' placeholder='Notes'></textarea>";
?></div></td></tr>
</table>
</td>
</tr>
</table>