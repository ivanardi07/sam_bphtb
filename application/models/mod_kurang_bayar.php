<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_sptpd.php
 * Description: SPTPD model
 * Date created: 2011-03-19
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_kurang_bayar extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_sptpd';
    }

    public function get_sptpd($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '', $nop = '', $nodok = '', $date_start = '', $date_end = '')
    {
        if ($id != '') {
            $this->db->where('id_sptpd', $id);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->row();
        } elseif ($nik != '') {
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if (count(@$nop[1][0]) > 0) {
                $this->db->where('kd_propinsi', @$nop[0]);
                $this->db->where('kd_kabupaten', @$nop[1]);
                $this->db->where('kd_kecamatan', @$nop[2]);
                $this->db->where('kd_kelurahan', @$nop[3]);
                $this->db->where('kd_blok', @$nop[4]);
                $this->db->where('no_urut', @$nop[5]);
                $this->db->where('kd_jns_op', @$nop[6]);
            }
            if ($nodok != '') {
                $this->db->where('no_dokumen', $nodok);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            if ($date_start != '') {
                $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
            }

            $type_user = $this->session->userdata('s_tipe_bphtb');

            if ($type_user == 'PT') {
                $id_ppat = $this->session->userdata('s_id_ppat');
                $this->db->where('id_ppat', $id_ppat);
            }

            $this->db->where('is_kurang_bayar', '1');

            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    public function count_sptpd($date_start = '', $date_end = '', $pp = '', $ppat = '', $pwp = '', $stb = '', $skbkb = '', $skbkbt = '', $user = '', $nodok = '', $status = '')
    {
        // echo $nodok;exit();
        if ($date_start != '') {
            $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        }
        if ($pp != '') {
            $this->db->where('id_pp', $pp);
        }
        if ($ppat != '' && $ppat != 'DISPENDA') {
            $this->db->where('id_ppat', $ppat);
        }
        if ($ppat == 'DISPENDA') {
            $this->db->where("id_ppat = ''");
        }
        if ($stb != '') {
            $this->db->where('jns_setoran', $stb);
        }
        if ($skbkb != '') {
            $this->db->where('jns_setoran', $skbkb);
        }
        if ($skbkbt != '') {
            $this->db->where('jns_setoran', $skbkbt);
        }
        if ($user != '') {
            $this->db->where('id_user', $user);
        }
        // echo $nodok;exit();
        if ($nodok != '') {
            $this->db->where('no_dokumen', $nodok);
        }

        if ($status != '') {

            if ($status == 'lunas') {
                $this->db->where('validasi_dispenda !=', 'null');
            } elseif ($status == 'belum') {
                $this->db->where('validasi_dispenda IS NULL');
            } elseif ($status == 'tidak_kena_pajak') {
                $this->db->where('npop < npoptkp');
            }
        }

        $this->db->where('is_kurang_bayar', '1');

        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }
}
