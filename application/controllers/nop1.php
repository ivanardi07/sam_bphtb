<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: nop.php
 * Description: NOP controller
 * Date created: 2011-03-07
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Nop extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
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
            else: $info = '<div class="warn_text">Pilih data terlebih dahulu.</div>';
            endif;
            $data['info'] = $info;
        }
        if($this->input->post('search')){
            $search = array('nop'=>array('nop'=>$this->input->post('txt_nop')));
            $this->session->set_userdata('search',$search);     
        }
        if($this->input->post('reset')){
            $search = array('nop'=>array('nop'=>''));
            $this->session->set_userdata('search',$search);     
        }
        $data['search'] = $this->session->userdata('search');
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_nop->count_nop($data['search']['nop']);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['nops'] = $this->mod_nop->get_nop('', '', 'page', $data['start'], $config['per_page'], $data['search']['nop']);
        $this->antclass->skin('v_nop', $data);
    }

    function get_nop()
    {
        $id_nop = $this->antclass->id_replace($this->input->post('rx_id_nop'));
        $id_nik = $this->antclass->id_replace($this->input->post('rx_id_nik'));
        $data = $this->mod_nop->get_nop($id_nop);
        if($data)
        {
            echo '<script type="text/javascript">';
            echo '$("#lokasi_nop_id").html("'.$data->lokasi_op.'");';
            echo '$("#kelurahan_nop_id").html("'.$data->nm_kelurahan.'");';
            echo '$("#kecamatan_nop_id").html("'.$data->nm_kecamatan.'");';
            echo '$("#kotakab_nop_id").html("'.$data->nm_dati2.'");';
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
            //echo '$("#nilai_nop_id").html("'.number_format($data->nilai_op, 0 ,',', '.').'");';
            $npop_sel = 0;
            if($data->njop_pbb_op >= $data->nilai_op){ $npop_sel = $data->njop_pbb_op; echo '$("#npop_id").val("'.$npop_sel.'");'; }
            elseif($data->njop_pbb_op <= $data->nilai_op){ $npop_sel = $data->nilai_op; echo '$("#npop_id").val("'.$npop_sel.'");'; }
            // $jns_perolehan = $this->mod_jns_perolehan->get_jns_perolehan($data->jenis_perolehan_op);
            $cek_transaksi_prev = $this->mod_sptpd->get_sptpd('', '', '', '', '', $id_nik); // Cek apakah NPWP pernah transaksi sebelumnya
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
            echo '</script>';
        }
        else
        {
            echo '<script type="text/javascript">';
            echo '$("#lokasi_nop_id").html("");';
            echo '$("#kelurahan_nop_id").html("");';
            echo '$("#kecamatan_nop_id").html("");';
            echo '$("#kotakab_nop_id").html("");';
            echo '$("#rtrw_nop_id").html("");';
            echo '$("#luas_tanah_nop_id").html("");';
            echo '$("#njop_tanah_nop_id").html("");';
            echo '$("#luas_bangunan_nop_id").html("");';
            echo '$("#njop_bangunan_nop_id").html("");';
            echo '$("#l_njop_tanah_nop_id").html("");';
            echo '$("#l_njop_bangunan_nop_id").html("");';
            echo '$("#njop_pbb_nop_id").html("");';
            echo '$("#nilai_nop_id").html("");';
            echo '$("#jns_perolehan_nop_id").html("");';
            echo '$("#no_sertipikat_nop_id").html("");';
            echo '</script>';
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
            /*
            $this->form_validation->set_rules('txt_nilai_nop', 'Nilai Transaksi / Harga Pasar', 'numeric');
            $this->form_validation->set_rules('txt_jns_perolehan_nop', 'Jenis Perolehan', 'required');
            */
            $this->form_validation->set_rules('txt_no_sertipikat_nop', 'Nomor Sertipikat', 'required'); 
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $nop = $this->antclass->id_replace($this->input->post('txt_id_nop'));
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
                /*
                $nilai = $this->input->post('txt_nilai_nop');
                $jns_perolehan = $this->input->post('txt_jns_perolehan_nop');
                */
                $no_sertipikat = $this->input->post('txt_no_sertipikat_nop');
                
                //function add_nop($id, $lokasi, $kelurahan, $rtrw, $kecamatan, $kotakab, $luas_tanah, $luas_bangunan, $njop_tanah, $njop_bangunan, $njop_pbb, $nilai_op, $jenis_perolehan, $no_sertipikat)
                $nop_check = $this->mod_nop->get_nop($nop);
                if($nop_check)
                {
                    $data['info'] = '<div class="warn_text">NOP Sudah Ada.</div>';
                }
                else
                {
                    $info = $this->mod_nop->add_nop($nop, 
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
                                                    $no_sertipikat
                                                   );
                    if($info)
                    {
                        $data['info'] = '<div class="note_text">Input NOP Berhasil.</div>';
                    }
                    else
                    {
                        $data['info'] = '<div class="warn_text">Input NOP Gagal.</div>';
                    }
                }
            }
        }
        
        $data['dati2s'] = $this->mod_dati2->get_dati2();
        $data['kecamatans'] = $this->mod_kecamatan->get_kecamatan();
        $data['kelurahans'] = $this->mod_kelurahan->get_kelurahan();
        $data['jns_perolehans'] = $this->mod_jns_perolehan->get_jns_perolehan();
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
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
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
                /*
                $nilai = $this->input->post('txt_nilai_nop');
                $jns_perolehan = $this->input->post('txt_jns_perolehan_nop');
                */
                $no_sertipikat = $this->input->post('txt_no_sertipikat_nop');
                
                $info = $this->mod_nop->edit_nop($id_nop, 
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
                                                 $no_sertipikat
                                                );
                if($info)
                {
                    $data['info'] = '<div class="note_text">Update NOP Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Update NOP Gagal.</div>';
                }
            }
        }

        if($data['nop'] = $this->mod_nop->get_nop($id))
        {
            $data['dati2s'] = $this->mod_dati2->get_dati2();
            $data['kecamatans'] = $this->mod_kecamatan->get_kecamatan();
            $data['kelurahans'] = $this->mod_kelurahan->get_kelurahan();
            $data['jns_perolehans'] = $this->mod_jns_perolehan->get_jns_perolehan();
            
            $data['kd_dati2'] = $data['nop']->kotakab_op;
            $data['kd_kecamatan'] = $data['nop']->kecamatan_op;
            $data['kd_kelurahan'] = $data['nop']->kelurahan_op;
        
            $data['nop'] = $this->mod_nop->get_nop($id);
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

    function delete($id)
    {
        if($this->mod_nop->get_nop($id))
        {
            $this->mod_nop->delete_nop($id);
            redirect($this->c_loc);
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
            redirect($this->c_loc.'/report/'.$date_start.'/'.$date_end.'/'.$nop_lama.'/'.$nop_baru);
        }
    }
    
    function report()
    {
        $date_start = $this->uri->segment(3);
        $date_end = $this->uri->segment(4);
        $nop_lama = $this->uri->segment(5);
        $nop_baru = $this->uri->segment(6);
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/report/'.$date_start.'/'.$date_end.'/'.$nop.'/';
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
}

/* EoF */
