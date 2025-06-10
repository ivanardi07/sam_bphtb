<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_nop.php
 * Description: NOP model
 * Date created: 2011-03-07
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_nop extends CI_Model
{

	var $query_get_data_nop = "SELECT a.*,b.nama as nm_kelurahan,c.nama as nm_kecamatan,d.nama as nm_dati2
     FROM tbl_nop as a LEFT JOIN tbl_kelurahan as b
     ON (a.kelurahan_op = b.kd_kelurahan) LEFT JOIN tbl_kecamatan as c
     ON (a.kecamatan_op = c.kd_kecamatan) LEFT JOIN tbl_kabupaten as d
     ON (a.kotakab_op = d.kd_kabupaten)
     WHERE
     a.kd_propinsi = ?
     AND a.kd_kabupaten = ?
     AND a.kd_kecamatan = ?
     AND a.kd_kelurahan = ?
     AND a.kd_blok = ?
     AND a.no_urut = ?
     AND a.kd_jns_op = ?
     ";

	var $query_get_data_nop_new = "SELECT a.*
     FROM tbl_nop as a 
     WHERE
     a.kd_propinsi = ?
     AND a.kd_kabupaten = ?
     AND a.kd_kecamatan = ?
     AND a.kd_kelurahan = ?
     AND a.kd_blok = ?
     AND a.no_urut = ?
     AND a.kd_jns_op = ?
     ";

	var $query_get_data_nop_service = "SELECT a.*
     FROM tbl_nop as a 
     WHERE
     a.kd_propinsi = ?
     AND a.kd_kabupaten = ?
     AND a.kd_kecamatan = ?
     AND a.kd_kelurahan = ?
     AND a.kd_blok = ?
     AND a.no_urut = ?
     AND a.kd_jns_op = ?
     and a.thn_pajak_sppt = ?
     ";

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->tbl = $this->config->item('pg_schema') . 'tbl_nop';
	}

	function get_nop($id_compile = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nop = '')
	{

		if ($id_compile != '') {

			// $this->db->where('nop',$id);
			// $query = $this->db->get($this->tbl);
			$query = $this->db->query($this->query_get_data_nop_new, $id_compile);

			return $query->row();
		} else {

			// if($go_page !=''){ $this->db->limit($halt_at, $start); }
			// if($limit !=''){$this->db->limit($limit);}
			// if($nop['nop'] !=''){$this->db->where('nop',str_replace('.','',$nop['nop']));}
			// $this->db->order_by('nop','asc');

			if ($go_page != '') {
				$this->db->limit($halt_at, $start);
			}
			if ($limit != '') {
				$this->db->limit($limit);
			}
			if (count($nop[1][0]) > 0) //$nop dalam bentuk $id_compile
			{
				$this->db->where('kd_propinsi', $nop[0]);
				$this->db->where('kd_kabupaten', $nop[1]);
				$this->db->where('kd_kecamatan', $nop[2]);
				$this->db->where('kd_kelurahan', $nop[3]);
				$this->db->where('kd_blok', $nop[4]);
				$this->db->where('no_urut', $nop[5]);
				$this->db->where('kd_jns_op', $nop[6]);
			} else {
				$this->db->order_by('kd_propinsi');
				$this->db->order_by('kd_kabupaten');
				$this->db->order_by('kd_kecamatan');
				$this->db->order_by('kd_kelurahan');
				$this->db->order_by('kd_blok');
				$this->db->order_by('no_urut');
				$this->db->order_by('kd_jns_op');
			}

			$query = $this->db->get($this->tbl);
			return $query->result();
		}
	}

	public function get_nop_service($id_compile = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nop = '')
	{

		$query = $this->db->query($this->query_get_data_nop_service, $id_compile);
		return $query->row();
	}

	function check_kecamatan($kd_kecamatan)
	{
		if ($kd_kecamatan != '') {
			$this->db->where('kecamatan_op', $kd_kecamatan);
			$query = $this->db->get($this->tbl);
			if ($query->row()) {
				return TRUE;
			}
		}

		return FALSE;
	}

	function check_kelurahan($kd_kelurahan)
	{
		if (@$nop['nop'] != '') {
			$this->db->where('nop', $nop['nop']);
		}

		if ($kd_kelurahan != '') {
			$this->db->where('kelurahan_op', $kd_kelurahan);
			$query = $this->db->get($this->tbl);
			if ($query->row()) {
				return TRUE;
			}
		}

		return FALSE;
	}

	function count_nop($id_compile)
	{

		if ($id_compile != null) {
			$this->db->where('kd_propinsi', $id_compile[0]);
			$this->db->where('kd_kabupaten', $id_compile[1]);
			$this->db->where('kd_kecamatan', $id_compile[2]);
			$this->db->where('kd_kelurahan', $id_compile[3]);
			$this->db->where('kd_blok', $id_compile[4]);
			$this->db->where('no_urut', $id_compile[5]);
			$this->db->where('kd_jns_op', $id_compile[6]);
		}

		$this->db->from($this->tbl);
		return $this->db->count_all_results();
	}

	function add_nop($id_compile, $lokasi, $kelurahan, $rtrw, $kecamatan, $kotakab, $luas_tanah, $luas_bangunan, $njop_tanah, $njop_bangunan, $njop_pbb, $nilai_op = 0, $jenis_perolehan, $no_sertipikat, $kd_propinsi_op, $thn_pajak_sppt, $ref_tanah, $ref_bangunan, $param_nop)
	{

		$cek_nop = $this->cek_nop($id_compile, date('Y'));

		if ($cek_nop > 0) {

			$object = array(
				'kd_propinsi' => $id_compile[0],
				'lokasi_op'                     => $lokasi,
				'kelurahan_op'                  => $kelurahan,
				'rtrw_op'                       => $rtrw,
				'kecamatan_op'                  => $kecamatan,
				'kotakab_op'                    => $kotakab,
				'luas_tanah_op'                 => $luas_tanah,
				'luas_bangunan_op'              => $luas_bangunan,
				'njop_tanah_op'                 => $njop_tanah,
				'njop_bangunan_op'              => $njop_bangunan,
				'njop_pbb_op'                   => $njop_pbb,
				'nilai_op'                      => $nilai_op,
				'jenis_perolehan_op'            => $jenis_perolehan,
				'no_sertipikat_op'              => $no_sertipikat,
				'propinsi_op'                   => $kd_propinsi_op,
				'thn_pajak_sppt'                => $thn_pajak_sppt,
				'ref_tanah'                		=> $ref_tanah,
				'ref_bangunan'                	=> $ref_bangunan,
				'nama_penjual'                	=> $param_nop['nama_penjual'],
				'alamat_penjual'                => $param_nop['alamat_penjual'],
			);

			$where = array(
				'kd_kabupaten'                  => $id_compile[1],
				'kd_kecamatan'                  => $id_compile[2],
				'kd_kelurahan'                  => $id_compile[3],
				'kd_blok'                       => $id_compile[4],
				'no_urut'                       => $id_compile[5],
				'kd_jns_op'                     => $id_compile[6],
				'thn_pajak_sppt'                => $thn_pajak_sppt,
			);
			$this->db->where($where);
			$this->db->update($this->tbl, $object);
		} else {
			$add_data = array(
				'kd_propinsi' => $id_compile[0],
				'kd_kabupaten'                  => $id_compile[1],
				'kd_kecamatan'                  => $id_compile[2],
				'kd_kelurahan'                  => $id_compile[3],
				'kd_blok'                       => $id_compile[4],
				'no_urut'                       => $id_compile[5],
				'kd_jns_op'                     => $id_compile[6],
				'lokasi_op'                     => $lokasi,
				'kelurahan_op'                  => $kelurahan,
				'rtrw_op'                       => $rtrw,
				'kecamatan_op'                  => $kecamatan,
				'kotakab_op'                    => $kotakab,
				'luas_tanah_op'                 => $luas_tanah,
				'luas_bangunan_op'              => $luas_bangunan,
				'njop_tanah_op'                 => $njop_tanah,
				'njop_bangunan_op'              => $njop_bangunan,
				'njop_pbb_op'                   => $njop_pbb,
				'nilai_op'                      => $nilai_op,
				'jenis_perolehan_op'            => $jenis_perolehan,
				'no_sertipikat_op'              => $no_sertipikat,
				'propinsi_op'                   => $kd_propinsi_op,
				'thn_pajak_sppt'                => $thn_pajak_sppt,
				'ref_tanah'                		=> $ref_tanah,
				'ref_bangunan'                	=> $ref_bangunan,
				'nama_penjual'                	=> $param_nop['nama_penjual'],
				'alamat_penjual'                => $param_nop['alamat_penjual'],
			);
			if ($this->db->insert($this->tbl, $add_data)) {
				$this->antclass->go_log($this->db->last_query());
				return TRUE;
			}
		}

		return FALSE;
	}

	public function cek_nop($nop = '', $thn_pajak_sppt)
	{
		$this->db->where('kd_propinsi', $nop[0]);
		$this->db->where('kd_kabupaten', $nop[1]);
		$this->db->where('kd_kecamatan', $nop[2]);
		$this->db->where('kd_kelurahan', $nop[3]);
		$this->db->where('kd_blok', $nop[4]);
		$this->db->where('no_urut', $nop[5]);
		$this->db->where('kd_jns_op', $nop[6]);
		$this->db->where('thn_pajak_sppt', $thn_pajak_sppt);
		$data = $this->db->get('tbl_nop')->num_rows();

		return $data;
	}

	public function edit_service_nop($id_compile, $lokasi, $kelurahan, $rtrw, $kecamatan, $kotakab, $luas_tanah, $luas_bangunan, $njop_tanah, $njop_bangunan, $njop_pbb, $nilai_op = 0, $jenis_perolehan, $no_sertipikat, $kd_propinsi_op, $thn_pajak_sppt, $ref_tanah, $ref_bangunan, $param_nop)
	{

		$cek_nop = $this->cek_nop($id_compile, $thn_pajak_sppt);

		if ($cek_nop > 0) {
			$ed_data = array(
				'lokasi_op' => $lokasi,
				'kelurahan_op'               => $kelurahan,
				'rtrw_op'                    => $rtrw,
				'kecamatan_op'               => $kecamatan,
				'kotakab_op'                 => $kotakab,
				'luas_tanah_op'              => $luas_tanah,
				'luas_bangunan_op'           => $luas_bangunan,
				'njop_tanah_op'              => $njop_tanah,
				'njop_bangunan_op'           => $njop_bangunan,
				'njop_pbb_op'                => $njop_pbb,
				'jenis_perolehan_op'         => $jenis_perolehan,
				'no_sertipikat_op'           => $no_sertipikat,
				'propinsi_op'                => $kd_propinsi_op,
				'nama_penjual'               => $param_nop['nama_penjual'],
				'alamat_penjual'             => $param_nop['alamat_penjual'],
			);

			$this->db->where('kd_propinsi', $id_compile[0]);
			$this->db->where('kd_kabupaten', $id_compile[1]);
			$this->db->where('kd_kecamatan', $id_compile[2]);
			$this->db->where('kd_kelurahan', $id_compile[3]);
			$this->db->where('kd_blok', $id_compile[4]);
			$this->db->where('no_urut', $id_compile[5]);
			$this->db->where('kd_jns_op', $id_compile[6]);
			$this->db->where('thn_pajak_sppt', $thn_pajak_sppt);

			if ($this->db->update($this->tbl, $ed_data)) {
				$this->antclass->go_log($this->db->last_query());
				return TRUE;
			}
		} else {
			$proses_add = $this->add_nop($id_compile, $lokasi, $kelurahan, $rtrw, $kecamatan, $kotakab, $luas_tanah, $luas_bangunan, $njop_tanah, $njop_bangunan, $njop_pbb, $nilai_op = 0, $jenis_perolehan, $no_sertipikat, $kd_propinsi_op, $thn_pajak_sppt, $ref_tanah, $ref_bangunan, $param_nop);

			return $proses_add;
		}

		return FALSE;
	}

	function edit_nop($id_compile, $lokasi, $kelurahan, $rtrw, $kecamatan, $kotakab, $luas_tanah, $luas_bangunan, $njop_tanah, $njop_bangunan, $njop_pbb, $nilai_op = 0, $jenis_perolehan, $no_sertipikat, $kd_propinsi_op)
	{
		$ed_data = array(
			'lokasi_op' => $lokasi,
			'kelurahan_op'               => $kelurahan,
			'rtrw_op'                    => $rtrw,
			'kecamatan_op'               => $kecamatan,
			'kotakab_op'                 => $kotakab,
			'luas_tanah_op'              => $luas_tanah,
			'luas_bangunan_op'           => $luas_bangunan,
			'njop_tanah_op'              => $njop_tanah,
			'njop_bangunan_op'           => $njop_bangunan,
			'njop_pbb_op'                => $njop_pbb,
			//'nilai_op'=>$nilai_op,
			'jenis_perolehan_op'         => $jenis_perolehan,
			'no_sertipikat_op'           => $no_sertipikat,
			'propinsi_op'                => $kd_propinsi_op,
		);

		$this->db->where('kd_propinsi', $id_compile[0]);
		$this->db->where('kd_kabupaten', $id_compile[1]);
		$this->db->where('kd_kecamatan', $id_compile[2]);
		$this->db->where('kd_kelurahan', $id_compile[3]);
		$this->db->where('kd_blok', $id_compile[4]);
		$this->db->where('no_urut', $id_compile[5]);
		$this->db->where('kd_jns_op', $id_compile[6]);
		if ($this->db->update($this->tbl, $ed_data)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	function delete_nop($id_compile)
	{
		$this->db->where('kd_propinsi', $id_compile[0]);
		$this->db->where('kd_kabupaten', $id_compile[1]);
		$this->db->where('kd_kecamatan', $id_compile[2]);
		$this->db->where('kd_kelurahan', $id_compile[3]);
		$this->db->where('kd_blok', $id_compile[4]);
		$this->db->where('no_urut', $id_compile[5]);
		$this->db->where('kd_jns_op', $id_compile[6]);
		if ($this->db->delete($this->tbl)) {
			$this->antclass->go_log($this->db->last_query());
			return TRUE;
		}

		return FALSE;
	}

	// tambahan

	function get_kab($kd_propinsi = '')
	{
		$sql   = "select * from tbl_kabupaten where kd_propinsi = '$kd_propinsi'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_kel($kd_kecamatan = '')
	{
		$sql   = "select * from tbl_kelurahan where kd_kecamatan = '$kd_kecamatan'";
		$query = $this->db->query($sql);
		return $query->result();
	}
}

/* EoF */
