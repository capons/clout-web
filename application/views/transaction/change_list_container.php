<?php 
 if(!empty($changeList))
 { 
?>
<table>
	<tr>
		<td class='instruction-row'>
			<table>
				<tr>
					<td style='width:60%;white-space:nowrap;'>Please review the edit history and flag any problems you notice.</td>

					<td width='30%'>
						<div class='rightpagination' style="margin:0px;padding:0px;">
							<div id="changessearch<?php echo $descriptorId;?>" class="paginationdiv no-scroll">
								<div class="previousbtn" style='display:none;'>&#x25c4;</div>
								<div class="selected">1</div>
								<div class="nextbtn">&#x25ba;</div>
							</div>
							<input name="paginationdiv__changessearch<?php echo $descriptorId;?>_action" id="paginationdiv__changessearch<?php echo $descriptorId;?>_action" type="hidden" value="<?php echo base_url()."lists/load/t/descriptor_changes/descriptor_id/".$descriptorId;?>" />
							<input name="paginationdiv__changessearch<?php echo $descriptorId;?>_maxpages" id="paginationdiv__changessearch<?php echo $descriptorId;?>_maxpages" type="hidden" value="<?php echo NUM_OF_LISTS_PER_VIEW;?>" />
							<input name="paginationdiv__changessearch<?php echo $descriptorId;?>_noperlist" id="paginationdiv__changessearch<?php echo $descriptorId;?>_noperlist" type="hidden" value="<?php echo NUM_OF_ROWS_PER_PAGE;?>" />
							<input name="paginationdiv__changessearch<?php echo $descriptorId;?>_showdiv" id="paginationdiv__changessearch<?php echo $descriptorId;?>_showdiv" type="hidden" value="paginationdiv__changessearch<?php echo $descriptorId;?>_list" />
							<input name="paginationdiv__changessearch<?php echo $descriptorId;?>_extrafields" id="paginationdiv__changessearch<?php echo $descriptorId;?>_extrafields" type="hidden" value="changetype<?php echo $descriptorId;?>__typeofchangehistory=historytype" />
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td class='list-details-row'>
			<div id="paginationdiv__changessearch<?php echo $descriptorId;?>_list">
				<div id="changessearch<?php echo $descriptorId;?>__1">
					<?php $this->load->view('transaction/change_list', array('changeList'=>$changeList));?>
				</div>
			</div>
		</td>
	</tr>
</table>
 
 
<?php 
}
else {
	echo "<table><tr><td class='instruction-row'>".
	format_notice($this, "WARNING: No change history could be found for this descriptor.").
	"</td></tr></table>"; 
}?>