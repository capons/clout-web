<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing promotion information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/23/2015
 */
class Promotion extends CI_Controller
{

	function __construct() { //access
        parent::__construct();
        check_access($this,'__redirect');
        if(!check_access($this,'can_view_promotions',array('access'))){ //redirect if user don't have permission
            redirect(base_url('account/log_out'), 'refresh');
        }
    }
	# The home
	function home()
	{
        log_message('debug', 'Promotion/home');
		$data = filter_forwarded_data($this);
        $data = load_page_labels('promotion_home', $data);
        $this->load->view('promotion/home', $data);
	}
	function home_custom()
	{
        log_message('debug', 'Promotion/home_custom');
        $data = filter_forwarded_data($this);
        $data = load_page_labels('promotion_home_custom', $data);
        $this->load->view('promotion/home_custom', $data);
	}

	function admin()
	{
		log_message('debug', 'Promotion/admin');
		$data = filter_forwarded_data($this);
		$this->load->view('promotion/home', $data);
	}


	# udpate a promotion by the given score
	function update_promotion_by_score()
	{
		log_message('debug', 'Promotion/update_promotion_by_score');
		$data = filter_forwarded_data($this);
		$data['score'] = !empty($data['t'])? decrypt_value($data['t']): '0';
		log_message('debug', 'Promotion/update_promotion_by_score:: [1] data='.json_encode($data));

		$this->load->view('promotion/promotion_by_score', $data);
	}


	# update a promotion by the given score
	function edit_offer()
	{
		log_message('debug', 'Promotion/edit_offer');
		$data = filter_forwarded_data($this);
		$data['offerId'] = !empty($data['i'])? decrypt_value($data['i']): '';
		log_message('debug', 'Promotion/edit_offer:: [1] data='.json_encode($data));

		$this->load->view('promotion/edit_offer', $data);
	}




	# show edit fields
	function show_edit_fields()
	{
		log_message('debug', 'Promotion/show_edit_fields');
		$data = filter_forwarded_data($this);
		$data['type'] = !empty($data['t'])? decrypt_value($data['t']): '';
		log_message('debug', 'Promotion/show_edit_fields:: [1] data='.json_encode($data));

		$this->load->view('promotion/edit_offer_fields', $data);
	}

}

/* End of controller file */
