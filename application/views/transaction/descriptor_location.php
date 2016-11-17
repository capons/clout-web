<table class='microform ignoreclear'>

<tr>
<td class='instruction-row' colspan='2'>
<table><tr><td>Match the &ldquo;Transaction Descriptor&rdquo; above to a location(s) from the list below.</td></tr>
</table>
</td>
</tr>




<tr>
<td class="location-details-row" style="vertical-align:top;width: 99%;">
<?php

echo "<table class='normal-table'>";
if(!empty($locationList['chains'])){
	foreach($locationList['chains'] AS $chain){
		echo "<tr>
		<td>
		<div class='accordion-row no-framing".($chain['is_selected'] == 'Y'? ' selected': '')."'><div>
			<input type='radio' id='chain_".$descriptorId."_".$chain['id']."' name='chain_".$descriptorId."[]' value='".$chain['id']."' ".($chain['is_selected'] == 'Y'? 'checked': '')."/><label class='text-label' for='chain_".$descriptorId."_".$chain['id']."'>".$chain['name']." &nbsp; | &nbsp; ".(!empty($chain['category'])? $chain['category']: 'No Category')."</label> &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$chain['id']."' data-fortarget='chain_".$descriptorId."_".$chain['id']."' data-type='chain' data-categoryid='".$descriptorId."'>edit</a>
		</div>
		
		<div style='padding-left:20px;'>";
		
		# Add the default options
		echo "<input type='radio' id='store_".$descriptorId."_".$chain['id']."' name='store_".$descriptorId."[]' value='notsure' ".(empty($locationList['stores'][$chain['id']]) && empty($chain['website'])? 'checked': '')."/><label class='text-label' for='store_".$descriptorId."_".$chain['id']."'>Not sure which location</label>
		
		<br><input type='radio' id='store_".$descriptorId."_".$chain['id']."_www' name='store_".$descriptorId."[]' value='website' ".(empty($locationList['stores'][$chain['id']]) && !empty($chain['website'])? 'checked': '')."/><label class='text-label' for='store_".$descriptorId."_".$chain['id']."_www'>".(!empty($chain['website'])? $chain['website']: 'www')."</label>  &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$chain['id']."' data-fortarget='store_".$descriptorId."_".$chain['id']."_www' data-type='chain_website' data-categoryid='".$descriptorId."'>edit</a>";
		
		# Add any other options available
		if(!empty($locationList['stores'][$chain['id']])){
			foreach($locationList['stores'][$chain['id']] AS $chainId=>$store){
				echo "<br><input type='radio' id='store_".$descriptorId."_".$store['id']."' name='store_".$descriptorId."[]' value='".$store['id']."' ".($store['is_selected']=='Y'? 'checked': '')."/><label class='text-label' for='store_".$descriptorId."_".$store['id']."'>".$store['address'].' '.$store['zipcode']."</label>  &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$chain['id']."'  data-storeid='".$store['id']."' data-type='store' data-fortarget='store_".$descriptorId."_".$store['id']."'  data-categoryid='".$descriptorId."'>edit</a>";
			}
		}
		
		echo "
		<br><a href='javascript:;' class='edit-chain' data-id='".$chain['id']."' data-type='store' data-categoryid='".$descriptorId."'>Add Location</a>
		</div>
		</td> 
		</tr>";
	}
}


echo "<tr class='add-more-row'>
		<td>
		<input type='radio' id='chain_".$descriptorId."_nomatch' name='chain_".$descriptorId."[]' value='nomatch' class='add-more-link' data-target='addchain_div__".$descriptorId."'/><label class='text-label' for='chain_".$descriptorId."_nomatch'>No Matches Found</label>
		
	<br><div id='addchain_div__".$descriptorId."' style='display:none;border-bottom: 1px solid #CCC;'>";
$this->load->view('transaction/add_chain', array('descriptorId'=>$descriptorId));
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
						<button id='save_location_<?php echo $descriptorId;?>' name='save_location_<?php echo $descriptorId;?>' class='btn blue submitmicrobtn submit-to-type' onclick="changeAreaHtml('addchain_div__<?php echo $descriptorId;?>', '')" style='max-width: 70px;' data-type='descriptor_location'>Save</button> 
						<button id='cancel_location_<?php echo $descriptorId;?>' name='cancel_location_<?php echo $descriptorId;?>' class='btn grey cancel-list-btn' style='max-width: 70px;'>Cancel</button>
						<input type='hidden' id='errormessage' name='errormessage' value='Please add or select a location' />
						<input type='hidden' id='action' name='action' value='<?php echo base_url().'transaction/update_descriptor_location/action/submit';?>' />
						<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
					</td>
				</tr>
					
				<tr>
					<td style="padding-top:15px;">
						<input type='radio' id='verify_<?php echo $descriptorId;?>_confirm' name='verify_<?php echo $descriptorId;?>' value='confirm-<?php echo $descriptorId;?>' checked/>
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