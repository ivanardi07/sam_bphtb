<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: sptpd.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Reject_sspd extends MY_Controller
{

    private $table_prefix   = '';

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('mod_aprove_sspd', 'aprove');
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->library('quotes');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_sppt');
        $this->load->model('mod_ppat');
        $this->load->model('mod_nik');
        $this->load->model('mod_nop');
        $this->load->model('mod_dati2');
        $this->load->model('mod_propinsi');
        $this->load->model('mod_kecamatan');
        $this->load->model('mod_kelurahan');
        $this->load->model('mod_jns_perolehan');
        $this->load->model('mod_rekening');
        $this->load->model('mod_paymentpoint');
        $this->load->model('mod_nop_log');
        $this->load->model('mod_user');
        $this->load->model('mod_prefix');
        $this->load->model('mod_formulir_penelitian');
        $this->load->model('mod_validasi_sptpd', 'pembayaran');
        $this->c_loc = base_url() . 'index.php/sptpd';
        $this->load->model('mod_aprove_user', 'aprove1');
        $this->load->model('m_global', 'global');
    }

    public function index()
    {
        $get  = $this->session->all_userdata();
        $tipe = $get['s_tipe_bphtb'];

        if ($tipe == 'PT') {
            $ppat = $this->session->userdata('s_id_ppat');
            $data['user'] = $this->mod_sptpd->get_reject_pt($ppat);
        } elseif ($tipe == 'D') {
            $data['user'] = $this->mod_sptpd->get_reject_d();
        }

        $data['c_loc'] = site_url() . 'reject_sspd';

        $this->antclass->skin('v_reject', $data);
    }
}
