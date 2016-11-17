<?php
/**
 * This class generates and formats location details. 
 *
 * @author Al Zziwa <azziwa@gmail.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 07/22/2015
 */
class _location extends CI_Model
{
	#Get current location by IP
	public function get_current_location($data, $needed=array())
    {
        $returnKeys = array('address', 'latitude','longitude', 'zipcode', 'city', 'state_code', 'state', 'country_code', 'country_name');
        log_message('debug', '_location/get_current_location:: [1] data: '.json_encode($data).' needed='.json_encode($needed));
        # Update/Set the longitude and latitude if given in the data passed
        if(!empty($data['latitude'])) $this->native_session->set('__latitude', $data['latitude']);
        if(!empty($data['longitude'])) $this->native_session->set('__longitude', $data['longitude']);

        $location = $this->locate_with_api($needed);
        log_message('debug', '_location/get_current_location:: [2] location-with-api: '.json_encode($location));

        if(empty($location)) $location = $this->geolocate_local($returnKeys, $needed);
        log_message('debug', '_location/get_current_location:: [3] location-with-geolocate: '.json_encode($location));
        
        # Set the new location confidence
        if(!empty($location['confidence'])) $this->native_session->set('__location_confidence', $location['confidence']);
		
        # Fill the missing keys with blanks
        if(!empty($location)) foreach($returnKeys AS $field) if(!array_key_exists($field, $location)) $location[$field] = '';

        log_message('debug', '_location/get_current_location:: [4] location-final: '.json_encode($location));
        
        return $location;
    }
	
	
	
	
	
	# Geo-locate with an API
	function locate_with_api($needed=array())
	{
		log_message('debug', '_location/locate_with_api');
		log_message('debug', '_location/locate_with_api:: [1] needed='.json_encode($needed));
		
		$location = $final = array();
		# If we already have the latitude and longitude and they are the only ones needed, we should not run on the API
		if(!empty($needed) && count(array_diff($needed, array('latitude','longitude'))) == 0 && $this->native_session->get('__latitude') && $this->native_session->get('__longitude'))
		{
			$final['latitude'] = $this->native_session->get('__latitude');
			$final['longitude'] = $this->native_session->get('__longitude');
			$final['confidence'] = $this->native_session->get('__location_confidence')? $this->native_session->get('__location_confidence'): '1.0';
		}
		else 
		{
			# If no coordinates or fails, then try with IP address
			if(empty($location)) {
				$location = $this->locate_with_ip_info();
				# If results have latitude and longitude then re-run on google API to get approximate location
				if(!empty($location['latitude']) && !empty($location['longitude'])){
					$this->native_session->set('__latitude',$location['latitude']);
					$this->native_session->set('__longitude',$location['longitude']);
					
					$location = $this->locate_with_google_lat_lng($location['latitude'], $location['longitude']);
					if(!empty($location['zipcode'])) {
						$this->native_session->set('__latitude',$location['latitude']);
						$this->native_session->set('__longitude',$location['longitude']);
						$this->native_session->set('__zipcode',$location['zipcode']);
					}
					if(!empty($location)) $location['confidence'] = '0.6';
				}
				else $location['confidence'] = '0.4';
			}
			
			# Then extract only the requested values
			if(!empty($needed)) {
				foreach($location AS $key=>$value) if(in_array($key, $needed)) $final[$key] = $value;
			}
			else $final = $location;
		}
		log_message('debug', '_location/locate_with_api:: [2] final='.json_encode($final));
		
		return $final;
	}
	
	
	
	
	
	# Locate address with google latitude and longitude
	function locate_with_google_lat_lng($latitude, $longitude)
	{
		log_message('debug', '_location/locate_with_google_lat_lng');
		log_message('debug', '_location/locate_with_google_lat_lng:: [1] latitude='.$latitude.' longitude='.$longitude);
		
		$location = array();
		
		# Set the CURL Options
		$data['key'] = GOOGLE_API_KEY;
		$data['latlng'] = trim($latitude).','.trim($longitude);
		$addressList = $this->run_curl(GOOGLE_GEOCODING_API_URL.'?'.http_build_query($data));
		
		# Simply use the first address - usually the most accurate
		if(!empty($addressList['results'][0])){
			$raw = $addressList['results'][0];
			#$location = array('address', 'latitude','longitude', 'zipcode', 'city', 'state_code', 'state', 'country_code', 'country_name')
			if(!empty($raw['formatted_address'])) $location['address'] = $raw['formatted_address'];
			if(!empty($raw['geometry']['location']['lat'])) $location['latitude'] = $raw['geometry']['location']['lat'];
			if(!empty($raw['geometry']['location']['lng'])) $location['longitude'] = $raw['geometry']['location']['lng'];
			if(!empty($raw['address_components'])) {
				foreach($raw['address_components'] AS $component){
					if(!empty($component['types']) && in_array('postal_code', $component['types']) && !empty($component['short_name'])) $location['zipcode'] = $component['short_name'];
					if(!empty($component['types']) && in_array('administrative_area_level_1', $component['types']) && !empty($component['short_name'])) $location['state_code'] = $component['short_name'];
					if(!empty($component['types']) && in_array('administrative_area_level_1', $component['types']) && !empty($component['long_name'])) $location['state'] = $component['long_name'];
					if(!empty($component['types']) && in_array('country', $component['types']) && !empty($component['short_name'])) $location['country_code'] = $component['short_name'];
					if(!empty($component['types']) && in_array('country', $component['types']) && !empty($component['long_name'])) $location['country_name'] = $component['long_name'];
					if(!empty($component['types']) && in_array('locality', $component['types']) && !empty($component['long_name'])) $location['city'] = $component['long_name'];
				}
			}
		}
		log_message('debug', '_location/locate_with_google_lat_lng:: [2] location='.json_encode($location));
		
		return $location;
	}
	
	
	
	
	# Locate the user's address using the IP address
	function locate_with_ip_info()
	{
		log_message('debug', '_location/locate_with_ip_info');
		
		$location = array();
		$raw = $this->run_curl(IP_INFO_URL.get_ip_address().'/json');
		
		if(!empty($raw['city'])) $location['city'] = $raw['city'];
		if(!empty($raw['region'])) $location['state'] = $raw['region'];
		if(!empty($raw['country'])) $location['country_code'] = $raw['country'];
		if(!empty($raw['postal'])) $location['zipcode'] = $raw['postal'];
		if(!empty($raw['loc'])) {
			$loc = explode(',',$raw['loc']);
			$location['latitude'] = $loc[0];
			if(!empty($loc[1])) $location['longitude'] = $loc[1];
		} 
		log_message('debug', '_location/locate_with_ip_info:: [1] location='.json_encode($location));
		
		return $location;
	}
	
	
	
	
	
	
	
	# Run the passed url on CURL 
	function run_curl($url)
	{
		log_message('debug', '_location/run_curl');
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($curl, CURLOPT_REFERER, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl);
		#Return the result from the cURL execution
		return json_decode($result, TRUE);
	}
	
	
	
	
	
	
	
	# Geo-locate using local DB
	function geolocate_local($locationSpecs, $needed=array())
	{
		log_message('debug', '_location/geolocate_local');
		log_message('debug', '_location/geolocate_local:: [1] locationSpecs='.json_encode($locationSpecs).' needed='.json_encode($needed));
		
		$location = $final = array();
		
		# If we already have the latitude and longitude and they are the only ones needed, we should not run the IP library
		$this->load->library('geoip_lib');
		$this->geoip_lib->InfoIP(get_ip_address());
	  	$geo = $this->geoip_lib->result_array();
		
		# Populate the location specs keys with respective location values
		foreach($locationSpecs AS $field){
			if($field == 'latitude') $location[$field] = ($this->native_session->get('__latitude')? $this->native_session->get('__latitude'): (!empty($geo['latitude'])? $geo['latitude']: ''));
			if($field == 'longitude') $location[$field] = ($this->native_session->get('__longitude')? $this->native_session->get('__longitude'): (!empty($geo['longitude'])? $geo['longitude']: ''));
			if($field == 'zipcode') $location[$field] = (!empty($geo['postal_code'])? $geo['postal_code']: '');
			if($field == 'city') $location[$field] = (!empty($geo['city'])? $geo['city']: '');
			if($field == 'state_code') $location[$field] = (!empty($geo['region'])? $geo['region']: '');
			if($field == 'state') $location[$field] = (!empty($geo['region_name'])? $geo['region_name']: '');
			if($field == 'country_code') $location[$field] = (!empty($geo['country_code3'])? $geo['country_code3']: '');
			if($field == 'country_name') $location[$field] = (!empty($geo['country_name'])? $geo['country_name']: '');
		}
			
		# Final location details needed
		if(!empty($needed)) foreach($location AS $key=>$value) if(in_array($key, $needed)) $final[$key] = $value;
		else $final = $location;
		
		# Set the confidence based on results
		if(!empty($location['zipcode'])) $final['confidence'] = '0.5';
		else if(!empty($location['country'])) $final['confidence'] = '0.4';
		else $final['confidence'] = '0.0';
		log_message('debug', '_location/geolocate_local:: [2] final='.json_encode($final));
		
		return $final;
	}
	
	

}

?>