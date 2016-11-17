<?php
/**
 * This file contains functions that are used in a number of classes or views.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/03/2015
 */




# Filter forwarded data to get only the passed variables
# In addition, it picks out all non-zero data from a URl array to be passed to a form
function filter_forwarded_data($obj, $urlDataArray=array(), $reroutedUrlDataArray=array(), $noOfPartsToIgnore=RETRIEVE_URL_DATA_IGNORE)
{
	log_message('debug', 'common_functions_helper/filter_forwarded_data');
	# Get the passed details into the url data array if any
	$urlData = $obj->uri->uri_to_assoc($noOfPartsToIgnore, $urlDataArray);
	
	$dataArray = array();
	
	
	foreach($urlData AS $key=>$value)
	{
		if($value !== FALSE && trim($value) != '' && !array_key_exists($value, $urlData))
		{
			if($value == '_'){
				$dataArray[$key] = '';
			} else {
				$dataArray[$key] = $value;
			}
		}
	}
	
	#handle re-routed URL data
	if(!empty($reroutedUrlDataArray))
	{
		$urlInfo = $obj->uri->ruri_to_assoc(3);
		foreach($reroutedUrlDataArray AS $urlKey)
		{
			if(!empty($urlInfo[$urlKey]))
			{
				$dataArray[$urlKey] = $urlInfo[$urlKey];
			}
		}
	}
	
	return restore_bad_chars_in_array($dataArray);
}




# Restore bar chars in an array
function restore_bad_chars_in_array($goodArray)
{
	log_message('debug', 'common_functions_helper/restore_bad_chars_in_array');
	$badArray = array();
	
	foreach($goodArray AS $key=>$item)
	{
		$badArray[$key] = restore_bad_chars($item);
	}
	
	return $badArray;
}




# Replace placeholders for bad characters in a text passed in URL with their actual characters
function restore_bad_chars($goodString)
{
	log_message('debug', 'common_functions_helper/restore_bad_chars');
	$badString = '';
	$badChars = array("'", "\"", "\\", "(", ")", "/", "<", ">", "!", "#", "@", "%", "&", "?", "$", ",", " ", ":", ";", "=", "*");
	$replaceChars = array("_QUOTE_", "_DOUBLEQUOTE_", "_BACKSLASH_", "_OPENPARENTHESIS_", "_CLOSEPARENTHESIS_", "_FORWARDSLASH_", "_OPENCODE_", "_CLOSECODE_", "_EXCLAMATION_", "_HASH_", "_EACH_", "_PERCENT_", "_AND_", "_QUESTION_", "_DOLLAR_", "_COMMA_", "_SPACE_", "_FULLCOLON_", "_SEMICOLON_", "_EQUAL_", "_ASTERISK_");
	
	foreach($replaceChars AS $pos => $charEquivalent)
	{
		$badString = str_replace($charEquivalent, $badChars[$pos], $goodString);
		$goodString = $badString;
	}
	
	return $badString;
}





# Replace placeholders for bad characters in a text passed in URL with their actual characters
function replace_bad_chars($badString)
{
	log_message('debug', 'common_functions_helper/replace_bad_chars');
	$badChars = array("'", "\"", "\\", "(", ")", "/", "<", ">", "!", "#", "@", "%", "&", "?", "$", ",", " ", ":", ";", "=", "*");
	$replaceChars = array("_QUOTE_", "_DOUBLEQUOTE_", "_BACKSLASH_", "_OPENPARENTHESIS_", "_CLOSEPARENTHESIS_", "_FORWARDSLASH_", "_OPENCODE_", "_CLOSECODE_", "_EXCLAMATION_", "_HASH_", "_EACH_", "_PERCENT_", "_AND_", "_QUESTION_", "_DOLLAR_", "_COMMA_", "_SPACE_", "_FULLCOLON_", "_SEMICOLON_", "_EQUAL_", "_ASTERISK_");
	
	$goodString = $badString;
	foreach($badChars AS $pos => $char) $goodString = str_replace($char, $replaceChars[$pos], $goodString);
	
	return $goodString;
}



# Load labels of a page from a flat file into the variable list to be used on a view
function load_page_labels($page, $data=array())
{
	log_message('debug', 'common_functions_helper/load_page_labels');
	$lines = file(LABEL_DIRECTORY.$page.'.txt', FILE_IGNORE_NEW_LINES);
	$labels = array();
	
	foreach($lines AS $line)
	{
		#Read each variable and its value into the array
		if( strncmp($line,">>",2) == 0) 
		{
			$variable = substr($line, 2, (strpos($line, '=')-2) );
			$labels[$variable] = substr($line, (strpos($line, '=')+1));
		} 
		else if(!empty($labels[$variable]))  
		{
			$labels[$variable] .= '<br>'.$line;
		}
	}
	
	return array_merge($data, $labels);
}





# Encrypts the entered values
function encrypt_value($value)
{
	log_message('debug', 'common_functions_helper/encrypt_value');
	$num = strlen($value);
	$numIndex = $num-1;
	$newValue="";
		
	#Reverse the order of characters
	for($x=0;$x<strlen($value);$x++){
		$newValue .= substr($value,$numIndex,1);
		$numIndex--;
	}
		
	#Encode the reversed value
	$newValue = base64_encode($newValue);
	return $newValue;
}
	
	
# Decrypts the entered values
function decrypt_value($dvalue)
{
	log_message('debug', 'common_functions_helper/decrypt_value');
	#Decode value
	$dvalue = base64_decode($dvalue);
		
	$dnum = strlen($dvalue);
	$dnumIndex = $dnum-1;
	$newDvalue = "";
		
	#Reverse the order of characters
	for($x=0;$x<strlen($dvalue);$x++){
		$newDvalue .= substr($dvalue,$dnumIndex,1);
		$dnumIndex--;
	}
	return $newDvalue;
}






# Minify a list of files
function minify_js($page, $files) 
{
	log_message('debug', 'common_functions_helper/minify_js');
	$string = "";
	# Minify and show the minified version
	if(MINIFY)
	{
		$fileLocation = HOME_URL.'assets/js/';
		# If the file exists, just return the file, else create the minified version
		if(!file_exists($fileLocation.'__'.$page.'.min.js'))
		{
			require_once(HOME_URL.'external_libraries/minifiers/JSMin.php');
			foreach($files AS $file)
			{
				$min = JSMin::minify(file_get_contents($fileLocation.$file));
  				file_put_contents($fileLocation.'__'.$page.'.min.js', $min, FILE_APPEND);
			}
		}
		$string = "<script type='text/javascript' src='".base_url()."assets/js/__".$page.".min.js'></script>"; 
	}
	# List the files out one by one
	else
	{
		foreach($files AS $file) $string .= "<script type='text/javascript' src='".base_url()."assets/js/".$file."'></script>";
	}
	
	return $string;
}


# Function to redirect a user from an iframe
function redirect_from_iframe($url)
{
	log_message('debug', 'common_functions_helper/redirect_from_iframe');
	echo "<script type='text/javascript'>window.top.location.href = '".$url."';</script>";exit;
}




# Returns the AJAX constructor to a page where needed
function get_ajax_constructor($needsAjax, $extraIds=array())
{
	log_message('debug', 'common_functions_helper/get_ajax_constructor');
	$ajaxString = "";
	
	if($needsAjax)
	{
		$ajaxString = "<script language=\"javascript\"  type=\"text/javascript\">".
							"var http = getHTTPObject();";
							
		if(!empty($extraIds))
		{
			foreach($extraIds AS $id)
			{
				$ajaxString .=  "var ".$id." = getHTTPObject();";
			}
		}					
		$ajaxString .=  "</script>";
	}
	return $ajaxString;
}





# Returns the passed message with the appropriate formating based on whether it is an error or not
function format_notice($obj, $msg)
{
	log_message('debug', 'common_functions_helper/format_notice');
	$style = "border-radius: 5px;
	-moz-border-radius: 5px;";
	
	# Error message. look for "WARNING:" in the message
	if(strcasecmp(substr($msg, 0, 8), 'WARNING:') == 0)
	{
		$msgString = "<table width='100%' border='0' cellspacing='0' cellpadding='5' style=\"".$style."border:0px;\">".
						"<tr><td width='1%' class='error' style='border:0px;padding:5px;min-width:0px;' nowrap>".str_replace("WARNING:", "<img src='".base_url()."assets/images/warning.png' border='0'/></td><td  class='error'  style='font-size:13px; color:#000;border:0px; word-wrap: break-word;' width='99%' valign='middle'>", $msg)."</td></tr>".
					  "</table>";
	}
	# Error message. look for "ERROR:" in the message
	else if(strcasecmp(substr($msg, 0, 6), 'ERROR:') == 0)
	{
		$msgString = "<table width='100%' border='0' cellspacing='0' cellpadding='5' style=\"".$style."border:0px;\">".
						"<tr><td class='error' style='border:0px;padding:5px;min-width:0px;' width='1%' nowrap>".str_replace("ERROR:", "<img src='".base_url()."assets/images/error.png'  border='0'/></td><td  width='99%' class='error'  style='font-size:13px;border:0px; word-wrap: break-word;' valign='middle'>", $msg)."</td></tr>".
					  "</table>";
	}
	
	#Normal Message
	else
	{
		$msgString = "<table width='100%' border='0' cellspacing='0' cellpadding='5' style=\"".$style."border:0px;\">".
						"<tr><td class='message' style='border:0px; word-wrap: break-word;'>".$msg."</td></tr>".
					  "</table>";
	}
	
	return $msgString;
}





#Function to fomart a notice string to the appropriate color
function format_status($status)
{
	log_message('debug', 'common_functions_helper/format_status');
	$status = strtolower($status);
	$statusString = str_replace('_', ' ', $status);
	
	if(in_array($status, array('pending','suspended','inactive','unopened')))
	{
		$statusString = "<span class='orange'>".$statusString."</span>";
	}
	elseif(in_array($status, array('joined','active','already_member','member','accepted')))
	{
		$statusString = "<span class='green'>".$statusString."</span>";
	}
	elseif(in_array($status, array('bounced','blocked','deleted','not_eligible','declined','cancelled')))
	{
		$statusString = "<span class='red'>".$statusString."</span>";
	}
	elseif(in_array($status, array('read','clicked')))
	{
		$statusString = "<span class='blue'>".$statusString."</span>";
	}
	
	return $statusString;
}





# Replace content links
function replace_content_links($stringWithLinks, $linkArray, $classes=array())
{
	log_message('debug', 'common_functions_helper/replace_content_links');
	$finalString = $stringWithLinks;
	foreach($linkArray AS $key=>$value)
	{
		$finalString = str_replace('<'.$key.'>', "<a href='".$value."' ".(!empty($classes)? "class='".implode(' ',$classes)."'": "")." >", $finalString);
		
		$finalString = str_replace('</'.$key.'>', "</a>", $finalString);
	}
	
	return $finalString;
}











#Function to format a number to a desired length and format
function format_number($number, $maxCharLength=100, $decimalPlaces=2, $singleChar=TRUE, $hasCommas=TRUE, $forceFloat=FALSE)
{
	log_message('debug', 'common_functions_helper/format_number');
	#first strip any formatting;
    $number = (0+str_replace(",","",$number));
    #is this a number?
    if(!is_numeric($number)) return false;
	
	#now format it based on desired length and other instructions
    if($number > 1000000000000 && $maxCharLength < 13) return number_format(($number/1000000000000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'T': ' trillion');
    else if($number > 1000000000 && $maxCharLength < 10) return number_format(($number/1000000000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'B': ' billion');
    else if($number > 1000000 && $maxCharLength < 7) return number_format(($number/1000000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'M': ' million');
    else if($number > 1000 && $maxCharLength < 4) return number_format(($number/1000),$decimalPlaces, '.', ($hasCommas? ',': '')).($singleChar? 'K': ' thousand');
	else return number_format($number,((is_float($number) || $forceFloat)? $decimalPlaces: 0), '.', ($hasCommas? ',': ''));
}





# Format telephone for display
function format_telephone($number)
{
	log_message('debug', 'common_functions_helper/format_telephone');
	if(strlen($number) > 10) {
		$oldNumber = $number;
		$number = substr($number, -10);
		$countryCode = str_replace($number, '', $oldNumber);
	}
	
	if(preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $number,  $matches))
	{
    	$result = (!empty($countryCode)? '+'.$countryCode.' ': '').'('.$matches[1] . ') '.$matches[2] .'-'.$matches[3];
    	return $result;
	}
	else return $number;
}



# Format ID for display
function format_id($id)
{
	log_message('debug', 'common_functions_helper/format_id');
	return !empty($id)? "CT".str_pad(dechex($id),10,'0',STR_PAD_LEFT): "";
}


# Extract an ID from the API user friendly ID
function extract_id($id)
{
	log_message('debug', 'common_functions_helper/extract_id');
	return !empty($id)? hexdec(substr($id, 2)): "";
}




#Remove an array item from the given items and return the final array
function remove_item($item, $fullArray)
{
	log_message('debug', 'common_functions_helper/remove_item');
	#First remove the item from the array list
	unset($fullArray[array_search($item, $fullArray)]);
	
	return $fullArray;
}






	
	


#Function to get current user's IP address
function get_ip_address()
{
	log_message('debug', 'common_functions_helper/get_ip_address');
	$ip = "";
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return (ENVIRONMENT == 'development' || (!empty($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== FALSE))? DEFAULT_IP: $ip;
}





# Get the user device
function get_user_device()
{
	log_message('debug', 'common_functions_helper/get_user_device');
	if(stripos($_SERVER['HTTP_USER_AGENT'],"iPod")) return 'iPod';
	if(stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")) return 'iPhone';
	if(stripos($_SERVER['HTTP_USER_AGENT'],"iPad")) return 'iPad';
	if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")) return 'Android';
	if(stripos($_SERVER['HTTP_USER_AGENT'],"web")) return 'Web';
	
	return 'Other';
}



# Get the user browser
# IMPORTED from stackoverflow
function get_user_browser()
{ 
	log_message('debug', 'common_functions_helper/get_user_browser');
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
	 $ub = ""; 

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return "userAgent:".$u_agent.",name:".$bname.",version:".$version.",platform:".$platform.",pattern:".$pattern;
} 







# Add real html tags
function real_tags($string)
{
	log_message('debug', 'common_functions_helper/real_tags');
	$tags = array('<b red>', '<b green>', '<b>', '</b>');
	$realTags = array("<span class='bold red'>", "<span class='bold green'>", "<span class='bold'>", '</span>');	
		
	$finalString = $string;
	foreach($tags AS $index=>$tag){
		$finalString = str_replace($tag, $realTags[$index], $finalString);
	}
	
	return $finalString;
}





#Checks whether an array key that begins or ends in a value is in the passed array
function array_key_contains($keyPart, $array)
{
	log_message('debug', 'common_functions_helper/array_key_contains');
	$keys = array_keys($array);
	$theKey = '';
	$exists = FALSE;
	
	foreach($keys AS $key)
	{
		if(strpos($key, $keyPart) !== FALSE)
		{
			$exists = TRUE;
			$theKey = $key;
			break;
		}
	}
	
	return array('bool'=>$exists, 'key'=>$theKey);
}






# Formats an epoch date for display on the UI
function format_epoch_date($epochDate, $format, $default='&nbsp;')
{
	log_message('debug', 'common_functions_helper/format_epoch_date');
	$epochDate = trim($epochDate);
	
	if(!empty($epochDate)){
		$dateObj = new DateTime();
		$dateObj->setTimestamp(intval($epochDate));
		return $dateObj->format($format);
	}
	else return $default;
}



# Get column as array from a multi-row array
function get_column_from_multi_array($array, $column)
{
	log_message('debug', 'common_functions_helper/get_column_from_multi_array');
	$final = array();
	$firstItem = current($array);
	
	if(isset($firstItem[$column])){
		foreach($array AS $row) array_push($final, $row[$column]);
	}

	return $final;
}





# Get the message stored in the session to be shown at the given area
function get_session_msg($obj)
{
	log_message('debug', 'common_functions_helper/get_session_msg');
	$msg = $obj->native_session->get('msg')? $obj->native_session->get('msg'): "";
	$obj->native_session->delete('msg');
	
	return $msg;
}



	
	
# Format text for inline-edit
function format_inline_edit($category, $string, $id)
{
	log_message('debug', 'common_functions_helper/format_inline_edit');
	$matches = array();
	preg_match_all("^\[(.*?)\]^",$string, $matches, PREG_PATTERN_ORDER);
	
	foreach($matches[1] AS $key=>$phrase){
		$keyValue = explode('=', $phrase);
		$keyArray = explode('|', $keyValue[0]);
		$valueArray = explode('|', $keyValue[1]);
		
		$fieldHTML = "<a href='javascript:;' data-id='edit_".$keyArray[0]."_".$id."' class='edit-in-line' data-actionurl='".$category."/update_list_value/t/".$keyArray[0]."/v/".replace_bad_chars($valueArray[0])."/d/".$id.(!empty($valueArray[1])? "/h/".replace_bad_chars($valueArray[0]): '').(!empty($keyArray[1])? '/w/'.$keyArray[1]: '')."' title='Click to edit'>".str_replace(',', ', ', $valueArray[0])."</a>"; 
		
		$string = str_replace($matches[0][$key], $fieldHTML, $string);
	}
	
	return $string;
}




# restore session values
function restore_session_variables($obj, $data) 
{
	log_message('debug', 'common_functions_helper/restore_session_variables');
	$results = array();
	foreach($data as $value) {
		$results[str_replace('__', '', $value)] = $obj->native_session->get($value);
	}
	return $results;
}




# Add data to unchageable user session
function add_to_user_session($obj, $data)
{
	log_message('debug', 'common_functions_helper/add_to_user_session');
	foreach($data AS $key=>$value) {
		$obj->native_session->set('__'.$key, $value);
	}
}




# clear user session
function clear_user_session($obj)
{
	log_message('debug', 'common_functions_helper/clear_user_session');
	@session_unset();
	@session_destroy();
	$obj->native_session->delete('__user_id');
	$obj->native_session->delete('__user_type');
	$obj->native_session->delete_all();
}





#limit string length
function limit_string_length($string, $maxLength, $ignoreSpaces=TRUE, $endString='..')
{
	log_message('debug', 'common_functions_helper/limit_string_length');
    if (strlen(html_entity_decode($string, ENT_QUOTES)) <= $maxLength) return $string;
	
	if(!$ignoreSpaces)
	{
    	$newString = substr($string, 0, $maxLength);
		$newString = (substr($newString, -1, 1) != ' ')?substr($newString, 0, strrpos($newString, " ")) : $string;
	}
	else
	{
		$newString = substr(html_entity_decode($string, ENT_QUOTES), 0, $maxLength);
		if(strpos($newString, '&') !== FALSE)
		{
			$newString = substr($newString, 0, strrpos($newString, " "));
		}
	}
	
    return $newString.$endString;
}




# Function to upload a photo
function upload_temp_file($postData, $fileField, $newFileStub, $allowedExtensions='jpeg,jpg')
{
	log_message('debug', 'common_functions_helper/upload_temp_file');
	# Check if the temp folder exists in the uploads folder. If it does not, create it
	if(!is_dir(UPLOAD_DIRECTORY.'temp')) mkdir(UPLOAD_DIRECTORY.'temp', 0777); 
	$extension =  strtolower(pathinfo($postData[$fileField]['name'],PATHINFO_EXTENSION));
	
	if(in_array($extension, explode(',',$allowedExtensions))) {
		$fileName = $newFileStub.strtotime('now').'.'.$extension;
		if (move_uploaded_file($postData[$fileField]["tmp_name"], UPLOAD_DIRECTORY.'temp/'.$fileName)){
			return $fileName;
		}
		else return "";
	}
}












#Function to provide the difference of two dates in a desired format
# Key to stop showing unless it is zero and then the next lowest will be returned
function format_date_interval($startDate, $endDate, $returnArray=TRUE, $minKey='days')
{
	log_message('debug', 'common_functions_helper/format_date_interval');
    $datetime1 = date_create($startDate);
	$datetime2 = (!empty($endDate)? date_create($endDate): date_create());
	$interval = date_diff($datetime1, $datetime2);
	
	$date['years'] = $interval->y;
	$date['months'] = $interval->m;
	$date['days'] = $interval->d;
	$date['hours'] = $interval->h;
	$date['minutes'] = $interval->i;
	
	$finalDate = array();
	$passedMinKey = FALSE;
	
	foreach($date AS $key=>$value) {
		if($key != $minKey && !empty($value)) {
			$finalDate[$key] = $value;
			if($passedMinKey) break;
		}
		
		if($key == $minKey) {
			$passedMinKey = TRUE;
			if(!empty($value)) $finalDate[$key] = $value;
		}
	}
	
	if(!$returnArray){
		$dateString = "";
		foreach($finalDate AS $key=>$value) $dateString .= $value.' '.$key.',';
		
		return trim($dateString, ',');
	}
	else return $finalDate;
}








# checks user access rights to a certain area of the system
function check_access($obj, $permission='', $categories=array())
{
	log_message('debug', 'common_functions_helper/check_access');
	# simply checking if the user is logged in
	if((empty($permission) && empty($categories)) || (!empty($permission) && $permission == '__redirect')){
		$userId = $obj->native_session->get('__user_id');
		
		# take appropriate action based on passed values
		if(!empty($permission) && empty($userId)){
			$obj->native_session->set('msg', 'WARNING: You are no longer logged in. <br>Please login again to continue');
			redirect(base_url().'account/log_out');
		}
		else if(empty($permission)) return !empty($userId);
	}
	
	# checking for real permission
	else {
		$list = $obj->native_session->get('__permissions');
		# checking access - go through the user's permissions
		if(!empty($list) && empty($categories)){ //if login not working remove empty($categories)
		    $auth_result = array();
            $auth_result['cat'] = FALSE;
            $auth_result['per'] = FALSE;
			foreach($list AS $category=>$permissions){
				if(!empty($categories) && in_array($category, $categories))
				    return TRUE;
				if(!empty($permission) && in_array($permission, $permissions))
				    return TRUE;
			}
		} else if (!empty($list)) {   //if login dont working remove else if statement
            $auth_result = array();
            $auth_result['cat'] = FALSE;
            $auth_result['per'] = FALSE;
            foreach($list AS $category=>$permissions){
                if(!empty($categories) && in_array($category, $categories))
                  $auth_result['cat'] = TRUE;
                if(!empty($permission) && in_array($permission, $permissions))
                  $auth_result['per'] = TRUE;
            }
            if(!in_array(FALSE,$auth_result)){
                return TRUE;
            }
        }
	}
	return FALSE;
}

# Run on API
function run_on_api($url, $data, $runType='POST', $returnType='array')
{
		log_message('debug', 'common_functions_helper/run_on_api');
		#Prepare for sending
		$ch = curl_init();
    	
		#GET the data
		if($runType == 'GET')
		{
			$string = http_build_query($data);
			curl_setopt($ch, CURLOPT_URL, $url.'?'.$string); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, '10000');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		}
		
		
		#POST the data
		else if($runType == 'POST')
		{
			$string = json_encode($data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($string)));
    		curl_setopt($ch, CURLOPT_URL, $url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
   			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    		curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
       	 	curl_setopt($ch, CURLOPT_POSTFIELDS,  $string);
       		curl_setopt($ch, CURLOPT_POST, 1);
		}
		#Other send run options
		else
		{
			$string = http_build_query($data);
			curl_setopt($ch, CURLOPT_URL, $url.'?'.$string); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, '10000');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $runType);
		}
		
   		#Run the value as passed
		$result = curl_exec($ch);
			
		#Show error
   		if (curl_errno($ch)) 
		{
        	$error = curl_error($ch); 
			$errorResult = array('code' => 404, 'message' => 'system error', 'resolve' => $error ); 
    	} 
		#Close the channel
		curl_close($ch);
		
		
    	
		
		#Determine the type of data to return
		if($returnType == 'string')
		{
			return !empty($error)? $error: $result;
		}
		else
		{
			return !empty($errorResult)? $errorResult: json_decode($result, TRUE);
		}
}



# check if a URL exists
function url_exists($url){
	$headers=get_headers($url);
	return stripos($headers[0],"200 OK")? true:false;
}






?>