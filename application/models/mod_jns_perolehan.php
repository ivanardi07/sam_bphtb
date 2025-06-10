<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_jns_perolehan.php
 * Description: Jenis Perolehan model
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_jns_perolehan extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_jns_perolehan';
    }

    function get_jns_perolehan($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nama = '')
    {
        if ($id != '') {
            $this->db->where('kd_perolehan', $id);
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
            $this->db->order_by('kd_perolehan', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function count_jns_perolehan($nama = '')
    {
        if ($nama['nama'] != '') {
            $this->db->like('nama', $nama['nama']);
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_jns_perolehan($id, $nama)
    {
        $add_data = array('kd_perolehan' => $id, 'nama' => $nama);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_jns_perolehan($id, $nama)
    {
        $ed_data = array('nama' => $nama);
        $this->db->where('kd_perolehan', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_jns_perolehan($id)
    {
        $this->db->where('kd_perolehan', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function change_status($id, $old_status)
    {
        if ($old_status == '1') {
            $nu_status = '0';
        } elseif ($old_status == '0') {
            $nu_status = '1';
        }
        $ed_data = array('is_blokir' => $nu_status);
        $this->db->where('kd_perolehan', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */