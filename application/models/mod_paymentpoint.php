<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_paymentpoint.php
 * Description: Payment Point model
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_paymentpoint extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_paymentpoint';
        $this->tbl_user = $this->config->item('pg_schema') . 'tbl_user';
    }

    function get_paymentpoint($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $id_pp = '', $nama = '', $alamat = '')
    {
        if ($id != '') {
            $sql = "select a.*, b.username, b.password from tbl_paymentpoint a, tbl_user b Where a.id_pp = ? and b.id_user= a.id_user and b.tipe = 'PP'";
            $query = $this->db->query($sql, array($id));
            return $query->row();
        } else {
            $sql = "SELECT * FROM (tbl_paymentpoint) WHERE is_delete = 0 ";

            if (@$id_pp != '') {
                $sql .= " AND id_pp LIKE '%" . $this->db->escape_str($id_pp) . "%'";
            }
            if (@$nama != '') {
                $sql .= " AND nama LIKE '%" . $this->db->escape_str($nama) . "%'";
            }
            if (@$alamat != '') {
                $sql .= " AND alamat LIKE '%" . $this->db->escape_str($alamat) . "%'";
            }

            $sql .= " ORDER BY id_pp asc ";

            if ($go_page != '') {
                // $this->db->limit($halt_at, $start);
                $sql .= "LIMIT " . $start . "," . $halt_at;
            }

            if ($limit != '') {
                $sql .= "LIMIT " . $limit;
                // $this->db->limit($limit);
            }

            $query = $this->db->query($sql);

            return $query->result();
        }
    }

    function count_paymentpoint($id_pp = '', $nama = '', $alamat = '')
    {
        $sql = "SELECT * FROM (tbl_paymentpoint) WHERE is_delete = 0 ";

        if (@$id_pp != '') {
            $sql .= " AND id_pp LIKE '%" . $this->db->escape_str($id_pp) . "%'";
        }
        if (@$nama != '') {
            $sql .= " AND nama LIKE '%" . $this->db->escape_str($nama) . "%'";
        }
        if (@$alamat != '') {
            $sql .= " AND alamat LIKE '%" . $this->db->escape_str($alamat) . "%'";
        }

        $query = $this->db->query($sql);
        $hasil = $query->result();
        return count($hasil);
    }

    function add_paymentpoint($id, $nama, $alamat, $telepon, $nama_kepala, $username, $password)
    {

        $add_data_user = array(
            'username' => $username,
            'password' => $password,
            'tipe' => 'PP',
            'is_blokir' => 0
        );
        if ($this->db->insert($this->tbl_user, $add_data_user)) {
            $last_id_user = $this->db->insert_id();

            $add_data = array(

                'id_user' => $last_id_user,
                'id_pp' => $id,
                'nama' => $nama,
                'alamat' => $alamat,
                'telepon' => $telepon,
                'nama_kepala' => $nama_kepala
            );
            $this->db->insert($this->tbl, $add_data);

            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_paymentpoint($id_pp = '', $id_user = '', $nama = '', $alamat = '', $telepon = '', $nama_kepala = '', $password = '')
    {
        if ($password != '') {

            $sql_user = "UPDATE tbl_user SET password = ? WHERE id_user = ?";
            $proses_user = $this->db->query($sql_user, array($password, $id_user));
        }

        $sql_paymentpoint = "UPDATE tbl_paymentpoint SET nama=?,alamat=?,telepon=?,nama_kepala=? WHERE id_pp = ?";
        $proses_ppat = $this->db->query($sql_paymentpoint, array($nama, $alamat, $telepon, $nama_kepala, $id_pp));

        $this->antclass->go_log($this->db->last_query());
        return TRUE;
    }

    function delete_paymentpoint($id, $id_user)
    {
        $sql_paymentpoint = "Update tbl_paymentpoint set is_delete = '1' where id_pp = ?";

        $proses1 = $this->db->query($sql_paymentpoint, array($id));


        $sql_user = "Update tbl_user set is_delete = '1' where id_user = ?";

        $proses2 = $this->db->query($sql_user, array($id_user));


        $this->antclass->go_log($this->db->last_query());

        return TRUE;
    }

    function cek_username($cu)
    {
        $query_str = "SELECT * FROM tbl_user where username= ?";
        $result = $this->db->query($query_str, array($cu));
        $num_rows = $result->num_rows();
        return $num_rows;
    }
}

/* EoF */