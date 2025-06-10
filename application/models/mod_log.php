<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_log.php
 * Description: log model
 * Date created: 2011-03-04
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_log extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_log';
    }

    function get_log($login_user = '', $tipe = '', $go_page = '', $start = '', $halt_at = '')
    {
        if (!empty($go_page)) {
            $this->db->limit($halt_at, $start);
        }
        if (!empty($tipe)) {
            $this->db->where("query_log LIKE '%Login%' OR query_log LIKE '%Logout%'");
        }
        if (!empty($login_user)) {
            $this->db->where('login_user', $login_user);
        }
        $this->db->order_by('date_log', 'desc');
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    function count_log($login_user = '', $tipe = '')
    {
        if (!empty($tipe)) {
            $this->db->where("query_log LIKE '%Login%' OR query_log LIKE '%Logout%'");
        }
        if (!empty($login_user)) {
            $this->db->where('login_user', $login_user);
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }
}

/* EoF */