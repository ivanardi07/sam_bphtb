<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'/third_party/mpdf60/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = '"en-GB-x","F4","","",10,10,10,10,6,3')
    {
    	$i = 0;
    	$mode = 'F4';
    	if (is_array($param)) {
    		$mode = 'F4-L';
	    	// foreach ($param as $key) {
	    	// 	$i++;
	    	// 	if ($i == 1) {
	    	// 		$param = '"'.$key.'"';
	    	// 	}else{
	    	// 		if(is_numeric($key)){
	    	// 			$param .= ','.$key;
	    	// 		}else{
	    	// 			$param .= ',"'.$key.'"';
	    	// 		}
	    	// 	}
	    	// }
    	}
        // $this->param =$param;
    	// echo "<pre>";
    	// print_r ($this->param);
    	// echo "</pre>";exit();
        $this->pdf = new mPDF("c",$mode);
    }
}
