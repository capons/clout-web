<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing affiliate information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/24/2015
 */
class Affiliate extends CI_Controller 
{ 
	# The home
	function home()
	{
		log_message('debug', 'Affiliate/home');
		
		$data = filter_forwarded_data($this);
		$this->load->view('affiliate/home', $data);
	}
}

/* End of controller file */