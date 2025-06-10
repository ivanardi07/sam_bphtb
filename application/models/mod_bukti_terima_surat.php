<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_bukti_terima_surat.php
 * Description: Bukti Terima Surat model
 * Date created: 2011-03-03
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_bukti_terima_surat extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_bukti_terima_surat';
    }

    function get_bukti_terima_surat($id = '', $limit = '', $nop = '', $date_in_start = '', $date_in_end = '', $go_page = '', $start = '', $halt_at = '')
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
            if (!empty($date_in_start)) {
                $this->db->where("tgl_masuk BETWEEN '$date_start' AND '$date_end'");
            }
            if (!empty($nop)) {
                $this->db->where("nop LIKE '%$nop%'");
            }
            $this->db->order_by('tgl_masuk', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function add_bukti_terima_surat($nop, $tgl_surat, $tgl_masuk, $tgl_keluar, $pemeriksaan, $masa_pajak)
    {
        $add_data = array('nop' => $nop, 'tgl_surat' => $tgl_surat, 'tgl_masuk' => $tgl_masuk, 'tgl_keluar' => $tgl_masuk, 'pemeriksaan' => $pemeriksaan, 'masa_pajak' => $masa_pajak);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_bukti_terima_surat($id, $nop, $tgl_surat, $tgl_masuk, $tgl_keluar, $pemeriksaan, $masa_pajak)
    {
        $ed_data = array('nop' => $nop, 'tgl_surat' => $tgl_surat, 'tgl_masuk' => $tgl_masuk, 'tgl_keluar' => $tgl_masuk, 'pemeriksaan' => $pemeriksaan, 'masa_pajak' => $masa_pajak);
        $this->db->where('id', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function del_bukti_terima_surat($id)
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