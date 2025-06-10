<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_dati2.php
 * Description: Dati2 model
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_dati2 extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_kabupaten';
    }

    function get_dati2($id = '', $limit = '', $kd_propinsi = '', $go_page = '', $start = '', $halt_at = '', $propinsi = '', $kabupaten = '')
    {
        if ($id != '') {
            if ($kd_propinsi != '') {
                $this->db->where("kd_propinsi = '$kd_propinsi'");
            }
            $this->db->where('kd_kabupaten', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($kd_propinsi != '') {
                $this->db->where("kd_propinsi = '$kd_propinsi'");
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            if ($propinsi != '') {
                $this->db->where('kd_propinsi', $propinsi);
            }
            if ($kabupaten != '') {
                $this->db->like('nama', $kabupaten);
            }
            $this->db->order_by('kd_kabupaten', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }
    function count_dati2($propinsi = '', $kabupaten = '')
    {
        if ($propinsi != '') {
            $this->db->where('kd_propinsi', $propinsi);
        }
        if ($kabupaten != '') {
            $this->db->like('nama', $kabupaten);
        }

        $this->db->from($this->tbl);

        return $this->db->count_all_results();
    }
    function add_dati2($kd_propinsi, $kd_dati, $nama)
    {

        $add_data = array('kd_propinsi' => $kd_propinsi, 'kd_kabupaten' => $kd_dati, 'nama' => $nama);
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    // function edit_dati2($id, $nama = '', $kd_dati = '', $kd_propinsi = '', $kd_propinsi_new = '')
    function edit_dati2($data_update, $data_where)
    {
        $this->db->where($data_where);
        if ($this->db->update($this->tbl, $data_update)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        } else {
            return FALSE;
        }

        // if( ! empty($kd_dati))
        //    { 
        //        $ed_data = array('kd_propinsi'=>$kd_propinsi_new,
        //                         'kd_kabupaten'=>$kd_dati, 
        //                         'nama'=>$nama); 
        //    }
        //    else
        //    { 
        //        $ed_data = array('nama'=>$nama); 
        //    }
        //    $this->db->where('kd_kabupaten', $id);
        //    $this->db->where('kd_propinsi', $kd_propinsi);
        //    if($this->db->update($this->tbl, $ed_data))
        //    {
        //        return $this->db->last_query();
        //        $this->antclass->go_log($this->db->last_query());
        //        return TRUE;
        //    }

        //    return FALSE;
    }

    function delete_dati2($id = "", $kode_propinsi = "")
    {
        $this->db->where('kd_kabupaten', $id);
        $this->db->where('kd_propinsi', $kode_propinsi);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            // $this->db->last_query();
            // exit();
            return TRUE;
        }

        return FALSE;
    }

    function get_dati($id = '', $kd_propinsi = '')
    {
        if ($id != '' && $kd_propinsi != '') {
            if ($id != '') {
                $this->db->where("kd_kabupaten = '$id'");
            }
            if ($kd_propinsi != '') {
                $this->db->where("kd_propinsi = '$kd_propinsi'");
            }
            $query = $this->db->get($this->tbl);
            return $query->row();
        }
    }
}

/* EoF */