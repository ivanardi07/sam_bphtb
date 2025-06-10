<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran_sptpd extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->antclass->auth_user();
		$this->load->model('M_bayar_sptpd', 'mdb');
		$this->c_loc = 'pembayaran_sptpd';
	}

	public function index()
	{

		$data['title'] = 'Cek Pembayaran SPTPD';
		$data['c_loc'] = $this->c_loc;
		$data['data_pembayaran'] = null;

		$this->antclass->skin('v_pembayaran_sptpd', $data);
	}
}

/* End of file pembayaran_sptpd.php */
/* Location: ./application/controllers/pembayaran_sptpd.php */