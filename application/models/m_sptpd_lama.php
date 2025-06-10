<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_sptpd_lama extends CI_Model {

	public function getSptpd($limit, $offset)
	{
		$cari = $this->session->userdata('cari');

		if ($cari != '') {
			$this->db->like('namawp', $cari);
		}

		$this->db->limit($limit, $offset);
		$data = $this->db->get('bphtb')->result();

		return $data;

	}

	public function countSptpd()
	{
		$cari = $this->session->userdata('cari');

		if ($cari != '') {
			$this->db->like('namawp', $cari);
		}

		$data = $this->db->get('bphtb')->num_rows();

		return $data;
	}

	public function getSptpdDetail($id='')
	{
		$this->db->where('Id', $id);
		$data = $this->db->get('bphtb')->result();

		return @$data[0];
	}

}

/* End of file m_sptpd_lama.php */
/* Location: ./application/models/m_sptpd_lama.php */