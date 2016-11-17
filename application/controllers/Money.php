<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing money information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/23/2015
 */
class Money extends CI_Controller 
{
	# The money home
	function home()
	{
		log_message('debug', 'Money/home');
		
		$data = filter_forwarded_data($this);
		$this->load->view('money/home', $data);
	}
}

/* End of controller file */