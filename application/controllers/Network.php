<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing message information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/23/2015
 */
class Network extends CI_Controller 
{
	# The network home
	function home()
	{
		log_message('debug', 'Network/home');
		check_access($this,'__redirect'); 
		
		$data = filter_forwarded_data($this);
		$statCodes = array('last_time_user_joined_my_direct_network', 'clout_score', 'total_users_in_my_network', 'total_direct_referrals_in_my_network', 'total_level_2_referrals_in_my_network', 'total_level_3_referrals_in_my_network', 'total_level_4_referrals_in_my_network', 'total_invites_in_my_network', 'total_earnings_in_my_network');
		# Collect relevant data for the page
		$data = array_merge($data, $this->get_my_network_details($statCodes, 'network/referrals', array('limit'=>5)));
		
		$data['userLinks'] = $this->_api->get('network/links');
		$this->load->view('network/home', $data);
	}
	
	# The business network home
	function business_network()
	{
		log_message('debug', 'Network/home');
		check_access($this,'__redirect');
	
		$data = filter_forwarded_data($this);
		$statCodes = array('last_time_user_joined_my_direct_network', 'clout_score', 'total_users_in_my_network', 'total_direct_referrals_in_my_network', 'total_level_2_referrals_in_my_network', 'total_level_3_referrals_in_my_network', 'total_level_4_referrals_in_my_network', 'total_invites_in_my_network', 'total_earnings_in_my_network');
		# Collect relevant data for the page
		$data = array_merge($data, $this->get_my_network_details($statCodes, 'network/referrals', array('limit'=>5)));
	
		$data['userLinks'] = $this->_api->get('network/links');
		
		# TODO: Add processing functionality for generating the button code here
		if(!empty($_POST)){
				
			# temporary
			$isSuccessful = TRUE;
			$codeString = "<textarea rows='16' cols='50' class='copyfield' readonly>
<!-- Load Clout VIP Button for JavaScript -->
<div id='clout-btn'></div>
<script>(function(d, s, id) {
  var js, cjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//plugins.clout.com/en_us/sdk.js';
  cjs.parentNode.insertBefore(js, cjs);
}(document, 'script', 'clout-jssdk'));</script>
		
<!-- Your VIP button code -->
<div class='share-btn long small'
    data-url='http://www.your-domain.com/vip-congs.html'
    data-appid='34Yasda1sdx8932H'
    data-action='redirect'>
</div></textarea>";
				
				
			if($isSuccessful) {
				echo $codeString;
			}
			# TODO: include all errors as inidicated in the Trello Card e.g., the user ID is invalid
			else {
				# a) invalid user ID
				if($invalidUserID) echo format_notice($this, "WARNING: You have entered an invalid user ID.");
				# b) referral URL does not belong to user ID
				else if($invalidReferralUrlMatch) echo format_notice($this, "WARNING: The referral URL provided does not belong to the Clout User ID");
				# c) invalid referral URL
				else if($invalidReferralUrl) echo format_notice($this, "WARNING: Invalid referral URL.");
				# everything has failed
				else echo format_notice($this, "ERROR: The button could not be generated. Please try again.");
			}
		}
		else {
			$data = load_page_labels('business_network', $data);
			$this->load->view('network/business_network', $data);
		}
		
	}
	
	
	
	
	# Get my network tab details
	function get_my_network_details($statCodes, $listType='', $values=array())
	{
		log_message('debug', 'Network/get_my_network_details');
		log_message('debug', 'Network/get_my_network_details:: [1] statCode='.json_encode($statCodes).' listType='.$listType.' values='.json_encode($values));
		$pageStats = $this->_api->get('score/details', array('type'=>'clout_score', 'codes'=>$statCodes));
		$list = !empty($listType)? $this->_api->get($listType, $values): array();
		log_message('debug', 'Network/get_my_network_details:: [2] list='.json_encode($list));
		
		return array('pageStats'=>$pageStats, 'networkList'=>$list);
	}
	
	
	
	
	# The my network section
	function my_network()
	{
		log_message('debug', 'Network/my_network');
		$statCodes = array('total_direct_referrals_in_my_network', 'total_level_2_referrals_in_my_network', 'total_level_3_referrals_in_my_network', 'total_level_4_referrals_in_my_network');
		
		$this->load->view('network/my_network_details', $this->get_my_network_details($statCodes, 'network/referrals', array('limit'=>5)));
	}
	
	
	
	
	# The my invites section
	function my_invites()
	{
		log_message('debug', 'Network/my_invites');
		$statCodes = array('last_time_invite_was_sent', 'total_invites_in_my_network', 'total_direct_invites_in_my_network', 'total_level_2_invites_in_my_network', 'total_level_3_invites_in_my_network', 'total_level_4_invites_in_my_network');
		
		$this->load->view('network/my_invites_details', $this->get_my_network_details($statCodes, 'network/invites', array('limit'=>5)));
	}
	
	
	
	
	# The my earnings section
	function my_earnings()
	{
		log_message('debug', 'Network/my_earnings');
		$statCodes = array('last_time_commission_was_earned', 'clout_score', 'my_current_commission', 'clout_score_level', 'clout_score_details', 'clout_score_breakdown', 'clout_score_key_description', 'score_level_data', 'total_earnings_in_my_network', 'total_direct_earnings_in_my_network', 'total_level_2_earnings_in_my_network', 'total_level_3_earnings_in_my_network', 'total_level_4_earnings_in_my_network', 'points_to_next_level');
		
		$this->load->view('network/my_earnings_details', $this->get_my_network_details($statCodes, ''));
	}







	# Import user contacts by IMAP
	function import_by_imap()
	{
		log_message('debug', 'Network/import_by_imap');
		$data = filter_forwarded_data($this);
		
		# Just submitted the email
		if(!empty($data['youremail'])){
			log_message('debug', 'Network/import_by_imap:: [1] !empty($data[\'youremail\'])');
			$data['getDetails'] = "Y";
			$data['yourEmail'] = restore_bad_chars($data['youremail']);
			
			# Check if the email address already has a known IMAP host, and request it if not
			$host = $this->_api->get('network/email_host', array('emailAddress'=> $data['yourEmail']));
			if(empty($host['host_url'])) $data['getHost'] = "Y";
			
			$this->load->view('network/import_from_email', $data);
		}
		
		
		
		# Has submitted the password to their email
		else if($this->input->post('yourpass')){
			log_message('debug', 'Network/import_by_imap:: [2] $this->input->post(\'yourpass\')');
			$response = $this->_api->get('network/import_contacts_from_email', array(
				'emailAddress'=>$_POST['youremail'], 
				'emailPassword'=>$_POST['yourpass'], 
				'emailHost'=>($this->input->post('emailhost')? $_POST['emailhost']: ''), 
				'hostPort'=>($this->input->post('hostPort')? $_POST['hostPort']: '') 
			));
			log_message('debug', 'Network/import_by_imap:: [3] response='.json_encode($response));
			# SUCCESS
			if(!empty($response['result']) && $response['result'] == 'SUCCESS') {
				if(!empty($response['contacts'])){
					$data['finalContactsList'] = $response['contacts'];
					$data['r'] = 'import_from_email';
					$this->load->view('network/invite_contacts', $data);
				}
				else {
					$data['msg'] = "WARNING: Sorry. There were no contacts resolved for import.";
					$this->load->view('network/import_from_email', $data);
				}
			} 
			# ERROR
			else {
				$data['msg'] = "ERROR: There was a problem connecting to your email account. <br>Check your email and password and try again. <br>If the problem persists, you may need to check with your email provider for details. <BR><BR>You may also be required to turn off two-step authentication to allow operation of this process.";
				$this->load->view('network/import_from_email', $data);
			}
		}
		
		
		
		else
		{
			$msg = get_session_msg($this);
			$data['msg'] = !empty($msg)? $msg: "ERROR: There was a problem processing the import";
			$this->load->view('network/import_from_email', $data);
		}
	}
	
	
	
	
	
	
	# Send invitations to the selected contacts
	function send_invitations()
	{
		log_message('debug', 'Network/send_invitations');
		
		$data = filter_forwarded_data($this);
		
		# clean out the owner's email or repeatitions
		if(!empty($_POST['contacts']))
		{
			$contacts = array();
			foreach($_POST['contacts'] AS $email){
				if(!in_array($email, $contacts) && $email != $this->native_session->get('__email_address')) {
					array_push($contacts, $email);
				}
			}
			
			$_POST['contacts'] = $contacts;
		}
		
		
		# Send the invitations
		if(!empty($_POST['contacts']))
		{
			log_message('debug', 'Network/send_invitations:: [1] contacts='.$_POST['contacts']);
			$response = $this->_api->post('network/send_invitations', array('emailList'=>$_POST['contacts'], 'baseUrl'=>base_url() )); 
			log_message('debug', 'Network/send_invitations:: [2] response='.$response);
			# Update the invitations number if successful
			$invites = $this->get_my_network_details(array('total_invites_in_my_network','total_direct_invites_in_my_network'), 'network/referrals');
			log_message('debug', 'Network/send_invitations:: [3] invites='.json_encode($invites));
			$data['invitationCount'] = !empty($invites['pageStats']['total_invites_in_my_network'])? $invites['pageStats']['total_invites_in_my_network']: 0;
			log_message('debug', 'Network/send_invitations:: [4] data[invitationCount]='.$data['invitationCount']);
			$data['directInvitationCount'] = !empty($invites['pageStats']['total_direct_invites_in_my_network'])? $invites['pageStats']['total_direct_invites_in_my_network']: 0;
			log_message('debug', 'Network/send_invitations:: [5] data[directInvitationCount]='.$data['directInvitationCount']);
			
			$data['msg'] = !empty($response['msg'])? $response['msg']: (!empty($response['result']) && $response['result'] == 'SUCCESS'? "Your invitations have been sent.": "ERROR: There was a problem sending your invitations.");
			log_message('debug', 'Network/send_invitations:: [6] data[msg]='.$data['msg']);
			
			$this->native_session->set('__direct_invitation_count',$data['directInvitationCount']);
			
			# Determine if there were any problems worth reporting and append the email details
			$addMsg = '';
			if(!empty($response['per_email'])){
				foreach($response['per_email'] AS $email=>$msg) if($msg != 'message sent') $addMsg .= $email.'='.$msg.', ';
			}
			if($addMsg != '') $data['msg'] .= ' for: '.trim($addMsg, ', ');
			
			log_message('debug', 'Network/send_invitations:: [7] MINIMUM_INVITE_COUNT='.MINIMUM_INVITE_COUNT);
			
			# apply the user's true permission group based on the system rules
			if($data['directInvitationCount'] >= MINIMUM_INVITE_COUNT && $this->native_session->get('__user_type') == 'random_shopper'){
				$applyGroup = $this->_api->post('account/apply_default_group'); 
				log_message('debug', 'Network/send_invitations:: [8] $applyGroup='.json_encode($applyGroup));
				if(!empty($applyGroup['result']) && $applyGroup['result'] == 'SUCCESS'){
					log_message('debug', 'Network/send_invitations:: [8] $apply group successful');
					$this->native_session->set('__permissions', $applyGroup['user_permissions']);
					$this->native_session->set('__user_type', $applyGroup['user_type']);
					$this->native_session->set('__default_view', $applyGroup['default_view']);
				}
			}
			
			# if user invited less than MINIMUM_INVITE_COUNT
			else {
				echo " You have invited ".$data['directInvitationCount']." friend"
						.($data['directInvitationCount'] == '1'?'':'s')
						." so far.";
						
				if(!empty($addMsg)) echo "<br>Less ".count($response['per_email']).' for: '.trim($addMsg, ', ');
			}
			
		}
		else $data['msg'] = "WARNING: No contacts could be resolved. No invitations were sent out.";
		
		
		# Determine where to go after sending the invitation emails
		# redirection processing is done by external functionality (e.g., jQuery)
		if(!empty($data['t']) && $data['t'] == 'external')
		{
			if(!(!empty($response['result']) && $response['result'] == 'SUCCESS')) $this->native_session->set('msg', $data['msg']);
		}
		# redirection processing is done by internal functionality (e.g., jQuery)
		else {
			if(!empty($data['t']) && $data['t'] == 'internal')
			{
				$this->load->view('network/'.$data['r'], $data);
			}
			# Coming from a popup
			else
			{
				$this->native_session->set('msg', $data['msg']);
				echo "<script>window.opener.location.href='".base_url()."network/home';window.close();</script>";
			}
		}
		
	}
	
	
	
	
	
	
	



	# Import user contacts by file
	function import_by_file()
	{
		log_message('debug', 'Network/import_by_file');
		$data = filter_forwarded_data($this);
		
		# Just submitted the email
		if(!empty($_POST['file__csvformats'])){
			
			log_message('debug', 'Network/import_by_file:: [1] !empty($_POST[\'file__csvformats\'])');
			$fileUrl = upload_temp_file($_FILES, 'importfromfile__fileurl', 'csv_', 'csv');
			
			if(!empty($fileUrl)){
				$response = $this->_api->get('network/import_contacts_from_file', array(
					'fileFormat'=>$_POST['file__csvformats'], 
					'csvFile'=>base_url().'assets/uploads/temp/'.$fileUrl
				));
			}
			
			#Remove the temp file now that we are done with it
			if(file_exists(UPLOAD_DIRECTORY.'temp/'.$fileUrl)) @unlink(UPLOAD_DIRECTORY.'temp/'.$fileUrl);
			
			if(!empty($response['contacts'])) {
				$data['finalContactsList'] = $response['contacts'];
				$data['r'] = 'import_from_file';
				$this->load->view('network/invite_contacts', $data);
			} 
			# Could not get the contacts
			else {
				$data['msg'] = !empty($msg)? $msg: "ERROR: There was a problem processing the import";
				$this->load->view('network/import_from_file', $data);
			}
		}
		
		
		
		else
		{
			$msg = get_session_msg($this);
			
			$data['msg'] = !empty($msg)? $msg: "ERROR: There was a problem processing the import";
			$this->load->view('network/import_from_file', $data);
		}
	
	}
	
	
	



	# Add a share link
	function share_your_link()
	{
		log_message('debug', 'Network/share_your_link');
		$data = filter_forwarded_data($this);
		$data['userLinks'] = $this->_api->post('network/share_link');
		
		$this->load->view('network/share_your_link', $data);
	}
	
	
	



	# Invite new users to the system
	function invite()
	{
		log_message('debug', 'Network/invite');
		check_access($this,'__redirect'); 
		
		$data = filter_forwarded_data($this);
		
		$invites = $this->get_my_network_details(array('total_direct_invites_in_my_network'), 'network/referrals');
		$data['directInvitationCount'] = !empty($invites['pageStats']['total_direct_invites_in_my_network'])? $invites['pageStats']['total_direct_invites_in_my_network']: 0;
		
		$data = load_page_labels('invite_five', $data);
		$this->load->view('network/invite_five', $data);
	}
	


	
	
	
	# make a custom link
	function custom_link()
	{
		log_message('debug', 'Network/custom_link');
		$data = filter_forwarded_data($this);
		
		# user has posted a new custom referral code
		if(!empty($_POST['new_code'])){
			log_message('debug', 'Network/custom_link:: [1] !empty($_POST[\'new_code\'])');
			$response = $this->_api->post('network/referral_code', array('newCode'=>$_POST['new_code']));
			$data['msg'] = !empty($response['boolean']) && $response['boolean']? 'The referral code has been added': 'ERROR: The referral code could not be added';
			
			$data['userLinks'] = $this->_api->get('network/links');
			$this->load->view('network/share_your_link', $data);
		}
		
		# check whether a custom referral code is valid
		else if(!empty($_POST['check_value'])){
			$response = $this->_api->get('network/referral_code', array('checkCode'=>$_POST['check_value']));
			echo !empty($response['boolean']) && $response['boolean']? 'VALID': 'INVALID';
		}
		
		# just viewing the link form
		else $this->load->view('network/custom_link', $data);
	}
	
	
	
	
	# list emails invited by this user
	function invited_emails()
	{
		log_message('debug', 'Network/invited_emails');
		$data = filter_forwarded_data($this);
		$data['invites'] = $this->_api->get('network/invites');
		
		$this->load->view('network/invited_emails', $data);
	}
	
	
	
	
}

/* End of controller file */