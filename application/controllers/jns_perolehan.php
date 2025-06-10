<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: jns_perolehan.php
 * Description: Jenis Perolehan controller
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Jns_perolehan extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_jns_perolehan');
        $this->c_loc = base_url().'index.php/jns_perolehan';
    }

    function index()
    {
        $info = '';
        $data['info'] = '';

        $search = array('nama'=>'');
        $this->session->set_userdata('n_perolehan',$search);
        
        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        { $this->mod_jns_perolehan->delete_jns_perolehan($ch); }
                    break;
                    case 'status':
                        foreach($check as $ch)
                        {
                            $get_status = $this->mod_jns_perolehan->get_jns_perolehan($ch);
                            $old_status = $get_status->is_blokir;
                            $this->mod_jns_perolehan->change_status($ch, $old_status);
                        }
                    break;
                }
            else: $info = '<div class="warn_text">Pilih data terlebih dahulu.</div>';
            endif;
            $data['info'] = $info;
        }

        if($this->input->post('search')){
            $search = array('nama'=>$this->input->post('txt_nama'));
            $this->session->set_userdata('n_perolehan',$search);     
        }

        $data['search'] = $this->session->userdata('n_perolehan');
        
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_jns_perolehan->count_jns_perolehan($data['search']);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        /*STYLE PAGINATION*/

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

         /*STYLE PAGINATION*/

     
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['jns_perolehans'] = $this->mod_jns_perolehan->get_jns_perolehan('', '', 'page', $data['start'], $config['per_page'], $data['search']);
        $this->antclass->skin('v_jns_perolehan', $data);
    }
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_kd_jns_perolehan', 'Kode Perolehan', 'trim|required|is_numeric');
            $this->form_validation->set_rules('txt_nama_jns_perolehan', 'Nama', 'trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $kd_jns_perolehan = $this->input->post('txt_kd_jns_perolehan');
                $nama = $this->input->post('txt_nama_jns_perolehan');
                
                $jns_perolehan_check = $this->mod_jns_perolehan->get_jns_perolehan($kd_jns_perolehan);
                if($jns_perolehan_check)
                {
                    $data['info'] = err_msg('Kode Jenis Perolehan Sudah Ada.');
                }
                else
                {
                    $info = $this->mod_jns_perolehan->add_jns_perolehan($kd_jns_perolehan, $nama);
                    if($info)
                    {
                        $this->session->set_flashdata('flash_message',succ_msg("Input Jenis Perolehan Berhasil."));
                        redirect($this->c_loc);
                        
                    }
                    else
                    {
                        $data['info'] = err_msg('Input Jenis Perolehan Gagal.');
                    }
                }
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_jns_perolehanform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_jns_perolehan', 'Nama', 'trim|required');

            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $kd_jns_perolehan = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_jns_perolehan');
                
                $info = $this->mod_jns_perolehan->edit_jns_perolehan($kd_jns_perolehan, $nama);
                if($info)
                {
                    $this->session->set_flashdata('flash_message',succ_msg("Update Jenis Perolehan Berhasil."));
                    redirect($this->c_loc);
                }
                else
                {
                    $data['info'] = err_msg('Update Jenis Perolehan Gagal.');
                }
            }
        }

        if($data['jns_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan($id))
        {
            $data['jns_perolehan'] = $this->mod_jns_perolehan->get_jns_perolehan($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_jns_perolehanform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        if($this->mod_jns_perolehan->get_jns_perolehan($id))
        {
            $this->mod_jns_perolehan->delete_jns_perolehan($id);
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