<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing account information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/17/2015
 */
class Account extends CI_Controller
{

	# The system dashboard to redirect to the user's dashboard
	function dashboard()
	{
		log_message('debug', 'Account/dashboard');

		$data = filter_forwarded_data($this);

		# If switching users, automatically logout one account, log into another linked account
		if(!empty($data['u'])){
			log_message('debug', 'Account/dashboard:: [1] !empty($data[\'u\'])='.!empty($data['u']));
			$userDetails = $this->_api->get('account/switch_users', array('currentUserId'=>$this->native_session->get('__user_id'),'desiredUserId'=>$data['u']));
			log_message('debug', 'Account/dashboard:: [2] userDetails='.json_encode($userDetails));
			if(!empty($userDetails)) populateSessionArray($userDetails);
			else $this->native_session->set('msg', "ERROR: The details for the selected user could not be resolved.");
		}

		redirect(get_user_dashboard($this));
	}



	# The admin dashboard
	function admin_dashboard()
	{
		log_message('debug', 'Account/admin_dashboard');
		$data = filter_forwarded_data($this);
		$this->set_unread_count();
		$this->load->view('account/admin_dashboard', $data);
	}


	# The store owner dashboard
	function store_owner_dashboard()
	{
		log_message('debug', 'Account/store_owner_dashboard');
		$data = filter_forwarded_data($this);
		$this->set_unread_count();
		$this->load->view('account/store_owner_dashboard', $data);
	}



	# The shopper dashboard
	function shopper_dashboard()
	{
		log_message('debug', 'Account/shopper_dashboard');
		$data = filter_forwarded_data($this);
		$this->set_unread_count();
		redirect(base_url().'search/home');
	}


	# User Settings
	function settings()
	{
		log_message('debug', 'Account/settings');
		$data = filter_forwarded_data($this);

		log_message('debug', 'Account/dashboard:: [1] !empty($data[\'a\'])='.!empty($data['a']));
		# Updating the user photo
		if(!empty($data['a']) && $data['a'] == 'user_photo'){
			if(!empty($_FILES)) $fileUrl = upload_temp_file($_FILES, 'settingphotourl__fileurl', 'user_', 'jpg,jpeg,gif,png,tiff');
			if(!empty($fileUrl)){
				$result = $this->_api->post('user/photo', array(
					'photo'=>base_url().'assets/uploads/temp/'.$fileUrl
				));

				if(!empty($result['result']) && $result['result']=='SUCCESS') {
					# Update the user session profile photo
					$this->native_session->set('__photo_url',$result['photo_url']);
				}
			}

			#Remove the temp file now that we are done with it
			if(!empty($fileUrl) && file_exists(UPLOAD_DIRECTORY.'temp/'.$fileUrl)) @unlink(UPLOAD_DIRECTORY.'temp/'.$fileUrl);
		}


		# Updating the user password
		else if(!empty($data['a']) && $data['a'] == 'new_password'){
			if(!empty($_POST['newpassword'])) $result = $this->_api->post('user/password', array('password'=>encrypt_value($_POST['newpassword']) ));

			echo format_notice($this, (!empty($result['result']) && $result['result']=='SUCCESS'? 'Your password has been successfully updated': 'ERROR: The password could not be updated'));
		}


		# Adding an address
		else if(!empty($data['a']) && $data['a'] == 'add_address'){
			if(!empty($_POST['addressline1'])) $result = $this->_api->post('user/address', array(
				'addressLine1'=>$_POST['addressline1'],
				'addressLine2'=>$_POST['addressline2'],
				'city'=>$_POST['city'],
				'state'=>$_POST['state__states'],
				'country'=>$_POST['country__countries'],
				'zipcode'=>$_POST['zipcode']
				));

			$data['msg'] = (!empty($result['result']) && $result['result']=='SUCCESS'? 'Your new address was successfully added': 'ERROR: The new address could not be added');
			$addresses = $this->_api->get('user/settings', array('fields'=>'savedAddresses'));
			$data['savedAddresses'] = $addresses['savedAddresses'];
			$this->load->view('account/saved_addresses', $data);
		}


		# Updating the address type
		else if(!empty($data['a']) && $data['a'] == 'update_address_type'){
			$fieldId = "address_".$data['i']."__addresstypes";

			if(!empty($data[$fieldId])) $result = $this->_api->post('user/address_type', array(
				'contactId'=>$data['i'],
				'addressType'=>$data[$fieldId]
				));

			echo format_notice($this, (!empty($result['result']) && $result['result']=='SUCCESS'? 'Your address was successfully updated': 'ERROR: The address could not be updated'));
		}


		# Deactivating an address
		else if(!empty($data['a']) && $data['a'] == 'deactivate_address'){

			if(!empty($_POST['item_id'])) $result = $this->_api->post('user/remove_address', array(
				'contactId'=>$_POST['item_id']
				));

			echo format_notice($this, (!empty($result['result']) && $result['result']=='SUCCESS'? 'Your address was successfully removed': 'ERROR: The address could not be removed'));
		}


		# Update communication privacy
		else if(!empty($data['a']) && $data['a'] == 'update_privacy'){
			$result = $this->_api->post('user/communication_privacy', array(
				'method'=>$data['t'],
				'methodValue'=>(!empty($_POST['data']['value'])? 'all':'')
				));

			echo $result['result'];
		}


		# Add email address
		else if(!empty($data['a']) && ($data['a'] == 'add_email' || $data['a'] == 'activate_contact' && $data['t'] == 'email')){
			if($data['a'] == 'add_email') {
				$result = $this->_api->post('user/email_address', array('emailAddress'=>$_POST['newemail']));
				$successMsg = 'Your new email was successfully added';
				$failMsg = 'ERROR: The new email could not be added';
			} else if($data['a'] == 'activate_contact'){
				$result = $this->_api->post('user/activate_email_address', array('contactId'=>$data['d'],'code'=>$_POST['data']['value']));
				$successMsg = 'Your email address has been activated';
				$failMsg = 'ERROR: The email address could not be activated';
			}

			$data['msg'] = (!empty($result['result']) && $result['result']=='SUCCESS'? $successMsg: $failMsg);
			$addresses = $this->_api->get('user/settings', array('fields'=>'savedEmails'));
			$data['savedEmails'] = $addresses['savedEmails'];
			$this->load->view('account/saved_emails', $data);
		}

		# Add telephone
		else if(!empty($data['a']) && ($data['a'] == 'add_telephone' || $data['a'] == 'activate_contact' && $data['t'] == 'phone')){
			if($data['a'] == 'add_telephone') {
				$result = $this->_api->post('user/telephone', array('telephone'=>$_POST['newtelephone'],'provider'=>$_POST['provider__provider']));
				$successMsg = 'Your new telephone was successfully added';
				$failMsg = 'ERROR: The new telephone could not be added';
			} else if($data['a'] == 'activate_contact'){
				$result = $this->_api->post('user/activate_telephone', array('contactId'=>$data['d'],'code'=>$_POST['data']['value']));
				$successMsg = 'Your telephone has been activated';
				$failMsg = 'ERROR: The telephone could not be activated';
			}

			$data['msg'] = (!empty($result['result']) && $result['result']=='SUCCESS'? $successMsg: $failMsg);
			$addresses = $this->_api->get('user/settings', array('fields'=>'savedPhones'));
			$data['savedPhones'] = $addresses['savedPhones'];
			$this->load->view('account/saved_phones', $data);
		}



		# Normal whole settings page load
		else {
			$data['settings'] = $this->_api->get('user/settings', array('fields'=>'name,gender,photo,birthday,emailAddress,telephone,addressLine1,addressLine2,city,state,country,zipcode,dateJoined,passwordLastUpdated,savedAddresses,savedEmails,savedPhones,notificationPreferences'));

			$this->load->view('account/settings', $data);
		}
	}



	# Set unread message count
	function set_unread_count()
	{
		log_message('debug', 'Account/set_unread_count');
		$unread = $this->_api->get('message/statistics', array('fields'=>'unread'));
		log_message('debug', 'Account/set_unread_count:: [1] unread='.json_encode($unread));
		if(!empty($unread['unread'])) $this->native_session->set('__unread_count', $unread['unread']);
	}


	# Login page
	function login()
	{
		log_message('debug', 'Account/login');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Account/login:: [1] post='.json_encode(array_diff_key($_POST, array('loginpassword'=>''))));
		# The user wants to proceed to login
		if(!empty($_POST)){
			# Track user location if they opted in through the browser
			if(!empty($_POST['latitude'])) $this->native_session->set('__latitude', $_POST['latitude']);
			if(!empty($_POST['longitude'])) $this->native_session->set('__longitude', $_POST['longitude']);
				$response = $this->_api->post('account/login', array(
					'userName'=>$_POST['loginusername'],
					'password'=>$_POST['loginpassword'],
					'uri'=>uri_string()
				));



				# Proceed based on the login response from the API
				if(!empty($response['result']) && $response['result'] == 'SUCCESS' && !empty($response['default_view'])) {
					add_to_user_session($this, $response['user_details']);
					$this->native_session->set('__permissions', $response['permissions']);
					$this->native_session->set('__user_type', $response['user_type']);
					$this->native_session->set('__default_view', $response['default_view']);
					# is this a shopper and can login?
					if(check_access($this,'can_login')
						&& in_array($response['user_type'], array('invited_shopper','random_shopper'))
					){
						# has already linked an account
						if(!empty($response['user_details']['has_linked_accounts'])
							&& $response['user_details']['has_linked_accounts'] == 'Y'
						){
							# has already verified their phone
							if($response['user_details']['telephone_verified'] == 'Y') {
								# has invited the minimum required users
								if(!empty($response['user_details']['direct_invitation_count'])
									&&  $response['user_details']['direct_invitation_count'] >= MINIMUM_INVITE_COUNT
								){
									$view = check_access($this,'can_view_invite_tools') && $response['default_view'] == 'account/thank_you'? 'network/home': $response['default_view'];
								}
								else $view = 'network/invite';
							}
							else $view = 'account/update_user_phone';
						}
						else $view = 'account/list_banks';

						redirect(($this->native_session->get('__redirect')? $this->native_session->get('__redirect'): base_url().$view));

					}

					# other non-shopper user types
					else if(check_access($this,'can_login'))
					{

						redirect(($this->native_session->get('__redirect')? $this->native_session->get('__redirect'): base_url().$response['default_view']));
					}

					# SORRY: Can not login - access revoked from user group
					else {
						$this->native_session->set('msg','WARNING: Your login privileges were removed. <br>Please use the contact us form if you believe this was done in error.');
						redirect(base_url().'account/log_out');
					}
				}
				# incorrect password
				else $data['msg'] = "ERROR: The user name and password do not match a registered user. Please check and try again.";
		}

		# destroy any session variables if the user is just coming to the page
		else {
			if($this->native_session->get('msg')) $data['msg'] = $this->native_session->get('msg');
			$restoreSessionVars = restore_session_variables($this, array('__store_id', '__redirect'));
			clear_user_session($this);
			add_to_user_session($this, $restoreSessionVars);
		}

		$data = load_page_labels('login', $data);
		$this->load->view('account/login', $data);
	}



	# Log out page
	function log_out()
	{
		log_message('debug', 'Account/log_out');
		$data = filter_forwarded_data($this);
		# notify the back end that this user has logged out
		$response = $this->_api->post('account/logout', array('uri'=>uri_string() ));
		log_message('debug', 'Account/log_out:: [1] response='.$response);
		# pick any custom logout message if given
		$data['msg'] = get_session_msg($this);
		if(empty($data['msg'])) $data['msg'] = "You have logged out";
		# destroy any session variables
		clear_user_session($this);

		# finally, display the login page
		$data = load_page_labels('login', $data);
		$this->load->view('account/login', $data);
	}







	# Sign Up page
	function sign_up()
	{
		log_message('debug', 'Account/sign_up');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Account/sign_up:: [1] post='.json_encode(array_diff_key($_POST, array('loginpassword'=>''))));

		if(!empty($_POST))
		{
			# post the user data
			$result = $this->_api->post('account/add', array(
				'firstName'=>$_POST['firstname'],
				'lastName'=>$_POST['lastname'],
				'emailAddress'=>$_POST['emailaddress'],
				'emailVerified'=>$_POST['emailverified'],
				'password'=>$_POST['newpassword'],
				'telephone'=>$_POST['mobilephone'],
				'provider'=>$_POST['provider__provider'],
				'gender'=>$_POST['gender__gender'],
				'zipcode'=>$_POST['zipcode'],
				'facebookId'=>$_POST['facebookid'],
				'birthDate'=>$_POST['birthmonth__monthnumber'].'/'.$_POST['birthday__monthday'].'/'.$_POST['birthyear__pastyear'],
				'reffererId'=>($this->native_session->get('referrer_id')? $this->native_session->get('referrer_id'): ''),
				'baseLink'=>BASE_URL
			));

			if(!empty($result['result']) && $result['result'] == 'SUCCESS' && !empty($result['new_user_id']))
			{
				$this->native_session->set('__user_id', $result['new_user_id']);
				$this->native_session->set('__email_address', $_POST['emailaddress']);
				$this->native_session->set('__telephone', $_POST['mobilephone']);
				$this->native_session->set('__provider_id', $_POST['provider__provider']);
				$this->native_session->set('__email_verified', $result['email_verified']);

				if(!empty($result['email_verified']) && $result['email_verified']=='Y'){
					$this->native_session->set('__facebook_msg', 'Your Clout score just increased 40 points for verifying your email and connecting Facebook.<br>Login to continue.');
				} else {
					$this->native_session->set('msg', 'A verification link has been sent to '.$_POST['emailaddress'].'. <br>Please click the link to sign in.');
				}
			}
			else {
				echo "ERROR: ".(!empty($result['reason'])? $result['reason']: 'We could not submit your application.');
			}
		}
		else
		{
			# Set the referrer ID if this user was referred
			$data = filter_forwarded_data($this, array(), array(), 1);
			if(!empty($data['r'])) $this->native_session->set('referrer_id', extract_id($data['r']));

			$data = load_page_labels('sign_up', $data);
			$this->load->view('account/sign_up', $data);
		}
	}



	# Link your bank card
	function link_card()
	{
		log_message('debug', 'Account/link_card');
		$data = filter_forwarded_data($this);
		$data['featuredBanks'] = $this->_api->get('money/banks', array('offset'=>0, 'limit'=>'10', 'isFeatured'=>'Y'));

		$data = load_page_labels('link_card', $data);
		$this->load->view('account/link_card', $data);
	}



	# Link your bank in a page
	function link_card_in_page()
	{
		log_message('debug', 'Account/link_card_in_page');
		$data = filter_forwarded_data($this);
		$data['featuredBanks'] = $this->_api->get('money/banks', array('offset'=>0, 'limit'=>'10', 'isFeatured'=>'Y'));
		$this->native_session->set('link_in_page','Y');
		$this->load->view('account/choose_bank', $data);
	}







	# Show bank login
	function show_bank_login()
	{
		log_message('debug', 'Account/show_bank_login');
		$data = filter_forwarded_data($this);

		if(!empty($data['n'])) $this->native_session->set('login_institution', decrypt_value($data['n']));
		if(!empty($data['i'])) $this->native_session->set('login_institution_id', decrypt_value($data['i']));
		if(!empty($data['c'])) $this->native_session->set('login_institution_code', decrypt_value($data['c']));

		if($this->native_session->get('login_institution_id')) {
			$institutionDetails = $this->_api->get('money/bank', array('bankId'=>$this->native_session->get('login_institution_id') , 'fields'=>'logo_url' ));
			if(!empty($institutionDetails['logo_url'])) {
				$this->native_session->set('login_institution_logo', $institutionDetails['logo_url']);
			}
			# Remove old logo if adding another account
			else if($this->native_session->get('login_institution_logo')) {
				$this->native_session->delete('login_institution_logo');
			}
		}

		$data['area'] = "login_form";
		$this->load->view('account/bank_forms', $data);
	}





	# Post data to the bank API
	function post_to_bank_api()
	{
		log_message('debug', 'Account/post_to_bank_api');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Account/post_to_bank_api:: [1] !empty($data[\'a\'])='.!empty($data['a']));
		# Processing bank form POST
		# ------------------------------------------------------
		# a) API required extra information after login
		if(!empty($data['a']) && ($data['a'] == 'display_question' || $data['a'] == 'display_code'))
		{
			$credentials['mfa'] = $_POST['questionanswer'];
			$postData = array('bank_id'=>$this->native_session->get('login_institution_id'), 'email_address'=>$this->native_session->get('__email_address'));
		}
		# b) API requested to choose a delivery option for a code after login
		else if(!empty($data['a']) && $data['a'] == 'display_options')
		{
			$credentials['mfa'] = $_POST['questionanswer'];
			$credentials['send_method'] = $_POST['questionanswer'];
			$postData = array('bank_id'=>$this->native_session->get('login_institution_id'), 'email_address'=>$this->native_session->get('__email_address'));

		}
		# c) API returned an error after login or first time logging in
		else
		{
			$credentials['user_name'] = $_POST['username'];
			$credentials['password'] = $_POST['bankpassword'];
			if(!empty($_POST['bankpin'])) $credentials['bank_pin'] = $_POST['bankpin'];
			$postData = array('bank_id'=>$this->native_session->get('login_institution_id'), 'email_address'=>$this->native_session->get('__email_address'));
		}

		# Connect to bank with details
		$data['response'] = $this->_api->post('money/connect_to_bank', array('credentials'=>$credentials, 'postData'=>$postData ));

		# Was there a successful connection? Then get the user's current banks
		if(!empty($data['response']['accounts']))
		{
			$data['currentBanks'] = $this->_api->get('money/current_user_banks');
		}

		# Determine which area to show based on response
		if(!empty($data['a'])) unset($data['a']);
		$this->native_session->set('__data', $data);
		echo base_url().'account/load_bank_form/a/'.$this->which_bank_view($data['response']);
	}




	# Load the bank form
	function load_bank_form()
	{
		log_message('debug', 'Account/load_bank_form');
		$data = filter_forwarded_data($this);

		if($this->native_session->get('__data')) $data = array_merge($data, $this->native_session->get('__data'));
		$data['area'] = !empty($data['a'])? $data['a']: 'login_form';
		if(empty($data['response'])) $data['response']['resolve'] = 'ERROR: No response was received from your bank. <br>Please notify us about this error so that we can follow up.';

		$this->load->view('account/bank_forms', $data);
	}




	# Determine which view area to show based on a response from the bank API
	function which_bank_view($response)
	{
		log_message('debug', 'Account/which_bank_view');
		if(!empty($response['type']) && $response['type'] == 'questions' && !empty($response['mfa'])) return 'mfa_answer';
		else if(!empty($response['type']) && $response['type'] == 'list' && !empty($response['mfa'])) return 'choose_code_delivery';
		else if(!empty($response['type']) && $response['type'] == 'device' && !empty($response['mfa']['message'])) return 'verification_code';
		else if(!empty($response['accounts'])) return 'user_bank_list';
		else return 'login_form';
	}





	# Verify Code
	function verify_code()
	{
		log_message('debug', 'Account/verify_code');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Account/verify_code:: [1] post='.json_encode($_POST));
		#The user has posted the code for verification
		if(!empty($_POST)){

			# Verifying phone number
			if(!empty($_POST['usercode'])){
				$response = $this->_api->post('account/verify', array(
					'code'=>$_POST['usercode'],
					'telephone'=>$this->native_session->get('__telephone'),
					'baseLink'=>base_url()
				));

				if(!empty($response['verified']) && $response['verified']=='Y'){
					$data = load_page_labels('verify_email');
					$data['msg'] = 'Your phone has been verified';
					$this->load->view('account/verify_email', $data);
				}
				else {
					$data['msg'] = 'ERROR: Your phone could not be verified.<br>Please try again.';
					$data = load_page_labels('verify_phone',$data);
					$this->load->view('account/verify_phone', $data);
				}
			}

			# Verifying email address
			else if(!empty($_POST['emailaddress'])){
				$response = $this->_api->post('account/resend_link', array(
					'emailAddress'=>$this->native_session->get('__email_address'),
					'baseLink'=>base_url()
				));

				$data['msg'] = (!empty($response['result']) && $response['result']=='SUCCESS')?'The verification link has been resent':'ERROR: The verification link could not be resent';
				$data = load_page_labels('verify_email',$data);
				$this->load->view('account/verify_email', $data);
			}

		}

		# Default verify-code page load
		else {
			$data = load_page_labels('verify_code', $data);
			$data['phoneAreaLabels'] = load_page_labels('verify_phone');
			$this->load->view('account/verify_code', $data);
		}
	}






	# Load Verify Email Form
	function verify_email()
	{
		log_message('debug', 'Account/verify_email');
		$data = filter_forwarded_data($this);
		$data['msg'] = get_session_msg($this);
		log_message('debug', 'Account/verify_email:: [1] post='.json_encode($_POST));
		# skip this step if the user has already verified their email address
		if($this->native_session->get('__email_verified') && $this->native_session->get('__email_verified') == 'Y'){
			redirect(base_url().'account/login');
		}

		# otherwise continue here
		if(!empty($_POST['emailaddress'])){
			$response = $this->_api->post('account/resend_link', array(
				'emailAddress'=>$this->native_session->get('__email_address'),
				'baseLink'=>base_url()
			));

			$data['msg'] = (!empty($response['result']) && $response['result']=='SUCCESS')?'The verification link has been resent':'ERROR: The verification link could not be resent';
		}

		$data = load_page_labels('sign_up',$data);
		$this->load->view('account/verify_email', $data);
	}




	# Update the user phone number
	function update_user_phone()
	{
		log_message('debug', 'Account/update_user_phone');
		check_access($this,'__redirect'); #redirect away from this function if user is not logged in

		$data = filter_forwarded_data($this);
		$result = FALSE;
		$data['msg'] = '';
		log_message('debug', 'Account/update_user_phone:: [1] post='.json_encode($_POST));
		log_message('debug', 'Account/update_user_phone:: [2] data='.json_encode($data));
		# a) The user is updating the telephone number
		if(!empty($_POST['telephone'])){
			$data['hasPosted'] = 'Y';
			$response = $this->_api->post('user/telephone', array(
					'telephone'=>$_POST['telephone'],
					'provider'=>$_POST['provider__provider'],
					'isPrimary'=>'Y'
				));

			# Update the user telephone and provider if sucessful
			if(!empty($response['result']) && $response['result']=='SUCCESS'){
				$this->native_session->set('__telephone', $_POST['telephone']);
				$this->native_session->set('__provider', $response['provider']);
				$this->native_session->set('__provider_id', $_POST['provider__provider']);
				$data['msg'] = 'Your phone number has been updated and verification code sent.';
				$result = TRUE;
				$data['area'] = 'verify_code_form';
			}
			else {
				$data['msg'] = 'ERROR: Your phone number could not be updated';
				$data['area'] = 'user_phone_details';
			}
		}


		# b) Verify telephone code
		else if(!empty($_POST['usercode'])){
			$data['hasPosted'] = 'Y';
			$response = $this->_api->post('account/verify', array(
				'code'=>$_POST['usercode'],
				'telephone'=>$this->native_session->get('__telephone'),
				'baseLink'=>base_url()
			));

			if(!empty($response['verified']) && $response['verified']=='Y'){
				$this->native_session->set('__telephone_verified', 'Y');
				$data['msg'] = '20 Points have been added to your Clout Score';
				$data['area'] = 'verify_code_results';
			}
			else {
				$data['msg'] = 'ERROR: Your phone could not be verified.<br>Please try again.';
				$data['area'] = 'verify_code_form';
			}
		}


		# c) the user has already verified their phone.
		else if($this->native_session->get('__telephone_verified') && $this->native_session->get('__telephone_verified') == 'Y'){
			# if this is a user with more privileges to view the network page take them to the network home instead
			if($this->native_session->get('__direct_invitation_count')
				&& $this->native_session->get('__direct_invitation_count') >= MINIMUM_INVITE_COUNT
			){
				$view = check_access($this,'can_view_invite_tools')? 'network/home': 'account/thank_you';
			}
			else $view = 'network/invite';

			# take to appropriate view
			redirect(base_url().$view);
		}


		# c) the user is coming to this page for first time OR they havent verified their phone yet
		else if(!(!empty($data['edit']) && $data['edit'] == 'Y') && $this->native_session->get('__telephone') && $this->native_session->get('__provider_id')
			&& (!$this->native_session->get('__telephone_verified') || ($this->native_session->get('__telephone_verified') && $this->native_session->get('__telephone_verified') == 'N'))
		){
			$response = $this->_api->post('user/telephone', array(
					'telephone'=>$this->native_session->get('__telephone'),
					'provider'=>$this->native_session->get('__provider_id'),
					'isPrimary'=>'Y'
			));

			# Prepare appropriate message
			$data['msg'] = (!empty($response['result']) && $response['result']=='SUCCESS')? 'A verification message has been sent to your phone. Enter the code here to confirm your phone number.': 'ERROR: A verification message could not be sent to your phone. <br>Click Resend to attempt sending it again, or Edit to change your phone details.';
			$result = TRUE;
			$data['area'] = 'verify_code_form';
		}


		# d) The user has to enter their phone details from scratch
		else $data['area'] = 'user_phone_details';

		$data = load_page_labels('link_card', $data);
		$this->load->view('account/verify_phone', $data);
	}





	# Verify User
	function verify_user()
	{
		log_message('debug', 'Account/verify_user');
		$data = filter_forwarded_data($this,array(),array(),1);
		log_message('debug', 'Account/verify_user:: [1] data='.json_encode($data));

		if(!empty($data['u']))
		{
			$response = $this->_api->post('account/verify', array(
					'code'=>$data['u'],
					'baseLink'=>base_url()
				));

		}

		$msg = (!empty($response['verified']) && $response['verified']=='Y')?'Your Clout score just increased 20 points for verifying your email. Login to continue.':'ERROR: The email address could not be verified.<br>Please re-check the link sent to your email and try again.';
		$this->native_session->set('msg', $msg);
		redirect(base_url().'account/login');
	}





	# Forgot password
	function forgot_password()
	{
		log_message('debug', 'Account/forgot_password');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Account/forgot_password:: [1] post='.json_encode($_POST));

		# User has posted an email address
		if(!empty($_POST['youremail'])){
			$response = $this->_api->post('account/forgot', array(
					'emailAddress'=>$_POST['youremail'],
					'baseLink'=>base_url()
				));

			if(!empty($response['result']) && $response['result']=='SUCCESS'){
				$this->native_session->set('msg', "A link to reset your password has been sent");
			} else {
				$msg = !empty($response['msg'])? $response['msg']: "A link to reset your password could not be sent. <br>Please try again.";
				echo format_notice($this, "ERROR: ".$msg);
			}
		}
		# Showing the whole page
		else
		{
			$data = load_page_labels('forgot_password', $data);
			$this->load->view('account/forgot_password', $data);
		}
	}





	# Recover password
	function recover_password()
	{
		log_message('debug', 'Account/recover_password');
		$data = filter_forwarded_data($this,array(),array(),1);
		log_message('debug', 'Account/recover_password:: [1] data='.json_encode($data));
		# The passed email user identifier
		if(!empty($data['p'])){
			$response = $this->_api->post('account/recover', array('tempPassword'=>$data['p'] ));
			log_message('debug', 'Account/recover_password:: [2] response='.json_encode($response));

			if(!empty($response['result']) && $response['result']=='verified'){
				$data['msg'] = "Please enter your new password";
				$data['showRecoveryForm'] = 'Y';
				$data['userId'] = $response['user_id'];
			}
			else $data['msg'] = "ERROR: Your link seems to be invalid. <br>Please double check your recovery link and try again.";
		}

		# The user has posted a new password
		if(!empty($_POST['yournewpassword'])){
			if($_POST['yournewpassword'] == $_POST['repeatnewpassword']){
				$response = $this->_api->post('account/recover', array(
					'newPassword'=>$_POST['yournewpassword'],
					'userId'=> $_POST['userid']
				));

				if(!empty($response['result']) && $response['result']=='SUCCESS'){
					$this->native_session->set('msg', 'Your password has been updated. Login to continue.');
					echo "<script>document.location.href='".base_url()."account/login';</script>";
				}
				else echo format_notice($this, "ERROR: We could not update your password. Please try again or contact us.");
			}
			else echo format_notice($this, "ERROR: The passwords do not match. <br>Please try again.");
		}
		# Loading full form details
		else
		{
			$data = load_page_labels('forgot_password', $data);
			$data['area'] = 'recover_password';
			$this->load->view('account/forgot_password', $data);
		}
	}





	# Verify a user phone number
	function verify_telephone()
	{
		log_message('debug', 'Account/verify_telephone');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Account/verify_telephone:: [1] post='.json_encode($_POST));

		if(!empty($_POST)){
			$result = FALSE;
			$data['msg'] = '';
			$data['hasPosted'] = 'Y';

			# a) Is user updating their phone details?
			if(!empty($_POST['telephone'])){
				# Add or update phone and send verification code
				$response = $this->_api->post('user/telephone', array(
					'telephone'=>$_POST['telephone'],
					'provider'=>$_POST['provider__provider'],
					'isPrimary'=>'Y'
				));

				# Update the user telephone and provider if sucessful
				if(!empty($response['result']) && $response['result']=='SUCCESS'){
					$data['msg'] .= $this->native_session->get('__telephone') != $_POST['telephone']? 'Your phone number has been updated and a': 'A';
					$data['msg'] .= ' code has been sent for verification';
					$this->native_session->set('__telephone', $_POST['telephone']);
					$this->native_session->set('__provider', $response['provider']);
					$this->native_session->set('__provider_id', $_POST['provider__provider']);
					$result = TRUE;
					$data['area'] = 'verify_code_form';
				}
				else $data['msg'] .= 'ERROR: Your phone number could not be updated or code sent.';
			}

			# b) Verify telephone code
			else if(!empty($_POST['usercode'])){
				$response = $this->_api->post('account/verify', array(
					'code'=>$_POST['usercode'],
					'telephone'=>$this->native_session->get('__telephone'),
					'baseLink'=>base_url()
				));

				if(!empty($response['verified']) && $response['verified']=='Y'){
					$this->native_session->set('__telephone_verified', 'Y');
					$data['msg'] = '20 Points have been added to your Clout Score';
					$data['area'] = 'verify_code_results';
				}
				else {
					$data['msg'] = 'ERROR: Your phone could not be verified.<br>Please try again.';
					$data['area'] = 'verify_code_form';
				}
			}
		}

		$data['area'] = !empty($data['area'])? $data['area']: 'user_phone_details';
		$this->load->view('account/verify_phone', $data);
	}





	# Load splash page for restricted users
	function splash()
	{
		log_message('debug', 'Account/splash');
		$data = filter_forwarded_data($this);
		$this->load->view('account/splash', $data);
	}




	# thank you for signing up
	function thank_you()
	{
		log_message('debug', 'Account/thank_you');
		$data = filter_forwarded_data($this);

		if($this->native_session->get('__direct_invitation_count') && $this->native_session->get('__direct_invitation_count') >= MINIMUM_INVITE_COUNT)
		{
			# if a new default view has been set, go to that instead
			if($this->native_session->get('__default_view')
				&& $this->native_session->get('__default_view') != 'account/thank_you'
			) {
				redirect(base_url().$this->native_session->get('__default_view'));
			}
			# else show the current page
			else {
				$data = load_page_labels('invite_five', $data);
				$this->load->view('account/thank_you', $data);
			}
		}
		# otherwise take the user back to enter more invites
		else redirect(base_url().'network/invite');
	}







	# save facebook data
	function save_facebook_data()
	{
		log_message('debug', 'Account/save_facebook_data');
		# only proceed if at least the facebook ID is posted
		if(!empty($_POST['facebookId'])) $response = $this->_api->post('account/facebook', $_POST);
	}


	# View list_banks
	function list_banks()
	{
		log_message('debug', 'Account/list_banks');
		$data = filter_forwarded_data($this);

		if(!empty($_POST['selected_banks'])){
			log_message('debug', 'Account/list_banks:: [1] !empty($_POST[\'selected_banks\'])');
			$this->native_session->set('exclude_banks',$_POST['selected_banks']);
		} else {
			$data = load_page_labels('list_banks', $data);
			$this->load->view('account/list_banks', $data);
		}
	}

	# Generate activate button after user submit banks.
	function generate_activate_button()
	{
		log_message('debug', 'Account/generate_activate_button');
		$data = filter_forwarded_data($this);

  		$data['bank_links'] = array();

  		log_message('debug', 'Account/generate_activate_button:: [1] post='.json_encode($_POST));
  		if(!empty($_POST['bankname__banks'])){

  			foreach($_POST['bankname__banks'] As $enteredBank){
  				if($enteredBank!= ''){
  					$result = $this->_api->get('money/banks', array('offset'=>0, 'limit'=>'1', 'phrase'=>$enteredBank));
  					if($result){
  						foreach($result As $bank){
  							$link = base_url()."account/show_bank_login/i/".encrypt_value($bank['bank_id'])."/n/".encrypt_value($bank['bank_name'])."/c/".encrypt_value($bank['bank_code']);
  						}
  						array_push($data['bank_links'], $link);
  					} else {
  						array_push($data['bank_links'], "");
  					}

  				}
  			}
			echo json_encode($data['bank_links']);

 		}else echo format_notice($this, "ERROR: The bank you have provided do not match. Please try again.");

	}

	function user_access_view()
    {
        $view = $this->native_session->get('__permissions');
        if(!empty($view['view'])) {
            echo json_encode($view['view']);
        } else {
            echo 'empty';
        }
    }
}

/* End of controller file */
