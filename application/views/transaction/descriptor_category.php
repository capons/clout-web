<table class='microform ignoreclear'>

	<tr>
		<td class='instruction-row' colspan='2'>
			<table>
				<tr>
					<td>Select the Category(ies) this Store Owner belongs to:</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td style="vertical-align:top;width: 99%;">
			<?php 
			if(!empty($categoryList)){
				
				echo "<table class='normal-table'>";
				
				foreach($categoryList['level_1'] AS $row){
					
					$unitId = $descriptorId."_".$row['id'];
					echo "<tr>
					
					<td width='1%' class='parent-child-checkboxes'>
					<input type='checkbox' id='category__".$unitId."' name='category__".$descriptorId."[]' value='".$row['id']."' ".($row['is_selected'] == 'Y'? 'checked': '')."/>
							<label class='text-label' for='category__".$descriptorId."_".$row['id']."'>".$row['name']."</label>
							<span class='minimizer-tip' data-target='div_category__".$unitId."'>&nbsp;</span>
					
					<br><div id='div_category__".$unitId."' style='padding-left:20px;'>";
					
					# Now pick the sub-categories
					foreach($categoryList['level_1to2_mapping'][$row['id']] AS $subrow){
						$subUnitId = $row['id']."_".$subrow['id'];
						echo "<input type='checkbox' id='subcategory__".$subUnitId."' name='subcategory__".$row['id']."[]' value='".$subrow['id']."' ".($subrow['is_selected'] == 'Y'? 'checked': '')."/><label class='text-label".($subrow['is_suggestion'] == 'Y'? ' green': '')."' for='subcategory__".$subUnitId."'>".ucwords(strtolower($subrow['name']))."</label><br>";
					}
					
					echo "<a href='javascript:;' class='add-more-link' data-target='more_category__".$unitId."'>Add Category</a>
					<br><div id='more_category__".$unitId."' style='display:none;'>
						<table>
						<tr>
						<td><input type='text' class='smalltextfield optional' data-category='".$row['id']."' data-descriptor='".$descriptorId."' id='newcategory_".$unitId."' name='newcategory_".$unitId."' placeholder='Enter New Category' value='' /></td>
						<td><button id='save_".$unitId."' name='save_".$unitId."' class='green smallbtn add-sub-category'>Save</button></td>
						<td><button id='cancel_".$unitId."' name='cancel_".$unitId."' class='grey smallbtn' onclick=\"toggleLayersOnCondition('more_category__".$unitId."', 'more_category__".$unitId."')\">Cancel</button></td>
						</tr>
						</table>
					</div>";
					
					echo "</div></td>
					</tr>";
				}
			
				echo "</table>";
			}
			?>
		</td>

		<td style="vertical-align:top; width: 1%;">
			<table class='normal-table'>
			
				<tr>
					<td style="white-space:nowrap;">
						<button id='save_category_<?php echo $descriptorId;?>' name='save_category_<?php echo $descriptorId;?>' class='btn blue submitmicrobtn submit-to-type' data-type='descriptor_category' style='max-width: 70px;'>Save</button>
						<button id='cancel_category_<?php echo $descriptorId;?>' name='cancel_category_<?php echo $descriptorId;?>' class='btn grey cancel-list-btn' style='max-width: 70px;'>Cancel</button>
						<input type='hidden' id='errormessage' name='errormessage' value='Please confirm the categories of this descriptor' />
						<input type='hidden' id='action' name='action' value='<?php echo base_url().'transaction/update_descriptor_category/action/submit';?>' />
						<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
					</td>
				</tr>
			
				<tr>
					<td style="padding-top:15px;">
						<input type='radio' id='verify_<?php echo $descriptorId;?>_confirm' name='verify_<?php echo $descriptorId;?>' value='confirm-<?php echo $descriptorId;?>' checked/><label class='text-label' for='verify_<?php echo $descriptorId;?>_confirm'>Verified By <?php echo $this->native_session->get('__first_name').' '.$this->native_session->get('__last_name');?></label>
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