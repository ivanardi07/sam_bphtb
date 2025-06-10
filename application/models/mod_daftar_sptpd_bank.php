<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_daftar_sptpd_bank extends CI_Model {

	var $error = '';
	
	function __construct()
	{
	    parent::__construct();
	    $this->tbl = 'tbl_sptpd';
	    $this->load->database();
	} 
	
	function count_sptpd()
	{
	    $this->db->from($this->tbl);
	    $query = $this->db->get();
	    return $query->num_rows();
	}

	function get_sptpd($id='', $limit='', $go_page='', $start='', $halt_at='', $id_ppat="", $propinsi="", $kabupaten="", $kecamatan="", $kelurahan="", $blok="", $urut="", $jenis="", $cari_dokumen='')
	{

	    if( ! empty($id))
	    {
	        $this->db->where('id_sptpd',$id);
	        $query = $this->db->get($this->tbl);
	        return $query->row();
	    }
	    else
	    {
	        
	        if( ! empty($go_page)){ $this->db->limit($halt_at, $start); }
	        if( ! empty($limit)){$this->db->limit($limit);}
	        if( ! empty($propinsi)){$this->db->where('kd_propinsi', $propinsi);}
	        if( ! empty($propinsi)){$this->db->where('kd_kabupaten', $kabupaten);}
	        if( ! empty($propinsi)){$this->db->where('kd_kecamatan', $kecamatan);}
	        if( ! empty($propinsi)){$this->db->where('kd_kelurahan', $kelurahan);}
	        if( ! empty($propinsi)){$this->db->where('kd_blok', $blok);}
	        if( ! empty($propinsi)){$this->db->where('no_urut', $urut);}
	        if( ! empty($propinsi)){$this->db->where('kd_jns_op', $jenis);}

	        // cari dokumen
	        if( ! empty($cari_dokumen)){$this->db->where('no_dokumen', $cari_dokumen);}
	        
	        $type_user = $this->session->userdata('s_tipe_bphtb');
	        
	        if ($type_user == 'PT') {
	            $id_ppat = $this->session->userdata('s_id_ppat');
	            $this->db->where('id_ppat',$id_ppat);
	        }
	        if ($type_user == 'D') {
	            $username = $this->session->userdata('s_username_bphtb');
	            if ($username != 'admin') {
	                $id_dispenda = $this->session->userdata('s_id_dispenda');
	                $this->db->where('id_dispenda',$id_dispenda);
	            }
	        }

	        // Tambahan
	        if ($type_user == 'PP') {
	            $id_bank = $this->session->userdata('s_id_paymentpoint');
	            $this->db->where('id_bank',$id_bank);
	            

	        }
	        // end
	        
	        $this->db->order_by('tanggal','desc');
	        $query = $this->db->get($this->tbl);
	        return $query->result();
	    }
	}

	function get_id_ppat($id_user='')
	{
	    $this->db->where('id_user',$id_user);
	    $query = $this->db->get('tbl_ppat');
	    $id = $query->result();
	    $id = $id[0]->id_ppat;
	    return $id;
	}

	function get_user($id_user='')
	{
	    $this->db->where('id_user',$id_user);
	    $query = $this->db->get('tbl_user');
	    $id = $query->result();
	    @$tipe = $id[0]->tipe;
	    return @$tipe;
	}

	// function sum_jumlah_setor($ppat='',$approve=false)
	// {
	//     if( ! empty($ppat)){ $this->db->where('id_ppat', $ppat); }
	//     if( ! $approve ){ $this->db->where('id_ppat', ''); }
	//     $this->db->select("SUM(jumlah_setor) AS grand_total");
	//     $query = $this->db->get($this->tbl);
	//     return $query->row();
	// }


	function sum_jumlah_setor($ppat='', $approve=false , $propinsi='', $kabupaten='', $kecamatan='', $kelurahan='', $blok='', $urut='', $jenis='', $cari_dokumen='')
	{
	    
		if( ! empty($propinsi)){$this->db->where('kd_propinsi', $propinsi);}
		if( ! empty($propinsi)){$this->db->where('kd_kabupaten', $kabupaten);}
		if( ! empty($propinsi)){$this->db->where('kd_kecamatan', $kecamatan);}
		if( ! empty($propinsi)){$this->db->where('kd_kelurahan', $kelurahan);}
		if( ! empty($propinsi)){$this->db->where('kd_blok', $blok);}
		if( ! empty($propinsi)){$this->db->where('no_urut', $urut);}
		if( ! empty($propinsi)){$this->db->where('kd_jns_op', $jenis);}
		if( ! empty($cari_dokumen)){$this->db->where('no_dokumen', $cari_dokumen);}

	    if( ! empty($ppat)){ $this->db->where('id_ppat', $ppat); }
	    if( ! $approve ){ $this->db->where('id_ppat', ''); }
	    $this->db->select("SUM(jumlah_setor) AS grand_total");
	    $query = $this->db->get($this->tbl);
	    return $query->row();
	}



	function get_sptpd_from_idbank($id_bank)
	{
		$this->db->where('id_bank',$id_bank);
	    $query = $this->db->get('tbl_sptpd');
	    return $query->result();
	}

}

/* End of file mod_daftar_sptpd_bank.php */
/* Location: ./application/models/mod_daftar_sptpd_bank.php */