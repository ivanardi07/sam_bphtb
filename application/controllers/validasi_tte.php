<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: validasi_tte.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Validasi_tte extends MY_Controller
{

    private $table_prefix   = '';
    private $enableEmailing = false;

    public function __construct()
    {
        parent::__construct();

        header("Access-Control-Allow-Origin: *");

        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->library('quotes');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->helper('captcha');
        $this->load->model('m_global', 'global');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_lspop');
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
        $this->load->model('mod_register', 'reg');
        $this->load->model('mod_formulir_penelitian');
        $this->load->model('mod_validasi_sptpd', 'pembayaran');

        $this->load->model('mod_service');
        $this->c_loc = base_url() . 'index.php/validasi_tte';
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $info         = '';
        $data['info'] = '';
        if ($this->input->post('submit_multi')) {
            $check = $this->input->post('check');
            if (!empty($check)) :
                switch ($this->input->post('submit_multi')) {
                    case 'delete':
                        foreach ($check as $ch) {
                            $this->mod_sptpd->delete_sptpd($ch);
                        }
                        break;
                }
            else : $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }

        $data['count']          = $this->mod_sptpd->get_notif_jml_tte();
        $data['info']           = $this->session->flashdata('info');
        $data['c_loc']          = $this->c_loc;
        $data['userdata']       = $this->session->all_userdata();
        $data['nik_tte_kabid']  = $this->mod_sptpd->get_nik_user_kabid($this->session->userdata('s_id_user'))->nik;

        $this->antclass->skin('v_validasi_tte', $data);
    }

    public function get_notif_jml_tte()
    {
        $data = $this->mod_sptpd->get_notif_jml_tte();
        echo $data;
    }
}
