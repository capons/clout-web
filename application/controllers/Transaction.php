<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing transaction information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 07/28/2015
 */
class Transaction extends CI_Controller 
{
	# The transaction matching by  home
	function match_by_each()
	{
		log_message('debug', 'Transaction/match_by_each');
		$data = filter_forwarded_data($this);
		$data['transactionList'] = $this->_api->get('transaction/list', array('dataType'=>'transaction_list', 'limit'=>'20', 'offset'=>'0' ));
		
		log_message('debug', 'Transaction/match_by_each:: [1] data='.json_encode($data));
		$this->load->view('transaction/match_by_each', $data);
	}
	
	
	
	# The transaction matching home
	function match_by_descriptor()
	{
		log_message('debug', 'Transaction/match_by_descriptor');
		$data = filter_forwarded_data($this);
		$data['descriptorList'] = $this->_api->get('transaction/descriptor', array('dataType'=>'descriptor_list', 'limit'=>'20' ));
		
		log_message('debug', 'Transaction/match_by_descriptor:: [1] data='.json_encode($data));
		$this->load->view('transaction/match_by_descriptor', $data);
	}
	
	
	
	
	
	
	# Show the descriptor change history
	function change_history()
	{
		log_message('debug', 'Transaction/change_history');
		$data = filter_forwarded_data($this);
		
		if(!empty($data['i']))
		{
			$data['descriptorId'] = $data['i'];
			$data['changeList'] = $this->_api->get('transaction/change', array('dataType'=>'change_list', 'dataId'=>$data['i'] ));
		}
		
		log_message('debug', 'Transaction/change_history:: [1] data='.json_encode($data));
		$this->load->view('transaction/change_list_container', $data);
	}
	
	
	
	# Show the descriptor scope
	function descriptor_scope()
	{
		log_message('debug', 'Transaction/descriptor_scope');
		$data = filter_forwarded_data($this);
		# Do not proceed without a descriptor ID
		if(!empty($data['i']))
		{
			$data['scopeList'] = $this->_api->get('transaction/descriptor', array('dataType'=>'scope_list', 'descriptorId'=>$data['i']));
			$data['problemFlags'] = $this->_api->get('transaction/descriptor', array('dataType'=>'problem_flags', 'descriptorId'=>$data['i']));
			$data['descriptorId'] = $data['i'];
		}
		
		log_message('debug', 'Transaction/descriptor_scope:: [1] data='.json_encode($data));
		$this->load->view('transaction/descriptor_scope', $data);
	}
	
	
	
	
	
	# Update the descriptor scope
	function update_descriptor_scope()
	{
		log_message('debug', 'Transaction/update_descriptor_scope');
		$data = filter_forwarded_data($this);
		
		$postCheck = array_key_contains('scope_', $_POST);
		
		log_message('debug', 'Transaction/update_descriptor_scope:: [1] postCheck='.json_encode($postCheck));
		if($postCheck['bool'] && !empty($_POST[$postCheck['key']][0])){
			# Extract relevant IDs
			$posted = $this->extract_descriptor_id_and_flags($_POST);
			$actionValueParts = explode('-', $_POST['verify_'.$posted['descriptor_id']]);
			
			# Then post to the API
			$result = $this->_api->post('transaction/update_scope', array('descriptorId'=>$posted['descriptor_id'], 'scopeId'=>$_POST[$postCheck['key']][0], 'action'=>$actionValueParts[0], 'otherDetails'=>$posted['flag_details']));
			
			log_message('debug', 'Transaction/update_descriptor_scope:: [1] result='.$result);
			# If successful, echo the new scope to fill the current scope's area
			if($result['result'] == 'SUCCESS' && !empty($result['newScope'])) echo $result['newScope'];
			else if($result['result'] == 'FAIL') echo "ERROR";
		}
		else echo "ERROR";
	}
	
	
	
	
	
	
	
	# Show the descriptor categories
	function descriptor_category()
	{
		log_message('debug', 'Transaction/descriptor_category');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/descriptor_category:: [1] data='.json_encode($data));
		# Do not proceed without a descriptor ID
		if(!empty($data['i']))
		{
			$data['categoryList'] = $this->_api->get('transaction/descriptor', array('dataType'=>'category_list', 'descriptorId'=>$data['i']));
			$data['problemFlags'] = $this->_api->get('transaction/descriptor', array('dataType'=>'problem_flags', 'descriptorId'=>$data['i']));
			$data['descriptorId'] = $data['i'];
		}
		if(empty($data['categoryList'])) $data['msg'] = "ERROR: No categories could be resolved for this descriptor.";
		
		log_message('debug', 'Transaction/descriptor_category:: [2] data='.json_encode($data));
		$this->load->view('transaction/descriptor_category', $data);
	}
	
	
	
	
	
	# Update the descriptor category
	function update_descriptor_category()
	{
		log_message('debug', 'Transaction/update_descriptor_category');
		$data = filter_forwarded_data($this);
		
		$postCheck = array_key_contains('subcategory__', $_POST);
		
		log_message('debug', 'Transaction/update_descriptor_category:: [1] postCheck='.json_encode($postCheck));
		if($postCheck['bool'] && !empty($_POST[$postCheck['key']][0])){
			# Extract relevant IDs
			$posted = $this->extract_descriptor_id_and_flags($_POST);
			$actionValueParts = explode('-', $_POST['verify_'.$posted['descriptor_id']]);
			$checkboxList = $this->extract_from_checkboxes('subcategory__', $_POST);
			log_message('debug', 'checkboxList: '.json_encode($checkboxList));
			# Then post to the API
			$result = $this->_api->post('transaction/update_categories', array('descriptorId'=>$posted['descriptor_id'], 'subCategories'=>$checkboxList['sub_categories'], 'suggestedSubCategories'=>$checkboxList['suggested_sub_categories'], 'action'=>$actionValueParts[0], 'otherDetails'=>$posted['flag_details']));
			log_message('debug', 'Transaction/update_descriptor_category:: [1] result='.$result);
			# If successful, echo the new scope to fill the current scope's area
			if(!empty($result['result']) && $result['result'] == 'SUCCESS' && !empty($result['sampleCategory'])) echo $result['sampleCategory'];
			else if(!empty($result['result']) && $result['result'] == 'FAIL') echo "ERROR";
		}
		else echo "ERROR";
		
	}
	
	
	
	
	# Show the descriptor location
	function descriptor_location()
	{
		log_message('debug', 'Transaction/descriptor_location');
		
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/descriptor_location:: [1] data='.json_encode($data));
		# Do not proceed without a descriptor ID
		if(!empty($data['i']))
		{
			$data['locationList'] = $this->_api->get('transaction/descriptor', array('dataType'=>'location_list', 'descriptorId'=>$data['i']));
			
			$data['problemFlags'] = $this->_api->get('transaction/descriptor', array('dataType'=>'problem_flags', 'descriptorId'=>$data['i']));
			$data['descriptorId'] = $data['i'];
		}
		
		if(empty($data['locationList'])) $data['msg'] = "WARNING: No locations could be resolved for this descriptor.";
		if(empty($data['descriptorId'])) $data['msg'] = "ERROR: No locations could be resolved for this descriptor.";
		
		log_message('debug', 'Transaction/descriptor_location:: [2] data='.json_encode($data));
		$this->load->view('transaction/descriptor_location', $data);
	}
	
	
	
	
	
	# Confirm descriptor location update
	function update_descriptor_location()
	{
		log_message('debug', 'Transaction/update_descriptor_location');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/update_descriptor_location:: [1] post='.json_encode($_POST));
		if(!empty($_POST)){
			# Extract relevant IDs
			$posted = $this->extract_descriptor_id_and_flags($_POST);
			$actionValueParts = explode('-', $_POST['verify_'.$posted['descriptor_id']]);
			$chain = !empty($_POST['chain_'.$posted['descriptor_id']])? $_POST['chain_'.$posted['descriptor_id']][0]:'';
			$store = !empty($_POST['store_'.$posted['descriptor_id']])? $_POST['store_'.$posted['descriptor_id']][0]:'';
			
			# Then post to the API
			$result = $this->_api->post('transaction/update_location', array('descriptorId'=>$posted['descriptor_id'], 'chain'=>$chain, 'store'=>$store, 'action'=>$actionValueParts[0], 'otherDetails'=>$posted['flag_details']));
			log_message('debug', 'Transaction/update_descriptor_location:: [2] result='.$result);
			# If successful, echo the new location count to fill the current location's area
			if($result['result'] == 'SUCCESS') echo $result['locationCount'].' locations';
			else if($result['result'] == 'FAIL') echo "ERROR: ";
		}
		else echo "ERROR:";
	}
	
	
	
	
	# Extract relevant data from checkbox list
	function extract_from_checkboxes($fieldStub, $data)
	{
		log_message('debug', 'Transaction/extract_from_checkboxes');
		log_message('debug', 'Transaction/extract_from_checkboxes:: [1] $fieldStub='.$fieldStub.' data='.json_encode($data));
		$subCategories = array();
		$suggestedSubCategories = array();
		
		foreach($data AS $key=>$group){
			# We are looking at the relevant fields in the data only
			if(strpos($key, $fieldStub) !== FALSE){
				# Category ID
				$groupId = str_replace($fieldStub, '', $key); 
				
				# Sort the ids based on the status of the items
				foreach($group AS $id){
					if(strpos($id, '__') !== FALSE){
						$idKeyParts = explode('__', $id);
						# $suggestedSubCategories[categoryId] = array(suggested sub-category id);
						if(empty($suggestedSubCategories[$groupId])) $suggestedSubCategories[$groupId] = array($idKeyParts[0]);
						else array_push($suggestedSubCategories[$groupId], $idKeyParts[0]);
					}
					# Normal approved categories
					else {
						# $subCategories[categoryId] = array(sub-category id);
						if(empty($subCategories[$groupId])) $subCategories[$groupId] = array($id);
						else array_push($subCategories[$groupId], $id);
					}
				}
			}
		}
		
		log_message('debug', 'Transaction/extract_from_checkboxes:: [2] return='.json_encode(array('sub_categories'=> $subCategories, 'suggested_sub_categories'=> $suggestedSubCategories)));
		return array('sub_categories'=> $subCategories, 'suggested_sub_categories'=> $suggestedSubCategories);
	}
	
	
	
	
	# Extract the descriptor ID and flag details if any
	function extract_descriptor_id_and_flags($data)
	{
		log_message('debug', 'Transaction/extract_descriptor_id_and_flags');
		log_message('debug', 'Transaction/extract_descriptor_id_and_flags:: [1] data='.json_encode($data));
		$flagCheck = array_key_contains('flag_', $data);
		$keyParts = explode('_', $flagCheck['key']);
		# Collect any other details
		$details = array();
		if(!empty($data['flag_'.$keyParts[1]])) $details['flags'] = $data['flag_'.$keyParts[1]];
		if(!empty($data['flag_'.$keyParts[1].'_notes'])) $details['notes'] = $data['flag_'.$keyParts[1].'_notes'];
		
		log_message('debug', 'Transaction/extract_from_checkboxes:: [2] return='.json_encode(array('descriptor_id'=>$keyParts[1], 'flag_details'=>$details)));
		return array('descriptor_id'=>$keyParts[1], 'flag_details'=>$details);
	}
	
	
	
	
	
	# Show the flags attached to a transaction change
	function flag_list()
	{
		log_message('debug', 'Transaction/flag_list');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/flag_list:: [1] data='.json_encode($data));
		# Do not proceed without a descriptor ID
		if(!empty($data['i'])) {
			$data['flagList'] = $this->_api->get('transaction/change', array('dataType'=>'user_flags', 'dataId'=>$data['i']));
		}
		if(empty($data['flagList'])) $data['msg'] = "ERROR: No flags could be resolved for this change.";
		
		$data['area'] = 'change_flag_list';
		
		log_message('debug', 'Transaction/flag_list:: [2] data='.json_encode($data));
		$this->load->view('transaction/flags', $data);
	}
	
	
	
	# Delete a change flag
	function delete_change_flag()
	{
		log_message('debug', 'Transaction/delete_change_flag');
		$data = filter_forwarded_data($this);
		# Do not proceed without a descriptor ID
		if(!empty($_POST['item_id'])) {
			$success = $this->_api->post('transaction/delete_flag', array('dataType'=>'user_flag', 'flagId'=>$_POST['item_id'], 'stage'=>'submit' ));
			log_message('debug', 'Transaction/flag_list:: [1] return='.$success['result']);
			echo $success['result'];
		}
	}
	
	
	
	
	
	# Add a flag item
	function add_flag()
	{
		log_message('debug', 'Transaction/add_flag');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/flag_list:: [1] post='.json_encode($_POST));
		# Add a new flag
		if(!empty($_POST)){
			$success['result'] = 'FAIL';
			
			if(!empty($_POST['item_id']) && !empty($_POST['displayed_value'])){
				$success = $this->_api->post('transaction/add_flag', array(
					'dataType'=>'user_flag', 
					'changeId'=>$_POST['item_id'],
					'displayedValue'=>$_POST['displayed_value'],
					'hiddenValue'=>$_POST['hidden_value'], 
					'stage'=>'submit'
				));
			}
			
			log_message('debug', 'Transaction/flag_list:: [2] return='.$success['result']);
			echo $success['result'];
		}
		# Simply displaying the form
		else
		{
			$data['area'] = 'flag_form';
			$this->load->view('transaction/flags', $data);
		}
	}
	
	
	
	
	
	
	# Add a new sub-category
	function add_sub_category()
	{
		log_message('debug', 'Transaction/add_sub_category');
		$data = filter_forwarded_data($this);
		$result = 'ERROR: ';
			
		log_message('debug', 'Transaction/add_sub_category:: [1] post='.json_encode($_POST));
		log_message('debug', 'Transaction/add_sub_category:: [2] data='.json_encode($data));
		# Add a new sub category
		if(!empty($_POST)){
			if(!empty($data['c']) && !empty($_POST['subCategory'])){
				$success = $this->_api->post('transaction/add_sub_category', array(
					'descriptorId'=>$_POST['descriptorId'],
					'categoryId'=>$data['c'],
					'newSubCategory'=>$_POST['subCategory'],
					'action'=>'verify'
				));
				
				log_message('debug', 'Transaction/add_sub_category:: [3] success='.json_encode($success));
				if(!empty($success['result']) && $success['result'] == 'SUCCESS' && !empty($success['new_sub_category_id'])) {
					$subUnitId = $data['c'].'_'.$_POST['descriptorId'];
					echo "<input type='checkbox' id='subcategory__".$subUnitId."' name='subcategory__".$data['c']."[]' value='".$success['new_sub_category_id']."' checked/><label class='text-label' for='subcategory__".$subUnitId."'>".$_POST['subCategory']."</label><br>";
				}
				else if(!empty($success['result'])) echo 'ERROR: ';
			}
			else echo $result;
		}
		
		
		
	}
	
	
	
	
	
	
	
	# Add a  chain/store suggestion 
	function add_chain_suggestion()
	{
		log_message('debug', 'Transaction/add_chain_suggestion');
		$data = filter_forwarded_data($this);
			
		log_message('debug', 'Transaction/add_chain_suggestion:: [1] post='.json_encode($_POST));
		log_message('debug', 'Transaction/add_chain_suggestion:: [2] data='.json_encode($data));
		# Check if there is posted data
		if(!empty($_POST)){
			# $data['d'] = descriptor ID
			if(!empty($data['d'])){
				
				$success = $this->_api->post('store/suggest', array(
					'name'=>$_POST['locationname_'.$data['d']],
					'address'=>(!empty($_POST['locationaddress_'.$data['d']])? $_POST['locationaddress_'.$data['d']]: ''),
					'level1Category'=>$_POST['locationcategory_'.$data['d'].'__level1categories'],
					'zipcode'=>(!empty($_POST['locationzipcode_'.$data['d']])? $_POST['locationzipcode_'.$data['d']]: ''),
					'website'=>(!empty($_POST['locationwebsite_'.$data['d']])? $_POST['locationwebsite_'.$data['d']]: ''),
					'descriptorId'=>$data['d'],
					'referenceLinks'=>(!empty($_POST['links_'.$data['d']])? $_POST['links_'.$data['d']]: array()),
					'chainId'=>(!empty($data['c'])? $data['c']: ''),
					'chainType'=>(!empty($data['t'])? $data['t']: '')
				));
				
				log_message('debug', 'Transaction/add_sub_category:: [3] success='.json_encode($success));
				if(!empty($success['result']) && $success['result'] == 'SUCCESS' && !empty($success['new_chain_id'])) {
					$idStub = $data['d']."__".$success['new_chain_id'];
					
					$rowHtml = $_POST['locationname_'.$data['d']]." &nbsp; | &nbsp; ".$_POST['locationcategory_'.$data['d'].'__level1categories_text'];
					
					# Add row html
					if(!empty($data['c'])){
						echo $rowHtml;
					}
					else 
					{
						$fullHtml= "<tr>
		<td>
		<div class='accordion-row no-framing selected'><div>
			<input type='radio' id='chain_".$idStub."' name='chain_".$data['d']."[]' value='".$success['new_chain_id']."' checked /><label class='text-label' for='chain_".$idStub."'>".$rowHtml."</label> &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$success['new_chain_id']."' data-type='chain' data-categoryid='".$data['d']."' data-fortarget='chain_".$idStub."'>edit</a>
		</div>
		
		<div style='padding-left:20px;'>";
		
		# Add the default options
		$fullHtml .= "<input type='radio' id='store_".$data['d']."_".$success['new_chain_id']."' name='store_".$data['d']."[]' value='notsure' ".(empty($_POST['locationwebsite_'.$data['d']]) && empty($_POST['locationaddress_'.$data['d']])? 'checked': '')."/><label class='text-label' for='store_".$data['d']."'>Not sure which location</label>
		
		<br><input type='radio' id='store_".$data['d']."_".$success['new_chain_id']."_www' name='store_".$data['d']."[]' value='website' ".(!empty($_POST['locationwebsite_'.$data['d']]) && empty($_POST['locationaddress_'.$data['d']])? 'checked': '')."/><label class='text-label' for='store_".$data['d']."_www'>".(!empty($_POST['locationwebsite_'.$data['d']])? $_POST['locationwebsite_'.$data['d']]: 'www')."</label>  &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$success['new_chain_id']."' data-type='chain_website' data-categoryid='".$data['d']."' data-fortarget='store_".$data['d']."_".$success['new_chain_id']."_www'>edit</a>";
		
		# Add any other options available
		if(!empty($_POST['locationaddress_'.$data['d']]) && !empty($success['new_store_id'])){
			$fullHtml .= "<br><input type='radio' id='store_".$data['d']."_".$success['new_store_id']."' name='store_".$data['d']."[]' value='' checked/><label class='text-label' for='store_".$data['d']."_".$success['new_store_id']."'>".$_POST['locationaddress_'.$data['d']].' '.$_POST['locationzipcode_'.$data['d']]."</label>  &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$success['new_chain_id']."' data-storeid='".$success['new_store_id']."' data-type='store' data-categoryid='".$data['d']."' data-fortarget='store_".$data['d']."_".$success['new_store_id']."'>edit</a>";
		}
		
		$fullHtml .= "
		<br><a href='javascript:;'>Add Location</a>
		</div>
		</td> 
		</tr>";
		
					echo $fullHtml;
				}
				}
				
				if(!empty($success['result']) && $success['result'] == 'FAIL' ){
					echo "ERROR: This chain already exist.";
				}else if((!empty($success['result']) && $success['result'] == 'SUCCESS' ) && empty($success['new_chain_id'])){
					echo "ERROR: We could not process your submission.";
				}
			}
			else echo 'ERROR: We could not submit the chain';
		}
		
		else
		{
			$data['descriptorId'] = $data['d'];
			$data['chainId'] = $data['c'];
			$data['chainType'] = $data['t'];
			$data['displayArea'] = !empty($data['a'])? $data['a']:'';
			$data['storeId'] = !empty($data['s'])? $data['s']:'';
			
			# If editing a store
			if(!empty($data['storeId'])){
				$data['details'] = $this->_api->get('store/edit_store_details', array('storeId'=>$data['storeId']));
			}
			# If not adding a new store
			else if($data['displayArea'] != 'store')
			{
				$data['details'] = $this->_api->get('store/edit_chain_details', array('chainId'=>$data['chainId'], 'chainType'=>$data['chainType']));
			}
			
			log_message('debug', 'Transaction/add_chain_suggestion:: [4] data='.json_encode($data));
			$this->load->view('transaction/add_chain', $data);
		}
	}
	
	
	
	
	
	
	# Save website
	function save_website()
	{
		log_message('debug', 'Transaction/add_chain_suggestion');
		$data = filter_forwarded_data($this);
			
		log_message('debug', 'Transaction/add_chain_suggestion:: [1] post='.json_encode($_POST));
		log_message('debug', 'Transaction/add_chain_suggestion:: [2] data='.json_encode($data));
		# Check if there is posted data
		if(!empty($_POST) && !empty($data['d']) && !empty($data['c'])){
			$success = $this->_api->post('store/edit_chain_details', array(
				'fields'=>array('website'), 
				'fieldValues'=>array('website'=>(!empty($_POST['locationwebsite_'.$data['d']])? $_POST['locationwebsite_'.$data['d']]: '')), 
				'chainId'=>(!empty($data['c'])? $data['c']: '')
			));
			
			log_message('debug', 'Transaction/add_sub_category:: [3] success='.json_encode($success));
			if(!empty($success['result']) && $success['result'] == 'SUCCESS'){
				echo $_POST['locationwebsite_'.$data['d']];
			}
		}
	}
	
	
	
	
	
	
	# Save store
	function save_store()
	{
		log_message('debug', 'Transaction/save_store');
		$data = filter_forwarded_data($this);
			
		log_message('debug', 'Transaction/save_store:: [1] post='.json_encode($_POST));
		log_message('debug', 'Transaction/save_store:: [2] data='.json_encode($data));
		# Check if there is posted data
		if(!empty($_POST) && !empty($data['d']) && !empty($data['c'])){
			$success = $this->_api->post('store/edit_store_details', array(
				'storeId'=>(!empty($_POST['storeid_'.$data['d']])? $_POST['storeid_'.$data['d']]: ''),
				'fields'=>array('address_line_1','zipcode'), 
				'fieldValues'=>array(
					'address_line_1'=>(!empty($_POST['locationaddress_'.$data['d']])? $_POST['locationaddress_'.$data['d']]: ''),
					'zipcode'=>(!empty($_POST['locationzipcode_'.$data['d']])? $_POST['locationzipcode_'.$data['d']]: ''),
					'chain_id'=>$data['c'],
					'descriptor_id'=>$data['d']
				)
			));
			
			log_message('debug', 'Transaction/save_store:: [3] success='.json_encode($success));
			if(!empty($success['result']) && $success['result'] == 'SUCCESS'){
				$rowHtml = $_POST['locationaddress_'.$data['d']].' '.$_POST['locationzipcode_'.$data['d']];
				
				# This is a new store
				if(empty($_POST['storeid_'.$data['d']])){
					echo "<input type='radio' id='store_".$data['d']."_".$success['new_store_id']."' name='store_".$data['d']."[]' value=''  checked/><label class='text-label' for='store_".$data['d']."_".$success['new_store_id']."'>".$rowHtml."</label>  &nbsp; <a href='javascript:;' class='edit-chain' data-id='".$data['c']."'  data-storeid='".$success['new_store_id']."' data-type='store' data-fortarget='store_".$data['d']."_".$success['new_store_id']."'  data-categoryid='".$data['d']."'>edit</a><br>";
				}
				#This is a store edit
				else 
				{
					echo $rowHtml;
				}
			}
		}
	}
	
	
	
	
	
	
	# Search for chains
	function chain_search()
	{
		log_message('debug', 'Transaction/chain_search');
		$data = filter_forwarded_data($this);

		log_message('debug', 'Transaction/chain_search:: [1] data='.json_encode($data));
		# Check if there is posted data
		# $data['d'] = descriptor ID
		if(!empty($data['d'])){
			$data['descriptorId'] = $data['d'];
			# First time loading the list
			if(!empty($_POST)){
				$this->native_session->set('descriptorchain_'.$data['d'].'_phrase', $_POST['locationname_'.$data['d']]);
				$this->native_session->set('descriptorchain_'.$data['d'].'_address', $_POST['locationaddress_'.$data['d']]);
				$this->native_session->set('descriptorchain_'.$data['d'].'_category', $_POST['locationcategory_'.$data['d'].'__level1categories']);
				$this->native_session->set('descriptorchain_'.$data['d'].'_zipcode', $_POST['locationzipcode_'.$data['d']]);
				$this->native_session->set('descriptorchain_'.$data['d'].'_website', $_POST['locationwebsite_'.$data['d']]);
				$this->native_session->set('descriptorchain_'.$data['d'].'_searchtype', $_POST['btnaction']);
				
				$offset = 0;
				$limit = NUM_OF_ROWS_PER_PAGE;
			}
			
			# Loading subsequent lists for same search query
			if(empty($limit) && !empty($data['n'])){
				$limit = $data['n'];
				$offset = ($data['p'] - 1) * $data['n'];
			}
			
			if($this->native_session->get('descriptorchain_'.$data['d'].'_phrase') && !empty($limit)){
				$data['chainList'] = $this->_api->get('store/'.
						($this->native_session->get('descriptorchain_'.$data['d'].'_searchtype') == 'google_search'? 'google': 'list'),
					array(
					'phrase'=>$this->native_session->get('descriptorchain_'.$data['d'].'_phrase'),
					'address'=>$this->native_session->get('descriptorchain_'.$data['d'].'_address'),
					'categories'=>$this->native_session->get('descriptorchain_'.$data['d'].'_category'),
					'zipcode'=>$this->native_session->get('descriptorchain_'.$data['d'].'_zipcode'),
					'website'=>$this->native_session->get('descriptorchain_'.$data['d'].'_website'),
					'offset'=>$offset,
					'limit'=>$limit
				));
				
				
				# Where should the results be displayed?
				$data['displayArea'] = $this->native_session->get('descriptorchain_'.$data['d'].'_searchtype') == 'google_search'? 'google_search': 'system_search';
			}
		}
		
		log_message('debug', 'Transaction/chain_search:: [2] data='.json_encode($data));
		$this->load->view('transaction/chain_list', $data);
	}
	
	
	
	
	
	
	
	# View the links for the store
	function links()
	{			
		log_message('debug', 'Transaction/links');
		$data = filter_forwarded_data($this);

		log_message('debug', 'Transaction/links:: [1] data='.json_encode($data));
		if(!empty($data['id'])){
			$data['linkList'] = $this->_api->get('store/links', array('storeSuggestionId'=>$data['id']));
		}
		
		# Show a message if there are no links
		if(empty($data['linkList'])) $data['msg'] = "ERROR: No links resolved";
	
		log_message('debug', 'Transaction/links:: [2] data='.json_encode($data));
		$this->load->view('transaction/links', $data);
	}
	
	
	
	
	
	
	
	# Add a chain for a store
	function add_chain()
	{
		log_message('debug', 'Transaction/add_chain');
		$data = filter_forwarded_data($this);
		
		$data['storeId'] = (!empty($data['s'])? $data['s']: '');
		$data['storeType'] = (!empty($data['t'])? $data['t']: '');
		$data['descriptorId'] = (!empty($data['d'])? $data['d']: '');
		
		log_message('debug', 'Transaction/add_chain:: [1] post='.json_encode($_POST));
		log_message('debug', 'Transaction/add_chain:: [2] data='.json_encode($data));
		# Submitting a new chain information
		if(!empty($_POST['newchain__chainnames'])){
		
			$success = $this->_api->post('store/add_chain', array(
					'chainName'=>$_POST['newchain__chainnames'],
					'chainId'=>(!empty($_POST['newchain__chainnames__hidden'])? $_POST['newchain__chainnames__hidden']: ''),
					'storeId'=>$_POST['storeid'],
					'storeType'=>$_POST['storetype'],
					'descriptorId'=>(!empty($_POST['descriptorid'])? $_POST['descriptorid']: '')
			));
			
			log_message('debug', 'Transaction/save_store:: [3] success='.json_encode($success));
			if(!empty($success['chainName'])) echo '('.html_entity_decode($success['chainName'], ENT_QUOTES).')';
			else echo format_notice($this, "ERROR: The chain data could not be saved.");
		}
		else $this->load->view('transaction/add_chain', $data);
	}
	
	
	
	
	
	
	
	
	
	
	# Show the matching rules attached to the descriptor
	function possible_matches()
	{
		log_message('debug', 'Transaction/possible_matches');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/possible_matches:: [1] data='.json_encode($data));
		if(!empty($data['i']))
		{
			$data['ruleList'] = $this->_api->get('transaction/matching_rules', array('descriptorId'=>$data['i'], 'types'=>'chain,store' ));
			$data['problemFlags'] = $this->_api->get('transaction/descriptor', array('dataType'=>'problem_flags', 'descriptorId'=>$data['i']));
			$data['descriptorId'] = $data['i'];
		}
		
		log_message('debug', 'Transaction/possible_matches:: [2] data='.json_encode($data));		
		$this->load->view('transaction/possible_matches', $data);
	}
	
	
	
	
	
	# Save a new matching rule
	function add_match_rule()
	{
		log_message('debug', 'Transaction/add_match_rule');
		$data = filter_forwarded_data($this);
			
		log_message('debug', 'Transaction/add_match_rule:: [1] post='.json_encode($_POST));
		log_message('debug', 'Transaction/add_match_rule:: [2] data='.json_encode($data));
		# Check if there is posted data
		if(!empty($_POST)){
			# $data['d'] = descriptor ID
			if(!empty($data['d'])){
				$post = array(
					'criteria'=>$_POST['criteria_'.$data['d'].'__rulecriteria'],
					'phrase'=>$_POST['rulesearch_'.$data['d']],
					'action'=>$_POST['action_'.$data['d'].'__ruleaction'],
					'category'=>$_POST['matchcategory_'.$data['d']][0],
					'storeId'=>!empty($_POST['matchstore_'.$data['d'].'__storenames']) && !empty($_POST['matchstore_'.$data['d'].'__storenames__hidden'])? $_POST['matchstore_'.$data['d'].'__storenames__hidden']: '',
					'chainId'=>!empty($_POST['matchchain_'.$data['d'].'__chainnames']) && !empty($_POST['matchchain_'.$data['d'].'__chainnames__hidden'])? $_POST['matchchain_'.$data['d'].'__chainnames__hidden']: '',
					'descriptorId'=>$data['d']
				); 
				
				$success = $this->_api->post('transaction/add_rule',$post);
				
				log_message('debug', 'Transaction/add_match_rule:: [3] success='.json_encode($success));
				# Echo the new rule row if successful
				if(!empty($success['result']) && $success['result'] == 'SUCCESS' && !empty($success['new_rule_id'])) {
					$rowHtml = "<tr>
		<td width='1%' id='".$success['new_rule_id']."' class='list-delete-icon confirm' style='min-width:35px; padding-right: 10px;'>&nbsp;
		<input type='hidden' id='ruleid_".$post['descriptorId']."_".$success['new_rule_id']."' name='ruleid_".$post['descriptorId']."[]' value='".$post['category'].'-'.$success['new_rule_id']."' /></td>
		<td width='1%'>".strtoupper($post['action'])."</td>
		<td width='78%'>".strtoupper(str_replace('_', ' ', $post['criteria'])).": ".$post['phrase']."</td> 
		<td width='20%'>".strtoupper($post['category']).": ".
		(!empty($post['storeId'])? $_POST['matchstore_'.$post['descriptorId'].'__storenames']: 
		(!empty($post['chainId'])? $_POST['matchchain_'.$post['descriptorId'].'__chainnames']: '&nbsp;'))."</td>
		</tr>";
		
					# Add row html
					echo $rowHtml;
				}
				
				if(empty($success['new_rule_id'])){
					echo "ERROR: We could not process your submission.";
				}
			}
			else echo 'ERROR: We could not submit the rule';
		}
	}
	
	
	
	
	
	
	
	
	# Delete a matching rule
	function delete_match_rule()
	{
		log_message('debug', 'Transaction/delete_match_rule');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/delete_match_rule:: [1] post='.json_encode($_POST));
		# Do not proceed without a descriptor ID
		if(!empty($_POST['item_id'])) {
			$success = $this->_api->post('transaction/delete_rule', array('ruleId'=>$_POST['item_id'], 'stage'=>'submit' ));
			log_message('debug', 'Transaction/delete_match_rule:: [2] success='.json_encode($success));
			echo $success['result'];
		}
	}
	
	
	
		
	
	
	
	
	# Confirm rule update
	function update_possible_matches()
	{
		log_message('debug', 'Transaction/update_possible_matches');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Transaction/update_possible_matches:: [1] post='.json_encode($_POST));
		if(!empty($_POST)){
			# Extract relevant IDs
			$posted = $this->extract_descriptor_id_and_flags($_POST);
			$actionValueParts = explode('-', $_POST['verify_'.$posted['descriptor_id']]);
			$rules = (!empty($_POST['ruleid_'.$posted['descriptor_id']])? $_POST['ruleid_'.$posted['descriptor_id']]:array());
			
			# Then post to the API
			$result = $this->_api->post('transaction/update_matches', array('descriptorId'=>$posted['descriptor_id'], 'ruleIds'=>$rules, 'action'=>$actionValueParts[0], 'otherDetails'=>$posted['flag_details']));
			log_message('debug', 'Transaction/update_possible_matches:: [2] $result='.$result['result']);
			# If not successful notify about the error
			if($result['result'] == 'FAIL') echo "ERROR: ";
		}
		else echo "ERROR:";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	







	# Show the transaction categories
	function transaction_category()
	{
		log_message('debug', 'Transaction/transaction_category');
		$data = filter_forwarded_data($this);
	
		log_message('debug', 'Transaction/transaction_category:: [1] data='.json_encode($data));
		# Do not proceed without a descriptor ID
		if(!empty($data['i']))
		{
			$data['categoryList'] = $this->_api->get('transaction/list', array('dataType'=>'category_list', 'transactionId'=>$data['i']));
			$data['transactionId'] = $data['i'];
		}
		if(empty($data['categoryList'])) $data['msg'] = "ERROR: No categories could be resolved for this transaction.";
	
		log_message('debug', 'Transaction/transaction_category:: [2] data='.json_encode($data));
		$this->load->view('transaction/transaction_category', $data);
	}
	
	
	
	
	
	# update the transaction category
	function update_transaction_category()
	{
		log_message('debug', 'Transaction/update_transaction_category');
		$data = filter_forwarded_data($this);
	
		$postCheck = array_key_contains('subcategory__', $_POST);
		
		log_message('debug', 'Transaction/update_transaction_category:: [1] postCheck='.json_encode($postCheck));
		if($postCheck['bool'] && !empty($_POST[$postCheck['key']][0])){
			$checkboxList = $this->extract_from_checkboxes('subcategory__', $_POST);
			log_message('debug', 'checkboxList: '.json_encode($checkboxList));
			# then post to the API
			$result = $this->_api->post('transaction/update_transaction_categories', array('transactionId'=>$data['transaction_id'], 'subCategories'=>$checkboxList['sub_categories']));
			log_message('debug', 'Transaction/update_transaction_category:: [1] result='.$result);
			# echo the appropriate message
			echo $result['result'] == 'SUCCESS'? 'The transaction categories have been saved.': "ERROR";
		}
		else echo "ERROR";
	
	}
	
	
	
	
	
	
	# search in session for a value from the given fields
	function search_in_session()
	{
		$data = filter_forwarded_data($this);
		$list = array();
		
		# check to make sure that the required fields are provided
		if(!empty($data['id']) && !empty($data['list_name']) && !empty($data['fields']) && !empty($data['phrase'])){
			$fields = explode(',',$data['fields']);
			$phrase = $data['phrase'];
			$wholeList = $this->native_session->get($data['list_name']);
			
			foreach($wholeList AS $row){
				foreach($fields AS $field){
					if(!empty($row[$field]) && strpos(strtolower($row[$field]), strtolower($phrase)) !== FALSE) {
						$row['matched_field'] = $field;
						$list[] = $row;
						break;
					}
				}
			}
		}
		
		# show the list generated and use it to quickly select values
		if(!empty($list)){
			$selected = $this->native_session->get('category_list_selected');
			
			foreach($list AS $row){
				
				$levelName = ($row['matched_field'] == 'level_1_name'? '<b>': '').$row['level_1_name'].($row['matched_field'] == 'level_1_name'? '</b>': '')
							." &gt; "
							.($row['matched_field'] == 'level_2_name'? '<b>': '').ucwords(strtolower($row['level_2_name']))
							.($row['matched_field'] == 'level_2_name'? '</b>': '');
				$uId = $data['id']."_".$row['level_1_id']."_".$row['level_2_id'];
				
				if($row['matched_field'] == 'level_1_name'){
					if(in_array($row['level_1_id'], $selected['categories']) || in_array($row['level_2_id'], $selected['sub_categories'])) echo "<br><i>".$levelName."</i>";
					else echo "<span id='selectsubcat__".$uId."'><a href='javascript:;' onClick=\"selectCategoryItem('subcategory__".$row['level_1_id']."_".$row['level_2_id']."','selectsubcat__".$uId."');\">".$levelName."</a></span>";
				}
				else if($row['matched_field'] == 'level_2_name'){
					if(in_array($row['level_2_id'], $selected['sub_categories'])) echo "<br><i>".$levelName."</i>";
					else echo "<span id='selectsubcat__".$uId."'><a href='javascript:;' onClick=\"selectCategoryItem('subcategory__".$row['level_1_id']."_".$row['level_2_id']."','selectsubcat__".$uId."');\">".$levelName."</a></span>";
				}
			}
		}
	}
	
	
	
	
	
	
	# add a clicked item to the session
	function add_to_session()
	{
		$data = filter_forwarded_data($this);
		
		if(!empty($data['item'])){
			$selected = $this->native_session->get('category_list_selected');
			$item = explode('__',$data['item']);
			$itemIds = explode('_',$item[1]);
			
			if(!empty($itemIds[2])) $selected['sub_categories'][] = $itemIds[2];
			$this->native_session->set('category_list_selected',$selected);
		}
	}
	
	
	
	
	
	
	# show the store match form
	function store_match()
	{
		$data = filter_forwarded_data($this);
		
		
		$this->load->view('transaction/store_match', $data);
	}
	
}

/* End of controller file */