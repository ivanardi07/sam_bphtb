<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_propinsi.php
 * Description: Propinsi model
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_propinsi extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tbl = $this->config->item('pg_schema') . 'tbl_propinsi';
	}
	function count_propinsi($nama = '')
	{
		if ($nama['nama'] != '') {
			$this->db->like('nama', $nama['nama']);
		}
		$this->db->from($this->tbl);
		return $this->db->count_all_results();
	}
	function get_propinsi($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nama = '')
	{
		if ($id != '') {
			$this->db->where('kd_propinsi', $id);
			$query = $this->db->get($this->tbl);
			return $query->row();
		} else {
			if ($go_page != '') {
				$this->db->limit($halt_at, $start);
			}
			if ($limit != '') {
				$this->db->limit($limit);
			}
			if (@$nama['nama'] != '') {
				$this->db->like('nama', $nama['nama']);
			}
			$this->db->order_by('kd_propinsi', 'asc');
			$query = $this->db->get($this->tbl);
			return $query->result();
		}
	}

	function add_propinsi($id, $nama)
	{
		$add_data = array('kd_propinsi' => $id, 'nama' => $nama);
		if ($this->db->insert($this->tbl, $add_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function edit_propinsi($id, $nama)
	{
		$ed_data = array('nama' => $nama);
		$this->db->where('kd_propinsi', $id);
		if ($this->db->update($this->tbl, $ed_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function delete_propinsi($id)
	{
		$this->db->where('kd_propinsi', $id);
		if ($this->db->delete($this->tbl)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}
}

/* EoF */