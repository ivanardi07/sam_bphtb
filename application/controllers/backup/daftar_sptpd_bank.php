<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_sptpd_bank extends CI_Controller {

	function __construct()
	{
	    parent::__construct();
	    
	    $this->load->model('mod_daftar_sptpd_bank');   
	    $this->load->helper('url_helper');
	    $this->load->library('session'); 
	    $this->c_loc = base_url().'index.php/daftar_sptpd';  
	}
	
	function index()
	{
	    @$cari_dokumen = $this->input->get('cari_dokumen');
	    $isi=trim($this->input->get('cari'));
	    $nop=explode('.', $isi);
	    @$propinsi=$nop[0];
	    @$kabupaten=$nop[1];
	    @$kecamatan=$nop[2];
	    @$kelurahan=$nop[3];
	    @$blok=$nop[4];
	    @$urut=$nop[5];
	    @$jenis=$nop[6];


	    $id_user = $this->session->userdata('s_id_user');

	    $tipe_user = $this->mod_daftar_sptpd_bank->get_user($id_user);
	    // echo $tipe_user;
	    // exit();

	    // $allsess = $this->session->all_userdata();	//s_id_paymentpoint
	    // echo "<pre>";print_r($allsess);exit();

	    $id_bank = $this->session->userdata('s_id_paymentpoint');
	    // echo "<pre>";print_r($id_bank);exit();

	    

	    
	    // echo $id_ppat;
	    // exit();

	    
	    $this->load->library('pagination');
	    $config['base_url'] = $this->c_loc.'/index';
	    $config['total_rows'] = $this->mod_daftar_sptpd_bank->count_sptpd();
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
	    $data['tipe_user'] = $tipe_user;
	    
	    if($tipe_user == 'D'){
	        $id_ppat="";
	        $data['sptpd'] = $this->mod_daftar_sptpd_bank->get_sptpd('', '', 'page', $data['start'], $config['per_page'], @$id_ppat, $propinsi, $kabupaten, $kecamatan, $kelurahan, $blok, $urut, $jenis,$cari_dokumen);

	    }
	    elseif ($tipe_user == 'PP') {
	    	// echo "tipe pp";
	    	// $id_ppat="";
	    	// $data['sptpd'] = $this->mod_daftar_sptpd_bank->get_sptpd_from_idbank($id_bank);

	    	$data['sptpd'] = $this->mod_daftar_sptpd_bank->get_sptpd('', '', 'page', $data['start'], $config['per_page'], @$id_ppat, $propinsi, $kabupaten, $kecamatan, $kelurahan, $blok, $urut, $jenis, $cari_dokumen);
	    	// // echo $this->db->last_query();
	    }

	    elseif($tipe_user == 'PT')
	    {
	        
	        $id_ppat = $this->mod_daftar_sptpd_bank->get_id_ppat($id_user);
	        $data['sptpd'] = $this->mod_daftar_sptpd_bank->get_sptpd('', '', 'page', $data['start'], $config['per_page'], @$id_ppat, $propinsi, $kabupaten, $kecamatan, $kelurahan, $blok, $urut, $jenis, $cari_dokumen);

	    }
	    
	    if ($tipe_user == 'PT') {
	        $data['sum_jumlah_setor'] = $this->mod_daftar_sptpd_bank->sum_jumlah_setor(@$id_ppat,true);
	        $data['sum_jumlah_setor'] = $this->mod_daftar_sptpd_bank->sum_jumlah_setor(@$id_ppat,true, $propinsi, $kabupaten, $kecamatan, $kelurahan, $blok, $urut, $jenis, $cari_dokumen);
	        // echo $this->db->last_query();exit();
	    }
	    

	    
	    $this->antclass->skin('v_daftar_sptpd_bank', $data);
	}

}

/* End of file daftar_sptpd_bank.php */
/* Location: ./application/controllers/daftar_sptpd_bank.php */