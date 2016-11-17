<?php
if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

/**
 * This class handles sessions as determined by the configuration settings. 
 * It may use PHP or memcache settings based on config instructions.
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 11/05/2015
 */

include_once('session/Php_session.php');
include_once('session/Memcached_session.php');

class Native_session
{
    private $session;
	
	# start the session object
	public function __construct()
    {
        # Only regenarate the session if not already created
		if(empty($this->session))
		{
			if(IS_BALANCED) $this->session = new Memcached_session();
			else $this->session = new Php_session();
		}
    }

	# set a variable/value to the session
    public function set($key, $value)
    {
        $this->session->set($key, $value);
    }

	# set a full array of variable[key]/value[value] array
    public function set_array($valueArray)
    {
        $this->session->set_array($valueArray);
    }
	
	# get a session variable given its value
    public function get($key, $refresh=FALSE)
    {
        return $this->session->get($key, $refresh);
    }

	# regenerate the session id
    public function regenerate_id( $delOld = false )
    {
        $this->session->regenerate_id($delOld);
    }

	# delete a session variable
    public function delete($key)
    {
        $this->session->delete($key);
    }

	# delete all session variables and remove the session as well
    public function delete_all()
    {
         $this->session->delete_all();
    }
}