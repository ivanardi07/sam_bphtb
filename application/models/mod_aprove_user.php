<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_aprove_user extends CI_Model {

	public function get_user($value='')
		{
			$sql='select w.* from tbl_wp w join tbl_user u on u.id_user=w.id_user where u.is_blokir = 1 and w.status="1"';
			$data = $this->db->query($sql);
			return $data->result();
		}	

	public function get_user1($id_sptpd='')
		{ 
			$sql="select w.* from tbl_wp w join tbl_user u on u.id_user=w.id_user where u.is_blokir = '1' and w.status='1' and w.id_user = $id_sptpd";
			$data = $this->db->query($sql);
			return $data->row();
		}	


	public function acc_user($id)
	{
		$sql = "update tbl_user set is_blokir = 0  where id_user=".$id;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();exit();
		if ($data) {
			return true;
		}

		return false;
	}
	public function delete_user($id)
	{
		$sql = "delete from tbl_user where id_user=".$id;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();exit();
		if ($data) {
			$sql1 = "delete from tbl_wp where id_user=".$id;
			$data1 = $this->db->query($sql1);
				if ($data1) {
					return true;
				}
		}

		return false;
	}

	public function get_user_id($id)
	{
		$sql ='select w.*, u.username from tbl_wp w join tbl_user u on u.id_user=w.id_user where w.id_user='.$id;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();exit();
		return $data->row_array();

	}
	public function get_user_id_bywp($id)
	{
		$sql =' select * from tbl_wp where id_wp='.$id;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();exit();
		return $data->row_array();

	}


}

/* End of file mod_aprove_user.php */
/* Location: ./application/models/mod_aprove_user.php */