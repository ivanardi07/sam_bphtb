<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: nop.php
 * Description: NOP controller
 * Date created: 2011-03-07
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Nop extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->helper('form');
        $this->load->model('mod_nop');
        $this->load->model('mod_dati2');
        $this->load->model('mod_propinsi');
        $this->load->model('mod_kecamatan');
        $this->load->model('mod_kelurahan');
        $this->load->model('mod_jns_perolehan');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_nop_log');
        $this->c_loc = base_url().'index.php/nop';
    }

    function index()
    {
        // $this->session->unset_userdata('m_nop');
        $info = '';
        $data['info'] = '';

        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        { $this->mod_nop->delete_nop($ch); }
                    break;
                }
            else: $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }
        if($this->input->post('search')){
            $search = array('nop'=> trim($this->input->post('txt_nop')));
            $this->session->set_userdata('m_nop',$search);     
        }
        if($this->input->post('reset')){
            $this->session->unset_userdata('m_nop');     
        }
        
        $nop_sess = $this->session->userdata('m_nop'); //array
        $nop_search = str_replace('.', '', $nop_sess['nop']);
        $kd_propinsi = substr($nop_search, 0,2);
        $kd_kabupaten = substr($nop_search, 2,2);
        $kd_kecamatan = substr($nop_search, 4,3);
        $kd_kelurahan = substr($nop_search, 7,3);
        $kd_blok = substr($nop_search, 10,3);
        $no_urut = substr($nop_search, 13,4);
        $kd_jns_op = substr($nop_search, 17,1);
        $id_compile = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        // $data['search'] = $this->session->userdata('m_nop');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_nop->count_nop($id_compile);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
         $config['full_tag_open'] = '<ul>';
         $config['full_tag_close'] = '</ul>';
         $config['first_link'] = 'First';
         $config['first_tag_open'] = '<li>';
         $config['first_tag_close'] = '</li>';
         $config['last_link'] = 'Last';
         $config['last_tag_open'] = '<li>';
         $config['last_tag_close'] = '</li>';
         $config['next_link'] = 'Next →';
         $config['next_tag_open'] = '<li class="next">';
         $config['next_tag_close'] = '</li>';
         $config['prev_link'] = '← Prev';
         $config['prev_tag_open'] = '<li class="prev disabled">';
         $config['prev_tag_close'] = '</li>';
         $config['cur_tag_open'] = '<li class = "active"> <a href="#">';
         $config['cur_tag_close'] = '</a></li>';
         $config['num_tag_open'] = '<li>';
         $config['num_tag_close'] = '</li>';
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        // $cek_nop_sptpd = $this->mod_sptpd->get_sptpd('','','','','','',$id_compile);
        // if(count($cek_nop_sptpd) > 0){
        //     $data['del_none'] = "is use";
        // }else{
        //     $data['del_none'] = "not use";
        // }
        $data['info'] = $this->session->flashdata('info');
        $data['search_value'] = $nop_sess;
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['nops'] = $this->mod_nop->get_nop('', '', 'page', $data['start'], $config['per_page'], $id_compile);
        $this->antclass->skin('v_nop', $data);
    }
    function refresh(){
        $this->session->unset_userdata('m_nop');
        redirect('nop');
    }

    function get_nop()
    {
        $id_nop = $this->antclass->id_replace($this->input->post('rx_id_nop'));
        $id_nik = $this->antclass->id_replace($this->input->post('rx_id_nik'));
        $kd_propinsi = substr($id_nop, 0,2);
        $kd_kabupaten = substr($id_nop, 2,2);
        $kd_kecamatan = substr($id_nop, 4,3);
        $kd_kelurahan = substr($id_nop, 7,3);
        $kd_blok = substr($id_nop, 10,3);
        $no_urut = substr($id_nop, 13,4);
        $kd_jns_op = substr($id_nop, 17,1);
        $thn_skrg = date('Y');
        $id_compile = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op,$thn_skrg);

        $data = $this->mod_nop->get_nop_service($id_compile);
        $nm_kabupaten    = $this->mod_sptpd->get_wilayah_detail('kabupaten',$id_compile);
        $nm_kecamatan    = $this->mod_sptpd->get_wilayah_detail('kecamatan',$id_compile);
        $nm_kelurahan    = $this->mod_sptpd->get_wilayah_detail('kelurahan',$id_compile);
        
        if($data)
        {
            echo '<script type="text/javascript">';
            echo '$("#lokasi_nop_id").html("'.$data->lokasi_op.'");';
            echo '$("#lokasi_nop_id_op").html("'.$data->lokasi_op.'");';
            echo '$("#kelurahan_nop_id").html("'.$nm_kelurahan.'");';
            echo '$("#kecamatan_nop_id").html("'.$nm_kecamatan.'");';
            echo '$("#kotakab_nop_id").html("'.$nm_kabupaten.'");';
            echo '$("#rtrw_nop_id").html("'.$data->rtrw_op.'");';
            echo '$("#luas_tanah_nop_id").html("'.$data->luas_tanah_op.'");';
            echo '$("#luas_tanah_id").val("'.$data->luas_tanah_op.'");';
            echo '$("#njop_tanah_nop_id").html("'.number_format($data->njop_tanah_op, 0 ,',', '.').'");';
            echo '$("#njop_tanah_id").val("'.$data->njop_tanah_op.'");';
            echo '$("#luas_bangunan_nop_id").html("'.$data->luas_bangunan_op.'");';
            echo '$("#luas_bangunan_id").val("'.$data->luas_bangunan_op.'");';
            echo '$("#njop_bangunan_nop_id").html("'.number_format($data->njop_bangunan_op, 0 ,',', '.').'");';
            echo '$("#njop_bangunan_id").val("'.$data->njop_bangunan_op.'");';
            echo '$("#l_njop_tanah_nop_id").html("'.number_format($data->luas_tanah_op * $data->njop_tanah_op, 0 ,',', '.').'");';
            echo '$("#l_njop_tanah_nop_h_id").val("'.$data->luas_tanah_op * $data->njop_tanah_op.'");';
            echo '$("#l_njop_bangunan_nop_id").html("'.number_format($data->luas_bangunan_op * $data->njop_bangunan_op, 0 ,',', '.').'");';
            echo '$("#l_njop_bangunan_nop_h_id").val("'.$data->luas_bangunan_op * $data->njop_bangunan_op.'");';
            echo '$("#njop_pbb_nop_id").html("'.number_format($data->njop_pbb_op, 0 ,',', '.').'");';
            echo '$("#njop_pbb_nop_h_id").val("'.$data->njop_pbb_op.'");';
            echo '$("#ref_tanah").val("'.$data->ref_tanah.'");';
            echo '$("#ref_bangunan").val("'.$data->ref_bangunan.'");';
            echo '$("#referensi_tanah").html("'.number_format($data->ref_tanah, 0 ,',', '.').'");';
            echo '$("#referensi_bangunan").html("'.number_format($data->ref_bangunan, 0 ,',', '.').'");';
            echo '$("#total_referensi").html("'.number_format(($data->ref_tanah + $data->ref_bangunan), 0 ,',', '.').'");';
            $npop_sel = 0;
            if($data->njop_pbb_op >= $data->nilai_op){ $npop_sel = $data->njop_pbb_op; echo '$("#npop_id").val("'.$npop_sel.'");'; }
            elseif($data->njop_pbb_op <= $data->nilai_op){ $npop_sel = $data->nilai_op; echo '$("#npop_id").val("'.$npop_sel.'");'; }
            // $jns_perolehan = $this->mod_jns_perolehan->get_jns_perolehan($data->jenis_perolehan_op);
            $cek_transaksi_prev = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $id_nik); // Cek apakah NPWP pernah transaksi sebelumnya
            if( ! $cek_transaksi_prev) {
                //echo 'alert("Yo");';
                // NPWP TIDAK PERNAH melakukan transaksi, dapat NPOPTKP
                $npopkp_sel = $npop_sel-$this->config->item('conf_npoptkp');
                echo '$("#npoptkp_lbl_id").html("'.number_format($this->config->item('conf_npoptkp'), 0 ,',', '.').'");';
                echo '$("#npoptkp_id").val("'.$this->config->item('conf_npoptkp').'");';
            } else {
                // NPWP PERNAH melakukan transaksi, TIDAK dapat NPOPTKP
                $npopkp_sel = $npop_sel;
                echo '$("#npoptkp_lbl_id").html("'.number_format(0, 0 ,',', '.').'");';
                echo '$("#npoptkp_id").val("0");';
            }
            if($npopkp_sel <= 0){ $npopkp_sel = 0; }
            echo '$("#npopkp_id").html("'.number_format($npopkp_sel, 0 ,',', '.').'");';
            $bea_perolehan_sel = 0;
            if($npopkp_sel > 0){ $bea_perolehan_sel = $npopkp_sel*0.05; }
            echo '$("#bea_perolehan_id").html("'.number_format($bea_perolehan_sel, 0 ,',', '.').'");';
            echo '$("#bea_perolehan_h_id").val("'.$bea_perolehan_sel.'");';
            // echo '$("#jns_perolehan_nop_id").html("'.$data->jenis_perolehan_op.' - '.$jns_perolehan->nama.'");';
            echo '$("#no_sertipikat_nop_id").html("'.$data->no_sertipikat_op.'");';
            echo '$("#no_sertipikat_nop_id_op").html("'.$data->no_sertipikat_op.'");';
            echo '</script>';
        }
        else
        {
            echo 'kosong';
        }
    }

    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_id_nop', 'NOP', 'required');   
            $this->form_validation->set_rules('txt_lokasi_nop', 'Lokasi', 'required');
            $this->form_validation->set_rules('txt_kd_dati2_nop', 'Kabupaten / Kota', 'required');
            $this->form_validation->set_rules('txt_kd_kecamatan_nop', 'Kecamatan', 'required');
            $this->form_validation->set_rules('txt_kd_kelurahan_nop', 'Kelurahan', 'required');
            $this->form_validation->set_rules('txt_rtrw_nop', 'RT / RW', 'required');
            $this->form_validation->set_rules('txt_luas_tanah_nop', 'Luas Tanah', 'required|numeric');
            $this->form_validation->set_rules('txt_njop_tanah_nop', 'NJOP Tanah', 'required|numeric');
            $this->form_validation->set_rules('txt_luas_bangunan_nop', 'Luas Bangunan', 'required|numeric');
            $this->form_validation->set_rules('txt_njop_bangunan_nop', 'NJOP Bangunan', 'required|numeric');
            $this->form_validation->set_rules('txt_njop_pbb_nop', 'NJOP PBB', 'required|numeric');
            $this->form_validation->set_rules('txt_thn_sppt_nop', 'Tahun Pajak SPPT', 'required|numeric');
            /*
            $this->form_validation->set_rules('txt_nilai_nop', 'Nilai Transaksi / Harga Pasar', 'numeric');
            $this->form_validation->set_rules('txt_jns_perolehan_nop', 'Jenis Perolehan', 'required');
            */
            $this->form_validation->set_rules('txt_no_sertipikat_nop', 'Nomor Sertipikat', 'required'); 
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $nop = $this->antclass->id_replace(trim($this->input->post('txt_id_nop')));
                // pemecahan nop
                $kd_propinsi = substr($nop, 0,2);
                $kd_kabupaten = substr($nop, 2,2);
                $kd_kecamatan = substr($nop, 4,3);
                $kd_kelurahan = substr($nop, 7,3);
                $kd_blok = substr($nop, 10,3);
                $no_urut = substr($nop, 13,4);
                $kd_jns_op = substr($nop, 17,1);
                $id_compile = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);
                // end pemecahan nop

                $lokasi = trim($this->input->post('txt_lokasi_nop'));
                $kd_dati2_nop = trim($this->input->post('txt_kd_dati2_nop'));
                $kd_kecamatan_nop = trim($this->input->post('txt_kd_kecamatan_nop'));
                $kd_kelurahan_nop = trim($this->input->post('txt_kd_kelurahan_nop'));
                $rtrw = trim($this->input->post('txt_rtrw_nop'));
                $luas_tanah = trim($this->input->post('txt_luas_tanah_nop'));
                $njop_tanah = trim($this->input->post('txt_njop_tanah_nop'));
                $luas_bangunan = trim($this->input->post('txt_luas_bangunan_nop'));
                $njop_bangunan = trim($this->input->post('txt_njop_bangunan_nop'));
                $njop_pbb = trim($this->input->post('txt_njop_pbb_nop'));
                $kd_propinsi_op = trim($this->input->post('txt_kd_propinsi_nop'));
                /*
                $nilai = $this->input->post('txt_nilai_nop');
                $jns_perolehan = $this->input->post('txt_jns_perolehan_nop');
                */
                $no_sertipikat = trim($this->input->post('txt_no_sertipikat_nop'));
                $thn_pajak_sppt = trim($this->input->post('txt_thn_sppt_nop'));
                
                //function add_nop($id, $lokasi, $kelurahan, $rtrw, $kecamatan, $kotakab, $luas_tanah, $luas_bangunan, $njop_tanah, $njop_bangunan, $njop_pbb, $nilai_op, $jenis_perolehan, $no_sertipikat)
                $nop_check = $this->mod_nop->get_nop($id_compile);
                if(count($nop_check) > 0)
                {
                    $data['info'] = err_msg('NOP Sudah Ada.');
                }
                else
                {
                    $info = $this->mod_nop->add_nop($id_compile, 
                                                    $lokasi,
                                                    $kd_kelurahan_nop,
                                                    $rtrw,
                                                    $kd_kecamatan_nop,  
                                                    $kd_dati2_nop, 
                                                    $luas_tanah,
                                                    $luas_bangunan, 
                                                    $njop_tanah, 
                                                    $njop_bangunan, 
                                                    $njop_pbb, 
                                                    '', 
                                                    '', 
                                                    $no_sertipikat,
                                                    $kd_propinsi_op,
                                                    $thn_pajak_sppt
                                                   );
                    if($info)
                    {
                        $data['info'] = succ_msg('Input NOP Berhasil.');
                        $this->session->set_flashdata('info', $data['info']);
                        redirect('nop', @$data);
                    }
                    else
                    {
                        $data['info'] = err_msg('Input NOP Gagal.');
                    }
                }
            }
        }
        
        $data['propinsis'] = $this->mod_propinsi->get_propinsi();
        $data['dati2s'] = $this->mod_dati2->get_dati2();
        $data['kecamatans'] = $this->mod_kecamatan->get_kecamatan();
        $data['kelurahans'] = $this->mod_kelurahan->get_kelurahan();
        $data['jns_perolehans'] = $this->mod_jns_perolehan->get_jns_perolehan();
        $data['kd_propinsi'] = '';
        $data['kd_dati2'] = '';
        $data['kd_kecamatan'] = '';
        $data['kd_kelurahan'] = '';
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_nopform', $data);
    }

    function edit($id)
    {
        // pemecahan nop
        $kd_propinsi = substr($id, 0,2);
        $kd_kabupaten = substr($id, 2,2);
        $kd_kecamatan = substr($id, 4,3);
        $kd_kelurahan = substr($id, 7,3);
        $kd_blok = substr($id, 10,3);
        $no_urut = substr($id, 13,4);
        $kd_jns_op = substr($id, 17,1);
        $id_compile = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_lokasi_nop', 'Lokasi', 'required');
            $this->form_validation->set_rules('txt_kd_dati2_nop', 'Kabupaten / Kota', 'required');
            $this->form_validation->set_rules('txt_kd_kecamatan_nop', 'Kecamatan', 'required');
            $this->form_validation->set_rules('txt_kd_kelurahan_nop', 'Kelurahan', 'required');
            $this->form_validation->set_rules('txt_rtrw_nop', 'RT / RW', 'required');
            $this->form_validation->set_rules('txt_luas_tanah_nop', 'Luas Tanah', 'required|numeric');
            $this->form_validation->set_rules('txt_njop_tanah_nop', 'NJOP Tanah', 'required|numeric');
            $this->form_validation->set_rules('txt_luas_bangunan_nop', 'Luas Bangunan', 'required|numeric');
            $this->form_validation->set_rules('txt_njop_bangunan_nop', 'NJOP Bangunan', 'required|numeric');
            $this->form_validation->set_rules('txt_njop_pbb_nop', 'NJOP PBB', 'required|numeric');
            /*
            $this->form_validation->set_rules('txt_nilai_nop', 'Nilai Transaksi / Harga Pasar', 'numeric');
            $this->form_validation->set_rules('txt_jns_perolehan_nop', 'Jenis Perolehan', 'required');
            */
            $this->form_validation->set_rules('txt_no_sertipikat_nop', 'Nomor Sertipikat', 'required');
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $id_nop = $this->input->post('h_rec_id');
                $lokasi = $this->input->post('txt_lokasi_nop');
                $kd_dati2_nop = $this->input->post('txt_kd_dati2_nop');
                $kd_kecamatan_nop = $this->input->post('txt_kd_kecamatan_nop');
                $kd_kelurahan_nop = $this->input->post('txt_kd_kelurahan_nop');
                $rtrw = $this->input->post('txt_rtrw_nop');
                $luas_tanah = $this->input->post('txt_luas_tanah_nop');
                $njop_tanah = $this->input->post('txt_njop_tanah_nop');
                $luas_bangunan = $this->input->post('txt_luas_bangunan_nop');
                $njop_bangunan = $this->input->post('txt_njop_bangunan_nop');
                $njop_pbb = $this->input->post('txt_njop_pbb_nop');
                $kd_propinsi_op = $this->input->post('txt_kd_propinsi_nop');
                /*
                $nilai = $this->input->post('txt_nilai_nop');
                $jns_perolehan = $this->input->post('txt_jns_perolehan_nop');
                */
                $no_sertipikat = $this->input->post('txt_no_sertipikat_nop');
                
                $info = $this->mod_nop->edit_nop($id_compile, 
                                                 $lokasi,
                                                 $kd_kelurahan_nop,
                                                 $rtrw,
                                                 $kd_kecamatan_nop,  
                                                 $kd_dati2_nop, 
                                                 $luas_tanah,
                                                 $luas_bangunan, 
                                                 $njop_tanah, 
                                                 $njop_bangunan, 
                                                 $njop_pbb, 
                                                 '', 
                                                 '', 
                                                 $no_sertipikat,
                                                 $kd_propinsi_op
                                                );
                if($info)
                {
                    $data['info'] = succ_msg('Update NOP Berhasil.');
                    $this->session->set_flashdata('info', $data['info']);
                    redirect('nop', @$data);
                }
                else
                {
                    $data['info'] = err_msg('Update NOP Gagal.');
                }
            }
        }

        if($data['nop'] = $this->mod_nop->get_nop($id_compile))
        {
            $data['propinsis'] = $this->mod_propinsi->get_propinsi();
            $data['dati2s'] = $this->mod_dati2->get_dati2();
            $data['kecamatans'] = $this->mod_kecamatan->get_kecamatan();
            $data['kelurahans'] = $this->mod_kelurahan->get_kelurahan();
            $data['jns_perolehans'] = $this->mod_jns_perolehan->get_jns_perolehan();
            
            $data['kd_propinsi'] = $data['nop']->propinsi_op;
            $data['kd_dati2'] = $data['nop']->kotakab_op;
            $data['kd_kecamatan'] = $data['nop']->kecamatan_op;
            $data['kd_kelurahan'] = $data['nop']->kelurahan_op;
        
            $data['nop'] = $this->mod_nop->get_nop($id_compile);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_nopform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete()
    {
        $id = $this->uri->segment(3);
        $kd_propinsi = substr($id, 0,2);
        $kd_kabupaten = substr($id, 2,2);
        $kd_kecamatan = substr($id, 4,3);
        $kd_kelurahan = substr($id, 7,3);
        $kd_blok = substr($id, 10,3);
        $no_urut = substr($id, 13,4);
        $kd_jns_op = substr($id, 17,1);
        $id_compile = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);
        if($this->mod_nop->get_nop($id_compile))
        {
            $cek_nop_sptpd = $this->mod_sptpd->get_sptpd('','','','','','',$id_compile);
            if(count($cek_nop_sptpd) > 0){
                $data['info'] = $this->session->set_flashdata('info', err_msg('NOP Sedang digunakan di SPTPD.'));
                redirect($this->c_loc, $data);
            }else{
                $this->mod_nop->delete_nop($id_compile);
                $data['info'] = $this->session->set_flashdata('info', succ_msg('Delete NOP Berhasil.'));
                redirect($this->c_loc, $data);
            }
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
    
    function check_nop()
    {
        $id_nop = $this->antclass->id_replace($this->input->post('enNopValue'));
        $data = $this->mod_nop->get_nop($id_nop);
        if($data){
            $njop_tanah = number_format($data->njop_tanah_op, 0 ,',', '.');
            $njop_bangunan = number_format($data->njop_bangunan_op, 0 ,',', '.');
            $l_njop_tanah = number_format($data->luas_tanah_op * $data->njop_tanah_op, 0 ,',', '.');
            $l_njop_bangunan = number_format($data->luas_bangunan_op * $data->njop_bangunan_op, 0 ,',', '.');
            $njop_pbb = number_format($data->njop_pbb_op, 0 ,',', '.');
            $nilai_nop = number_format($data->nilai_op, 0 ,',', '.');
            $jns_perolehan = $this->mod_jns_perolehan->get_jns_perolehan($data->jenis_perolehan_op);
            $result_content = array(
                                    'lokasi'=>$data->lokasi_op,
                                    'kelurahan'=>$data->nm_kelurahan,
                                    'kecamatan'=>$data->nm_kecamatan,
                                    'kotakab'=>$data->nm_dati2,
                                    'rtrw'=>$data->rtrw_op,
                                    'luas_tanah'=>$data->luas_tanah_op,
                                    'njop_tanah'=>$njop_tanah,
                                    'luas_bangunan'=>$data->luas_bangunan_op,
                                    'njop_bangunan'=>$njop_bangunan,
                                    'l_njop_tanah'=>$l_njop_tanah,
                                    'l_njop_bangunan'=>$l_njop_bangunan,
                                    'njop_pbb'=>$njop_pbb,
                                    'nilai_nop'=>$nilai_nop,
                                    //'jns_perolehan'=>$data->jenis_perolehan_op.' - '.$jns_perolehan->nama,
                                    'no_sertipikat'=>$data->no_sertipikat_op
                                    );        
        } else {
            $result_content = array('lokasi'=>'');   
        }
        echo json_encode($result_content);
    }
    
    function go_report()
    {
        if($this->input->post('search_submit'))
        {
            if($this->input->post('txt_c_tgl_awal') != ''){ $date_start = $this->input->post('txt_c_tgl_awal'); }else{ $date_start = '2000-01-01'; }
            if($this->input->post('txt_c_tgl_akhir') != ''){ $date_end = $this->input->post('txt_c_tgl_akhir'); }else{ $date_end = date('Y-m-d'); }
            if($this->input->post('txt_c_nop_lama') != ''){ $nop_lama = $this->antclass->remove_separator($this->input->post('txt_c_nop_lama')); }else{ $nop_lama = '-'; }
            if($this->input->post('txt_c_nop_baru') != ''){ $nop_baru = $this->antclass->remove_separator($this->input->post('txt_c_nop_baru')); }else{ $nop_baru = '-'; }
            if($nop_lama == ''){ $nop_lama = '-'; }
            if($nop_baru == ''){ $nop_baru = '-'; }
            redirect($this->c_loc.'/report/'.$date_start.'/'.$date_end.'/'.$nop_lama.'/'.$nop_baru);
        }
        if($this->input->post('submit_print_all'))
        {
            if($this->input->post('txt_c_tgl_awal') != ''){ $date_start = $this->input->post('txt_c_tgl_awal'); }else{ $date_start = '2000-01-01'; }
            if($this->input->post('txt_c_tgl_akhir') != ''){ $date_end = $this->input->post('txt_c_tgl_akhir'); }else{ $date_end = date('Y-m-d'); }
            if($this->input->post('txt_c_nop_lama') != ''){ $nop_lama = $this->antclass->remove_separator($this->input->post('txt_c_nop_lama')); }
            if($this->input->post('txt_c_nop_baru') != ''){ $nop_baru = $this->antclass->remove_separator($this->input->post('txt_c_nop_baru')); }
            if($nop_lama == ''){ $nop_lama = '-'; }
            if($nop_baru == ''){ $nop_baru = '-'; }
            redirect($this->c_loc.'/report_all/'.$date_start.'/'.$date_end.'/'.$nop_lama.'/'.$nop_baru);
        }
    }
    
    function report()
    {
        $date_start = $this->uri->segment(3);
        $date_end = $this->uri->segment(4);
        $nop_lama = $this->uri->segment(5);
        $nop_baru = $this->uri->segment(6);
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/report/'.$date_start.'/'.$date_end.'/'.$nop_lama.'/'.$nop_baru.'/';
        if($this->uri->segment(5) == '-'){ $nop_lama = ''; }else{ $nop_lama = $this->uri->segment(5); }
        if($this->uri->segment(6) == '-'){ $nop_baru = ''; }else{ $nop_baru = $this->uri->segment(6); }
        
        $config['total_rows'] = $this->mod_nop_log->count_nop_log($nop_lama, $nop_baru, $date_start, $date_end);
        $config['per_page'] = 20;
        $config['uri_segment'] = 10;
        $data['start'] = $this->uri->segment(10);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['nops'] = $this->mod_nop_log->get_nop_log($nop_lama, $nop_baru, $date_start, $date_end);
        $this->antclass->skin('v_nopreport', $data);
    }

    function report_all()
    {
        $date_start = $this->uri->segment(3);
        $date_end = $this->uri->segment(4);
        $nop_lama = $this->uri->segment(5);
        $nop_baru = $this->uri->segment(6);
        if($this->uri->segment(5) == '-'){ $nop_lama = ''; }else{ $nop_lama = $this->uri->segment(5); }
        if($this->uri->segment(6) == '-'){ $nop_baru = ''; }else{ $nop_baru = $this->uri->segment(6); }
        $config['full_tag_open'] = '<ul>';
         $config['full_tag_close'] = '</ul>';
         $config['first_link'] = 'First';
         $config['first_tag_open'] = '<li>';
         $config['first_tag_close'] = '</li>';
         $config['last_link'] = 'Last';
         $config['last_tag_open'] = '<li>';
         $config['last_tag_close'] = '</li>';
         $config['next_link'] = 'Next →';
         $config['next_tag_open'] = '<li class="next">';
         $config['next_tag_close'] = '</li>';
         $config['prev_link'] = '← Prev';
         $config['prev_tag_open'] = '<li class="prev disabled">';
         $config['prev_tag_close'] = '</li>';
         $config['cur_tag_open'] = '<li class = "active"> <a href="#">';
         $config['cur_tag_close'] = '</a></li>';
         $config['num_tag_open'] = '<li>';
         $config['num_tag_close'] = '</li>';
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['nops'] = $this->mod_nop_log->get_nop_log($nop_lama, $nop_baru, $date_start, $date_end);
        $this->antclass->skin('v_nopreportall', $data);
    }

    function get_kecamatan_bydati2()
    {
        $kd_dati2 = $this->input->post('dati2_id');
        $data = $this->mod_kecamatan->get_kecamatan('', '', $kd_dati2);
        if($data)
        {
            foreach($data as $data)
            {
                echo '<option value="'.$data->kd_kecamatan.'">'.$data->kd_kecamatan.' - '.$data->nama.'</option>';
            }
        }
        else
        {
            echo 'no';
        }
    }

    function get_kelurahan_bykecamatan()
    {
        $kd_kecamatan = $this->input->post('kecamatan_id');
        $data = $this->mod_nop->get_kel($kd_kecamatan);
        if($data)
        {
            foreach($data as $data)
            {
                echo '<option value="'.$data->kd_kelurahan.'">'.$data->kd_kelurahan.' - '.$data->nama.'</option>';
            }
        }
        else
        {
            echo 'no';
        }
    }

    function get_kabupaten_bypropinsi()
    {
        $kd_propinsi = $this->input->post('propinsi_id');
        $data = $this->mod_nop->get_kab($kd_propinsi);
        if($data > 0)
        {
            foreach($data as $data)
            {
                echo '<option value="'.$data->kd_kabupaten.'">'.$data->kd_kabupaten.' - '.$data->nama.'</option>';
            }
        }
        else
        {
            echo 'no';
        }
    }
}

/* EoF */
