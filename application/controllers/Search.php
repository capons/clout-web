<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing store and searched information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 06/24/2015
 */
class Search extends CI_Controller 
{
	
	# Search home page
	function home()
	{
		log_message('debug', 'Search/home');
		check_access($this,'__redirect');

		$data = filter_forwarded_data($this);
		
		# Get location information based on IP address if none is provided
		$location = $this->_location->get_current_location($data); 
		$parameters = array('type'=>'details', 'limit'=>'20', 'userId'=>format_id($this->native_session->get('__user_id')), 'filters'=>array('categoryId'=>'all'));
		if(!empty($location['latitude'])) $parameters['latitude'] = $location['latitude'];
		if(!empty($location['longitude'])) $parameters['longitude'] = $location['longitude'];
		if(!empty($location['zipcode'])) $parameters['filters']['zipcode'] = $location['zipcode'];
		if(!empty($location['city'])) {
			$parameters['filters']['city'] = $location['city'];
			$parameters['location'] = $location['city'];
		}
		
		log_message('debug', 'Search/home:: [1] post='.json_encode($_POST));
		# (Re)set the search parameters
		if(!empty($_POST['phrase']))
		{
			$this->native_session->set('search_phrase',$_POST['phrase']);
			$this->native_session->set('location_phrase',(!empty($_POST['location'])? $_POST['location']: ''));
			$this->native_session->set('order_phrase',(!empty($_POST['order'])? $_POST['order']: ''));
			
			$parameters['phrase'] = $this->native_session->get('search_phrase');
			$parameters['filters']['locationEntered'] = $parameters['location'] = $this->native_session->get('location_phrase');
			$parameters['order'] = $this->native_session->get('order_phrase');
		}
		else
		{
			$this->native_session->set('search_phrase','');
			$this->native_session->set('location_phrase','');
			$this->native_session->set('order_phrase','');
		}
		//echo '<p style="margin-top: 100px">34</p>';
		//var_dump(json_encode($parameters));
		log_message('debug', 'Search/home:: [2] parameters='.json_encode($parameters));
		# Now apply the parameters to the API
		$response = $this->_api->get('search/store_suggestions', $parameters);

		if(empty($response['origin'])) $response['origin'] = array('latitude'=>'', 'longitude'=>'', 'zipcode'=>'');
		if(empty($response['list'])) $response['list'] = array();
		
		$this->native_session->set('search_latitude',$response['origin']['latitude']);
		$this->native_session->set('search_longitude',$response['origin']['longitude']);
		$this->native_session->set('search_zipcode',$response['origin']['zipcode']);
		
		$data['suggestions'] = $response['list'];
		$data['defaultMsg'] = !empty($data['suggestions']) && empty($data['suggestions'][0]['store_score'])? "WARNING: Computation of your store scores has not been completed. We will notify you when your scores are ready.": "";
		
		# Set this as the search results session - for the map view
		$this->native_session->set('search_results',$data['suggestions']);
		$this->native_session->set('search_result_ids',(!empty($data['suggestions'])? get_column_from_multi_array($data['suggestions'],'store_id'): array()));
		
		log_message('debug', 'Search/home:: [3] data='.json_encode($data));
		$this->load->view('search/home', $data);
	}
	
	
	
	
	

	#Store details page
	function store()
	{
		log_message('debug', 'Search/store');
		if($this->native_session->get('public_store_page') != 1) {
			check_access($this,'__redirect');
		}
	
		$data = filter_forwarded_data($this);
	
		log_message('debug', 'Search/store:: [1] data='.json_encode($data));
		if(!empty($data['id'])) $this->native_session->set('__store_id', extract_id($data['id']));
	
		if($this->native_session->get('__store_id'))
		{
			# The store and user IDs
			$userId = format_id($this->native_session->get('__user_id'));
			$storeId = format_id($this->native_session->get('__store_id'));
			log_message('debug', 'Search/store:: [2] userId='.$userId.' storeId='.$storeId);
				
			# Store details to display on this page
			$data['storeDetails'] = $this->_api->get('store/'.$storeId, array(
			'fields'=>'storeName,address,latitude,longitude,distance,category,hasPerk,maxCashBack,minCashBack,isFavorite,website,telephone,description,reviewCount,averageReviewScore,photoCount,isOnVip',
			'latitude'=>($this->native_session->get('search_latitude')? $this->native_session->get('search_latitude'): ''),
			'longitude'=>($this->native_session->get('search_longitude')? $this->native_session->get('search_longitude'): '')
			));
				
			if(!empty($userId)) {
				#Store score breakdown details
				$storeScore = $this->_api->get('score/store', array('userId'=>$userId,'storeId'=>$storeId, 'includeScoreBreakdown'=>'TRUE'));
				$data['storeScoreDetails']['store_score'] = !empty($storeScore['storeScore'])? $storeScore['storeScore']: '0';
				$data['storeScoreDetails']['store_score_level'] = !empty($storeScore['scoreLevel'])? $storeScore['scoreLevel']: '0';
				$data['storeScoreDetails']['points_to_next_level'] = !empty($storeScore['pointsToNextLevel'])? $storeScore['pointsToNextLevel']: '0';
				$data['storeScoreDetails']['store_score_breakdown'] = !empty($storeScore['scoreBreakdown'])? $storeScore['scoreBreakdown']: array();
	
				$data['storeScoreDetails']['level_cashback_ranges'] = $this->_api->get('store/'.$storeId, array('offers'=>'cashback_ranges','userId'=>$userId));
				$data['storeDetails']['transactionStats'] = $this->_api->get('store/'.$storeId, array('type'=>'transaction', 'statistics'=>'lifeTimeSpendingTransactions,lifeTimeSpendingAmount,daysSinceLastTransaction,lastTransactionAmount,availableRewards,availableRewardAmount,pendingRewards,pendingRewardAmount','userId'=>$userId));
				log_message('debug', 'Search/store:: [3] transactionStats='.json_encode($data['storeDetails']));
			}
			# Offer display details
			$data['storeScoreDetails']['store_score_level_data'] = $this->_api->get('score/settings', array('type'=>'store_score','use'=>'level_data','storeId'=>$storeId));
			$data['storeScoreDetails']['store_score_key_description'] = $this->_api->get('score/settings', array('type'=>'store_score', 'use'=>'key_description'));
				
			$data['storeScoreDetails']['storeId'] = $storeId;
	
			$data['storeDetails']['offers']['cashback'] = $this->_api->get('store/'.$storeId, array('offers'=>'cashback'));
			$data['storeDetails']['offers']['perk'] = $this->_api->get('store/'.$storeId, array('offers'=>'perk'));
			$data['storeDetails']['hours'] = $this->_api->get('store/'.$storeId, array('hours'=>'weekly'));
			$data['storeDetails']['features'] = $this->_api->get('store/'.$storeId, array('features'=>'list'));
			$data['storeDetails']['photos'] = $this->_api->get('store/photos', array('storeId'=>$storeId, 'baseUrl'=>API_S3_URL));
				
			if(empty($userId)) {
				$data = load_page_labels('public_store', $data);
	
				log_message('debug', 'Search/store:: [2] data='.json_encode($data));
				$this->load->view('search/public_store', $data);
			}
			else {
				log_message('debug', 'Search/store:: [3] data='.json_encode($data));
				$this->load->view('search/store', $data);
			}
		}
		# No store can be resolved
		else
		{
			$this->native_session->set('msg', 'ERROR: We could not resolve the store details.');
			redirect(base_url().'search/home');
		}
	}
	
	
	
	
	
	
	#Function  to allow getting directions to a location
	public function map_to_location()
	{
		log_message('debug', 'Search/map_to_location');
		$data = filter_forwarded_data($this);
		if(!empty($data['a'])) $data['address'] = decrypt_value($data['a']);
		else $data['msg'] = format_notice($this, 'ERROR: Address could not be resolved.');
		
		log_message('debug', 'Search/map_to_location:: [1] data='.json_encode($data));
		$this->load->view('search/map_to_location', $data);
	}
	
	
	
	
	
	
	
	
	
	#Function to show a store offer explanation
	public function offer_details()
	{
		log_message('debug', 'Search/offer_details');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/offer_details:: [1] data='.json_encode($data));
		if(!empty($data['i']))
		{
			$data['offerId'] = decrypt_value($data['i']);
			$data['offerType'] = $data['t'];
			$data['offerDetails'] = $this->_api->get('store/'. format_id($this->native_session->get('__store_id')), array('offerId'=>$data['offerId'], 'fields'=>'extra_conditions,description,requires_scheduling,offer_bar_code')); 
		}
		else $data['msg'] = "ERROR: Offer can not be resolved.";
		
		log_message('debug', 'Search/offer_details:: [2] data='.json_encode($data));
		$this->load->view('search/single_offer_details', $data);
	}
	
	
	
	
	# Checkin a user
	public function checkin()
	{
		log_message('debug', 'Search/checkin');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/checkin:: [1] data='.json_encode($data));
		$location = $this->_location->get_current_location($data);
		$location['address'] = '';
			
		$checkin = $this->_api->post('store/checkin', array(
			'offerId'=>(!empty($data['i'])? decrypt_value($data['i']): ''), 
			'userId'=>format_id(!empty($data['u'])? decrypt_value($data['u']): $this->native_session->get('__user_id') ), 
			'location'=>$location,
			'storeId'=>(!empty($_POST['storeid'])? format_id($_POST['storeid']): '') 
		)); 
		
		log_message('debug', 'Search/checkin:: [2] checkin='.json_encode($checkin));
		$data['msg'] = !empty($checkin['checkinSuccess']) && $checkin['checkinSuccess']=='Y'? "Checkin confirmed": "WARNING: Checkin NOT confirmed.";
		
		# How do you display the results
		if(!empty($data['u'])){
			$this->load->view('search/single_offer_details', $data);
		} else {
			echo (!empty($checkin['checkinSuccess']) && $checkin['checkinSuccess']=='Y'? "SUCCESS": "FAIL");
		}
		log_message('debug', 'Search/checkin:: [3] data='.json_encode($data));
	}
	
	
	
	
	# make a reservation
	function make_reservation()
	{
		log_message('debug', 'Search/make_reservation');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/make_reservation:: [1] data='.json_encode($data));
		if(!empty($data['i']))
		{
			$reservation = $this->_api->post('store/reservation', array('offerId'=>decrypt_value($data['i']), 'reservation'=>array('reservationName'=>$_POST['reservationname'], 'reservationEmail'=>$this->native_session->get('__email_address'), 'reservationDate'=>$_POST['reservationdate'], 'reservationPhone'=>$_POST['reservationphone'], 'reservationNumber'=>$_POST['reservationnumber'], 'specialRequests'=>(!empty($_POST['specialrequests'])? $_POST['specialrequests']: '')) )); 
			$data['msg'] = (!empty($reservation['reservationSuccess']) && $reservation['reservationSuccess']=='Y')? "Your reservation has been confirmed.": "ERROR: The reservation could not be completed. Please try again later.";
		}
		else
		{
			$data['msg'] = "ERROR: The reservation offer can not be resolved.";
		}
		log_message('debug', 'Search/make_reservation:: [2] data='.json_encode($data));
		$this->load->view('search/single_offer_details', $data);
	}
	
	
	
	
	
	
	#Display an offerlist for a store based on the passed score
	function offer_list()
	{
		log_message('debug', 'Search/offer_list');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/offer_list:: [1] data='.json_encode($data));
		#Get the offer level
		if(!empty($data['l']))
		{
			$layerNameParts = explode('_', $data['l']);
			$level = $layerNameParts[1];
		} 
		else $level = 0;

		
		#Get the extra level details
		if(!empty($data['e']))
		{
			$extraInfo = explode('__', $data['e']);
			$data['currentLevel'] = $extraInfo[1];
			$data['isOnVip'] = $extraInfo[2];
			$data['hasRemainingPoints'] = $extraInfo[3];
			$data['viewedLevel'] = $level;
			$data['remainingPoints'] = !empty($extraInfo[4])?$extraInfo[4]:'';
			if($level == $extraInfo[1]) $data['isCurrentLevel'] = TRUE;
			
			# The the offers at the specified score level
			$data['offers']['cashback'] = $this->_api->get('store/'.$extraInfo[0], array('offers'=>'cashback','level'=>$level)); 
			$data['offers']['perk'] = $this->_api->get('store/'.$extraInfo[0], array('offers'=>'perk','level'=>$level)); 
		}
		
		log_message('debug', 'Search/offer_list:: [2] data='.json_encode($data));
		$this->load->view('search/offer_list', $data);
		
	}
	
	
	
	
	
	# Add a store as a favorite
	function add_favorite()
	{
		log_message('debug', 'Search/add_favorite');
		$data = filter_forwarded_data($this);
		
		if(!empty($_POST['storeid'])){
			$result = $this->_api->post('store/favorite', array('storeId'=>format_id($_POST['storeid']), 'action'=>$_POST['action'] ));
		}
		
		log_message('debug', 'Search/add_favorite:: [1] result='.json_encode($result));
		echo (!empty($result['result']) && $result['result']=='SUCCESS'? "SUCCESS": "FAIL");
	}
	
	
	
	
	
	
	# Apply a search filter
	function apply_filter()
	{
		log_message('debug', 'Search/apply_filter');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/apply_filter:: [1] post='.json_encode($_POST));
		if(!empty($_POST['search__level1categories'])){
			# Location information
			$filters = array();
			$location = $this->_location->get_current_location($data);
			if(!empty($location['latitude'])) $parameters['latitude'] = $location['latitude'];
			if(!empty($location['longitude'])) $parameters['longitude'] = $location['longitude'];
			if(!empty($location['zipcode'])) $filters['zipcode'] = $location['zipcode'];
			if(!empty($location['city'])) $filters['city'] = $location['city'];
			if(empty($_POST['searchlocation']) && !empty($location['city'])) $_POST['searchlocation'] = $location['city'];
			
			$parameters = array('type'=>'details', 
				'phrase'=>$_POST['searchphrase'], 
				'location'=>$_POST['searchlocation'], 
				'order'=>$_POST['searchorder'], 
				'longitude'=>(!empty($location['longitude'])? $location['longitude']: ''),
				'latitude'=>(!empty($location['latitude'])? $location['latitude']: ''),
				'offset'=>'0', 
				'limit'=>'20'
			);
			
			# Filter information
			$filters['categoryId'] = $_POST['search__level1categories'];
			$filters['maxDistance'] = $_POST['search__distanceoptions'];
			$filters['checkinPerks'] = !empty($_POST['rewards__perks_checkin__value']) && $_POST['rewards__perks_checkin__value'] == 'ON'? 'Y': 'N';
			$filters['reservationPerks'] = !empty($_POST['rewards__perks_reservation__value']) && $_POST['rewards__perks_reservation__value'] == 'ON'? 'Y': 'N';
			$filters['cashback'] = !empty($_POST['rewards__cashback__value']) && $_POST['rewards__cashback__value'] == 'ON'? 'Y': 'N';
			$filters['cashbackRange'] = !empty($_POST['rewards__cashbackrange'])? $_POST['rewards__cashbackrange']: '';
			$filters['favorites'] = !empty($_POST['hotspots__favorites__value']) && $_POST['hotspots__favorites__value'] == 'ON'? 'Y': 'N';
			$filters['shoppedAt'] = !empty($_POST['hotspots__ihavebeen__value']) && $_POST['hotspots__ihavebeen__value'] == 'ON'? 'Y': 'N';
			$filters['popular'] = !empty($_POST['hotspots__popular__value']) && $_POST['hotspots__popular__value'] == 'ON'? 'Y': 'N';
			$parameters['filters'] = $filters;
			
			# Get search data		
			$data['suggestionList'] = $this->_api->get('search/store_suggestions', $parameters); 	
		}
		else $data['suggestionList'] = array();
		
		log_message('debug', 'Search/apply_filter:: [1] data='.json_encode($data));
		$this->load->view('search/store_suggestions_list', $data);
	}
	
	
	
	
	
	
	
	
	# View or add a review for a store
	function add_review()
	{
		log_message('debug', 'Search/add_review');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/add_review:: [1] data='.json_encode($data));
		# Adding a review
		if(isset($_POST['review__reviewgrades'])){
			$result = $this->_api->post('store/review', array(
				'storeId'=>$data['s'],
				'score'=>$_POST['review__reviewgrades'],
				'comment'=>(!empty($_POST['reviewdetails'])? $_POST['reviewdetails']: '')
			));
			
			log_message('debug', 'Search/add_review:: [2] result='.json_encode($result));
			$data['msg'] = (!empty($result['result']) && $result['result']=='SUCCESS'? "Your review has been successfully submitted.": "ERROR: Your review could not be submitted.");
			$data['reviews'] = $this->_api->get('store/reviews', array('storeId'=>$data['s'])); 
			
			# Update review stats
			
			# a) Review average
			if(empty($data['c']) && !empty($data['reviews'][0]['score'])) {
				$data['c'] = $data['reviews'][0]['score']; 
			} else if(!empty($data['c']) && !empty($data['reviews'][0]['score']) && !empty($data['r']) && empty($_POST['previousscore'])){
				$data['c'] = round((($data['c']*$data['r'])+$data['reviews'][0]['score'])/($data['r']+1),0,PHP_ROUND_HALF_UP);
			}
			# b) Review count
			if(empty($data['r']) && !empty($data['reviews'])) {
				$data['r'] = count($data['reviews']); 
			} else if(!empty($data['r']) && !empty($result['result']) && $result['result']=='SUCCESS' && empty($_POST['previousscore'])){
				$data['r'] = ($data['r']+1);
			}
			
			log_message('debug', 'Search/add_review:: [3] data='.json_encode($data));
			$this->load->view('search/review_list', $data);
		}
		else
		{
			# View store reviews
			if(!empty($data['s'])) {
				$data['storeId'] = $data['s'];
				$data['reviews'] = $this->_api->get('store/reviews', array('storeId'=>$data['s'])); 
				$data['reviewDetails'] = $this->_api->get('store/review', array('storeId'=>$data['s'])); 
			}
			
			log_message('debug', 'Search/add_review:: [4] data='.json_encode($data));
			$this->load->view('search/add_review', $data);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	# View or add a photo for a store
	function add_photo()
	{
		log_message('debug', 'Search/home');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/send_request:: [1] post='.json_encode($_POST));
		# Add a review
		if(isset($_POST['photourl'])){
			$fileUrl = upload_temp_file($_FILES, 'photourl__fileurl', 'storephoto_', 'jpg,jpeg,gif,png,tiff');
			
			if(!empty($fileUrl)){
				$result = $this->_api->post('store/photo', array(
					'storeId'=>$data['s'], 
					'photo'=>INTERNAL_SERVER_URL.'assets/uploads/temp/'.$fileUrl,
					'comment'=>(!empty($_POST['photocomment'])? $_POST['photocomment']: '')
				));
			}
			
			log_message('debug', 'Search/send_request:: [2] result='.json_encode($result));
			if(!empty($result['result']) && $result['result']=='SUCCESS') {
				echo "Your photo has been successfully submitted.";
			} else {
				echo "ERROR: Your photo could not be submitted.";
			}
			#Remove the temp file now that we are done with it
			if(file_exists(UPLOAD_DIRECTORY.'temp/'.$fileUrl)) @unlink(UPLOAD_DIRECTORY.'temp/'.$fileUrl);
		}
		else
		{
			# View store photos
			if(!empty($data['s'])) $data['storeId'] = $data['s'];
			$this->load->view('search/add_photo', $data);
		}
	}
	
	
	
	
	
	
	# Send request for offers
	function send_request()
	{
		log_message('debug', 'Search/send_request');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/send_request:: [1] data='.json_encode($data));
		# Adding to VIP list
		if(!empty($data['a']) && $data['a'] == 'add_vip'){
			$result = $this->_api->post('store/request_offers', array(
					'storeId'=>format_id($this->native_session->get('__store_id')),  
					'type'=>'add_to_vip_list',
					'requests'=>array(
						'perVisitSpend'=>$_POST['pervisitspend'],
						'perMonthSpend'=>$_POST['permonthspend']
					)
				));
				
			log_message('debug', 'Search/send_request:: [2] result='.json_encode($result));
			if(!empty($result['result']) && $result['result']=='SUCCESS') {
				$data['msg'] = "You're on the list!";
				$data['showConfirmation'] = 'Y';
			} else {
				$data['msg'] = "ERROR: You could not be added to the list.";
				$data['showAddToVIP'] = 'Y';
			}
		}
		
		# Knowing what the user wants
		else {
			$result = $this->_api->post('store/request_offers', array(
					'storeId'=>format_id($this->native_session->get('__store_id')),  
					'type'=>'what_you_want',
					'requests'=>$_POST['requests']
				));
				
			log_message('debug', 'Search/send_request:: [3] result='.json_encode($result));
			if(!empty($result['result']) && $result['result']=='SUCCESS') {
				$data['msg'] = "Your requests have been sent.";
				$data['showAddToVIP'] = 'Y';
			} else {
				$data['msg'] = "ERROR: Your requests could not be sent.";
			}
		}
		
		log_message('debug', 'Search/delete_location:: [4] data='.json_encode($data));
		$this->load->view('search/request_offers', $data);
	}
	
	
	
	
	
	
	# Load the map view - iFrame
	function load_map_view()
	{
		log_message('debug', 'Search/home');
		$data = filter_forwarded_data($this);
		$data['area'] = "stores_on_the_map";
		$this->load->view('addons/basic_addons', $data);
	}
	# Load the real store list map
	function show_store_list_map()
	{
		log_message('debug', 'Search/home');
		$data = filter_forwarded_data($this);
		$this->load->view('search/search_map_view', $data);
	}
	
	
	
	
	
	
	
	# Remove a location 
	function delete_location()
	{
		log_message('debug', 'Search/delete_location');
		$data = filter_forwarded_data($this);
		
		log_message('debug', 'Search/delete_location:: [1] data='.json_encode($data));
		if(!empty($data['d'])) $result = $this->_api->post('user/remove_address', array('contactId'=>$data['d']));
		
		log_message('debug', 'Search/delete_location:: [2] result='.json_encode($result));
		echo (!empty($result['result']) && $result['result']=='SUCCESS')? "The address has been removed": "ERROR: The address could not be removed.";
	}
	
	
	# Serves public store page
	function map_store() 
	{
		log_message('debug', 'Search/map_store');
		$data = filter_forwarded_data($this, array(), array(), 1);

		$params = explode('=', $data['store']);
		
		log_message('debug', 'Search/map_store:: [1] params='.count($params));
		if(count($params) == 2) {
			$result = $this->_api->get('store/public_mapping', array('chainName'=>$params[0], 'address'=>str_replace('.html', '', $params[1])));
			log_message('debug', 'Search/map_store:: [2] result='.json_encode($result));
			if(!empty($result) && !empty($result['store_id'])) {
				$this->native_session->set('msg', '');
				$this->native_session->set('public_store_page', '1');
				redirect(base_url().'search/store/id/'.format_id($result['store_id']));
			}
			$this->native_session->set('msg', 'ERROR: Invalid request. Please recheck your store URL.');
			redirect(base_url().'search/home');
		}
		else {
			
			$this->native_session->set('msg', 'ERROR: Invalid request. Please recheck your store URL.');
			
			# maybe redirect here?
			redirect(base_url().'search/home');
		}
	}
	
	
	
}

/* End of controller file */