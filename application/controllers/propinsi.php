<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: propinsi.php
 * Description: Propinsi controller
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class propinsi extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_propinsi');
        $this->c_loc = base_url().'index.php/propinsi';
    }

    function index()
    {
		$info = '';
		$data['info'] = '';

        $search = array('nama'=>'');
        $this->session->set_userdata('n_prop',$search); 
		
		if($this->input->post('submit_multi'))
		{
			$check = $this->input->post('check');
			if( ! empty($check)):
				switch($this->input->post('submit_multi'))
				{
					case 'delete':
						foreach($check as $ch)
						{ $this->mod_propinsi->delete_propinsi($ch); }
					break;
				}
			else: $info = '<div class="warn_text">Pilih data terlebih dahulu.</div>';
			endif;
			$data['info'] = $info;
		}

        if($this->input->post('search')){
            $search = array('nama'=>$this->input->post('txt_nama'));
            $this->session->set_userdata('n_prop',$search);     
        }
       
        
        $data['search'] = $this->session->userdata('n_prop');

		$this->load->library('pagination');
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
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_propinsi->count_propinsi($data['search']);
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
		$data['c_loc'] = $this->c_loc;
		$data['propinsis'] = $this->mod_propinsi->get_propinsi('', '', 'page', $data['start'], $config['per_page'], $data['search']);
		$this->antclass->skin('v_propinsi', $data);
    }
    
    function add()
    {
         if($this->input->post('submit'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_kd_propinsi', 'Propinsi', 'trim|required');
			$this->form_validation->set_rules('txt_nama_propinsi', 'Nama', 'trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['info'] = err_msg(validation_errors());
			}
			else
			{
				$kd_propinsi = $this->input->post('txt_kd_propinsi');
				$nama = $this->input->post('txt_nama_propinsi');
				
				$propinsi_check = $this->mod_propinsi->get_propinsi($kd_propinsi);
				if($propinsi_check)
				{
					$data['info'] = err_msg('Kode propinsi Sudah Ada.');
				}
				else
				{
					$info = $this->mod_propinsi->add_propinsi($kd_propinsi, $nama);
					if($info)
					{
                        $this->session->set_flashdata('flash_message',succ_msg("Input propinsi Berhasil."));
                        redirect($this->c_loc);
					}
					else
					{
						$data['info'] = err_msg('Input propinsi Gagal.');
					}
				}
			}
		}
		
		$data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
		$this->antclass->skin('v_propinsiform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_propinsi', 'Nama', 'trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
                $kd_propinsi = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_propinsi');
                
                $info = $this->mod_propinsi->edit_propinsi($kd_propinsi, $nama);
                if($info)
                {
                    //$data['info'] = succ_msg('Update propinsi Berhasil.');
                    $this->session->set_flashdata('flash_message',succ_msg("Update propinsi Berhasil."));
                    redirect($this->c_loc);
                }
                else
                {
                    $data['info'] = err_msg('Update propinsi Gagal.');
                }
            }
        }

        if($data['propinsi'] = $this->mod_propinsi->get_propinsi($id))
        {
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_propinsiform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        if($data['propinsi'] = $this->mod_propinsi->get_propinsi($id))
        {
            $info = $this->mod_propinsi->delete_propinsi($id);
            if($info)
            {
                $this->session->set_flashdata('flash_message', succ_msg(' Menghapus data.'));
            }
            else
            {
                $this->session->set_flashdata('flash_message', err_msg(' Menghapus data.'));
            }
            redirect($this->c_loc);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
}

/* EoF */