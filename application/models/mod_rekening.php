<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_rekening.php
 * Description: Rekening model
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_rekening extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_rekening';
    }

    function get_rekening($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nama = '')
    {
        if ($id != '') {
            $this->db->where('id_rekening', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            if ($nama['nama'] != '') {
                $this->db->like('nama', $nama['nama']);
            }
            $this->db->order_by('id_rekening', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function count_rekening($nama = '')
    {
        if ($nama['nama'] != '') {
            $this->db->like('nama', $nama['nama']);
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_rekening($nama, $nomor)
    {
        $add_data = array('nama' => $nama, 'nomor' => $nomor);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_rekening($id, $nama, $nomor)
    {
        $ed_data = array('nama' => $nama, 'nomor' => $nomor);
        $this->db->where('id_rekening', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_rekening($id)
    {
        $this->db->where('id_rekening', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */