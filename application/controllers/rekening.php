<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: rekening.php
 * Description: Rekening controller
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Rekening extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_rekening');
        $this->c_loc = base_url().'index.php/rekening';
    }

    function index()
    {
        $info = '';
        $data['info'] = '';

        $search = array('nama'=>'');
        $this->session->set_userdata('n_rek',$search);
        
        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        { $this->mod_rekening->delete_rekening($ch); }
                    break;
                }
            else: $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }
        if($this->input->post('search')){
            $search = array('nama'=>$this->input->post('txt_nama'));
            $this->session->set_userdata('n_rek',$search);     
        }
        
        
        $data['search'] = $this->session->userdata('n_rek');
        
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_rekening->count_rekening($data['search']);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['rekenings'] = $this->mod_rekening->get_rekening('', '', 'page', $data['start'], $config['per_page'],$data['search']);
        $this->antclass->skin('v_rekening', $data);
    }
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_rekening', 'Nama Bank', 'trim|required');
            $this->form_validation->set_rules('txt_nomor_rekening', 'Nomor Rekening', 'trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $nama = $this->input->post('txt_nama_rekening');
                $nomor = $this->input->post('txt_nomor_rekening');
                
                $info = $this->mod_rekening->add_rekening($nama, $nomor);
                if($info)
                {
                    $this->session->set_flashdata('flash_message',succ_msg("Input Rekening Berhasil."));
                        redirect($this->c_loc);
                }
                else
                {
                    $data['info'] = err_msg('Input Rekening Gagal.');
                }
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_rekeningform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_rekening', 'Nama Bank', 'trim|required');
            $this->form_validation->set_rules('txt_nomor_rekening', 'Nomor Rekening', 'trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $id_rekening = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_rekening');
                $nomor = $this->input->post('txt_nomor_rekening');
                
                $info = $this->mod_rekening->edit_rekening($id_rekening, $nama, $nomor);
                if($info)
                {
                    $this->session->set_flashdata('flash_message',succ_msg("Update Rekening Berhasil."));
                    redirect($this->c_loc);
                }
                else
                {
                    $data['info'] = err_msg('Update Rekening Gagal.');
                }
            }
        }

        if($data['rekening'] = $this->mod_rekening->get_rekening($id))
        {
            $data['rekening'] = $this->mod_rekening->get_rekening($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_rekeningform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        if($this->mod_rekening->get_rekening($id))
        {
            $this->mod_rekening->delete_rekening($id);
             $this->session->set_flashdata('flash_message', succ_msg(' Menghapus data.'));
            redirect($this->c_loc);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
}

/* EoF */