<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_bayar_sptpd extends CI_Model {

		public function cek_bayar_sspd()
		{
			$no_dokumen = @$this->input->post('no_dokumen');

			$data = $this->db->get_where('tbl_sptpd', array('no_dokumen' => $no_dokumen));

			return $data->result();
		}	

}

/* End of file m_bayar_sptpd.php */
/* Location: ./application/models/m_bayar_sptpd.php */