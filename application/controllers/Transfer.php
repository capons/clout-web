<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing transfer information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/24/2015
 */
class Transfer extends CI_Controller 
{ 
	# The home
	function home()
	{
		log_message('debug', 'Transfer/home');
		$data = filter_forwarded_data($this);
		$this->load->view('transfer/home', $data);
	}
}

/* End of controller file */