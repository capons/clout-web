<?php
/**
 * This class handles sessions the same way PHP would handle sessions
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 11/05/2015
 */

class Php_session
{
    public function __construct()
    {
        @session_start();
    }

    public function set( $key, $value )
    {
    	@session_start();
    	$_SESSION[$key] = $value;
    }

    public function set_array( $valueArray )
    {
        foreach($valueArray AS $key=>$value)
		{
			$_SESSION[$key] = $value;
		}
    }
	
    public function get($key)
    {
    	@session_start();
    	return isset($_SESSION[$key])? $_SESSION[$key] : null;
	}

    public function regenerate_id( $delOld = false )
    {
        @session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }

    public function delete_all()
    {
        @session_destroy();
    }
}

