<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_sptpd_lama extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_sptpd_lama', 'mdb');   
        $this->load->helper('url_helper');
        $this->load->library('session'); 
        $this->c_loc = site_url('daftar_sptpd_lama');  

        $this->limit = 20;
    }

	public function index()
	{
		$this->load->library('pagination');
		
		if ($this->input->post('cari')) {
			$array = array(
				'cari' => $this->input->post('cari')
			);
			
			$this->session->set_userdata( $array );
		}

		$config['base_url'] = $this->c_loc.'/index';
		$config['total_rows'] = $this->mdb->countSptpd();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 3;
		$config['full_tag_open']   = '<ul>';
        $config['full_tag_close']  = '</ul>';
        $config['first_link']      = 'First';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link']       = 'Last';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['next_link']       = 'Next →';
        $config['next_tag_open']   = '<li class="next">';
        $config['next_tag_close']  = '</li>';
        $config['prev_link']       = '← Prev';
        $config['prev_tag_open']   = '<li class="prev disabled">';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
		
		$this->pagination->initialize($config);

		$offset = $this->uri->segment(3);

		if ($offset == '') {
			$offset = 0;
		}
		
		$data['paging'] = $this->pagination->create_links();
		$data['sptpd'] 	= $this->mdb->getSptpd($this->limit, $offset);
		$this->antclass->skin('v_daftar_sptpd_lama', $data);
	}

	public function detail($id='')
	{
		$data['sptpd'] = $this->mdb->getSptpdDetail($id);
		$this->antclass->skin('v_daftar_sptpd_lama_detail', $data);
	}

	public function reset()
	{
		$this->session->unset_userdata('cari');
		redirect($this->c_loc);
	}
}

/* End of file daftar_sptpd_lama.php */
/* Location: ./application/controllers/daftar_sptpd_lama.php */