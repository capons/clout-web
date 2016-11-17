<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing message information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 08/28/2015
 */
class Message extends CI_Controller
{
	# The message home
	function home()
	{
		log_message('debug', 'Message/home');
		$data = filter_forwarded_data($this);
		$data['messageList'] = $this->_api->get('message/list', array('limit'=>'10'));
		$data['messageStats'] = $this->_api->get('message/statistics', array('fields'=>'unread,events,reservations'));

		$this->load->view('message/home', $data);
	}




	# The list of actions for the user list
	function list_actions()
	{
		log_message('debug', 'Message/list_actions');
		$data = filter_forwarded_data($this);
		$data['list'] = array(
			array('action'=>'like_message/a/like', 'display'=>'Like'),
			array('action'=>'like_message/a/dislike', 'display'=>'Dislike'),
			array('action'=>'add_mark/a/favorite', 'display'=>'Mark as Favorite'),
			array('action'=>'add_mark/a/read', 'display'=>'Mark as Read'),
		);
		$this->load->view('message/list_actions', $data);
	}




	# Like a message
	function like_message()
	{
		log_message('debug', 'Message/like_message');
		$data = filter_forwarded_data($this);

		if(!empty($data['list']))
		{
			log_message('debug', 'Message/like_message:: [1] !empty($data[\'list\'])');
			$result = $this->_api->post('message/like_message', array(
				'messages'=>explode('--',$data['list']),
				'action'=>$data['a']
			));

			log_message('debug', 'Message/like_message:: [2] $data[\'a\']='.$data['a']);
			if($data['a'] == 'like'){
				$success = "More messages similar to those selected will be sent in future.";
				$fail = "ERROR: One or more of your likes could not be recorded.";
			} else {
				$success = "Less messages similar to those selected will be sent in future.";
				$fail = "ERROR: One or more of your dislikes could not be recorded.";
			}
		}
		else $fail = "ERROR: No messages were selected.";

		echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />".
		format_notice($this, (!empty($result['result']) && $result['result'] == 'SUCCESS'? $success: $fail));
	}



	# Add a mark to a message
	function add_mark()
	{
		log_message('debug', 'Message/add_mark');
		$data = filter_forwarded_data($this);

		if(!empty($data['list']))
		{
			log_message('debug', 'Message/like_message:: [1] !empty($data[\'list\'])');
			$result = $this->_api->post('message/add_mark', array(
				'messages'=>explode('--',$data['list']),
				'action'=>$data['a']
			));

			log_message('debug', 'Message/like_message:: [2] $data[\'a\']='.$data['a']);
			if($data['a'] == 'favorite'){
				$success = "The stores associated with the selected messages have been marked as favorites.";
				$fail = "ERROR: The stores associated with the selected messages could not be marked as favorites.";
			} else {
				# Update the unread messages if successful
				if(!empty($result['result']) && $result['result'] == 'SUCCESS'){
					$stats = $this->_api->get('message/statistics', array('fields'=>'unread'));
					if(!empty($stats['unread']) || (isset($stats['unread']) && $stats['unread'] == 0)) $this->native_session->set('__unread_count',$stats['unread']);
				}
				$success = "The messages have been marked as read.
				<br><br><button id='refreshinbox' name='refreshinbox' class='btn green frompop' data-rel='".base_url()."message/home' style='width:100%;'>Refresh Inbox</button>
				<script type='text/javascript' src='".base_url()."assets/js/jquery-2.1.1.min.js'></script>
				<script type='text/javascript' src='".base_url()."assets/js/clout.js'></script>";
				$fail = "ERROR: The messages could not be marked as read.";
			}
		}
		else $fail = "ERROR: No messages were selected.";

		echo "<link rel='stylesheet' href='".base_url()."assets/css/clout.css' type='text/css' media='screen' />".
		format_notice($this, (!empty($result['result']) && $result['result'] == 'SUCCESS'? $success: $fail));
	}



	# View message details
	function view_details()
	{
		log_message('debug', 'Message/view_details');
		$data = filter_forwarded_data($this);

		if(!empty($data['m'])) $data['message'] = $this->_api->get('message/details', array('messageId'=>$data['m']));
		if(empty($data['message'])) $data['msg'] = "ERROR: The message details could not be resolved.";

		$this->load->view('message/details', $data);
	}



	# add a new Message
	function add()
	{
		log_message('debug', 'Message/add');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Message/add:: post='.json_encode($_POST));
		# user has posted a message
		if(!empty($_POST)){
			if(!empty($_POST['methods'])){
				if(!empty($_FILES)){
					$fileUrl = upload_temp_file($_FILES, 'attachment__fileurl', 'attachment_', 'jpg,jpeg,gif,png,tiff,doc,docx,pdf,xls,xlsx');
					if(!empty($fileUrl)) $_POST['attachment'] = INTERNAL_SERVER_URL.'assets/uploads/temp/'.$fileUrl;
				}

				$result = $this->_api->post('message/send', array('message'=>array(
				    'useTemplate'=>$_POST['usetemplate'],
					'templateId'=>($_POST['usetemplate'] == 'Y' && !empty($_POST['template_id'])? $_POST['template_id']: ''),
					'senderType'=>'user',
					'sendToType'=>($_POST['sendto'] == 'list' && !empty($_POST['recipients'])? 'list': 'filter'),
					'sendTo'=>($_POST['sendto'] == 'list' && !empty($_POST['recipients'])? $_POST['recipients']: $_POST['message__recipientfilters']),
					'subject'=>$_POST['subject'],
					'body'=>$_POST['body'],
					'sms'=>$_POST['sms'],
					'attachment'=>(!empty($_POST['attachment'])? $_POST['attachment']: ''),
					'templateAttachment'=>(!empty($_POST['template_attachment'])? $_POST['template_attachment']: ''),
					'saveTemplate'=>$_POST['savetemplate'],
					'saveTemplateName'=>$_POST['savetemplatename'],
					'sendDate'=>$_POST['senddate'],
					'methods'=>$_POST['methods']
				)));
			}
			# No sending method was selected
			else $result = array('boolean'=>FALSE, 'msg'=>'ERROR: No sending method was selected.');

			#Remove the temp file now that we are done with it
			if(!empty($fileUrl) && file_exists(UPLOAD_DIRECTORY.'temp/'.$fileUrl)) @unlink(UPLOAD_DIRECTORY.'temp/'.$fileUrl);

			# what result to show if failed
			if(!$result['boolean']){
				echo format_notice($this, !empty($result['msg'])? $result['msg']: 'ERROR: The message could not be scheduled for sending');
			}
		}


		# user has completed submission
		else if(!empty($data['a'])){
			$data['msg'] = 'The message has been scheduled for sending';
			$data['area'] = 'refresh_list_msg__from_shadowpage';
			$this->load->view('addons/basic_addons', $data);
		}


		# user has just come to the form
		else {
			if(!empty($data['list'])){
				$rawIds = explode('--',$data['list']);
				$idList = array();
				foreach($rawIds AS $id) array_push($idList, format_id($id));

				$data['users'] = $this->_api->get('user/list', array('view'=>'profile','phrase'=>'','category'=>'', 'limit'=>count($idList), 'viewUserIds'=>implode(',',$idList) ));
			}

			$this->load->view('message/add_new', $data);
		}
	}






	# unsubsribe an email from the system
	function unsubscribe()
	{
		log_message('debug', 'Message/unsubscribe');
		$data = filter_forwarded_data($this, array(), array(), 1);
		log_message('debug', 'Message/unsubscribe:: post='.json_encode($_POST));
		# visitor has posted confirmation
		if(!empty($_POST)){
			$response = $this->_api->post('message/unsubscribe', array(
				'emailAddress'=>$_POST['emailaddress'],
				'reason'=>(!empty($_POST['reason'])? $_POST['reason']: '')
			));

			echo "<table class='microform'>
				<tr>
				<td>".format_notice($this, ($response['boolean']? 'The email has been unsubscribed.': 'ERROR: The email could not be unsubscribed.'))."</td>
				</tr>
				</table>";
		}

		# visitor has just come to the page
		else {
			if(!empty($data['x'])) $data['emailAddress'] = decrypt_value($data['x']);
			else $data['msg'] = 'ERROR: The email address to unsubscribe could not be resolved. <br>Please check your link and try again.';
			$data = load_page_labels('contact', $data);
			$this->load->view('message/unsubscribe', $data);
		}
	}

	# Show different content based on tab
	function tab_handler()
	{
		log_message('debug', 'Message/tab_handler');
		log_message('debug', 'Message/tab_handler:: [1] post='.$_POST['tab_details']);
		$data = filter_forwarded_data($this);

		if($_POST['tab_details'] == 'mail_container'){

			$data['messageList'] = $this->_api->get('message/list', array('limit'=>'10'));
			log_message('debug', 'Message/tab_handler:: [2] messageList='.json_encode($data['messageList']));
			$this->load->view('message/mail_container', $data);

		}else if($_POST['tab_details'] == 'events_container'){

			# Get location information based on IP address if none is provided
			$location = $this->_location->get_current_location($data);

			$data['eventList'] = $this->_api->get('event/list', array(
					'location'=>array('latitude'=>$location['latitude'],'longitude'=>$location['longitude']),
					'details'=>array(
						'ownerType'=>'store',
						'promotionTypes'=>'perk',
						'maxSearchDistance'=>50
					),
					'filters'=>array(
						'searchString'=> (!empty($_POST['searchphrase']) ? $_POST['searchphrase'] : ''),
						'categoryId'=> (!empty($_POST['event__level1categories']) ? $_POST['event__level1categories'] : ''),
						'eventDate'=> (!empty($_POST['eventdate']) ? $_POST['eventdate'] : ''),
						'listType'=>(!empty($_POST['sort__switcheventslist__hidden']) ? $_POST['sort__switcheventslist__hidden'] : 'current'),
						'status'=> 'active'
					),
					'limit'=>'5',
					'offset'=>(!empty($_POST['offset']) ? $_POST['offset'] : '0')
			));

			log_message('debug', 'Message/tab_handler:: [3] eventList='.json_encode($data['eventList']));
			$this->load->view('message/events_container', $data);

		}else if($_POST['tab_details'] == 'reservations_container'){

			$data['reservationList'] = $this->_api->get('reservation/list', array(
					'limit'=>'5',
					'offset'=>(!empty($_POST['offset']) ? $_POST['offset'] : '0'),
					'filters'=>array(
						'searchString'=> (!empty($_POST['phrase']) ? $_POST['phrase'] : ''),
						'categoryId'=> (!empty($_POST['event__level1categories']) ? $_POST['event__level1categories'] : ''),
						'reservationDate'=> (!empty($_POST['reservationdate']) ? $_POST['reservationdate'] : ''),
						'status'=> (!empty($_POST['sort__switcharchived__hidden']) ? $_POST['sort__switcharchived__hidden'] : 'active')
					)
			));

			log_message('debug', 'Message/tab_handler:: [4] reservationList='.json_encode($data['reservationList']));
			$this->load->view('message/reservations_container', $data);

		}
	}

	# Get archived list of reservations or serach reservations
	function get_reservation_list()
	{
		$data = filter_forwarded_data($this);

		log_message('debug', 'Message/get_reservation_list');
		log_message('debug', 'Message/get_reservation_list:: [1] post='.json_encode($_POST));

		$data['reservationList'] = $this->_api->get('reservation/list', array(
				'limit'=>'5',
				'offset'=>(!empty($_POST['offset']) ? $_POST['offset'] : '0'),
				'filters'=>array(
					'searchString'=> (!empty($_POST['searchphrase']) ? $_POST['searchphrase'] : ''),
					'categoryId'=> (!empty($_POST['event__level1categories']) ? $_POST['event__level1categories'] : ''),
					'reservationDate'=> (!empty($_POST['reservationdate']) ? $_POST['reservationdate'] : ''),
					'status'=> (!empty($_POST['sort__switcharchived__hidden']) ? $_POST['sort__switcharchived__hidden'] : 'active')
				),
		));

		log_message('debug', 'Message/get_reservation_list:: [2] reservationList='.json_encode($data['reservationList']));
		$this->load->view('message/reservations_list', $data);
	}

	# Get reservation details
	function get_reservation_details(){

		log_message('debug', 'Message/get_reservation_details');
		log_message('debug', 'Message/get_reservation_details:: [1] post='.json_encode($_POST));
		$userId = '';

		# Get encrptyed userid if exist
		if(!empty($_POST['info'])){

			$info = decrypt_value($_POST['info']);

			$info = explode("--", $info);
			log_message('debug', 'Message/get_reservation_details:: [2] info='.json_encode($info));

			$userId = $info[1];
		}

		$result = $this->_api->get('reservation/list_by_id', array(
			'userId'=>$userId,
			'reservationId'=>$_POST['reservation_id']
		));

		log_message('debug', 'Message/get_reservation_details:: [3] result='.json_encode($result));

		$reservationDetails = array();
		foreach ($result as $row) {
			$reservationDetails['scheduler_name'] = $row['scheduler_name'];
			$reservationDetails['schedule_date'] = format_epoch_date($row['_schedule_date'],'m/d/Y h:i a');
			$reservationDetails['scheduler_phone'] = format_telephone($row['scheduler_phone']);
			$reservationDetails['telephone_provider_id'] = $row['telephone_provider_id'];
			$reservationDetails['phone_type'] = $row['phone_type'];
			$reservationDetails['scheduler_email'] = $row['scheduler_email'];
			$reservationDetails['number_in_party'] = $row['number_in_party'];
			$reservationDetails['special_request'] = $row['special_request'];

		}

		log_message('debug', 'Message/get_reservation_details:: [4] reservationDetails='.json_encode($reservationDetails));
		echo json_encode($reservationDetails);

	}

	# Cancel reservation
	function cancel_reservation(){

		log_message('debug', 'Message/cancel_reservation');
		log_message('debug', 'Message/cancel_reservation:: [1] post='.json_encode($_POST));
		$userId = '';

		# Get encrptyed userid if exist
		if(!empty($_POST['info'])){

			$info = decrypt_value($_POST['info']);

			$info = explode("--", $info);
			log_message('debug', 'Message/cancel_reservation:: [2] info='.json_encode($info));

			$userId = $info[1];
		}

		$result = $this->_api->post('reservation/cancel', array(
			'userId'=>$userId,
			'reservationStatus'=>'cancelled',
			'status'=>'deleted',
			'promotionId'=>$_POST['promotion_id'],
			'storeId'=>$_POST['store_id']
		));

		log_message('debug', 'Message/cancel_reservation:: [3] result='.json_encode($result));
		echo json_encode($result);

	}

	# Update reservation details
	function update_reservation(){

		log_message('debug', 'Message/update_reservation');
		log_message('debug', 'Message/update_reservation:: [1] post='.json_encode($_POST));
		$userId = '';

		# Get encrptyed userid if exist
		if(!empty($_POST['info'])){

			$info = decrypt_value($_POST['info']);

			$info = explode("--", $info);
			log_message('debug', 'Message/update_reservation:: [2] info='.json_encode($info));

			$userId = $info[1];
		}

		$result = $this->_api->post('reservation/update', array(
			'userId'=>$userId,
			'reservationId'=>$_POST['reservation_id'],
			'storeId'=>$_POST['store_id'],
			'details'=>array(
				'schedulerName'=>$_POST['scheduler_name'],
	         'schedulerEmail'=>$_POST['scheduler_email'],
	         'schedulerPhone'=>$_POST['scheduler_phone'],
	         'telephoneProviderId'=>$_POST['telephone_provider_id'],
	         'phoneType'=>$_POST['phone_type'],
	         'scheduleDate'=>$_POST['schedule_date'],
	         'numberInParty'=>$_POST['number_in_party'],
	         'specialRequest'=>$_POST['special_request']
			)));

		log_message('debug', 'Message/update_reservation:: [3] result='.json_encode($result));
		echo json_encode($result);

	}

	# Add new reservation
	function make_reservation(){

		log_message('debug', 'Message/make_reservation');
		log_message('debug', 'Message/make_reservation:: [1] post='.json_encode($_POST));
		$userId = '';

		# Get encrptyed userid if exist
		if(!empty($_POST['info'])){

			$info = decrypt_value($_POST['info']);

			$info = explode("--", $info);
			log_message('debug', 'Message/make_reservation:: [2] info='.json_encode($info));

			$userId = $info[1];
		}

		if(!empty($_POST)) {
		$result = $this->_api->post('reservation/add', array(
			'userId'=>$userId,
			'baseUrl'=>base_url(),
			'details'=>array(
				'promotionId'=>$_POST['promotion_id'],
				'schedulerName'=>(!empty($_POST['scheduler_name']) ? $_POST['scheduler_name'] : ''),
	         'schedulerEmail'=>(!empty($_POST['scheduler_email']) ? $_POST['scheduler_email'] : ''),
	         'schedulerPhone'=>(!empty($_POST['scheduler_phone']) ? $_POST['scheduler_phone'] : ''),
	         'telephoneProviderId'=>(!empty($_POST['telephone_provider_id']) ? $_POST['telephone_provider_id'] : ''),
	         'phoneType'=>(!empty($_POST['phone_type']) ? $_POST['phone_type'] : ''),
	         'scheduleDate'=>$_POST['schedule_date'],
	         'numberInParty'=>$_POST['number_in_party'],
	         'specialRequest'=>(!empty($_POST['special_request']) ? $_POST['special_request'] : '')
			)));

		log_message('debug', 'Message/make_reservation:: [3] result='.json_encode($result));
		echo json_encode($result);

		}
	}

	# Get past or going list of events or serach events
	function get_event_list()
	{
		$data = filter_forwarded_data($this);

		log_message('debug', 'Message/get_event_list');
		log_message('debug', 'Message/get_event_list:: [1] post='.json_encode($_POST));

		# Get location information based on IP address if none is provided
		$location = $this->_location->get_current_location($data);

		$data['eventList'] = $this->_api->get('event/list', array(
				'location'=>array('latitude'=>$location['latitude'],'longitude'=>$location['longitude']),
				'details'=>array(
					'ownerType'=>'store',
					'promotionTypes'=>'perk',
					'maxSearchDistance'=>50
				),
				'filters'=>array(
					'searchString'=> (!empty($_POST['searchphrase']) ? $_POST['searchphrase'] : ''),
					'categoryId'=> (!empty($_POST['event__level1categories']) ? $_POST['event__level1categories'] : ''),
					'eventDate'=> (!empty($_POST['eventdate']) ? $_POST['eventdate'] : ''),
					'listType'=>(!empty($_POST['sort__switcheventslist__hidden']) ? $_POST['sort__switcheventslist__hidden'] : 'current'),
					'status'=> 'active'
				),
				'limit'=>'5',
				'offset'=>(!empty($_POST['offset']) ? $_POST['offset'] : '0')
		));

		log_message('debug', 'Message/get_event_list:: [2] eventList='.json_encode($data['eventList']));
		$this->load->view('message/events_list', $data);
	}

	# Record response of the user to the event
	function update_event_notice(){

		log_message('debug', 'Message/update_event_notice');
		log_message('debug', 'Message/update_event_notice:: [1] post='.json_encode($_POST));

		$userId = '';

		# Get encrptyed userid if exist
		if(!empty($_POST['info'])){

			$info = decrypt_value($_POST['info']);

			$info = explode("--", $info);
			log_message('debug', 'Message/update_event_notice:: [2] info='.json_encode($info));

			$userId = $info[1];
		}

		$result = $this->_api->post('event/update', array(
			'userId'=>$userId,
			'baseUrl'=>base_url(),
			'promotionId'=>$_POST['promotion_id'],
			'storeId'=>$_POST['store_id'],
			'attendStatus'=>$_POST['attend_status'],
			'eventStatus'=>$_POST['event_status'],
			'scheduledSendDate'=>array(date('Y-m-d H:i:s', strtotime($_POST['event_time'].' -1 days')), date('Y-m-d H:i:s', strtotime($_POST['event_time'].' -2 hours')))
		));

		log_message('debug', 'Message/update_event_notice:: [3] result='.json_encode($result));
		echo json_encode($result);

	}

	# Handle links from email for events, reservations and check-in
	function email_landing_page()
	{
		$data = filter_forwarded_data($this, array(), array(), 1);

		if(!empty($data['c'])) {

			log_message('debug', 'Message/email_landing_page:: [1] c='.$data['c']);

			$this->native_session->set('__redirect', base_url().'message/home');
			$info = decrypt_value($data['c']);

			$info = explode("--", $info);
			log_message('debug', 'Message/email_landing_page:: [2] info='.json_encode($info));

			$eventId = $info[0];
			$userId = $info[1];
			$data['action'] = $info[2];

			if($data['action'] == 'reserve') {

				$data['isSingleRow'] = TRUE;

				$data['eventList'] = $this->_api->get('event/details', array(
						'eventId'=>$eventId,
						'userId'=>$userId
				));

			} else if ($data['action'] == 'checkin') {

				# get storeId using eventId(promotionId) from store_schedule table
				$result = $this->_api->get('reservation/list', array(
						'limit'=>'1',
						'offset'=>'0',
						'filters'=>array(
							'searchString'=>'',
							'categoryId'=>'',
							'reservationDate'=>'',
							'status'=> 'active',
							'promotionId'=>$eventId
						),
						'userId'=>$userId
				));

				log_message('debug', 'Message/email_landing_page:: [3] result='.$result[0]['store_id']);
				# pass storeId & userId to search/checkin
				$location = $this->_location->get_current_location($data);
				$location['address'] = '';

				$checkin = $this->_api->post('store/checkin', array(
					'offerId'=>$eventId,
					'userId'=>$userId,
					'location'=>$location,
					'storeId'=>(!empty($result[0]['store_id'])? $result[0]['store_id']: '')
				));

				log_message('debug', 'Message/email_landing_page:: [4] checkin='.json_encode($checkin));
				$data['msg'] = !empty($checkin['checkinSuccess']) && $checkin['checkinSuccess']=='Y'? "Checkin confirmed": "WARNING: Checkin NOT confirmed.";

			} else if ($data['action'] == 'change') {

				$data['isSingleRow'] = TRUE;

				$data['reservationList'] = $this->_api->get('reservation/list', array(
						'limit'=>'1',
						'offset'=>'0',
						'filters'=>array(
							'searchString'=>'',
							'categoryId'=>'',
							'reservationDate'=>'',
							'status'=> 'active',
							'promotionId'=>$eventId
						),
						'userId'=>$userId
				));

			}

			log_message('debug', 'Message/email_landing_page:: [5] data='.json_encode($data));

			$data = load_page_labels('email_landing_page', $data);
			$this->load->view('message/email_landing_page', $data);

		# Redirect user to inbox and require login if click cancel
		} else if(!empty($_POST['redirect']) && $_POST['redirect']) {

			log_message('debug','Message/email_landing_page:: [6] redirect='.$_POST['redirect']);

			# if login then redirect to message/home
			if ($this->native_session->get('__user_id')) {
				echo "message/home";
			# if not login then redirect to account/login
			} else {
				echo "account/login";
			}

		} else $data['msg'] = 'ERROR: Something went wrong. Please try again later.';

	}

}

/* End of controller file */
