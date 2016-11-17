<?php 
$this->load->view('addons/shadow_page_header', array(
	'title'=>'Send Message', 
	'sub_title'=>(!empty($users)? count($users).' Users Selected':''),
	'css'=>array('jquery-ui.css','clout.form.css','clout.date-picker.css','trumbowyg.css')
));
?>
<div class='body-form-area microform ignoreclear'>
	<div id='send_result_div'></div>
	<table>
		<tr>
			<td class='label'>Message</td>
			<td>
				<table class='default-table'>
					<tr>
						<td style='width:1%;'>
							<input id='usetemplate_n' name='usetemplate_radio' type='radio' 
									onclick="addClass('message__messagetemplates','optional');universalUpdate('usetemplate', 'N');" value='N' checked="checked"/>
						</td>
						<td style='padding-right:50px;width:1%;'><label for='usetemplate_n'>New</label></td>
						<td style='width:1%;'>
							<input id='usetemplate_y' name='usetemplate_radio' type='radio' 
									onclick="removeClass('message__messagetemplates','optional');universalUpdate('usetemplate', 'Y');" value='Y' />
						</td>
						<td style='width:1%; white-space:nowrap;'><label for='usetemplate_y'>Choose Template</label></td>
						<td>
							<input type='text' id='message__messagetemplates' name='message__messagetemplates' 
									onclick="clickItem('usetemplate_y');" placeholder='Search or Select Template' 
									class='searchable drop-down clear-on-empty optional' style='width:calc(100% - 25px);' 
									data-clearfield='template_id' />
							<input type='hidden' id='template_id' name='template_id' value='' />
							<input type='hidden' id='usetemplate' name='usetemplate' value='N' />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td class='label'>Send To</td>
			<td>
				<table class='default-table'>
					<tr>
						<td style='width:1%;'>
							<input id='sendto_list' name='sendto_radio' type='radio' value='list' 
							onclick="addClass('message__recipientfilters','optional');showLayerSet('recipient_list_div');universalUpdate('sendto', 'list');" 
							<?php if(!empty($users)) echo " checked";?>/>
						</td>
						<td style='padding-right:20px;width:1%; white-space:nowrap;'>
							<label for='sendto_list'>Selected List (below)</label>
						</td>
						<td style='width:1%;width:1%;'>
							<input id='sendto_filter' name='sendto_radio' type='radio' 
							onclick="removeClass('message__recipientfilters','optional');universalUpdate('sendto', 'filter');" 
							value='filter' <?php if(empty($users)) echo " checked";?>/>
						</td>
						<td style='width:1%;'>
							<label for='sendto_filter'>Filter</label>
						</td>
						<td>
							<select id='message__recipientfilters' name='message__recipientfilters' 
									onchange="clickItem('sendto_filter');hideLayerSet('recipient_list_div');" class='optional' style='width:calc(100% + 13px);'>
									<?php echo get_option_list($this, 'recipientfilters');?>
							</select>
							<input type='hidden' id='sendto' name='sendto' value='<?php echo !empty($users)? 'list':'filter';?>' />
						</td>
					</tr>
					<tr>
						<td colspan='5'>
							<?php if(!empty($users)){
									echo "<div id='recipient_list_div' class='textfield mocktextfield' style='border:0px;'>";
									foreach($users AS $row){
										echo "<div class='listdivs'>"
										.html_entity_decode($row['first_name'].' '.$row['last_name'].' ('.$row['email_address'].')', ENT_QUOTES)
										."<input type='hidden' id='recipients_".$row['user_id']."' name='recipients[".$row['user_id']."]' value='".$row['user_id']."'>
										</div>";
									}
									echo "</div>";
								} else echo "<div id='recipient_list_div'></div>";
							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td class='label'>Subject</td>
			<td><input type='text' id='subject' name='subject' style='width:calc(100% - 16px);'  /></td>
		</tr>
		
		<tr>
			<td class='label'>Body</td>
			<td><textarea id='body' name='body' class='htmlfield'></textarea></td>
		</tr>
		
		<tr>
			<td class='label'>Text Message</td>
			<td>
				<textarea id='sms' name='sms' class='limit-chars optional' data-max='150' style='height:80px; width:calc(100% - 16px);'></textarea>
				<br /><span class='h6'>Max:150 Characters</span>
			</td>
		</tr>
		
		<tr>
			<td class='label'>Attachment</td>
			<td>
				<input type='text' id='attachment' name='attachment' placeholder="Optional" class='filefield optional' 
						data-size='9000' data-val='jpg,jpeg,gif,png,tiff,doc,docx,pdf,xls,xlsx' style='width:calc(100% - 16px) !important;' />
				<br /><span class='h6'>Max:9MB, &nbsp; &nbsp; Allowed: jpg, jpeg, gif, png, tiff, doc, docx, pdf, xls, xlsx</span>
				<input type='hidden' id='template_attachment' name='template_attachment' value='' />
			</td>
		</tr>
		
		<tr>
			<td class='label'>Save</td>
			<td>
				<table class='default-table'>
					<tr>
						<td style='width:1%;'>
							<input id='savetemplate_n' name='savetemplate_radio' onclick="addClass('savetemplatename','optional');universalUpdate('savetemplate', 'N');" 
									type='radio' value='N' checked="checked"/>
						</td>
						<td style='padding-right:20px;width:1%;'>
							<label for='savetemplate_n'>No</label>
						</td>
						<td style='width:1%;width:1%;'>
							<input id='savetemplate_y' name='savetemplate_radio' onclick="removeClass('savetemplatename','optional');universalUpdate('savetemplate', 'Y');" 
									type='radio' value='Y' />
						</td>
						<td style='width:1%;'>
							<label for='savetemplate_y'>Yes</label>
						</td>
						<td>
							<input type='text' id='savetemplatename' name='savetemplatename' class='textfield optional' onchange="clickItem('savetemplate_y')" 
									placeholder="Template Name" style='width:calc(100% - 9px);' />
							<input type='hidden' id='savetemplate' name='savetemplate' value='N' />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td class='label'>Send When?</td>
			<td>
				<input type='text' id='senddate' name='senddate' class='calendar showtime clickactivated future-date' 
						style='width: calc(100% - 17px);' placeholder="Select Date/Time" />
			</td>
		</tr>
		
		<tr>
			<td class='label'>Methods</td>
			<td>
				<table class='default-table'>
					<tr>
						<td>
							<input id='system_method' name='methods[0]' type='checkbox' value='system' class='bigcheckbox' checked="checked">
							<label for='system_method'></label>
						</td>
						<td style='padding-right:20px;'>System Message</td>
						<td>
							<input id='email_method' name='methods[1]' type='checkbox' value='email' class='bigcheckbox'>
							<label for='email_method'></label>
						</td>
						<td style='padding-right:20px;'>Email</td>
						<td>
							<input id='sms_method' name='methods[2]' type='checkbox' value='sms' onchange="assignClassOnCheck('sms_method', 'sms', 'optional',true)" 
									class='bigcheckbox'>
							<label for='sms_method'></label>
						</td>
						<td>Text Message</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td style='padding-top:30px;padding-bottom:50px;'>
				<button type="button" id="save" name="save" class="btn green submitmicrobtn" style='width:100%;'>Schedule Message</button>
		    	<input type='hidden' id='action' name='action' value='<?php echo base_url().'message/add';?>' />
		    	<input type='hidden' id='resultsdiv' name='resultsdiv' value='' />
		    	<input type='hidden' id='redirectaction' name='redirectaction' value='<?php echo base_url().'message/add/a/confirm';?>' />
		    </td>
		</tr>
	</table>
</div>
<?php
$this->load->view('addons/shadow_page_footer', array('page'=>'message__add_new', 'js'=>array('jquery-ui.js', 'jquery-ui-timepicker-addon.js', 'jquery.datepick.js', 'clout.datepicker.js', 'trumbowyg.js', 'clout.network.js')));
?>