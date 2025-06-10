<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_aprove_sspd extends CI_Model {

		public function get_sspd($ppat='')
		{
			$sql='select * from tbl_sptpd where id_ppat = "'.$ppat.'" and aprove_ppat = "0"';
			$data = $this->db->query($sql);
			// echo $this->db->last_query();
			return $data->result();
		}	

	public function acc_sspd($id)
	{
		$sql = "update tbl_sptpd set aprove_ppat = 1  where id_sptpd=".$id;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();exit();
		if ($data) {
			return true;
		}

		return false;
	}

    public function rejectDokumen($param='')
    {
        $object = array(
                        'is_lunas'      => 3, 
                        'alasan_reject' => $param['alasan_reject'],
                        'aprove_ppat'   => '-1',
                       );
        $this->db->where('no_dokumen', $param['no_dokumen']);
        $this->db->update('tbl_sptpd', $object);

        return true;
    }	

}

/* End of file mod_aprove_sspd.php */
/* Location: ./application/models/mod_aprove_sspd.php */