<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing setting information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 08/25/2015
 */
class Setting extends CI_Controller 
{
	
	# The setting dashboard
	function dashboard()
	{
		# TODO: Add option to pick default redirect url based on this admin's access rights
		log_message('debug', 'Setting/dashboard');
		redirect(base_url().'setting/permission_groups');
	
	}
	
	
	# The permission groups
	function permission_groups()
	{
		log_message('debug', 'Setting/permission_groups');
		$data = filter_forwarded_data($this);
		$data['groupCategory'] = !empty($data['t'])? $data['t']: 'all';
		$data['permissionGroupList'] = $this->_api->get('setting/permission_group_list', array('category'=>$data['groupCategory'], 'limit'=>'20' ));
		
		log_message('debug', 'Setting/permission_groups:: [1] data='.json_encode($data));
		$this->load->view('setting/permission_group_dashboard', $data);
	}
	
	
	
	
	
	
	# Add or edit a group
	function add_group()
	{

		log_message('debug', 'Setting/add_group');
		$data = filter_forwarded_data($this);
		$this->native_session->delete('access_rule_ids');
		$data['groupCategory'] = !empty($data['t'])? $data['t']: 'all';
		log_message('debug', 'Setting/add_group:: [1] post='.json_encode($_POST));
		# User is saving group data
		if(!empty($_POST)){

			$result = $this->_api->post('setting/permission_group', array(
				'groupId'=>(!empty($data['id'])? $data['id']: ''),
				'groupName'=>$_POST['permissiongroupname'],
				'groupType'=>$_POST['permissiongrouptype'],
				'groupCategory'=>$data['groupCategory'],
				'rules'=>(!empty($_POST['ruleids'])? $_POST['ruleids']: array()),
				'permissions'=>(!empty($_POST['permissionids'])? $_POST['permissionids']: array()),
				'__check'=>'Y'
			));
			
			log_message('debug', 'Setting/add_group:: [2] result='.json_encode($result));
			$msg = (!empty($result['success']) && $result['success'] == 'TRUE')? "The group data has been saved": "ERROR: We could not save the permission group data";
			$this->native_session->set('msg', $msg);
		}
		else {
			# A group is being edited

			if(!empty($data['id'])) {
				$data['details'] = $this->_api->get('setting/permission_group', array('groupId'=>$data['id'] ));
				$this->native_session->set('access_rule_ids', (!empty($data['details']['rules'])? $data['details']['rules']: array()));
			}
			# Collect the system permissions for display
			$data['permissionList'] = $this->_api->get('setting/permissions', array('limit'=>200));

		
			log_message('debug', 'Setting/add_group:: [3] data='.json_encode($data));
			$this->load->view('setting/permission_group', $data);
		}
	}
	
	
	
	# Change rule set to select from
	function change_rule_set()
	{
		log_message('debug', 'Setting/change_rule_set');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/change_rule_set:: [1] data='.json_encode($data));
		echo "<select id='rule_rulenames' name='rule_rulenames' class='small-drop-down' value='' style='min-width:130px; width:350px;' placeholder='Rule Name'/>".get_option_list($this, 'rulenames', 'select', '', array('rule_category'=>$data['rule_ruletypes']))."</select>";
	}
	
	
	
	
	# Add a rule to session for saving 
	function add_rule()
	{
		log_message('debug', 'Setting/add_rule');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/add_rule:: [1] post='.json_encode($_POST));
		if(!empty($_POST['rule_rulenames'])){
			$rule = $this->_api->get('setting/rule_details', array('ruleId'=>$_POST['rule_rulenames'] ));
			
			log_message('debug', 'Setting/add_rule:: [2] rule='.json_encode($rule));
			if(!empty($rule)) {
				$ruleValues = array('id'=>$rule['id'], 'category_display'=>$rule['category_display'], 'name'=>$rule['name'], 'status'=>$rule['status']);
				$rules = $this->native_session->get('access_rule_ids')? $this->native_session->get('access_rule_ids'): array();
				$rules[$rule['id']] = $ruleValues;
				$this->native_session->set('access_rule_ids', $rules);
			
				log_message('debug', 'Setting/add_rule:: [3] ruleValues='.json_encode($ruleValues));
				log_message('debug', 'Setting/add_rule:: [4] rules='.json_encode($rules));
				echo "<tr>
					<td width='1%' id='".$ruleValues['id']."' class='list-delete-icon confirm' data-category='setting'  data-type='delete_rule' data-action='submitted' style='min-width:35px; padding-right: 10px;'>&nbsp;
					<input type='hidden' id='ruleid_".$ruleValues['id']."' name='ruleids[]' value='".$ruleValues['id']."' /></td>
		
					<td>".$ruleValues['category_display']."</td>
					<td>".$ruleValues['name']."</td>
					<td>".($ruleValues['status'] == 'active'? 'ON': 'OFF')."</td>
				</tr>";
			}
		}
	}
	
	
	
	
	
	
	
	# Delete a rule from the session that is going to be saved 
	function delete_rule()
	{
		log_message('debug', 'Setting/delete_rule');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/delete_rule:: [1] data='.json_encode($data));
		if(!empty($_POST['item_id'])){
			$rules = $this->native_session->get('access_rule_ids')? $this->native_session->get('access_rule_ids'): array();
			
			log_message('debug', 'Setting/delete_rule:: [2] rules='.json_encode($rules));
			if(!empty($rules)){
				unset($rules[$_POST['item_id']]);
				 $this->native_session->set('access_rule_ids', $rules);
				echo "SUCCESS";
			}
		}
	}
	
	
	
	
	
	# Change the status of the permission group 
	function change_group_status()
	{
		log_message('debug', 'Setting/change_group_status');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/change_group_status:: [1] data='.json_encode($data));
		log_message('debug', 'Setting/change_group_status:: [2] post='.json_encode($_POST));
		if(!empty($_POST['value']) && !empty($data['d'])){
			$result = $this->_api->post('setting/permission_group_status', array(
				'groupId'=>$data['d'], 
				'status'=>($_POST['value'] == 'ON'? 'active': 'inactive') 
			)); 
			
			log_message('debug', 'Setting/change_group_status:: [2] result='.json_encode($result));
			if(!empty($result['success']) && $result['success'] == 'TRUE') echo "SUCCESS";
			else echo "ERROR: ";
		}
	}
	
	
	
	
	
	# The cron job dashboard
	function cron_jobs()
	{
		log_message('debug', 'Setting/cron_jobs');
		$data = filter_forwarded_data($this);
		$data['cronJobList'] = $this->_api->get('setting/cron_job_list', array('limit'=>'20' ));
		
		log_message('debug', 'Setting/cron_jobs:: [1] data='.json_encode($data));
		$this->load->view('setting/cron_job_dashboard', $data);
	}
	
	
	
	
	
	# Change the status of the cron job
	function change_job_status()
	{
		log_message('debug', 'Setting/change_job_status');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/change_job_status:: [1] data='.json_encode($data));
		log_message('debug', 'Setting/change_job_status:: [2] post='.json_encode($_POST));
		if(!empty($_POST['value']) && !empty($data['d'])){
			$result = $this->_api->post('setting/cron_job_status', array(
				'jobId'=>$data['d'], 
				'status'=>($_POST['value'] == 'ON'? 'active': 'inactive') 
			)); 
			
			log_message('debug', 'Setting/change_job_status:: [3] result='.json_encode($result));
			if(!empty($result['success']) && $result['success'] == 'TRUE') echo "SUCCESS";
			else echo "ERROR: ";
		}
	}
	
	
	
	
	
	# The clout score settings dashboard
	function clout_score_settings()
	{
		log_message('debug', 'Setting/clout_score_settings');
		$data = filter_forwarded_data($this);
		$data['score_type'] = 'clout';
		$data['scoreSettingsList'] = $this->_api->get('setting/score_settings_list', array('limit'=>'200', 'scoreType'=>$data['score_type'] ));
		
		log_message('debug', 'Setting/clout_score_settings:: [1] data='.json_encode($data));
		$this->load->view('setting/score_settings_dashboard', $data);
	}
	
	
	
	
	
	# The store score settings dashboard
	function store_score_settings()
	{
		log_message('debug', 'Setting/store_score_settings');
		$data = filter_forwarded_data($this);
		$data['score_type'] = 'store';
		$data['scoreSettingsList'] = $this->_api->get('setting/score_settings_list', array('limit'=>'200', 'scoreType'=>$data['score_type'] ));

		log_message('debug', 'Setting/store_score_settings:: [1] data='.json_encode($data));
		$this->load->view('setting/score_settings_dashboard', $data);
	}
	
	
	
	
	
	
	# The rule settings dashboard
	function update_score_value()
	{
		log_message('debug', 'Setting/update_score_value');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/update_score_value:: [1] data='.json_encode($data));
		# Saving the value
		if(!empty($data['a']) && $data['a'] == 'save'){
			$result = $this->_api->post('setting/score_value', array(
				'settingId'=>$data['d'], 
				'scoreValue'=>$_POST['value'],
				'scoreType'=>$data['t']
			)); 
			
			log_message('debug', 'Setting/update_score_value:: [2] result='.json_encode($result));
			if(!empty($result['success']) && $result['success'] == 'TRUE') echo "SUCCESS";
			else echo "ERROR: ";
		}
		else {
			$this->load->view('setting/score_value', $data);
		}		
	}
	
	
	
	
	
	
	# The rule settings dashboard
	function rule_settings()
	{
		log_message('debug', 'Setting/rule_settings');
		$data = filter_forwarded_data($this);
		$data['ruleSettingsList'] = $this->_api->get('setting/rule_settings_list', array('limit'=>'20' ));
		
		log_message('debug', 'Setting/rule_settings:: [1] data='.json_encode($data));
		$this->load->view('setting/rule_settings_dashboard', $data);
	}
	
	
	
	
	
	# Update the list values
	function update_list_value()
	{
		log_message('debug', 'Setting/update_list_value');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/update_list_value:: [1] data='.json_encode($data));
		# Saving the value
		if(!empty($data['a']) && $data['a'] == 'save'){
			$result = $this->_api->post('setting/setting_value', array(
				'settingId'=>$data['d'], 
				'settingValue'=>$_POST['value'],
				'settingType'=>$data['t']
			)); 
			
			log_message('debug', 'Setting/update_list_value:: [2] result='.json_encode($result));
			if(!empty($result['success']) && $result['success'] == 'TRUE') echo "SUCCESS";
			else echo "ERROR: ";
		}
		else {
			$this->load->view('setting/list_value', $data);
		}	
	}
	
	
	
	
	
	
	# Change the status of a rule setting
	function change_rule_setting_status()
	{
		log_message('debug', 'Setting/change_rule_setting_status');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/change_rule_setting_status:: [1] post='.json_encode($_POST));
		if(!empty($_POST['value']) && !empty($data['d'])){
			$result = $this->_api->post('setting/rule_setting_status', array(
				'ruleId'=>$data['d'], 
				'status'=>($_POST['value'] == 'ON'? 'active': 'inactive') 
			)); 
			
			log_message('debug', 'Setting/change_rule_setting_status:: [2] result='.json_encode($result));
			if(!empty($result['success']) && $result['success'] == 'TRUE') echo "SUCCESS";
			else echo "ERROR: ";
		}
	}
	
	
	
	
	# delete a permission group
	function delete_permission_group()
	{
		log_message('debug', 'Setting/delete_permission_group');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Setting/delete_permission_group:: [1] post='.json_encode($_POST));
		if(!empty($_POST['item_id'])){
			$result = $this->_api->post('setting/delete_permission_group', array(
				'groupId'=>$_POST['item_id']
			)); 
			
			log_message('debug', 'Setting/delete_permission_group:: [2] result='.json_encode($result));
			if(!empty($result['success']) && $result['success'] == 'TRUE') echo "SUCCESS";
			else echo "ERROR: ";
		}
	}
	
	
}

/* End of controller file */