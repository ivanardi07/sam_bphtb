<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_kelurahan.php
 * Description: Kelurahan model
 * Date created: 2011-03-10
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_kelurahan extends CI_Model
{

	var $query_get_data_kecamatan = "SELECT * FROM tbl_kecamatan WHERE kd_propinsi = ?";

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tbl           = $this->config->item('pg_schema') . 'tbl_kelurahan';
		$this->tbl_kabupaten = $this->config->item('pg_schema') . 'tbl_kabupaten';
		$this->tbl_kecamatan = $this->config->item('pg_schema') . 'tbl_kecamatan';
		$this->tbl_kelurahan = $this->config->item('pg_schema') . 'tbl_kelurahan';
	}

	function get_kelurahan($id = '', $limit = '', $kd_kecamatan = '', $go_page = '', $start = '', $halt_at = '', $cari = '', $cari1 = '', $cari2 = '', $cari3 = '')
	{

		if ($id != '') {
			$id = explode('.', $id);
			$this->db->where('kd_propinsi', $id[0]);
			$this->db->where('kd_kabupaten', $id[1]);
			$this->db->where('kd_kecamatan', $id[2]);
			$this->db->where('kd_kelurahan', $id[3]);
			$query = $this->db->get($this->tbl);
			return $query->row();
		} else {

			if ($go_page != '') {
				$this->db->limit($halt_at, $start);
			}
			if ($limit != '') {
				$this->db->limit($limit);
			}
			if ($cari != '') {
				$this->db->like('tbl_kelurahan.nama', $cari);
			}
			if ($cari1 != '') {
				$this->db->where('tbl_kelurahan.kd_propinsi', $cari1);
			}
			if ($cari2 != '') {
				$this->db->where('tbl_kelurahan.kd_kabupaten', $cari2);
			}
			if ($cari2 != '') {
				$this->db->where('tbl_kelurahan.kd_kecamatan', $cari3);
			}
			$this->db->order_by('kd_kelurahan', 'asc');
			$query = $this->db->get($this->tbl);

			return $query->result();
		}
	}

	public function get_kecamatan_sppt_form($kd_propinsi = '', $kd_kabupaten = '', $kd_kecamatan = '')
	{
		$where = array(
			'kd_propinsi' => $kd_propinsi,
			'kd_kabupaten' => $kd_kabupaten,
			'kd_kecamatan' => $kd_kecamatan,
		);
		$data = $this->db->get_where('tbl_kelurahan', $where)->result();

		return $data;
	}

	public function get_kelurahan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan)
	{
		$this->db->where('kd_kelurahan', $kd_kelurahan);
		$this->db->where('kd_kecamatan', $kd_kecamatan);
		$this->db->where('kd_kabupaten', $kd_kabupaten);
		$this->db->where('kd_propinsi', $kd_propinsi);
		$query = $this->db->get($this->tbl);
		return $query->result_array();
	}

	function get_kecamatan($kd_dati2 = '')
	{
		if ($id != '') {
			if ($kd_dati2 != '') {
				$this->db->where("kd_kabupaten = '$kd_dati2'");
			}
			$query = $this->db->get($this->tbl_kecamatan);
			return $query->row();
		} else {
			if ($kd_dati2 != '') {
				$this->db->where("kd_kabupaten ='$kd_dati2'");
			}
			$this->db->order_by('kd_kecamatan', 'asc');
			$query = $this->db->get($this->tbl_kecamatan);
			//echo $this->db->last_query();exit;
			return $query->result();
		}
	}

	public function getKecamatanOption($kd_propinsi = '', $kd_kabupaten = '')
	{
		$data = $this->db->get_where('tbl_kecamatan', array(
			'kd_propinsi'  => $kd_propinsi,
			'kd_kabupaten' => $kd_kabupaten,
		));

		return $data->result();
	}

	function count_kelurahan($cari = '', $cari1 = '', $cari2 = '', $cari3 = '')
	{

		// if( ! empty($id)){ $this->db->where("id_kelurahan LIKE '$id.%'"); }
		if ($cari != '') {
			$this->db->like('tbl_kelurahan.nama', $cari);
		}
		if ($cari1 != '') {
			$this->db->where('tbl_kelurahan.kd_propinsi', $cari1);
		}
		if ($cari2 != '') {
			$this->db->where('tbl_kelurahan.kd_kabupaten', $cari2);
		}
		if ($cari2 != '') {
			$this->db->where('tbl_kelurahan.kd_kecamatan', $cari3);
		}

		$this->db->from($this->tbl);
		return $this->db->count_all_results();
	}

	function add_kelurahan($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $nama)
	{
		$add_data = array('kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_dati2, 'kd_kecamatan' => $kd_kecamatan, 'kd_kelurahan' => $kd_kelurahan, 'nama' => $nama);
		if ($this->db->insert($this->tbl, $add_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function edit_kelurahan($data, $nama, $kd_kelurahan = '', $kd_propinsi, $kd_dati2, $kd_kecamatan)
	{

		if ($kd_kelurahan != '') {
			$ed_data = array('kd_kelurahan' => $kd_kelurahan, 'nama' => $nama, 'kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_dati2, 'kd_kecamatan' => $kd_kecamatan);
		} else {
			$ed_data = array('nama' => $nama, 'kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_dati2, 'kd_kecamatan' => $kd_kecamatan);
		}
		$this->db->where('kd_propinsi', $data[0]);
		$this->db->where('kd_kabupaten', $data[1]);
		$this->db->where('kd_kecamatan', $data[2]);
		$this->db->where('kd_kelurahan', $data[3]);

		if ($this->db->update($this->tbl, $ed_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}
		return FALSE;
	}

	function delete_kelurahan($id)
	{
		$data = explode('.', $id);
		$this->db->where('kd_propinsi', $data[0]);
		$this->db->where('kd_kabupaten', $data[1]);
		$this->db->where('kd_kecamatan', $data[2]);
		$this->db->where('kd_kelurahan', $data[3]);
		if ($this->db->delete($this->tbl)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function check_kelurahan($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $nama)
	{
		if ($kd_propinsi != '' && $kd_dati2 != '' && $kd_kecamatan != '' && $kd_kelurahan != '' && $nama != '') {

			$this->db->where('kd_propinsi', $kd_propinsi);
			$this->db->where('kd_kabupaten', $kd_dati2);
			$this->db->where('kd_kecamatan', $kd_kecamatan);
			$this->db->where('kd_kelurahan', $kd_kelurahan);
			$this->db->where('nama', $nama);
			$query = $this->db->get($this->tbl);
			return $query->row();
		}
	}
}

/* EoF */