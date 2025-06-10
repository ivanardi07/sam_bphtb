<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: sptpd.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Kurang_bayar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->model('mod_kurang_bayar');
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
        $this->c_loc = base_url() . 'index.php/kurang_bayar';
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

        //search
        if ($this->input->post('search')) {
            $search = array(
                'nop'        => trim($this->input->post('txt_search_nop')),
                'nodok'      => trim($this->input->post('txt_search_nodok')),
                'date_start' => trim(changeDateFormat('database', $this->input->post('txt_search_dstart'))),
                'date_stop'  => trim(changeDateFormat('database', $this->input->post('txt_search_dstop'))),
            );
            $this->session->set_userdata('sptpd_search', $search);
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
        $nodok        = $nop_sess['nodok'];
        $date_start   = $nop_sess['date_start'];
        $date_stop    = $nop_sess['date_stop'];
        //endsearch

        $this->load->library('pagination');
        $config['base_url']   = $this->c_loc . '/index';
        $config['total_rows'] = $this->mod_kurang_bayar->count_sptpd($date_start, $date_stop);

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

        $data['sptpds'] = $this->mod_kurang_bayar->get_sptpd('', '', 'page', $data['start'], $config['per_page'], '', $id_compile, $nodok, $date_start, $date_stop);
        // echo $this->db->last_query(); exit;
        $this->pagination->initialize($config);
        $data['info']      = $this->session->flashdata('info');
        $data['search']    = $nop_sess;
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc']     = $this->c_loc;

        $this->antclass->skin('v_sptpd_kurang_bayar', $data);
    }

    public function add_kurang_bayar($id)
    {
        $data['sptpd'] = $this->mod_sptpd->get_sptpd($id);

        $data['nop'] =  $data['sptpd']->kd_propinsi . '.' .
            $data['sptpd']->kd_kabupaten . '.' .
            $data['sptpd']->kd_kecamatan . '.' .
            $data['sptpd']->kd_kelurahan . '.' .
            $data['sptpd']->kd_blok . '.' .
            $data['sptpd']->no_urut . '.' .
            $data['sptpd']->kd_jns_op;

        $data['nik'] = $this->mod_sptpd->get_nik_detail($data['sptpd']->nik);

        $data['txt_kd_dati2_selected']     = @$data['nik']->kd_kabupaten;
        $data['txt_kd_kecamatan_selected'] = @$data['nik']->kd_kecamatan;
        $data['txt_kd_kelurahan_selected'] = @$data['nik']->kd_kelurahan;

        $data['propinsis']       = $this->mod_propinsi->get_propinsi();
        $data['jenis_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['rekening']        = $this->mod_rekening->get_rekening(1);
        $data['prefix']          = $this->mod_prefix->get_prefix();
        $data['niks']            = $this->mod_nik->get_nik();
        // $data['nops'] = $this->mod_nop->get_nop();
        $data['cek_transaksi_prev'] = '';
        $data['c_loc']              = $this->c_loc;

        $data['submitvalue'] = 'Edit';
        $data['rec_id']      = '';

        $no_dokumen       = $data['sptpd']->no_dokumen;
        $data['lampiran'] = $this->mod_sptpd->get_lampiran($no_dokumen);

        $data['id'] = $id;

        $this->antclass->skin('v_sptpdform_kurang_bayar', $data);
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

        $param = $this->input->post();
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
                $this->session->set_flashdata('info', @$data['info']);
                redirect($this->c_loc, @$data);
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
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
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
                // $id_ppat     = $this->session->userdata('s_id_ppat');
                $id_ppat     = $this->input->post('id_ppat');
                $nik         = $this->input->post('txt_id_nik_sptpd');

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
                $njop_tanah_sptpd    = str_replace('.', '', $this->input->post('txt_njop_tanah_sptpd'));
                $njop_bangunan_sptpd = str_replace('.', '', $this->input->post('txt_njop_bangunan_sptpd'));
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
                $kurang_bayar      = $this->input->post('txt_kurang_bayar_sptpd');
                $sspd_lama         = $this->input->post('sspd_lama');

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
                //echo $no_dokumen;exit;
                $nop_pbb_baru = $this->input->post('txt_nop_pbb_baru_sptpd');
                $saved_nop    = $nop;
                // $kode_validasi = $this->antclass->add_nop_separator($nop).'-'.date('Ymd').'-'.$jml_setor.'-'.$unique_code;
                $kode_validasi = date('d') . '.' . date('m') . '.' . date('Y') . '.' . $autonum . '.' . $this->input->post('txt_jns_perolehan_sptpd');

                $picture = '';

                if (!empty($_FILES['txt_picture_sptpd']['name'])) {
                    $picture = str_replace(' ', '_', $_FILES['txt_picture_sptpd']['name']);
                }

                // Jumlah setor lebih atau sama dari Bea Perolehan Yang Terutang
                if ($kurang_bayar < $jml_setor or $dasar_jml_setoran == 'SKBKB' or $dasar_jml_setoran == "SKBKBT") {
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
                            $nop_compile,
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
                            $njop_tanah_sptpd,
                            $njop_bangunan_sptpd,
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
                            $kurang_bayar,
                            $sspd_lama
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

                        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', $no_dokumen_file . '_lampiran_sspd_1');

                            $paramFormulir['lampiran_sspd'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', $no_dokumen_file . '_lampiran_sppt');

                            $paramFormulir['lampiran_sppt'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', $no_dokumen_file . '_lampiran_fotocopi_identitas');

                            $paramFormulir['lampiran_fotocopi_identitas'] = $file;
                        }

                        if ($param['lampiran_surat_kuasa_wp'] != '') {

                            $paramFormulir['lampiran_nama_kuasa_wp']   = $this->input->post('lampiran_nama_kuasa_wp');
                            $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', $no_dokumen_file . '_lampiran_fotocopy_identitas_kwp');

                            $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', $no_dokumen_file . '_lampiran_fotocopy_kartu_npwp');

                            $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', $no_dokumen_file . '_lampiran_fotocopy_akta_jb');

                            $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', $no_dokumen_file . '_lampiran_sertifikat_kepemilikan_tanah');

                            $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_fotocopy_keterangan_waris',$_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', $no_dokumen_file . '_lampiran_fotocopy_keterangan_waris');

                            $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_fotocopy_surat_pernyataan']['name'] != '') {

                            $file = $this->uploadFile('txt_picture_lampiran_fotocopy_surat_pernyataan', $no_dokumen_file . '_lampiran_fotocopy_surat_pernyataan');

                            $paramFormulir['lampiran_fotocopy_surat_pernyataan'] = $file;
                        }

                        if ($_FILES['txt_picture_lampiran_identitas_lainya_file']['name'] != '') {

                            // $this->session->set_userdata('lampiran_identitas_lainya',$_FILES['txt_picture_lampiran_identitas_lainya_file']['name']);
                            $file = $this->uploadFile('txt_picture_lampiran_identitas_lainya_file', $no_dokumen_file . '_lampiran_identitas_lainya');

                            $paramFormulir['lampiran_identitas_lainya'] = $file;
                        }

                        // $paramFormulir['lampiran_identitas_lainya_val'] = $param['lampiran_identitas_lainya_val'];

                        // END OF CEK INPUT FORMULIR

                        $this->db->insert('tbl_formulir_penelitian', $paramFormulir);

                        $this->mod_sptpd->kurang_bayar($sspd_lama, '0');

                        if (!empty($picture)) {
                            if (!read_file($this->config->item('img_op_path') . $picture)) {
                                if (!$this->antclass->go_upload('txt_picture_sptpd', $this->config->item('img_op_path'), 'jpg|gif|png|pdf|doc|docx')) {
                                    $data['info'] .= err_msg('Upload gambar objek pajak gagal!');
                                }
                            } else {
                                $data['info'] .= err_msg('Upload gambar objek pajak gagal! Gambar objek pajak dengan nama sama sudah ada.');
                            }
                        }

                        if (!empty($new_nop)) {
                            $data['info'] .= '<div class="new_nop">NOP Baru: <b>' . $new_nop . '</b></div>';
                        }
                        $data['info'] .= '';
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
                    } else {
                        $data['info'] .= err_msg('Input SPTPD Gagal.');
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, @$data);
                    }
                } else {
                    $data['info'] = err_msg('Jumlah setor kurang dari Bea Perolehan yang harus dibayar.');
                    $this->session->set_flashdata('info', @$data['info']);
                    redirect($this->c_loc, @$data);
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
        $this->antclass->skin('v_sptpd_kurang_bayar', $data);
    }
}
