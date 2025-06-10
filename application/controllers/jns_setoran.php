<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: jns_setoran.php
 * Description: Jenis Setoran controller
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Jns_setoran extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_jns_setoran');
        $this->c_loc = base_url().'index.php/jns_setoran';
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
                        { $this->mod_jns_setoran->delete_jns_setoran($ch); }
                    break;
                    case 'status':
                        foreach($check as $ch)
                        {
                            $get_status = $this->mod_jns_setoran->get_jns_setoran($ch);
                            $old_status = $get_status->is_blokir;
                            $this->mod_jns_setoran->change_status($ch, $old_status);
                        }
                    break;
                }
            else: $info = '<div class="warn_text">Pilih data terlebih dahulu.</div>';
            endif;
            $data['info'] = $info;
        }
        
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_jns_setoran->count_jns_setoran();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['jns_setorans'] = $this->mod_jns_setoran->get_jns_setoran('', '', 'page', $data['start'], $config['per_page']);
        $this->antclass->skin('v_jns_setoran', $data);
    }
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_kd_jns_setoran', 'Kode setoran', 'required');
            $this->form_validation->set_rules('txt_nama_jns_setoran', 'Nama', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $kd_jns_setoran = $this->input->post('txt_kd_jns_setoran');
                $nama = $this->input->post('txt_nama_jns_setoran');
                
                $jns_setoran_check = $this->mod_jns_setoran->get_jns_setoran($kd_jns_setoran);
                if($jns_setoran_check)
                {
                    $data['info'] = '<div class="warn_text">Kode Jenis setoran Sudah Ada.</div>';
                }
                else
                {
                    $info = $this->mod_jns_setoran->add_jns_setoran($kd_jns_setoran, $nama);
                    if($info)
                    {
                        $data['info'] = '<div class="note_text">Input Jenis setoran Berhasil.</div>';
                    }
                    else
                    {
                        $data['info'] = '<div class="warn_text">Input Jenis setoran Gagal.</div>';
                    }
                }
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_jns_setoranform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_jns_setoran', 'Nama', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $kd_jns_setoran = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_jns_setoran');
                
                $info = $this->mod_jns_setoran->edit_jns_setoran($kd_jns_setoran, $nama);
                if($info)
                {
                    $data['info'] = '<div class="note_text">Update Jenis setoran Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Update Jenis setoran Gagal.</div>';
                }
            }
        }

        if($data['jns_setoran'] = $this->mod_jns_setoran->get_jns_setoran($id))
        {
            $data['jns_setoran'] = $this->mod_jns_setoran->get_jns_setoran($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_jns_setoranform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        if($this->mod_jns_setoran->get_jns_setoran($id))
        {
            $this->mod_jns_setoran->delete_jns_setoran($id);
            redirect($this->c_loc);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
}

/* EoF */