<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Theme {
    var $CI;

    function Theme(){
        $this->CI =& get_instance();
		$this->CI->load->helper('text');
		$this->CI->load->helper('url');
		$this->CI->load->library('quotes');
    }
    
	function skin($view, $vars=array('')){
		$data['child'] = $this->CI->load->view($view, $vars, TRUE);
		return $this->CI->load->view('skin.tpl.php', $data);
    }
	
	function getThemePathInfo( $type='' ){
		switch($type):
			case 'css' :
			      return base_url().'themes/css/';
				  break;
			case 'js' :
			      return base_url().'themes/js/';
			      break;
			case 'images' :
			      return base_url().'themes/images/';
			      break;	  
			default :
			      return base_url().'themes/';
				  break;
		endswitch; 
	}
	
	function locateThemeFileInfo( $type, $filename ){
	    $result['path']     = $this->getThemePathInfo(trim($type));
	    $result['filename'] = trim($filename);
	    return implode( '', $result );
	}
	
	function getBreadCrumbs(){
		return '';
	}  
	
}