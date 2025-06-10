<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
class Sptpd_model extends CI_Model
{
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

    function get_sptpd($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $id_ppat = "")
    {

        $pencarian = $this->session->userdata('pencarian');

        if (@$pencarian['cari'] != '') {
            $isi    = trim($pencarian['cari']);

            $nop    = explode('.', $isi);
            @$propinsi  = $nop[0];
            @$kabupaten = $nop[1];
            @$kecamatan = $nop[2];
            @$kelurahan = $nop[3];
            @$blok      = $nop[4];
            @$urut      = $nop[5];
            @$jenis     = $nop[6];
        }

        if (@$pencarian['no_sspd'] != '') {
            $this->db->where('no_dokumen', @$pencarian['no_sspd']);
        }

        if (!empty($id)) {
            $this->db->where('id_sptpd', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            if (!empty($limit)) {
                $this->db->limit($limit);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('kd_propinsi', $propinsi);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('kd_kabupaten', $kabupaten);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('kd_kecamatan', $kecamatan);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('kd_kelurahan', $kelurahan);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('kd_blok', $blok);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('no_urut', $urut);
            }
            if (!empty(@$propinsi)) {
                $this->db->where('kd_jns_op', $jenis);
            }

            $type_user = $this->session->userdata('s_tipe_bphtb');

            if ($type_user == 'PT') {
                $id_ppat = $this->session->userdata('s_id_ppat');
                $this->db->where('id_ppat', $id_ppat);
            }
            // if ($type_user == 'D') {
            //     $username = $this->session->userdata('s_username_bphtb');
            //     if ($username != 'admin') {
            //         $id_dispenda = $this->session->userdata('s_id_dispenda');
            //         $this->db->where('id_dispenda',$id_dispenda);
            //     }
            // }

            $this->db->order_by('tanggal', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function get_id_ppat($id_user = '')
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_ppat');
        $id = $query->result();
        $id = $id[0]->id_ppat;
        return $id;
    }

    function get_user($id_user = '')
    {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tbl_user');
        $id = $query->result();
        @$tipe = $id[0]->tipe;
        return @$tipe;
    }

    function sum_jumlah_setor($ppat = '', $approve = false)
    {
        if (!empty($ppat)) {
            $this->db->where('id_ppat', $ppat);
        }
        if (!$approve) {
            $this->db->where('id_ppat', '');
        }
        $this->db->select("SUM(jumlah_setor) AS grand_total");
        $query = $this->db->get($this->tbl);
        return $query->row();
    }
}
