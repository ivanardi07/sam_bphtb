<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: pegawai.php
 * Description: pegawai controller
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class pegawai extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_pegawai');
        $this->c_loc = base_url().'index.php/pegawai';
    }

    function index()
    {
		$info = '';
		$data['info'] = '';
		  
        $nama=trim($this->input->get('cari'));

		if($this->input->post('submit_multi'))
		{
			$check = $this->input->post('check');
			if( ! empty($check)):
				switch($this->input->post('submit_multi'))
				{
					case 'delete':
						foreach($check as $ch)
						{ $this->mod_pegawai->delete_pegawai($ch); }
					break;
				}
			else: $info = err_msg('Pilih data terlebih dahulu.');
			endif;
			$data['info'] = $info;
		}
        
		$this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_pegawai->count_pegawai();
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



        $data['info']=$this->session->flashdata('info');
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
		$data['c_loc'] = $this->c_loc;
		$data['pegawais'] = $this->mod_pegawai->get_pegawai('', '', 'page', $data['start'], $config['per_page'], $nama);

        
		$this->antclass->skin('v_pegawai', $data);
    }
    
    function add()
    {
         if($this->input->post('submit'))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('nip', 'NIP', 'trim|required|is_unique[tbl_pegawai.nip]');
			$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['info'] = err_msg(validation_errors());
			}
			else
			{
				$add = array();
				$add['nip'] = $this->input->post('nip');
				$add['nama'] = $this->input->post('nama');
				$add['jabatan'] = $this->input->post('jabatan');

                $hitung=$this->mod_pegawai->ceknip($add['nip']);

                if($hitung>0){
                    $data['info'] = succ_msg('Nip sudah ada.');
                }
				else{
                    $info = $this->mod_pegawai->add_pegawai($add);
                    if($info)
                    {
                        $data['info'] = succ_msg('Input Pegawai Berhasil.');
                        $this->session->set_flashdata('info',$data['info']);
                        redirect('pegawai',$data);
                    }
                    else
                    {
                        $data['info'] = err_msg('Input Pegawai Gagal.');
                    }
                }
    				
				
			}
		}
		
		$data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
		$this->antclass->skin('v_pegawaiform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
			$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
			$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
			
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = err_msg(validation_errors());
            }
            else
            {
				$data = array();
				$data['nip'] = $this->input->post('nip');
				$data['nama'] = $this->input->post('nama');
				$data['jabatan'] = $this->input->post('jabatan');
				
                $info = $this->mod_pegawai->edit_pegawai($id, $data);
                if($info)
                {
                    $data['info'] = succ_msg('Update Pegawai Berhasil.');
                    $this->session->set_flashdata('info',$data['info']);
                    redirect('pegawai',$data);
                }
                else
                {
                    $data['info'] = err_msg('Update Pegawai Gagal.');
                }
            }
        }

        if($data['pegawai'] = $this->mod_pegawai->get_pegawai($id))
        {
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_pegawaiform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id)
    {
        	    if($data['pegawai'] = $this->mod_pegawai->get_pegawai($id))
        {
            $this->mod_pegawai->delete_pegawai($id);
            $data['info'] = succ_msg('Hapus Pegawai Berhasil.');
            $this->session->set_flashdata('info',$data['info']);
            redirect('dati',$data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }

    function cari($value='')
    {
        
    }
}

/* EoF */