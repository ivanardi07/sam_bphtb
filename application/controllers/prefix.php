<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: prefix.php
 * Description: prefix controller
 * Date created: 2012-01-26
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Prefix extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_prefix');
        $this->c_loc = base_url().'index.php/prefix';
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
                        { $this->mod_prefix->delete_prefix($ch); }
                    break;
                }
            else: $info = '<div class="warn_text">Pilih data terlebih dahulu.</div>';
            endif;
            $data['info'] = $info;
        }
        
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_prefix->count_prefix();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['prefixs'] = $this->mod_prefix->get_prefix('', '', 'page', $data['start'], $config['per_page']);
        $this->antclass->skin('v_prefix', $data);
    }
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_prefix', 'Nama Bank', 'required');
            $this->form_validation->set_rules('txt_keterangan_prefix', 'keterangan prefix', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $nama = $this->input->post('txt_nama_prefix');
                $keterangan = $this->input->post('txt_keterangan_prefix');
                
                $info = $this->mod_prefix->add_prefix($nama, $keterangan);
                if($info)
                {
                    $data['info'] = '<div class="note_text">Input prefix Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Input prefix Gagal.</div>';
                }
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_prefixform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_prefix', 'Nama Bank', 'required');
            $this->form_validation->set_rules('txt_keterangan_prefix', 'keterangan prefix', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $id_prefix = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_prefix');
                $keterangan = $this->input->post('txt_keterangan_prefix');
                
                $info = $this->mod_prefix->edit_prefix($id_prefix, $nama, $keterangan);
                if($info)
                {
                    $data['info'] = '<div class="note_text">Update prefix Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Update prefix Gagal.</div>';
                }
            }
        }

        if($data['prefix'] = $this->mod_prefix->get_prefix($id))
        {
            $data['prefix'] = $this->mod_prefix->get_prefix($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_prefixform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        if($this->mod_prefix->get_prefix($id))
        {
            $this->mod_prefix->delete_prefix($id);
            redirect($this->c_loc);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
}

/* EoF */