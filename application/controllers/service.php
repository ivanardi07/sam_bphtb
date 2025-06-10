<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_validasi_sptpd', 'pembayaran');
	}

	public function setLunas()
	{
		$param['no_sspd'] 	= $this->input->post('no_sspd');
		$param['id_bank'] 	= $this->input->post('id_bank');

		$proses = $this->pembayaran->setLunas($param);

		echo json_encode($proses);
	}

}

/* End of file service.php */
/* Location: ./application/controllers/service.php */