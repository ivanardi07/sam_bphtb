<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_jumlah_transaksi extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url_helper');
        $this->load->model('mod_jumlah_transaksi', 'mdb');
        $this->load->library('terbilang');
        $this->load->library('quotes');
        $this->load->library('tanggal');
    }

	public function index()
	{
		$data['title']        = 'CEK JUMLAH TRANSAKSI WP';
        $data['data_nik']     = $this->mdb->getDataNikOpt();
        
		if ($this->input->post('txt_submit')) {
        	$nik 					= $this->input->post('nik');
            $nik                    = explode('-', $nik);
            $nik                    = trim($nik[0]);
	        $data['nik'] 			= $this->mdb->getDataNik($nik);
	        $data['dataJumlah'] 	= $this->mdb->get_jumlah_transaksi($nik);
            
        }
        
        $this->antclass->skin('v_cek_jumlah_transaksi', $data);
	}

}

/* End of file cek_jumlah_transaksi.php */
/* Location: ./application/controllers/cek_jumlah_transaksi.php */