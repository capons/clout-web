<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls requesting or viewing support.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 09/24/2015
 */
class Support extends CI_Controller 
{ 
	# The home
	function home()
	{
		log_message('debug', 'Support/home');
		$data = filter_forwarded_data($this);
		$this->load->view('support/home', $data);
	}
	
	# The Third party Adminstation Systems Page
	function admin_systems()
	{
		log_message('debug', 'Support/admin_systems');
		$data = filter_forwarded_data($this);
		log_message('debug', 'Support/admin_systems:: [1] post='.json_encode($_POST));
		
		# Copying between repos
		if( !empty($_POST["copy_from"]) && !empty($_POST["copy_to"])) {
			
			# Calculate the time to load command
			$start = microtime(true);
			
			$copy_from = $_POST["copy_from"];
			$copy_to = $_POST["copy_to"];
			$tag_name = !empty($_POST["tag_name"])? $_POST["tag_name"] : "";
			
			$url = DEPLOYMENT_SCRIPT_BASE."copy.php?fr=".$copy_from."&tr=".$copy_to."&t=".$tag_name;
			
			$time_elapsed_secs = microtime(true) - $start;
			
			$response = $this->_api->post('code_manager/activity', array(
					'uri'=>$url,
					'fromRepo'=>$copy_from,
					'toRepo'=>$copy_to,
					'tagName'=>$tag_name,
					'runTime'=>$time_elapsed_secs
			));
			
			log_message('debug', 'Support/admin_systems:: [2] url='.$url);
			
			echo $url;
			
		# Add tag to repos
		} else if( !empty($_POST["addtag"]) && !empty($_POST["addto"])) {
			
			# Calculate the time to load command
			$start = microtime(true);
			
			$add_to = $_POST["addto"];
			$tag_name = $_POST["addtag"];
			
			$url = DEPLOYMENT_SCRIPT_BASE."tag.php?r=".$add_to."&t=".$tag_name;
			
			$time_elapsed_secs = microtime(true) - $start;

			$response = $this->_api->post('code_manager/activity', array(
					'uri'=>$url,
					'fromRepo'=>'',
					'toRepo'=>$add_to,
					'tagName'=>$tag_name,
					'runTime'=>$time_elapsed_secs
			));

			log_message('debug', 'Support/admin_systems:: [3] url='.$url);
			
			echo $url;
			
		} else {
			$this->load->view('support/admin_systems', $data);
		}
	}

	# Get the tag names for copying repos
	function get_tag_names() 
	{	
		log_message('debug', 'Support/get_tag_names');
		echo get_option_list($this, 'tagNames', 'select', $_GET["copy_from_repo"]);
	}
}

/* End of controller file */