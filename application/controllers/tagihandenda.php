<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: sptpd.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Tagihandenda extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->c_loc = base_url().'index.php/penerbitanlapangan';
    }

    function index()
    {
        $this->add();
    }
    
    function add()
    {
		$data['bulan'] = array(
			1=>'Januari',
			2=>'Februari',
			3=>'Maret',
			4=>'April',
			5=>'Mei',
			6=>'Juni',
			7=>'Juli',
			8=>'Agustus',
			9=>'September',
			10=>'Oktober',
			11=>'November',
			12=>'Desember',
		);
		$data['jenisdenda'] = array(
			''=>'- Pilih Jenis Denda -',
		);
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $this->antclass->skin('v_tagihandendaform', $data);
    }
}

/* EoF */