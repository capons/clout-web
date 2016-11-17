<?php

/**
 * This class manages interaction with API.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/03/2015
 */
class _api extends CI_Model
{

	# Constructor to set some default values at class load
	public function __construct()
    {
        parent::__construct();
    }


	# GET data from the API
	function get($url, $variables=array())
	{
		log_message('debug', '_api/get');
		log_message('debug', '_api/get:: [1] url='.$url.' variables='.json_encode($variables));
		# Is an ID attached to the URL
		if(strpos($url, '/CT',3) !== FALSE) $url = str_replace('/CT','?apiId=CT',$url);
		$result = $this->execute('GET', $url, $variables);
		#TODO: Add handling result with errors

		return $result;
	}




	# POST data to the API
	function post($url, $variables=array(), $files=array())
	{
		log_message('debug', '_api/post');
		log_message('debug', '_api/post:: [1] url='.$url.' variables='.json_encode($variables).' files='.json_encode($files));
		$result = $this->execute('POST', $url, $variables, $files);
		#TODO: Add handling result with errors
		return $result;
	}




	# DELETE data to the API
	function delete($url, $variables=array())
	{
		log_message('debug', '_api/delete');
		log_message('debug', '_api/delete:: [1] url='.$url.' variables='.json_encode($variables));
		$result = $this->execute('DELETE', $url, $variables);
		#TODO: Add handling result with errors
		return $result;
	}




	# PUT data from the API
	function put($url, $variables=array())
	{
		log_message('debug', '_api/put');
		log_message('debug', '_api/put:: [1] url='.$url.' variables='.json_encode($variables));
		$result = $this->execute('PUT', $url, $variables);
		#TODO: Add handling result with errors
		return $result;
	}


	/**
	* Execute a request
	* RESERVED KEY WORDS in the data[] array:
	* "__check" = echo the [GET version] URL on which the command is being run
	* "__test" = possible new API end-point or operation. When in development environment,
	* 	the back-end developers are notified by email the first time it is called so that
	*	the full functionality can be added.
	*/
	function execute($type, $partUrl, $data=array(), $files=array())
	{
		log_message('debug', '_api/execute');
		log_message('debug', '_api/execute:: [1] type='.$type.' partUrl='.$partUrl.' data='.json_encode($data).' files='.json_encode($files));
		# if this is a local environment and the user is testing, stop here.
		if(ENVIRONMENT == 'local' && !empty($data['__test'])) return $data['__test'];


		# Add tracking information
		if(empty($data['userId']) && $this->native_session->get('__user_id')) $data['userId'] = format_id($this->native_session->get('__user_id'));
		if(empty($data['organizationId']) && $this->native_session->get('__organization_id')) $data['organizationId'] = format_id($this->native_session->get('__organization_id'));
		if(empty($data['userIp'])) $data['userIp'] = get_ip_address();
		if(empty($data['userDevice'])) $data['userDevice'] = get_user_device();
		if(empty($data['userBrowser'])) $data['userBrowser'] = $this->agent->browser();
		# Check if the user has set the longitude and latitude and include them in the api sent
		if(empty($data['latitude']) && $this->native_session->get('__latitude')) $data['latitude'] = $this->native_session->get('__latitude');
		if(empty($data['longitude']) && $this->native_session->get('__longitude')) $data['longitude'] = $this->native_session->get('__longitude');


		#Handle posting files
		if(!empty($files))
		{
			foreach($files AS $fileName=>$file) $data[$fileName] = array('name'=>'store_'.strtotime('now').'.jpg','file'=>'@'.$file['tmp_name'], 'fileName'=>$file['name']);
		}

		#Initialize the cURL
		$curl = curl_init();

		#Set the cURL options
		#---------------------------------------------------------------
		curl_setopt($curl, CURLOPT_URL, ($type == 'GET'? API_URL.$partUrl.(strpos($partUrl,'?') !== false? '&': '?').http_build_query($data): API_URL.$partUrl));

		# THIS LINE IS FOR TESTING/TROUBLESHOOTING ONLY
		if(!empty($data['__check'])) echo PHP_EOL.PHP_EOL.PHP_EOL.(API_URL.$partUrl.(strpos($partUrl,'?') !== false? '&': '?').http_build_query($data));

		#Set the method options based on the type
		if($type == 'GET') curl_setopt($curl, CURLOPT_POST, 0);
		if($type == 'POST') curl_setopt($curl, CURLOPT_POST, 1);
		if($type == 'PUT') curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    	if($type == 'DELETE') curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');

		#Header options
		$header = array('Content-Type: application/json', 'X-APPLICATION-ID: web-1.3.0', 'X-API-KEY: '.API_KEY);

		#Set the post fields
		if(!empty($data) && $type != 'GET')
		{
			$data = json_encode($data);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			array_push($header, 'Content-Length: ' . strlen($data));
		}

		#Set HTTP header options
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

		#Return the result
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		#Set the user agent
		curl_setopt($curl, CURLOPT_USERAGENT, 'Clout-Web/1.3.0 Web/1.3.0a');
		#---------------------------------------------------------------

		#Execute the cURL
		$result = curl_exec($curl);
		curl_close($curl);

		log_message('debug', '_api/execute:: [2] result='.json_encode($result));
		#Return the result from the cURL execution
		return json_decode($result, TRUE);
	}

}


?>
