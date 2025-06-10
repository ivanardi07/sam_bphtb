<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: sptpd.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Transaksi extends MY_Controller
{

    private $table_prefix   = '';

    public function __construct()
    {
        parent::__construct();

        header("Access-Control-Allow-Origin: *");

        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->library('quotes');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('m_global','global');
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
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $info         = '';
        $data['info'] = '';

        if ($this->input->post('submit_multi')) {
            $check = $this->input->post('check');
            if (!empty($check)):
                switch ($this->input->post('submit_multi')) {
                    case 'delete':
                        foreach ($check as $ch) {$this->mod_sptpd->delete_sptpd($ch);    }
                        break;
                } else :$info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }

        //search
        if ($this->input->post('search')) {
            $search = array(
                'id_ppat'      => trim($this->input->post('ppat')),
                'nop'          => trim($this->input->post('txt_search_nop')),
                'no_pelayanan' => trim($this->input->post('txt_search_no_pelayanan')),
                'nodok'        => trim($this->input->post('txt_search_nodok')),
                'date_start'   => trim(changeDateFormat('database', $this->input->post('txt_search_dstart'))),
                'date_stop'    => trim(changeDateFormat('database', $this->input->post('txt_search_dstop'))),
            );
            $this->session->set_userdata('sptpd_search', $search);
        } else {
            if ($this->uri->segment(3) == '') {
                $search = array(
                    'id_ppat'      => '',
                    'nop'          => '',
                    'no_pelayanan' => '',
                    'nodok'        => '',
                    'date_start'   => trim(changeDateFormat('database', date('d-m-Y'))),
                    'date_stop'    => trim(changeDateFormat('database', date('d-m-Y'))),
                );
            
                $this->session->set_userdata('sptpd_search', $search);
            }
        }
        if ($this->input->post('reset')) {
            $this->session->unset_userdata('sptpd_search');
        }

        $nop_sess     = $this->session->userdata('sptpd_search'); //array
        $nop_search   = str_replace('.', '', $nop_sess['nop']);
        $kd_propinsi  = substr($nop_search, 0, 2);
        $kd_kabupaten = substr($nop_search, 2, 2);
        $kd_kecamatan = substr($nop_search, 4, 3);
        $kd_kelurahan = substr($nop_search, 7, 3);
        $kd_blok      = substr($nop_search, 10, 3);
        $no_urut      = substr($nop_search, 13, 4);
        $kd_jns_op    = substr($nop_search, 17, 1);
        $id_compile   = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);
        $id_ppat      = $nop_sess['id_ppat'];
        $nodok        = $nop_sess['nodok'];
        $no_pelayanan = $nop_sess['no_pelayanan'];
        $date_start   = $nop_sess['date_start'];
        $date_stop    = $nop_sess['date_stop'];
        //endsearch

        $this->load->library('pagination');
        $config['base_url']   = $this->c_loc . '/index';
        $config['total_rows'] = $this->mod_sptpd->count_sptpd($date_start, $date_stop);

        $config['per_page']        = 20;
        $config['uri_segment']     = 3;
        $config['full_tag_open']   = '<ul>';
        $config['full_tag_close']  = '</ul>';
        $config['first_link']      = 'First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']       = 'Last';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['next_link']       = 'Next →';
        $config['next_tag_open']   = '<li class="next">';
        $config['next_tag_close']  = '</li>';
        $config['prev_link']       = '← Prev';
        $config['prev_tag_open']   = '<li class="prev disabled">';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        $data['start']             = $this->uri->segment(3);

        if (empty($data['start'])) {
            $data['start'] = 0;

        }

        $data['sptpds'] = $this->mod_sptpd->get_sptpd('', '', 'page', $data['start'], $config['per_page'], '', $id_compile, $id_ppat, $nodok, $no_pelayanan, $date_start, $date_stop);
        $this->pagination->initialize($config);
        $data['info']      = $this->session->flashdata('info');
        $data['search']    = $nop_sess;
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc']     = $this->c_loc;
        $data['userdata']  = $this->session->all_userdata();
        $data['ppat']      = $this->db->get("tbl_ppat")->result();

        $this->antclass->skin('v_transaksi1', $data);
    }

}