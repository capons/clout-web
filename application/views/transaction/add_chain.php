<?php 
$containerLayer = !empty($chainId)? 'editchain_div__'.$descriptorId.'_'.$chainId : 'addchain_div__'.$descriptorId;

#Editing the chain website
if(!empty($chainType) && $chainType == 'chain_website')
{
	echo "<table class='microform ignoreclear'>
		
		<tr>
		<td><input type='text' class='smalltextfield do-not-clear' data-categoryid='".$descriptorId."' id='locationwebsite_".$descriptorId."' name='locationwebsite_".$descriptorId."' placeholder='Enter Website' value='".$details['website']."' style='width:200px;' />
		</td></tr>
		
		<tr><td>
		<button id='save_".$descriptorId."' name='save_".$descriptorId."' class='green smallbtn save-new-location' data-value='".$descriptorId."' ".
		(!empty($chainId)? "data-chainid='".$chainId."'": '')
		.(!empty($displayArea)? "data-displayarea='".$displayArea."'": '')
		." data-targeturl='transaction/save_website'>Save</button>
		&nbsp; <button id='cancel_".$descriptorId."' name='cancel_".$descriptorId."' class='grey smallbtn' onclick=\"toggleLayersOnCondition('".$containerLayer."', '".$containerLayer."')\">Cancel</button>
		</td></tr>
		</table>";		
}


#Editing the chain store
else if(!empty($chainType) && $chainType == 'store')
{
	echo "<table class='microform ignoreclear'>
		
		<tr>
		<td><input type='text' class='smalltextfield do-not-clear' data-categoryid='".$descriptorId."' id='locationaddress_".$descriptorId."' name='locationaddress_".$descriptorId."' placeholder='Enter Location Address' value='".(!empty($details['address'])? $details['address']: '')."' style='width:200px;' />
		</td>
		<td><input type='text' class='smalltextfield' id='locationzipcode_".$descriptorId."' name='locationzipcode_".$descriptorId."' value='".(!empty($details['zipcode'])? $details['zipcode']: '')."' style='min-width:80px;width:80px;' placeholder='Zip Code'/></td>
		</tr>
		
		<tr><td>
		<button id='save_".$descriptorId."' name='save_".$descriptorId."' class='green smallbtn save-new-location' data-value='".$descriptorId."' ".
		(!empty($chainId)? "data-chainid='".$chainId."'": '')
		.(!empty($displayArea)? "data-displayarea='".$displayArea."'": '')
		." data-targeturl='transaction/save_store' data-chaintype='".$chainType."'>Save</button>
		&nbsp; <button id='cancel_".$descriptorId."' name='cancel_".$descriptorId."' class='grey smallbtn' onclick=\"toggleLayersOnCondition('".$containerLayer."', '".$containerLayer."')\">Cancel</button>"
		.(!empty($storeId)? "<input type='hidden' id='storeid_".$descriptorId."' name='storeid_".$descriptorId."' value='".$storeId."' />": '')
		."</td></tr>
		</table>";
		
		
		
}



# Adding or editing the full chain
else
{

echo "<table class='microform ignoreclear'>
		
		<tr>
		<td style='width:1%;'><input type='text' class='smalltextfield do-not-clear' data-categoryid='".$descriptorId."' id='locationname_".$descriptorId."' name='locationname_".$descriptorId."' placeholder='Enter New Chain Name' value='".(!empty($details['chain_name'])? $details['chain_name']: '')."' style='width:200px;' /></td>
		<td><select id='locationcategory_".$descriptorId."__level1categories' name='locationcategory_".$descriptorId."__level1categories' class='small-drop-down' value='' style='min-width:130px; width:233px;' placeholder='Select a Category' 
		onchange=\"passTextValue('locationcategory_".$descriptorId."__level1categories')\"
		/>".get_option_list($this, 'level1categories', 'select','', array('selected'=>(!empty($details['category_id'])? $details['category_id']: '')))."</select>
		<input type='hidden' id='locationcategory_".$descriptorId."__level1categories_text' name='locationcategory_".$descriptorId."__level1categories_text' value='".(!empty($details['category'])? $details['category']: '')."' /></td>
		</tr>";

if(empty($chainId)){		
	echo "<tr>
		<td><input type='text' class='smalltextfield optional' id='locationaddress_".$descriptorId."' name='locationaddress_".$descriptorId."' placeholder='Enter Location Address (Optional)' value='' style='width:200px;' /></td>
		<td><input type='text' class='smalltextfield optional' id='locationzipcode_".$descriptorId."' name='locationzipcode_".$descriptorId."' value='' style='min-width:80px;width:80px;' placeholder='Zip Code (Optional)'/> 
		<input type='text' class='smalltextfield optional' id='locationwebsite_".$descriptorId."' name='locationwebsite_".$descriptorId."' value='' style='min-width:150px;width:150px;' placeholder='Website (Optional)'/></td>
		</tr>";
}


echo "<tr>
		<td colspan='2'>";
		
if(empty($chainId)){		
	echo "<button id='googlesearch_".$descriptorId."' name='googlesearch_".$descriptorId."' class='blue smallbtn submitmicrobtn'>Google Search</button>
		&nbsp; ";
}

echo "<button id='save_".$descriptorId."' name='save_".$descriptorId."' class='green smallbtn save-new-location' data-value='".$descriptorId."' ".
		(!empty($chainId)? "data-chainid='".$chainId."'": '')
		.(!empty($displayArea)? "data-displayarea='".$displayArea."'": '')
		.">Save</button>
		&nbsp; <button id='cancel_".$descriptorId."' name='cancel_".$descriptorId."' class='grey smallbtn' onclick=\"toggleLayersOnCondition('".$containerLayer."', '".$containerLayer."')\">Cancel</button>
		
		<input type='hidden' id='chainname_".$descriptorId."' name='chainname_".$descriptorId."' value='".(!empty($details['chain_name'])? $details['chain_name']: '')."' />
		<input type='hidden' id='btnaction' name='btnaction' value='google_search' />
		<input type='hidden' id='action' name='action' value='".base_url()."transaction/chain_search/d/".$descriptorId.(!empty($chainId)? '/s/'.$chainId.'/t/'.$chainType: '')."' />
		<input type='hidden' id='resultsdiv' name='resultsdiv' value='googleresults_".$descriptorId."' />
		</td>
		</tr>
		<tr>
		<td colspan='2'><div id='chainlinks_".$descriptorId."' style='width:100%;'>";

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
}

?>