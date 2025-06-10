<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_ptdpd.php
 * Description: SPTPD model
 * Date created: 2011-03-18
 * Author: Your Name (your@email.com)
 */
class Mod_sptpd extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_sptpd';
    }

    function get_sptpd($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '')
    {
        if (!empty($id)) {
            $this->db->where('id_sptpd', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            if (!empty($limit)) {
                $this->db->limit($limit);
            }
            $this->db->order_by('id_sptpd', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function check_nop($nop)
    {
        if (!empty($nop)) {
            $this->db->where('nop', $nop);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function count_sptpd()
    {
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_sptpd($password, $nama, $nip, $alamat, $email, $tipe = 'D', $is_blokir)
    {
        $add_data = array('password' => $password, 'nama' => $nama, 'nip' => $nip, 'alamat' => $alamat, 'email' => $email, 'tipe' => $tipe, 'is_blokir' => $is_blokir);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_sptpd($id, $nama, $nip, $alamat, $email, $tipe, $is_blokir)
    {
        $ed_data = array('nama' => $nama, 'nip' => $nip, 'alamat' => $alamat, 'email' => $email, 'tipe' => $tipe, 'is_blokir' => $is_blokir);
        $this->db->where('id_sptpd', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_sptpd($id)
    {
        $this->db->where('id_sptpd', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */