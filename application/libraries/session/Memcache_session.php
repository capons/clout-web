<?php
/**
 * This class handles sessions using the memcached server (for distributed installations)
 *
 * @author Al Zziwa <al@clout.com>
 * @version 1.3.0
 * @copyright Clout
 * @created 11/05/2015
 */


class Memcache_session
{
    private $memcache;    
	private $lifetime = 0;
	private $id;
	private $systemCookie = 'SYSPHPSESSID';
	
	# object constructor
	public function __construct()
    {
        $this->memcache = new Memcache;
        $this->memcache->connect(MEMCACHED_SERVER, MEMCACHED_PORT) or die("Error : Memcache is not ready");
        # Session lifetime
		$this->lifetime = ini_get('session.gc_maxlifetime');
		
		@session_start();
		# Read the session or create a new one
		if(!empty($_COOKIE[$this->systemCookie])){
			$this->id =  $_COOKIE[$this->systemCookie];
			session_id($this->id);
		}
		else {
			$this->id = session_id();
			setcookie($this->systemCookie, $this->id, time()+$this->lifetime); # expire at the same time as the session
		}
    }
	
	public function set( $key, $value )
    {
		$_COOKIE[$key] = $value;
		$this->memcache->set($this->id.'__'.$key, $value);
    }

    public function set_array( $valueArray )
    {
        foreach($valueArray AS $key=>$value) $this->set($key, $value);
    }
	
    public function get($key, $refresh=FALSE)
    {
		return (!$refresh && isset($_COOKIE[$key]))? $_COOKIE[$key]: $this->read($key);
	}
	
	public function read($key)
    {
		$session = array();
		
		$allSlabs = $this->memcache->getExtendedStats('slabs');
		$items = $this->memcache->getExtendedStats('items');
		
		foreach($allSlabs AS $server => $slabs) {
    		foreach($slabs AS $slabId => $slabMeta) {
        		if (!is_int($slabId)) continue;
        		
				$cacheDump = $this->memcache->getExtendedStats('cachedump', (int)$slabId, 100000000);
        		foreach($cacheDump AS $keys => $arrayValue) { 
            		if ($arrayValue){
                	# Process arrays in the cache dump
					# values are in the format:
						foreach($arrayValue AS $sessionKey => $sessionValue) {
							# Only collect proper session values
							if(strpos($sessionKey,'.') === FALSE && strpos($sessionKey,$this->id.'__') !== FALSE) {
								$mkey = str_replace($this->id.'__','',$sessionKey);
								$session[$mkey] = $this->memcache->get($sessionKey);
								if($mkey == $key) break 4;
							}
						}
					}
            	}
    		}
		}

		return !empty($session[$key])? $session[$key]: null;
	}
	
	
	
	
	
    public function regenerate_id( $delOld = false )
    {
        @session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        if(isset($_SESSION[$key])) unset($_SESSION[$key]);
		$this->memcache->delete($this->id.'__'.$key);
    }

    public function delete_all()
    {
        @session_destroy();
		if(!empty($this->id)) setcookie($this->systemCookie, "", time()-3600);
    }
}

