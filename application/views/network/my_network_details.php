<table style="width:calc(100% - 20px); margin:10px;">
	<tr>
		<td class='center-all'>
			<table style="width:100%; border:none; padding:10px; margin-right: auto; margin-left: auto;">
        		<tr>
        			<td colspan="4" style="padding-bottom:0px;">
        				<span class="whiteheadertitle purple">Your Network</span>
        				<br>
						The last member joined your direct network <?php echo (!empty($pageStats['last_time_user_joined_my_direct_network'])?format_date_interval($pageStats['last_time_user_joined_my_direct_network'], '', FALSE, 'years'): '0 days');?> ago.
					</td>
				</tr>
				
				<tr>
					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_direct_referrals_in_my_network'],5);?>
								<br>
									<div class="networkbar purplebg first"></div>
									1st
								</td>
							</tr>
						</table>
					</td>

					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_2_referrals_in_my_network'],5);?>
								<br>
									<div class="networkbar purplebg second"></div>
									2nd
								</td>
							</tr>
						</table>
					</td>

					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_3_referrals_in_my_network'],5);?>
								<br>
									<div class="networkbar purplebg third"></div> 
									3rd
								</td>
							</tr>
						</table>
					</td>

					<td valign="bottom">
						<table style="margin-right: auto; margin-left: auto;">
							<tr>
								<td class="whiteheadertitle"><?php echo format_number($pageStats['total_level_4_referrals_in_my_network'],5);?>
								<br>
									<div class="networkbar purplebg fourth"></div> 
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
        				<input type="text" id="networksearch" data-type="network" name="networksearch" class='smalltextfield findfield' placeholder="Search.." style="min-width:70px;width:100%;" value="">
        				<input name="networksearch__action" id="networksearch__action" type="hidden" value="<?php echo base_url()."lists/load/t/network";?>" />
        				<input name="networksearch__displaydiv" id="networksearch__displaydiv" type="hidden" value="network__1" />
        			</td>
        			<td style="font-weight:bold;width:100px;">Last Activity</td>
        			<td style="font-weight:bold; width:60px;">Network</td>
        			<td style="font-weight:bold;  width:50px;">Invites</td>
        		</tr>
       			<tr>
          			<td colspan="4" style="padding:0px;">
          				<div id="paginationdiv__network_list">
		 					<div id='network__1'><?php $this->load->view('network/network_list', array('networkList'=>$networkList)); ?></div>
          				</div>
 					</td>
        		</tr>
       			
       			<tr>
          			<td colspan="4" style="text-align:center;">
          
						<div class='pagination' style="margin:0px;padding:0px;">
							<div id="network" class="paginationdiv no-scroll">
								<div class="previousbtn" style='display:none;'>&#x25c4;</div>
								<div class="selected">1</div>
								<div class="nextbtn">&#x25ba;</div>
							</div>
							<input name="paginationdiv__network_action" id="paginationdiv__network_action" type="hidden" value="<?php echo base_url()."lists/load/t/network";?>" />
							<input name="paginationdiv__network_maxpages" id="paginationdiv__network_maxpages" type="hidden" value="<?php echo NUM_OF_LISTS_PER_VIEW;?>" />
							<input name="paginationdiv__network_noperlist" id="paginationdiv__network_noperlist" type="hidden" value="5" />
							<input name="paginationdiv__network_showdiv" id="paginationdiv__network_showdiv" type="hidden" value="paginationdiv__network_list" />
							<input name="paginationdiv__network_extrafields" id="paginationdiv__network_extrafields" type="hidden" value="networksearch=phrase" />
						</div>
          			</td>
          		</tr>
          	</table>
<?php }
	else {
	echo format_notice($this, "WARNING: There are no network referrals for this user.");
}?>
		</td>
	</tr>
</table>