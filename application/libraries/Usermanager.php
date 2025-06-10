<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/* --------------------------------------------
 * @package		BPHTB
 * @filename    Usermanager.php
 * @author		Cendana2000
 * @Updated     -
 * -------------------------------------------- 
 * Naming Convention
 * 1. File names must be capitalized. For example:  Myclass.php
 * 2. Class declarations must be capitalized. For example:  class Myclass
 * 3. Class names and file names must match.
 * ------------------------------------------------------------------ 
 * Normalnya pemanggilan fungsi controller dengan menggunakan struktur '$this'
 * namun jika ingin memanggil fungsi yang ada pada codeigniter dari fungsi yang kita definisikan sendiri 
 * maka definisikan definisikan Object Codeigniter ke dalam variable 
 * yang nantinya dapat dipanggil sebagai pengganti '$this'   
 *  ------------------------------------------------------------------
 */
class Usermanager{
    var $CI;
	var $params  = array();
	var $errmsg  = '';
	
	function Usermanager(){
		$this->CI =& get_instance(); 
	}
	
	function Authentifikasi( $level = '' ){
		if ( !( $this->CI->mysession->userdata('SESSI_BPHTB_DINAS_UID') and ($this->CI->mysession->userdata('SESSI_BPHTB_DINAS_UID')<>'') and $this->CI->mysession->userdata('SESSI_BPHTB_DINAS_GID') and ($this->CI->mysession->userdata('SESSI_BPHTB_DINAS_GID')<>'')) ):
			redirect('admin', 'refresh');
			return false;
		endif;
	}
	
	function Authenticated(){
		if ( ( $this->CI->mysession->userdata('SESSI_BPHTB_DINAS_UID') and ($this->CI->mysession->userdata('SESSI_BPHTB_DINAS_UID')<>'') and $this->CI->mysession->userdata('SESSI_BPHTB_DINAS_GID') and ($this->CI->mysession->userdata('SESSI_BPHTB_DINAS_GID')<>'')) ):
			return true;
		endif;
		return false;
	}
	
	
	function Datasessi( $params = '', $gid='' ){
		switch ( $params ) :
			case 'GID'      : return $this->CI->mysession->userdata('SESSI_BPHTB_DINAS_GID'); break; 
			case 'UID'      : return $this->CI->mysession->userdata('SESSI_BPHTB_DINAS_UID'); break; 
			default         : return ''; break;
		endswitch;
	}
	
	function Register($params){
        if ( is_array($params) and (count($params) > 0) ):
			$this->CI->mysession->set_userdata($params);
        endif;
	}
	
	function GenPasswordUser( $username, $password ){
	    $result = '';
	    $result = md5(trim($username).trim($password));
	    return $result;
	}
	
	function Unregister($params=array()){
		$this->CI->mysession->unset_userdata($params);
	}
}