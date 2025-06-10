<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_referensi extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url_helper');
        $this->load->model('mod_validasi_sptpd', 'pembayaran');
        $this->load->model('mod_nop');
        $this->load->library('terbilang');
        $this->load->library('quotes');
        $this->load->library('tanggal');
    }

	public function index()
	{
		$data['title'] = 'CEK REFERENSI HARGA PASAR';

		if ($this->input->post('txt_submit')) {
        	$data['output'] = $this->get_nop();
        }
        
        $this->antclass->skin('v_cek_referensi', $data);
	}

	function get_nop()
    {
        $id_nop = $this->input->post('nop');
        
        $url = $this->config->item('url_service_nop').'web_service/getnopbphtb?nop='.$id_nop;

        // Get cURL resource
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url,
		    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);

		$hasil = (array) json_decode($resp);

		$output= array();
		
		if (count($hasil) > 1) {
			$ref_tanah				= ($hasil['NILAI_PER_M2_BUMI'] * 4) * $hasil['LUAS_BUMI_SPPT'];
			$ref_bangunan			= ($hasil['NILAI_PER_M2_BNG'] * 4) * $hasil['LUAS_BNG_SPPT'];
			$total					= $ref_tanah + $ref_bangunan;
			$output['nop']			= $id_nop;
			$output['ref_tanah'] 	= formatrupiah($ref_tanah);
	        $output['ref_bangunan'] = formatrupiah($ref_bangunan);
	        $output['total']		= formatrupiah($total);
		}
		// Close request to clear up some resources
		curl_close($curl);

        return $output;
    }

}

/* End of file cek_referensi.php */
/* Location: ./application/controllers/cek_referensi.php */