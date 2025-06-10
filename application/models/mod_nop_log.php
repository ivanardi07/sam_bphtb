<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_nop_log_log.php
 * Description: NOP Log model
 * Date created: 2011-08-03
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_nop_log extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_nop_log';
    }

    function get_nop_log($nop_lama = '', $nop_baru = '', $date_start = '', $date_end = '', $go_page = '', $start = '', $halt_at = '')
    {
        $this->db->order_by('tanggal', 'desc');
        if ($go_page != '') {
            $this->db->limit($halt_at, $start);
        }
        if (@$limit != '') {
            $this->db->limit($limit);
        }
        if ($date_start != '') {
            $this->db->where("tanggal BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59'");
        }
        if ($nop_baru != '') {
            $this->db->where('nop_baru', $nop_baru);
        }
        if ($nop_lama != '') {
            $this->db->where('nop_lama', $nop_lama);
        }
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    function count_nop_log($nop_lama = '', $nop_baru = '', $date_start = '', $date_end = '')
    {
        if ($date_start != '') {
            $this->db->where("tanggal BETWEEN '$date_start 00:00:00' AND '$date_end 23:59:59'");
        }
        if ($nop_baru != '') {
            $this->db->where('nop_baru', $nop_baru);
        }
        if ($nop_lama != '') {
            $this->db->where('nop_lama', $nop_lama);
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_nop_log($nop_lama, $nop_baru, $tanggal)
    {
        $add_data = array(
            'nop_lama' => $nop_lama,
            'nop_baru' => $nop_baru,
            'tanggal' => $tanggal
        );
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */