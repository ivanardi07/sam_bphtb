<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: nik.php
 * Description: NIK controller
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Nik extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_nik');
        $this->load->model('mod_dati2');
        $this->load->model('mod_propinsi');
        $this->load->model('mod_kecamatan');
        $this->load->model('mod_kelurahan');
        $this->load->model('mod_sptpd');
        $this->c_loc = base_url().'index.php/nik';
    }

    function index()
    {
        $info = '';
        $data['info'] = '';
        $search = array('nik'=>'','nama'=>'');
        $this->session->set_userdata('m_nik',$search);  
        
        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        { $this->mod_nik->delete_nik($ch); }
                    break;
                }
            else: $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }
	
        if($this->input->post('search')){
            $search = array('nik'=>$this->input->post('txt_nik'),'nama'=>$this->input->post('txt_nama'));
            $this->session->set_userdata('m_nik',$search);     
        }

        $data['info'] = $this->session->flashdata('info');

        $data['search'] = $this->session->userdata('m_nik');

        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_nik->count_nik($data['search']);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;

        /*CONFIG STYLE PAGINATION*/
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
        /*CONFIG STYLE PAGINATION*/

        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['niks'] = $this->mod_nik->get_nik('', '', 'page', $data['start'], $config['per_page'], $data['search']);
        // echo $this->db->last_query();
        // exit;
        $this->antclass->skin('v_nik', $data);
    }

	function get_nik()
    {
        $id_nik = $this->input->post('rx_id_nik');
        $data = $this->mod_nik->get_nik($id_nik);
        if($data)
        {
            echo '<script type="text/javascript">';
            echo '$("#nama_nik_id").html("'.$data->nama.'");';
			echo '$("#alamat_nik_id").html("'.$data->alamat.'");';
			echo '$("#kelurahan_nik_id").html("'.$data->nm_kelurahan.'");';
			echo '$("#kecamatan_nik_id").html("'.$data->nm_kecamatan.'");';
			echo '$("#kotakab_nik_id").html("'.$data->nm_dati2.'");';
			echo '$("#rtrw_nik_id").html("'.$data->rtrw.'");';
			echo '$("#kodepos_nik_id").html("'.$data->kodepos.'");';
            echo '</script>';
        }
        else
        {
            echo '<script type="text/javascript">';
            echo '$("#nama_nik_id").html("");';
			echo '$("#alamat_nik_id").html("");';
			echo '$("#kelurahan_nik_id").html("");';
			echo '$("#kecamatan_nik_id").html("");';
			echo '$("#kotakab_nik_id").html("");';
			echo '$("#rtrw_nik_id").html("");';
			echo '$("#kodepos_nik_id").html("");';
            echo '</script>';
        }
    }
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_id_nik', 'NIK', 'trim|required|is_unique[tbl_nik.nik]');
            $this->form_validation->set_rules('txt_nama_nik', 'Nama', 'required');
            $this->form_validation->set_rules('txt_alamat_nik', 'Alamat', 'required');
            $this->form_validation->set_rules('txt_kd_propinsi_nik', 'Propinsi', 'trim|required');
            $this->form_validation->set_rules('txt_kd_dati2_nik', 'Kabupaten / Kota', 'trim|required');
            $this->form_validation->set_rules('txt_kd_kecamatan_nik', 'Kecamatan', 'trim|required');
            $this->form_validation->set_rules('txt_kd_kelurahan_nik', 'Kelurahan', 'trim|required');
            $this->form_validation->set_rules('txt_rtrw_nik', 'RT / RW', 'trim|required');
            $this->form_validation->set_rules('txt_kodepos_nik', 'Kode Pos', 'trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $nik = $this->input->post('txt_id_nik');
                $nama = $this->input->post('txt_nama_nik');
                $alamat = $this->input->post('txt_alamat_nik');
                $propinsi = $this->input->post('txt_kd_propinsi_nik');
                $kd_dati2_nik = $this->input->post('txt_kd_dati2_nik');
                $kd_kecamatan_nik = $this->input->post('txt_kd_kecamatan_nik');
                $kd_kelurahan_nik = $this->input->post('txt_kd_kelurahan_nik');
                $rtrw = $this->input->post('txt_rtrw_nik');
                $kodepos = $this->input->post('txt_kodepos_nik');

                $hitung = $this->mod_nik->ceknik($nik);
                if(!empty($hitung))
                {
                    $data['info'] = err_msg('NIK Sudah Ada.');
                }
                else
                {
                    $info = $this->mod_nik->add_nik($nik, 
                                                $nama, 
                                                $alamat,
                                                $propinsi,
                                                $kd_dati2_nik, 
                                                $kd_kecamatan_nik, 
                                                $kd_kelurahan_nik, 
                                                $rtrw, 
                                                $kodepos
                                               );
                    if($info)
                    {
                        $data['info'] = succ_msg('Input NIK Berhasil.');
                    }
                    else
                    {
                        $data['info'] = err_msg('Input NIK Gagal.');
                    }
                    $this->session->set_flashdata('info', @$data['info']);
                    redirect($this->c_loc,$data);
                }
            }
        }
        $data['propinsis'] = $this->mod_nik->get_propinsi();
        $data['dati2s'] = $this->mod_nik->get_dati2();
        $data['kecamatans'] = $this->mod_nik->get_kecamatan();
        $data['kd_dati2'] = '';
        $data['kd_kecamatan'] = '';
        $data['kd_kelurahan'] = '';
        $data['kd_propinsi'] = '';
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_nikform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_nik', 'Nama', 'trim|required');
            $this->form_validation->set_rules('txt_alamat_nik', 'Alamat', 'trim|required');
            $this->form_validation->set_rules('txt_kd_propinsi_nik', 'Propinsi', 'trim|required');
            $this->form_validation->set_rules('txt_kd_dati2_nik', 'Kabupaten / Kota', 'trim|required');
            $this->form_validation->set_rules('txt_kd_kecamatan_nik', 'Kecamatan', 'trim|required');
            $this->form_validation->set_rules('txt_kd_kelurahan_nik', 'Kelurahan', 'trim|required');
            $this->form_validation->set_rules('txt_rtrw_nik', 'RT / RW', 'trim|required');
            $this->form_validation->set_rules('txt_kodepos_nik', 'Kode Pos', 'trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $nik = $this->input->post('txt_id_nik');
                $nik_ed = $this->input->post('txt_id_nik');
                $nama = $this->input->post('txt_nama_nik');
                
                $alamat = $this->input->post('txt_alamat_nik');
                $propinsi = $this->input->post('txt_kd_propinsi_nik');
                $kd_dati2_nik = $this->input->post('txt_kd_dati2_nik');
                $kd_kecamatan_nik = $this->input->post('txt_kd_kecamatan_nik');
                $kd_kelurahan_nik = $this->input->post('txt_kd_kelurahan_nik');
                $rtrw = $this->input->post('txt_rtrw_nik');
                $kodepos = $this->input->post('txt_kodepos_nik');
                
                $info = $this->mod_nik->edit_nik($nik, 
                                                 $nama, 
                                                 $alamat,
                                                 $propinsi, 
                                                 $kd_dati2_nik, 
                                                 $kd_kecamatan_nik, 
                                                 $kd_kelurahan_nik, 
                                                 $rtrw, 
                                                 $kodepos
                                                );

                if($info)
                {
                    $data['info'] = succ_msg('Update NIK Berhasil');
                }
                else
                {
                    $data['info'] = err_msg('Update NIK Gagal');
                }
                $this->session->set_flashdata('info', @$data['info']);
                redirect($this->c_loc,$data);
            }
        }

        if($data['nik'] = $this->mod_nik->get_nik($id))
        {

            $data['propinsis'] = $this->mod_nik->get_propinsi();
            $data['dati2s'] = $this->mod_nik->get_dati2s($data['nik']);
            $data['kecamatans'] = $this->mod_nik->get_kecamatans($data['nik']);
            $data['kelurahans'] = $this->mod_nik->get_kelurahans($data['nik']);

            $data['kd_propinsi'] = $data['nik']->kd_propinsi;
            $data['kd_kabupaten'] = $data['nik']->kd_kabupaten;
            $data['kd_kecamatan'] = $data['nik']->kd_kecamatan;
            $data['kd_kelurahan'] = $data['nik']->kd_kelurahan;
        
            $data['nik'] = $this->mod_nik->get_nik($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
			
			if($this->session->userdata('s_tipe_bphtb') == 'D' or $this->session->userdata('s_tipe_bphtb') == 'PT')
				$data['allow_edit'] = true;
			else
				$data['allow_edit'] = false;
            $this->antclass->skin('v_nikformedit', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        if($this->mod_nik->get_nik($id))
        {
            $this->mod_nik->delete_nik($id);
            redirect($this->c_loc);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
    
    function check_nik(){
        $id_nik = $this->input->post('enNikValue');
        $data = $this->mod_nik->get_nik($id_nik);
        if($data){
            $result_content = array(
                                    'nama'=>$data->nama,
                                    'alamat'=>$data->alamat,
                                    'kelurahan'=>$data->nm_kelurahan,
                                    'rtrw'=>$data->rtrw,
                                    'kecamatan'=>$data->nm_kecamatan,
                                    'kota'=>$data->nama_dati2,
                                    'kd_pos'=>$data->kodepos
                                    );        
        } else {
            $result_content = array('nama'=>'');   
        }
        echo json_encode($result_content);
    }

    function get_kecamatan_bydati2()
    {
        $kd_dati2 = $this->input->post('rx_kd_dati2');
        $data = $this->mod_nik->get_kecamatan($kd_dati2);
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
        $kd_kecamatan = $this->input->post('rx_kd_kecamatan');
        $data = $this->mod_nik->get_kelurahan($kd_kecamatan);
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

    function get_dati2_bypropinsi()
    {
        $kd_propinsi = $this->input->post('rx_kd_propinsi');
        $data = $this->mod_nik->get_dati2_bypropinsi($kd_propinsi);
        if($data)
        {
            echo '<option></option>';
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
