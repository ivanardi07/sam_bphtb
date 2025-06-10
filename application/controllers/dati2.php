<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: dati2.php
 * Description: dati2 controller
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class dati2 extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_dati2');
        $this->c_loc = base_url().'index.php/dati2';
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
                        { $this->mod_dati2->delete_dati2($ch); }
                    break;
                }
            else: $info = '<div class="warn_text">Please select data first.</div>';
            endif;
            $data['info'] = $info;
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['dati2s'] = $this->mod_dati2->get_dati2();
        $this->antclass->skin('v_dati2', $data);
    }
    
  
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_kd_dati2', 'dati2', 'required');
            $this->form_validation->set_rules('txt_kd_dati2', 'Dati2', 'required');
            $this->form_validation->set_rules('txt_kd_dati2', 'Kode dati2', 'required');
            $this->form_validation->set_rules('txt_nama_dati2', 'Nama', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $kd_dati2 = $this->input->post('txt_kd_dati2');
                $kd_dati2 = $kd_dati2.$this->input->post('txt_kd_dati2');
                $nama = $this->input->post('txt_nama_dati2');
                
                $dati2_check = $this->mod_dati2->get_dati2($kd_dati2);
                if($dati2_check)
                {
                    $data['info'] = '<div class="warn_text">ID dati2 Sudah Ada.</div>';
                }
                else
                {
                    $info = $this->mod_dati2->add_dati2($kd_dati2, $nama);
                    if($info)
                    {
                        $data['info'] = '<div class="note_text">Input dati2 Berhasil.</div>';
                    }
                    else
                    {
                        $data['info'] = '<div class="warn_text">Input dati2 Gagal.</div>';
                    }
                }
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_dati2form', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
        $this->form_validation->set_rules('txt_nama_dati2', 'Nama', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $kd_dati2 = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_dati2');
                
                $info = $this->mod_dati2->edit_dati2($kd_dati2, $nama);
                if($info)
                {
                    $data['info'] = '<div class="note_text">Update dati2 Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Update dati2 Gagal.</div>';
                }
            }
        }
        
        if($data['dati2'] = $this->mod_dati2->get_dati2($id))
        {
            $data['dati2'] = $this->mod_dati2->get_dati2($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_dati2form', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        // Delete controller goes here
    }
	
	function get_dati2_bypropinsix()
    {
        $kd_dati2 = $this->input->post('rx_kd_propinsi');
        $data = $this->mod_dati2->get_dati2('', '', $kd_propinsi);
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
	function get_dati2_bypropinsi()
    {
        $kd_propinsi = $this->input->post('rx_kd_propinsi');
        $datas = $this->mod_dati2->get_dati2('', '', $kd_propinsi);
        if($datas)
        {
            foreach($datas as $data)
            {
                echo '<option value="'.$data->kd_dati2.'">'.$data->kd_dati2.' - '.$data->nama.'</option>';
            }
        }
        else
        {
            echo 'no';
        }
    }
}

/* EoF */