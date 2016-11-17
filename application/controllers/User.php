<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing user information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 08/24/2015
 */
class User extends CI_Controller 
{
	
	# The home list of users
	function shopper_dashboard()
	{
		log_message('debug', 'User/shopper_dashboard');
		$data = filter_forwarded_data($this);
		$data['userList'] = $this->_api->get('user/list', array('view'=>'profile', 'limit'=>'20', 'category'=>'shopper'  ));
		$this->native_session->set('__user_category', 'shopper');
		$this->native_session->delete('selected_users');
		$this->native_session->delete('user_list_ranges');

		log_message('debug', 'User/shopper_dashboard:: [1] data='.json_encode($data));
		$this->load->view('user/user_dashboard', $data);
	}
	
	
	# The home list of store owner users
	function store_owner_dashboard()
	{
		log_message('debug', 'User/store_owner_dashboard');
		$data = filter_forwarded_data($this);
		$data['userList'] = $this->_api->get('user/list', array('view'=>'profile', 'limit'=>'20', 'category'=>'store_owner' ));
		$this->native_session->set('__user_category', 'store_owner');
		$this->native_session->delete('selected_users');
		$this->native_session->delete('user_list_ranges');
		
		log_message('debug', 'User/store_owner_dashboard:: [1] data='.json_encode($data));
		$this->load->view('user/user_dashboard', $data);
	}
	
	# The home list of system admin users
	function admin_dashboard()
	{
		log_message('debug', 'User/admin_dashboard');
		$data = filter_forwarded_data($this);
		$data['userList'] = $this->_api->get('user/list', array('view'=>'profile', 'limit'=>'20', 'category'=>'admin' ));
		$this->native_session->set('__user_category', 'admin');
		$this->native_session->delete('selected_users');
		$this->native_session->delete('user_list_ranges');
		
		log_message('debug', 'User/admin_dashboard:: [1] data='.json_encode($data));
		$this->load->view('user/user_dashboard', $data);
	}
	
	
	
	# The list of tags for the user list
	function list_tags()
	{
		log_message('debug', 'User/shopper_dashboard');
		$data = filter_forwarded_data($this);
		echo  get_option_list($this, 'user_list_actions', 'div','', array('type'=>'tags'));
	}
	
	
	
	# The list of actions for the user list
	function list_actions()
	{
		log_message('debug', 'User/shopper_dashboard');
		$data = filter_forwarded_data($this);
		echo  get_option_list($this, 'user_list_actions', 'div','', array('type'=>'actions'));
	}
	
	
	
	# Add tags to a list item
	function tags()
	{
		log_message('debug', 'User/shopper_dashboard');
		$data = filter_forwarded_data($this);
		echo format_notice($this, 'WARNING: You clicked the '.$data['t'].' tag.');
	}
	
	
	
	# purge the selected users from the system
	function purge_user()
	{
		log_message('debug', 'User/shopper_dashboard');
		$data = filter_forwarded_data($this);
		$response = $this->_api->post('account/purge_user', array('purgeUsers'=>explode('--', $data['list']) ));
		log_message('debug', 'User/change_group:: [1] response='.json_encode($response));
		
		$data['msg'] = (!empty($response['result']) && $response['result'] == 'SUCCESS')? "The user data has been purged from the system.": "ERROR: All the user data could not be removed. ".(!empty($response['msg'])? "<br>DETAILS:<BR>".$response['msg']: '');
		
		$data['area'] = 'refresh_list_msg';
		
		log_message('debug', 'User/change_group:: [2] data='.json_encode($data));
		$this->load->view('addons/basic_addons', $data);
	}
	
	
	
	# change the user permission group
	function change_group()
	{
		log_message('debug', 'User/change_group');
		$data = filter_forwarded_data($this);
		log_message('debug', 'User/change_group:: [1] data='.json_encode($data));
		log_message('debug', 'User/change_group:: [2] post='.json_encode($_POST));
		# viewing the permissions in a selected group
		if(!empty($data['g'])){
			$data['access'] = $this->_api->get('setting/permission_group', array('groupId'=>format_id($data['g']) ));
			$this->load->view('user/group_access', $data); 
		}
		
		# user is changing the permission group
		else if(!empty($_POST)){

			$response = $this->_api->post('setting/user_group_mapping', array(
					'newGroupId'=>$_POST['group__permissiongroups'],
					'userIdList'=>explode(',', $_POST['users'])
				));
			$msg = (!empty($response['result']) && $response['result'] == 'SUCCESS')? "The selected user group has been updated.": "ERROR: The selected user group could not be properly updated.";
			$this->native_session->set('__msg', $msg);
		}
		
		# showing the change result
		else if(!empty($data['a'])){
			$data['msg'] = $this->native_session->get('__msg');
			$data['area'] = 'refresh_list_msg';
			$this->load->view('addons/basic_addons', $data);
		}
		
		# user is just viewing the form for the first time
		else $this->load->view('user/change_group', $data);
	}
	
	
	
				
				
				
	
	
	# The list of views for a user list
	function list_views()
	{
		log_message('debug', 'User/list_views');
		$data = filter_forwarded_data($this);
		log_message('debug', 'User/list_views:: [1] data='.json_encode($data));
		# Load the real list
		if(empty($data['d']))
		{

			$data['viewToLoad'] = $data['t'];//'';
			$data['userList'] = $this->_api->get('user/list', array(
					'view'=>$data['t'],//'',
					'limit'=>'20', 
					'phrase'=>(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''), 
					'category'=>($this->native_session->get('__user_category')? $this->native_session->get('__user_category'): ''),
					'viewUserIds'=>(!empty($data['listids'])? restore_bad_chars($data['listids']): '')
				));
			log_message('debug', 'User/list_views:: [2] data='.json_encode($data));

			$this->load->view('user/user_list_container', $data);
		}
		
		# A destination div is specified. Hence we are just showing the list of views
		else echo get_option_list($this, 'user_list_views', 'div');
	}
	
	
	
	
	
	
	# get the full details of a user
	function details()
	{
		log_message('debug', 'User/details');
		$data = filter_forwarded_data($this);
		log_message('debug', 'User/details:: [1] data='.json_encode($data));
		# user details

		if(!empty($data['d']))
		{
			$data['user'] = $this->_api->get('user/settings', array(
				'userId'=>format_id($data['d']),
				'fields'=>'userId,name,photo'
			));
			$data['title'] = !empty($data['user']['name'])? $data['user']['name']: 'ERROR';
			
			$parameters = array('limit'=>'1', 'phrase'=>'', 'category'=>'', 'viewUserIds'=>$data['d']);
			$data['profile'] = $this->_api->get('user/list', array_merge($parameters, array('view'=>'profile')));
			$data['network'] = $this->_api->get('user/list', array_merge($parameters, array('view'=>'network')));
			$data['activity'] = $this->_api->get('user/list', array_merge($parameters, array('view'=>'activity')));
			$data['money'] = $this->_api->get('user/list', array_merge($parameters, array('view'=>'money')));
			$data['clout_score'] = $this->_api->get('user/list', array_merge($parameters, array('view'=>'clout_score')));
		}
		
		if(empty($data['user'])) {
			$data['title'] = "ERROR";
			$data['msg'] = "ERROR: The user details can not be resolved";
		}



		log_message('debug', 'User/details:: [2] data='.json_encode($data));
		$this->load->view('user/details', $data);
	}
	
	
	
	# get the facebook user details
	function social_media() 
	{
		log_message('debug', 'User/social_media');
		$data = filter_forwarded_data($this);
		log_message('debug', 'User/social_media:: [1] data='.json_encode($data));
		# user facebook details
		if(!empty($data['d'])) {
			$data['user'] = $this->_api->get('user/social_media', array(
				'userId'=>format_id($data['d']),
				'mediaType'=>$data['t'],
				'fields'=>'media_id,email_address,full_name,first_name,last_name,age_range,gender,birth_day,profile_link,timezone_offset,photo_url,is_silhoutte,photo_list,owner_user_id,date_entered,last_update_date'
			));
			$data['title'] = !empty($data['user']['full_name'])? $data['user']['full_name']: 'ERROR';
		}
		
		# display error if no facebook detail was found in DB
		if(empty($data['user'])) {
			$data['title'] = "ERROR";
			$data['msg'] = "ERROR: The user details can not be resolved";
		}
		log_message('debug', 'User/social_media:: [2] data='.json_encode($data));
		$this->load->view('user/social_media', $data);
	}
	
	
	
	# Get user facebook photos
	function facebook_photos() 
	{
		log_message('debug', 'User/facebook_photos');
		$data = filter_forwarded_data($this);
		log_message('debug', 'User/facebook_photos:: [1] data='.json_encode($data));
		# user facebook details
		if(!empty($data['d'])) {
			$photos = $this->_api->get('user/social_media', array(
				'userId'=>format_id($data['d']),
				'mediaType'=>$data['t'],
				'fields'=>'photo_url, photo_list'
			));
			
			$data['photos'] = array();
			if(!empty($photos['photo_url'])) {
				array_push($data['photos'], $photos['photo_url']);
			}
			
			if(!empty($photos['photo_list'])) {
				foreach($photos['photo_list'] as $value){
					array_push($data['photos'], $value);
				}
			}
			
			$data['title'] = !empty($data['user']['full_name'])? $data['user']['full_name']: 'ERROR';
		}
		
		# display error if no facebook detail was found in DB
		if(empty($data['user'])) {
			$data['title'] = "ERROR";
			$data['msg'] = "ERROR: The user details can not be resolved";
		}
		log_message('debug', 'User/facebook_photos:: [2] data='.json_encode($data));
		$this->load->view('user/facebook_photos', $data);
	}
	
	
	
}

/* End of controller file */