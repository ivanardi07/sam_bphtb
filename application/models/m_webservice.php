<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_webservice extends CI_Model {
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function get_data($idbilling) {
		$fix 	= substr($idbilling, 0, 6);
		$d 		= substr($idbilling, 6, 2);
		$m 		= substr($idbilling, 8, 2);
		$y 		= substr($idbilling, 10, 4);
		$order	= substr($idbilling, 14, 4);
		// $hint=intVal('090097097097');
		// echo 'a'.$hint;
		// echo '<pre>';
		// die($idbilling);
		if ( $fix == '351900') {
			$tanggal 	= $d.$m.$y;
			$ord 		= ( strlen(ltrim($order, '0')) >= 4 ) ? ltrim($order, '0') : substr($order, 0, 4);

			$sql = ' select 
						a.id_sptpd,
						b.nik,
						b.nama,
						a.no_dokumen,
						CONCAT(
								a.kd_propinsi,".",
								a.kd_kabupaten,".",
								a.kd_kecamatan,".",
								a.kd_kelurahan,".",
								a.kd_blok,".",
								a.no_urut,".",
								a.kd_jns_op
							) as nop,
						b.alamat,
						b.nik,
						a.jumlah_setor,
						a.validasi_dispenda,
						a.validasi_bank,
						a.is_kurang_bayar,
						a.id_ppat,
						a.jumlah_setor,
						a.idbilling
						from tbl_sptpd a
						join tbl_nik b on b.nik = a.nik
						where idbilling = "'.$idbilling.'"';
			
	      	// $this->db->where('SUBSTRING( id_billing, 7, 8 ) = ',$tanggal);
	      
	    	$result = $this->db->query($sql)->result();
	    	// $a= $this->db->last_query();
	    	// echo $this->db->last_query();
	    	return $result;
	    } else {
	    	return false;
	    }
    }

    public function change_flag($idbilling)
    {
    	$fix 	= substr($idbilling, 0, 6);
		$d 		= substr($idbilling, 6, 2);
		$m 		= substr($idbilling, 8, 2);
		$y 		= substr($idbilling, 10, 4);
		$order	= substr($idbilling, 14, 4);
		
		$sql ='select jumlah_setor from tbl_sptpd where idbilling='.$idbilling;
		$jml = $this->db->query($sql)->row();
		$jumlah_setor = $jml->jumlah_setor;
		// echo $jumlah_setor_baru;exit();

		if ( $fix == '351900') {
			$tanggal 	= $d.$m.$y;
			$ord 		= ( strlen(ltrim($order, '0')) >= 4 ) ? ltrim($order, '0') : substr($order, 0, 4);

	    	$this->db->where('idbilling = ',$idbilling);
	    	$this->db->where('validasi_dispenda is NOT NULL', NULL, FALSE);

	    	$data = [
					'validasi_bank'         => 'bank_'.date('Y-m-d H:i:s'),
					'tgl_validasi_bank'     => date('Y-m-d'),
					'validasi_dispenda'     => date('Y-m-d'),
					'tgl_validasi_dispenda' => date('Y-m-d'),
					'is_lunas'              => '1',
					'is_kurang_bayar'       => '0',
					'jumlah_setor'          => $jumlah_setor
	    	];

	    	$sts = $this->db->update('tbl_sptpd', $data);
	    	$row = $this->db->affected_rows();

	    	$result = [
	    		'sts' => $sts,
	    		'row' => $row
	    	];

	    	return $result;
	    } else {
	    	return false;
	    }
    }
}