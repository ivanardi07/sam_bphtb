<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_jumlah_transaksi extends CI_Model {

	public function get_jumlah_transaksi($nik='')
	{
		$this->db->select('count(tbl_nik.nik) as jumlah, thn_pajak_sppt as tahun');
		$this->db->from('tbl_sptpd');
		$this->db->join('tbl_nik', 'tbl_nik.nik = tbl_sptpd.nik', 'left');
		$this->db->group_by('tbl_sptpd.thn_pajak_sppt');
		$this->db->order_by('thn_pajak_sppt', 'asc');
		$this->db->where('tbl_sptpd.nik', $nik);
		
		$data = $this->db->get()->result();

		return $data;
	}

	public function getDataNik($nik='')
	{
		if ($nik) {
			$this->db->where('nik', $nik);
		}
		
		$data = $this->db->get('tbl_nik')->result();

		return @$data[0];
	}	

	public function getDataNikOpt($value='')
	{
		$this->db->select('nik, nama');
		$this->db->from('tbl_nik');
		$data = $this->db->get()->result_array();

		$out = array();

		foreach ($data as $key => $value) {
			$out[] = $value['nik'] . ' - ' . $value['nama'];
		}

		return json_encode(@$out);
	}
}

/* End of file mod_jumlah_transaksi.php */
/* Location: ./application/models/mod_jumlah_transaksi.php */