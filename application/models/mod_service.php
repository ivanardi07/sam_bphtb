<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_service extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->tbl ='tbl_user';
		$this->sismiop = $this->load->database('oracle', TRUE);
	}

	public function login($param)
	{
		$this->db->where('username', trim($param['username']));
		$this->db->where('password', md5(trim($param['password'])));
        $this->db->where('is_blokir', 0);
        $this->db->where('is_delete', 0);
        $this->db->limit(1);
        $query = $this->db->get($this->tbl)->result_array();
		
		return @$query[0];
	}

	public function cekTblNop($nop)
	{
		$this->db->where('CONCAT(kd_propinsi, kd_kabupaten, kd_kecamatan, kd_kelurahan, kd_blok, no_urut, kd_jns_op) =', $nop, FALSE);
		$data = $this->db->get('tbl_nop');
	
		return $data->result();
	}

	public function getNik($nik='')
	{
		$this->db->limit(1);
		$this->db->where('nik', $nik);
		$data = $this->db->get('tbl_nik')->result_array();

		return @$data[0];
	}

	public function getDetailSSPD($no_sspd='')
	{
		$this->db->limit(1);
		$this->db->where('no_sspd', $no_sspd);
		$data = $this->db->get('tbl_detail_sptpd')->result_array();

		return @$data[0];
	}

	public function cariSspd($param='')
	{
		$this->db->limit(1);
		$this->db->where('no_dokumen', $param['no_sspd']);
        $query 	= $this->db->get('tbl_sptpd')->result_array();
		$data 	= @$query[0];
		$wp 	= $this->getNik($data['nik']);
		
		$nop  	= $data['kd_propinsi'].'.'.$data['kd_kabupaten'].'.'.$data['kd_kecamatan'].'.'.$data['kd_kelurahan'].'.'.$data['kd_blok'].'.'.$data['no_urut'].'.'.$data['kd_jns_op'];

		$propinsi 		= $this->getPropinsi($data);
		$kabupaten 		= $this->getKabupaten($data);
		$kelurahan 		= $this->getKelurahan($data);
		$kecamatan 		= $this->getKecamatan($data);
		$detail_sspd 	= $this->getDetailSSPD($param['no_sspd']);
		
		$foto 			= json_decode(@$detail_sspd['foto_sspd']); 
		for ($i=0; $i < count($foto) ; $i++) { 
			$url_foto[] = base_url().'assets/foto_lokasi/'.$foto[$i];
		}

		if (count(@$url_foto) == 0) {
			$url_foto = array();
		}

		// $output = ;

		$out = array('0' => array(
						'no_dokumen' => $data['no_dokumen'] , 
						'nik' 		 => $data['nik'] , 
						'nama_wp' 	 => $wp['nama'] , 
						'alamat_wp'  => $wp['alamat'] ,
						'nop'  		 => $nop ,
						'propinsi'   => $propinsi['nama'] ,
						'kabupaten'  => $kabupaten['nama'] ,
						'kecamatan'  => $kecamatan['nama'] ,
						'kelurahan'  => $kelurahan['nama'] ,
						'detail'	 => array(
											'latitude'	=> $detail_sspd['latitude'],
											'longitude'	=> $detail_sspd['longitude'],
											'foto' 		=> @$url_foto
										)
				  		)
				);

		return $out;
	}

	public function getPropinsi($param='')
	{
		$this->db->where('kd_propinsi', $param['kd_propinsi']);
		$data = $this->db->get('tbl_propinsi')->result_array();

		return @$data[0];
	}

	public function getKabupaten($param='')
	{
		$this->db->where('kd_propinsi', $param['kd_propinsi']);
		$this->db->where('kd_kabupaten', $param['kd_kabupaten']);
		$data = $this->db->get('tbl_kabupaten')->result_array();

		return @$data[0];
	}

	public function getKecamatan($param='')
	{
		$this->db->where('kd_propinsi', $param['kd_propinsi']);
		$this->db->where('kd_kabupaten', $param['kd_kabupaten']);
		$this->db->where('kd_kecamatan', $param['kd_kecamatan']);
		$data = $this->db->get('tbl_kecamatan')->result_array();

		return @$data[0];
	}

	public function getKelurahan($param='')
	{
		$this->db->where('kd_propinsi', $param['kd_propinsi']);
		$this->db->where('kd_kabupaten', $param['kd_kabupaten']);
		$this->db->where('kd_kecamatan', $param['kd_kecamatan']);
		$this->db->where('kd_kelurahan', $param['kd_kelurahan']);
		$data = $this->db->get('tbl_kelurahan')->result_array();

		return @$data[0];
	}

	public function cek_sspd($param='')
	{
		$max_foto = 5;

		$this->db->where('no_sspd', $param['no_sspd']);
		$jumlah_data = $this->db->get('tbl_detail_sptpd')->num_rows();

		return $jumlah_data;
		
	}

	public function simpan_detail_sspd($param='')
	{
		// $this->db->insert('Table', $object);
		$file = json_decode($param['foto']);
		$no = 1;
		foreach ($file as $key => $value) {
			$nama_file = date('Ymdhis').$no.'.jpg';
			$file_path = 'assets/foto_lokasi/'.$nama_file;
			$file 	   = $value->foto;
			decode_image($file,$file_path);
			$no++;

			$data_foto[] = $nama_file;

			// resize image
			resize_image($file_path, 800, 600);
		}

		$cek_gambar = $this->getDetailSSPD($param['no_sspd']);

		if (@$cek_sspd['foto_sspd'] != '') {
			$foto = json_decode(@$cek_sspd['foto_sspd']);
			foreach ($foto as $key => $value) {
				unlink('assets/foto_lokasi/'.$value);
			}
		}

		$data_detail = array(
			'no_sspd'	=> $param['no_sspd'],
			'foto_sspd'	=> json_encode($data_foto),
			'latitude'	=> $param['latitude'],
			'longitude'	=> $param['longitude'],
		);

		if ($param['status'] == 'add') {
			$this->db->insert('tbl_detail_sptpd', $data_detail);
		}else if ($param['status'] == 'edit'){
			$no_sspd = $param['no_sspd'];
			unset($data_detail['no_sspd']);
			$this->db->where('no_sspd', $no_sspd);
			$this->db->update('tbl_detail_sptpd', $data_detail);
		}
		
		

		return $this->db->affected_rows();
	}

	public function autoSspd($param='')
	{
		$this->db->select('no_dokumen as no_sspd');
		$this->db->from('tbl_sptpd');
		$this->db->like('no_dokumen', $param['no_sspd']);
		$data = $this->db->get()->result_array();

		$out = array(
				 'data' => $data
			   );
		return $out;
	}

	public function loadAllSspd()
	{
		$this->db->select('no_dokumen as no_sspd');
		$this->db->from('tbl_sptpd');
		$data = $this->db->get()->result_array();

		$out = array(
				 'data' => $data
			   );
		return $out;
	}

	function get_detail_nop($nop,$tahun){
//$sql = "SELECT A.*,K.NM_KECAMATAN,P.NM_PROPINSI,T.NM_DATI2,
// (A.NJOP_BUMI_SPPT / A.LUAS_BUMI_SPPT) AS NILAI_PER_M2_BUMI,
// (CASE WHEN A.LUAS_BNG_SPPT = 0
// THEN 0
// ELSE (A.NJOP_BNG_SPPT / A.LUAS_BNG_SPPT) 
// END) AS NILAI_PER_M2_BNG
// FROM
// 	SPPT A
// LEFT JOIN DAT_OBJEK_PAJAK D ON A .KD_PROPINSI = D .KD_PROPINSI
// AND A .KD_DATI2 = D .KD_DATI2
// AND A .KD_KECAMATAN = D .KD_KECAMATAN
// AND A .KD_KELURAHAN = D .KD_KELURAHAN
// AND A .KD_BLOK = D .KD_BLOK
// AND A .NO_URUT = D .NO_URUT
// AND A .KD_JNS_OP = D .KD_JNS_OP
// inner join REF_KECAMATAN K on A.KD_PROPINSI = K.KD_PROPINSI and A.KD_DATI2 = K.KD_DATI2 and A.KD_KECAMATAN = K.KD_KECAMATAN
// inner join REF_PROPINSI P on A.KD_PROPINSI = P.KD_PROPINSI
// inner join REF_DATI2 T on A.KD_PROPINSI = T.KD_PROPINSI and A.KD_DATI2 = T.KD_DATI2 
// LEFT JOIN KELAS_TANAH KL ON KL.KD_KLS_TANAH = A.KD_KLS_TANAH AND KL.THN_AWAL_KLS_TANAH = A.THN_AWAL_KLS_TANAH
// WHERE
// A .KD_PROPINSI = '$nop[0]'
// AND A .KD_DATI2 = '$nop[1]'
// AND A .KD_KECAMATAN = '$nop[2]'
// AND A .KD_KELURAHAN = '$nop[3]'
// AND A .KD_BLOK = '$nop[4]'
// AND A .NO_URUT = '$nop[5]'
// AND A .KD_JNS_OP = '$nop[6]'
// AND A .THN_PAJAK_SPPT = '$tahun'";
$tahun = date("Y");
		$sql = "SELECT A.*,K.NM_KECAMATAN,P.NM_KELURAHAN,D.JALAN_OP,
				(A.NJOP_BUMI_SPPT / A.LUAS_BUMI_SPPT) AS NILAI_PER_M2_BUMI,
				(CASE WHEN A.LUAS_BNG_SPPT = 0
				THEN 0
				ELSE (A.NJOP_BNG_SPPT / A.LUAS_BNG_SPPT) 
				END) AS NILAI_PER_M2_BNG
				FROM
				  SPPT A
				LEFT JOIN DAT_OBJEK_PAJAK D ON A .KD_PROPINSI = D .KD_PROPINSI
				AND A .KD_DATI2 = D .KD_DATI2
				AND A .KD_KECAMATAN = D .KD_KECAMATAN
				AND A .KD_KELURAHAN = D .KD_KELURAHAN
				AND A .KD_BLOK = D .KD_BLOK
				AND A .NO_URUT = D .NO_URUT
				AND A .KD_JNS_OP = D .KD_JNS_OP
				inner join REF_KECAMATAN K on A.KD_KECAMATAN = K.KD_KECAMATAN
				inner join REF_KELURAHAN P on A.KD_KECAMATAN = P.KD_KECAMATAN AND A.KD_KELURAHAN = P.KD_KELURAHAN
				WHERE
				A .KD_PROPINSI = '$nop[0]'
				AND A .KD_DATI2 = '$nop[1]'
				AND A .KD_KECAMATAN = '$nop[2]'
				AND A .KD_KELURAHAN = '$nop[3]'
				AND A .KD_BLOK = '$nop[4]'
				AND A .NO_URUT = '$nop[5]'
				AND A .KD_JNS_OP = '$nop[6]'
				AND A .THN_PAJAK_SPPT = '$tahun'";
		// $q = $this->sismiop->query($sql,array($nop[0],$nop[1],$nop[2],$nop[3],$nop[4],$nop[5],$nop[6],$tahun));
		$q = $this->sismiop->query($sql);
		return $q->result_array();
	}

	function getHistory($nop) {
		//$qry = "SELECT * FROM (select
	    $qry = "SELECT   
	            thn_pajak_sppt,
	            pbb_yg_harus_dibayar_sppt,
	            status_pembayaran_sppt,
	            case
	              when status_pembayaran_sppt='1' then 'LUNAS' 
	              else 'BELUM. LUNAS'
	            end STATUS
	           from sppt 
	           where 
	            kd_propinsi= '$nop[0]' and
	            kd_dati2 = '$nop[1]' and
	            kd_kecamatan = '$nop[2]' and
	            kd_kelurahan = '$nop[3]' and
	            kd_blok = '$nop[4]' and
	            no_urut= '$nop[5]' and
	            kd_jns_op= '$nop[6]'
				and status_pembayaran_sppt != 2
	           order by thn_pajak_sppt DESC";
			   //order by thn_pajak_sppt DESC) WHERE ROWNUM < 6";
        // $query = $this->simiop->query($qry, array($nop[0],$nop[1],$nop[2],$nop[3],$nop[4],$nop[5],$nop[6]));
	    $query = $this->sismiop->query($qry);
        return $query->result_array();     
    }
	
	function getPaymentBreak($nop) {
	    $qrysql = "SELECT   
	            count(thn_pajak_sppt) tunggakan
	           from sppt 
	           where 
	            (kd_propinsi= '$nop[0]' and
	            kd_dati2 = '$nop[1]' and
	            kd_kecamatan = '$nop[2]' and
	            kd_kelurahan = '$nop[3]' and
	            kd_blok = '$nop[4]' and
	            no_urut= '$nop[5]' and
	            kd_jns_op= '$nop[6]')
				and status_pembayaran_sppt = '0'
	           order by thn_pajak_sppt DESC";
	    $querysql = $this->sismiop->query($qrysql);
        return $querysql->result_array();     
    }

}

/* End of file mod_service.php , query sppt */
/* Location: ./application/models/mod_service.php */