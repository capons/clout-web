<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = DEFAULT_CONTROLLER;
$route['404_override'] = '404.html';


#Customize URL Access link to ease remembering public links
#----------------------------

#User referrals
#www.clout.com/r/2341234
$route['([Rr])/([a-zA-Z0-9-]+)'] = "page/index/r/$2";
$route['([Rr])/([a-zA-Z0-9-]+)/(:any)'] = "page/index/r/$2/m/$3";

#User activation
$route['([Uu])/([a-zA-Z0-9]+)'] = "account/verify_user/u/$2";
$route['([Uu])/([a-zA-Z0-9]+)/(:any)'] = "account/verify_user/u/$2/m/$3";

#User password recovery
$route['([Pp])/([a-zA-Z0-9=]+)'] = "account/recover_password/p/$2";
$route['([Pp])/([a-zA-Z0-9=]+)/(:any)'] = "account/recover_password/p/$2/m/$3";

#Unsubscribe an email
$route['([Xx])/([a-zA-Z0-9=]+)'] = "message/unsubscribe/x/$2";
$route['([Xx])/([a-zA-Z0-9=]+)/(:any)'] = "message/unsubscribe/x/$2/m/$3";

#Make a reservation on event
$route['([Cc])/([a-zA-Z0-9=]+)'] = "message/email_landing_page/c/$2";
$route['([Cc])/([a-zA-Z0-9=]+)/(:any)'] = "message/email_landing_page/c/$2/m/$3";

#www.clout.com/store/chain-name/address-line
#$route['store/(:any)'] = 'search/map_store/store/$2';
#ie /store/mcdonalds=123-wilshire-blvd-los-angeles-ca-90210-united-states
$route['category/(:any)/store/(:any)'] = 'search/map_store/category/$1/store/$2';
$route['store/(:any)'] = 'search/map_store/category/$1/store/$2';



/* End of file routes.php */
/* Location: ./application/config/routes.php */
