<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_sppt.php
 * Description: SPPT model
 * Date created: 2011-05-26
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_sppt extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'sppt';
    }

    function get_sppt($nop = '', $limit = '', $go_page = '', $start = '', $halt_at = '')
    {
        if ($id != '') {
            $arr_nop = explode('.', $nop);
            $this->db->where('kd_propinsi', $arr_nop[0]);
            $this->db->where('kd_dati2', $arr_nop[1]);
            $this->db->where('kd_kecamatan', $arr_nop[2]);
            $this->db->where('kd_kelurahan', $arr_nop[3]);
            $this->db->where('kd_blok', $arr_nop[4]);
            $this->db->where('no_urut', $arr_nop[5]);
            $this->db->where('kd_jns_op', $arr_nop[6]);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function check_sppt($nop)
    {
        $arr_nop = explode('.', $nop);
        $this->db->where('kd_propinsi', $arr_nop[0]);
        $this->db->where('kd_dati2', $arr_nop[1]);
        $this->db->where('kd_kecamatan', $arr_nop[2]);
        $this->db->where('kd_kelurahan', $arr_nop[3]);
        $this->db->where('kd_blok', $arr_nop[4]);
        $this->db->where('no_urut', $arr_nop[5]);
        $this->db->where('kd_jns_op', $arr_nop[6]);
        $query = $this->db->get($this->tbl);
        $sppt_nop = $query->row();
        if ($sppt_nop) {
            $last = $this->get_last_sppt($nop);
            return array(
                'nama' => $sppt_nop->nm_wp_sppt,
                'urut_skr' => $last->no_urut,
                'luas_bumi' => $sppt_nop->luas_bumi_sppt,
                'njop_bumi' => $sppt_nop->njop_bumi_sppt,
                'luas_bng' => $sppt_nop->luas_bng_sppt,
                'njop_bng' => $sppt_nop->njop_bng_sppt,
                'pbb_bayar' => $sppt_nop->pbb_terhutang_sppt
            );
        }

        return FALSE;
    }

    function get_last_sppt($nop)
    {
        $arr_nop = explode('.', $nop);
        $this->db->limit(1);
        $this->db->order_by('no_urut', 'desc');
        $this->db->where('kd_propinsi', $arr_nop[0]);
        $this->db->where('kd_dati2', $arr_nop[1]);
        $this->db->where('kd_kecamatan', $arr_nop[2]);
        $this->db->where('kd_kelurahan', $arr_nop[3]);
        $this->db->where('kd_blok', $arr_nop[4]);
        $query = $this->db->get($this->tbl);
        $sppt_nop = $query->row();
        if ($sppt_nop) {
            return $sppt_nop;
        }

        return 0;
    }

    function add_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jenis_op, $thn_pajak, $nama, $jln, $rw, $rt, $kecamatan, $kelurahan, $kota, $luas_bumi, $luas_bng, $njop_bumi, $njop_bng, $pbb_bayar, $nik, $token, $tgl_input)
    {
        $query = "INSERT INTO $this->tbl (kd_propinsi, kd_dati2, kd_kecamatan, kd_kelurahan, kd_blok, no_urut, kd_jns_op, 
                                               thn_pajak_sppt, nm_wp_sppt, jln_wp_sppt, rw_wp_sppt, rt_wp_sppt, kelurahan_wp_sppt, 
                                               kota_wp_sppt, luas_bumi_sppt, luas_bng_sppt, njop_bumi_sppt, njop_bng_sppt,
                                               pbb_harus_dibayar_sppt, jalan_op, rw_op, rt_op, kelurahan_op, kecamatan_op, nik, token, tgl_input)
                  VALUES ('$kd_propinsi', '$kd_dati2', '$kd_kecamatan', '$kd_kelurahan', '$kd_blok', '$no_urut', '$kd_jenis_op', 
                          '$thn_pajak', '$nama', '$jln', '$rw', '$rt', '$kelurahan', '$kota', '$luas_bumi', '$luas_bng', '$njop_bumi', 
                          '$njop_bng', '$pbb_bayar', '$jln', '$rw', '$rt', '$kelurahan', '$kecamatan', '$nik', '$token', '$tgl_input')";

        if ($this->db->query($query)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    //function edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jenis_op, $thn_pajak, $nama, $luas_bumi, $luas_bng, $njop_bumi, $njop_bng, $pbb_bayar)
    function edit_parted_sppt($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jenis_op, $thn_pajak, $nama, $luas_bumi, $luas_bng, $nik = '', $token = '', $njop_bumi = '', $njop_bng = '', $pbb_bayar = '')
    {
        /*
        $query = "UPDATE $this->tbl SET(luas_bumi_sppt='$luas_bumi', luas_bng_sppt='$luas_bng', njop_bumi_sppt='$njop_bumi', 
                                        njop_bng_sppt='$njop_bng', pbb_harus_dibayar_sppt='$pbb_bayar') 
                  WHERE kd_propinsi='$kd_propinsi', kd_dati2='$kd_dati2', kd_kecamatan='$kd_kecamatan', kd_kelurahan='$kd_kelurahan',
                        kd_blok='$kd_blok', no_urut='$no_urut', kd_jns_op='$kd_jns_op', thn_pajak_sppt='$thn_pajak'";
        */
        $set = '';
        if ($njop_bumi != '') {
            $set .= ", njop_bumi_sppt='$njop_bumi'";
        }
        if ($njop_bng != '') {
            $set .= ", njop_bng_sppt='$njop_bng'";
        }
        if ($pbb_bayar != '') {
            $set .= ", pbb_harus_dibayar_sppt='$pbb_bayar'";
        }
        $where = '';
        if ($nik != '') {
            $where .= " AND nik='$nik'";
        }
        if ($token != '') {
            $where .= " AND token='$token'";
        }
        $query = "UPDATE $this->tbl SET luas_bumi_sppt='$luas_bumi', luas_bng_sppt='$luas_bng' $set 
                  WHERE kd_propinsi='$kd_propinsi' AND kd_dati2='$kd_dati2' AND kd_kecamatan='$kd_kecamatan' 
                        AND kd_kelurahan='$kd_kelurahan' AND kd_blok='$kd_blok' AND no_urut='$no_urut' AND kd_jns_op='$kd_jenis_op' 
                        AND thn_pajak_sppt='$thn_pajak' $where";

        if ($this->db->query($query)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }
}

/* EoF */