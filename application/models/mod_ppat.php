<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

/**
 * Filename: mod_ppat.php
 * Description: PPAT model
 * Date created: 2011-03-08
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_ppat extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl      = $this->config->item('pg_schema') . 'tbl_ppat';
        $this->tbl_user = $this->config->item('pg_schema') . 'tbl_user';
    }

    public function get_ppat($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $id_ppat = '', $nama = '', $alamat = '')
    {
        if ($id != '') {

            $sql   = "select a.*, b.username, b.password, b.exp_date from tbl_ppat a, tbl_user b Where a.id_ppat = ? and b.id_user= a.id_user and b.tipe = 'PT'";
            $query = $this->db->query($sql, array($id));
            return $query->row();
        } else {
            $sql = "SELECT * FROM (tbl_ppat) WHERE is_delete = 0 ";

            if ($id_ppat != '') {
                $sql .= " AND id_ppat LIKE '%" . $this->db->escape_str($id_ppat) . "%'";
            }
            if ($nama != '') {
                $sql .= " AND nama LIKE '%" . $this->db->escape_str($nama) . "%'";
            }
            if ($alamat != '') {
                $sql .= " AND alamat LIKE '%" . $this->db->escape_str($alamat) . "%'";
            }
            //  if(! empty($id_ppat && $nama && $alamat))
            //  {
            // $sql .= " AND (id_ppat LIKE '%".$this->db->escape_str($id_ppat['id_ppat'])."%'
            //           OR nama LIKE '%".$this->db->escape_str($nama['nama'])."%'
            //           OR alamat LIKE '%".$this->db->escape_str($alamat['alamat'])."%')";
            //  }

            $sql .= " ORDER BY id_ppat asc";

            if ($go_page != '') {
                $sql .= " LIMIT " . $start . "," . $halt_at;
            }
            if ($limit != '') {
                $sql .= " LIMIT " . $limit;
            }

            // $this->db->where('is_delete', 0);
            //    $this->db->order_by('id_ppat','asc');

            //    $query = $this->db->get($this->tbl);
            $query = $this->db->query($sql);

            return $query->result();
        }
    }

    public function get_ppat_byusername($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get($this->tbl);
        return $query->row();
    }

    public function count_ppat($id_ppat, $nama, $alamat)
    {
        $sql = "SELECT * FROM (tbl_ppat) WHERE is_delete = 0 ";

        if ($id_ppat != '') {
            $sql .= " AND id_ppat LIKE '%" . $this->db->escape_str($id_ppat) . "%'";
        }
        if ($nama != '') {
            $sql .= " AND nama LIKE '%" . $this->db->escape_str($nama) . "%'";
        }
        if ($alamat != '') {
            $sql .= " AND alamat LIKE '%" . $this->db->escape_str($alamat) . "%'";
        }

        $query = $this->db->query($sql);
        $hasil = $query->result();
        return count($hasil);
        //return $this->db->count_all_results();
    }

    public function add_ppat($id, $nama, $alamat, $username, $password, $exp_date)
    {
        $add_data_user = array(
            'username'  => $username,
            'password'  => $password,
            'tipe'      => 'PT',
            'is_blokir' => 0,
            'exp_date'  => changeDateFormat('database', $exp_date),
        );
        if ($this->db->insert($this->tbl_user, $add_data_user)) {
            $last_id_user = $this->db->insert_id();

            $add_data = array(
                'id_user' => $last_id_user,
                'id_ppat' => $id,
                'nama'    => $nama,
                'alamat'  => $alamat,
            );

            $this->db->insert($this->tbl, $add_data);

            $this->antclass->go_log($this->db->last_query());
            return true;
        }

        return false;
    }

    public function edit_ppat($id_ppat = '', $id_user = '', $nama = '', $alamat = '', $password = '', $exp_date = '')
    {

        if ($password != '') {

            $object = array(
                'password' => $password,
                'exp_date' => changeDateFormat('database', $exp_date),
            );

            $this->db->where('id_user', $id_user);
            $this->db->update('tbl_user', $object);
        }

        $obj_ppat = array(
            'nama'   => $nama,
            'alamat' => $alamat,

        );
        $this->db->where('id_ppat', $id_ppat);
        $this->db->update('tbl_ppat', $obj_ppat);

        $this->antclass->go_log($this->db->last_query());

        return true;

        //    if( ! empty($password))
        //       {
        //           $ed_data = array('nama'=>$nama, 'alamat'=>$alamat);
        //           $ed_data_user = array('password'=>$password,'tipe'=>'PT', 'is_blokir'=>0,'id_user'=>$id_user);
        //       }
        //       else
        //       {
        //           $ed_data = array('nama'=>$nama, 'alamat'=>$alamat);
        //           $ed_data_user = array('tipe'=>'PT', 'is_blokir'=>0,'id_user'=>$id_user);
        //       }
        //       $this->db->where('id_ppat', $id);
        //       if($this->db->update($this->tbl, $ed_data))
        // {
        //     $sql = "UPDATE tbl_user SET password=?,tipe = 'PT',is_blokir=0 WHERE id_user = ?";
        //     $proses = $this->db->query($sql,array($ed_data_user));
        //     $this->antclass->go_log($this->db->last_query());
        //     return TRUE;
        // }

        // return FALSE;
    }

    public function delete_ppat($id, $id_user)
    {
        $sql_ppat = "Update tbl_ppat set is_delete = '1' where id_ppat = ?";

        $proses1 = $this->db->query($sql_ppat, array($id));

        $sql_user = "Update tbl_user set is_delete = '1' where id_user = ?";

        $proses2 = $this->db->query($sql_user, array($id_user));

        $this->antclass->go_log($this->db->last_query());

        return true;
    }

    public function cek_username($cu)
    {
        $query_str = "SELECT * FROM tbl_user where username= ?";
        $result    = $this->db->query($query_str, array($cu));
        $num_rows  = $result->num_rows();
        return $num_rows;
    }
}

/* EoF */
