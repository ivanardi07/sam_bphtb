<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_jns_setoran.php
 * Description: Jenis Setoran model
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_jns_setoran extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_jns_setoran';
    }

    function get_jns_setoran($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '')
    {
        if (!empty($id)) {
            $this->db->where('kd_setoran', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            if (!empty($limit)) {
                $this->db->limit($limit);
            }
            $this->db->order_by('kd_setoran', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function count_jns_setoran()
    {
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_jns_setoran($id, $nama)
    {
        $add_data = array('kd_setoran' => $id, 'nama' => $nama);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_jns_setoran($id, $nama)
    {
        $ed_data = array('nama' => $nama);
        $this->db->where('kd_setoran', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_jns_setoran($id)
    {
        $this->db->where('kd_setoran', $id);
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
        $this->db->where('kd_setoran', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */