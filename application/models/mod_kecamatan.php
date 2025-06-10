<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_kecamatan.php
 * Description: Kecamatan model
 * Date created: 2011-03-08
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_kecamatan extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tbl           = $this->config->item('pg_schema') . 'tbl_kecamatan';
		$this->tbl_kelurahan = $this->config->item('pg_schema') . 'tbl_kelurahan';
	}

	function get_kecamatan($id = '', $limit = '', $kd_dati2 = '', $go_page = '', $start = '', $halt_at = '', $search = '', $search1 = '', $search2 = '')
	{
		if ($id != '') {
			$id = explode('.', $id);

			if ($kd_dati2 != '') {
				$this->db->where("kd_kabupaten = '$kd_dati2'");
			}
			$this->db->where('kd_propinsi', $id[0]);
			$this->db->where('kd_kabupaten', $id[1]);
			$this->db->where('kd_kecamatan', $id[2]);
			$this->db->like('nama', $search);
			$this->db->like('kd_propinsi', $search1);
			$this->db->like('kd_kabupaten', $search2);
			$query = $this->db->get($this->tbl);
			return $query->row();
		} else {
			if ($go_page != '') {
				$this->db->limit($halt_at, $start);
			}
			if ($limit != '') {
				$this->db->limit($limit);
			}
			if ($kd_dati2 != '') {
				$this->db->where('kd_kabupaten', $kd_dati2);
			}
			if ($search1 != '') {
				$this->db->like('kd_propinsi', $search1);
			}
			if ($search2 != '') {
				$this->db->like('kd_kabupaten', $search2);
			}
			if ($search != '') {
				$this->db->like('tbl_kecamatan.nama', $search);
			}
			$this->db->order_by('kd_kecamatan', 'asc');
			$query = $this->db->get($this->tbl);
			// echo $this->db->last_query();exit;
			return $query->result();
		}
	}

	public function get_kecamatan_sppt_form($kd_propinsi = '', $kd_kabupaten = '')
	{
		$where = array(
			'kd_propinsi' => $kd_propinsi,
			'kd_kabupaten' => $kd_kabupaten,
		);
		$data = $this->db->get_where('tbl_kecamatan', $where)->result();

		return $data;
	}

	public function get_kecamatan_cek($kd_propinsi, $kd_kabupaten, $kd_kecamatan)
	{
		$this->db->where('kd_kecamatan', $kd_kecamatan);
		$this->db->where('kd_kabupaten', $kd_kabupaten);
		$this->db->where('kd_propinsi', $kd_propinsi);
		$query = $this->db->get($this->tbl);
		return $query->result_array();
	}

	function get_kecamatancek($id = '', $kd_kabupaten, $kd_propinsi)
	{
		if ($id != '' && $kd_kabupaten != '' && $kd_propinsi != '') {
			if ($kd_dati2 != '') {
				$this->db->where("kd_kabupaten = '$kd_dati2'");
			}
			$this->db->where('kd_kecamatan', $id);
			$this->db->where('kd_kabupaten', $kd_kabupaten);
			$this->db->where('kd_propinsi', $kd_propinsi);
			$query = $this->db->get($this->tbl);
			return $query->row();
		} else {
			if ($go_page != '') {
				$this->db->limit($halt_at, $start);
			}
			if ($limit != '') {
				$this->db->limit($limit);
			}
			if ($kd_dati2 != '') {
				$this->db->where("kd_kabupaten ='$kd_dati2'");
			}
			$this->db->order_by('kd_kecamatan', 'asc');
			$query = $this->db->get($this->tbl);
			//echo $this->db->last_query();exit;
			return $query->result();
		}
	}

	function count_kecamatan($id = '', $search1 = '', $search2 = '')
	{
		if ($id != '') {
			$this->db->where("nama LIKE '$id.%'");
		}
		if ($search1 != '') {
			$this->db->where('kd_propinsi', $search1);
		}
		if ($search2 != '') {
			$this->db->where('kd_kabupaten', $search2);
		}
		$this->db->from($this->tbl);
		return $this->db->count_all_results();
	}

	function add_kecamatan($id, $nama, $kd_propinsi, $kd_kabupaten)
	{
		$add_data = array('kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_kabupaten, 'kd_kecamatan' => $id, 'nama' => $nama);
		if ($this->db->insert($this->tbl, $add_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function edit_kecamatan($data, $nama, $kd_kecamatan = '', $kd_propinsi, $kd_kabupaten)
	{

		if ($kd_kecamatan != '') {
			$ed_data = array('kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_kabupaten, 'kd_kecamatan' => $kd_kecamatan, 'nama' => $nama);
		} else {
			$ed_data = array('kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_kabupaten, 'kd_kecamatan' => $kd_kecamatan, 'nama' => $nama);
		}
		// $this->db->where('nama', $nama);
		$this->db->where('kd_propinsi', $data[0]);
		$this->db->where('kd_kabupaten', $data[1]);
		$this->db->where('kd_kecamatan', $data[2]);

		if ($this->db->update($this->tbl, $ed_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function delete_kecamatan($id)
	{
		$data = explode('.', $id);
		$this->db->where('kd_propinsi', $data[0]);
		$this->db->where('kd_kabupaten', $data[1]);
		$this->db->where('kd_kecamatan', $data[2]);
		if ($this->db->delete($this->tbl)) {
			$this->db->where("kd_kelurahan LIKE '$id.%'");
			$this->db->delete($this->tbl_kelurahan);
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}
}

/* EoF */