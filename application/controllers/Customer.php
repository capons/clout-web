<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls viewing customer information.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/23/2015
 */
class Customer extends CI_Controller 
{ 
	function __construct() { //access
        parent::__construct();
        check_access($this,'__redirect');
        if(!check_access($this,'can_view_customers',array('access'))){ //redirect if user don't have permission
            redirect(base_url('account/log_out'), 'refresh');
        }
    }
	# The customer home
	function home()
	{
        /*
        $data = array(
            0 => array (
                'score' => 100,
                'next_score' => 150,
                'column11' =>34

            )
        );
        //resive rules to remove from view
        $view_access = array(

            'sectionn.store',
            'column1',
            'column2'
        );
        //section column map (name must be the same as column name of mysql result)
        $section_rules = array (
            'store' => array (
                'score',
                'in_store_spending',
                'competitor_spending',
                'category_spending',
                'related_spending',
                'overall_spending',
                'linked_accounts',
                'activity'

            )
        );
        //names of sections which I want to remove from view
        $section = array();
        //individual column rules
        $column_rules = array();
        //all section column name
        $all_section_rules = array();
        foreach ($view_access as $key2=>$val2){
            $filter = explode('.',$val2); //explode array value
            if(isset($filter[1])){ //true if section name isset
                if($filter[0] == 'section') {
                    $section[] = $filter[1];
                }

            } else {              //if array have column name
                $column_rules[] = $filter[0];
            }
        }
        //if isset section => merge all section rules into one array
        if(!empty($section)){
            foreach ($section as $key=>$val){
                $all_section_rules[] = $section_rules[$val];
            }
            //all section rules put here (column name )
            $merge_section_rules = array();
            foreach ($all_section_rules as $key=>$val){
                foreach ($val as $k=>$v){
                    $merge_section_rules[] = $v;
                }
            }
        }
        if(isset($merge_section_rules)) {
            $field_view_result = array_unique(array_merge($column_rules, $merge_section_rules));
        } else {
            $field_view_result = $column_rules;
        }


        $i = 0;
        foreach ($data as $key => $val) {
            foreach ($val as $key1 => $val1) {

                if (in_array($key1, $field_view_result)) {
                    unset($data[$i][$key1]);
                }
            }
            $i++;
        }
        echo '<pre>';
        print_r($data);
        echo '</pre>';

	    die();
        */
		log_message('debug', 'Customer/home');

		$data = filter_forwarded_data($this);
//		$this->load->view('customer/home', $data);
		$this->load->view('customer/home_list', $data);
	}
	function home_tile()
	{
		log_message('debug', 'Customer/home_tile');

		$data = filter_forwarded_data($this);
//		$this->load->view('customer/home', $data);
		$this->load->view('customer/home_tile', $data);
	}
	function home2()
	{
		log_message('debug', 'Customer/_home');

		$data = filter_forwarded_data($this);
//		$this->load->view('customer/home', $data);
		$this->load->view('customer/_home', $data);
	}
}

/* End of controller file */