<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_penelitian extends CI_Model {


	public function get_propinsi($id_propinsi='')
	{
		$data = $this->db->get_where('tbl_propinsi', array(
														'kd_propinsi' => $id_propinsi
														));

		$data = $data->result();

		return @$data[0];
	}	

	public function get_kabupaten($id_propinsi='',$id_kabupaten='')
	{
		$data = $this->db->get_where('tbl_kabupaten', array(
														'kd_propinsi' => $id_propinsi,
														'kd_kabupaten' => $id_kabupaten,
														));

		$data = $data->result();

		return @$data[0];
	}	

	public function get_kecamatan($id_propinsi='',$id_kabupaten='', $id_kecamatan='')
	{
		$data = $this->db->get_where('tbl_kecamatan', array(
														'kd_propinsi' => $id_propinsi,
														'kd_kabupaten' => $id_kabupaten,
														'kd_kecamatan' => $id_kecamatan,
														));
		$data = $data->result();
		return @$data[0];
	}	

	public function get_kelurahan($id_propinsi='',$id_kabupaten='', $id_kecamatan='',$id_kelurahan='')
	{
		$data = $this->db->get_where('tbl_kelurahan', array(
														'kd_propinsi' => $id_propinsi,
														'kd_kabupaten' => $id_kabupaten,
														'kd_kecamatan' => $id_kecamatan,
														'kd_kelurahan' => $id_kelurahan,
														));

		$data = $data->result();

		return @$data[0];
	}	

}

/* End of file mod_penelitian.php */
/* Location: ./application/models/mod_penelitian.php */