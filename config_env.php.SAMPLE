<?php
/*
 *  This document includes global environment-specific settings
 *
 */
 
 
/*
 *---------------------------------------------------------------
 * GLOBAL SETTINGS
 *---------------------------------------------------------------
 */
	define('ENVIRONMENT', 'local');
	
	define('SECURE_MODE', FALSE);
	
	define('BASE_URL', 'http://localhost:8888/clout-dev/dev-v1.3.2-web/');#Set to HTTPS:// if SECURE_MODE = TRUE

	define('RETRIEVE_URL_DATA_IGNORE', 3);#The starting point to obtain the passed url data

	define("MINIFY", FALSE);
	
	define('PORT_HTTP', '80');
  
  	define('PORT_HTTP_SSL', '443');
	
	define('PHP_LOCATION', "php5");

 	define('ENABLE_PROFILER', FALSE); #See perfomance stats based on set benchmarks
	
	define('INTERNAL_SERVER_URL','http://localhost:8888/clout-dev/dev-v1.3.2-web/');


/*
 *---------------------------------------------------------------
 * API SETTINGS
 *---------------------------------------------------------------
 */

	define('API_URL', 'http://dev.clout.com:8996/');
	
	define('API_PUBLIC_URL', 'http://dev.clout.com:8996/');
		
	define('API_KEY', 'xt9487593-234u78i345345k-rt845k45p234');

 	define('API_S3_URL', 'http://pro-dw-s3b1.s3.amazonaws.com/');
 
	
	


/*
 *---------------------------------------------------------------
 * GEOCODING DETAILS
 * Google API Management: https://console.developers.google.com/project/807729000380/clouddev/develop/browse
 *---------------------------------------------------------------
 */
 	
	define('GOOGLE_API_KEY', 'AIzaSyDzUPJlJ7PkSPrnysdMQPYicvbdciAeTNw'); 
	
	define('GOOGLE_GEOCODING_API_URL', 'https://maps.googleapis.com/maps/api/geocode/json');

	define('IP_INFO_URL', 'http://ipinfo.io/');
 

/*
 *
 *	0 = Disables logging, Error logging TURNED OFF
 *	1 = Error Messages (including PHP errors)
 *	2 = Debug Messages
 *	3 = Informational Messages
 *	4 = All Messages
 *	The log file can be found in: [HOME_URL]application/logs/
 *	Run >tail -n50 log-YYYY-MM-DD.php to view the errors being generated
 */
	define('LOG_ERROR_LEVEL', 2);


			
/*
 *--------------------------------------------------------------------------
 * URI PROTOCOL
 *--------------------------------------------------------------------------
 *
 * The default setting of "AUTO" works for most servers.
 * If your links do not seem to work, try one of the other delicious flavors:
 *
 * 'AUTO'	
 * 'REQUEST_URI'
 * 'PATH_INFO'	
 * 'QUERY_STRING'
 * 'ORIG_PATH_INFO'
 *
 */
	
	define('URI_PROTOCOL', 'AUTO'); // Set "AUTO" For WINDOWS OR determined by the system
									// Set "REQUEST_URI" For LINUX


/*
 *---------------------------------------------------------------
 * LOAD BALANCER SETTINGS
 * These affect the handling of sessions and re-routing
 *---------------------------------------------------------------
 */
 
	# Is this front-end on a load balancer? Set to FALSE for single server installations
	define('IS_BALANCED', FALSE);	        
	
	define('MEMCACHED_SERVER', "prd-be1.clout.int");
	
	define('MEMCACHED_PORT', "11211");

?>