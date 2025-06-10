<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mod_validasi_sptpd extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public $data  = array();
    public $tbl   = 'tbl_sptpd';
    public $error = '';

    public function get_sptpd($id = '', $ppat = '', $approve = false, $start = '', $halt_at = '')
    {
        if (!empty($id)) {
            $this->db->where('id_sptpd', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($halt_at) or !empty($start)) {$this->db->limit($halt_at, $start);}
            if (!empty($ppat)) {$this->db->where('id_ppat', $ppat);}
            if (!$approve) {$this->db->where('id_ppat', '');}
            $this->db->order_by('tanggal', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    public function validasi_akhir($id_sptpd)
    {
        $sql = "update tbl_sptpd set is_lunas = '2' where id_sptpd = ".$id_sptpd;
        $data = $this->db->query($sql);
        // echo $this->db->last_query();exit();
        if ($data) {
            return true;
            
        }
        return false;
    }

    public function update_sptpd($id, $id_user, $type, $tgl_valid_dispenda = '', $jabatan,$nama_staf,$petugas)
    {
        if ($type == 'PP') {
            $ed_data = array(
                'id_bank'           => $id_user,
                'tgl_validasi_bank' => date('Y-m-d'),
                'is_lunas'          => 1,
                'flag_ppat'         => 0, 
                'flag_dispenda'     => 0, 
            );
        } elseif ($type == 'D' && $jabatan == '0') {
            $ed_data = array(
                'id_dispenda'           => $id_user,
                'tgl_validasi_dispenda' => changeDateFormat('database',@$tgl_valid_dispenda),
                'is_lunas'              => '',
                'flag_ppat'             => 0, 
                'flag_dispenda'         => 0, 
                'proses'                => $jabatan,
                'nama_staf'             => $nama_staf,
                'nama_petugas_lapangan' => $petugas
            );
        } elseif ($type == 'D') {
            $ed_data = array(
                'id_dispenda'           => $id_user,
                'tgl_validasi_dispenda' => changeDateFormat('database',@$tgl_valid_dispenda),
                'is_lunas'              => '',
                'flag_ppat'             => 0, 
                'flag_dispenda'         => 0, 
                'proses'                => $jabatan
				//'proses'                => $jabatan
            );
        }

        $this->db->where('id_sptpd', $id);

        if ($this->db->update($this->tbl, $ed_data)) {
            return true;
        }
        return false;

    }
    public function update_kode_validasi($id, $kode, $type)
    {
        if ($type == 'PP') {
            $ed_data = array(
                'kode_validasi' => $kode,
                'validasi_bank' => $kode,
                'flag_ppat'     => 0, 
                'flag_dispenda' => 0, 
            );
        } elseif ($type == 'D') {
            $ed_data = array(
                'validasi_dispenda' => $kode,
                'flag_ppat'         => 0, 
                'flag_dispenda'     => 0, 
            );
        }

        $this->db->where('id_sptpd', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            return true;
        }
        return false;
    }

    public function get_id_ppat($id_src = '')
    {
        $querySelect = "SELECT id_ppat FROM tbl_ppat WHERE id_user = '$id_src'";
        $query       = $this->db->query($querySelect);
        return $query->result();
    }

    public function get_entries_by_nop($nop)
    {
        $result     = false;
        $formatDate = '%d-%m-%Y';
        /*
        $querySelect = sprintf ( "select a.NPWP_BPHTB,
        b.NM_WP_SSB,
        date_format( a.TGL_BAYAR_BPHTB, '%s') as TGL_BAYAR_BPHTB,
        c.NM_BANK_TUNGGAL,
        c.NO_REK_BANK_TUNGGAL,
        a.NILAI_BAYAR_BPHTB
        from   %s as a
        left join %s as b
        on a.NPWP_BPHTB = b.NPWP_SSB
        left join %s as c
        on a.KD_BANK_BPHTB = c.KD_BANK_TUNGGAL
        where  a.NOP_BPHTB = '%s'    ",
        $formatDate,
        $this->config->item('TABEL_PEMBAYARAN_BPHTB'),
        $this->config->item('TABEL_REF_NPWP'),
        $this->config->item('TABEL_BANK_TUNGGAL'),
        $nop );

         */
        // echo $nop; exit;
        $Kd_prof = substr($nop, 0, 2);
        $Kd_kab  = substr($nop, 2, 2);
        $kd_kec  = substr($nop, 4, 3);
        $kd_kel  = substr($nop, 7, 3);
        $kd_blok = substr($nop, 10, 3);
        $kd_urut = substr($nop, 13, 4);
        $kd_jns  = substr($nop, 17, 1);
        //echo $kd_jns;exit();
        $querySelect = "SELECT * FROM tbl_sptpd WHERE kd_propinsi = '$Kd_prof' and kd_kabupaten = '$Kd_kab' and kd_kecamatan = '$kd_kec'
        				and kd_kelurahan = '$kd_kel' and kd_blok = '$kd_blok' and no_urut = '$kd_urut' and kd_jns_op = '$kd_jns'";
        $query = $this->db->query($querySelect);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        }
        return $result;
    }

    public function get_entries_by_no_sspd($no_sspd = '')
    {
        $data = $this->db->get_where($this->tbl, array('no_dokumen' => $no_sspd))->row_array();

        return $data;
    }

    public function rejectDokumen($param='')
    {
        $this->db->where('no_dokumen', $param['no_dokumen']);
        $query = $this->db->get($this->tbl);
        $query1 = $query->row_array();
        $tanggal = date('d-m-Y');

        $object = array(
                        'is_lunas'      => 3, 
                        'alasan_reject' => $query1['alasan_reject'].nl2br("\r\n"."[".$tanggal."] ".$param['alasan_reject']).';',
                        'flag_ppat'     => 1, 
                        'flag_dispenda' => 0, 
                       );
        $this->db->where('no_dokumen', $param['no_dokumen']);
        $this->db->update('tbl_sptpd', $object);

        return $this->db->affected_rows();
    }

    public function logReject($param='')
    {
        $this->db->where('no_dokumen', $param['no_dokumen']);
        $query = $this->db->get($this->tbl);
        $query1 = $query->row_array();
        // print_r($query1); exit();
        $object = array(
                        'id_sptpd'      => $query1['id_sptpd'], 
                        'id_user'       => $this->session->userdata('s_id_user'), 
                        'no_dokumen'    => $param['no_dokumen'], 
                        'catatan'       => $param['alasan_reject'],
                        'tanggal'       => date('Y-m-d H:i:s'), 
                       );
        $this->db->where('no_dokumen', $param['no_dokumen']);
        $this->db->insert('tbl_log_sptpd', $object);

        return $this->db->affected_rows();
    }


    public function batal_bayar($id='')
    {
        $object = array(
                        'is_lunas'          => '', 
                        'tgl_validasi_bank' => '',
                        'validasi_bank'     => '',
                        'id_bank'           => '',
                        'flag_ppat'         => 1, 
                        'flag_dispenda'     => 0, 
                       );
        $this->db->where('no_dokumen', $id);
        $this->db->update('tbl_sptpd', $object);

        return $this->db->affected_rows();
    }

    public function cekSSPD($id='')
    {
        $data = $this->db->get_where('tbl_sptpd', array('no_dokumen' => $id))->result_array();

        return $data;
    }

    public function setLunas($param='')
    {
        $cekDokument = $this->cekSSPD($param['no_sspd']);
        
        $response = array();

        if (count($cekDokument) > 0) {

            $ed_data = array(
                'validasi_bank'     => $cekDokument[0]['kode_validasi'],
                'tgl_validasi_bank' => date('Y-m-d'),
                'id_bank'           => $param['id_bank'],
                'is_lunas'          => 1,
                'flag_ppat'         => 0, 
                'flag_dispenda'     => 0, 
            );

            $this->db->where('no_dokumen', $param['no_sspd']);
            if ($this->db->update($this->tbl, $ed_data)) {
               $response                = array(
                                            'is_lunas'          => 1, 
                                            'keterangan'        => 'Nomor SSPD : '.$param['no_sspd'].' Berhasil Melakukan Pembayaran',
                                            'tgl_pembayaran'    => date('Y-m-d'), 
                                          );
            }else{
               $response['is_lunas'] = 0; 
            }
        }else{
            $response['is_lunas'] = 0;
        }

        return $response;
    }
}

/* End of file mod_validasi_sptpd.php */
/* Location: ./application/models/mod_validasi_sptpd.php */
