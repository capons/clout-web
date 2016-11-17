<table style="width:calc(100% - 20px); margin:10px;">
	<tr>
		<td class='center-all'>
			<table style="width:100%; border:none; padding:10px; margin-right: auto; margin-left: auto;">
				<tr>
					<td colspan="4" style="padding-bottom:0px;">
						<span class="whiteheadertitle blue">Your Invites</span>
						<br>
						The last invite you sent was <?php echo (!empty($pageStats['last_time_invite_was_sent'])?format_date_interval($pageStats['last_time_invite_was_sent'], '', FALSE, 'years'): '0 days');?> ago.
					</td>
				</tr>
        		<tr>
					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_direct_invites_in_my_network'],5);?>
								<br>
									<div class="networkbar bluebg first"></div>
									1st
								</td>
							</tr>
						</table>
					</td>
					
					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_2_invites_in_my_network'],5);?>
								<br>
									<div class="networkbar bluebg second"></div>
									2nd
								</td>
							</tr>
						</table>
					</td>

					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_3_invites_in_my_network'],5);?>
								<br>
									<div class="networkbar bluebg third"></div> 
									3rd
								</td>
							</tr>
						</table>
					</td>

					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_4_invites_in_my_network'],5);?>
								<br>
									<div class="networkbar bluebg fourth"></div> 
									4th
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
<?php
if(!empty($networkList)){
?>
			<table style="width:100%; border:none; margin-right: auto; margin-left: auto; margin-top:15px;" id="network_list_table" class='normal-list-table light-grey-bg'>
        
        		<tr>
        			<td style='padding-right:10px;'>
        				<input type="text" id="networksearch" data-type="invites" name="networksearch" class='smalltextfield findfield' placeholder="Search.." style="min-width:70px;width:100%;" value="">
        				<input name="networksearch__action" id="networksearch__action" type="hidden" value="<?php echo base_url()."lists/load/t/invites";?>" />
        				<input name="networksearch__displaydiv" id="networksearch__displaydiv" type="hidden" value="networksearch__1" />
        			</td>
        			<td class='hide-on-mobile' style="font-weight:bold;  width:50px;">Status</td>
        		</tr>
       			<tr>
          			<td colspan="2" style="padding:0px;">
          				<div id="paginationdiv__networksearch_list">
		  					<div id='networksearch__1'><?php $this->load->view('network/invite_list', array('networkList'=>$networkList, 'n'=>5)); ?></div>
          				</div>
 					</td>
        		</tr>
        		<tr>
          			<td colspan="2" style="text-align:center;">
          
						<div class='pagination' style="margin:0px;padding:0px;">
							<div id="networksearch" class="paginationdiv no-scroll">
								<div class="previousbtn" style='display:none;'>&#x25c4;</div>
								<div class="selected">1</div>
								<div class="nextbtn">&#x25ba;</div>
							</div>
							<input name="paginationdiv__networksearch_action" id="paginationdiv__networksearch_action" type="hidden" value="<?php echo base_url()."lists/load/t/invites";?>" />
							<input name="paginationdiv__networksearch_maxpages" id="paginationdiv__networksearch_maxpages" type="hidden" value="<?php echo NUM_OF_LISTS_PER_VIEW;?>" />
							<input name="paginationdiv__networksearch_noperlist" id="paginationdiv__networksearch_noperlist" type="hidden" value="5" />
							<input name="paginationdiv__networksearch_showdiv" id="paginationdiv__networksearch_showdiv" type="hidden" value="paginationdiv__networksearch_list" />
							<input name="paginationdiv__networksearch_extrafields" id="paginationdiv__networksearch_extrafields" type="hidden" value="networksearch=phrase" />
						</div>
          			</td>
          		</tr>
          	</table>
<?php }
else {
	echo format_notice($this, "WARNING: There are no invites made by this user.");
}?>
		</td>
	</tr>
</table>

<?php echo minify_js('network__my_invite_details', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.pagination.js', 'clout.network.js'));?>