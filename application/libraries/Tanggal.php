<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tanggal{
	function Tanggal(){}
	     
	function cektanggal( $tgl='', $sep='' ){
		// Format $tgl ( dd-mm-yyyy )
	    $separator = ( $sep <> '' )? $sep : '-'; 
		if ( $tgl == '' ) { return false; } 
		
		// Ekstrak Tanggal
	    $tg  = explode( $separator, $tgl );
		$day = $tg[0];  $month = $tg[1]; $year = $tg[2];
		
		// Cek Empty Tanggal
		if ( ($day == '') || ($month == '') || ($year == '') ){ return false; } 
		
		// Cek Valid Tanggal
		if ( !is_numeric($day) || !is_numeric($month) || !is_numeric($year) ){ return false; }
		
		// bool checkdate ( int month, int day, int year )
		return checkdate( $month, $day, $year );
	}
	
	function sitestamp(){
		$arr_hari   = array ("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		$arr_bulan  = array ("","Januari", "Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
		$tanggal[0] = $arr_hari[date("w",time())];
		$tanggal[1] = date("d",time());
		$tanggal[2] = $arr_bulan[date("n",time())];
		$tanggal[3] = date("Y",time());
		return $tanggal[0].", ".$tanggal[1]." ".$tanggal[2]." ".$tanggal[3];
	}
     
	function date_formatter( $d='', $format='d-m-Y', $separator='/' ){
		if ( !empty($d) ):
		   $d = trim($d);
		   return date($format, strtotime($d));
		else : 
		    return FALSE;
		endif; 
	}
    
	function dmY2Ymd( $d='', $separator='/' ){
		if ( !empty($d) ):
		   $d = trim($d);
		   return date('Y-m-d',strtotime($d));
		else : 
		    return " - - ";
		endif; 
	}

	function mdY2dmY( $d='', $separator='/' ){
		if ( !empty($d) ):
		   $d = trim($d);
		   return date('d-m-Y',strtotime($d));
		else : 
		    return " - - ";
		endif; 
	}

	function mdYhis2dmYhis( $tg ='', $separator='' ){
	    # define separator   
	    if ( !empty($tg) ) :
		   $tgl = trim($tg);
		   return date('d-m-Y H:i:s',strtotime($tgl));
	    else :
		   return " - - ";
		endif; 
	}
	
	function mdYhis2dmY( $tg ='', $separator='' ){
	    # define separator   
	    if ( !empty($tg) ) :
		   $tgl = trim($tg);
		   return date('d-m-Y',strtotime($tgl));
	    else :
		   return " - - ";
		endif; 
	}

	function lastmonth ( $month='', $year='')
	 {
	   $result = '--';
	   if ( !empty($month) or !empty($year) )
		 {  
		   $date = 01;
		   while (checkdate($month,$date,$year)): 
			 $date++; 
		   endwhile; 
		   $date = $date-1;
		   $result = date('Y-m-d',mktime(0,0,0,$month,$date,$year));
		 }
	   return $result; 
	 }  
	
	 function bulan( $bln )
	 {
		$b = array( '','Januari','Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli','Agustus','September','Oktober', 'Nopember', 'Desember' );
		$m = intval($bln);
		return ( ( $m >= 0 ) && ( $m <= 12 ) ) ? $b[$m] :'';
	 }

}	