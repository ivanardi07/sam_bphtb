<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: sptpd.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Sptpd extends MY_Controller
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
        $this->c_loc = base_url() . 'index.php/sptpd';
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
        //tambah search
        //$data['sptpds'] = $this->mod_sptpd->get_sptpddata();
        $data['count']     = $this->mod_sptpd->hitung_berkas();
        $data['info']      = $this->session->flashdata('info');
        $data['c_loc']     = $this->c_loc;
        $data['userdata']  = $this->session->all_userdata();

        $this->antclass->skin('v_sptpd', $data);
    }

    public function laporan_bp2d()
    {
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc . '/laporan_bp2d/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '';

        // echo "<pre>";
        // print_r($config['base_url']);exit;
        if ($this->uri->segment(5) == '-') {
            $pp      = '';
        } else {
            $pp      = $this->uri->segment(5);
        }
        if ($this->uri->segment(6) == '-') {
            $ppat    = '';
        } else {
            $ppat    = $this->uri->segment(6);
        }
        if ($this->uri->segment(7) == '0') {
            $pwp     = '';
        } else {
            $pwp     = $this->uri->segment(7);
        }
        if ($this->uri->segment(8) == '0') {
            $stb     = '';
        } else {
            $stb     = $this->uri->segment(8);
        }
        if ($this->uri->segment(9) == '0') {
            $skbkb   = '';
        } else {
            $skbkb   = $this->uri->segment(9);
        }
        if ($this->uri->segment(10) == '0') {
            $skbkbt = '';
        } else {
            $skbkbt = $this->uri->segment(10);
        }
        if ($this->uri->segment(11) == '-') {
            $user   = '';
        } else {
            $user   = $this->uri->segment(11);
        }
        if ($this->uri->segment(12) == '-') {
            $nodok  = '';
        } else {
            $nodok  = $this->uri->segment(12);
        }
        if ($this->uri->segment(13) == '-') {
            $status = '';
        } else {
            $status = $this->uri->segment(13);
        }

        $config['total_rows'] = $this->mod_sptpd->count_sptpd('', '', '', '', '', '', '', '', '', '', '');
        // echo $this->db->last_query();exit();
        // echo "<pre>";
        // print_r($config['total_rows']);exit;
        $config['per_page']                        = 20;
        $config['uri_segment']                     = 14;
        $data['start']                             = $this->uri->segment(14);
        $config['full_tag_open']                   = '<ul>';
        $config['full_tag_close']                  = '</ul>';
        $config['first_link']                      = 'First';
        $config['first_tag_open']                  = '<li>';
        $config['first_tag_close']                 = '</li>';
        $config['last_link']                       = 'Last';
        $config['last_tag_open']                   = '<li>';
        $config['last_tag_close']                  = '</li>';
        $config['next_link']                       = 'Next →';
        $config['next_tag_open']                   = '<li class="next">';
        $config['next_tag_close']                  = '</li>';
        $config['prev_link']                       = '← Prev';
        $config['prev_tag_open']                   = '<li class="prev disabled">';
        $config['prev_tag_close']                  = '</li>';
        $config['cur_tag_open']                    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']                   = '</a></li>';
        $config['num_tag_open']                    = '<li>';
        $config['num_tag_close']                   = '</li>';
        if (empty($data['start'])) {
            $data['start'] = 0;
        }
        $this->pagination->initialize($config);

        $data['page_link']    = $this->pagination->create_links();
        $data['c_loc']        = $this->c_loc;

        $data['hr'] = $this->db->query('select * from tbl_sptpd where aprove_ppat = 1')->result();

        foreach ($data['hr'] as $key => $value) {
            $kd_propinsi              = $value->kd_propinsi;
            $kd_kabupaten             = $value->kd_kabupaten;
            $kd_kecamatan             = $value->kd_kecamatan;
            $kd_kelurahan             = $value->kd_kelurahan;
            $kd_blok                  = $value->kd_blok;
            $no_urut                  = $value->no_urut;
            $kd_jns_op                = $value->kd_jns_op;
            $nop_compile              = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);
            $data['ppat']             = $this->mod_ppat->get_ppat($value->id_ppat);
            $data['nik']              = $this->mod_nik->get_nik($value->nik);
        }
        $wil_nik                  = (array) $data['nik'];
        $wil_nik                  = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']  = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten'] = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan'] = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan'] = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']              = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);

        $this->antclass->skin('v_laporan_bp2d', $data);
    }

    public function laporan_ppat()
    {

        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc . '/laporan_ppat/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '';

        // echo "<pre>";
        // print_r($config['base_url']);exit;
        if ($this->uri->segment(5) == '-') {
            $pp      = '';
        } else {
            $pp      = $this->uri->segment(5);
        }
        if ($this->uri->segment(6) == '-') {
            $ppat    = '';
        } else {
            $ppat    = $this->uri->segment(6);
        }
        if ($this->uri->segment(7) == '0') {
            $pwp     = '';
        } else {
            $pwp     = $this->uri->segment(7);
        }
        if ($this->uri->segment(8) == '0') {
            $stb     = '';
        } else {
            $stb     = $this->uri->segment(8);
        }
        if ($this->uri->segment(9) == '0') {
            $skbkb   = '';
        } else {
            $skbkb   = $this->uri->segment(9);
        }
        if ($this->uri->segment(10) == '0') {
            $skbkbt = '';
        } else {
            $skbkbt = $this->uri->segment(10);
        }
        if ($this->uri->segment(11) == '-') {
            $user   = '';
        } else {
            $user   = $this->uri->segment(11);
        }
        if ($this->uri->segment(12) == '-') {
            $nodok  = '';
        } else {
            $nodok  = $this->uri->segment(12);
        }
        if ($this->uri->segment(13) == '-') {
            $status = '';
        } else {
            $status = $this->uri->segment(13);
        }

        $config['total_rows'] = $this->mod_sptpd->count_sptpd('', '', '', '', '', '', '', '', '', '', '');
        // echo $this->db->last_query();exit();
        // echo "<pre>";
        // print_r($config['total_rows']);exit;
        $config['per_page']                        = 20;
        $config['uri_segment']                     = 14;
        $data['start']                             = $this->uri->segment(14);
        $config['full_tag_open']                   = '<ul>';
        $config['full_tag_close']                  = '</ul>';
        $config['first_link']                      = 'First';
        $config['first_tag_open']                  = '<li>';
        $config['first_tag_close']                 = '</li>';
        $config['last_link']                       = 'Last';
        $config['last_tag_open']                   = '<li>';
        $config['last_tag_close']                  = '</li>';
        $config['next_link']                       = 'Next →';
        $config['next_tag_open']                   = '<li class="next">';
        $config['next_tag_close']                  = '</li>';
        $config['prev_link']                       = '← Prev';
        $config['prev_tag_open']                   = '<li class="prev disabled">';
        $config['prev_tag_close']                  = '</li>';
        $config['cur_tag_open']                    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']                   = '</a></li>';
        $config['num_tag_open']                    = '<li>';
        $config['num_tag_close']                   = '</li>';
        if (empty($data['start'])) {
            $data['start'] = 0;
        }
        $this->pagination->initialize($config);

        $data['page_link']    = $this->pagination->create_links();
        $data['c_loc']        = $this->c_loc;

        $all_user  = $this->session->all_userdata('');
        $id_ppat = $all_user['s_id_ppat'];

        $data['hr'] = $this->db->query("select * from tbl_sptpd where id_ppat = '$id_ppat'")->result();

        foreach ($data['hr'] as $key => $value) {
            $kd_propinsi              = $value->kd_propinsi;
            $kd_kabupaten             = $value->kd_kabupaten;
            $kd_kecamatan             = $value->kd_kecamatan;
            $kd_kelurahan             = $value->kd_kelurahan;
            $kd_blok                  = $value->kd_blok;
            $no_urut                  = $value->no_urut;
            $kd_jns_op                = $value->kd_jns_op;
            $nop_compile              = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);
            $data['ppat']             = $this->mod_ppat->get_ppat($value->id_ppat);
            $data['nik']              = $this->mod_nik->get_nik($value->nik);
        }
        $wil_nik                  = (array) $data['nik'];
        $wil_nik                  = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']  = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten'] = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan'] = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan'] = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']              = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);

        $this->antclass->skin('v_laporan_ppat', $data);
    }

    public function laporan_wp()
    {

        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc . '/laporan_ppat/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '' . '/' . '';

        // echo "<pre>";
        // print_r($config['base_url']);exit;
        if ($this->uri->segment(5) == '-') {
            $pp      = '';
        } else {
            $pp      = $this->uri->segment(5);
        }
        if ($this->uri->segment(6) == '-') {
            $ppat    = '';
        } else {
            $ppat    = $this->uri->segment(6);
        }
        if ($this->uri->segment(7) == '0') {
            $pwp     = '';
        } else {
            $pwp     = $this->uri->segment(7);
        }
        if ($this->uri->segment(8) == '0') {
            $stb     = '';
        } else {
            $stb     = $this->uri->segment(8);
        }
        if ($this->uri->segment(9) == '0') {
            $skbkb   = '';
        } else {
            $skbkb   = $this->uri->segment(9);
        }
        if ($this->uri->segment(10) == '0') {
            $skbkbt = '';
        } else {
            $skbkbt = $this->uri->segment(10);
        }
        if ($this->uri->segment(11) == '-') {
            $user   = '';
        } else {
            $user   = $this->uri->segment(11);
        }
        if ($this->uri->segment(12) == '-') {
            $nodok  = '';
        } else {
            $nodok  = $this->uri->segment(12);
        }
        if ($this->uri->segment(13) == '-') {
            $status = '';
        } else {
            $status = $this->uri->segment(13);
        }

        $config['total_rows'] = $this->mod_sptpd->count_sptpd('', '', '', '', '', '', '', '', '', '', '');
        // echo $this->db->last_query();exit();
        // echo "<pre>";
        // print_r($config['total_rows']);exit;
        $config['per_page']                        = 20;
        $config['uri_segment']                     = 14;
        $data['start']                             = $this->uri->segment(14);
        $config['full_tag_open']                   = '<ul>';
        $config['full_tag_close']                  = '</ul>';
        $config['first_link']                      = 'First';
        $config['first_tag_open']                  = '<li>';
        $config['first_tag_close']                 = '</li>';
        $config['last_link']                       = 'Last';
        $config['last_tag_open']                   = '<li>';
        $config['last_tag_close']                  = '</li>';
        $config['next_link']                       = 'Next →';
        $config['next_tag_open']                   = '<li class="next">';
        $config['next_tag_close']                  = '</li>';
        $config['prev_link']                       = '← Prev';
        $config['prev_tag_open']                   = '<li class="prev disabled">';
        $config['prev_tag_close']                  = '</li>';
        $config['cur_tag_open']                    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']                   = '</a></li>';
        $config['num_tag_open']                    = '<li>';
        $config['num_tag_close']                   = '</li>';
        if (empty($data['start'])) {
            $data['start'] = 0;
        }
        $this->pagination->initialize($config);

        $data['page_link']    = $this->pagination->create_links();
        $data['c_loc']        = $this->c_loc;

        $all_user  = $this->session->all_userdata('');
        $id_wp = $all_user['s_id_wp'];

        $data['hr'] = $this->db->query("select * from tbl_sptpd where id_wp = '$id_wp'")->result();

        foreach ($data['hr'] as $key => $value) {
            $kd_propinsi              = $value->kd_propinsi;
            $kd_kabupaten             = $value->kd_kabupaten;
            $kd_kecamatan             = $value->kd_kecamatan;
            $kd_kelurahan             = $value->kd_kelurahan;
            $kd_blok                  = $value->kd_blok;
            $no_urut                  = $value->no_urut;
            $kd_jns_op                = $value->kd_jns_op;
            $nop_compile              = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);
            $data['ppat']             = $this->mod_ppat->get_ppat($value->id_ppat);
            $data['nik']              = $this->mod_nik->get_nik($value->nik);
        }
        $wil_nik                  = (array) $data['nik'];
        $wil_nik                  = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']  = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten'] = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan'] = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan'] = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']              = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);

        $this->antclass->skin('v_laporan_ppat', $data);
    }

    public function refresh()
    {
        $this->session->unset_userdata('sptpd_search');
        redirect('sptpd');
    }

    public function get_prev_bynik()
    {
        $nik = $this->input->post('rx_id_nik');
        // echo $nik.' yoo'; exit;
        $skbkb              = $this->input->post('rx_skbkb');
        $cek_transaksi_prev = $this->mod_sptpd->get_sptpd('', 1, '', '', '', $nik); // Cek apakah NIK pernah transaksi sebelumnya

        if (!$cek_transaksi_prev) {
            // NIK TIDAK PERNAH melakukan transaksi, dapat NPOPTKP
            echo '0';
            exit;
        } else {
            // NIK PERNAH melakukan transaksi dan bukan SKBKB
            // Cek apakah jenis pembayaran SKBKB
            if ($skbkb == 'undefined') {
                // Bukan pembayaran SKBKB
                // NIK PERNAH melakukan transaksi dan bukan SKBKB
                foreach ($cek_transaksi_prev as $cek_prev) {
                    // Cek apakah transaksi dalam tahun yang sama, apabila TRUE maka tidak dapat NPOPTKP, jika beda tahun dapat NPOPTKP
                    $tahun_trx = substr($cek_prev->tanggal, 0, 4);
                    if ($tahun_trx != date('Y')) {
                        echo '0';
                    } else {
                        echo '1';
                    }
                }
                exit;
            } else {
                // Pembayaran SKBKB
                echo '0';
                exit;
            }
        }
    }

    public function add()
    {
        $array = array(
            // nik
            's_nik_nik'                          => $this->input->post('txt_id_nik_sptpd'),
            's_nama_nik'                         => $this->input->post('nama_nik_name'),
            's_alamat_nik'                       => $this->input->post('alamat_nik_name'),
            's_propinsi_nik'                     => $this->input->post('propinsi_nik_name'),
            's_kd_dati2_nik'                     => $this->input->post('kotakab_nik_name'),
            's_kd_kecamatan_nik'                 => $this->input->post('kecamatan_nik_name'),
            's_kd_kelurahan_nik'                 => $this->input->post('kelurahan_nik_name'),
            's_rtrw_nik'                         => $this->input->post('rtrw_nik_name'),
            's_kodepos_nik'                      => $this->input->post('kodepos_nik_name'),

            // nop
            's_txt_id_nop_sptpd'                 => $this->input->post('txt_id_nop_sptpd'),

            // lampiran
            's_txt_picture_lampiran_sspd_1_file' => $this->input->post('txt_picture_lampiran_sspd_1_file'),
        );

        $this->session->set_userdata($array);

        // $param = $_POST;
        // echo "<pre>";print_r($param);exit();

        if ($this->input->post('submit')) {
            $data['info'] = '';
            $this->load->library('form_validation');
            $ident = $this->input->post('ident');
            //hilangi nama_ppat_id
            //jilangi txt_id_ppat_sptpd
            //$this->form_validation->set_rules('txt_id_ppat_sptpd', 'ID PPAT', 'required|xss_clean');
            $this->form_validation->set_rules('txt_id_nik_sptpd', 'NIK', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_id_nop_sptpd', 'NOP', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_nilai_pasar_sptpd', 'Nilai Pasar', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_npop_sptpd', 'NPOP', 'required|trim');
            $this->form_validation->set_rules('txt_jml_setor_sptpd', 'Jumlah yang disetor', 'required|numeric|trim');
            $this->form_validation->set_rules('txt_jns_perolehan_sptpd', 'Jenis Perolehan', 'trim|required');
            if ($ident != '') {
                $this->form_validation->set_rules('nama_nik_name', 'Nama', 'required|trim');
                $this->form_validation->set_rules('alamat_nik_name', 'Alamat', 'required|trim');
                $this->form_validation->set_rules('propinsi_nik_name', 'Propinsi', 'required|trim');
                $this->form_validation->set_rules('kotakab_nik_name', 'Kabupaten / Kota', 'required|trim');
                $this->form_validation->set_rules('kecamatan_nik_name', 'Kecamatan', 'required|trim');
                $this->form_validation->set_rules('kelurahan_nik_name', 'Kelurahan', 'required|trim');
                $this->form_validation->set_rules('rtrw_nik_name', 'RT / RW', 'trim');
                $this->form_validation->set_rules('kodepos_nik_name', 'Kode Pos', 'trim');
            }
            if ($this->form_validation->run() == false) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $nik_nik          = $this->input->post('txt_id_nik_sptpd');
                $nama_nik         = $this->input->post('nama_nik_name');
                $alamat_nik       = $this->input->post('alamat_nik_name');
                $propinsi_nik     = $this->input->post('propinsi_nik_name');
                $kd_dati2_nik     = $this->input->post('kotakab_nik_name');
                $kd_kecamatan_nik = $this->input->post('kecamatan_nik_name');
                $kd_kelurahan_nik = $this->input->post('kelurahan_nik_name');
                $rtrw_nik         = $this->input->post('rtrw_nik_name');
                $kodepos_nik      = $this->input->post('kodepos_nik_name');

                if ($ident != '') {
                    $hitung = $this->mod_nik->ceknik($nik_nik);
                    if (!empty($hitung)) {
                        $data['info'] = err_msg('NIK Sudah Ada.');
                    } else {
                        $info = $this->mod_nik->add_nik(
                            $nik_nik,
                            $nama_nik,
                            $alamat_nik,
                            $propinsi_nik,
                            $kd_dati2_nik,
                            $kd_kecamatan_nik,
                            $kd_kelurahan_nik,
                            $rtrw_nik,
                            $kodepos_nik
                        );
                    }
                }

                // $id_ppat = $this->antclass->remove_separator($this->input->post('txt_id_ppat_sptpd'));

                $unique_code = $this->antclass->get_unique_code(5);
                $id_ppat     = $this->session->userdata('s_id_ppat');
                $nik         = $this->input->post('txt_id_nik_sptpd');
                $wajibpajak   = $this->input->post('wajibpajak') . " " . $this->input->post('wajibpajaktext') . " " . $this->input->post('wajibpajaklainnya');

                $nop = $this->antclass->remove_separator($this->input->post('txt_id_nop_sptpd'));
                // pemecahan nop
                $kd_propinsi  = substr($nop, 0, 2);
                $kd_kabupaten = substr($nop, 2, 2);
                $kd_kecamatan = substr($nop, 4, 3);
                $kd_kelurahan = substr($nop, 7, 3);
                $kd_blok      = substr($nop, 10, 3);
                $no_urut      = substr($nop, 13, 4);
                $kd_jns_op    = substr($nop, 17, 1);
                $nop_compile  = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

                //str replace alamat nop
                $nop_alamat_filter   = @$this->input->post('alamat_nop_id');
                $nop_alamat          = str_replace("'", "`", $nop_alamat_filter);

                //inputan nop
                $nopsave_lokasi           = $this->input->post('nopsave_letak_tanah');
                $nopsave_kd_dati2_nop     = $kd_kabupaten;
                $nopsave_kd_kecamatan_nop = $kd_kecamatan;
                $nopsave_kd_kelurahan_nop = $kd_kelurahan;
                $nopsave_rtrw             = $this->input->post('nopsave_rtrw');
                $nopsave_luas_tanah       = $this->input->post('nopsave_luas_tanah');
                $nopsave_njop_tanah       = $this->input->post('nopsave_njop_tanah');
                $nopsave_luas_bangunan    = $this->input->post('nopsave_luas_bangunan');
                $nopsave_njop_bangunan    = $this->input->post('nopsave_njop_bangunan');
                $nopsave_njop_pbb         = $this->input->post('nopsave_njop');
                $nopsave_kd_propinsi_op   = $kd_propinsi;
                $nopsave_no_sertipikat    = $this->input->post('nopsave_no_serf');
                $nopsave_thn_pajak_sppt   = $this->input->post('nopsave_thnpjk');
                $nopsave_ident            = $this->input->post('status_pencarian_nop');

                $nopsave_propinsi            = $this->input->post('nopsave_propinsi');
                $nopsave_kabupaten           = $this->input->post('nopsave_kabupaten');
                $nopsave_kecamatan           = $this->input->post('nopsave_kecamatan');
                $nopsave_kelurahan           = $this->input->post('nopsave_kelurahan');
                $nopsave_ref_tanah           = $this->input->post('ref_tanah');
                $nopsave_ref_bangunan        = $this->input->post('ref_bangunan');
                $param_nop['nama_penjual']   = $this->input->post('nama_penjual');
                $param_nop['alamat_penjual'] = $this->input->post('alamat_penjual');

                //add nop
                if ($nopsave_ident == 'dari sismiop') {
                    $this->mod_nop->add_nop(
                        $nop_compile,
                        $nopsave_lokasi,
                        $nopsave_kd_kelurahan_nop,
                        $nopsave_rtrw,
                        $nopsave_kd_kecamatan_nop,
                        $nopsave_kd_dati2_nop,
                        $nopsave_luas_tanah,
                        $nopsave_luas_bangunan,
                        $nopsave_njop_tanah,
                        $nopsave_njop_bangunan,
                        $nopsave_njop_pbb,
                        '',
                        '',
                        $nopsave_no_sertipikat,
                        $nopsave_kd_propinsi_op,
                        $nopsave_thn_pajak_sppt,
                        $nopsave_ref_tanah,
                        $nopsave_ref_bangunan,
                        $param_nop
                    );

                    //input propinsi
                    $check_prop = $this->mod_propinsi->get_propinsi($kd_propinsi);
                    if (count($check_prop) == 0) {
                        $this->mod_propinsi->add_propinsi($kd_propinsi, $nopsave_propinsi);
                    }
                    //input kabupaten
                    $check_kab = $this->mod_dati2->get_dati2($kd_kabupaten, '', $kd_propinsi);
                    if (count($check_kab) == 0) {
                        $this->mod_dati2->add_dati2($kd_propinsi, $kd_kabupaten, $nopsave_kabupaten);
                    }
                    //input kecamatan
                    $check_kec = $this->mod_kecamatan->get_kecamatan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan);

                    if (count($check_kec) == 0) {
                        $this->mod_kecamatan->add_kecamatan($kd_kecamatan, $nopsave_kecamatan, $kd_propinsi, $kd_kabupaten);
                    }
                    //input kelurahan
                    $check_kel = $this->mod_kelurahan->get_kelurahan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan);

                    if (count($check_kel) == 0) {
                        $this->mod_kelurahan->add_kelurahan($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $nopsave_kelurahan);
                    }
                }

                $luas_tanah_sptpd    = $this->input->post('txt_luas_tanah_sptpd');
                $luas_bangunan_sptpd = $this->input->post('txt_luas_bangunan_sptpd');
                $luas_tanah_b_sptpd  = $this->input->post('txt_luas_tanah_b_sptpd');
                $luas_bangunan_b_sptpd  = $this->input->post('txt_luas_bangunan_b_sptpd');
                $njop_tanah_sptpd    = str_replace('.', '', $this->input->post('txt_njop_tanah_sptpd'));
                $njop_bangunan_sptpd = str_replace('.', '', $this->input->post('txt_njop_bangunan_sptpd'));
                $njop_tanah_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_tanah_b_sptpd'));
                $njop_bangunan_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_bangunan_b_sptpd'));
                $njop_pbb_sptpd      = $this->input->post('txt_njop_pbb_h_sptpd');
                $text_no_sertifikat  = $this->input->post('txt_no_sertifikat_op');

                $text_lokasi_op      = $this->input->post('text_lokasi_op');
                $text_thn_pajak_sppt = $this->input->post('text_thn_pajak_sppt');

                $nilai_pasar       = str_replace('.', '', $this->input->post('txt_nilai_pasar_sptpd'));
                $jenis_perolehan   = $this->input->post('txt_jns_perolehan_sptpd');
                $npop              = str_replace('.', '', $this->input->post('txt_npop_sptpd'));
                $npoptkp           = str_replace('.', '', $this->input->post('txt_npoptkp_sptpd'));
                $dasar_jml_setoran = $this->input->post('txt_dasar_jml_setoran_sptpd');
                $bea_terhutang     = $this->input->post('txt_bea_perolehan_sptpd');
                $bea_bayar         = $this->input->post('txt_bea_bayar_sptpd');

                // untuk inputan APHB
                // $inp_aphb1 = @$this->input->post('inp_aphb1');
                // $inp_aphb2 = @$this->input->post('inp_aphb2');
                // $inp_aphb3 = $this->input->post('inp_aphb3');
                $tanah_inp_aphb1 = @$this->input->post('tanah_inp_aphb1');
                $tanah_inp_aphb2 = @$this->input->post('tanah_inp_aphb2');
                $tanah_inp_aphb3 = @$this->input->post('tanah_inp_aphb3');

                $bangunan_inp_aphb1 = @$this->input->post('bangunan_inp_aphb1');
                $bangunan_inp_aphb2 = @$this->input->post('bangunan_inp_aphb2');
                $bangunan_inp_aphb3 = @$this->input->post('bangunan_inp_aphb3');

                $tanah_b_inp_aphb1 = @$this->input->post('tanah_b_inp_aphb1');
                $tanah_b_inp_aphb2 = @$this->input->post('tanah_b_inp_aphb2');
                $tanah_b_inp_aphb3 = @$this->input->post('tanah_b_inp_aphb3');

                $bangunan_b_inp_aphb1 = @$this->input->post('bangunan_b_inp_aphb1');
                $bangunan_b_inp_aphb2 = @$this->input->post('bangunan_b_inp_aphb2');
                $bangunan_b_inp_aphb3 = @$this->input->post('bangunan_b_inp_aphb3');
                // end untuk inputan APHB

                $nomor_jml_setoran  = '';
                $tgl_jml_setoran    = '';
                $custom_jml_setoran = '';
                if ($dasar_jml_setoran == 'PWP') {
                    $nomor_jml_setoran = '';
                    $tgl_jml_setoran   = '';
                } elseif ($dasar_jml_setoran == 'STB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_stb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_stb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKBT') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkbt_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkbt_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                }

                $hitung_sendiri_jml_setoran = $this->input->post('txt_hitung_sendiri_sptpd');
                $jml_setor                  = $this->input->post('txt_jml_setor_sptpd');
                //$no_dokumen = $this->input->post('txt_no_dokumen_sptpd');
                $autonum     = '0001';
                $cur_autonum = '';
                $get_autonum = $this->mod_sptpd->get_last_autonum2();
                foreach ($get_autonum as $getnum) {
                    $cur_autonum = $getnum->nodok;
                }
                if ($cur_autonum != '') {
                    // $autonum = substr($cur_autonum, 11, 4);
                    // $autonum = (int) $autonum;
                    // $autonum += $autonum;
                    $autonum = str_pad($cur_autonum, 4, '0', STR_PAD_LEFT);
                }
                $no_dokumen = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_prefix_sptpd');
                // echo $no_dokumen;exit;
                $nop_pbb_baru = $this->input->post('txt_nop_pbb_baru_sptpd');
                $saved_nop    = $nop;
                // $kode_validasi = $this->antclass->add_nop_separator($nop).'-'.date('Ymd').'-'.$jml_setor.'-'.$unique_code;
                $kode_validasi = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_jns_perolehan_sptpd');

                $picture = '';

                if ($_FILES['txt_picture_sptpd']['name'] != '') {
                    $picture = str_replace(' ', '_', $_FILES['txt_picture_sptpd']['name']);
                }

                // Jumlah setor lebih atau sama dari Bea Perolehan Yang Terutang
                if ($bea_bayar <= $jml_setor or $dasar_jml_setoran == 'SKBKB' or $dasar_jml_setoran == "SKBKBT") {
                    $check_luas_skip = false;
                    if ($ret = $this->mod_sppt->check_sppt($this->input->post('txt_id_nop_sptpd'))) {
                        $data_nik     = $this->mod_nik->get_nik($nik);
                        $token        = $this->antclass->generate_token();
                        $new_nop      = '';
                        $arr_nop      = explode('.', $this->input->post('txt_id_nop_sptpd'));
                        $kd_propinsi  = $arr_nop[0];
                        $kd_dati2     = $arr_nop[1];
                        $kd_kecamatan = $arr_nop[2];
                        $kd_kelurahan = $arr_nop[3];
                        $kd_blok      = $arr_nop[4];
                        $no_urut      = str_pad((int) $ret['urut_skr'] + 1, 4, "0", STR_PAD_LEFT);
                        $kd_jns_op    = $arr_nop[6];
                        $new_nop      = $kd_propinsi . '.' . $kd_dati2 . '.' . $kd_kecamatan . '.' . $kd_kelurahan . '.' . $kd_blok . '.' . $no_urut . '.' . $kd_jns_op;
                        $thn_pajak    = date('Y');
                        $rwrt         = explode('/', $data_nik->rtrw);
                        $rw           = trim($rwrt[0]);
                        $rt           = trim($rwrt[1]);
                        $kec          = $this->mod_kecamatan->get_kecamatan($data_nik->kd_kecamatan);

                        $kel       = $this->mod_kelurahan->get_kelurahan($data_nik->kd_kelurahan);
                        $dt2       = $this->mod_dati2->get_dati2($data_nik->kotakab);
                        $nops      = $this->mod_nop->get_nop($nop_compile);
                        $tgl_input = date('Y-m-d H:i:s');

                        // Cek luas bumi atau bangunan sama
                        if ($ret['luas_bumi'] < $luas_tanah_sptpd or $ret['luas_bng'] < $luas_bangunan_sptpd) {
                            $check_luas_skip = true;
                        } else {
                            $pbb_njop_dasar     = $nops->njop_pbb_op;
                            $pbb_njop_hitung    = $nops->njop_pbb_op - $this->config->item('conf_npoptkp_pbb');
                            $pbb_njkp           = ceil(0.2 * $pbb_njop_hitung);
                            $pbb_hutang_pbb     = ceil(0.005 * $pbb_njkp);
                            $njop_bumi          = ceil($nops->luas_tanah_op * $nops->njop_tanah_op);
                            $njop_bumi_sbgn     = ceil($luas_tanah_sptpd * $nops->njop_tanah_op);
                            $njop_bangunan      = ceil($nops->luas_bangunan_op * $nops->njop_bangunan_op);
                            $njop_bangunan_sbgn = ceil($luas_bangunan_sptpd * $nops->njop_bangunan_op);

                            $pbb_hutang_pbb_sbgn                                = $njop_bumi_sbgn + $njop_bangunan_sbgn;
                            $pbb_hutang_pbb_sbgn                                = $pbb_hutang_pbb_sbgn - $this->config->item('conf_npoptkp_pbb');
                            $pbb_hutang_pbb_sbgn                                = ceil(0.2 * $pbb_hutang_pbb_sbgn);
                            $pbb_hutang_pbb_sbgn                                = ceil(0.005 * $pbb_hutang_pbb_sbgn);

                            if ($pbb_hutang_pbb_sbgn < 0) {
                                $pbb_hutang_pbb_sbgn = 0;
                            }

                            if ($ret['luas_bumi'] > $luas_tanah_sptpd or $ret['luas_bng'] > $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $new_luas_tanah    = $ret['luas_bumi'];
                                    $new_luas_bangunan = $ret['luas_bng'];
                                    $new_njop_bumi     = $ret['njop_bumi'];
                                    $new_njop_bng      = $ret['njop_bng'];
                                    if ($ret['luas_bumi'] > $luas_tanah_sptpd) {
                                        $new_luas_tanah = $ret['luas_bumi'] - $luas_tanah_sptpd;
                                        $new_njop_bumi  = $new_luas_tanah * $nops->njop_tanah_op;
                                        if ($ret['luas_bng'] == $luas_bangunan_sptpd) {
                                            $new_luas_bangunan = 0;
                                            $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                        }
                                    }

                                    if ($ret['luas_bng'] > $luas_bangunan_sptpd) {
                                        $new_luas_bangunan = $ret['luas_bng'] - $luas_bangunan_sptpd;
                                        $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                    }

                                    $new_pbb_bayar = $new_njop_bumi + $new_njop_bng;
                                    $new_pbb_bayar = $new_pbb_bayar - $this->config->item('conf_npoptkp_pbb');
                                    $new_pbb_bayar = ceil(0.2 * $new_pbb_bayar);
                                    $new_pbb_bayar = ceil(0.005 * $new_pbb_bayar);
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_sppt->edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $arr_nop[5], $kd_jns_op, $thn_pajak, $ret['nama'], $new_luas_tanah, $new_luas_bangunan, '', '', $new_njop_bumi, $new_njop_bng, $new_pbb_bayar);

                                    $new_nop_pbb_bayar = $new_luas_tanah * $nops->njop_tanah_op;
                                    $new_nop_pbb_bayar += $new_luas_bangunan * $nops->njop_bangunan_op;
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_nop->edit_nop($nop_compile, $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $new_luas_tanah, $new_luas_bangunan, $nops->njop_tanah_op, $nops->njop_bangunan_op, $new_nop_pbb_bayar, '', '', $nops->no_sertipikat_op);

                                    $saved_nop    = str_replace('.', '', $new_nop);
                                    $nop_njop_pbb = $luas_tanah_sptpd * $nops->njop_tanah_op;
                                    $nop_njop_pbb += $luas_bangunan_sptpd * $nops->njop_bangunan_op;
                                    // Buat NOP Baru
                                    $this->mod_nop->add_nop(str_replace('.', '', $new_nop), $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $luas_tanah_sptpd, $luas_bangunan_sptpd, $nops->njop_tanah_op, $nops->njop_bangunan_op, $nop_njop_pbb, '', '', '', '');
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $no_urut,
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $luas_tanah_sptpd,
                                        $luas_bangunan_sptpd,
                                        $njop_bumi_sbgn,
                                        $njop_bangunan_sbgn,
                                        $pbb_hutang_pbb_sbgn,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                    $this->mod_nop_log->add_nop_log(str_replace('.', '', $nop), str_replace('.', '', $new_nop), date('Y-m-d H:i:s'));
                                } else {
                                    $check_luas_skip = true;
                                    $data['info']    = err_msg('Identitas pemilik baru sama dengan pemilik lama.');
                                }
                            } elseif ($ret['luas_bumi'] == $luas_tanah_sptpd or $ret['luas_bng'] == $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $saved_nop = $nop;
                                    $new_nop   = '';
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $arr_nop[5],
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $nops->luas_tanah_op,
                                        $nops->luas_bangunan_op,
                                        $njop_bumi,
                                        $njop_bangunan,
                                        $pbb_hutang_pbb,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                }
                            }
                        }
                    }
                    if (!$check_luas_skip) {
                        //  PROSES INPUT SPTPD

                        // $info = $this->mod_sptpd->add_sptpd($id_ppat,
                        //     $nik,
                        //     $nop_compile,
                        //     $nilai_pasar,
                        //     $jenis_perolehan,
                        //     $npop,
                        //     $npoptkp,
                        //     $dasar_jml_setoran,
                        //     $nomor_jml_setoran,
                        //     $tgl_jml_setoran,
                        //     $hitung_sendiri_jml_setoran,
                        //     $custom_jml_setoran,
                        //     $jml_setor,
                        //     date('Y-m-d'),
                        //     $no_dokumen,
                        //     $nop_pbb_baru,
                        //     $kode_validasi,
                        //     $this->session->userdata('s_username_bphtb'),
                        //     $this->session->userdata('s_id_pp_bphtb'),
                        //     $picture,
                        //     $luas_tanah_sptpd,
                        //     $luas_bangunan_sptpd,
                        //     $njop_tanah_sptpd,
                        //     $njop_bangunan_sptpd,
                        //     $njop_pbb_sptpd,
                        //     $text_no_sertifikat,
                        //     $text_lokasi_op,
                        //     $text_thn_pajak_sppt,
                        //     $inp_aphb1,
                        //     $inp_aphb2,
                        //     $inp_aphb3
                        // );
                        $info = $this->mod_sptpd->add_sptpd(
                            $id_ppat,
                            $nik,
                            $wajibpajak,
                            $nop_compile,
                            $nop_alamat,
                            $nilai_pasar,
                            $jenis_perolehan,
                            $npop,
                            $npoptkp,
                            $dasar_jml_setoran,
                            $nomor_jml_setoran,
                            $tgl_jml_setoran,
                            $hitung_sendiri_jml_setoran,
                            $custom_jml_setoran,
                            $jml_setor,
                            date('Y-m-d'),
                            $no_dokumen,
                            $nop_pbb_baru,
                            $kode_validasi,
                            $this->session->userdata('s_username_bphtb'),
                            $this->session->userdata('s_id_pp_bphtb'),
                            $picture,
                            $luas_tanah_sptpd,
                            $luas_bangunan_sptpd,
                            $luas_tanah_b_sptpd,
                            $luas_bangunan_b_sptpd,
                            $njop_tanah_sptpd,
                            $njop_bangunan_sptpd,
                            $njop_tanah_b_sptpd,
                            $njop_bangunan_b_sptpd,
                            $njop_pbb_sptpd,
                            $text_no_sertifikat,
                            $text_lokasi_op,
                            $text_thn_pajak_sppt,
                            $tanah_inp_aphb1,
                            $tanah_inp_aphb2,
                            $tanah_inp_aphb3,
                            $bangunan_inp_aphb1,
                            $bangunan_inp_aphb2,
                            $bangunan_inp_aphb3,
                            $tanah_b_inp_aphb1,
                            $tanah_b_inp_aphb2,
                            $tanah_b_inp_aphb3,
                            $bangunan_b_inp_aphb1,
                            $bangunan_b_inp_aphb2,
                            $bangunan_b_inp_aphb3
                        );
                    }
                    if (@$info) {
                        $data['info'] = succ_msg('Input SPTPD Berhasil.');

                        // CEK INPUT LAMPIRAN

                        $paramFormulir = array();

                        $paramFormulir['no_sspd']             = $no_dokumen;
                        $paramFormulir['no_formulir']         = date('Ymdhis');
                        $paramFormulir['tanggal_no_sspd']     = date('Y-m-d');
                        $paramFormulir['tanggal_no_formulir'] = date('Y-m-d');

                        $no_dokumen_file = str_replace('.', '', $no_dokumen);

                        if ($picture != '') {
                            $x = $picture;
                            $y = explode('.', $x);
                            $z = end($y);

                            $picture = str_replace('.' . $z, '', $x);

                            $file = $this->uploadFile('txt_picture_sptpd', $picture, $no_dokumen_file);

                            // $paramFormulir['gambar_op'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', $no_dokumen_file . '_lampiran_sspd_1', $no_dokumen_file);

                            $paramFormulir['lampiran_sspd'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', $no_dokumen_file . '_lampiran_sppt', $no_dokumen_file);

                            $paramFormulir['lampiran_sppt'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', $no_dokumen_file . '_lampiran_fotocopi_identitas', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopi_identitas'] = $file;
                        }

                        if ($this->input->post('lampiran_surat_kuasa_wp') != '') {

                            $paramFormulir['lampiran_nama_kuasa_wp']   = $this->input->post('lampiran_nama_kuasa_wp');
                            $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', $no_dokumen_file . '_lampiran_fotocopy_identitas_kwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', $no_dokumen_file . '_lampiran_fotocopy_kartu_npwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', $no_dokumen_file . '_lampiran_fotocopy_akta_jb', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', $no_dokumen_file . '_lampiran_sertifikat_kepemilikan_tanah', $no_dokumen_file);

                            $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_fotocopy_keterangan_waris',$_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', $no_dokumen_file . '_lampiran_fotocopy_keterangan_waris', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_surat_pernyataan']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file . '_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_surat_pernyataan'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_identitas_lainya_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_identitas_lainya',$_FILES['txt_picture_lampiran_identitas_lainya_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_identitas_lainya_file', $no_dokumen_file . '_lampiran_identitas_lainya', $no_dokumen_file);

                            $paramFormulir['lampiran_identitas_lainya'] = $file;
                        }

                        // $paramFormulir['lampiran_identitas_lainya_val'] = $param['lampiran_identitas_lainya_val'];

                        // END OF CEK INPUT FORMULIR

                        $this->db->insert('tbl_formulir_penelitian', $paramFormulir);

                        // if (!empty($picture)) {
                        //     if (!read_file(base_url() . $this->config->item('img_op_path') . $picture)) {
                        //         if (!$this->antclass->go_upload('txt_picture_sptpd', $this->config->item('img_op_path'), 'jpg|gif|png|pdf|doc|docx')) {
                        //             $data['info'] .= err_msg('Upload gambar objek pajak gagal!');
                        //         }
                        //     } else {
                        //         $data['info'] .= err_msg('Upload gambar objek pajak gagal! Gambar objek pajak dengan nama sama sudah ada.');
                        //     }
                        // }

                        if (!empty($new_nop)) {
                            $data['info'] .= '<div class="new_nop">NOP Baru: <b>' . $new_nop . '</b></div>';
                        }
                        $data['info'] .= '';
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
                    } else {
                        $data['info'] .= err_msg('Input SPTPD Gagal.');
                    }
                } else {
                    $data['info'] = err_msg('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
                }
            }
        }

        $data['propinsis']       = $this->mod_propinsi->get_propinsi();
        // $data['dati2s']          = $this->mod_dati2->get_dati2();
        // $data['kecamatans']      = $this->mod_kecamatan->get_kecamatan();
        // $data['kelurahans']      = $this->mod_kelurahan->get_kelurahan();
        $data['jenis_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['rekening']        = $this->mod_rekening->get_rekening(1);
        $data['prefix']          = $this->mod_prefix->get_prefix();
        $data['niks']            = $this->mod_nik->get_nik();
        // $data['nops'] = $this->mod_nop->get_nop();
        $data['cek_transaksi_prev'] = '';
        $data['c_loc']              = $this->c_loc;

        $data['submitvalue'] = 'Simpan';
        $data['rec_id']      = '';
        $this->antclass->skin('v_sptpdform', $data);
    }

    public function add_by_dispenda()
    {
        $array = array(
            // nik
            's_nik_nik'                          => $this->input->post('txt_id_nik_sptpd'),
            's_nama_nik'                         => $this->input->post('nama_nik_name'),
            's_alamat_nik'                       => $this->input->post('alamat_nik_name'),
            's_propinsi_nik'                     => $this->input->post('propinsi_nik_name'),
            's_kd_dati2_nik'                     => $this->input->post('kotakab_nik_name'),
            's_kd_kecamatan_nik'                 => $this->input->post('kecamatan_nik_name'),
            's_kd_kelurahan_nik'                 => $this->input->post('kelurahan_nik_name'),
            's_rtrw_nik'                         => $this->input->post('rtrw_nik_name'),
            's_kodepos_nik'                      => $this->input->post('kodepos_nik_name'),

            // nop
            's_txt_id_nop_sptpd'                 => $this->input->post('txt_id_nop_sptpd'),

            // lampiran
            's_txt_picture_lampiran_sspd_1_file' => $this->input->post('txt_picture_lampiran_sspd_1_file'),
        );

        $this->session->set_userdata($array);

        $param = $_POST;
        // echo "<pre>";print_r($param);exit();

        if ($this->input->post('submit')) {
            $data['info'] = '';
            $this->load->library('form_validation');
            $ident = $this->input->post('ident');
            //hilangi nama_ppat_id
            //jilangi txt_id_ppat_sptpd
            //$this->form_validation->set_rules('txt_id_ppat_sptpd', 'ID PPAT', 'required|xss_clean');
            $this->form_validation->set_rules('txt_id_nik_sptpd', 'NIK', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_id_nop_sptpd', 'NOP', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_nilai_pasar_sptpd', 'Nilai Pasar', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_npop_sptpd', 'NPOP', 'required|trim');
            $this->form_validation->set_rules('txt_jml_setor_sptpd', 'Jumlah yang disetor', 'required|numeric|trim');
            $this->form_validation->set_rules('txt_jns_perolehan_sptpd', 'Jenis Perolehan', 'trim|required');
            $this->form_validation->set_rules('nama_petugas_lapangan', 'Nama Petugas Lapangan', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_no_sertifikat_op', 'No Sertifikat', 'required|xss_clean|trim');
            $this->form_validation->set_rules('id_ppat', 'PPAT', 'required|xss_clean|trim');
            if ($ident != '') {
                $this->form_validation->set_rules('nama_nik_name', 'Nama', 'required|trim');
                $this->form_validation->set_rules('alamat_nik_name', 'Alamat', 'required|trim');
                $this->form_validation->set_rules('propinsi_nik_name', 'Propinsi', 'required|trim');
                $this->form_validation->set_rules('kotakab_nik_name', 'Kabupaten / Kota', 'required|trim');
                $this->form_validation->set_rules('kecamatan_nik_name', 'Kecamatan', 'required|trim');
                $this->form_validation->set_rules('kelurahan_nik_name', 'Kelurahan', 'required|trim');
                $this->form_validation->set_rules('rtrw_nik_name', 'RT / RW', 'trim');
                $this->form_validation->set_rules('kodepos_nik_name', 'Kode Pos', 'trim');
            }
            if ($this->form_validation->run() == false) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $nik_nik          = $this->input->post('txt_id_nik_sptpd');
                $nama_nik         = $this->input->post('nama_nik_name');
                $alamat_nik       = $this->input->post('alamat_nik_name');
                $propinsi_nik     = $this->input->post('propinsi_nik_name');
                $kd_dati2_nik     = $this->input->post('kotakab_nik_name');
                $kd_kecamatan_nik = $this->input->post('kecamatan_nik_name');
                $kd_kelurahan_nik = $this->input->post('kelurahan_nik_name');
                $rtrw_nik         = $this->input->post('rtrw_nik_name');
                $kodepos_nik      = $this->input->post('kodepos_nik_name');

                if ($ident != '') {
                    $hitung = $this->mod_nik->ceknik($nik_nik);
                    if (!empty($hitung)) {
                        $data['info'] = err_msg('NIK Sudah Ada.');
                    } else {
                        $info = $this->mod_nik->add_nik(
                            $nik_nik,
                            $nama_nik,
                            $alamat_nik,
                            $propinsi_nik,
                            $kd_dati2_nik,
                            $kd_kecamatan_nik,
                            $kd_kelurahan_nik,
                            $rtrw_nik,
                            $kodepos_nik
                        );
                    }
                }

                // $id_ppat = $this->antclass->remove_separator($this->input->post('txt_id_ppat_sptpd'));

                $unique_code           = $this->antclass->get_unique_code(5);
                // $id_ppat            = $this->session->userdata('s_id_ppat');
                $id_ppat               = $this->input->post('id_ppat');
                $nik                   = $this->input->post('txt_id_nik_sptpd');
                $nomor                 = $this->global->nomor('sspd');
                $nomor_idbilling       = $this->global->nomor('idbilling');
                $nama_petugas_lapangan = $this->input->post('nama_petugas_lapangan');

                $nop = $this->antclass->remove_separator($this->input->post('txt_id_nop_sptpd'));
                // pemecahan nop
                $kd_propinsi  = substr($nop, 0, 2);
                $kd_kabupaten = substr($nop, 2, 2);
                $kd_kecamatan = substr($nop, 4, 3);
                $kd_kelurahan = substr($nop, 7, 3);
                $kd_blok      = substr($nop, 10, 3);
                $no_urut      = substr($nop, 13, 4);
                $kd_jns_op    = substr($nop, 17, 1);
                $nop_compile  = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

                //str replace alamat nop
                $nop_alamat_filter   = @$this->input->post('alamat_nop_id');
                $nop_alamat          = str_replace("'", "`", $nop_alamat_filter);

                //inputan nop
                $nopsave_lokasi           = $this->input->post('nopsave_letak_tanah');
                $nopsave_kd_dati2_nop     = $kd_kabupaten;
                $nopsave_kd_kecamatan_nop = $kd_kecamatan;
                $nopsave_kd_kelurahan_nop = $kd_kelurahan;
                $nopsave_rtrw             = $this->input->post('nopsave_rtrw');
                $nopsave_luas_tanah       = $this->input->post('nopsave_luas_tanah');
                $nopsave_njop_tanah       = $this->input->post('nopsave_njop_tanah');
                $nopsave_luas_bangunan    = $this->input->post('nopsave_luas_bangunan');
                $nopsave_njop_bangunan    = $this->input->post('nopsave_njop_bangunan');
                $nopsave_njop_pbb         = $this->input->post('nopsave_njop');
                $nopsave_kd_propinsi_op   = $kd_propinsi;
                $no_pelayanan             = $nomor;
                $nopsave_no_sertipikat    = $this->input->post('nopsave_no_serf');
                $nopsave_thn_pajak_sppt   = $this->input->post('nopsave_thnpjk');
                $nopsave_ident            = $this->input->post('status_pencarian_nop');

                $nopsave_propinsi            = $this->input->post('nopsave_propinsi');
                $nopsave_kabupaten           = $this->input->post('nopsave_kabupaten');
                $nopsave_kecamatan           = $this->input->post('nopsave_kecamatan');
                $nopsave_kelurahan           = $this->input->post('nopsave_kelurahan');
                $nopsave_ref_tanah           = $this->input->post('ref_tanah');
                $nopsave_ref_bangunan        = $this->input->post('ref_bangunan');
                $param_nop['nama_penjual']   = $this->input->post('nama_penjual');
                $param_nop['alamat_penjual'] = $this->input->post('alamat_penjual');


                //add nop
                if ($nopsave_ident == 'dari sismiop') {
                    $this->mod_nop->add_nop(
                        $nop_compile,
                        $nopsave_lokasi,
                        $nopsave_kd_kelurahan_nop,
                        $nopsave_rtrw,
                        $nopsave_kd_kecamatan_nop,
                        $nopsave_kd_dati2_nop,
                        $nopsave_luas_tanah,
                        $nopsave_luas_bangunan,
                        $nopsave_njop_tanah,
                        $nopsave_njop_bangunan,
                        $nopsave_njop_pbb,
                        '',
                        '',
                        $nopsave_no_sertipikat,
                        $nopsave_kd_propinsi_op,
                        $nopsave_thn_pajak_sppt,
                        $nopsave_ref_tanah,
                        $nopsave_ref_bangunan,
                        $param_nop
                    );

                    //input propinsi
                    $check_prop = $this->mod_propinsi->get_propinsi($kd_propinsi);
                    if (count($check_prop) == 0) {
                        $this->mod_propinsi->add_propinsi($kd_propinsi, $nopsave_propinsi);
                    }
                    //input kabupaten
                    $check_kab = $this->mod_dati2->get_dati2($kd_kabupaten, '', $kd_propinsi);
                    if (count($check_kab) == 0) {
                        $this->mod_dati2->add_dati2($kd_propinsi, $kd_kabupaten, $nopsave_kabupaten);
                    }
                    //input kecamatan
                    $check_kec = $this->mod_kecamatan->get_kecamatan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan);

                    if (count($check_kec) == 0) {
                        $this->mod_kecamatan->add_kecamatan($kd_kecamatan, $nopsave_kecamatan, $kd_propinsi, $kd_kabupaten);
                    }
                    //input kelurahan
                    $check_kel = $this->mod_kelurahan->get_kelurahan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan);

                    if (count($check_kel) == 0) {
                        $this->mod_kelurahan->add_kelurahan($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $nopsave_kelurahan);
                    }
                }

                $luas_tanah_sptpd    = $this->input->post('txt_luas_tanah_sptpd');
                $luas_bangunan_sptpd = $this->input->post('txt_luas_bangunan_sptpd');
                $luas_tanah_b_sptpd  = $this->input->post('txt_luas_tanah_b_sptpd');
                $luas_bangunan_b_sptpd  = $this->input->post('txt_luas_bangunan_b_sptpd');
                $njop_tanah_sptpd    = str_replace('.', '', $this->input->post('txt_njop_tanah_sptpd'));
                $njop_bangunan_sptpd = str_replace('.', '', $this->input->post('txt_njop_bangunan_sptpd'));
                $njop_tanah_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_tanah_b_sptpd'));
                $njop_bangunan_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_bangunan_b_sptpd'));
                $njop_pbb_sptpd      = $this->input->post('txt_njop_pbb_h_sptpd');
                $text_no_sertifikat  = $this->input->post('txt_no_sertifikat_op');

                $text_lokasi_op      = $this->input->post('text_lokasi_op');
                $text_thn_pajak_sppt = $this->input->post('text_thn_pajak_sppt');

                $nilai_pasar       = str_replace('.', '', $this->input->post('txt_nilai_pasar_sptpd'));
                $jenis_perolehan   = $this->input->post('txt_jns_perolehan_sptpd');
                $npop              = str_replace('.', '', $this->input->post('txt_npop_sptpd'));
                $npoptkp           = str_replace('.', '', $this->input->post('txt_npoptkp_sptpd'));
                $dasar_jml_setoran = $this->input->post('txt_dasar_jml_setoran_sptpd');
                $bea_terhutang     = $this->input->post('txt_bea_perolehan_sptpd');
                $bea_bayar         = $this->input->post('txt_bea_bayar_sptpd');

                // untuk inputan APHB
                // $inp_aphb1 = @$this->input->post('inp_aphb1');
                // $inp_aphb2 = @$this->input->post('inp_aphb2');
                // $inp_aphb3 = $this->input->post('inp_aphb3');
                $tanah_inp_aphb1 = @$this->input->post('tanah_inp_aphb1');
                $tanah_inp_aphb2 = @$this->input->post('tanah_inp_aphb2');
                $tanah_inp_aphb3 = @$this->input->post('tanah_inp_aphb3');

                $bangunan_inp_aphb1 = @$this->input->post('bangunan_inp_aphb1');
                $bangunan_inp_aphb2 = @$this->input->post('bangunan_inp_aphb2');
                $bangunan_inp_aphb3 = @$this->input->post('bangunan_inp_aphb3');

                $tanah_b_inp_aphb1 = @$this->input->post('tanah_b_inp_aphb1');
                $tanah_b_inp_aphb2 = @$this->input->post('tanah_b_inp_aphb2');
                $tanah_b_inp_aphb3 = @$this->input->post('tanah_b_inp_aphb3');

                $bangunan_b_inp_aphb1 = @$this->input->post('bangunan_b_inp_aphb1');
                $bangunan_b_inp_aphb2 = @$this->input->post('bangunan_b_inp_aphb2');
                $bangunan_b_inp_aphb3 = @$this->input->post('bangunan_b_inp_aphb3');
                // end untuk inputan APHB

                $nomor_jml_setoran  = '';
                $tgl_jml_setoran    = '';
                $custom_jml_setoran = '';
                if ($dasar_jml_setoran == 'PWP') {
                    $nomor_jml_setoran = '';
                    $tgl_jml_setoran   = '';
                } elseif ($dasar_jml_setoran == 'STB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_stb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_stb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKBT') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkbt_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkbt_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                }

                $hitung_sendiri_jml_setoran = $this->input->post('txt_hitung_sendiri_sptpd');
                $jml_setor                  = $this->input->post('txt_jml_setor_sptpd');
                //$no_dokumen = $this->input->post('txt_no_dokumen_sptpd');
                $autonum     = $this->global->num('num');
                $cur_autonum = '';
                $get_autonum = $this->mod_sptpd->get_last_autonum2();
                foreach ($get_autonum as $getnum) {
                    $cur_autonum = $getnum->nodok;
                }
                if ($cur_autonum != '') {
                    // $autonum = substr($cur_autonum, 11, 4);
                    // $autonum = (int) $autonum;
                    // $autonum += $autonum;
                    $autonum = str_pad($cur_autonum, 4, '0', STR_PAD_LEFT);
                }
                $no_dokumen = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_prefix_sptpd');
                //echo $no_dokumen;exit;
                $nop_pbb_baru = $this->input->post('txt_nop_pbb_baru_sptpd');
                $saved_nop    = $nop;
                // $kode_validasi = $this->antclass->add_nop_separator($nop).'-'.date('Ymd').'-'.$jml_setor.'-'.$unique_code;
                $kode_validasi = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_jns_perolehan_sptpd');

                $picture = '';

                if ($_FILES['txt_picture_sptpd']['name'] != '') {
                    $picture = str_replace(' ', '_', $_FILES['txt_picture_sptpd']['name']);
                }

                // Jumlah setor lebih atau sama dari Bea Perolehan Yang Terutang
                if ($bea_bayar <= $jml_setor or $dasar_jml_setoran == 'SKBKB' or $dasar_jml_setoran == "SKBKBT") {
                    $check_luas_skip = false;
                    if ($ret = $this->mod_sppt->check_sppt($this->input->post('txt_id_nop_sptpd'))) {
                        $data_nik     = $this->mod_nik->get_nik($nik);
                        $token        = $this->antclass->generate_token();
                        $new_nop      = '';
                        $arr_nop      = explode('.', $this->input->post('txt_id_nop_sptpd'));
                        $kd_propinsi  = $arr_nop[0];
                        $kd_dati2     = $arr_nop[1];
                        $kd_kecamatan = $arr_nop[2];
                        $kd_kelurahan = $arr_nop[3];
                        $kd_blok      = $arr_nop[4];
                        $no_urut      = str_pad((int) $ret['urut_skr'] + 1, 4, "0", STR_PAD_LEFT);
                        $kd_jns_op    = $arr_nop[6];
                        $new_nop      = $kd_propinsi . '.' . $kd_dati2 . '.' . $kd_kecamatan . '.' . $kd_kelurahan . '.' . $kd_blok . '.' . $no_urut . '.' . $kd_jns_op;
                        $thn_pajak    = date('Y');
                        $rwrt         = explode('/', $data_nik->rtrw);
                        $rw           = trim($rwrt[0]);
                        $rt           = trim($rwrt[1]);
                        $kec          = $this->mod_kecamatan->get_kecamatan($data_nik->kd_kecamatan);

                        $kel       = $this->mod_kelurahan->get_kelurahan($data_nik->kd_kelurahan);
                        $dt2       = $this->mod_dati2->get_dati2($data_nik->kotakab);
                        $nops      = $this->mod_nop->get_nop($nop_compile);
                        $tgl_input = date('Y-m-d H:i:s');

                        // Cek luas bumi atau bangunan sama
                        if ($ret['luas_bumi'] < $luas_tanah_sptpd or $ret['luas_bng'] < $luas_bangunan_sptpd) {
                            $check_luas_skip = true;
                        } else {
                            $pbb_njop_dasar     = $nops->njop_pbb_op;
                            $pbb_njop_hitung    = $nops->njop_pbb_op - $this->config->item('conf_npoptkp_pbb');
                            $pbb_njkp           = ceil(0.2 * $pbb_njop_hitung);
                            $pbb_hutang_pbb     = ceil(0.005 * $pbb_njkp);
                            $njop_bumi          = ceil($nops->luas_tanah_op * $nops->njop_tanah_op);
                            $njop_bumi_sbgn     = ceil($luas_tanah_sptpd * $nops->njop_tanah_op);
                            $njop_bangunan      = ceil($nops->luas_bangunan_op * $nops->njop_bangunan_op);
                            $njop_bangunan_sbgn = ceil($luas_bangunan_sptpd * $nops->njop_bangunan_op);

                            $pbb_hutang_pbb_sbgn                                = $njop_bumi_sbgn + $njop_bangunan_sbgn;
                            $pbb_hutang_pbb_sbgn                                = $pbb_hutang_pbb_sbgn - $this->config->item('conf_npoptkp_pbb');
                            $pbb_hutang_pbb_sbgn                                = ceil(0.2 * $pbb_hutang_pbb_sbgn);
                            $pbb_hutang_pbb_sbgn                                = ceil(0.005 * $pbb_hutang_pbb_sbgn);

                            if ($pbb_hutang_pbb_sbgn < 0) {
                                $pbb_hutang_pbb_sbgn = 0;
                            }

                            if ($ret['luas_bumi'] > $luas_tanah_sptpd or $ret['luas_bng'] > $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $new_luas_tanah    = $ret['luas_bumi'];
                                    $new_luas_bangunan = $ret['luas_bng'];
                                    $new_njop_bumi     = $ret['njop_bumi'];
                                    $new_njop_bng      = $ret['njop_bng'];
                                    if ($ret['luas_bumi'] > $luas_tanah_sptpd) {
                                        $new_luas_tanah = $ret['luas_bumi'] - $luas_tanah_sptpd;
                                        $new_njop_bumi  = $new_luas_tanah * $nops->njop_tanah_op;
                                        if ($ret['luas_bng'] == $luas_bangunan_sptpd) {
                                            $new_luas_bangunan = 0;
                                            $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                        }
                                    }

                                    if ($ret['luas_bng'] > $luas_bangunan_sptpd) {
                                        $new_luas_bangunan = $ret['luas_bng'] - $luas_bangunan_sptpd;
                                        $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                    }

                                    $new_pbb_bayar = $new_njop_bumi + $new_njop_bng;
                                    $new_pbb_bayar = $new_pbb_bayar - $this->config->item('conf_npoptkp_pbb');
                                    $new_pbb_bayar = ceil(0.2 * $new_pbb_bayar);
                                    $new_pbb_bayar = ceil(0.005 * $new_pbb_bayar);
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_sppt->edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $arr_nop[5], $kd_jns_op, $thn_pajak, $ret['nama'], $new_luas_tanah, $new_luas_bangunan, '', '', $new_njop_bumi, $new_njop_bng, $new_pbb_bayar);

                                    $new_nop_pbb_bayar = $new_luas_tanah * $nops->njop_tanah_op;
                                    $new_nop_pbb_bayar += $new_luas_bangunan * $nops->njop_bangunan_op;
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_nop->edit_nop($nop_compile, $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $new_luas_tanah, $new_luas_bangunan, $nops->njop_tanah_op, $nops->njop_bangunan_op, $new_nop_pbb_bayar, '', '', $nops->no_sertipikat_op);

                                    $saved_nop    = str_replace('.', '', $new_nop);
                                    $nop_njop_pbb = $luas_tanah_sptpd * $nops->njop_tanah_op;
                                    $nop_njop_pbb += $luas_bangunan_sptpd * $nops->njop_bangunan_op;
                                    // Buat NOP Baru
                                    $this->mod_nop->add_nop(str_replace('.', '', $new_nop), $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $luas_tanah_sptpd, $luas_bangunan_sptpd, $nops->njop_tanah_op, $nops->njop_bangunan_op, $nop_njop_pbb, '', '', '', '');
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $no_urut,
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $luas_tanah_sptpd,
                                        $luas_bangunan_sptpd,
                                        $njop_bumi_sbgn,
                                        $njop_bangunan_sbgn,
                                        $pbb_hutang_pbb_sbgn,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                    $this->mod_nop_log->add_nop_log(str_replace('.', '', $nop), str_replace('.', '', $new_nop), date('Y-m-d H:i:s'));
                                } else {
                                    $check_luas_skip = true;
                                    $data['info']    = err_msg('Identitas pemilik baru sama dengan pemilik lama.');
                                }
                            } elseif ($ret['luas_bumi'] == $luas_tanah_sptpd or $ret['luas_bng'] == $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $saved_nop = $nop;
                                    $new_nop   = '';
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $arr_nop[5],
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $nops->luas_tanah_op,
                                        $nops->luas_bangunan_op,
                                        $njop_bumi,
                                        $njop_bangunan,
                                        $pbb_hutang_pbb,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                }
                            }
                        }
                    }
                    if (!$check_luas_skip) {
                        //  PROSES INPUT SPTPD
                        // echo "<pre>";
                        // print_r ($_POST);exit();
                        // echo "</pre>";

                        $info = $this->mod_sptpd->add_sptpd_dispenda(
                            $id_ppat,
                            $nik,
                            $nop_compile,
                            $nop_alamat,
                            $nilai_pasar,
                            $jenis_perolehan,
                            $npop,
                            $npoptkp,
                            $dasar_jml_setoran,
                            $nomor_jml_setoran,
                            $tgl_jml_setoran,
                            $hitung_sendiri_jml_setoran,
                            $custom_jml_setoran,
                            $jml_setor,
                            date('Y-m-d H:i:s'),
                            $no_dokumen,
                            $nop_pbb_baru,
                            $kode_validasi,
                            $this->session->userdata('s_username_bphtb'),
                            $this->session->userdata('s_id_pp_bphtb'),
                            $picture,
                            $luas_tanah_sptpd,
                            $luas_bangunan_sptpd,
                            $luas_tanah_b_sptpd,
                            $luas_bangunan_b_sptpd,
                            $njop_tanah_sptpd,
                            $njop_bangunan_sptpd,
                            $njop_tanah_b_sptpd,
                            $njop_bangunan_b_sptpd,
                            $njop_pbb_sptpd,
                            $text_no_sertifikat,
                            $text_lokasi_op,
                            $text_thn_pajak_sppt,
                            $tanah_inp_aphb1,
                            $tanah_inp_aphb2,
                            $tanah_inp_aphb3,
                            $bangunan_inp_aphb1,
                            $bangunan_inp_aphb2,
                            $bangunan_inp_aphb3,
                            $tanah_b_inp_aphb1,
                            $tanah_b_inp_aphb2,
                            $tanah_b_inp_aphb3,
                            $bangunan_b_inp_aphb1,
                            $bangunan_b_inp_aphb2,
                            $bangunan_b_inp_aphb3,
                            $nama_nik,
                            $alamat_nik,
                            $text_propinsi,
                            $text_kotakab,
                            $text_kecamatan,
                            $text_kelurahan,
                            $rtrw_nik,
                            $kodepos_nik,
                            $no_pelayanan,
                            $nama_petugas_lapangan
                        );
                    }
                    if (@$info) {
                        $data['info'] = succ_msg('Input SPTPD Berhasil.');

                        // CEK INPUT LAMPIRAN

                        $paramFormulir = array();

                        $paramFormulir['no_sspd']             = $no_dokumen;
                        $paramFormulir['no_formulir']         = date('Ymdhis');
                        $paramFormulir['tanggal_no_sspd']     = date('Y-m-d');
                        $paramFormulir['tanggal_no_formulir'] = date('Y-m-d');

                        $no_dokumen_file = str_replace('.', '', $no_dokumen);

                        if ($picture != '') {
                            $x = $picture;
                            $y = explode('.', $x);
                            $z = end($y);

                            $picture = str_replace('.' . $z, '', $x);

                            $file = $this->uploadFile('txt_picture_sptpd', $picture, $no_dokumen_file);

                            // $paramFormulir['gambar_op'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', $no_dokumen_file . '_lampiran_sspd_1', $no_dokumen_file);

                            $paramFormulir['lampiran_sspd'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', $no_dokumen_file . '_lampiran_sppt', $no_dokumen_file);

                            $paramFormulir['lampiran_sppt'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', $no_dokumen_file . '_lampiran_fotocopi_identitas', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopi_identitas'] = $file;
                        }

                        if ($this->input->post('lampiran_surat_kuasa_wp') != '') {

                            $paramFormulir['lampiran_nama_kuasa_wp']   = $this->input->post('lampiran_nama_kuasa_wp');
                            $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', $no_dokumen_file . '_lampiran_fotocopy_identitas_kwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', $no_dokumen_file . '_lampiran_fotocopy_kartu_npwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', $no_dokumen_file . '_lampiran_fotocopy_akta_jb', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', $no_dokumen_file . '_lampiran_sertifikat_kepemilikan_tanah', $no_dokumen_file);

                            $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_fotocopy_keterangan_waris',$_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', $no_dokumen_file . '_lampiran_fotocopy_keterangan_waris', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_surat_pernyataan']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file . '_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_surat_pernyataan'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_identitas_lainya_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_identitas_lainya',$_FILES['txt_picture_lampiran_identitas_lainya_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_identitas_lainya_file', $no_dokumen_file . '_lampiran_identitas_lainya', $no_dokumen_file);

                            $paramFormulir['lampiran_identitas_lainya'] = $file;
                        }

                        // $paramFormulir['lampiran_identitas_lainya_val'] = $param['lampiran_identitas_lainya_val'];

                        // END OF CEK INPUT FORMULIR

                        $this->db->insert('tbl_formulir_penelitian', $paramFormulir);

                        // if (!empty($picture)) {
                        //     if (!read_file(base_url() . $this->config->item('img_op_path') . $picture)) {
                        //         if (!$this->antclass->go_upload('txt_picture_sptpd', $this->config->item('img_op_path'), 'jpg|gif|png|pdf|doc|docx')) {
                        //             $data['info'] .= err_msg('Upload gambar objek pajak gagal!');
                        //         }
                        //     } else {
                        //         $data['info'] .= err_msg('Upload gambar objek pajak gagal! Gambar objek pajak dengan nama sama sudah ada.');
                        //     }
                        // }

                        if (!empty($new_nop)) {
                            $data['info'] .= '<div class="new_nop">NOP Baru: <b>' . $new_nop . '</b></div>';
                        }
                        $data['info'] .= '';
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
                    } else {
                        $data['info'] .= err_msg('Input SPTPD Gagal.');
                    }
                } else {
                    $data['info'] .= err_msg('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
                }
            }
        }

        $data['propinsis']       = $this->mod_propinsi->get_propinsi();
        $data['ppat']            = $this->mod_sptpd->get_ppat_opt();
        $data['jenis_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['rekening']        = $this->mod_rekening->get_rekening(1);
        $data['prefix']          = $this->mod_prefix->get_prefix();
        $data['niks']            = $this->mod_nik->get_nik();
        $data['cek_transaksi_prev'] = '';
        $data['c_loc']              = $this->c_loc;

        $data['submitvalue'] = 'Simpan';
        $data['rec_id']      = '';
        $this->antclass->skin('v_sptpdform_dispenda', $data);
    }

    public function add_by_wp()
    {
        //----CAPTCHA--------
        //----SC : FAIZAL----
        if (@$_POST['captcha'] == "") {
            $data['cap'] = $this->_create_captcha();
        }

        $array = array(
            // nik
            's_nik_nik'                          => $this->input->post('txt_id_nik_sptpd'),
            's_nama_nik'                         => $this->input->post('nama_nik_name'),
            's_alamat_nik'                       => $this->input->post('alamat_nik_name'),
            's_propinsi_nik'                     => $this->input->post('propinsi_nik_name'),
            's_kd_dati2_nik'                     => $this->input->post('kotakab_nik_name'),
            's_kd_kecamatan_nik'                 => $this->input->post('kecamatan_nik_name'),
            's_kd_kelurahan_nik'                 => $this->input->post('kelurahan_nik_name'),
            's_rtrw_nik'                         => $this->input->post('rtrw_nik_name'),
            's_kodepos_nik'                      => $this->input->post('kodepos_nik_name'),

            // nop
            's_txt_id_nop_sptpd'                 => $this->input->post('txt_id_nop_sptpd'),

            // lampiran
            's_txt_picture_lampiran_sspd_1_file' => $this->input->post('txt_picture_lampiran_sspd_1_file'),
        );


        $this->session->set_userdata($array);

        // $param = $_POST;
        // echo "<pre>";print_r($param);exit();

        if ($this->input->post('submit')) {
            $data['info'] = '';
            $this->load->library('form_validation');
            $ident = $this->input->post('ident');
            //hilangi nama_ppat_id
            //jilangi txt_id_ppat_sptpd
            //$this->form_validation->set_rules('txt_id_ppat_sptpd', 'ID PPAT', 'required|xss_clean');
            $this->form_validation->set_rules('txt_id_nik_sptpd', 'NIK', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_id_nop_sptpd', 'NOP', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_nilai_pasar_sptpd', 'Nilai Pasar', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_npop_sptpd', 'NPOP', 'required|trim');
            $this->form_validation->set_rules('txt_jml_setor_sptpd', 'Jumlah yang disetor', 'required|numeric|trim');
            $this->form_validation->set_rules('txt_jns_perolehan_sptpd', 'Jenis Perolehan', 'trim|required');
            $this->form_validation->set_rules('txt_no_sertifikat_op', 'No Sertifikat', 'required|xss_clean|trim');
            $this->form_validation->set_rules('id_ppat', 'PPAT', 'required|xss_clean|trim');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|xss_clean|trim');
            if ($ident != '') {
                $this->form_validation->set_rules('nama_nik_name', 'Nama', 'required|trim');
                $this->form_validation->set_rules('alamat_nik_name', 'Alamat', 'required|trim');
                $this->form_validation->set_rules('propinsi_nik_name', 'Propinsi', 'required|trim');
                $this->form_validation->set_rules('kotakab_nik_name', 'Kabupaten / Kota', 'required|trim');
                $this->form_validation->set_rules('kecamatan_nik_name', 'Kecamatan', 'required|trim');
                $this->form_validation->set_rules('kelurahan_nik_name', 'Kelurahan', 'required|trim');
                $this->form_validation->set_rules('rtrw_nik_name', 'RT / RW', 'trim');
                $this->form_validation->set_rules('kodepos_nik_name', 'Kode Pos', 'trim');
            }
            if ($this->form_validation->run() == false) {
                $data['info'] .= err_msg(validation_errors());
            } elseif ($this->session->userdata("captchaFormSSPD") != $this->input->post('captcha')) {
                $data['info'] .= err_msg('Captcha Salah!');
            } else {
                $nik_nik          = $this->input->post('txt_id_nik_sptpd');
                $propinsi_nik     = $this->input->post('propinsi_nik_name');
                $kd_dati2_nik     = $this->input->post('kotakab_nik_name');
                $kd_kecamatan_nik = $this->input->post('kecamatan_nik_name');
                $kd_kelurahan_nik = $this->input->post('kelurahan_nik_name');
                $rtrw_nik         = $this->input->post('rtrw_nik_name');
                $nama_nik         = $this->input->post('nama_nik_name');
                $alamat_nik       = $this->input->post('alamat_nik_name');
                $kodepos_nik      = $this->input->post('kodepos_nik_name');

                $text_propinsi    = $this->input->post('inp_propinsi');
                $text_kotakab     = $this->input->post('inp_kotakab');
                $text_kecamatan   = $this->input->post('inp_kecamatan');
                $text_kelurahan   = $this->input->post('inp_kelurahan');

                if ($ident != '') {
                    $hitung = $this->mod_nik->ceknik($nik_nik);
                    if (!empty($hitung)) {
                        $data['info'] .= err_msg('NIK Sudah Ada.');
                    } else {
                        $info = $this->mod_nik->add_nik(
                            $nik_nik,
                            $nama_nik,
                            $alamat_nik,
                            $propinsi_nik,
                            $kd_dati2_nik,
                            $kd_kecamatan_nik,
                            $kd_kelurahan_nik,
                            $rtrw_nik,
                            $kodepos_nik
                        );
                    }
                }

                // $id_ppat = $this->antclass->remove_separator($this->input->post('txt_id_ppat_sptpd'));

                $unique_code  = $this->antclass->get_unique_code(5);
                // $id_ppat   = $this->session->userdata('s_id_ppat');
                $id_ppat      = $this->input->post('id_ppat');
                $nik          = $this->input->post('txt_id_nik_sptpd');
                $wajibpajak   = $this->input->post('wajibpajak') . " " . $this->input->post('wajibpajaktext') . " " . $this->input->post('wajibpajaklainnya');
                $nomor        = $this->global->nomor('sspd');

                $nop = $this->antclass->remove_separator($this->input->post('txt_id_nop_sptpd'));
                // pemecahan nop
                $kd_propinsi  = substr($nop, 0, 2);
                $kd_kabupaten = substr($nop, 2, 2);
                $kd_kecamatan = substr($nop, 4, 3);
                $kd_kelurahan = substr($nop, 7, 3);
                $kd_blok      = substr($nop, 10, 3);
                $no_urut      = substr($nop, 13, 4);
                $kd_jns_op    = substr($nop, 17, 1);
                $nop_compile  = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

                //str replace alamat nop
                $nop_alamat_filter   = @$this->input->post('alamat_nop_id');
                $nop_alamat          = str_replace("'", "`", $nop_alamat_filter);


                //inputan nop
                $nopsave_lokasi           = $this->input->post('nopsave_letak_tanah');
                $nopsave_kd_dati2_nop     = $kd_kabupaten;
                $nopsave_kd_kecamatan_nop = $kd_kecamatan;
                $nopsave_kd_kelurahan_nop = $kd_kelurahan;
                $nopsave_rtrw             = $this->input->post('nopsave_rtrw');
                $nopsave_luas_tanah       = $this->input->post('nopsave_luas_tanah');
                $nopsave_njop_tanah       = $this->input->post('nopsave_njop_tanah');
                $nopsave_luas_bangunan    = $this->input->post('nopsave_luas_bangunan');
                $nopsave_njop_bangunan    = $this->input->post('nopsave_njop_bangunan');
                $nopsave_njop_pbb         = $this->input->post('nopsave_njop');
                $no_pelayanan             = $nomor;
                $nopsave_kd_propinsi_op   = $kd_propinsi;
                $nopsave_no_sertipikat    = $this->input->post('nopsave_no_serf');
                $nopsave_thn_pajak_sppt   = $this->input->post('nopsave_thnpjk');
                $nopsave_ident            = $this->input->post('status_pencarian_nop');

                $nopsave_propinsi            = $this->input->post('nopsave_propinsi');
                $nopsave_kabupaten           = $this->input->post('nopsave_kabupaten');
                $nopsave_kecamatan           = $this->input->post('nopsave_kecamatan');
                $nopsave_kelurahan           = $this->input->post('nopsave_kelurahan');
                $nopsave_ref_tanah           = $this->input->post('ref_tanah');
                $nopsave_ref_bangunan        = $this->input->post('ref_bangunan');
                $param_nop['nama_penjual']   = $this->input->post('nama_penjual');
                $param_nop['alamat_penjual'] = $this->input->post('alamat_penjual');


                //add nop
                if ($nopsave_ident == 'dari sismiop') {
                    $this->mod_nop->add_nop(
                        $nop_compile,
                        $nopsave_lokasi,
                        $nopsave_kd_kelurahan_nop,
                        $nopsave_rtrw,
                        $nopsave_kd_kecamatan_nop,
                        $nopsave_kd_dati2_nop,
                        $nopsave_luas_tanah,
                        $nopsave_luas_bangunan,
                        $nopsave_njop_tanah,
                        $nopsave_njop_bangunan,
                        $nopsave_njop_pbb,
                        '',
                        '',
                        $nopsave_no_sertipikat,
                        $nopsave_kd_propinsi_op,
                        $nopsave_thn_pajak_sppt,
                        $nopsave_ref_tanah,
                        $nopsave_ref_bangunan,
                        $param_nop
                    );

                    //input propinsi
                    $check_prop = $this->mod_propinsi->get_propinsi($kd_propinsi);
                    if (count($check_prop) == 0) {
                        $this->mod_propinsi->add_propinsi($kd_propinsi, $nopsave_propinsi);
                    }
                    //input kabupaten
                    $check_kab = $this->mod_dati2->get_dati2($kd_kabupaten, '', $kd_propinsi);
                    if (count($check_kab) == 0) {
                        $this->mod_dati2->add_dati2($kd_propinsi, $kd_kabupaten, $nopsave_kabupaten);
                    }
                    //input kecamatan
                    $check_kec = $this->mod_kecamatan->get_kecamatan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan);

                    if (count($check_kec) == 0) {
                        $this->mod_kecamatan->add_kecamatan($kd_kecamatan, $nopsave_kecamatan, $kd_propinsi, $kd_kabupaten);
                    }
                    //input kelurahan
                    $check_kel = $this->mod_kelurahan->get_kelurahan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan);

                    if (count($check_kel) == 0) {
                        $this->mod_kelurahan->add_kelurahan($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $nopsave_kelurahan);
                    }
                }

                $luas_tanah_sptpd       = $this->input->post('txt_luas_tanah_sptpd');
                $luas_bangunan_sptpd    = $this->input->post('txt_luas_bangunan_sptpd');
                $luas_tanah_b_sptpd     = $this->input->post('txt_luas_tanah_b_sptpd');
                $luas_bangunan_b_sptpd  = $this->input->post('txt_luas_bangunan_b_sptpd');
                $njop_tanah_sptpd       = str_replace('.', '', $this->input->post('txt_njop_tanah_sptpd'));
                $njop_bangunan_sptpd    = str_replace('.', '', $this->input->post('txt_njop_bangunan_sptpd'));
                $njop_tanah_b_sptpd     = str_replace('.', '', $this->input->post('txt_njop_tanah_b_sptpd'));
                $njop_bangunan_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_bangunan_b_sptpd'));
                $njop_pbb_sptpd         = $this->input->post('txt_njop_pbb_h_sptpd');
                $text_no_sertifikat     = $this->input->post('txt_no_sertifikat_op');

                $text_lokasi_op         = $this->input->post('text_lokasi_op');
                $text_thn_pajak_sppt    = $this->input->post('text_thn_pajak_sppt');

                $nilai_pasar            = str_replace('.', '', $this->input->post('txt_nilai_pasar_sptpd'));
                $jenis_perolehan        = $this->input->post('txt_jns_perolehan_sptpd');
                $jenis_kepemilikan      = $this->input->post('txt_jns_kepemilikan_sptpd');
                $npop                   = str_replace('.', '', $this->input->post('txt_npop_sptpd'));
                $npoptkp                = str_replace('.', '', $this->input->post('txt_npoptkp_sptpd'));
                $dasar_jml_setoran      = $this->input->post('txt_dasar_jml_setoran_sptpd');
                $bea_terhutang          = $this->input->post('txt_bea_perolehan_sptpd');
                $bea_bayar              = $this->input->post('txt_bea_bayar_sptpd');

                // untuk inputan APHB
                // $inp_aphb1 = @$this->input->post('inp_aphb1');
                // $inp_aphb2 = @$this->input->post('inp_aphb2');
                // $inp_aphb3 = $this->input->post('inp_aphb3');
                $tanah_inp_aphb1        = @$this->input->post('tanah_inp_aphb1');
                $tanah_inp_aphb2        = @$this->input->post('tanah_inp_aphb2');
                $tanah_inp_aphb3        = @$this->input->post('tanah_inp_aphb3');

                $bangunan_inp_aphb1     = @$this->input->post('bangunan_inp_aphb1');
                $bangunan_inp_aphb2     = @$this->input->post('bangunan_inp_aphb2');
                $bangunan_inp_aphb3     = @$this->input->post('bangunan_inp_aphb3');

                $tanah_b_inp_aphb1      = @$this->input->post('tanah_b_inp_aphb1');
                $tanah_b_inp_aphb2      = @$this->input->post('tanah_b_inp_aphb2');
                $tanah_b_inp_aphb3      = @$this->input->post('tanah_b_inp_aphb3');

                $bangunan_b_inp_aphb1   = @$this->input->post('bangunan_b_inp_aphb1');
                $bangunan_b_inp_aphb2   = @$this->input->post('bangunan_b_inp_aphb2');
                $bangunan_b_inp_aphb3   = @$this->input->post('bangunan_b_inp_aphb3');
                // end untuk inputan APHB

                $nomor_jml_setoran      = '';
                $tgl_jml_setoran        = '';
                $custom_jml_setoran     = '';
                if ($dasar_jml_setoran == 'PWP') {
                    $nomor_jml_setoran = '';
                    $tgl_jml_setoran   = '';
                } elseif ($dasar_jml_setoran == 'STB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_stb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_stb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKBT') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkbt_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkbt_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                }

                $hitung_sendiri_jml_setoran = $this->input->post('txt_hitung_sendiri_sptpd');
                $jml_setor                  = $this->input->post('txt_jml_setor_sptpd');
                //$no_dokumen               = $this->input->post('txt_no_dokumen_sptpd');
                $autonum                    = $this->global->num('num');
                $cur_autonum                = '';
                $get_autonum                = $this->mod_sptpd->get_last_autonum2();
                foreach ($get_autonum as $getnum) {
                    $cur_autonum = $getnum->nodok;
                }
                if ($cur_autonum != '') {
                    // $autonum = substr($cur_autonum, 11, 4);
                    // $autonum = (int) $autonum;
                    // $autonum += $autonum;
                    $autonum    = str_pad($cur_autonum, 4, '0', STR_PAD_LEFT);
                }
                $no_dokumen         = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_prefix_sptpd');
                //echo $no_dokumen;exit;
                $nop_pbb_baru       = $this->input->post('txt_nop_pbb_baru_sptpd');
                $saved_nop          = $nop;
                // $kode_validasi   = $this->antclass->add_nop_separator($nop).'-'.date('Ymd').'-'.$jml_setor.'-'.$unique_code;
                $kode_validasi      = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_jns_perolehan_sptpd');

                $picture            = '';

                if ($_FILES['txt_picture_sptpd']['name'] != '') {
                    $picture = str_replace(' ', '_', $_FILES['txt_picture_sptpd']['name']);
                }

                // Jumlah setor lebih atau sama dari Bea Perolehan Yang Terutang
                if ($bea_bayar <= $jml_setor or $dasar_jml_setoran == 'SKBKB' or $dasar_jml_setoran == "SKBKBT") {
                    $check_luas_skip = false;
                    $last_id_sptpd = "Ehehehehehehe";
                    if ($ret = $this->mod_sppt->check_sppt($this->input->post('txt_id_nop_sptpd'))) {
                        $data_nik     = $this->mod_nik->get_nik($nik);
                        $token        = $this->antclass->generate_token();
                        $new_nop      = '';
                        $arr_nop      = explode('.', $this->input->post('txt_id_nop_sptpd'));
                        $kd_propinsi  = $arr_nop[0];
                        $kd_dati2     = $arr_nop[1];
                        $kd_kecamatan = $arr_nop[2];
                        $kd_kelurahan = $arr_nop[3];
                        $kd_blok      = $arr_nop[4];
                        $no_urut      = str_pad((int) $ret['urut_skr'] + 1, 4, "0", STR_PAD_LEFT);
                        $kd_jns_op    = $arr_nop[6];
                        $new_nop      = $kd_propinsi . '.' . $kd_dati2 . '.' . $kd_kecamatan . '.' . $kd_kelurahan . '.' . $kd_blok . '.' . $no_urut . '.' . $kd_jns_op;
                        $thn_pajak    = date('Y');
                        $rwrt         = explode('/', $data_nik->rtrw);
                        $rw           = trim($rwrt[0]);
                        $rt           = trim($rwrt[1]);
                        $kec          = $this->mod_kecamatan->get_kecamatan($data_nik->kd_kecamatan);

                        $kel        = $this->mod_kelurahan->get_kelurahan($data_nik->kd_kelurahan);
                        $dt2        = $this->mod_dati2->get_dati2($data_nik->kotakab);
                        $nops       = $this->mod_nop->get_nop($nop_compile);
                        $tgl_input  = date('Y-m-d H:i:s');

                        // Cek luas bumi atau bangunan sama
                        if ($ret['luas_bumi'] < $luas_tanah_sptpd or $ret['luas_bng'] < $luas_bangunan_sptpd) {
                            $check_luas_skip = true;
                        } else {
                            $pbb_njop_dasar     = $nops->njop_pbb_op;
                            $pbb_njop_hitung    = $nops->njop_pbb_op - $this->config->item('conf_npoptkp_pbb');
                            $pbb_njkp           = ceil(0.2 * $pbb_njop_hitung);
                            $pbb_hutang_pbb     = ceil(0.005 * $pbb_njkp);
                            $njop_bumi          = ceil($nops->luas_tanah_op * $nops->njop_tanah_op);
                            $njop_bumi_sbgn     = ceil($luas_tanah_sptpd * $nops->njop_tanah_op);
                            $njop_bangunan      = ceil($nops->luas_bangunan_op * $nops->njop_bangunan_op);
                            $njop_bangunan_sbgn = ceil($luas_bangunan_sptpd * $nops->njop_bangunan_op);

                            $pbb_hutang_pbb_sbgn    = $njop_bumi_sbgn + $njop_bangunan_sbgn;
                            $pbb_hutang_pbb_sbgn    = $pbb_hutang_pbb_sbgn - $this->config->item('conf_npoptkp_pbb');
                            $pbb_hutang_pbb_sbgn    = ceil(0.2 * $pbb_hutang_pbb_sbgn);
                            $pbb_hutang_pbb_sbgn    = ceil(0.005 * $pbb_hutang_pbb_sbgn);

                            if ($pbb_hutang_pbb_sbgn < 0) {
                                $pbb_hutang_pbb_sbgn = 0;
                            }

                            if ($ret['luas_bumi'] > $luas_tanah_sptpd or $ret['luas_bng'] > $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $new_luas_tanah    = $ret['luas_bumi'];
                                    $new_luas_bangunan = $ret['luas_bng'];
                                    $new_njop_bumi     = $ret['njop_bumi'];
                                    $new_njop_bng      = $ret['njop_bng'];
                                    if ($ret['luas_bumi'] > $luas_tanah_sptpd) {
                                        $new_luas_tanah = $ret['luas_bumi'] - $luas_tanah_sptpd;
                                        $new_njop_bumi  = $new_luas_tanah * $nops->njop_tanah_op;
                                        if ($ret['luas_bng'] == $luas_bangunan_sptpd) {
                                            $new_luas_bangunan = 0;
                                            $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                        }
                                    }

                                    if ($ret['luas_bng'] > $luas_bangunan_sptpd) {
                                        $new_luas_bangunan = $ret['luas_bng'] - $luas_bangunan_sptpd;
                                        $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                    }

                                    $new_pbb_bayar = $new_njop_bumi + $new_njop_bng;
                                    $new_pbb_bayar = $new_pbb_bayar - $this->config->item('conf_npoptkp_pbb');
                                    $new_pbb_bayar = ceil(0.2 * $new_pbb_bayar);
                                    $new_pbb_bayar = ceil(0.005 * $new_pbb_bayar);
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_sppt->edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $arr_nop[5], $kd_jns_op, $thn_pajak, $ret['nama'], $new_luas_tanah, $new_luas_bangunan, '', '', $new_njop_bumi, $new_njop_bng, $new_pbb_bayar);

                                    $new_nop_pbb_bayar = $new_luas_tanah * $nops->njop_tanah_op;
                                    $new_nop_pbb_bayar += $new_luas_bangunan * $nops->njop_bangunan_op;
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_nop->edit_nop($nop_compile, $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $new_luas_tanah, $new_luas_bangunan, $nops->njop_tanah_op, $nops->njop_bangunan_op, $new_nop_pbb_bayar, '', '', $nops->no_sertipikat_op);

                                    $saved_nop    = str_replace('.', '', $new_nop);
                                    $nop_njop_pbb = $luas_tanah_sptpd * $nops->njop_tanah_op;
                                    $nop_njop_pbb += $luas_bangunan_sptpd * $nops->njop_bangunan_op;
                                    // Buat NOP Baru
                                    $this->mod_nop->add_nop(str_replace('.', '', $new_nop), $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $luas_tanah_sptpd, $luas_bangunan_sptpd, $nops->njop_tanah_op, $nops->njop_bangunan_op, $nop_njop_pbb, '', '', '', '');
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $no_urut,
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $luas_tanah_sptpd,
                                        $luas_bangunan_sptpd,
                                        $njop_bumi_sbgn,
                                        $njop_bangunan_sbgn,
                                        $pbb_hutang_pbb_sbgn,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                    $this->mod_nop_log->add_nop_log(str_replace('.', '', $nop), str_replace('.', '', $new_nop), date('Y-m-d H:i:s'));
                                } else {
                                    $check_luas_skip = true;
                                    $data['info']    .= err_msg('Identitas pemilik baru sama dengan pemilik lama.');
                                }
                            } elseif ($ret['luas_bumi'] == $luas_tanah_sptpd or $ret['luas_bng'] == $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $saved_nop = $nop;
                                    $new_nop   = '';
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $arr_nop[5],
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $nops->luas_tanah_op,
                                        $nops->luas_bangunan_op,
                                        $njop_bumi,
                                        $njop_bangunan,
                                        $pbb_hutang_pbb,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                }
                            }
                        }
                    }
                    if (!$check_luas_skip) {
                        // PROSES INPUT SPTPD
                        // echo "<pre>";
                        // print_r ($no_pelayanan);exit();
                        // echo "</pre>";
                        // echo "<pre>";
                        // print_r ($_POST);exit();
                        // echo "</pre>";

                        $info = $this->mod_sptpd->add_sptpd(
                            $id_ppat,
                            $nik,
                            $wajibpajak,
                            $nop_compile,
                            $nop_alamat,
                            $nilai_pasar,
                            $jenis_perolehan,
                            $jenis_kepemilikan,
                            $npop,
                            $npoptkp,
                            $dasar_jml_setoran,
                            $nomor_jml_setoran,
                            $tgl_jml_setoran,
                            $hitung_sendiri_jml_setoran,
                            $custom_jml_setoran,
                            $jml_setor,
                            date('Y-m-d H:i:s'),
                            $no_dokumen,
                            $nop_pbb_baru,
                            $kode_validasi,
                            $this->session->userdata('s_username_bphtb'),
                            $this->session->userdata('s_id_pp_bphtb'),
                            $picture,
                            $luas_tanah_sptpd,
                            $luas_bangunan_sptpd,
                            $luas_tanah_b_sptpd,
                            $luas_bangunan_b_sptpd,
                            $njop_tanah_sptpd,
                            $njop_bangunan_sptpd,
                            $njop_tanah_b_sptpd,
                            $njop_bangunan_b_sptpd,
                            $njop_pbb_sptpd,
                            $text_no_sertifikat,
                            $text_lokasi_op,
                            $text_thn_pajak_sppt,
                            $tanah_inp_aphb1,
                            $tanah_inp_aphb2,
                            $tanah_inp_aphb3,
                            $bangunan_inp_aphb1,
                            $bangunan_inp_aphb2,
                            $bangunan_inp_aphb3,
                            $tanah_b_inp_aphb1,
                            $tanah_b_inp_aphb2,
                            $tanah_b_inp_aphb3,
                            $bangunan_b_inp_aphb1,
                            $bangunan_b_inp_aphb2,
                            $bangunan_b_inp_aphb3,
                            $nama_nik,
                            $alamat_nik,
                            $text_propinsi,
                            $text_kotakab,
                            $text_kecamatan,
                            $text_kelurahan,
                            $rtrw_nik,
                            $kodepos_nik,
                            $no_pelayanan
                        );
                        $last_id_sptpd = $info;
                    }
                    if (@$info) {
                        //JIKA JUMLAH BANGUNAN LEBIH DARI 0 MAKA SIMPAN DATA LSPOP
                        $lspopInfo = "";
                        $simpanLSPOP = array();
                        $fiturLSPOP = false;
                        if ($fiturLSPOP) {
                            if ($this->input->post('sel_jml_bangunan') > 0) {
                                $lspopData = array(
                                    "last_id_sptpd" => $last_id_sptpd,
                                    "jml_bangunan"  => $this->input->post('sel_jml_bangunan'),
                                    "lspopData"     => $this->input->post('lspopdata'),
                                );
                                //PROSES SIMPAN LSPOP
                                $simpanLSPOP = $this->mod_lspop->add_lspop($lspopData);
                                if ($simpanLSPOP['status']) {
                                    $lspopInfo = " dan LSPOP Data";
                                }
                            } else {
                                $simpanLSPOP = array("tidak ada field sel_jml_bangunan");
                            }
                        }

                        $data['info'] .= succ_msg('Input SPTPD' . $lspopInfo . ' Berhasil.');

                        $email1 = $this->mod_sptpd->get_ppat($id_ppat)->email;

                        $body1 = 'Anda Telah dipilih notaris oleh Bpk/Ibu/Sdr ' . $nama_nik . ', silahkan cek di menu SSPD untuk aprove atau reject';
                        $kode1 = 'Badan Pelayanan Pajak Daerah';
                        $this->global->email($email1, 'Aprove Akun', 'Aprove Akun', $body1, $kode1);
                        //$this->global->email($_POST['email'], 'Aprove Akun', 'Aprove Akun', $body1);
                        // CEK INPUT LAMPIRAN

                        $paramFormulir = array();

                        $paramFormulir['no_sspd']             = $no_dokumen;
                        $paramFormulir['no_formulir']         = date('Ymdhis');
                        $paramFormulir['tanggal_no_sspd']     = date('Y-m-d');
                        $paramFormulir['tanggal_no_formulir'] = date('Y-m-d');

                        $no_dokumen_file = str_replace('.', '', $no_dokumen);

                        if ($picture != '') {
                            $x = $picture;
                            $y = explode('.', $x);
                            $z = end($y);

                            $picture = str_replace('.' . $z, '', $x);

                            $file = $this->uploadFile('txt_picture_sptpd', $picture, $no_dokumen_file);

                            // $paramFormulir['gambar_op'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_sspd_1') . '_lampiran_sspd_1', $no_dokumen_file);

                            $paramFormulir['lampiran_sspd'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_sppt') . '_lampiran_sppt', $no_dokumen_file);

                            $paramFormulir['lampiran_sppt'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_fotocopi_identitas') . '_lampiran_fotocopi_identitas', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopi_identitas'] = $file;
                        }

                        if ($this->input->post('lampiran_surat_kuasa_wp') != '') {

                            $paramFormulir['lampiran_nama_kuasa_wp']   = $this->input->post('lampiran_nama_kuasa_wp');
                            $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
                            // print_r($paramFormulir['lampiran_nama_kuasa_wp']);
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_fotocopy_identitas_kwp') . '_lampiran_fotocopy_identitas_kwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_fotocopy_kartu_npwp') . '_lampiran_fotocopy_kartu_npwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_fotocopy_akta_jb') . '_lampiran_fotocopy_akta_jb', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_sertifikat_kepemilikan_tanah') . '_lampiran_sertifikat_kepemilikan_tanah', $no_dokumen_file);

                            $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_fotocopy_keterangan_waris',$_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_fotocopy_keterangan_waris') . '_lampiran_fotocopy_keterangan_waris', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_surat_pernyataan']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_surat_pernyataan', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_fotocopy_surat_pernyataan') . '_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_surat_pernyataan'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_identitas_lainya_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_identitas_lainya',$_FILES['txt_picture_lampiran_identitas_lainya_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_identitas_lainya_file', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_identitas_lainya') . '_lampiran_identitas_lainya', $no_dokumen_file);

                            $paramFormulir['lampiran_identitas_lainya'] = $file;
                        }

                        //-------FAIZAL--------//
                        //INPUT LAMPIRAN SPOP/LSPOP//
                        if ($_FILES['txt_picture_spoplspop']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_spoplspop', str_replace("/", "_", $no_pelayanan) . '_' . md5('_lampiran_spoplspop') . '_lampiran_spoplspop', $no_dokumen_file);

                            $paramFormulir['lampiran_spoplspop'] = $file;
                        }
                        //--------------------//

                        // $paramFormulir['lampiran_identitas_lainya_val'] = $param['lampiran_identitas_lainya_val'];

                        // END OF CEK INPUT FORMULIR

                        $this->db->insert('tbl_formulir_penelitian', $paramFormulir);

                        // if (!empty($picture)) {
                        //     if (!read_file(base_url() . $this->config->item('img_op_path') . $picture)) {
                        //         if (!$this->antclass->go_upload('txt_picture_sptpd', $this->config->item('img_op_path'), 'jpg|gif|png|pdf|doc|docx')) {
                        //             $data['info'] .= err_msg('Upload gambar objek pajak gagal!');
                        //         }
                        //     } else {
                        //         $data['info'] .= err_msg('Upload gambar objek pajak gagal! Gambar objek pajak dengan nama sama sudah ada.');
                        //     }
                        // }

                        if (!empty($new_nop)) {
                            $data['info'] .= '<div class="new_nop">NOP Baru: <b>' . $new_nop . '</b></div>';
                        }
                        // $data['info'] .= '';
                        // $this->session->set_flashdata('info', @$data['info']);
                        // redirect($this->c_loc, @$data);
                    } else {
                        $data['info'] .= err_msg('Input SPTPD Gagal!!4.');
                    }
                } else {
                    $data['info'] .= err_msg('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
                }
            }
            $this->session->set_userdata('info', $data['info']);
            $this->session->set_userdata('infoo', $data['info']);
            print_r($this->session->all_userdata());
            print_r($data['info']);
            redirect("/sptpd/add_by_wp");
        } else {
            $data['propinsis']          = $this->mod_propinsi->get_propinsi();
            $data['ppat']               = $this->mod_sptpd->get_ppat_opt();
            $data['jenis_perolehan']    = $this->mod_jns_perolehan->get_jns_perolehan();
            $data['prefix']             = $this->mod_prefix->get_prefix();
            $data['niks']               = $this->mod_nik->get_nik();
            $all_user                   = $this->session->all_userdata();
            $id_wp                      = $all_user['s_id_wp'];
            $data['isi']                = $this->db->query("select * from tbl_wp where id_wp = '$id_wp'")->row();
            $data['cek_transaksi_prev'] = '';
            $data['c_loc']              = $this->c_loc;
            $data['propinsi']           = $this->reg->get_prop($data['isi']->kd_propinsi);
            $data['kabupaten']          = $this->reg->get_kab($data['isi']->kd_propinsi, $data['isi']->kd_kabupaten);
            $data['kecamatan']          = $this->reg->get_kec($data['isi']->kd_propinsi, $data['isi']->kd_kabupaten, $data['isi']->kd_kecamatan);
            $data['kelurahan']          = $this->reg->get_kel($data['isi']->kd_propinsi, $data['isi']->kd_kabupaten, $data['isi']->kd_kecamatan, $data['isi']->kd_kelurahan);

            $data['submitvalue'] = 'Simpan';
            $data['rec_id']      = '';

            $data['info'] = $this->session->flashdata('info');

            $this->antclass->skin('v_sptpdform_wp', $data);
        }

        //----MENGHAPUS FILE CAPTCHA YANG LAMA
        //----SC : FAIZAL----
        // if ($this->session->userdata("oldCaptcha")) {
        //     $this->removeOldCaptcha($this->session->userdata("oldCaptcha"));
        //     $this->session->unset_userdata("oldCaptcha");
        // }
        //$this->session->set_userdata("oldCaptcha", $data['cap']);
    }

    //----MEMBUAT FUNGSI UNTUK GENERATE GAMBAR CAPTCHA DAN MENGESET SESSION UNTUK KODE CAPTCHA
    //----SC : FAIZAL----
    private function _create_captcha()
    {
        // we will first load the helper. We will not be using autoload because we only need it here
        $original_string = array_merge(range(0, 9));
        $original_string = implode("", $original_string);
        $captcha         = substr(str_shuffle($original_string), 0, 3);
        $vals = array(
            'word'          => $captcha,
            'img_path'      => './assets/captcha/',
            'img_url'       => base_url() . 'assets/captcha/',
            'font_path'     => FCPATH . 'assets\fonts\verdana.ttf',
            'font_size'     => 14,
            'img_width'     => '100',
            'img_height'    => 43,
            'expiration'    => 30,
            'colors'        => array(
                'background'     => array(255, 160, 119),
                'border'         => array(255, 255, 255),
                'text'           => array(40, 84, 164),
                'grid'           => array(40, 84, 164)
            )
        );
        $c_captcha     = create_captcha($vals);
        $image         = $c_captcha['image'];
        $this->session->set_userdata('captchaFormSSPD', $c_captcha['word']);
        // we will return the image html code
        return $image;
    }

    //----FUNGSI UNTUK MENGHAPUS FILE GAMBAR CAPTCHA YANG LAMA
    //----SC : FAIZAL
    public function removeOldCaptcha($fileLoc = "")
    {
        if ($fileLoc == "")  return false;
        $pattern = '<img src="(.+?)".+?>';
        preg_match_all($pattern, $fileLoc, $match);
        $fileLoc = $match[1][0];
        $fileLoc = explode("captcha/", $fileLoc);
        $fileName = $fileLoc[1];
        $filePosition = "./assets/captcha/" . $fileName;
        if (file_exists($filePosition)) {
            if (unlink($filePosition)) {
                return true;
            }
        }
    }

    public function loadFormLSPOP()
    {
        $data = array(
            "nop"           => $this->input->post('nop'),
            "lspopData"     => json_decode($this->input->post('lspopData'), true),
            "jml_bangunan"  => $this->input->post("jml_bangunan")
        );
        $this->load->view('v_formLSPOP', $data);
    }

    public function uploadFile($file = '', $name_fix = '', $no_dokumen = '')
    {
        $new_folder = 'assets/files/penelitian/' . $no_dokumen;

        if (!is_dir($new_folder)) {
            $oldmask = umask(0);
            mkdir($new_folder, 0777, true);
            umask($oldmask);
        }

        copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . 'assets/index.php', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $new_folder . '/index.php');

        $name          = $_FILES[$file]['name']; // get file name from form
        $fileNameParts = explode(".", $name); // explode file name to two part
        $fileExtension = end($fileNameParts); // give extension
        $fileExtension = strtolower($fileExtension); // convert to lower case
        $fix_name_file = $name_fix . "." . $fileExtension; // new file name

        $config['upload_path']   = $new_folder;
        $config['allowed_types'] = 'png|jpg|jpeg|pdf';
        $config['overwrite']     = TRUE;
        $config['max_size']      = '3048';
        // $config['max_width']     = '1024';
        // $config['max_height']    = '768';

        $this->load->library('upload', $config);

        $config['file_name'] = $fix_name_file; //set file name

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file)) {
            $error = array('error' => $this->upload->display_errors());

            echo 'kesalahan (Ukuran File Teralalu Besar) = ' . $file;
            print_r($error);
            exit;
        } else {
            $data = array('upload_data' => $this->upload->data());
        }

        return $fix_name_file;
    }

    public function edit($id)
    {
        $data['rekening']   = $this->mod_rekening->get_rekening(1);
        $data['c_loc']      = $this->c_loc;
        $$data['sptpd']     = $this->mod_sptpd->get_sptpd($id);
        $nomor_skb          = '';
        $tanggal_skb        = '';
        $nomor_skbkb        = '';
        $tanggal_skbkb      = '';
        $nomor_skbkbt       = '';
        $tanggal_skbkbt     = '';
        $custom_jml_setoran = '';
        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }

        $data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);
        $data['nop']                 = $this->mod_nop->get_nop($data['sptpd']->nop);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd('', '', '', '', '', $data['sptpd']->nik);
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        $this->antclass->skin('v_sptpdform', $data);
    }

    public function delete($id)
    {
        if ($this->mod_sptpd->get_sptpd($id)) {
            $this->mod_sptpd->delete_sptpd($id);
            $data['info'] = succ_msg('Delete SPTPD Berhasil.');
            $this->session->set_flashdata('info', @$data['info']);
            redirect($this->c_loc, @$data);
        } else {
            $this->antclass->skin('v_notfound');
        }
    }

    public function setlunas($id)
    {
        if ($this->session->userdata('s_tipe_bphtb') == 'B') {
            if ($this->mod_sptpd->get_sptpd($id)) {
                $no_dokumen = $this->uri->segment(4);
                if ($this->mod_sptpd->set_lunas($no_dokumen)) {
                    redirect($this->c_loc . '/report');
                } else {
                }
            } else {
                $this->antclass->skin('v_notfound');
            }
        }
    }

    public function report()
    {
        $date_start = $this->uri->segment(3) ? $this->uri->segment(3) : date('2000-01-01');
        $date_end   = $this->uri->segment(4) ? $this->uri->segment(4) : date('Y-m-d');
        $pp         = $this->uri->segment(5) ? $this->uri->segment(5) : '-';
        $ppat       = $this->uri->segment(6) ? $this->uri->segment(6) : '-';
        $pwp        = $this->uri->segment(7) ? $this->uri->segment(7) : '0';
        $stb        = $this->uri->segment(8) ? $this->uri->segment(8) : '0';
        $skbkb      = $this->uri->segment(9) ? $this->uri->segment(9) : '0';
        $skbkbt     = $this->uri->segment(10) ? $this->uri->segment(10) : '0';
        $user       = $this->uri->segment(11) ? $this->uri->segment(11) : '-';
        $nodok      = $this->uri->segment(12) ? $this->uri->segment(12) : '-';
        $status     = $this->uri->segment(13) ? $this->uri->segment(13) : '-';
        $pp_disp    = '';
        if ($pp == 'DISPENDA') {
            $pp_disp = '';
        } else {
            $pp_disp = $pp;
        }

        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc . '/report/' . $date_start . '/' . $date_end . '/' . $pp . '/' . $ppat . '/' . $pwp . '/' . $stb . '/' . $skbkb . '/' . $skbkbt . '/' . $user . '/' . $nodok . '/' . $status;

        // echo "<pre>";
        // print_r($config['base_url']);exit;
        if ($this->uri->segment(5) == '-') {
            $pp      = '';
        } else {
            $pp      = $this->uri->segment(5);
        }
        if ($this->uri->segment(6) == '-') {
            $ppat    = '';
        } else {
            $ppat    = $this->uri->segment(6);
        }
        if ($this->uri->segment(7) == '0') {
            $pwp     = '';
        } else {
            $pwp     = $this->uri->segment(7);
        }
        if ($this->uri->segment(8) == '0') {
            $stb     = '';
        } else {
            $stb     = $this->uri->segment(8);
        }
        if ($this->uri->segment(9) == '0') {
            $skbkb   = '';
        } else {
            $skbkb   = $this->uri->segment(9);
        }
        if ($this->uri->segment(10) == '0') {
            $skbkbt = '';
        } else {
            $skbkbt = $this->uri->segment(10);
        }
        if ($this->uri->segment(11) == '-') {
            $user   = '';
        } else {
            $user   = $this->uri->segment(11);
        }
        if ($this->uri->segment(12) == '-') {
            $nodok  = '';
        } else {
            $nodok  = $this->uri->segment(12);
        }
        if ($this->uri->segment(13) == '-') {
            $status = '';
        } else {
            $status = $this->uri->segment(13);
        }

        $config['total_rows'] = $this->mod_sptpd->count_sptpd($date_start, $date_end, $pp, $ppat, $pwp, $stb, $skbkb, $skbkbt, $user, $nodok, $status);
        // echo $this->db->last_query();exit();
        // echo "<pre>";
        // print_r($config['total_rows']);exit;
        $config['per_page']                        = 20;
        $config['uri_segment']                     = 14;
        $data['start']                             = $this->uri->segment(14);
        $config['full_tag_open']                   = '<ul>';
        $config['full_tag_close']                  = '</ul>';
        $config['first_link']                      = 'First';
        $config['first_tag_open']                  = '<li>';
        $config['first_tag_close']                 = '</li>';
        $config['last_link']                       = 'Last';
        $config['last_tag_open']                   = '<li>';
        $config['last_tag_close']                  = '</li>';
        $config['next_link']                       = 'Next →';
        $config['next_tag_open']                   = '<li class="next">';
        $config['next_tag_close']                  = '</li>';
        $config['prev_link']                       = '← Prev';
        $config['prev_tag_open']                   = '<li class="prev disabled">';
        $config['prev_tag_close']                  = '</li>';
        $config['cur_tag_open']                    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']                   = '</a></li>';
        $config['num_tag_open']                    = '<li>';
        $config['num_tag_close']                   = '</li>';
        if (empty($data['start'])) {
            $data['start'] = 0;
        }
        $this->pagination->initialize($config);

        $data['page_link']    = $this->pagination->create_links();
        $data['c_loc']        = $this->c_loc;
        $data['paymentpoint'] = $this->mod_paymentpoint->get_paymentpoint();
        $data['users']        = $this->mod_user->get_user();
        $data['ppats']        = $this->mod_ppat->get_ppat();
        $data['sptpds']       = $this->mod_sptpd->get_report_sptpd('', $date_start, $date_end, $pp, $ppat, $pwp, $stb, $skbkb, $skbkbt, $user, $nodok, $status, 'page', $data['start'], $config['per_page']);

        $data['sum_jumlah_setor'] = $this->mod_sptpd->sum_jumlah_setor($date_start, $date_end, $pp, $ppat, $pwp, $stb, $skbkb, $skbkbt);

        $this->antclass->skin('v_sptpdreport', $data);
    }

    public function report_all()
    {
        $this->load->library('pagination');
        $date_start = $this->uri->segment(3);
        $date_end   = $this->uri->segment(4);
        $pp         = $this->uri->segment(5);
        $ppat       = $this->uri->segment(6);
        $pwp        = $this->uri->segment(7);
        $stb        = $this->uri->segment(8);
        $skbkb      = $this->uri->segment(9);
        $skbkbt     = $this->uri->segment(10);
        $user       = $this->uri->segment(11);
        $nodok      = $this->uri->segment(12);
        $status     = $this->uri->segment(13);

        if ($this->uri->segment(5) == '-') {
            $pp      = '';
        } else {
            $pp      = $this->uri->segment(5);
        }
        if ($this->uri->segment(6) == '-') {
            $ppat    = '';
        } else {
            $ppat    = $this->uri->segment(6);
        }
        if ($this->uri->segment(7) == '0') {
            $pwp     = '';
        } else {
            $pwp     = $this->uri->segment(7);
        }
        if ($this->uri->segment(8) == '0') {
            $stb     = '';
        } else {
            $stb     = $this->uri->segment(8);
        }
        if ($this->uri->segment(9) == '0') {
            $skbkb   = '';
        } else {
            $skbkb   = $this->uri->segment(9);
        }
        if ($this->uri->segment(10) == '0') {
            $skbkbt = '';
        } else {
            $skbkbt = $this->uri->segment(10);
        }
        if ($this->uri->segment(11) == '-') {
            $user   = '';
        } else {
            $user   = $this->uri->segment(11);
        }
        if ($this->uri->segment(12) == '-') {
            $nodok  = '';
        } else {
            $nodok  = $this->uri->segment(12);
        }
        if ($this->uri->segment(13) == '-') {
            $status = '';
        } else {
            $status = $this->uri->segment(13);
        }

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

        $data['page_link']        = $this->pagination->create_links();
        $data['c_loc']            = $this->c_loc;
        $data['paymentpoint']     = $this->mod_paymentpoint->get_paymentpoint();
        $data['users']            = $this->mod_user->get_user();
        $data['ppats']            = $this->mod_ppat->get_ppat();
        $data['sptpds']           = $this->mod_sptpd->get_report_sptpd('', $date_start, $date_end, $pp, $ppat, $pwp, $stb, $skbkb, $skbkbt, $user, $nodok, $status);
        $this->session->set_userdata('ses_sql_laporan_ppat', $this->db->last_query());
        $data['sum_jumlah_setor'] = $this->mod_sptpd->sum_jumlah_setor($date_start, $date_end, $pp, $ppat, $pwp, $stb, $skbkb, $skbkbt, $nodok);

        $this->antclass->skin('v_sptpdprintall', $data);
    }

    public function go_report()
    {
        if ($this->input->post('search_submit')) {
            if ($this->input->post('txt_c_tgl_awal') != '') {
                $date_start   = $this->input->post('txt_c_tgl_awal');
            } else {
                $date_start   = '2000-01-01';
            }
            if ($this->input->post('txt_c_tgl_akhir') != '') {
                $date_end    = $this->input->post('txt_c_tgl_akhir');
            } else {
                $date_end    = date('Y-m-d');
            }
            if ($this->input->post('txt_c_pp') != '') {
                $pp                 = $this->input->post('txt_c_pp');
            } else {
                $pp                 = '-';
            }
            if ($this->input->post('txt_c_ppat') != '') {
                $ppat             = $this->input->post('txt_c_ppat');
            } else {
                $ppat             = '-';
            }
            if ($this->input->post('txt_c_setoran_pwp') != '') {
                $pwp       = $this->input->post('txt_c_setoran_pwp');
            } else {
                $pwp       = '0';
            }
            if ($this->input->post('txt_c_setoran_stb') != '') {
                $stb       = $this->input->post('txt_c_setoran_stb');
            } else {
                $stb       = '0';
            }
            if ($this->input->post('txt_c_setoran_skbkb') != '') {
                $skbkb   = $this->input->post('txt_c_setoran_skbkb');
            } else {
                $skbkb   = '0';
            }
            if ($this->input->post('txt_c_setoran_skbkbt') != '') {
                $skbkbt = $this->input->post('txt_c_setoran_skbkbt');
            } else {
                $skbkbt = '0';
            }
            if ($this->input->post('txt_c_user') != '') {
                $user             = $this->input->post('txt_c_user');
            } else {
                $user             = '-';
            }
            if ($this->input->post('txt_c_nodok') != '') {
                $nodok           = $this->input->post('txt_c_nodok');
            } else {
                $nodok           = '-';
            }
            if ($this->input->post('txt_c_status') != '') {
                $status         = $this->input->post('txt_c_status');
            } else {
                $status         = '-';
            }
            redirect($this->c_loc . '/report/' . $date_start . '/' . $date_end . '/' . $pp . '/' . $ppat . '/' . $pwp . '/' . $stb . '/' . $skbkb . '/' . $skbkbt . '/' . $user . '/' . $nodok . '/' . $status);
        }

        if ($this->input->post('submit_print_all')) {
            if ($this->input->post('txt_c_tgl_awal') != '') {
                $date_start   = $this->input->post('txt_c_tgl_awal');
            } else {
                $date_start   = '2000-01-01';
            }
            if ($this->input->post('txt_c_tgl_akhir') != '') {
                $date_end    = $this->input->post('txt_c_tgl_akhir');
            } else {
                $date_end    = date('Y-m-d');
            }
            if ($this->input->post('txt_c_pp') != '') {
                $pp                 = $this->input->post('txt_c_pp');
            } else {
                $pp                 = '-';
            }
            if ($this->input->post('txt_c_ppat') != '') {
                $ppat             = $this->input->post('txt_c_ppat');
            } else {
                $ppat             = '-';
            }
            if ($this->input->post('txt_c_setoran_pwp') != '') {
                $pwp       = $this->input->post('txt_c_setoran_pwp');
            } else {
                $pwp       = '0';
            }
            if ($this->input->post('txt_c_setoran_stb') != '') {
                $stb       = $this->input->post('txt_c_setoran_stb');
            } else {
                $stb       = '0';
            }
            if ($this->input->post('txt_c_setoran_skbkb') != '') {
                $skbkb   = $this->input->post('txt_c_setoran_skbkb');
            } else {
                $skbkb   = '0';
            }
            if ($this->input->post('txt_c_setoran_skbkbt') != '') {
                $skbkbt = $this->input->post('txt_c_setoran_skbkbt');
            } else {
                $skbkbt = '0';
            }
            if ($this->input->post('txt_c_user') != '') {
                $user             = $this->input->post('txt_c_user');
            } else {
                $user             = '-';
            }
            if ($this->input->post('txt_c_nodok') != '') {
                $nodok           = $this->input->post('txt_c_nodok');
            } else {
                $nodok           = '-';
            }
            if ($this->input->post('txt_c_status') != '') {
                $status         = $this->input->post('txt_c_status');
            } else {
                $status         = '-';
            }

            redirect($this->c_loc . '/report_all/' . $date_start . '/' . $date_end . '/' . $pp . '/' . $ppat . '/' . $pwp . '/' . $stb . '/' . $skbkb . '/' . $skbkbt . '/' . $user . '/' . $nodok . '/' . $status);
        }
    }

    public function printform($id)
    {
        $data['id']       = $id;
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['c_loc']    = $this->c_loc;
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);

        $data['hasil']    = $data['sptpd']->batas - 3;

        @$kec = @$data['sptpd']->kd_kecamatan;
        @$kel = @$data['sptpd']->kd_kelurahan;

        $data['hr']       = $this->db->query("SELECT b.alamat, b.harga from tbl_sptpd a
                                    join harga_refrensi b on b.kd_kec = a.kd_kecamatan and b.kd_kel = a.kd_kelurahan
                                    where a.kd_propinsi='35' and a.kd_kabupaten='73' and b.kd_kec = $kec and b.kd_kel = $kel and a.id_sptpd = $id")->result();

        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        $data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);
        $wil_nik                     = (array) $data['nik'];
        $wil_nik                     = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        $data['penelitian']          = $this->mod_sptpd->get_lampiran($data['sptpd']->no_dokumen);

        $data['kabid']               = $this->mod_user->get_kabid();

        $this->antclass->skin('v_sptpdprint_blitar', $data);
    }

    function action_update($id_sptpd)
    {
        $data[$this->table_prefix . 'no_akta']           = $_POST['no_akta'];
        $data[$this->table_prefix . 'tgl_akta']          = $_POST['tgl_akta'];
        $data[$this->table_prefix . 'tgl']               = $_POST['tgl'];
        $data[$this->table_prefix . 'rp']                = $_POST['rp'];
        $data[$this->table_prefix . 'pihak_mengalihkan'] = $_POST['pihak_mengalihkan'];
        $result                                        = $this->db->update('tbl_sptpd', $data, ['id_sptpd' => $id_sptpd]);

        redirect('sptpd', 'refresh');
    }

    public function lihat_transaksi($id)
    {
        $data['id']       = $id;
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['c_loc']    = $this->c_loc;
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);
        $id_jp            = $data['sptpd']->jenis_perolehan_op;
        $data['jenper']   = $this->db->query("SELECT nama from tbl_jns_perolehan where kd_perolehan = $id_jp")->row();

        $id_user          = $data['sptpd']->id_ppat;
        $data['ppat1']   = $this->db->query("SELECT * from tbl_ppat where id_ppat = $id_user")->row();

        @$kec = @$data['sptpd']->kd_kecamatan;
        @$kel = @$data['sptpd']->kd_kelurahan;

        $data['hr']       = $this->db->query("SELECT b.alamat, b.harga from tbl_sptpd a
                                    join harga_refrensi b on b.kd_kec = a.kd_kecamatan and b.kd_kel = a.kd_kelurahan
                                    where a.kd_propinsi='35' and a.kd_kabupaten='73' and b.kd_kec = $kec and b.kd_kel = $kel and a.id_sptpd = $id")->result();

        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        $data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);
        $wil_nik                     = (array) $data['nik'];
        $wil_nik                     = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        $data['penelitian'] = $this->mod_sptpd->get_lampiran($data['sptpd']->no_dokumen);

        $data['kabid']  = $this->mod_user->get_kabid();

        $this->antclass->skin('v_transaksi', $data);
    }

    public function halaman_print($id)
    {
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['c_loc']    = $this->c_loc;
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);
        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        $data['ppat'] = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']  = $this->mod_nik->get_nik($data['sptpd']->nik);

        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        $this->load->view('v_sptpd_halaman_print', $data, false);
        // $this->antclass->skin('v_sptpdprint', $data);
        // $this->antclass->skin('v_sptpd_halaman_print', $data);
    }

    public function terbilang_val($nilai = null)
    {
        if (isset($_POST['ajax'])) {
            $convert         = $this->antclass->terbilang($this->input->post('enValue'), 3);
            $terbilang_array = array('result' => $convert);
            echo json_encode($terbilang_array);
        } else {
            $convert = $this->antclass->terbilang($nilai, 3);
            return $convert . ' Rupiah';
        }
    }

    public function update_sppt_token()
    {
        $this->db->where("token IS NULL");
        $query = $this->db->get('sppt');
        $data  = $query->result();
        foreach ($data as $dt) {
            $token   = $this->antclass->generate_token();
            $ed_data = array('token' => $token);
            $this->db->where('kd_propinsi', $dt->kd_propinsi);
            $this->db->where('kd_dati2', $dt->kd_dati2);
            $this->db->where('kd_kecamatan', $dt->kd_kecamatan);
            $this->db->where('kd_kelurahan', $dt->kd_kelurahan);
            $this->db->where('kd_blok', $dt->kd_blok);
            $this->db->where('no_urut', $dt->no_urut);
            $this->db->where('kd_jns_op', $dt->kd_jns_op);
            $this->db->where("token IS NULL");
            if ($this->db->update('sppt', $ed_data)) {
                echo 'yes';
            } else {
                echo 'no';
            }
            echo '<br />';
        }
    }

    public function update_nop_data()
    {
        $query = $this->db->get('sppt');
        $data  = $query->result();
        foreach ($data as $dt) {
            $nop = $dt->kd_propinsi . $dt->kd_dati2 . $dt->kd_kecamatan . $dt->kd_kelurahan . $dt->kd_blok . $dt->no_urut . $dt->kd_jns_op;

            $this->db->where('nop', $nop);
            $query = $this->db->get('tbl_nop');
            if (!$query->row()) {
                $add_data = array(
                    'nop' => $nop,
                    'lokasi_op'             => $dt->jln_wp_sppt,
                    'kelurahan_op'          => $dt->kd_propinsi . '.' . $dt->kd_dati2 . '.' . $dt->kd_kecamatan . '.' . $dt->kd_kelurahan,
                    'rtrw_op'               => $dt->rw_wp_sppt . ' / ' . $dt->rt_wp_sppt,
                    'kecamatan_op'          => $dt->kd_propinsi . '.' . $dt->kd_dati2 . '.' . $dt->kd_kecamatan,
                    'kotakab_op'            => $dt->kd_propinsi . '.' . $dt->kd_dati2,
                    'luas_tanah_op'         => $dt->luas_bumi_sppt,
                    'luas_bangunan_op'      => $dt->luas_bng_sppt,
                    'njop_tanah_op'         => $dt->njop_bumi_sppt / $dt->luas_bumi_sppt,
                    'njop_bangunan_op'      => $dt->njop_bng_sppt / $dt->luas_bng_sppt,
                    'njop_pbb_op'           => $dt->njop_bumi_sppt + $dt->njop_bng_sppt,
                    //'nilai_op'=>$nilai_op,
                    'jenis_perolehan_op'    => '',
                    'no_sertipikat_op'      => '',
                );
                if ($this->db->insert('tbl_nop', $add_data)) {
                    echo 'yes';
                    echo '<br />';
                } else {
                    echo 'no';
                }
            }
        }
    }

    public function get_nik()
    {
        $id_nik = $_POST['txt_id_nik_sptpd'];
        $data   = $this->mod_sptpd->get_nik($id_nik);
        if ($data) {
            $wil_nik     = (array) $data;
            $wil_nik2    = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);

            $nik_nm_propinsi     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik2);
            $nik_nm_kabupaten    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik2);
            $nik_nm_kecamatan    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik2);
            $nik_nm_kelurahan    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik2);
            echo '<script type="text/javascript">';
            echo '$("#nama_nik_id").html("' . $data->nama . '");';
            echo '$("#alamat_nik_id").html("' . $data->alamat . '");';
            echo '$("#propinsi_nik_id").html("' . $nik_nm_propinsi . '");';
            echo '$("#kelurahan_nik_id").html("' . $nik_nm_kelurahan . '");';
            echo '$("#kecamatan_nik_id").html("' . $nik_nm_kecamatan . '");';
            echo '$("#kotakab_nik_id").html("' . $nik_nm_kabupaten . '");';
            echo '$("#rtrw_nik_id").html("' . $data->rtrw . '");';
            echo '$("#kodepos_nik_id").html("' . $data->kodepos . '");';
            echo '$("#nama_nik_id_text").val("' . $data->nama . '");';
            echo '$("#alamat_nik_id_text").val("' . $data->alamat . '");';
            echo '$("#rtrw_nik_id_text").val("' . $data->rtrw . '");';
            echo '$("#kodepos_nik_id_text").val("' . $data->kodepos . '");';
            echo '$("#kodepos_nik_id_text").val("' . $data->kodepos . '");';
            echo '$("#propinsi_nik_id_inp").val("' . $nik_nm_propinsi . '");';
            echo '$("#kotakab_nik_id_inp").val("' . $nik_nm_kabupaten . '");';
            echo '$("#kecamatan_nik_id_inp").val("' . $nik_nm_kecamatan . '");';
            echo '$("#kelurahan_nik_id_inp").val("' . $nik_nm_kelurahan . '");';

            echo '</script>';
        } else {
            // echo '<script type="text/javascript">';
            // echo '</script>';

            echo "kosong";
        }
    }

    public function check_nik()
    {

        $id_nik = $this->input->post('enNikValue');
        $data   = $this->mod_sptpd->get_nik($id_nik);
        if ($data) {
            $result_content = array(
                'nama'      => $data->nama,
                'alamat'    => $data->alamat,
                'kelurahan' => $data->nm_kelurahan,
                'rtrw'      => $data->rtrw,
                'kecamatan' => $data->nm_kecamatan,
                'kota'      => $data->nm_dati2,
                'kd_pos'    => $data->kodepos,
            );
        } else {
            $result_content = array('nama' => '');
        }

        echo json_encode($result_content);
    }

    public function getNOPService()
    {
        $nop = $this->input->get('nop');

        print_r(json_decode($nop));
    }

    public function cek_transaksi_previous()
    {
        $nik      = $this->input->get('nik');
        $npop_sel = $this->input->get('npop_sel');

        // $cek_transaksi_prev = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $nik); //deleted 

        echo '<script type="text/javascript">';

        /* tidak ada pengecekan
		 if (!$cek_transaksi_prev) {
            // NPWP TIDAK PERNAH melakukan transaksi, dapat NPOPTKP
            $npopkp_sel = $npop_sel - $this->config->item('conf_npoptkp');
            echo '$("#npoptkp_lbl_id").html("' . number_format($this->config->item('conf_npoptkp'), 0, ',', '.') . '");';
            echo '$("#npoptkp_id").val("' . $this->config->item('conf_npoptkp') . '");';
        } else {
            // NPWP PERNAH melakukan transaksi, TIDAK dapat NPOPTKP
            $npopkp_sel = $npop_sel;
            echo '$("#npoptkp_lbl_id").html("' . number_format(0, 0, ',', '.') . '");';
            echo '$("#npoptkp_id").val("0");';
        } */

        //tanpa cek transaksi/tdk ada progresif
        $npopkp_sel = $npop_sel - $this->config->item('conf_npoptkp');
        echo '$("#npoptkp_lbl_id").html("' . number_format($this->config->item('conf_npoptkp'), 0, ',', '.') . '");';
        echo '$("#npoptkp_id").val("' . $this->config->item('conf_npoptkp') . '");';
        //

        if ($npopkp_sel <= 0) {
            $npopkp_sel = 0;
        }
        echo '$("#npopkp_id").html("' . number_format($npopkp_sel, 0, ',', '.') . '");';
        $bea_perolehan_sel                       = 0;
        if ($npopkp_sel > 0) {
            $bea_perolehan_sel = $npopkp_sel * 0.05;
        }
        echo '$("#bea_perolehan_id").html("' . number_format($bea_perolehan_sel, 0, ',', '.') . '");';
        echo '$("#bea_perolehan_h_id").val("' . $bea_perolehan_sel . '");';
        // echo '$("#jns_perolehan_nop_id").html("'.$data->jenis_perolehan_op.' - '.$jns_perolehan->nama.'");';
        // echo '$("#no_sertipikat_nop_id").html("'.$data->no_sertipikat_op.'");';
        // echo 'alert("Yo");';

        echo '</script>';
    }

    public function get_kecamatan_bydati2()
    {
        $kd_propinsi = $this->input->post('kd_propinsi');
        $kd_dati2 = $this->input->post('dati2_id');

        $data     = $this->mod_kecamatan->get_kecamatan_sppt_form($kd_propinsi, $kd_dati2);
        // echo '<pre>'; print_r($data);
        // echo $this->db->last_query();
        // exit;
        if ($data) {
            foreach ($data as $data) {
                echo '<option value="' . $data->kd_kecamatan . '"' . set_select('propinsi_nik_name', $data->kd_kecamatan) . '   >' . $data->kd_kecamatan . ' - ' . $data->nama . '</option>';
            }
        } else {
            echo 'no';
        }
    }

    public function get_kecamatan_bydati2_session()
    {
        $kd_dati2     = $this->input->get('dati2_id');
        $kd_kecamatan = $this->input->get('kd_kecamatan');

        $data = $this->mod_kecamatan->get_kecamatan('', '', $kd_dati2);
        // echo '<pre>'; print_r($data);
        // echo $this->db->last_query();
        // exit;

        if ($data) {
            foreach ($data as $data) {
                if ($data->kd_kecamatan == $kd_kecamatan) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                echo '<option value="' . $data->kd_kecamatan . '" ' . $selected . ' >' . $data->kd_kecamatan . ' - ' . $data->nama . '</option>';
            }
        } else {
            echo 'no';
        }
    }

    public function get_kabupaten_bypropinsi()
    {
        @$ses_dati2  = $this->session->userdata('kd_dati2_nik');
        $kd_propinsi = $this->input->post('propinsi_id');
        $data        = $this->mod_nop->get_kab($kd_propinsi);
        if ($data > 0) {
            foreach ($data as $data) {
                echo '<option value="' . $data->kd_kabupaten . '" >' . $data->kd_kabupaten . ' - ' . $data->nama . '</option>';
            }
        } else {
            echo 'no';
        }
    }

    public function get_kelurahan_bykecamatan_session()
    {
        // $kd_kecamatan = $this->input->get('kd_kecamatan');
        $kd_kelurahan = $this->input->get('kd_kelurahan');

        $kd_kecamatan = $this->input->get('rx_kd_kecamatan');
        $data         = $this->mod_kelurahan->get_kelurahan('', '', $kd_kecamatan);

        if ($datas) {
            foreach ($data as $data) {
                if ($data->kd_kelurahan == $kd_kelurahan) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                echo '<option value="' . $data->kd_kelurahan . '" ' . $selected . ' >' . $data->kd_kelurahan . ' - ' . $data->nama . '</option>';
            }
        } else {
            echo 'no';
        }
    }

    public function save_tmp()
    {
        $ses_data = $this->input->post('txt_nilai_pasar_sptpd');
        $a        = str_replace('.', '', $ses_data);
        // echo "string";
        print_r($a);
        exit();
    }

    public function edit_sptpd($id_sptpd)
    {
        $data['file_upload'] = null;
        $data['no_sspd']     = null;
        $data['id']     = $id_sptpd;
        $data['sptpd'] = $this->mod_sptpd->get_sptpd($id_sptpd);
        $data['sspd_no'] = $this->mod_sptpd->get_sspd_no($id_sptpd);
        // echo  $data['sspd_no']->no_dokumen;exit();

        $data['nop'] =  $data['sptpd']->kd_propinsi . '.' .
            $data['sptpd']->kd_kabupaten . '.' .
            $data['sptpd']->kd_kecamatan . '.' .
            $data['sptpd']->kd_kelurahan . '.' .
            $data['sptpd']->kd_blok . '.' .
            $data['sptpd']->no_urut . '.' .
            $data['sptpd']->kd_jns_op;

        if ($data['sptpd']) {
            $data['file_upload'] = $this->mod_sptpd->get_fileUpload($data['sptpd']->no_dokumen);
            $data['no_sspd']     = $data['sptpd']->no_dokumen;
        }

        $data['nik'] = $this->mod_sptpd->get_nik_detail($data['sptpd']->nik);

        $data['txt_kd_dati2_selected']     = @$data['nik']->kd_kabupaten;
        $data['txt_kd_kecamatan_selected'] = @$data['nik']->kd_kecamatan;
        $data['txt_kd_kelurahan_selected'] = @$data['nik']->kd_kelurahan;

        $array = array(
            // nik
            's_nik_nik'                          => $this->input->post('txt_id_nik_sptpd'),
            's_nama_nik'                         => $this->input->post('nama_nik_name'),
            's_alamat_nik'                       => $this->input->post('alamat_nik_name'),
            's_propinsi_nik'                     => $this->input->post('propinsi_nik_name'),
            's_kd_dati2_nik'                     => $this->input->post('kotakab_nik_name'),
            's_kd_kecamatan_nik'                 => $this->input->post('kecamatan_nik_name'),
            's_kd_kelurahan_nik'                 => $this->input->post('kelurahan_nik_name'),
            's_rtrw_nik'                         => $this->input->post('rtrw_nik_name'),
            's_kodepos_nik'                      => $this->input->post('kodepos_nik_name'),

            // nop
            's_txt_id_nop_sptpd'                 => $this->input->post('txt_id_nop_sptpd'),

            // lampiran
            's_txt_picture_lampiran_sspd_1_file' => $this->input->post('txt_picture_lampiran_sspd_1_file'),
        );

        $this->session->set_userdata($array);

        if ($this->input->post('submit')) {

            $data['info'] = '';
            $this->load->library('form_validation');
            $ident = $this->input->post('ident');
            //hilangi nama_ppat_id
            //jilangi txt_id_ppat_sptpd
            //$this->form_validation->set_rules('txt_id_ppat_sptpd', 'ID PPAT', 'required|xss_clean');
            $this->form_validation->set_rules('txt_id_nik_sptpd', 'NIK', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_id_nop_sptpd', 'NOP', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_nilai_pasar_sptpd', 'Nilai Pasar', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_npop_sptpd', 'NPOP', 'required|trim');
            $this->form_validation->set_rules('txt_jml_setor_sptpd', 'Jumlah yang disetor', 'required|numeric|trim');
            $this->form_validation->set_rules('txt_jns_perolehan_sptpd', 'Jenis Perolehan', 'trim|required');
            if ($ident != '') {
                $this->form_validation->set_rules('nama_nik_name', 'Nama', 'required|trim');
                $this->form_validation->set_rules('alamat_nik_name', 'Alamat', 'required|trim');
                $this->form_validation->set_rules('propinsi_nik_name', 'Propinsi', 'required|trim');
                $this->form_validation->set_rules('kotakab_nik_name', 'Kabupaten / Kota', 'required|trim');
                $this->form_validation->set_rules('kecamatan_nik_name', 'Kecamatan', 'required|trim');
                $this->form_validation->set_rules('kelurahan_nik_name', 'Kelurahan', 'required|trim');
                $this->form_validation->set_rules('rtrw_nik_name', 'RT / RW', 'trim');
                $this->form_validation->set_rules('kodepos_nik_name', 'Kode Pos', 'trim');
            }
            if ($this->form_validation->run() == false) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $nik_nik          = $this->input->post('txt_id_nik_sptpd');
                $nama_nik         = $this->input->post('nama_nik_name');
                $alamat_nik       = $this->input->post('alamat_nik_name');
                $propinsi_nik     = $this->input->post('propinsi_nik_name');
                $kd_dati2_nik     = $this->input->post('kotakab_nik_name');
                $kd_kecamatan_nik = $this->input->post('kecamatan_nik_name');
                $kd_kelurahan_nik = $this->input->post('kelurahan_nik_name');
                $rtrw_nik         = $this->input->post('rtrw_nik_name');
                $kodepos_nik      = $this->input->post('kodepos_nik_name');

                if ($ident != '') {
                    $hitung = $this->mod_nik->ceknik($nik_nik);
                    if (!empty($hitung)) {
                        $data['info'] = err_msg('NIK Sudah Ada.');
                    } else {
                        $info = $this->mod_nik->add_nik(
                            $nik_nik,
                            $nama_nik,
                            $alamat_nik,
                            $propinsi_nik,
                            $kd_dati2_nik,
                            $kd_kecamatan_nik,
                            $kd_kelurahan_nik,
                            $rtrw_nik,
                            $kodepos_nik
                        );
                    }
                }

                $unique_code = $this->antclass->get_unique_code(5);
                $id_ppat     = $this->session->userdata('s_id_ppat');
                $nik         = $this->input->post('txt_id_nik_sptpd');
                $wajibpajak   = $data['sptpd']->wajibpajak;
                $nop = $this->antclass->remove_separator($this->input->post('txt_id_nop_sptpd'));
                // pemecahan nop
                $kd_propinsi  = substr($nop, 0, 2);
                $kd_kabupaten = substr($nop, 2, 2);
                $kd_kecamatan = substr($nop, 4, 3);
                $kd_kelurahan = substr($nop, 7, 3);
                $kd_blok      = substr($nop, 10, 3);
                $no_urut      = substr($nop, 13, 4);
                $kd_jns_op    = substr($nop, 17, 1);
                $nop_compile  = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

                //str replace alamat nop
                $nop_alamat_filter   = @$this->input->post('alamat_nop_id');
                $nop_alamat          = str_replace("'", "`", $nop_alamat_filter);

                //inputan nop
                $nopsave_lokasi           = $this->input->post('nopsave_letak_tanah');
                $nopsave_kd_dati2_nop     = $kd_kabupaten;
                $nopsave_kd_kecamatan_nop = $kd_kecamatan;
                $nopsave_kd_kelurahan_nop = $kd_kelurahan;
                $nopsave_rtrw             = $this->input->post('nopsave_rtrw');
                $nopsave_luas_tanah       = $this->input->post('nopsave_luas_tanah');
                $nopsave_njop_tanah       = $this->input->post('nopsave_njop_tanah');
                $nopsave_luas_bangunan    = $this->input->post('nopsave_luas_bangunan');
                $nopsave_njop_bangunan    = $this->input->post('nopsave_njop_bangunan');
                $nopsave_njop_pbb         = $this->input->post('nopsave_njop');
                $nopsave_kd_propinsi_op   = $kd_propinsi;
                $nopsave_no_sertipikat    = $this->input->post('nopsave_no_serf');
                $nopsave_thn_pajak_sppt   = $this->input->post('nopsave_thnpjk');
                $nopsave_ident            = $this->input->post('status_pencarian_nop');

                $nopsave_propinsi  = $this->input->post('nopsave_propinsi');
                $nopsave_kabupaten = $this->input->post('nopsave_kabupaten');
                $nopsave_kecamatan = $this->input->post('nopsave_kecamatan');
                $nopsave_kelurahan = $this->input->post('nopsave_kelurahan');
                $nopsave_ref_tanah           = $this->input->post('ref_tanah');
                $nopsave_ref_bangunan        = $this->input->post('ref_bangunan');
                $param_nop['nama_penjual']   = $this->input->post('nama_penjual');
                $param_nop['alamat_penjual'] = $this->input->post('alamat_penjual');

                //add nop
                if ($nopsave_ident == 'dari sismiop') {
                    $this->mod_nop->edit_service_nop(
                        $nop_compile,
                        $nopsave_lokasi,
                        $nopsave_kd_kelurahan_nop,
                        $nopsave_rtrw,
                        $nopsave_kd_kecamatan_nop,
                        $nopsave_kd_dati2_nop,
                        $nopsave_luas_tanah,
                        $nopsave_luas_bangunan,
                        $nopsave_njop_tanah,
                        $nopsave_njop_bangunan,
                        $nopsave_njop_pbb,
                        '',
                        '',
                        $nopsave_no_sertipikat,
                        $nopsave_kd_propinsi_op,
                        $nopsave_thn_pajak_sppt,
                        $nopsave_ref_tanah,
                        $nopsave_ref_bangunan,
                        $param_nop
                    );
                    //input propinsi
                    $check_prop = $this->mod_propinsi->get_propinsi($kd_propinsi);
                    if (count($check_prop) == 0) {
                        $this->mod_propinsi->add_propinsi($kd_propinsi, $nopsave_propinsi);
                    }
                    //input kabupaten
                    $check_kab = $this->mod_dati2->get_dati2($kd_kabupaten, '', $kd_propinsi);
                    if (count($check_kab) == 0) {
                        $this->mod_dati2->add_dati2($kd_propinsi, $kd_kabupaten, $nopsave_kabupaten);
                    }
                    //input kecamatan
                    $check_kec = $this->mod_kecamatan->get_kecamatan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan);

                    if (count($check_kec) == 0) {
                        $this->mod_kecamatan->add_kecamatan($kd_kecamatan, $nopsave_kecamatan, $kd_propinsi, $kd_kabupaten);
                    }
                    //input kelurahan
                    $check_kel = $this->mod_kelurahan->get_kelurahan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan);

                    if (count($check_kel) == 0) {
                        $this->mod_kelurahan->add_kelurahan($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $nopsave_kelurahan);
                    }
                }

                $luas_tanah_sptpd    = $this->input->post('txt_luas_tanah_sptpd');
                $luas_bangunan_sptpd = $this->input->post('txt_luas_bangunan_sptpd');
                $luas_tanah_b_sptpd  = $this->input->post('txt_luas_tanah_b_sptpd');
                $luas_bangunan_b_sptpd  = $this->input->post('txt_luas_bangunan_b_sptpd');
                $njop_tanah_sptpd    = str_replace('.', '', $this->input->post('txt_njop_tanah_sptpd'));
                $njop_bangunan_sptpd = str_replace('.', '', $this->input->post('txt_njop_bangunan_sptpd'));
                $njop_tanah_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_tanah_b_sptpd'));
                $njop_bangunan_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_bangunan_b_sptpd'));
                $njop_pbb_sptpd      = $this->input->post('txt_njop_pbb_h_sptpd');
                $text_no_sertifikat  = $this->input->post('txt_no_sertifikat_op');

                $text_lokasi_op      = $this->input->post('text_lokasi_op');
                $text_thn_pajak_sppt = $this->input->post('text_thn_pajak_sppt');

                $nilai_pasar        = str_replace('.', '', $this->input->post('txt_nilai_pasar_sptpd'));
                $jenis_perolehan    = $this->input->post('txt_jns_perolehan_sptpd');
                $npop               = str_replace('.', '', $this->input->post('txt_npop_sptpd'));
                $npoptkp            = str_replace('.', '', $this->input->post('txt_npoptkp_sptpd'));
                $dasar_jml_setoran  = $this->input->post('txt_dasar_jml_setoran_sptpd');
                $bea_terhutang      = $this->input->post('txt_bea_perolehan_sptpd');
                $bea_bayar          = $this->input->post('txt_bea_bayar_sptpd');
                $nomor_jml_setoran  = '';
                $tgl_jml_setoran    = '';
                $custom_jml_setoran = '';
                if ($dasar_jml_setoran == 'PWP') {
                    $nomor_jml_setoran = '';
                    $tgl_jml_setoran   = '';
                } elseif ($dasar_jml_setoran == 'STB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_stb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_stb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKBT') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkbt_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkbt_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                }

                $hitung_sendiri_jml_setoran = $this->input->post('txt_hitung_sendiri_sptpd');
                $jml_setor                  = $this->input->post('txt_jml_setor_sptpd');

                //19082021
                $tanggal_pengajuan = $this->input->post('tanggal_pengajuan_name');

                //$no_dokumen = $this->input->post('txt_no_dokumen_sptpd');
                $autonum     = '0001';
                $cur_autonum = '';
                $get_autonum = $this->mod_sptpd->get_last_autonum2();
                foreach ($get_autonum as $getnum) {
                    $cur_autonum = $getnum->nodok;
                }
                if ($cur_autonum != '') {
                    // $autonum = substr($cur_autonum, 11, 4);
                    // $autonum = (int) $autonum;
                    // $autonum += $autonum;
                    $autonum = str_pad($cur_autonum, 4, '0', STR_PAD_LEFT);
                }

                $no_dokumen = $this->input->post('nomor_dokumen');
                //echo $no_dokumen;exit;
                $nop_pbb_baru = $this->input->post('txt_nop_pbb_baru_sptpd');
                $saved_nop    = $nop;
                // $kode_validasi = $this->antclass->add_nop_separator($nop).'-'.date('Ymd').'-'.$jml_setor.'-'.$unique_code;
                $kode_validasi = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_jns_perolehan_sptpd');

                // $picture                                                    = '';
                if ($_FILES['txt_picture_sptpd']['name'] != '') {
                    $picture = str_replace(' ', '_', $_FILES['txt_picture_sptpd']['name']);
                }

                // Jumlah setor lebih atau sama dari Bea Perolehan Yang Terutang
                if ($bea_bayar <= $jml_setor or $dasar_jml_setoran == 'SKBKB' or $dasar_jml_setoran == "SKBKBT") {
                    $check_luas_skip = false;
                    if ($ret = $this->mod_sppt->check_sppt($this->input->post('txt_id_nop_sptpd'))) {
                        $data_nik     = $this->mod_nik->get_nik($nik);
                        $token        = $this->antclass->generate_token();
                        $new_nop      = '';
                        $arr_nop      = explode('.', $this->input->post('txt_id_nop_sptpd'));
                        $kd_propinsi  = $arr_nop[0];
                        $kd_dati2     = $arr_nop[1];
                        $kd_kecamatan = $arr_nop[2];
                        $kd_kelurahan = $arr_nop[3];
                        $kd_blok      = $arr_nop[4];
                        $no_urut      = str_pad((int) $ret['urut_skr'] + 1, 4, "0", STR_PAD_LEFT);
                        $kd_jns_op    = $arr_nop[6];
                        $new_nop      = $kd_propinsi . '.' . $kd_dati2 . '.' . $kd_kecamatan . '.' . $kd_kelurahan . '.' . $kd_blok . '.' . $no_urut . '.' . $kd_jns_op;
                        $thn_pajak    = date('Y');
                        $rwrt         = explode('/', $data_nik->rtrw);
                        $rw           = trim($rwrt[0]);
                        $rt           = trim($rwrt[1]);
                        $kec          = $this->mod_kecamatan->get_kecamatan($data_nik->kd_kecamatan);

                        $kel       = $this->mod_kelurahan->get_kelurahan($data_nik->kd_kelurahan);
                        $dt2       = $this->mod_dati2->get_dati2($data_nik->kotakab);
                        $nops      = $this->mod_nop->get_nop($nop_compile);
                        $tgl_input = date('Y-m-d H:i:s');

                        // Cek luas bumi atau bangunan sama
                        if ($ret['luas_bumi'] < $luas_tanah_sptpd or $ret['luas_bng'] < $luas_bangunan_sptpd) {
                            $check_luas_skip = true;
                        } else {
                            $pbb_njop_dasar     = $nops->njop_pbb_op;
                            $pbb_njop_hitung    = $nops->njop_pbb_op - $this->config->item('conf_npoptkp_pbb');
                            $pbb_njkp           = ceil(0.2 * $pbb_njop_hitung);
                            $pbb_hutang_pbb     = ceil(0.005 * $pbb_njkp);
                            $njop_bumi          = ceil($nops->luas_tanah_op * $nops->njop_tanah_op);
                            $njop_bumi_sbgn     = ceil($luas_tanah_sptpd * $nops->njop_tanah_op);
                            $njop_bangunan      = ceil($nops->luas_bangunan_op * $nops->njop_bangunan_op);
                            $njop_bangunan_sbgn = ceil($luas_bangunan_sptpd * $nops->njop_bangunan_op);

                            $pbb_hutang_pbb_sbgn                                = $njop_bumi_sbgn + $njop_bangunan_sbgn;
                            $pbb_hutang_pbb_sbgn                                = $pbb_hutang_pbb_sbgn - $this->config->item('conf_npoptkp_pbb');
                            $pbb_hutang_pbb_sbgn                                = ceil(0.2 * $pbb_hutang_pbb_sbgn);
                            $pbb_hutang_pbb_sbgn                                = ceil(0.005 * $pbb_hutang_pbb_sbgn);
                            if ($pbb_hutang_pbb_sbgn < 0) {
                                $pbb_hutang_pbb_sbgn = 0;
                            }

                            if ($ret['luas_bumi'] > $luas_tanah_sptpd or $ret['luas_bng'] > $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $new_luas_tanah    = $ret['luas_bumi'];
                                    $new_luas_bangunan = $ret['luas_bng'];
                                    $new_njop_bumi     = $ret['njop_bumi'];
                                    $new_njop_bng      = $ret['njop_bng'];
                                    if ($ret['luas_bumi'] > $luas_tanah_sptpd) {
                                        $new_luas_tanah = $ret['luas_bumi'] - $luas_tanah_sptpd;
                                        $new_njop_bumi  = $new_luas_tanah * $nops->njop_tanah_op;
                                        if ($ret['luas_bng'] == $luas_bangunan_sptpd) {
                                            $new_luas_bangunan = 0;
                                            $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                        }
                                    }

                                    if ($ret['luas_bng'] > $luas_bangunan_sptpd) {
                                        $new_luas_bangunan = $ret['luas_bng'] - $luas_bangunan_sptpd;
                                        $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                    }

                                    $new_pbb_bayar = $new_njop_bumi + $new_njop_bng;
                                    $new_pbb_bayar = $new_pbb_bayar - $this->config->item('conf_npoptkp_pbb');
                                    $new_pbb_bayar = ceil(0.2 * $new_pbb_bayar);
                                    $new_pbb_bayar = ceil(0.005 * $new_pbb_bayar);
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_sppt->edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $arr_nop[5], $kd_jns_op, $thn_pajak, $ret['nama'], $new_luas_tanah, $new_luas_bangunan, '', '', $new_njop_bumi, $new_njop_bng, $new_pbb_bayar);

                                    $new_nop_pbb_bayar = $new_luas_tanah * $nops->njop_tanah_op;
                                    $new_nop_pbb_bayar += $new_luas_bangunan * $nops->njop_bangunan_op;
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_nop->edit_nop($nop_compile, $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $new_luas_tanah, $new_luas_bangunan, $nops->njop_tanah_op, $nops->njop_bangunan_op, $new_nop_pbb_bayar, '', '', $nops->no_sertipikat_op);

                                    $saved_nop    = str_replace('.', '', $new_nop);
                                    $nop_njop_pbb = $luas_tanah_sptpd * $nops->njop_tanah_op;
                                    $nop_njop_pbb += $luas_bangunan_sptpd * $nops->njop_bangunan_op;
                                    // Buat NOP Baru
                                    $this->mod_nop->add_nop(str_replace('.', '', $new_nop), $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $luas_tanah_sptpd, $luas_bangunan_sptpd, $nops->njop_tanah_op, $nops->njop_bangunan_op, $nop_njop_pbb, '', '', '', '');

                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $no_urut,
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $luas_tanah_sptpd,
                                        $luas_bangunan_sptpd,
                                        $njop_bumi_sbgn,
                                        $njop_bangunan_sbgn,
                                        $pbb_hutang_pbb_sbgn,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                    $this->mod_nop_log->add_nop_log(str_replace('.', '', $nop), str_replace('.', '', $new_nop), date('Y-m-d H:i:s'));
                                } else {
                                    $check_luas_skip = true;
                                    $data['info']    = err_msg('Identitas pemilik baru sama dengan pemilik lama.');
                                }
                            } elseif ($ret['luas_bumi'] == $luas_tanah_sptpd or $ret['luas_bng'] == $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $saved_nop = $nop;
                                    $new_nop   = '';
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $arr_nop[5],
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $nops->luas_tanah_op,
                                        $nops->luas_bangunan_op,
                                        $njop_bumi,
                                        $njop_bangunan,
                                        $pbb_hutang_pbb,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                }
                            }
                        }
                    }
                    if (!$check_luas_skip) {

                        // untuk inputan APHB
                        // $inp_aphb1 = @$this->input->post('inp_aphb1');
                        // $inp_aphb2 = @$this->input->post('inp_aphb2');
                        // $inp_aphb3 = $this->input->post('inp_aphb3');
                        $tanah_inp_aphb1 = @$this->input->post('tanah_inp_aphb1');
                        $tanah_inp_aphb2 = @$this->input->post('tanah_inp_aphb2');
                        $tanah_inp_aphb3 = @$this->input->post('tanah_inp_aphb3');

                        $bangunan_inp_aphb1 = @$this->input->post('bangunan_inp_aphb1');
                        $bangunan_inp_aphb2 = @$this->input->post('bangunan_inp_aphb2');
                        $bangunan_inp_aphb3 = @$this->input->post('bangunan_inp_aphb3');

                        $tanah_b_inp_aphb1 = @$this->input->post('tanah_b_inp_aphb1');
                        $tanah_b_inp_aphb2 = @$this->input->post('tanah_b_inp_aphb2');
                        $tanah_b_inp_aphb3 = @$this->input->post('tanah_b_inp_aphb3');

                        $bangunan_b_inp_aphb1 = @$this->input->post('bangunan_b_inp_aphb1');
                        $bangunan_b_inp_aphb2 = @$this->input->post('bangunan_b_inp_aphb2');
                        $bangunan_b_inp_aphb3 = @$this->input->post('bangunan_b_inp_aphb3');
                        // end untuk inputan APHB

                        //  PROSES INPUT SPTPD

                        $info = $this->mod_sptpd->edit_sptpd(
                            $id_ppat,
                            $nik,
                            $wajibpajak,
                            $nop_compile,
                            $nop_alamat,
                            $nilai_pasar,
                            $jenis_perolehan,
                            $npop,
                            $npoptkp,
                            $dasar_jml_setoran,
                            $nomor_jml_setoran,
                            $tgl_jml_setoran,
                            $hitung_sendiri_jml_setoran,
                            $custom_jml_setoran,
                            $jml_setor,
                            //date('Y-m-d H:i:s'),
                            $tanggal_pengajuan,
                            $no_dokumen,
                            $nop_pbb_baru,
                            $this->session->userdata('s_username_bphtb'),
                            $this->session->userdata('s_id_pp_bphtb'),
                            @$picture,
                            $luas_tanah_sptpd,
                            $luas_bangunan_sptpd,
                            $luas_tanah_b_sptpd,
                            $luas_bangunan_b_sptpd,
                            $njop_tanah_sptpd,
                            $njop_bangunan_sptpd,
                            $njop_tanah_b_sptpd,
                            $njop_bangunan_b_sptpd,
                            $njop_pbb_sptpd,
                            $text_no_sertifikat,
                            $text_lokasi_op,
                            $text_thn_pajak_sppt,
                            $tanah_inp_aphb1,
                            $tanah_inp_aphb2,
                            $tanah_inp_aphb3,
                            $bangunan_inp_aphb1,
                            $bangunan_inp_aphb2,
                            $bangunan_inp_aphb3,
                            $tanah_b_inp_aphb1,
                            $tanah_b_inp_aphb2,
                            $tanah_b_inp_aphb3,
                            $bangunan_b_inp_aphb1,
                            $bangunan_b_inp_aphb2,
                            $bangunan_b_inp_aphb3
                        );
                    }

                    if (@$info) {
                        $data['info'] = succ_msg('Edit SPTPD Berhasil.');

                        // CEK INPUT LAMPIRAN

                        $paramFormulir = array();

                        $paramFormulir['no_sspd']             = $no_dokumen;
                        $paramFormulir['no_formulir']         = date('Ymdhis');
                        $paramFormulir['tanggal_no_sspd']     = date('Y-m-d');
                        $paramFormulir['tanggal_no_formulir'] = date('Y-m-d');

                        $no_dokumen_file = str_replace('.', '', $no_dokumen);

                        if (@$picture != '') {
                            $x = $picture;
                            $y = explode('.', $x);
                            $z = end($y);

                            @$picture = str_replace('.' . $z, '', $x);

                            $file = $this->uploadFile('txt_picture_sptpd', @$picture, $no_dokumen_file);

                            // $paramFormulir['gambar_op'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', $no_dokumen_file . '_lampiran_sspd_1', $no_dokumen_file);

                            $paramFormulir['lampiran_sspd'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', $no_dokumen_file . '_lampiran_sppt', $no_dokumen_file);

                            $paramFormulir['lampiran_sppt'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', $no_dokumen_file . '_lampiran_fotocopi_identitas', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopi_identitas'] = $file;
                        }

                        if ($this->input->post('lampiran_surat_kuasa_wp') != '') {

                            $paramFormulir['lampiran_nama_kuasa_wp']   = $this->input->post('lampiran_nama_kuasa_wp');
                            $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', $no_dokumen_file . '_lampiran_fotocopy_identitas_kwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', $no_dokumen_file . '_lampiran_fotocopy_kartu_npwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', $no_dokumen_file . '_lampiran_fotocopy_akta_jb', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', $no_dokumen_file . '_lampiran_sertifikat_kepemilikan_tanah', $no_dokumen_file);

                            $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_fotocopy_keterangan_waris',$_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', $no_dokumen_file . '_lampiran_fotocopy_keterangan_waris', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_surat_pernyataan']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file . '_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_surat_pernyataan'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_identitas_lainya_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_identitas_lainya',$_FILES['txt_picture_lampiran_identitas_lainya_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_identitas_lainya_file', $no_dokumen_file . '_lampiran_identitas_lainya', $no_dokumen_file);

                            $paramFormulir['lampiran_identitas_lainya'] = $file;
                        }

                        // $paramFormulir['lampiran_identitas_lainya_val'] = $param['lampiran_identitas_lainya_val'];

                        // END OF CEK INPUT FORMULIR

                        // $this->db->insert('tbl_formulir_penelitian', $paramFormulir);
                        $this->db->where('no_sspd', $no_dokumen);
                        $this->db->update('tbl_formulir_penelitian', $paramFormulir);

                        // if (!empty($picture)) {
                        //     if (!read_file(base_url() . $this->config->item('img_op_path') . $picture)) {
                        //         if (!$this->antclass->go_upload('txt_picture_sptpd', $this->config->item('img_op_path'), 'jpg|gif|png|pdf|doc|docx')) {
                        //             $data['info'] .= err_msg('Upload gambar objek pajak gagal!');
                        //         }
                        //     } else {
                        //         $data['info'] .= err_msg('Upload gambar objek pajak gagal! Gambar objek pajak dengan nama sama sudah ada.');
                        //     }
                        // }

                        if (!empty($new_nop)) {
                            $data['info'] .= '<div class="new_nop">NOP Baru: <b>' . $new_nop . '</b></div>';
                        }
                        $data['info'] .= '';
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
                    } else {
                        $data['info'] .= err_msg('Input SPTPD Gagal.');
                    }
                } else {
                    $data['info'] = err_msg('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
                }
            }
        }

        $data['propinsis']       = $this->mod_propinsi->get_propinsi();
        $data['jenis_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['rekening']        = $this->mod_rekening->get_rekening(1);
        $data['prefix']          = $this->mod_prefix->get_prefix();
        $data['niks']            = $this->mod_nik->get_nik();
        // $data['nops'] = $this->mod_nop->get_nop();
        $data['cek_transaksi_prev']  = '';
        // $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd($id_sptpd);

        $data['c_loc']              = $this->c_loc;

        $data['submitvalue'] = 'Simpan';
        $data['rec_id']      = '';

        $no_dokumen       = $data['sptpd']->no_dokumen;
        $data['lampiran'] = $this->mod_sptpd->get_lampiran($no_dokumen);
        //GENIO
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        // var_dump($data['lampiran']->lampiran_sspd);exit();
        // echo "<pre>";
        // print_r($data['lampiran']);exit;

        $this->antclass->skin('v_sptpdform_edit', $data);
    }

    public function edit_sptpd_wp($id_sptpd)
    {
        $data['file_upload'] = null;
        $data['no_sspd']     = null;
        $data['id']          = $id_sptpd;
        $data['sptpd']       = $this->mod_sptpd->get_sptpd($id_sptpd);
        $data['sspd_no']     = $this->mod_sptpd->get_sspd_no($id_sptpd);
        // echo  $data['sspd_no']->no_dokumen;exit();

        $data['nop'] =  $data['sptpd']->kd_propinsi . '.' .
            $data['sptpd']->kd_kabupaten . '.' .
            $data['sptpd']->kd_kecamatan . '.' .
            $data['sptpd']->kd_kelurahan . '.' .
            $data['sptpd']->kd_blok . '.' .
            $data['sptpd']->no_urut . '.' .
            $data['sptpd']->kd_jns_op;

        if ($data['sptpd']) {
            $data['file_upload'] = $this->mod_sptpd->get_fileUpload($data['sptpd']->no_dokumen);
            $data['no_sspd']     = $data['sptpd']->no_dokumen;
        }

        $data['nik'] = $this->mod_sptpd->get_nik_detail($data['sptpd']->nik);

        $data['txt_kd_dati2_selected']     = @$data['nik']->kd_kabupaten;
        $data['txt_kd_kecamatan_selected'] = @$data['nik']->kd_kecamatan;
        $data['txt_kd_kelurahan_selected'] = @$data['nik']->kd_kelurahan;

        $array = array(
            // nik
            's_nik_nik'                          => $this->input->post('txt_id_nik_sptpd'),
            's_nama_nik'                         => $this->input->post('nama_nik_name'),
            's_alamat_nik'                       => $this->input->post('alamat_nik_name'),
            's_propinsi_nik'                     => $this->input->post('propinsi_nik_name'),
            's_kd_dati2_nik'                     => $this->input->post('kotakab_nik_name'),
            's_kd_kecamatan_nik'                 => $this->input->post('kecamatan_nik_name'),
            's_kd_kelurahan_nik'                 => $this->input->post('kelurahan_nik_name'),
            's_rtrw_nik'                         => $this->input->post('rtrw_nik_name'),
            's_kodepos_nik'                      => $this->input->post('kodepos_nik_name'),

            // nop
            's_txt_id_nop_sptpd'                 => $this->input->post('txt_id_nop_sptpd'),

            // lampiran
            's_txt_picture_lampiran_sspd_1_file' => $this->input->post('txt_picture_lampiran_sspd_1_file'),
        );

        $this->session->set_userdata($array);

        if ($this->input->post('submit')) {

            $data['info'] = '';
            $this->load->library('form_validation');
            $ident = $this->input->post('ident');
            //hilangi nama_ppat_id
            //jilangi txt_id_ppat_sptpd
            //$this->form_validation->set_rules('txt_id_ppat_sptpd', 'ID PPAT', 'required|xss_clean');
            $this->form_validation->set_rules('txt_id_nik_sptpd', 'NIK', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_id_nop_sptpd', 'NOP', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_nilai_pasar_sptpd', 'Nilai Pasar', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txt_npop_sptpd', 'NPOP', 'required|trim');
            $this->form_validation->set_rules('txt_jml_setor_sptpd', 'Jumlah yang disetor', 'required|numeric|trim');
            $this->form_validation->set_rules('txt_jns_perolehan_sptpd', 'Jenis Perolehan', 'trim|required');
            if ($ident != '') {
                $this->form_validation->set_rules('nama_nik_name', 'Nama', 'required|trim');
                $this->form_validation->set_rules('alamat_nik_name', 'Alamat', 'required|trim');
                $this->form_validation->set_rules('propinsi_nik_name', 'Propinsi', 'required|trim');
                $this->form_validation->set_rules('kotakab_nik_name', 'Kabupaten / Kota', 'required|trim');
                $this->form_validation->set_rules('kecamatan_nik_name', 'Kecamatan', 'required|trim');
                $this->form_validation->set_rules('kelurahan_nik_name', 'Kelurahan', 'required|trim');
                $this->form_validation->set_rules('rtrw_nik_name', 'RT / RW', 'trim');
                $this->form_validation->set_rules('kodepos_nik_name', 'Kode Pos', 'trim');
            }
            if ($this->form_validation->run() == false) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $nik_nik          = $this->input->post('txt_id_nik_sptpd');
                $nama_nik         = $this->input->post('nama_nik_name');
                $alamat_nik       = $this->input->post('alamat_nik_name');
                $propinsi_nik     = $this->input->post('propinsi_nik_name');
                $kd_dati2_nik     = $this->input->post('kotakab_nik_name');
                $kd_kecamatan_nik = $this->input->post('kecamatan_nik_name');
                $kd_kelurahan_nik = $this->input->post('kelurahan_nik_name');
                $rtrw_nik         = $this->input->post('rtrw_nik_name');
                $kodepos_nik      = $this->input->post('kodepos_nik_name');

                if ($ident != '') {
                    $hitung = $this->mod_nik->ceknik($nik_nik);
                    if (!empty($hitung)) {
                        $data['info'] = err_msg('NIK Sudah Ada.');
                    } else {
                        $info = $this->mod_nik->add_nik(
                            $nik_nik,
                            $nama_nik,
                            $alamat_nik,
                            $propinsi_nik,
                            $kd_dati2_nik,
                            $kd_kecamatan_nik,
                            $kd_kelurahan_nik,
                            $rtrw_nik,
                            $kodepos_nik
                        );
                    }
                }

                $unique_code = $this->antclass->get_unique_code(5);
                $id_ppat     = $this->session->userdata('s_id_ppat');
                $nik         = $this->input->post('txt_id_nik_sptpd');
                $wajibpajak   = $data['sptpd']->wajibpajak;
                $nop = $this->antclass->remove_separator($this->input->post('txt_id_nop_sptpd'));
                // pemecahan nop
                $kd_propinsi  = substr($nop, 0, 2);
                $kd_kabupaten = substr($nop, 2, 2);
                $kd_kecamatan = substr($nop, 4, 3);
                $kd_kelurahan = substr($nop, 7, 3);
                $kd_blok      = substr($nop, 10, 3);
                $no_urut      = substr($nop, 13, 4);
                $kd_jns_op    = substr($nop, 17, 1);
                $nop_compile  = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

                //str replace alamat nop
                $nop_alamat_filter   = @$this->input->post('alamat_nop_id');
                $nop_alamat          = str_replace("'", "`", $nop_alamat_filter);

                //inputan nop
                $nopsave_lokasi           = $this->input->post('nopsave_letak_tanah');
                $nopsave_kd_dati2_nop     = $kd_kabupaten;
                $nopsave_kd_kecamatan_nop = $kd_kecamatan;
                $nopsave_kd_kelurahan_nop = $kd_kelurahan;
                $nopsave_rtrw             = $this->input->post('nopsave_rtrw');
                $nopsave_luas_tanah       = $this->input->post('nopsave_luas_tanah');
                $nopsave_njop_tanah       = $this->input->post('nopsave_njop_tanah');
                $nopsave_luas_bangunan    = $this->input->post('nopsave_luas_bangunan');
                $nopsave_njop_bangunan    = $this->input->post('nopsave_njop_bangunan');
                $nopsave_njop_pbb         = $this->input->post('nopsave_njop');
                $nopsave_kd_propinsi_op   = $kd_propinsi;
                $nopsave_no_sertipikat    = $this->input->post('nopsave_no_serf');
                $nopsave_thn_pajak_sppt   = $this->input->post('nopsave_thnpjk');
                $nopsave_ident            = $this->input->post('status_pencarian_nop');

                $nopsave_propinsi  = $this->input->post('nopsave_propinsi');
                $nopsave_kabupaten = $this->input->post('nopsave_kabupaten');
                $nopsave_kecamatan = $this->input->post('nopsave_kecamatan');
                $nopsave_kelurahan = $this->input->post('nopsave_kelurahan');
                $nopsave_ref_tanah           = $this->input->post('ref_tanah');
                $nopsave_ref_bangunan        = $this->input->post('ref_bangunan');
                $param_nop['nama_penjual']   = $this->input->post('nama_penjual');
                $param_nop['alamat_penjual'] = $this->input->post('alamat_penjual');

                //19082021
                $tanggal_pengajuan = $this->input->post('tanggal_pengajuan_name');

                //add nop
                if ($nopsave_ident == 'dari sismiop') {
                    $this->mod_nop->edit_service_nop(
                        $nop_compile,
                        $nopsave_lokasi,
                        $nopsave_kd_kelurahan_nop,
                        $nopsave_rtrw,
                        $nopsave_kd_kecamatan_nop,
                        $nopsave_kd_dati2_nop,
                        $nopsave_luas_tanah,
                        $nopsave_luas_bangunan,
                        $nopsave_njop_tanah,
                        $nopsave_njop_bangunan,
                        $nopsave_njop_pbb,
                        '',
                        '',
                        $nopsave_no_sertipikat,
                        $nopsave_kd_propinsi_op,
                        $nopsave_thn_pajak_sppt,
                        $nopsave_ref_tanah,
                        $nopsave_ref_bangunan,
                        $param_nop
                    );
                    //input propinsi
                    $check_prop = $this->mod_propinsi->get_propinsi($kd_propinsi);
                    if (count($check_prop) == 0) {
                        $this->mod_propinsi->add_propinsi($kd_propinsi, $nopsave_propinsi);
                    }
                    //input kabupaten
                    $check_kab = $this->mod_dati2->get_dati2($kd_kabupaten, '', $kd_propinsi);
                    if (count($check_kab) == 0) {
                        $this->mod_dati2->add_dati2($kd_propinsi, $kd_kabupaten, $nopsave_kabupaten);
                    }
                    //input kecamatan
                    $check_kec = $this->mod_kecamatan->get_kecamatan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan);

                    if (count($check_kec) == 0) {
                        $this->mod_kecamatan->add_kecamatan($kd_kecamatan, $nopsave_kecamatan, $kd_propinsi, $kd_kabupaten);
                    }
                    //input kelurahan
                    $check_kel = $this->mod_kelurahan->get_kelurahan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan);

                    if (count($check_kel) == 0) {
                        $this->mod_kelurahan->add_kelurahan($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $nopsave_kelurahan);
                    }
                }

                $luas_tanah_sptpd    = $this->input->post('txt_luas_tanah_sptpd');
                $luas_bangunan_sptpd = $this->input->post('txt_luas_bangunan_sptpd');
                $luas_tanah_b_sptpd  = $this->input->post('txt_luas_tanah_b_sptpd');
                $luas_bangunan_b_sptpd  = $this->input->post('txt_luas_bangunan_b_sptpd');
                $njop_tanah_sptpd    = str_replace('.', '', $this->input->post('txt_njop_tanah_sptpd'));
                $njop_bangunan_sptpd = str_replace('.', '', $this->input->post('txt_njop_bangunan_sptpd'));
                $njop_tanah_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_tanah_b_sptpd'));
                $njop_bangunan_b_sptpd  = str_replace('.', '', $this->input->post('txt_njop_bangunan_b_sptpd'));
                $njop_pbb_sptpd      = $this->input->post('txt_njop_pbb_h_sptpd');
                $text_no_sertifikat  = $this->input->post('txt_no_sertifikat_op');

                $text_lokasi_op      = $this->input->post('text_lokasi_op');
                $text_thn_pajak_sppt = $this->input->post('text_thn_pajak_sppt');

                $nilai_pasar        = str_replace('.', '', $this->input->post('txt_nilai_pasar_sptpd'));
                $jenis_perolehan    = $this->input->post('txt_jns_perolehan_sptpd');
                $npop               = str_replace('.', '', $this->input->post('txt_npop_sptpd'));
                $npoptkp            = str_replace('.', '', $this->input->post('txt_npoptkp_sptpd'));
                $dasar_jml_setoran  = $this->input->post('txt_dasar_jml_setoran_sptpd');
                $bea_terhutang      = $this->input->post('txt_bea_perolehan_sptpd');
                $bea_bayar          = $this->input->post('txt_bea_bayar_sptpd');
                $nomor_jml_setoran  = '';
                $tgl_jml_setoran    = '';
                $custom_jml_setoran = '';
                if ($dasar_jml_setoran == 'PWP') {
                    $nomor_jml_setoran = '';
                    $tgl_jml_setoran   = '';
                } elseif ($dasar_jml_setoran == 'STB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_stb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_stb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKB') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkb_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkb_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                } elseif ($dasar_jml_setoran == 'SKBKBT') {
                    $nomor_jml_setoran  = $this->input->post('txt_nomor_skbkbt_sptpd');
                    $tgl_jml_setoran    = $this->input->post('txt_tanggal_skbkbt_sptpd');
                    $custom_jml_setoran = $this->input->post('txt_custom_setoran_sptpd');
                }

                $hitung_sendiri_jml_setoran = $this->input->post('txt_hitung_sendiri_sptpd');
                $jml_setor                  = $this->input->post('txt_jml_setor_sptpd');
                //$no_dokumen = $this->input->post('txt_no_dokumen_sptpd');
                $autonum     = '0001';
                $cur_autonum = '';
                $get_autonum = $this->mod_sptpd->get_last_autonum2();
                foreach ($get_autonum as $getnum) {
                    $cur_autonum = $getnum->nodok;
                }
                if ($cur_autonum != '') {
                    // $autonum = substr($cur_autonum, 11, 4);
                    // $autonum = (int) $autonum;
                    // $autonum += $autonum;
                    $autonum = str_pad($cur_autonum, 4, '0', STR_PAD_LEFT);
                }

                $no_dokumen = $this->input->post('nomor_dokumen');
                //echo $no_dokumen;exit;
                $nop_pbb_baru = $this->input->post('txt_nop_pbb_baru_sptpd');
                $saved_nop    = $nop;
                // $kode_validasi = $this->antclass->add_nop_separator($nop).'-'.date('Ymd').'-'.$jml_setor.'-'.$unique_code;
                $kode_validasi = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_jns_perolehan_sptpd');

                // $picture                                                    = '';
                if ($_FILES['txt_picture_sptpd']['name'] != '') {
                    $picture = str_replace(' ', '_', $_FILES['txt_picture_sptpd']['name']);
                }

                // Jumlah setor lebih atau sama dari Bea Perolehan Yang Terutang
                if ($bea_bayar <= $jml_setor or $dasar_jml_setoran == 'SKBKB' or $dasar_jml_setoran == "SKBKBT") {
                    $check_luas_skip = false;
                    if ($ret = $this->mod_sppt->check_sppt($this->input->post('txt_id_nop_sptpd'))) {
                        $data_nik     = $this->mod_nik->get_nik($nik);
                        $token        = $this->antclass->generate_token();
                        $new_nop      = '';
                        $arr_nop      = explode('.', $this->input->post('txt_id_nop_sptpd'));
                        $kd_propinsi  = $arr_nop[0];
                        $kd_dati2     = $arr_nop[1];
                        $kd_kecamatan = $arr_nop[2];
                        $kd_kelurahan = $arr_nop[3];
                        $kd_blok      = $arr_nop[4];
                        $no_urut      = str_pad((int) $ret['urut_skr'] + 1, 4, "0", STR_PAD_LEFT);
                        $kd_jns_op    = $arr_nop[6];
                        $new_nop      = $kd_propinsi . '.' . $kd_dati2 . '.' . $kd_kecamatan . '.' . $kd_kelurahan . '.' . $kd_blok . '.' . $no_urut . '.' . $kd_jns_op;
                        $thn_pajak    = date('Y');
                        $rwrt         = explode('/', $data_nik->rtrw);
                        $rw           = trim($rwrt[0]);
                        $rt           = trim($rwrt[1]);
                        $kec          = $this->mod_kecamatan->get_kecamatan($data_nik->kd_kecamatan);

                        $kel       = $this->mod_kelurahan->get_kelurahan($data_nik->kd_kelurahan);
                        $dt2       = $this->mod_dati2->get_dati2($data_nik->kotakab);
                        $nops      = $this->mod_nop->get_nop($nop_compile);
                        $tgl_input = date('Y-m-d H:i:s');

                        // Cek luas bumi atau bangunan sama
                        if ($ret['luas_bumi'] < $luas_tanah_sptpd or $ret['luas_bng'] < $luas_bangunan_sptpd) {
                            $check_luas_skip = true;
                        } else {
                            $pbb_njop_dasar     = $nops->njop_pbb_op;
                            $pbb_njop_hitung    = $nops->njop_pbb_op - $this->config->item('conf_npoptkp_pbb');
                            $pbb_njkp           = ceil(0.2 * $pbb_njop_hitung);
                            $pbb_hutang_pbb     = ceil(0.005 * $pbb_njkp);
                            $njop_bumi          = ceil($nops->luas_tanah_op * $nops->njop_tanah_op);
                            $njop_bumi_sbgn     = ceil($luas_tanah_sptpd * $nops->njop_tanah_op);
                            $njop_bangunan      = ceil($nops->luas_bangunan_op * $nops->njop_bangunan_op);
                            $njop_bangunan_sbgn = ceil($luas_bangunan_sptpd * $nops->njop_bangunan_op);

                            $pbb_hutang_pbb_sbgn                                = $njop_bumi_sbgn + $njop_bangunan_sbgn;
                            $pbb_hutang_pbb_sbgn                                = $pbb_hutang_pbb_sbgn - $this->config->item('conf_npoptkp_pbb');
                            $pbb_hutang_pbb_sbgn                                = ceil(0.2 * $pbb_hutang_pbb_sbgn);
                            $pbb_hutang_pbb_sbgn                                = ceil(0.005 * $pbb_hutang_pbb_sbgn);
                            if ($pbb_hutang_pbb_sbgn < 0) {
                                $pbb_hutang_pbb_sbgn = 0;
                            }

                            if ($ret['luas_bumi'] > $luas_tanah_sptpd or $ret['luas_bng'] > $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $new_luas_tanah    = $ret['luas_bumi'];
                                    $new_luas_bangunan = $ret['luas_bng'];
                                    $new_njop_bumi     = $ret['njop_bumi'];
                                    $new_njop_bng      = $ret['njop_bng'];
                                    if ($ret['luas_bumi'] > $luas_tanah_sptpd) {
                                        $new_luas_tanah = $ret['luas_bumi'] - $luas_tanah_sptpd;
                                        $new_njop_bumi  = $new_luas_tanah * $nops->njop_tanah_op;
                                        if ($ret['luas_bng'] == $luas_bangunan_sptpd) {
                                            $new_luas_bangunan = 0;
                                            $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                        }
                                    }

                                    if ($ret['luas_bng'] > $luas_bangunan_sptpd) {
                                        $new_luas_bangunan = $ret['luas_bng'] - $luas_bangunan_sptpd;
                                        $new_njop_bng      = $new_luas_tanah * $nops->njop_tanah_op;
                                    }

                                    $new_pbb_bayar = $new_njop_bumi + $new_njop_bng;
                                    $new_pbb_bayar = $new_pbb_bayar - $this->config->item('conf_npoptkp_pbb');
                                    $new_pbb_bayar = ceil(0.2 * $new_pbb_bayar);
                                    $new_pbb_bayar = ceil(0.005 * $new_pbb_bayar);
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_sppt->edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $arr_nop[5], $kd_jns_op, $thn_pajak, $ret['nama'], $new_luas_tanah, $new_luas_bangunan, '', '', $new_njop_bumi, $new_njop_bng, $new_pbb_bayar);

                                    $new_nop_pbb_bayar = $new_luas_tanah * $nops->njop_tanah_op;
                                    $new_nop_pbb_bayar += $new_luas_bangunan * $nops->njop_bangunan_op;
                                    // Ubah ukuran luas bumi / bangunan
                                    $this->mod_nop->edit_nop($nop_compile, $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $new_luas_tanah, $new_luas_bangunan, $nops->njop_tanah_op, $nops->njop_bangunan_op, $new_nop_pbb_bayar, '', '', $nops->no_sertipikat_op);

                                    $saved_nop    = str_replace('.', '', $new_nop);
                                    $nop_njop_pbb = $luas_tanah_sptpd * $nops->njop_tanah_op;
                                    $nop_njop_pbb += $luas_bangunan_sptpd * $nops->njop_bangunan_op;
                                    // Buat NOP Baru
                                    $this->mod_nop->add_nop(str_replace('.', '', $new_nop), $nops->lokasi_op, $nops->kelurahan_op, $nops->rtrw_op, $nops->kecamatan_op, $nops->kotakab_op, $luas_tanah_sptpd, $luas_bangunan_sptpd, $nops->njop_tanah_op, $nops->njop_bangunan_op, $nop_njop_pbb, '', '', '', '');

                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $no_urut,
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $luas_tanah_sptpd,
                                        $luas_bangunan_sptpd,
                                        $njop_bumi_sbgn,
                                        $njop_bangunan_sbgn,
                                        $pbb_hutang_pbb_sbgn,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                    $this->mod_nop_log->add_nop_log(str_replace('.', '', $nop), str_replace('.', '', $new_nop), date('Y-m-d H:i:s'));
                                } else {
                                    $check_luas_skip = true;
                                    $data['info']    = err_msg('Identitas pemilik baru sama dengan pemilik lama.');
                                }
                            } elseif ($ret['luas_bumi'] == $luas_tanah_sptpd or $ret['luas_bng'] == $luas_bangunan_sptpd) {
                                if ($ret['nama'] != $data_nik->nama) {
                                    $saved_nop = $nop;
                                    $new_nop   = '';
                                    $this->mod_sppt->add_sppt(
                                        $kd_propinsi,
                                        $kd_dati2,
                                        $kd_kecamatan,
                                        $kd_kelurahan,
                                        $kd_blok,
                                        $arr_nop[5],
                                        $kd_jns_op,
                                        $thn_pajak,
                                        $data_nik->nama,
                                        $data_nik->alamat,
                                        $rw,
                                        $rt,
                                        $kec->nama,
                                        $kel->nama,
                                        $dt2->nama,
                                        $nops->luas_tanah_op,
                                        $nops->luas_bangunan_op,
                                        $njop_bumi,
                                        $njop_bangunan,
                                        $pbb_hutang_pbb,
                                        $nik,
                                        $token,
                                        $tgl_input
                                    );
                                }
                            }
                        }
                    }
                    if (!$check_luas_skip) {

                        // untuk inputan APHB
                        // $inp_aphb1 = @$this->input->post('inp_aphb1');
                        // $inp_aphb2 = @$this->input->post('inp_aphb2');
                        // $inp_aphb3 = $this->input->post('inp_aphb3');
                        $tanah_inp_aphb1 = @$this->input->post('tanah_inp_aphb1');
                        $tanah_inp_aphb2 = @$this->input->post('tanah_inp_aphb2');
                        $tanah_inp_aphb3 = @$this->input->post('tanah_inp_aphb3');

                        $bangunan_inp_aphb1 = @$this->input->post('bangunan_inp_aphb1');
                        $bangunan_inp_aphb2 = @$this->input->post('bangunan_inp_aphb2');
                        $bangunan_inp_aphb3 = @$this->input->post('bangunan_inp_aphb3');

                        $tanah_b_inp_aphb1 = @$this->input->post('tanah_b_inp_aphb1');
                        $tanah_b_inp_aphb2 = @$this->input->post('tanah_b_inp_aphb2');
                        $tanah_b_inp_aphb3 = @$this->input->post('tanah_b_inp_aphb3');

                        $bangunan_b_inp_aphb1 = @$this->input->post('bangunan_b_inp_aphb1');
                        $bangunan_b_inp_aphb2 = @$this->input->post('bangunan_b_inp_aphb2');
                        $bangunan_b_inp_aphb3 = @$this->input->post('bangunan_b_inp_aphb3');
                        // end untuk inputan APHB

                        //  PROSES INPUT SPTPD

                        $info = $this->mod_sptpd->edit_sptpd_wp(
                            $id_ppat,
                            $nik,
                            $wajibpajak,
                            $nop_compile,
                            $nop_alamat,
                            $nilai_pasar,
                            $jenis_perolehan,
                            $npop,
                            $npoptkp,
                            $dasar_jml_setoran,
                            $nomor_jml_setoran,
                            $tgl_jml_setoran,
                            $hitung_sendiri_jml_setoran,
                            $custom_jml_setoran,
                            $jml_setor,
                            //date('Y-m-d H:i:s'),
                            $tanggal_pengajuan,
                            $no_dokumen,
                            $nop_pbb_baru,
                            $this->session->userdata('s_username_bphtb'),
                            $this->session->userdata('s_id_pp_bphtb'),
                            @$picture,
                            $luas_tanah_sptpd,
                            $luas_bangunan_sptpd,
                            $luas_tanah_b_sptpd,
                            $luas_bangunan_b_sptpd,
                            $njop_tanah_sptpd,
                            $njop_bangunan_sptpd,
                            $njop_tanah_b_sptpd,
                            $njop_bangunan_b_sptpd,
                            $njop_pbb_sptpd,
                            $text_no_sertifikat,
                            $text_lokasi_op,
                            $text_thn_pajak_sppt,
                            $tanah_inp_aphb1,
                            $tanah_inp_aphb2,
                            $tanah_inp_aphb3,
                            $bangunan_inp_aphb1,
                            $bangunan_inp_aphb2,
                            $bangunan_inp_aphb3,
                            $tanah_b_inp_aphb1,
                            $tanah_b_inp_aphb2,
                            $tanah_b_inp_aphb3,
                            $bangunan_b_inp_aphb1,
                            $bangunan_b_inp_aphb2,
                            $bangunan_b_inp_aphb3
                        );
                    }

                    if (@$info) {
                        $data['info'] = succ_msg('Input SPTPD Berhasil.');

                        // CEK INPUT LAMPIRAN

                        $paramFormulir = array();

                        $paramFormulir['no_sspd']             = $no_dokumen;
                        $paramFormulir['no_formulir']         = date('Ymdhis');
                        $paramFormulir['tanggal_no_sspd']     = date('Y-m-d');
                        $paramFormulir['tanggal_no_formulir'] = date('Y-m-d');

                        $no_dokumen_file = str_replace('.', '', $no_dokumen);

                        if (@$picture != '') {
                            $x = $picture;
                            $y = explode('.', $x);
                            $z = end($y);

                            @$picture = str_replace('.' . $z, '', $x);

                            $file = $this->uploadFile('txt_picture_sptpd', @$picture, $no_dokumen_file);

                            // $paramFormulir['gambar_op'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', $no_dokumen_file . '_lampiran_sspd_1', $no_dokumen_file);

                            $paramFormulir['lampiran_sspd'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', $no_dokumen_file . '_lampiran_sppt', $no_dokumen_file);

                            $paramFormulir['lampiran_sppt'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', $no_dokumen_file . '_lampiran_fotocopi_identitas', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopi_identitas'] = $file;
                        }

                        if ($this->input->post('lampiran_surat_kuasa_wp') != '') {

                            $paramFormulir['lampiran_nama_kuasa_wp']   = $this->input->post('lampiran_nama_kuasa_wp');
                            $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', $no_dokumen_file . '_lampiran_fotocopy_identitas_kwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', $no_dokumen_file . '_lampiran_fotocopy_kartu_npwp', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', $no_dokumen_file . '_lampiran_fotocopy_akta_jb', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', $no_dokumen_file . '_lampiran_sertifikat_kepemilikan_tanah', $no_dokumen_file);

                            $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_fotocopy_keterangan_waris',$_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', $no_dokumen_file . '_lampiran_fotocopy_keterangan_waris', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_surat_pernyataan']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file . '_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file);

                            $paramFormulir['lampiran_fotocopy_surat_pernyataan'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_identitas_lainya_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_identitas_lainya',$_FILES['txt_picture_lampiran_identitas_lainya_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_identitas_lainya_file', $no_dokumen_file . '_lampiran_identitas_lainya', $no_dokumen_file);

                            $paramFormulir['lampiran_identitas_lainya'] = $file;
                        }

                        // $paramFormulir['lampiran_identitas_lainya_val'] = $param['lampiran_identitas_lainya_val'];

                        // END OF CEK INPUT FORMULIR

                        // $this->db->insert('tbl_formulir_penelitian', $paramFormulir);
                        $this->db->where('no_sspd', $no_dokumen);
                        $this->db->update('tbl_formulir_penelitian', $paramFormulir);

                        // if (!empty($picture)) {
                        //     if (!read_file(base_url() . $this->config->item('img_op_path') . $picture)) {
                        //         if (!$this->antclass->go_upload('txt_picture_sptpd', $this->config->item('img_op_path'), 'jpg|gif|png|pdf|doc|docx')) {
                        //             $data['info'] .= err_msg('Upload gambar objek pajak gagal!');
                        //         }
                        //     } else {
                        //         $data['info'] .= err_msg('Upload gambar objek pajak gagal! Gambar objek pajak dengan nama sama sudah ada.');
                        //     }
                        // }

                        if (!empty($new_nop)) {
                            $data['info'] .= '<div class="new_nop">NOP Baru: <b>' . $new_nop . '</b></div>';
                        }
                        $data['info'] .= '';
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
                    } else {
                        $data['info'] .= err_msg('Input SPTPD Gagal.');
                    }
                } else {
                    $data['info'] = err_msg('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
                }
            }
        }

        $data['propinsis']       = $this->mod_propinsi->get_propinsi();
        $data['jenis_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['rekening']        = $this->mod_rekening->get_rekening(1);
        $data['prefix']          = $this->mod_prefix->get_prefix();
        $data['niks']            = $this->mod_nik->get_nik();
        // $data['nops'] = $this->mod_nop->get_nop();
        $data['cek_transaksi_prev']  = '';
        // $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd($id_sptpd);

        $data['c_loc']              = $this->c_loc;

        $data['submitvalue'] = 'Simpan';
        $data['rec_id']      = '';

        $no_dokumen       = $data['sptpd']->no_dokumen;
        $data['lampiran'] = $this->mod_sptpd->get_lampiran($no_dokumen);
        // var_dump($data['lampiran']->lampiran_sspd);exit();
        // echo "<pre>";
        // print_r($data['lampiran']);exit;

        $this->antclass->skin('v_sptpdform_edit_wp', $data);
    }

    public function download_file($name = '')
    {
        $url = 'assets/files/penelitian/' . $name;
        force_download($name, $url);
    }

    public function get_kelurahan_bykecamatan()
    {
        $kd_propinsi           = $this->input->post('kd_propinsi');
        $kd_kabupaten          = $this->input->post('kd_kabupaten');
        $kd_kecamatan          = $this->input->post('kecamatan_id');
        // $kd_kelurahan_selected = $this->input->post('idkel_selected');
        $datas                 = $this->mod_kelurahan->get_kecamatan_sppt_form($kd_propinsi, $kd_kabupaten, $kd_kecamatan);
        // echo 'kd_kecamatan = ' . $kd_kecamatan . 'kd_kelurahan = ' . $kd_kelurahan_selected;
        // print_r($data);exit;
        // echo $this->db->last_query(); exit;
        if ($datas) {
            foreach ($datas as $data) {
                // if ($kd_kelurahan_selected == $data->kd_kelurahan) {
                //     $selected = 'selected';
                // } else {
                //     $selected = '';
                // }

                echo '<option value="' . $data->kd_kelurahan . '" >' . $data->kd_kelurahan . ' - ' . $data->nama . '</option>';
            }
        } else {
            echo 'no';
        }
    }

    public function edit_by_ppat($id_sptpd)
    {
        $this->load->library('form_validation');

        $data['txt_id_nik_sptpd'] = $this->input->post('txt_id_nik_sptpd');
        $data['nama_nik_name']    = $this->input->post('nama_nik_name');
        $data['alamat_nik_name']  = $this->input->post('alamat_nik_name');

        $data['txt_luas_tanah_sptpd']    = $this->input->post('txt_luas_tanah_sptpd');
        $data['txt_luas_bangunan_sptpd'] = $this->input->post('txt_luas_bangunan_sptpd');

        $data['txt_njop_pbb_h_sptpd'] = $this->input->post('txt_njop_pbb_h_sptpd');
        // echo "<pre>";
        // print_r($data);exit;

        // $proses = $this->mod_sptpd->edit_by_ppat($id_sptpd, $data);
        // echo "<pre>";
        // print_r($proses);exit;

        if ($data) {
            $this->form_validation->set_rules('nama_nik_name', 'nama_nik_name', 'trim|required', array('required' => 'Anda harus mengisi %s.'));
            $this->form_validation->set_rules('alamat_nik_name', 'alamat', 'trim|required', array('required' => 'Anda harus mengisi %s.'));
            $this->form_validation->set_rules('txt_luas_tanah_sptpd', 'txt_luas_tanah_sptpd', 'trim|numeric|required', array('required' => 'Anda harus mengisi %s.'));
            $this->form_validation->set_rules('txt_luas_bangunan_sptpd', 'txt_luas_bangunan_sptpd', 'trim|required|numeric', array('required' => 'Anda harus mengisi %s.'));
            $this->form_validation->set_rules('txt_njop_pbb_h_sptpd', 'txt_njop_pbb_h_sptpd', 'trim|required|numeric', array('required' => 'Anda harus mengisi %s.'));

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('info', err_msg(validation_errors()));
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $proses = $this->mod_sptpd->edit_by_ppat($id_sptpd, $data);
                if ($proses > 0) {
                    $data['info'] = '';
                    $this->session->set_flashdata('info', succ_msg('Berhasil mengupdate data.'));
                    redirect($this->c_loc, @$data);
                } else {
                    $data['info'] = '';
                    $this->session->set_flashdata('info', err_msg('Gagal mengupdate data.'));
                    redirect($this->c_loc, @$data);
                }
                // $data['info'] = '';
                // redirect($this->c_loc, @$data);
            }
        } else {
            show_404();
        }

        // $data_post = $this->input->post();
        // var_dump($data_post);
        // echo "<pre>";
        // print_r($data_post);exit;
    }

    public function get_history_pembayaran()
    {

        $nop = $this->input->get('nop');

        $url_history_pembayaran = $this->config->item('url_service_history_pembayaran') . $nop;

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => $url_history_pembayaran,
            CURLOPT_USERAGENT      => 'Codular Sample cURL Request',
        ));
        // Send the request & save response to $resp
        $resp = json_decode(curl_exec($curl));

        // Close request to clear up some resources
        curl_close($curl);

        $data['list_history'] = @$resp->data;

        echo $this->load->view('list_history_pembayaran', $data);
    }

    public function cetak_buktipendaftaran()
    {
        // echo '<body onload="window.print()">';
        $id            = $this->input->post('id');
        $data['id']    = $this->input->post('id');
        $data['c_loc'] = $this->c_loc;
        $data['sptpd'] = $this->mod_sptpd->getall_sptpd($id);

        $data['ppat'] = $this->mod_sptpd->get_ppat($data['sptpd']->id_ppat);
        $data['nik']  = $this->mod_nik->get_nik($data['sptpd']->nik);
        $this->load->view('v_buktipendaftaran', $data, false);
    }

    public function detail_rejek()
    {

        $id            = $this->input->post('id_sptpd');
        $data['id']    = $id;
        $data['c_loc'] = $this->c_loc;
        $data['sptpd'] = $this->mod_sptpd->getall_sptpd($id);

        $data['ppat'] = $this->mod_sptpd->get_ppat($data['sptpd']->id_ppat);
        $data['nik']  = $this->mod_nik->get_nik($data['sptpd']->nik);

        $this->load->view('v_detail_rejek', $data, false);
    }

    public function get_notif()
    {
        $data = $this->mod_sptpd->get_notif();

        echo $data;
    }

    public function get_notif2()
    {
        $data = $this->mod_sptpd->get_notif2();

        echo $data;
    }

    public function updateNotif($id = '')
    {
        $proses = $this->mod_sptpd->updateNotif($id);
    }

    function writetext($strprn, $makskolom)
    {
        $panjangstrorig = strlen($strprn);
        $buffstr = "";
        for ($i = 0; $i <= ($panjangstrorig / $makskolom); $i++) {
            $buffstr = $buffstr ./*"<br>".*/ substr($strprn, ($i * $makskolom), $makskolom);
            //if ($i <> (($panjangstrorig/$makskolom)-1)) {
            $buffstr = $buffstr . chr(13) . chr(10);
            //}
        }
        return $buffstr;
    }


    /*Ori
	    public function cek_progressif()
    {
        $nik    = $this->input->post('nik');
        //$jenis  = $this->input->post('jenis');

        $cek = $this->mod_sptpd->cek_progressif($nik, $jenis);

        echo $cek;
    }*/

    public function cek_progressif()
    {
        //$nik    = $this->input->post('nik');
        //$jenis  = $this->input->post('jenis');

        $cek = NULL; //$this->mod_sptpd->cek_progressif($nik);

        echo $cek;
    }

    public function cek_progressif_kurang()
    {
        $nik = $this->input->post('nik');

        $cek = $this->mod_sptpd->cek_progressif_kurang($nik);

        echo json_encode(array($cek[0]));
    }

    // UNTUK RATA KANAN KIRI DAN TENGAH

    public function print_wprn($id)
    {


        $data['id']       = $id;
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['c_loc']    = $this->c_loc;
        $sptpd            = $this->mod_sptpd->get_sptpd($id);

        $kd_propinsi      = $sptpd->kd_propinsi;
        $kd_kabupaten     = $sptpd->kd_kabupaten;
        $kd_kecamatan     = $sptpd->kd_kecamatan;
        $kd_kelurahan     = $sptpd->kd_kelurahan;
        $kd_blok          = $sptpd->kd_blok;
        $no_urut          = $sptpd->no_urut;
        $kd_jns_op        = $sptpd->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        if ($sptpd->jns_setoran == 'STB') {
            $nomor_skb   = $sptpd->jns_setoran_nomor;
            $tanggal_skb = $sptpd->jns_setoran_tanggal;
        } elseif ($sptpd->jns_setoran == 'SKBKB') {
            $nomor_skbkb   = $sptpd->jns_setoran_nomor;
            $tanggal_skbkb = $sptpd->jns_setoran_tanggal;
        } elseif ($sptpd->jns_setoran == 'SKBKBT') {
            $nomor_skbkbt  = $sptpd->jns_setoran_nomor;
            $tanggal_skbkbt = $sptpd->jns_setoran_tanggal;
        }
        $ppat                = $this->mod_ppat->get_ppat($sptpd->id_ppat);
        $nik                 = $this->mod_nik->get_nik($sptpd->nik);
        $wil_nik             = (array) $nik;
        $wil_nik             = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $nik_nm_propinsi     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $nik_nm_kabupaten    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $nik_nm_kecamatan    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $nik_nm_kelurahan    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $nop                 = $this->mod_nop->get_nop($nop_compile);
        $nop_nm_propinsi     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $nop_nm_kabupaten    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $nop_nm_kecamatan    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $nop_nm_kelurahan    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $dispenda            = $this->mod_sptpd->get_dispenda($sptpd->id_dispenda);
        $jenis_perolehan     = $this->mod_jns_perolehan->get_jns_perolehan($sptpd->jenis_perolehan);
        $rec_id              = $id;
        $submitvalue         = 'Edit';
        $cek_transaksi_prev  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $sptpd->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor               = $this->antclass->back_value($sptpd->jumlah_setor, 'txt_jml_setor_sptpd');
        $terbilang_jml_setor = $this->terbilang_val($setor);

        $ltnt                = @$sptpd->luas_tanah_op * @$sptpd->njop_tanah_op;
        $lbnb                = @$sptpd->luas_bangunan_op * @$sptpd->njop_bangunan_op;

        $npopkp              = @$sptpd->npop - @$sptpd->npoptkp;

        if ($npopkp <= 0) {
            $npopkp = 0;
        }

        $npopkp5             = 0.05 * @$npopkp;

        // =========================== PRINT WEB PRN ============================================================================
        // echo implode(' ',$nop_compile); exit;
        $nop_print          = implode(' ', $nop_compile);
        $dataPrint          = "";
        $strprn             = "";
        $strprn            .= $this->give_space(65) . "NO. " . $sptpd->no_dokumen;
        $strprn            .= $this->new_line(13);
        $strprn            .= $this->give_space(15) . $this->pecah_kata(@$nik->nama);
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(15) . $this->pecah_kata(@$nik->nik);
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(15) . @$nik->alamat;
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . $this->fix_area(@$nik_nm_kelurahan, 27) . $this->fix_area(@$nik->rtrw, 19) . @$nik_nm_kecamatan;
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . $this->fix_area(@$nik_nm_kabupaten, 46) . @$nik->kodepos;
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . $this->give_space(7) . $this->pecah_kata(@$nop_print);
        $strprn            .= $this->new_line(3);
        $strprn            .= $this->give_space(15) . $this->give_space(7) . @$nop->lokasi_op;
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . $this->fix_area(@$nop_nm_kelurahan, 39) . $nop->rtrw_op;
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . $this->fix_area(@$nop_nm_kecamatan, 45) . $nop_nm_kabupaten;
        $strprn            .= $this->new_line(5);
        $strprn            .= $this->give_space(23) . $this->fix_area(@$sptpd->luas_tanah_op, 23) . $this->fix_area(number_format(@$sptpd->njop_tanah_op, 0, ',', '.'), 21) . number_format(@$ltnt, 0, ',', '.');
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(23) . $this->fix_area(@$sptpd->luas_bangunan_op, 23) . $this->fix_area(number_format(@$sptpd->njop_bangunan_op, 0, ',', '.'), 21) . number_format(@$lbnb, 0, ',', '.');
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(66) . number_format(@$sptpd->njop_pbb_op, 0, ',', '.');
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(30) . $this->fix_area(@$sptpd->jenis_perolehan, 40) . number_format(@$sptpd->nilai_pasar, 0, ',', '.');
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . @$sptpd->no_sertifikat_op;
        $strprn            .= $this->new_line(4);
        $strprn            .= $this->give_space(15) . $this->give_space(59) . number_format(@$sptpd->npop, 0, ',', '.');
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(15) . $this->give_space(59) . number_format(@$sptpd->npoptkp, 0, ',', '.');
        $strprn            .= $this->new_line(1);
        $strprn            .= $this->give_space(15) . $this->give_space(59) . number_format(@$npopkp, 0, ',', '.');
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(15) . $this->give_space(59) . number_format(@$npopkp5, 0, ',', '.');

        $x1 = '';
        $x2 = '';
        $x3 = '';
        $x4 = '';

        if (@$sptpd->jns_setoran == 'PWP') {
            $x1 = "X";
        }
        if (@$sptpd->jns_setoran == 'STB') {
            $x2 = "X";
        }
        if (@$sptpd->jns_setoran == 'SKBKB') {
            $x3 = "X";
        }
        if (@$sptpd->jns_setoran == 'SKBKBT') {
            $x4 = "X";
        }

        $strprn            .= $this->new_line(3);
        $strprn            .= $x1;
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->fix_area($x2, 40) . $this->fix_area(@$nomor_skb, 25) . @$this->antclass->fix_date(@$tanggal_skb);
        $strprn            .= $this->new_line(2);
        $strprn            .= $this->fix_area($x3, 27) . $this->fix_area('', 25) . '';
        $strprn            .= $this->new_line(1);
        $strprn            .= $x4 . $this->give_space(4) . '';

        $strprn            .= $this->new_line(3);
        $strprn            .= $x4 . $this->give_space(2) . $this->fix_area(number_format(@$sptpd->jumlah_setor, 0, ',', '.'), 28) . @$terbilang_jml_setor;

        $strprn            .= $this->new_line(5);
        $strprn            .= $this->give_space(6) . changeDateFormat('webview', $sptpd->tanggal);

        $strprn            .= $this->new_line(2);
        $strprn            .= $this->give_space(50) . changeDateFormat('webview', @$sptpd->tgl_validasi_bank);


        $strprn            .= $this->new_line(3);
        $strprn            .= $this->fix_area(@$nik->nama, 20) . $this->fix_area(@$ppat->nama, 20) . $this->fix_area(getNamaBank(@$sptpd->id_bank, 'nama'), 30) . @$dispenda->nama;

        $dataPrint          .= $strprn;
        $this->load->helper('download');
        force_download("spspd.webprn", $dataPrint);
    }

    public function fix_area($str = '', $panjang_area)
    {
        $n_str = strlen($str);
        $area_sisa = $panjang_area - $n_str;

        return $str . $this->give_space($area_sisa);
    }

    public function new_line($n = '')
    {
        $str = '';
        for ($i = 0; $i < $n; $i++) {
            $str .= "\n";
        }

        return $str;
    }

    public function give_space($n = '')
    {
        $str = '';
        for ($i = 0; $i < $n; $i++) {
            $str .= " ";
        }

        return $str;
    }

    public function pecah_kata($string = '')
    {
        $data = str_split($string);

        return implode(' ', $data);
    }

    function RataKolom($cetakkolom, $maksperkolomcetak, $baris, $kolom, $makskolom, $tipe, $str, $strorig)
    {
        $strbuf = "";
        $strbuf1 = "";
        $strbuf2 = "";

        $strsplit = explode("<br>", $str);

        //substr ( string $string , int $start [, int $length ] )
        //mixed str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )

        $kolom = $kolom + ($cetakkolom - 1) * $maksperkolomcetak;

        if ($tipe == "KIRI") {
            foreach ($strsplit as $i => $value) {
                $panjangstr = strlen($value);
                $strbuf1 = substr($strorig, 0, (($baris + $i) * $makskolom) + $kolom);
                $strbuf2 = substr($strorig, (($baris + $i) * $makskolom) + $kolom + strlen($value), strlen($strorig));
                $strorig = $strbuf1 . $strbuf2;
                $strorig = substr_replace($strorig, $value, (($baris + $i) * $makskolom) + $kolom, 0);
            }
        }

        if ($tipe == "KANAN") {
            foreach ($strsplit as $i => $value) {
                $panjangstr = strlen($value);
                $strbuf1 = substr($strorig, 0, (($baris + $i) * $makskolom) + $kolom - strlen($value));
                $strbuf2 = substr($strorig, (($baris + $i) * $makskolom) + $kolom, strlen($strorig));
                $strorig = $strbuf1 . $strbuf2;
                $strorig = substr_replace($strorig, $value, (($baris + $i) * $makskolom) + $kolom - strlen($value), 0);
            }
        }

        return $strorig;
    }

    function RataKolomTengah($cetakkolom, $maksperkolomcetak, $baris, $kolom1, $kolom2, $makskolom, $tipe, $str, $strorig)
    {
        $strbuf = "";
        $strbuf1 = "";
        $strbuf2 = "";

        $strsplit = explode("<br>", $str);

        $kolom1 = $kolom1 + ($cetakkolom - 1) * $maksperkolomcetak;
        $kolom2 = $kolom2 + ($cetakkolom - 1) * $maksperkolomcetak;

        //echo ($kolom1);
        //echo ("  ");
        //echo ($kolom2);

        if ($tipe == "TENGAH") {
            foreach ($strsplit as $i => $value) {
                $panjangstr = strlen($value);
                $kolom = intval($kolom2 - $kolom1) - $panjangstr;
                $kolom = intval($kolom / 2);
                $kolom = $kolom + $kolom1;
                //echo ("  ");
                //echo ($kolom);
                //echo ("  ");
                //echo ($panjangstr);
                $strbuf1 = substr($strorig, 0, (($baris + $i) * $makskolom) + $kolom);
                $strbuf2 = substr($strorig, (($baris + $i) * $makskolom) + $kolom + strlen($value), strlen($strorig));
                $strorig = $strbuf1 . $strbuf2;
                $strorig = substr_replace($strorig, $value, (($baris + $i) * $makskolom) + $kolom, 0);
            }
        }

        return $strorig;
    }

    function DownloadPrn($f)
    {
        header("Content-Author: Test");
        header("Content-type: Application/webprn");
        header("Content-Length" . filesize($f));
        header("Content-Disposition: attachment; filename=\"print.webprn\"");
        header("Content-Description: Download Data");
        header("Content-EQUIV: refresh; URL=\"http://localhost/?\" ");
        readfile($f);
    }

    public function proses_validasi_akhir($id_sptpd)
    {
        $data = $this->pembayaran->validasi_akhir($id_sptpd);
        if ($data == '1') {
            redirect('sptpd/printform/' . $id_sptpd);
        }
    }

    public function proses_validasi($type)
    {
        $id               = $this->input->post('txt_id_sptpd');
        $id_user          = $this->input->post('id_user');
        $nama_staf        = $this->session->userdata('s_nama_bphtb');
        $data['userdata'] = $this->session->all_userdata();
        $jabatan          = $this->session->userdata('jabatan') + 1;

        $data['ambil_ppat'] = $this->db->query("SELECT email
                                                FROM tbl_dispenda
                                                WHERE jabatan = '$jabatan' and is_delete = '0'")->row();

        $data['ambil_wp'] = $this->db->query("SELECT b.email,a.no_dokumen from tbl_sptpd a
                                                LEFT JOIN tbl_wp b ON b.id_wp = a.id_wp
                                                where id_sptpd = $id")->row();

        if ($type == 'PP') {

            $id_sptpd = $this->input->post('txt_id_sptpd');
            $jabatan  = $this->input->post('jabatan_user');

            $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->validasi_dispenda;

            if ($this->input->post('cek_kode_validasi_dispenda') != '') {

                if ($kode_validasi == trim($this->input->post('kode_approval'))) {

                    $this->pembayaran->update_sptpd($id_sptpd, $id_user, $type);
                    $this->pembayaran->update_kode_validasi($id_sptpd, $kode_validasi, $type);

                    $this->session->set_flashdata('flash_msg', succ_msg('Berhasil Melakukan Pembayaran di Bank'));
                } else {
                    @$this->data['approval']->error = "*Kode Tidak Cocok";
                    $this->data['approval']->value  = $this->input->post('kode_approval');
                }
            } else {

                $this->session->set_flashdata('flash_msg', err_msg('*Silahkan Melakukan Validasi ke Badan Pelayanan Pajak Daerah Kota Malang'));
            }
        } elseif ($type == 'D' && $data['userdata']['jabatan'] == 0) {

            $id_sptpd           = $this->input->post('txt_id_sptpd');
            $tgl_valid_dispenda = date('Y-m-d H:i:s');
            $jabatan            = $this->input->post('jabatan_user');
            $petugas            = $this->input->post('petugas_lapangan');

            if ($tgl_valid_dispenda == '') {
                $this->session->set_flashdata('flash_msg', err_msg('*Tanggal Harus Diinputkan'));
            } else {
                $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->kode_validasi;

                if ($kode_validasi == trim($this->input->post('kode_approval'))) {

                    $body1 = 'Dokumen dengan nomor ' . ($data['ambil_wp']->no_dokumen) . ' telah disetujui Oleh STAF ' . $this->session->userdata('s_nama_bphtb');
                    $kode1 = 'Badan Pelayanan Pajak Daerah';
                    $this->global->email($data['ambil_ppat']->email, 'Setujui Dokumen STAF', 'Setujui Dokumen STAF', $body1, $kode1);

                    $this->pembayaran->update_sptpd($id_sptpd, $id_user, $type, $tgl_valid_dispenda, $jabatan, $nama_staf, $petugas);
                    $this->pembayaran->update_kode_validasi($id_sptpd, $kode_validasi, $type);

                    $this->session->set_flashdata('flash_msg', succ_msg('Berhasil Melakukan Validasi di DISPENDA'));
                } else {
                    @$this->data['approval']->error = "*Kode Tidak Cocok";
                    $this->data['approval']->value  = $this->input->post('kode_approval');
                }
            }
        } elseif ($type == 'D' && $data['userdata']['jabatan'] == 1) {
            $id_sptpd           = $this->input->post('txt_id_sptpd');
            $tgl_valid_dispenda = date('Y-m-d H:i:s');
            $jabatan            = $this->input->post('jabatan_user');

            if ($tgl_valid_dispenda == '') {
                $this->session->set_flashdata('flash_msg', err_msg('*Tanggal Harus Diinputkan'));
            } else {
                $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->kode_validasi;

                if ($kode_validasi == trim($this->input->post('kode_approval'))) {

                    $body1 = 'Dokumen dengan nomor ' . ($data['ambil_wp']->no_dokumen) . '  Telah Di Aprove Oleh KASUBID ';
                    $kode1 = 'Badan Pelayanan Pajak Daerah';
                    $this->global->email($data['ambil_ppat']->email, 'Aprove Dokumen KASUBID', 'Aprove Dokumen KASUBID', $body1, $kode1);

                    $this->pembayaran->update_sptpd($id_sptpd, $id_user, $type, $tgl_valid_dispenda, $jabatan);
                    $this->pembayaran->update_kode_validasi($id_sptpd, $kode_validasi, $type);

                    $this->session->set_flashdata('flash_msg', succ_msg('Validasi di BP2D Berhasil'));
                } else {
                    @$this->data['approval']->error = "*Kode Tidak Cocok";
                    $this->data['approval']->value  = $this->input->post('kode_approval');
                }
            }
        } elseif ($type == 'D' && $data['userdata']['jabatan'] == 2) {

            $id_sptpd           = $this->input->post('txt_id_sptpd');
            $tgl_valid_dispenda = date('Y-m-d H:i:s');
            $jabatan            = $this->input->post('jabatan_user');

            if ($tgl_valid_dispenda == '') {
                $this->session->set_flashdata('flash_msg', err_msg('*Tanggal Harus Diinputkan'));
            } else {
                $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->kode_validasi;

                if ($kode_validasi == trim($this->input->post('kode_approval'))) {

                    $body1 = 'Pengajuan BPHTB dengan nomor ' . ($data['ambil_wp']->no_dokumen) . ' telah disetujui oleh Badan Pendapatan Daerah Kota Malang. Silahkan mencetak SSPD-BPHTB.';
                    $kode1 = 'Badan Pendapatan Daerah';
                    $this->global->email($data['ambil_wp']->email, 'Pengajuan BPHTB Disetujui.', 'Pengajuan BPHTB Disetujui.', $body1, $kode1);

                    $this->pembayaran->update_sptpd($id_sptpd, $id_user, $type, $tgl_valid_dispenda, $jabatan);
                    $this->pembayaran->update_kode_validasi($id_sptpd, $kode_validasi, $type);

                    $this->session->set_flashdata('flash_msg', succ_msg('Berhasil Melakukan Validasi di DISPENDA'));
                } else {
                    @$this->data['approval']->error = "*Kode Tidak Cocok";
                    $this->data['approval']->value  = $this->input->post('kode_approval');
                }
            }
        }

        redirect('sptpd/printform/' . $id_sptpd);
    }

    public function tes($id = '')
    {
        $this->load->view('tes');
    }

    public function kurang_bayar($id)
    {
        $kurang = $this->mod_sptpd->kurang_bayar($id, '1');

        $data['info'] = '';

        if ($kurang) {
            $data['info'] = succ_msg('SPTPD Kurang Bayar');
            $this->session->set_flashdata('info', @$data['info']);
            redirect($this->c_loc, @$data);
        }
    }
}

/* EoF */
