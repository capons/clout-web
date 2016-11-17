<?php 
$containerLayer = !empty($storeId)? 'editstore__'.$descriptorId.'_'.$storeId: 'more_location__'.$descriptorId;

echo "<table class='microform ignoreclear'>
		
		<tr>
		<td style='width:1%;'><input type='text' class='smalltextfield searchable do-not-clear' data-categoryid='".$descriptorId."' id='locationname_".$descriptorId."__storenames' name='locationname_".$descriptorId."__storenames' placeholder='Enter New Location Name' value='".(!empty($details['store_name'])? $details['store_name']: '')."' style='width:200px;' /></td>
		<td><select id='locationcategory_".$descriptorId."__level1categories' name='locationcategory_".$descriptorId."__level1categories' class='small-drop-down' value='' style='min-width:130px; width:233px;' placeholder='Select a Category'/>".get_option_list($this, 'level1categories', 'select','', array('selected'=>(!empty($details['store_category'])? $details['store_category']: '')))."</select></td>
		</tr>
		
		<tr>
		<td><input type='text' class='smalltextfield' id='locationaddress_".$descriptorId."' name='locationaddress_".$descriptorId."' placeholder='Enter Location Address' value='".(!empty($details['address'])? $details['address']: '')."' style='width:200px;' /></td>
		<td><input type='text' class='smalltextfield' id='locationzipcode_".$descriptorId."' name='locationzipcode_".$descriptorId."' value='".(!empty($details['zipcode'])? $details['zipcode']: '')."' style='min-width:80px;width:80px;' placeholder='Zip Code'/> 
		<input type='text' class='smalltextfield optional' id='locationwebsite_".$descriptorId."' name='locationwebsite_".$descriptorId."' value='".(!empty($details['website'])? $details['website']: '')."' style='min-width:150px;width:150px;' placeholder='Website (Optional)'/></td>
		</tr>
		
		<tr>
		<td colspan='2'>
		<button id='search_".$descriptorId."' name='search_".$descriptorId."' onclick=\"assignFieldValue('btnaction','system_search')\" class='blue smallbtn submitmicrobtn'>System Search</button>
		&nbsp; <button id='googlesearch_".$descriptorId."' name='googlesearch_".$descriptorId."' onclick=\"assignFieldValue('btnaction','google_search')\" class='blue smallbtn submitmicrobtn'>Google Search</button>
		&nbsp; <button id='save_".$descriptorId."' name='save_".$descriptorId."' class='green smallbtn save-new-store' data-value='".$descriptorId."' ".(!empty($storeId)? "data-storeid='".$storeId."'": '').(!empty($storeType)? " data-storetype='".$storeType."'": '').">Save</button>
		&nbsp; <button id='cancel_".$descriptorId."' name='cancel_".$descriptorId."' class='grey smallbtn' onclick=\"toggleLayersOnCondition('".$containerLayer."', '".$containerLayer."')\">Cancel</button>
		
		<input type='hidden' id='chainname_".$descriptorId."' name='chainname_".$descriptorId."' value='".(!empty($details['chain_name'])? $details['chain_name']: '')."' />
		<input type='hidden' id='btnaction' name='btnaction' value='system_search' />
		<input type='hidden' id='action' name='action' value='".base_url()."transaction/store_search/d/".$descriptorId.(!empty($storeId)? '/s/'.$storeId.'/t/'.$storeType: '')."' />
		<input type='hidden' id='resultsdiv' name='resultsdiv' value='googleresults_".$descriptorId."' />
		</td>
		</tr>
		<tr>
		<td colspan='2'><div id='storelinks_".$descriptorId."' style='width:100%;'>";

if(!empty($details['links'])){
	foreach($details['links'] AS $link){
		echo "<div class='delete-icon'><a href='".$link['link']."' id='".$link['link_id']."' target='_blank'>".html_entity_decode($link['link_text'], ENT_QUOTES)."</a><input type='hidden' id='links_".$descriptorId."_".$link['link_id']."' name='links_".$descriptorId."[]' value='".$link['link'].'||'.addslashes(html_entity_decode($link['link_text'], ENT_QUOTES))."' /> </div>";
	}
}

echo "</div></td>
		</tr>
		
		<tr>
		<td colspan='2'><div id='googleresults_".$descriptorId."' style='width:100%;'></div></td>
		</tr>
		</table>";

?>