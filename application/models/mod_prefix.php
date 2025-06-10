<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_prefix.php
 * Description: prefix model
 * Date created: 2012-01-26
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_prefix extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_prefix';
    }

    function get_prefix($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '')
    {
        if ($id != '') {
            $this->db->where('id', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            $this->db->order_by('id', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function count_prefix()
    {
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_prefix($nama, $keterangan)
    {
        $add_data = array('nama' => $nama, 'keterangan' => $keterangan);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_prefix($id, $nama, $keterangan)
    {
        $ed_data = array('nama' => $nama, 'keterangan' => $keterangan);
        $this->db->where('id', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_prefix($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */