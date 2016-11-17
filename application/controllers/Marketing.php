<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing marketing information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/24/2015
 */
class Marketing extends CI_Controller 
{ 
	# The home
	function home()
	{
		log_message('debug', 'Marketing/home');
		
		$data = filter_forwarded_data($this);
		$this->load->view('marketing/home', $data);
	}
}

/* End of controller file */