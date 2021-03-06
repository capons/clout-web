<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing public pages.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/03/2015
 */
class Page extends CI_Controller
{
	# Home page
	function index()
	{
		log_message('debug', 'Page/index');
		# Set the referrer ID if this user was referred
		$data = filter_forwarded_data($this, array(), array(), 1);
		log_message('debug', 'Page/index:: [1] data='.json_encode($data));

		if(!empty($data['r']) && !$this->native_session->get('__user_id')) {
			$referrer = $this->_api->get('network/referrer_id',array('referralCode'=>$data['r']));
			if(!empty($referrer['referrer_id'])) $this->native_session->set('referrer_id', $referrer['referrer_id']);
		}
		$data = load_page_labels('home', $data);
		$this->load->view('home', $data);
	}



	# Redirect a URL through the system iFrame
	function redirect_url()
	{
		log_message('debug', 'Page/redirect_url');
		$data = filter_forwarded_data($this);
		$data['url'] = restore_bad_chars($data['url']);
		$data['area'] = "show_redirect_url";

		log_message('debug', 'Page/redirect_url:: [1] data='.json_encode($data));
		$this->load->view('addons/basic_addons', $data);
	}


	# Generate a custom drop down list
	function get_custom_drop_list()
	{
		log_message('debug', 'Page/get_custom_drop_list');
		$data = filter_forwarded_data($this);

		if(!empty($data['type'])){
			$searchBy = !empty($data['search_by'])? $data['search_by']: '';
			$data['list'] =  get_option_list($this, $data['type'], 'div', $searchBy, $data);
		}

		$data['area'] = "dropdown_list";
		log_message('debug', 'Page/get_custom_drop_list:: [1] data='.json_encode($data));
		$this->load->view('addons/basic_addons', $data);
	}


	# Contact form
	function contact()
	{
		log_message('debug', 'Page/contact');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Page/contact:: [1] post='.json_encode($_POST));
		# The user has submitted a message
		if(!empty($_POST['yourmessage'])){
			$response = $this->_api->post('message/contact', array(
				'name'=>$_POST['yourname'],
				'emailAddress'=>$_POST['youremail'],
				'telephone'=>(!empty($_POST['yourphone'])? $_POST['yourphone']: ''),
				'message'=>$_POST['yourmessage']
			));
			log_message('debug', 'Page/contact:: [2] response='.json_encode($response));
			if(!empty($response['result']) && $response['result']=='SUCCESS'){
				echo format_notice($this, 'Your message has been sent.');
			}
			else echo format_notice($this, 'ERROR: Your message could not be sent. <br>Please try again.');
		}
		else
		{
			$data = load_page_labels('contact', $data);
			$this->load->view('page/contact', $data);
		}
	}


	# Videos
	function videos()
	{
		log_message('debug', 'Page/videos');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('videos', $data);
		$this->load->view('page/videos', $data);
	}


	# Terms of use
	function terms()
	{
		log_message('debug', 'Page/terms');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('terms', $data);
		$this->load->view('page/terms', $data);
	}


	# Privacy
	function privacy()
	{
		log_message('debug', 'Page/privacy');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('privacy', $data);
		$this->load->view('page/privacy', $data);
	}


	# Business home
	function businesses()
	{
		log_message('debug', 'Page/businesses');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('businesses', $data);
		$this->load->view('page/businesses', $data);
	}


	# Affiliates home
	function affiliates()
	{
		log_message('debug', 'Page/affiliates');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('affiliates', $data);
		$this->load->view('page/affiliates', $data);
	}


	# Agents home
	function agents()
	{
		log_message('debug', 'Page/agents');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('agents', $data);
		$this->load->view('page/agents', $data);
	}


	# Banks home
	function banks()
	{
		log_message('debug', 'Page/banks');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('banks', $data);
		$this->load->view('page/banks', $data);
	}


	# Investor home
	function investor()
	{
		log_message('debug', 'Page/investor');
		$data = filter_forwarded_data($this);
		$data = load_page_labels('investor', $data);
		$this->load->view('page/investor', $data);
	}

	# View Photo
	function view_photo()
	{
		log_message('debug', 'Page/view_photo');
		$data = filter_forwarded_data($this);
		$data['area'] = 'photo';
		$this->load->view('addons/basic_addons', $data);
	}



	# View linking help
	function link_help()
	{
		log_message('debug', 'Page/link_help');
		$data = filter_forwarded_data($this);
		$this->load->view('page/link_help', $data);
	}


	# VIP form
	function vip_form()
	{
		log_message('debug', 'Page/vip_form');
		$data = filter_forwarded_data($this);

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
			$data = load_page_labels('vip_form', $data);
			$this->load->view('page/vip_form', $data);
		}
	}
















	#-----------------------------------------------------------------------------------------
	# TEMP FUNCTIONS. Remove when done.
	#-----------------------------------------------------------------------------------------

	#temp page
	function temp()
	{
		$data = filter_forwarded_data($this);
		$data['user'] = $this->_api->get('account/CT000000000001');

		$data = load_page_labels('home', $data);
		$this->load->view('temp', $data);
	}



	# Process form submission
	function process_form()
	{
		$data = filter_forwarded_data($this);
		if($this->input->post('formid'))
		{
			# Login form
			if($_POST['formid'] == 'loginform')
			{
				$formData = array('cloutusername'=>encrypt_value($_POST['cloutusername']), 'cloutpassword'=>encrypt_value($_POST['cloutpassword']));
				$data['result'] = $this->_api->post('account/login', $formData);

				echo "Your user ID: ".(!empty($data['result']['user_id'])? $data['result']['user_id'] : 'NOT FOUND!');
			}
		}
	}


}

/* End of controller file */
