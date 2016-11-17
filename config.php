<?php
/*
 * This document includes global system-specific settings
 *
 */
 
 
/*
 *---------------------------------------------------------------
 * GLOBAL SETTINGS
 *---------------------------------------------------------------
 */
	
	define('SITE_TITLE', "Clout");
		
	define('SITE_SLOGAN', "");

	define('SYS_TIMEZONE', "America/Los_Angeles");
	
	define('NUM_OF_ROWS_PER_PAGE', "20");
		
	define('NUM_OF_LISTS_PER_VIEW', "5");
	
	define('IMAGE_URL', BASE_URL."assets/images/");
	
	define('HOME_URL', getcwd()."/");
	
	define('DEFAULT_CONTROLLER', 'page');
	
	define('LABEL_DIRECTORY',  HOME_URL."assets/labels/");
	
	define('UPLOAD_DIRECTORY',  HOME_URL."assets/uploads/");
	
	define('MAX_FILE_SIZE', 40000000);
	
	define('ALLOWED_EXTENSIONS', ".doc,.docx,.txt,.pdf,.xls,.xlsx,.jpeg,.png,.jpg,.gif");
	
	define('MAXIMUM_FILE_NAME_LENGTH', 100);
	
	define('DOWNLOAD_LIMIT', 10000); #Max number of rows that can be downloaded
	
	define('MINIMUM_SIGNUP_AGE', 13);  
	
	define('MINIMUM_INVITE_COUNT', 5);  
	
	define("SYSTEM_COLORS", serialize(array('level_-1'=>"#F1F1F1", 'level_0'=>"#CCCCCC", 'level_1'=>"#56D42B", 'level_2'=>"#18C93E", 'level_3'=>"#0AC298", 'level_4'=>"#03BFCD", 'level_5'=>"#2DA0D1", 'level_6'=>"#6D76B5", 'level_7'=>"#8566AB", 'level_8'=>"#999999", 'level_9'=>"#666666", 'level_10'=>"#333333", 'level_11'=>"#000000"))); 

	define("DEPLOYMENT_SCRIPT_BASE", "http://sta.clout.com:8897/html/");

/*
 *---------------------------------------------------------------
 * SEARCH SETTINGS
 *---------------------------------------------------------------
 */
	
	define('DEFAULT_IP', '99.59.233.60');
	
	define('DEFAULT_SEARCH_CATEGORY', '9');
	
	define('DEFAULT_SEARCH_DISTANCE', '50');

?>