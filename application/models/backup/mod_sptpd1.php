<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_sptpd.php
 * Description: SPTPD model
 * Date created: 2011-03-19
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_sptpd extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_sptpd';
    }

    function get_sptpd($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '')
    {
        if (!empty($id)) {
            $this->db->where('id_sptpd', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            if (!empty($nik)) {
                $this->db->where('nik', $nik);
            }
            if (!empty($limit)) {
                $this->db->limit($limit);
            }
            $this->db->order_by('tanggal', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function get_last_autonum()
    {
        $this->db->limit(1);
        $this->db->order_by('no_dokumen', 'desc');
        $this->db->where("no_dokumen LIKE '" . date('d') . date('m') . date('Y') . "%'");
        $this->db->select('no_dokumen');
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    function check_nop($nop)
    {
        if (!empty($nop)) {
            $this->db->where('nop', $nop);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function check_ppat($ppat)
    {
        if (!empty($ppat)) {
            $this->db->where('id_ppat', $ppat);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function check_nik($nik)
    {
        if (!empty($nik)) {
            $this->db->where('nik', $nik);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function get_report_sptpd($id = '', $date_start = '', $date_end = '', $pp = '', $ppat = '', $pwp = '', $stb = '', $skbkb = '', $skbkbt = '', $user = '', $nodok = '', $go_page = '', $start = '', $halt_at = '')
    {
        if (!empty($id)) {
            $this->db->where('id_sptpd', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            if (!empty($date_start)) {
                $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
            }
            if (!empty($pp)) {
                $this->db->where('id_pp', $pp);
            }
            if (!empty($user)) {
                $this->db->where('id_user', $user);
            }
            if (!empty($nodok)) {
                $this->db->where('no_dokumen', $nodok);
            }
            if (!empty($ppat) && $ppat != 'DISPENDA') {
                $this->db->where('id_ppat', $ppat);
            }
            if ($ppat == 'DISPENDA') {
                $this->db->where("id_ppat = ''");
            }
            $dasar = array($pwp, $stb, $skbkb, $skbkbt);
            if (!empty($pwp) or  !empty($stb) or !empty($skbkb) or !empty($skbkbt)) {
                $this->db->where_in('jns_setoran', $dasar);
            }
            $this->db->order_by('id_sptpd', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function sum_jumlah_setor($date_start = '', $date_end = '', $pp = '', $ppat = '', $stb = '', $skbkb = '', $skbkbt = '')
    {
        if (!empty($date_start)) {
            $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        }
        if (!empty($pp)) {
            $this->db->where('id_pp', $pp);
        }
        if (!empty($user)) {
            $this->db->where('id_user', $user);
        }
        if (!empty($ppat) && $ppat != 'DISPENDA') {
            $this->db->where('id_ppat', $ppat);
        }
        if ($ppat == 'DISPENDA') {
            $this->db->where("id_ppat = ''");
        }
        if (!empty($stb)) {
            $this->db->where('jns_setoran', $stb);
        }
        if (!empty($skbkb)) {
            $this->db->where('jns_setoran', $skbkb);
        }
        if (!empty($skbkbt)) {
            $this->db->where('jns_setoran', $skbkbt);
        }
        $this->db->select("SUM(jumlah_setor) AS grand_total");
        $query = $this->db->get($this->tbl);
        return $query->row();
    }

    function count_sptpd($date_start = '', $date_end = '', $pp = '', $ppat = '', $stb = '', $skbkb = '', $skbkbt = '', $user = '')
    {
        if (!empty($date_start)) {
            $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        }
        if (!empty($pp)) {
            $this->db->where('id_pp', $pp);
        }
        if (!empty($ppat) && $ppat != 'DISPENDA') {
            $this->db->where('id_ppat', $ppat);
        }
        if ($ppat == 'DISPENDA') {
            $this->db->where("id_ppat = ''");
        }
        if (!empty($stb)) {
            $this->db->where('jns_setoran', $stb);
        }
        if (!empty($skbkb)) {
            $this->db->where('jns_setoran', $skbkb);
        }
        if (!empty($skbkbt)) {
            $this->db->where('jns_setoran', $skbkbt);
        }
        if (!empty($user)) {
            $this->db->where('id_user', $user);
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_sptpd($id_ppat, $nik, $nop, $nilai_pasar, $jenis_perolehan, $npop, $npoptkp, $dasar_jml_setoran, $nomor_jml_setoran, $tgl_jml_setoran, $hitung_sendiri_jml_setoran, $custom_jml_setoran, $jml_setor, $tanggal, $no_dokumen, $nop_pbb_baru, $kode_validasi, $id_user, $id_pp, $picture = '')
    {
        if ($tgl_jml_setoran == '') {
            $query = "INSERT INTO $this->tbl (id_ppat, nik, nop, nilai_pasar, jenis_perolehan, npop, npoptkp, jns_setoran, jns_setoran_nomor, jns_setoran_tanggal, jns_setoran_hitung_sendiri, jns_setoran_custom, jumlah_setor, tanggal, no_dokumen, nop_pbb_baru, id_user, id_pp, kode_validasi, gambar_op) 
                      VALUES ('$id_ppat', '$nik', '$nop', '$nilai_pasar', '$jenis_perolehan', '$npop', '$npoptkp', '$dasar_jml_setoran', '$nomor_jml_setoran', 
                              NULL, '$hitung_sendiri_jml_setoran', '$custom_jml_setoran', '$jml_setor', '$tanggal', 
                              '$no_dokumen', '$nop_pbb_baru', '$id_user', '$id_pp', '$kode_validasi', '$picture')";
        } else {
            $query = "INSERT INTO $this->tbl (id_ppat, nik, nop, nilai_pasar, jenis_perolehan, npop, npoptkp, jns_setoran, jns_setoran_nomor, jns_setoran_tanggal, jns_setoran_hitung_sendiri, jns_setoran_custom, jumlah_setor, tanggal, no_dokumen, nop_pbb_baru, id_user, id_pp, kode_validasi, gambar_op) 
                      VALUES ('$id_ppat', '$nik', '$nop', '$nilai_pasar', '$jenis_perolehan', '$npop', '$npoptkp', '$dasar_jml_setoran', '$nomor_jml_setoran', 
                              '$tgl_jml_setoran', '$hitung_sendiri_jml_setoran', '$custom_jml_setoran', '$jml_setor', '$tanggal', 
                              '$no_dokumen', '$nop_pbb_baru', '$id_user', '$id_pp', '$kode_validasi', '$picture')";
        }

        if ($this->db->query($query)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_sptpd($id, $id_ppat, $nik, $nop, $nilai_pasar, $jenis_perolehan, $npop, $npoptkp, $dasar_jml_setoran, $nomor_jml_setoran, $tgl_jml_setoran, $hitung_sendiri_jml_setoran, $custom_jml_setoran, $jml_setor, $tanggal, $no_dokumen, $nop_pbb_baru)
    {
        $query = "UPDATE $this->tbl SET id_ppat='$id_ppat', 
                                         nik='$nik', 
                                         nop='$nop', 
                                         nilai_pasar='$nilai_pasar',
                                         jenis_perolehan='$jenis_perolehan',
                                         npop='$npop', 
                                         npoptkp='$npoptkp', 
                                         jns_setoran='$dasar_jml_setoran', 
                                         jns_setoran_nomor='$nomor_jml_setoran', 
                                         jns_setoran_tanggal='$tgl_jml_setoran', 
                                         jns_setoran_hitung_sendiri='$hitung_sendiri_jml_setoran', 
                                         jns_setoran_custom='$custom_jml_setoran', 
                                         jumlah_setor='$jml_setor', 
                                         tanggal='$tanggal', 
                                         no_dokumen='$no_dokumen', 
                                         nop_pbb_baru='$nop_pbb_baru'
                  WHERE id_sptpd='$id'";

        if ($tgl_jml_setoran == '') {
            $query = "UPDATE $this->tbl SET id_ppat='$id_ppat', 
                                         nik='$nik', 
                                         nop='$nop', 
                                         nilai_pasar='$nilai_pasar',
                                         jenis_perolehan='$jenis_perolehan',
                                         npop='$npop', 
                                         npoptkp='$npoptkp', 
                                         jns_setoran='$dasar_jml_setoran', 
                                         jns_setoran_nomor='$nomor_jml_setoran', 
                                         jns_setoran_tanggal=NULL, 
                                         jns_setoran_hitung_sendiri='$hitung_sendiri_jml_setoran', 
                                         jns_setoran_custom='$custom_jml_setoran', 
                                         jumlah_setor='$jml_setor', 
                                         tanggal='$tanggal', 
                                         no_dokumen='$no_dokumen', 
                                         nop_pbb_baru='$nop_pbb_baru' 
                  WHERE id_sptpd='$id'";
        }

        if ($this->db->query($query)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_sptpd($id)
    {
        $this->db->where('id_sptpd', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function set_lunas($no_dokumen, $lunas = '')
    {
        $ed_data = array('is_lunas' => '1');
        if ($lunas != '') $ed_data = array('is_lunas' => $lunas);
        //$this->db->where('is_lunas', '0');
        $this->db->where('no_dokumen', $no_dokumen);
        if ($this->db->update($this->tbl, $ed_data)) {
            return true;
        } else {
            return false;
        }
    }

    function get_sptpd_no_dokumen($no)
    {
        $this->db->where('no_dokumen', $no);
        $query = $this->db->get($this->tbl);
        return $query->row();
    }
}
