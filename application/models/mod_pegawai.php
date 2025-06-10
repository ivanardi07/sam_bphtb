<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_pegawai.php
 * Description: pegawai model
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_pegawai extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tbl = 'tbl_pegawai';
	}
	function count_pegawai()
	{
		$this->db->from($this->tbl);
		return $this->db->count_all_results();
	}
	function get_pegawai($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nama = "")
	{
		if (!empty($id)) {
			$this->db->where('id', $id);
			$query = $this->db->get($this->tbl);
			return $query->row();
		} else {
			if (!empty($go_page)) {
				$this->db->limit($halt_at, $start);
			}
			if (!empty($limit)) {
				$this->db->limit($limit);
			}
			if (!empty($nama)) {
				$this->db->like('nama', $nama);
			}
			$this->db->order_by('id', 'asc');
			$query = $this->db->get($this->tbl);
			return $query->result();
		}
	}

	function add_pegawai($add)
	{
		$add_data = $add;
		if ($this->db->insert($this->tbl, $add_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function edit_pegawai($id, $data)
	{
		$ed_data = $data;
		$this->db->where('id', $id);
		if ($this->db->update($this->tbl, $ed_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function delete_pegawai($id)
	{
		$this->db->where('id', $id);
		if ($this->db->delete($this->tbl)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function ceknip($nip)
	{
		$query_str = "SELECT * FROM tbl_pegawai where nip= ?";
		$result = $this->db->query($query_str, array($nip));
		$num_rows = $result->num_rows();
		return $num_rows;
	}
}

/* EoF */