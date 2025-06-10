<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mysession{
	function Mysession(){ session_start(); }
	
	function userdata($param){
		$result = false;
		if ( isset($_SESSION[$param]) ):
			$result = $_SESSION[$param];
	    endif;
		return $result;
	}
	
	function set_userdata( $param='', $value='' ){
        $result = false;
		if ( is_array($param) ):
			$aKey = array_keys($param);
			foreach ($aKey as $sVal){
				$_SESSION[$sVal] = $param[$sVal];
            }
			$result = true;
		elseif ( $param <> '' ) :
		    $_SESSION[$param] = $value;
			$result = true;
		endif;
		return $result;
	}
	
	function unset_userdata ( $param='', $value='' ){
        $result = false;
		if ( is_array($param) ):
			$aKey = array_keys($param);
			foreach ($aKey as $sVal){
				if ( isset($_SESSION[$sVal]) ):
					$_SESSION[$sVal] = $param[$sVal];
					unset($_SESSION[$sVal]);
				endif;	
            }
			$result = true;
		elseif ( $param <> '' ) :
			if ( isset($_SESSION[$param]) ):  
				unset($_SESSION[$param]);
			endif;	
			$result = true;
		endif;
		return $result;
	}	
}