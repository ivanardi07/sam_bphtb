<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: paymentpoint.php
 * Description: Payment Point controller
 * Date created: 2011-03-10
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Paymentpoint extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_paymentpoint');
        $this->c_loc = base_url().'index.php/paymentpoint';
    }

    function index()
    {
        $id_pp= trim($this->input->get('id_pp'));
        $nama= trim($this->input->get('nama'));
        $alamat= trim($this->input->get('alamat'));

        $info = '';
        $data['info'] = '';
        $data['info'] = $this->session->flashdata('info');
        
        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');
            
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        {
                            $delete_multiple = explode('/', $ch);
    
                            $this->mod_paymentpoint->delete_paymentpoint($delete_multiple[0],$delete_multiple[1]); }
                    break;
                    case 'status':
                        foreach($check as $ch)
                        {
                            $get_status = $this->mod_paymentpoint->get_paymentpoint($ch);
                            $old_status = $get_status->is_blokir;
                            $this->mod_paymentpoint->change_status($ch, $old_status);
                        }
                    break;
                }
            else: $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }
        
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_paymentpoint->count_paymentpoint($id_pp,$nama,$alamat);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;

        /*STYLE PAGINATION START*/
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

        /*STYLE PAGINATION END*/

        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['paymentpoints'] = $this->mod_paymentpoint->get_paymentpoint('', '', 'page', $data['start'], $config['per_page'],$id_pp,$nama,$alamat);
        $this->antclass->skin('v_paymentpoint', $data);
    }
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_id_pp', 'ID paymentpoint', 'required');
            $this->form_validation->set_rules('txt_nama_paymentpoint', 'Nama', 'required');
            $this->form_validation->set_rules('txt_alamat_paymentpoint', 'Alamat', 'xss_clean');
            $this->form_validation->set_rules('txt_telepon_paymentpoint', 'Telepon', 'xss_clean');
            $this->form_validation->set_rules('txt_namakepala_paymentpoint', 'Nama Kepala', 'xss_clean');
            $this->form_validation->set_rules('txt_username_user', 'Username', 'required|is_unique[tbl_user.username]');
            $this->form_validation->set_rules('txt_password_user', 'Password', 'required|xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $id_pp = $this->input->post('txt_id_pp');
                $nama = $this->input->post('txt_nama_paymentpoint');
                $alamat = $this->input->post('txt_alamat_paymentpoint');
                $telepon = $this->input->post('txt_telepon_paymentpoint');
                $nama_kepala = $this->input->post('txt_namakepala_paymentpoint');
                $username = $this->input->post('txt_username_user');
                $password = md5($this->input->post('txt_password_user'));

                $hitung = $this->mod_paymentpoint->cek_username($username);
                if($hitung > 0){
                    $data['info'] =err_msg('Username Sudah Ada.');
                }else{

                    $paymentpoint_check = $this->mod_paymentpoint->get_paymentpoint($id_pp);
                if($paymentpoint_check)
                {
                    $data['info'] = err_msg('ID Payment Point Sudah Ada.');
                }
                else
                {
                    $info = $this->mod_paymentpoint->add_paymentpoint($id_pp, $nama, $alamat, $telepon, $nama_kepala, $username, $password);
                    if($info)
                    {
                        $data['info'] =succ_msg('Input Payment Point Berhasil.');
                    }
                    else
                    {
                        $data['info'] = err_msg('Input Payment Point Gagal.');
                    }
                    $this->session->set_flashdata('info', @$data['info']);
                    redirect($this->c_loc,$data);
                }

                }        
                
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_paymentpointform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_paymentpoint', 'Nama', 'required');
            $this->form_validation->set_rules('txt_alamat_paymentpoint', 'Alamat', 'xss_clean');
            $this->form_validation->set_rules('txt_telepon_paymentpoint', 'Telepon', 'xss_clean');
            $this->form_validation->set_rules('txt_namakepala_paymentpoint', 'Nama Kepala', 'xss_clean');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $id_pp = $this->input->post('h_rec_id');
                $id_user = $this->input->post('txt_id_user');
                $nama = $this->input->post('txt_nama_paymentpoint');
                $alamat = $this->input->post('txt_alamat_paymentpoint');
                $telepon = $this->input->post('txt_telepon_paymentpoint');
                $nama_kepala = $this->input->post('txt_namakepala_paymentpoint');
                
                if ($this->input->post('txt_password_ppat') != '') {
                    $password = md5($this->input->post('txt_password_ppat'));
                } else {
                    $password = '';
                }
                
                $info = $this->mod_paymentpoint->edit_paymentpoint($id_pp,$id_user, $nama, $alamat, $telepon, $nama_kepala,$password);
                if($info)
                {
                    $data['info'] =succ_msg('Update Payment Point Berhasil.');
                }
                else
                {
                    $data['info'] = err_msg('Update Payment Point Gagal.');
                }
                $this->session->set_flashdata('info', @$data['info']);
                redirect($this->c_loc,$data);
            }
        }

        if($data['paymentpoint'] = $this->mod_paymentpoint->get_paymentpoint($id))
        {
            $data['paymentpoint'] = $this->mod_paymentpoint->get_paymentpoint($id);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_paymentpointform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id,$id_user)
    {
        if($this->mod_paymentpoint->get_paymentpoint($id))
        {
            $this->mod_paymentpoint->delete_paymentpoint($id,$id_user);
            redirect($this->c_loc);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
    
    function status($id)
    {
        $data['info'] = '';
        if($get_status = $this->mod_paymentpoint->get_paymentpoint($id))
        {
            $old_status = $get_status->is_blokir;
            if($this->mod_paymentpoint->change_status($id, $old_status))
            {
                redirect($this->c_loc);
            }
            else
            {
                $data['info'] = err_msg('Update Status Blokir paymentpoint Gagal.');
            }
            
        }
        else
        {
            $data['info'] = '<div class="warn_text">ID paymentpoint Tidak Ada.</div>';
        }
        
        $this->antclass->skin('v_paymentpointform', $data);
    }
}

/* EoF */