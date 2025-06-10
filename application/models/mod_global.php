<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_global extends CI_Model {

	public function cekData($id='', $type = '')
	{
		
		if ($type == 'propinsi') {
			
			$data = $this->db->get_where('tbl_kabupaten', array('kd_propinsi' => $id))->result();

			return @$data[0]->kd_propinsi;

		}else if ($type == 'kabupaten') {

			$id = explode('.', $id);

			$object = array(
						'kd_propinsi' => $id[0],
						'kd_kabupaten' => $id[1],
					  );
			
			$data = $this->db->get_where('tbl_kecamatan', $object)->result();

			return @$data[0]->kd_kabupaten;
			
		}else if ($type == 'kecamatan') {
			
			$id = explode('.', $id);

			$object = array(
						'kd_propinsi' => $id[0],
						'kd_kabupaten' => $id[1],
						'kd_kecamatan' => $id[2],
					  );
			
			$data = $this->db->get_where('tbl_kelurahan', $object)->result();

			return @$data[0]->kd_kecamatan;
			
		}else if ($type == 'kelurahan') {
			
			$id = explode('.', $id);

			$object = array(
						'kd_propinsi' => $id[0],
						'kd_kabupaten' => $id[1],
						'kd_kecamatan' => $id[2],
						'kd_kelurahan' => $id[3],
					  );
			
			$data = $this->db->get_where('tbl_sptpd', $object)->result();

			return @$data[0]->kd_kelurahan;
			
		}else if ($type == 'nop') {
			
			$id = explode('.', $id);

			$object = array(
						'kd_propinsi' => $id[0],
						'kd_kabupaten' => $id[1],
						'kd_kecamatan' => $id[2],
						'kd_kelurahan' => $id[3],
						'kd_blok' => $id[4],
						'no_urut' => $id[5],
						'kd_jns_op' => $id[6],
					  );
			
			$data = $this->db->get_where('tbl_sptpd', $object)->result();

			return @$data[0]->no_urut;
			
		}


		
	}	

	public function getNamaBank($id='')
	{
		$data = $this->db->get_where('tbl_paymentpoint', array('id_pp' => $id))->result();

		$nama = @$data[0];

		return $nama;
	}

}

/* End of file mod_global.php */
/* Location: ./application/models/mod_global.php */