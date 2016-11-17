<?php
/**
 * This file contains functions that are used in a number of classes or views.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/19/2015
 */




# Get a list of options
# Allowed return values: [div, option]
function get_option_list($obj, $list_type, $return = 'select', $searchBy="", $more=array())
{
	$optionString = '';
	$types = array();

	switch($list_type)
	{
		case "pastyear":
			$startYear = @date('Y') - MINIMUM_SIGNUP_AGE;
			for($i=$startYear; $i>($startYear - (100 - MINIMUM_SIGNUP_AGE)); $i--)
			{
				if($return == 'div') $optionString .= "<div data-value='".$i."'>".$i."</div>";
				else $optionString .= "<option value='".$i."'>".$i."</option>";
			}
		break;


		case "monthnumber":
			for($i=1; $i<13; $i++)
			{
				$i = sprintf("%02d", $i);
				if($return == 'div') $optionString .= "<div data-value='".$i."'>".$i."</div>";
				else $optionString .= "<option value='".$i."'>".$i."</option>";
			}
		break;


		case "monthday":
			for($i=1; $i<32; $i++)
			{
				$i = sprintf("%02d", $i);
				if($return == 'div') $optionString .= "<div data-value='".$i."'>".$i."</div>";
				else $optionString .= "<option value='".$i."'>".$i."</option>";
			}
		break;


		case "phonetypes":
			$types = array('Mobile', 'Home','Office');
			foreach($types AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row."'>".$row."</div>";
				else $optionString .= "<option value='".$row."'>".$row."</option>";
			}
		break;



		case "gender":
			$types = array('Female', 'Male');
			foreach($types AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row."'>".$row."</div>";
				else $optionString .= "<option value='".$row."'>".$row."</option>";
			}
		break;


		case "provider":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$list = $obj->_api->get('provider/list', array('offset'=>0, 'limit'=>'50', 'phrase'=>$searchString));
			//$optionString = $searchString;

			if($return == 'select') $optionString = "<option value=''>Select a Provider</option>";
			//if(is_array($list)) {
				foreach ($list AS $row) {
					if ($return == 'div') $optionString .= "<div data-value='" . $row['id'] . "'>" . addslashes(html_entity_decode($row['full_carrier_name'], ENT_QUOTES)) . "</div>";
					else $optionString .= "<option value='" . $row['id'] . "' " . ((!empty($more['selected']) && $more['selected'] == $row['id']) ? 'selected' : '') . ">" . addslashes(html_entity_decode($row['full_carrier_name'], ENT_QUOTES)) . "</option>";
				}
			//}


		break;


		case "searchsortoptions":
			$types = array('Recommended', 'Best Deal', 'Distance', 'Score');
			foreach($types AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row."' onclick=\"reorderStoreItems('".str_replace(' ', '_',strtolower($row))."');\">".$row."</div>";
				else $optionString .= "<option value='".$row."' onclick=\"reorderStoreItems('".str_replace(' ', '_',strtolower($row))."');\">".$row."</option>";
			}
		break;



		case "topbanks":
			$list = $obj->_api->get('money/banks', array('offset'=>0, 'limit'=>'50', 'isFeatured'=>'Y'));

			#Put some default options not returned from the API
			if(!empty($list)) $optionString .= "<option value='all'>All Banks</option>";

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['bank_id']."'>".$row['bank_name']."</div>";
				else $optionString .= "<option value='".$row['bank_id']."'>".$row['bank_name']."</option>";
			}
			if(!empty($list)) $optionString .= "<option value='banks_not_featured'>Other Banks</option>";
		break;




		case "matchstatus":
			$list = $obj->_api->get('transaction/match_status', array('adminId'=>format_id($obj->native_session->get('__user_id')) ));

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['status_code']."'>".$row['status_string']."</div>";
				else $optionString .= "<option value='".$row['status_code']."'>".$row['status_string']."</option>";
			}
		break;




		case "admins":
			$list = $obj->_api->get('account/list', array('type'=>array('clout_owner', 'clout_admin_user'), 'limit'=>'50'));

			if(!empty($list)) $optionString .= "<option value='all'>All Admins</option>";

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".format_id($row['user_id'])."'>".$row['user_name']."</div>";
				else $optionString .= "<option value='".format_id($row['user_id'])."'>".$row['user_name']."</option>";
			}
		break;




		case "typeofchangehistory":
			$types = array('All', 'Pending', 'Flagged', 'Verified');
			foreach($types AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row."'>".$row."</div>";
				else $optionString .= "<option value='".$row."'>".$row."</option>";
			}
		break;




		case "changeflaglist":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$list = $obj->_api->get('transaction/change', array('dataType'=>'user_flag_list', 'offset'=>0, 'limit'=>'50', 'phrase'=>$searchString));

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['flag_id']."'>".html_entity_decode($row['flag_name'],ENT_QUOTES)."</div>";
				else $optionString .= "<option value='".$row['flag_id']."'>".html_entity_decode($row['flag_name'],ENT_QUOTES)."</option>";
			}
		break;



		case "level1categories":
			$list = $obj->_api->get('store/categories', array('level'=>'1'));

			$optionString = "<option value=''>Select a Category</option>";
			if(!empty($more['isFilter'])) $optionString .= "<option value='all' selected>All</option>";
			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['category_id']."'>".html_entity_decode($row['category_name'],ENT_QUOTES)."</div>";
				else $optionString .= "<option value='".$row['category_id']."' ".(!empty($more['selected']) && $more['selected']==$row['category_id']? ' selected': '').">".html_entity_decode($row['category_name'],ENT_QUOTES)."</option>";
			}
		break;



		case "storenames":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$list = $obj->_api->get('store/search', array('fields'=>'name', 'limit'=>50, 'phrase'=>$searchString));

			foreach($list AS $row)
			{
				$extraInstructions = !empty($more['area'])? '': "data-type='location' class='add-to-this-table' title='Click to add store to list'";
				if($return == 'div') $optionString .= "<div data-value='".$row['id']."' ".$extraInstructions.">".html_entity_decode($row['store_name'].' | '.$row['address_line_1'],ENT_QUOTES)."</div>";
				else $optionString .= "<option value='".$row['id']."' data-value='".$row['id']."'  ".$extraInstructions.">".html_entity_decode($row['store_name'].' | '.$row['address_line_1'],ENT_QUOTES)."</option>";
			}

			# Use this instead of the default option as default search text
			if(empty($list)){
				$optionString = ($return == 'select')? "<option value=''>Enter search phrase</option>": "<div data-value=''>Enter search phrase</div>";
			}
		break;



		case "chainnames":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$list = $obj->_api->get('store/chains', array(
				'storeId'=>(!empty($more['storeId'])? $more['storeId']: ''),
				'storeType'=>(!empty($more['storeType'])? $more['storeType']: ''),
				'phrase'=>$searchString
			));

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['chain_id']."'>".html_entity_decode($row['chain_name'],ENT_QUOTES)."</div>";
				else $optionString .= "<option value='".$row['chain_id']."'>".html_entity_decode($row['chain_name'],ENT_QUOTES)."</option>";
			}

			# Use this instead of the default option as default search text
			if(empty($list)){
				$optionString = ($return == 'select')? "<option value=''>Enter chain name to search</option>": "<div data-value=''>Enter chain name to search</div>";
			}
		break;




		case "rulecriteria":
			$types = array('contains'=>'Contains', 'starting_with'=>'Starting With', 'ending_with'=>'Ending With', 'equal_to'=>'Equal To');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;




		case "ruleactions":
			$types = array('match'=>'Match', 'reject'=>'Reject');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;



		case 'user_list_views':
			$types = array('profile'=>'Profile', 'network'=>'Network', 'activity'=>'Activity', 'money'=>'Money', 'clout_score'=>'Clout Score');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;



		case 'settingpages':
			$types = array('permission_groups'=>'Permission Groups', 'rule_settings'=>'Rule Settings', 'clout_score_settings'=>'Clout Score Settings', 'store_score_settings'=>'Store Score Settings', 'cron_jobs'=>'Cron Jobs');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;



		case 'matchinglisttypes':
			$types = array('match_by_each'=>'By Each Transaction', 'match_by_descriptor'=>'By Transaction Descriptor');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;
		
		


		case 'groupcategories':
			$types = array('all'=>'All Categories', 'admin'=>'Administrators', 'store_owner'=>'Store Owners', 'shopper'=>'Shoppers', 'merchant' => 'Merchant');

			# stop here and immediately return the array as defined
			if($return == 'array') {
				if(!empty($more['selected'])) return (!empty($types[$more['selected']])? $types[$more['selected']]: '');
				else return $types;
			}


			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;






		case "permissiongrouptypes":
			$list = $obj->_api->get('setting/group_types', array('groupCategory'=>(!empty($more['groupcategory'])? $more['groupcategory']: 'all')));

			$optionString = "<option value=''>Select a Group Type</option>";

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['type_code']."'>".$row['type_display']."</div>";
				else $optionString .= "<option value='".$row['type_code']."' ".(!empty($more['selected']) && $more['selected']==$row['type_code']? ' selected': '').">".$row['type_display']."</option>";
			}
		break;




		case "ruletypes":
			$types = $obj->_api->get('setting/rule_categories', array('limit'=>200));


			if($return == 'div') $optionString .= "<div data-value=''>Select a Category</div>";
			else $optionString .= "<option value=''>Select a Category</option>";
			//if(is_array($types)) {
				foreach ($types AS $key => $row) {
					if ($return == 'div') $optionString .= "<div data-value='" . $row['category'] . "'>" . $row['category_display'] . "</div>";
					else $optionString .= "<option value='" . $row['category'] . "'>" . $row['category_display'] . "</option>";
				}
			//}

		break;




		case "rulenames":
			if(!empty($more['rule_category'])){
				$types = $obj->_api->get('setting/rule_names', array('limit'=>200, 'category'=>$more['rule_category'] ));

				foreach($types AS $key=>$row)
				{
					if($return == 'div') $optionString .= "<div data-value='".$row['id']."'>".$row['name']."</div>";
					else $optionString .= "<option value='".$row['id']."'>".$row['name']."</option>";
				}
			}
		break;





		case "message_types":
			$types = array('perk'=>'Perk', 'cashback'=>'Cashback', 'system_message'=>'System Message');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;




		case "messagetemplates":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$types = $obj->_api->get('message/templates', array(
				'ownerId'=>format_id($obj->native_session->get('__user_id')),
				'ownerType'=>'user',
				'limit'=>'20',
				'phrase'=>$searchString));

			if (is_array($types) || is_object($types))
			{
	 			foreach($types AS $row)
	 			{
					$clickActions = "universalUpdate('template_id','".$row['template_id']."');
					universalUpdate('subject','".$row['subject']."');
					universalUpdate('sms','".$row['sms']."');
					setHtmlFieldValue('body','".$row['body']."');";

					if(!empty($row['attachment'])){
						$downloadLink = "<div><a href=\'".$row['attachment']."\' target=\'_blank\'>".basename($row['attachment'])."</a></div>";

						$clickActions .= "universalUpdate('template_attachment','".basename($row['attachment'])."');"
										 ."insertBeforeField('attachment','".$downloadLink."');";
					}

					$row['name'] = addslashes(html_entity_decode($row['name'], ENT_QUOTES));

					if($return == 'div') $optionString .= "<div data-value='".$row['template_id']."' onclick=\"".$clickActions."\">".$row['name']."</div>";
					else $optionString .= "<option value='".$row['template_id']."' onclick=\"".$clickActions."\">".$row['name']."</option>";
	 			}
			}
		break;





		case "recipientfilters":
			$types = array(''=>'Select Filter',
							'all_users'=>'All Users',
							'all_admins'=>'All Admins',
							'all_store_owners'=>'All Store Owners',
							'all_shoppers'=>'All Shoppers',
							'shoppers_without_bank_account'=>'Shoppers Without Bank Account',
							'shoppers_without_network'=>'Shoppers Without Network');

			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;



		case "banks":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			#Exclude the banks that user selected
			$banksToIgnore = $obj->native_session->get('exclude_banks') ? $obj->native_session->get('exclude_banks'): array();

			# filter options based on passed paramters
			$filter = array('offset'=>0, 'limit'=>'20');
			if(!empty($searchString)) $filter['phrase'] = $searchString;
			if(!empty($banksToIgnore)) $filter['excludeBanks'] = $banksToIgnore;
			if(empty($searchString)) $filter['isFeatured'] = 'Y';

			$list = $obj->_api->get('money/banks', $filter);

			# Add instruction as the first drop-down item
			if(!empty($list)){
				$optionString .= "<div data-value=''>Select from the list or start typing to find more banks</div>";
			# The default should give the user an option to request Clout to add the bank
			} else if(empty($list) && !empty($searchBy) && $return == 'div'){
				return !empty($optionString)? $optionString: "<div id='notFound' data-value='".$searchString."' style='color:#2DA0D1; text-decoration: underline;'>Not Found, Request to Add ".$searchString."?</div>";
			}
			//maby remove -> if input empty and we have no search data
			else if(empty($list) && empty($searchBy) && $return == 'div'){
				return '';
			}

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['bank_id']." class='shadowbox'>".html_entity_decode($row['bank_name'],ENT_QUOTES)."</div>";

				else $optionString .= "<option value='".$row['bank_id']."'>".html_entity_decode($row['banks_name'],ENT_QUOTES)."</option>";
			}

		break;





		case "storesearch":
			$list = $obj->_api->get('search/store_phrase_suggestions', array(
				'phrase'=> (!empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): ""),
				'limit'=>20
			));

			if(!empty($list)){
				foreach($list AS $row)
				{
					if($return == 'div') $optionString .= "<div data-value='".addslashes($row['suggestion'])."' onclick=\"updateFieldValue('suggestiontype<>suggestionid', '".$row['type']."<>".$row['suggestion_id']."', '');\">".addslashes(html_entity_decode($row['suggestion'],ENT_QUOTES))."</div>";
					else $optionString .= "<option value='".addslashes($row['suggestion'])."'>".addslashes(html_entity_decode($row['suggestion'],ENT_QUOTES))."</option>";
				}
			}
			# Use this instead of the default option as default search text
			else {
				$optionString = ($return == 'select')? "<option value=''>Enter search phrase</option>": "<div data-value=''>Enter search phrase</div>";
			}
		break;







		case "placesearch":
			$list = $obj->_api->get('search/store_locations', array(
				'phrase'=> (!empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "")
			));

			if(!empty($list)){
				foreach($list AS $row)
				{
					# Pad zipcode if they remove the zero left
					$row['suggestion'] = (preg_match('/^\d+$/',$row['suggestion']) && strlen($row['suggestion']) < 5)? sprintf('%05d', $row['suggestion']): $row['suggestion'];

					if($return == 'div') $optionString .= "<div data-value='".addslashes($row['suggestion'])."' ".(!empty($more['allowdelete']) && !empty($row['id'])? " class='delete-icon' data-url='search/delete_location/d/".$row['id']."' ": '').">".addslashes(html_entity_decode($row['suggestion'],ENT_QUOTES))."</div>";
					else $optionString .= "<option value='".addslashes($row['suggestion'])."'>".addslashes(html_entity_decode($row['suggestion'],ENT_QUOTES))."</option>";
				}

			}
			# Use this instead of the default option as default search text
			else {
				$optionString = ($return == 'select')? "<option value=''>Enter location name</option>": "<div data-value=''>Enter location name</div>";
			}
		break;



		case 'distanceoptions':
			$types = array('5_or_less'=>'Less Than 5 miles', '10'=>'Within 10 miles', '20'=>'Within 20 miles', '50'=>'Within 50 miles', '100'=>'Within 100 miles','any'=>'Any Distance');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;





		case 'cashbackrange':
			$types = array('2'=>'At Least 2%', '5'=>'At Least 5%', '10'=>'At Least 10%', '20'=>'At Least 20%', '30'=>'At Least 30%', '40_or_more'=>'At Least 40%');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;




		case 'csvformats':
			$types = array('csv_generic'=>'CSV - Generic File', 'csv_gmail'=>'CSV - Gmail Address Book', 'csv_outlook'=>'CSV - Outlook  Contacts', 'csv_yahoo'=>'CSV - Yahoo Address Book', 'text_commas'=>'Text File - Comma Delimited', 'text_tabs'=>'Text File - Tab Delimited');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;




		case 'messagetypes':
			$types = array('perk'=>'Perk', 'cashback'=>'Cash Back', 'system'=>'System Message');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."'>".$row."</option>";
			}
		break;




		case 'reviewgrades':
			$types = array(''=>'Select Review Grade', '1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;




		case 'addresstypes':
			$types = array('home'=>'Home', 'work'=>'Work', 'other'=>'Other');
			$optionString = '';
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;
		
		
		case 'placetypes':
			$types = array('place'=>'Place', 'unresolved'=>'Unresolved', 'digital'=>'Digital', 'special'=>'Special');
			$optionString = '';
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;



		case "states":
			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";
			$list = $obj->_api->get('search/states', array('offset'=>0, 'limit'=>'50', 'phrase'=>$searchString));

			$optionString = ($return == 'select')? "<option value=''>Select State</option>": "<div data-value=''>Select State</div>";

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['state']."'>".html_entity_decode($row['state'],ENT_QUOTES)."</div>";
				else $optionString .= "<option value='".$row['state']."' ".(!empty($more['selected']) && ($more['selected']==$row['state'] || strtoupper($more['selected'])==strtoupper($row['state_code']))? ' selected': '').">".html_entity_decode($row['state'],ENT_QUOTES)."</option>";
			}

		break;



		case "countries":
			$list = $obj->_api->get('search/countries');
			if(empty($more['selected'])) $more['selected'] = 'USA';

			foreach($list AS $row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['country_code']."'>".html_entity_decode($row['country'],ENT_QUOTES)."</div>";
				else $optionString .= "<option value='".$row['country_code']."' ".(!empty($more['selected']) && ($more['selected']==$row['country_code'] || $more['selected']==$row['country'])? ' selected': '').">".html_entity_decode($row['country'],ENT_QUOTES)."</option>";
			}

		break;





		case "user_list_actions":
			$list = $obj->_api->get('content/'.$more['type'], array('list_type'=>'users'));

			foreach($list AS $row)
			{
				if($row['action_code'] == 'send_email') $url = 'message/add';
				else $url = $more['type']== 'tags'? 'user/tags/t/'.$row['action_code']: 'user/'.$row['action_code'];

				# add any other classes to the options
				if($row['action_code'] == 'purge_user') $addnClass = " class='confirm-action'";
				else if($row['action_code'] == 'send_email') $addnClass = " class='use-shadowpage'";
				else $addnClass = "";

				if($row['action_code'] == 'send_email' && check_access($obj,'can_send_message')
				|| $row['action_code'] != 'send_email'
				){
					if($return == 'div') $optionString .= "<div data-url='".$url."'".$addnClass.">".$row['display']."</div>";
					else $optionString .= "<option value='".$url."'".$addnClass.">".$row['display']."</option>";
				}
			}

		break;








		case "permissiongroups":
			$types = $obj->_api->get('setting/permission_group_list', array(
				'category'=>(!empty($more['category'])? $more['category']: 'all'),
				'limit'=>50
				));

			if($return == 'div') $optionString .= "<div data-value=''>Select a Permission Group</div>";
			else $optionString .= "<option value=''>Select a Permission Group</option>";

			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$row['group_id']."'>".$row['group_name']."</div>";
				else $optionString .= "<option value='".$row['group_id']."' onclick=\"updateFieldLayer('".base_url()."user/change_group/g/".$row['group_id']."','','','".(!empty($more['grouplayer'])? $more['grouplayer']: 'user_group_access')."','')\" ".(!empty($more['selected']) && $more['selected']==$row['group_id']? ' selected': '').">".$row['group_name']."</option>";
			}
		break;


		case "userLinks":

			$userLinks = $obj->_api->get('network/links');

			if(!empty($userLinks)){
				foreach($userLinks AS $row) {
					$link = base_url().'r/'.$row['link_id'];
					if($return == 'div') $optionString .= "<div data-value='".$row['link_id']."'>".$link."</div>";
					else $optionString .= "<option value='".$row['link_id']."'>".$link."</option>";
				}
			} else {
				$link = base_url().'r/'.format_id($obj->native_session->get('__user_id'));
				if($return == 'div') $optionString .= "<div data-value='user_id'>".$link."</div>";
				else $optionString .= "<option value='user_id'>".$link."</option>";
			}

		break;

		case "tagNames":

			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";

			if(!empty($searchString)){

				$data_array = ["r" => $searchString, "a" => "get-tags"];
				$tags = run_on_api(DEPLOYMENT_SCRIPT_BASE."tag.php", $data_array, 'GET');
				$tags = array_reverse($tags);

				foreach($tags AS $tag) {
					if($return == 'div') $optionString .= "<div data-value='".$tag."'>".$tag."</div>";
					else $optionString .= "<option value='".$tag."'>".$tag."</option>";
				}

			} else {
				if($return == 'div') $optionString .= "<div data-value=''>No tags</div>";
				else $optionString .= "<option value=';>No tags</option>";
			}

		break;

		case 'repos':

			$searchString = !empty($searchBy)? htmlentities(restore_bad_chars($searchBy), ENT_QUOTES): "";

			$repos = array();

			$repos_dev = array('test-repo-dev'=>'test-repo-dev', 'dev-v1.3.2-backend'=>'dev-v1.3.2-backend', 'dev-v1.3.2-cron'=>'dev-v1.3.2-cron', 'dev-v1.3.2-database'=>'dev-v1.3.2-database',
			'dev-v1.3.2-iam'=>'dev-v1.3.2-iam', 'dev-v1.3.2-invite'=>'dev-v1.3.2-invite', 'dev-v1.3.2-message'=>'dev-v1.3.2-message', 'dev-v1.3.2-mysql'=>'dev-v1.3.2-mysql', 'dev-v1.3.2-scripts'=>'dev-v1.3.2-scripts',
			'dev-v1.3.2-security'=>'dev-v1.3.2-security', 'dev-v1.3.2-web'=>'dev-v1.3.2-web');

			$repos_sta =  array('test-repo-sta'=>'test-repo-sta', 'sta-v1.3.2-backend'=>'sta-v1.3.2-backend', 'sta-v1.3.2-cron'=>'sta-v1.3.2-cron', 'sta-v1.3.2-database'=>'sta-v1.3.2-database',
			'sta-v1.3.2-iam'=>'sta-v1.3.2-iam', 'sta-v1.3.2-invite'=>'sta-v1.3.2-invite', 'sta-v1.3.2-message'=>'sta-v1.3.2-message', 'sta-v1.3.2-mysql'=>'sta-v1.3.2-mysql', 'sta-v1.3.2-scripts'=>'sta-v1.3.2-scripts',
			'sta-v1.3.2-security'=>'sta-v1.3.2-security', 'sta-v1.3.2-web'=>'sta-v1.3.2-web');

			$repos_pro =  array('test-repo-pro'=>'test-repo-pro', 'pro-v1.3.2-backend'=>'pro-v1.3.2-backend', 'pro-v1.3.2-cron'=>'pro-v1.3.2-cron', 'pro-v1.3.2-database'=>'pro-v1.3.2-database', 'pro-v1.3.2-iam'=>'pro-v1.3.2-iam',
			'pro-v1.3.2-message'=>'pro-v1.3.2-message', 'pro-v1.3.2-mysql'=>'pro-v1.3.2-mysql', 'pro-v1.3.2-scripts'=>'pro-v1.3.2-scripts', 'pro-v1.3.2-security'=>'pro-v1.3.2-security',
			'pro-v1.3.2-web'=>'pro-v1.3.2-web');

			$optionString = '';

			if($searchString == 'copy_from'){
				if(check_access($obj,'can_copy_repository_changes_to_staging') && check_access($obj,'can_copy_repository_changes_to_production')){
					$repos = array_merge($repos_dev, $repos_sta);
				} else if (check_access($obj,'can_copy_repository_changes_to_staging')){
					$repos = $repos_dev;
				} else if (check_access($obj,'can_copy_repository_changes_to_production')){
					$repos = $repos_sta;
				}
			} else if ($searchString == 'copy_to') {
				if(check_access($obj,'can_copy_repository_changes_to_staging') && check_access($obj,'can_copy_repository_changes_to_production')){
					$repos = array_merge($repos_dev, $repos_sta);
				} else if (check_access($obj,'can_copy_repository_changes_to_staging')){
					$repos = $repos_dev;
				} else if (check_access($obj,'can_copy_repository_changes_to_production')){
					$repos = $repos_pro;
				}
			} else if ($searchString == 'add_tag' && check_access($obj,'can_add_repository_tag')){
				$repos = array_merge($repos_dev, $repos_sta, $repos_pro);
			}

			foreach($repos AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."'>".$row."</div>";
				else $optionString .= "<option value='".$key."' ".(!empty($more['selected']) && $more['selected']==$key? ' selected': '').">".$row."</option>";
			}
		break;

		case "switcharchived":
			$types = array('active'=>'Current', 'archived'=>'Past');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."' onclick=\"switcharchived('".$key."');\">".$row."</div>";
				else $optionString .= "<option value='".$key."' onclick=\"switcharchived('".$key."');\">".$row."</option>";
			}
		break;

		case "switcheventslist":
			$types = array('current'=>'Current', 'passed'=>'Past', 'going'=>'Going');
			foreach($types AS $key=>$row)
			{
				if($return == 'div') $optionString .= "<div data-value='".$key."' onclick=\"switcheventslist('".$key."');\">".$row."</div>";
				else $optionString .= "<option value='".$key."' onclick=\"switcheventslist('".$key."');\">".$row."</option>";
			}
		break;





	}


	# Determine which value to return
	if($return == 'objects'){
		return $types;
	}
	else if($return == 'div'){
		return !empty($optionString)? $optionString: "<div data-value=''>No Options</div>";
	}
	else {
		return !empty($optionString)? $optionString: "<option value=''>No Options</option>";
	}

}





# Get an item from a position in a drop down list
function get_list_item($array, $current, $direction, $return='key')
{
	if(array_key_exists($current, $array)){
		$keys = array_keys($array);
		$length = count($keys);
		$position = array_search($current, $keys);

		$newPosition = $position;
		if($direction == 'next') {
			$newPosition = ($position + 1) == $length? 0: ($position + 1);
		} else {
			$newPosition = ($position - 1) < 0? ($length - 1): ($position - 1);
		}

		# return the new list item
		return $return == 'value'? $array[$keys[$newPosition]]: $keys[$newPosition];
	}
	return '';
}




?>
