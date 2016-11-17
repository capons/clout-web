<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing list information - especially after the first page.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/24/2015
 */
class Lists extends CI_Controller 
{
	
	# Load a list's data
	function load()
	{
		log_message('debug', 'Lists/load');
		$data = filter_forwarded_data($this);
					
		log_message('debug', 'Lists/load:: [1] $data[\'t\']='.$data['t']);
		if(!empty($data['t']))
		{
			$limit = !empty($data['n'])? $data['n']: NUM_OF_ROWS_PER_PAGE;
			$offset = !empty($data['p'])? ($data['p'] - 1)*$limit: 0;
			
			
			# Dynamic loading of system's lists based on the list type and passed parameters
			switch($data['t'])
			{
				
				case 'descriptor_changes':
					$data['descriptorId'] = $data['descriptor_id'];
					$data['changeList'] = $this->_api->get('transaction/change', array('dataType'=>'change_list', 'dataId'=>$data['descriptor_id'], 'offset'=>$offset, 'limit'=>$limit ));
					
					$this->load->view('transaction/change_list', $data);
				break;
				
				
				
				
				case 'descriptor_list':
				case 'transaction_list':
					$filters = array();
					
					# Is posted
					if(!empty($_POST['searchbank__topbanks'])){
						$filters['phrase'] = $_POST['descriptorsearch'];
						$filters['adminId'] = $_POST['searchadmins__admins'];
						$filters['status'] = $_POST['searchstatus__matchstatus'];
						$filters['bankId'] = $_POST['searchbank__topbanks'];
					}
					# Is passed by URL
					if(!empty($data['bankId'])){
						$filters['phrase'] = !empty($data['phrase'])? $data['phrase']: '';
						$filters['adminId'] = !empty($data['adminId'])? $data['adminId']: '';
						$filters['status'] = !empty($data['status'])? $data['status']: '';
						$filters['bankId'] = $data['bankId'];
					}
					
					$stub = $data['t'] == 'descriptor_list'? 'descriptor': 'transaction';
					$apiEndPoint = $data['t'] == 'descriptor_list'? 'descriptor': 'list';
					$data[$stub.'List'] = $this->_api->get('transaction/'.$apiEndPoint, array('dataType'=>$stub.'_list', 'offset'=>$offset, 'limit'=>$limit, 'filters'=>$filters ));
					# Replace the entire list if filters are specified and offset is zero
					$this->load->view('transaction/'.$stub.'_list'.(!empty($filters) && empty($offset)? '_container': ''), $data);
				break;
				
				
				
				
				
				case 'permission_group_list':
					
					$data['phrase'] = (!empty($_POST['permissiongroupsearch'])? $_POST['permissiongroupsearch']: 
						(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''));
					
					$data['groupCategory'] = !empty($data['groupcategory'])? $data['groupcategory']: 'all';
					
					$data['permissionGroupList'] = $this->_api->get('setting/permission_group_list', array('category'=>$data['groupCategory'], 'phrase'=>$data['phrase'], 'offset'=>$offset, 'limit'=>$limit ));
					
					$this->load->view('setting/permission_group_list'.(!empty($data['f'])? '_container': ''), $data);
				break;
				
				
				
				
				case 'cron_job_list':
					
					$data['phrase'] = (!empty($_POST['cronjobsearch'])? $_POST['cronjobsearch']: 
						(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''));
					
					$data['cronJobList'] = $this->_api->get('setting/cron_job_list', array('phrase'=>$data['phrase'], 'offset'=>$offset, 'limit'=>$limit ));
					
					$this->load->view('setting/cron_job_list'.(!empty($data['f'])? '_container': ''), $data);
				break;
				
				
				
				
				case 'score_settings_list':
					
					$data['phrase'] = (!empty($_POST['scoresettingssearch'])? $_POST['scoresettingssearch']: 
						(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''));
					
					$data['scoreSettingsList'] = $this->_api->get('setting/score_settings_list', array('scoreType'=>$data['score_type'], 'phrase'=>$data['phrase'], 'offset'=>$offset, 'limit'=>$limit ));
					
					$this->load->view('setting/score_settings_list_container', $data);
				break;
				
				
				
				case 'rule_settings_list':
					
					$data['phrase'] = (!empty($_POST['rulesettingssearch'])? $_POST['rulesettingssearch']: 
						(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''));
					
					$data['ruleSettingsList'] = $this->_api->get('setting/rule_settings_list', array('phrase'=>$data['phrase'], 'offset'=>$offset, 'limit'=>$limit ));
					
					$this->load->view('setting/rule_settings_list'.(!empty($data['f'])? '_container': ''), $data);
				break;
				
				
				
				
				
				
				case 'store_suggestions_list':
					# Save the search parameters
					if(!empty($data['phrase'])) $this->native_session->set('search_phrase',restore_bad_chars($data['phrase']));
					if(!empty($data['location'])) $this->native_session->set('location_phrase',restore_bad_chars($data['location']));
					if(!empty($data['order']))$this->native_session->set('order_phrase',$data['order']);
					
					
					$filters = array();
					if(!empty($data['location'])) $filters['locationEntered'] = $data['location'];
					
					# Otherwise, makeup a location phrase based on the user location
					if(!$this->native_session->get('__latitude') || empty($data['location'])) $location = $this->_location->get_current_location($data);
					if(empty($data['location']) && !empty($location['city'])) $data['location'] = $location['city'];
					
					# The list of store ids to ignore
					$exclude = $offset > 0 && $this->native_session->get('search_result_ids')? $this->native_session->get('search_result_ids'): array();
					
					if(!empty($data['suggestionId'])) $filters['suggestionId'] = $data['suggestionId'];
					if(!empty($data['suggestionType'])) $filters['suggestionType'] = $data['suggestionType'];
					if(!empty($data['categoryId'])) $filters['categoryId'] = $data['categoryId'];
					if(!empty($data['maxDistance'])) $filters['maxDistance'] = $data['maxDistance'];
					if(!empty($data['checkinPerks']) && $data['checkinPerks'] == 'ON') $filters['checkinPerks'] = 'Y';
					if(!empty($data['reservationPerks']) && $data['reservationPerks'] == 'ON') $filters['reservationPerks'] = 'Y';
					if(!empty($data['cashback']) && $data['cashback'] == 'ON') $filters['cashback'] = 'Y';
					if(!empty($data['cashbackRange'])) $filters['cashbackRange'] = $data['cashbackRange'];
					if(!empty($data['favorites']) && $data['favorites'] == 'ON') $filters['favorites'] = 'Y';
					if(!empty($data['shoppedAt']) && $data['shoppedAt'] == 'ON') $filters['shoppedAt'] = 'Y';
					if(!empty($data['popular']) && $data['popular'] == 'ON') $filters['popular'] = 'Y';
					if(!empty($location['zipcode']) || $this->native_session->get('__zipcode')) $filters['zipcode'] = (!empty($location['zipcode'])? $location['zipcode']: $this->native_session->get('__zipcode'));
					
					$parameters = array(
						'type'=>'details', 
						'phrase'=>(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''), 
						'location'=>(!empty($data['location'])? restore_bad_chars($data['location']): ''), 
						'order'=>(!empty($data['order'])? $data['order']: ''), 
						'longitude'=>(!empty($location['longitude'])? $location['longitude']: ''),
						'latitude'=>(!empty($location['latitude'])? $location['latitude']: ''),
						'filters'=>$filters, 
						'offset'=>$offset, 
						'limit'=>$limit,
						'exclude'=>$exclude
					);
					
					$response = $this->_api->get('search/store_suggestions', $parameters); 
					$data['suggestionList'] = $response['list'];
					$this->native_session->set('search_latitude',$response['origin']['latitude']);
					$this->native_session->set('search_longitude',$response['origin']['longitude']);
					$this->native_session->set('search_zipcode',$response['origin']['zipcode']);
		
					$ids = !empty($response['store_ids'])? $response['store_ids']: array();
					
					#Refresh the search tracking session array
					if($offset > 0) {
						$currentList = $this->native_session->get('search_results');
						if(!empty($data['suggestionList'])) $this->native_session->set('search_results',array_merge($currentList,$data['suggestionList']));
						$previousIds = $this->native_session->get('search_result_ids'); 
						$this->native_session->set('search_result_ids', array_merge($previousIds, $ids)); 
					}
					else {
						$this->native_session->set('search_results',$data['suggestionList']);
						$this->native_session->set('search_result_ids',$ids);
					}
					
					$this->load->view('search/store_suggestions_list', $data);
				break;
				
		
		
				case "network":
					$data['networkList'] = $this->_api->get('network/referrals', array(
						'limit'=>$limit, 
						'offset'=>$offset, 
						'phrase'=>(!empty($data['phrase'])? htmlentities(restore_bad_chars($data['phrase']), ENT_QUOTES): "")
					));
					
					$this->load->view('network/network_list', $data);
				break;
				
		
		
				case "invites":
					$data['networkList'] = $this->_api->get('network/invites', array(
						'limit'=>$limit, 
						'offset'=>$offset, 
						'phrase'=>(!empty($data['phrase'])? htmlentities(restore_bad_chars($data['phrase']), ENT_QUOTES): "")
					));
					
					$this->load->view('network/invite_list', $data);
				break;
				
		
		
				case "mail":
					$filters['phrase'] = !empty($_POST['mailsearchphrase'])? $_POST['mailsearchphrase']: (!empty($data['phrase'])? restore_bad_chars($data['phrase']): "");
					$filters['type'] = !empty($_POST['message__messagetypes'])? $_POST['message__messagetypes']: (!empty($data['type'])? restore_bad_chars($data['type']): "");
					$filters['category'] = !empty($_POST['message__level1categories'])? $_POST['message__level1categories']: (!empty($data['category'])? $data['category']: "");
					$filters['cashback'] = !empty($_POST['message__cashbackrange'])? $_POST['message__cashbackrange']: (!empty($data['cashback'])? restore_bad_chars($data['cashback']): "");
					$filters['location'] = !empty($_POST['message__placesearch'])? $_POST['message__placesearch']: (!empty($data['location'])? restore_bad_chars($data['location']): "");
					
					
					$data['messageList'] = $this->_api->get('message/list', array(
						'limit'=>$limit, 
						'offset'=>$offset, 
						'filters'=>$filters
					));
					
					$this->load->view('message/mail_list', $data);
				break;
				
				
				
				
				case 'user_list':
					
					$data['viewToLoad'] = (!empty($_POST['user_list_views__selected'])? $_POST['user_list_views__selected']: 
						(!empty($data['view'])? $data['view']: 'profile'));
						
					$data['phrase'] = (!empty($_POST['usersearch'])? $_POST['usersearch']: 
						(!empty($data['phrase'])? restore_bad_chars($data['phrase']): ''));
					
					$data['userList'] = $this->_api->get('user/list', array(
						'view'=>$data['viewToLoad'], 
						'phrase'=>$data['phrase'],  
						'offset'=>$offset, 
						'limit'=>$limit, 
						'category'=>($this->native_session->get('__user_category')? $this->native_session->get('__user_category'): 'shopper')
					));
					
					$this->load->view('user/user_list'.(!empty($data['f'])? '_container': ''), $data);
				break;
				
				
				
				
				
			
				default:
				break;
			}
		}
	}
	
	
	
	
	
	
	
	
	# add an item to the session to keep tracking it
	function add_to_session()
	{
		log_message('debug', 'Lists/add_to_session');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Lists/load:: [1] $data[\'name\']='.$data['name']);
		if(!empty($data['name'])){
			$selected = $this->native_session->get($data['name'])? $this->native_session->get($data['name']): array();
			# adding an item
			if(!empty($data['action']) && !empty($data['d'])){
				if($data['action'] == 'remove'){
					$temp = $selected;
					foreach($temp AS $key=>$item) if($item == $data['d']) unset($selected[$key]);
				} 
				else if($data['action'] == 'add') array_push($selected, $data['d']);
			}
			$this->native_session->set($data['name'],$selected);
		}
	}
}

/* End of controller file */