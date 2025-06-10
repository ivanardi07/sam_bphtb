<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report_penerimaan_bank extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->tbl = 'tbl_sptpd';
	}
	public function getReport($param='', $limit, $offset)
	{
		$type_user = $this->session->userdata('s_tipe_bphtb');

		if ($param['tgl_awal'] != '' && $param['tgl_akhir'] != '') {
			$this->db->where('tanggal >=', $param['tgl_awal']);
			$this->db->where('tanggal <=', $param['tgl_akhir']);
		}
		
		if ($param['bank'] != '') {
			$this->db->where('id_bank', $param['bank']);
		}

		$this->db->select($this->tbl.'.*, tbl_paymentpoint.nama as nama_bank, tbl_nik.nama as nama_pembeli, tbl_nik.alamat as alamat_pembeli, tbl_nop.nama_penjual, tbl_nop.alamat_penjual');
		$this->db->where('validasi_dispenda !=', '');
		$this->db->where('validasi_bank !=', '');
		$this->db->where('tgl_validasi_dispenda !=', '');
		$this->db->where('tgl_validasi_bank !=', '');
		$this->db->where('is_lunas', 1);
		$this->db->from($this->tbl);
		$this->db->join('tbl_paymentpoint', 'tbl_paymentpoint.id_pp = tbl_sptpd.id_bank', 'left');
		$this->db->join('tbl_nik', 'tbl_nik.nik = tbl_sptpd.nik', 'left');
		$where = "tbl_nop.kd_propinsi = tbl_sptpd.kd_propinsi AND tbl_nop.kd_kabupaten = tbl_sptpd.kd_kabupaten AND tbl_nop.kd_kecamatan = tbl_sptpd.kd_kecamatan AND tbl_nop.kd_kelurahan = tbl_sptpd.kd_kelurahan AND tbl_nop.kd_blok = tbl_sptpd.kd_blok AND tbl_nop.no_urut = tbl_sptpd.no_urut AND tbl_nop.kd_jns_op = tbl_sptpd.kd_jns_op AND tbl_nop.thn_pajak_sppt = YEAR(tbl_sptpd.tanggal)
				 ";
        if ($type_user == 'PT') {
            $id_ppat = $this->session->userdata('s_id_ppat');
            $this->db->where('id_ppat',$id_ppat);
        }
		$this->db->join('tbl_nop', $where, 'left');
		$this->db->limit($limit,$offset);
		$data = $this->db->get()->result();
		
		return $data;
	}	

	public function countReport($param='')
	{
		$type_user = $this->session->userdata('s_tipe_bphtb');
		
		if ($param['tgl_awal'] != '' && $param['tgl_akhir'] != '') {
			$this->db->where('tanggal >=', $param['tgl_awal']);
			$this->db->where('tanggal <=', $param['tgl_akhir']);
		}
		
		if ($param['bank'] != '') {
			$this->db->where('id_bank', $param['bank']);
		}

		$this->db->select($this->tbl.'.*, tbl_paymentpoint.nama as nama_bank, tbl_nik.nama as nama_pembeli, tbl_nik.alamat as alamat_pembeli, tbl_nop.nama_penjual, tbl_nop.alamat_penjual');
		$this->db->where('validasi_dispenda !=', '');
		$this->db->where('validasi_bank !=', '');
		$this->db->where('tgl_validasi_dispenda !=', '');
		$this->db->where('tgl_validasi_bank !=', '');
		$this->db->where('is_lunas', 1);
		$this->db->from($this->tbl);
		$this->db->join('tbl_paymentpoint', 'tbl_paymentpoint.id_pp = tbl_sptpd.id_bank', 'left');
		$this->db->join('tbl_nik', 'tbl_nik.nik = tbl_sptpd.nik', 'left');
		$where = "tbl_nop.kd_propinsi = tbl_sptpd.kd_propinsi AND tbl_nop.kd_kabupaten = tbl_sptpd.kd_kabupaten AND tbl_nop.kd_kecamatan = tbl_sptpd.kd_kecamatan AND tbl_nop.kd_kelurahan = tbl_sptpd.kd_kelurahan AND tbl_nop.kd_blok = tbl_sptpd.kd_blok AND tbl_nop.no_urut = tbl_sptpd.no_urut AND tbl_nop.kd_jns_op = tbl_sptpd.kd_jns_op AND tbl_nop.thn_pajak_sppt = YEAR(tbl_sptpd.tanggal)
				 ";
		if ($type_user == 'PT') {
            $id_ppat = $this->session->userdata('s_id_ppat');
            $this->db->where('id_ppat',$id_ppat);
        }
		$this->db->join('tbl_nop', $where, 'left');
		$data = $this->db->get()->result();
		
		$array = array(
			'ses_sql_laporan' => $this->db->last_query()
		);
		
		$this->session->set_userdata( $array );
		
		return count($data);
	}
	public function getBank()
	{
		$this->db->where('is_delete', 0);
		$data = $this->db->get('tbl_paymentpoint')->result();
		return $data;
	}

}

/* End of file M_report_penerimaan_bank.php */
/* Location: ./application/models/M_report_penerimaan_bank.php */