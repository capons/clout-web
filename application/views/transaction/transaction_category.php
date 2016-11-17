<table class='microform ignoreclear'>

	<tr>
		<td class='instruction-row' colspan='2'>
			<table>
				<tr>
					<td>Select the categories and subcategories this transaction belongs to: 
					<input  type='text' id='categorysearch_<?php echo $transactionId;?>' name='categorysearch_<?php echo $transactionId;?>' value='' placeholder='Filter Categories'
							 class='smalltextfield searchicon in-session-search' data-sessionlist='category_list' data-searchfields='level_1_name,level_2_name'></input>
					<div id='categorysearch_<?php echo $transactionId;?>__results' style='white-space:nowrap; display:none;'></div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td style="vertical-align:top;width:99%;padding-left:10px;">
			<?php 
			# keep the list in seccion for quick searches
			$this->native_session->set('category_list', (!empty($categoryList)? $categoryList: array()));
			$selected = array('categories'=>array(), 'sub_categories'=>array());
			
			if(!empty($categoryList)){
				echo "<table class='normal-table' style='width:100%;'>";
				$level1 = '';
				
				foreach($categoryList AS $row){
					$unitId = $transactionId."_".$row['level_1_id'];
					
					if($level1 != $row['level_1_id']){
						# a) close row if this is not the first item
						if($level1 != '') echo "</div></td></tr>";
						
						# b) open a new category row
						echo "<tr>
						<td class='parent-child-checkboxes'>
						<input type='checkbox' id='category__".$unitId."' name='category__".$transactionId."[]' value='".$row['level_1_id']."' ".($row['is_selected_level_1'] == 'Y'? 'checked': '')."/>
								<label class='text-label' for='category__".$transactionId."_".$row['level_1_id']."'>".$row['level_1_name']."</label>
								<span class='minimizer-tip' data-target='div_category__".$unitId."'>&nbsp;</span>
						<br>
						<div id='div_category__".$unitId."' style='padding-left:20px;'>";
						
						# c) add this category to list of selected categories to help in filtering the categories						
						if($row['is_selected_level_1'] == 'Y') $selected['categories'][] = $row['level_1_id'];
					}
					
					# d) show the row sub-category
					$subUnitId = $row['level_1_id']."_".$row['level_2_id'];
					echo "<input type='checkbox' id='subcategory__".$subUnitId."' name='subcategory__".$transactionId.'_'.$row['level_1_id']."[]' ".
							"value='".$row['level_2_id']."' ".($row['is_selected_level_2'] == 'Y'? 'checked': '')."/>".
						"<label class='text-label' for='subcategory__".$subUnitId."'>".ucwords(strtolower($row['level_2_name']))."</label><br>";
					
					# e) add this sub-category to list of selected categories to help in filtering the categories
					if($row['is_selected_level_2'] == 'Y') $selected['sub_categories'][] = $row['level_2_id'];
					
					# f) keep track of the current level-1 category
					$level1 = $row['level_1_id'];
				}
				
				# always close the row if real levels were found
				if($level1 != '') echo "</div></td></tr>";
				echo "</table>";
			}
			else if(!empty($msg)) echo format_notice($this, $msg);
			
			$this->native_session->set('category_list_selected', $selected);
			?>
		</td>

		<td style="vertical-align:top; width: 1%;">
			<table class='normal-table'>
			
				<tr>
					<td style="white-space:nowrap;">
						<button id='save_category_<?php echo $transactionId;?>' name='save_category_<?php echo $transactionId;?>' class='btn blue submitmicrobtn submit-to-type' data-type='descriptor_category' style='max-width: 70px;'>Save</button>
						<button id='cancel_category_<?php echo $transactionId;?>' name='cancel_category_<?php echo $transactionId;?>' class='btn grey cancel-list-btn' style='max-width: 70px;'>Cancel</button>
						<input type='hidden' id='errormessage' name='errormessage' value='Please confirm the categories of this descriptor' />
						<input type='hidden' id='action' name='action' value='<?php echo base_url().'transaction/update_transaction_category/action/submit/transaction_id/'.$transactionId;?>' />
						<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>