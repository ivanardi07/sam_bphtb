<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_pbb.php
 * Description: PBB model
 * Date created: 2011-04-19
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_pbb extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_bukti_terima_surat';
    }

    function get_nop_pbb($id = '', $limit = '', $nop = '', $date_start = '', $date_end = '', $go_page = '', $start = '', $halt_at = '')
    {
        if (!empty($id)) {
            $this->db->where('nop', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            if (!empty($limit)) {
                $this->db->limit($limit);
            }
            if (!empty($date_start)) {
                $this->db->where("tanggal_jatuh_tempo BETWEEN '$date_start' AND '$date_end'");
            }
            if (!empty($nop)) {
                $this->db->where("nop LIKE '%$nop%'");
            }
            $this->db->order_by('nop', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function count_nop_pbb($nop = '', $date_start = '', $date_end = '')
    {
        if (!empty($date_start)) {
            $this->db->where("tanggal_jatuh_tempo BETWEEN '$date_start' AND '$date_end'");
        }
        if (!empty($nop)) {
            $this->db->where("nop LIKE '%$nop%'");
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function sum_pbb_bayar($nop = '', $date_start = '', $date_end = '')
    {
        if (!empty($date_start)) {
            $this->db->where("tanggal_jatuh_tempo BETWEEN '$date_start' AND '$date_end'");
        }
        if (!empty($nop)) {
            $this->db->where("nop LIKE '%$nop%'");
        }
        $this->db->select("SUM(pbb_bayar) AS grand_total");
        $query = $this->db->get($this->tbl);
        return $query->row();
    }
}

/* EoF */