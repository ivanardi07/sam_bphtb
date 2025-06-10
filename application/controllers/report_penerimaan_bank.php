<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_penerimaan_bank extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->antclass->auth_user();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url_helper');
		$this->load->model('M_report_penerimaan_bank', 'mdb');
		$this->c_loc = 'report_penerimaan_bank';
        $this->limit = 10;
	}

	public function index($uri = '')
	{
        
        $this->load->library('pagination');

        if ($uri) {
          $offset = $this->uri->segment(3);
        }else{
          $offset = 0;
        }

        $start  = $offset+1;
        
        $param['tgl_awal']  = @$this->input->get_post('tgl_awal');
        $param['tgl_akhir'] = @$this->input->get_post('tgl_akhir');
        $param['bank']      = $this->input->get_post('bank');
        $data['start']      = $start;
        $data['laporan']    = $this->mdb->getReport($param, $this->limit, $offset);

        $config['base_url'] = site_url($this->c_loc.'/index/');
        $config['total_rows'] = $this->mdb->countReport($param);
        $config['per_page'] = $this->limit;
        
        $config['full_tag_open']                   = '<ul>';
        $config['full_tag_close']                  = '</ul>';
        $config['first_link']                      = 'First';
        $config['first_tag_open']                  = '<li>';
        $config['first_tag_close']                 = '</li>';
        $config['last_link']                       = 'Last';
        $config['last_tag_open']                   = '<li>';
        $config['last_tag_close']                  = '</li>';
        $config['next_link']                       = 'Next →';
        $config['next_tag_open']                   = '<li class="next">';
        $config['next_tag_close']                  = '</li>';
        $config['prev_link']                       = '← Prev';
        $config['prev_tag_open']                   = '<li class="prev disabled">';
        $config['prev_tag_close']                  = '</li>';
        $config['cur_tag_open']                    = '<li class = "active"> <a href="#">';
        $config['cur_tag_close']                   = '</a></li>';
        $config['num_tag_open']                    = '<li>';
        $config['num_tag_close']                   = '</li>';
        // if (empty($data['start'])) {$data['start'] = 0;}
        $this->pagination->initialize($config);

        $data['page_link']    = $this->pagination->create_links();
        
    	$data['bank'] 		= $this->mdb->getBank();
        $this->antclass->skin('v_report_penerimaan_bank', $data);
	}

  public function cetakPenerimaan()
  {
    $data['laporan'] = $this->db->query($this->session->userdata('ses_sql_laporan'))->result();

    $this->load->library('pdf');
    
    $this->pdf->load_view('cetakPenerimaanBank', $data, 'Laporan Penerimaan BANK', 'Legal', 'potrait');

  }

}

/* End of file report_penerimaan_bank.php */
/* Location: ./application/controllers/report_penerimaan_bank.php */