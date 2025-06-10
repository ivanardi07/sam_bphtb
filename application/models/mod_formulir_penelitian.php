<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_formulir_penelitian.php
 * Description: formulir_penelitian model
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_formulir_penelitian extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_formulir_penelitian';
    }

    function get_formulir_penelitian($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '')
    {
        if (!empty($id)) {
            $this->db->where('id_formulir', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!empty($limit)) {
                $this->db->limit($limit);
            }
            if (!empty($go_page)) {
                $this->db->limit($halt_at, $start);
            }
            $this->db->join('tbl_sptpd', 'no_dokumen = no_sspd', 'left');
            $type_user = $this->session->userdata('s_tipe_bphtb');

            if ($type_user == 'PT') {
                $id_ppat = $this->session->userdata('s_id_ppat');
                $this->db->where('id_ppat', $id_ppat);
            }
            $this->db->order_by('id_formulir', 'asc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }
    function getByNoSSPD($no_sspd)
    {
        $this->db->where('no_sspd', $no_sspd);
        return $this->db->get($this->tbl)->row();
    }
    function count_formulir_penelitian()
    {
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }
    function add_formulir_penelitian($add_data)
    {
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_formulir_penelitian($id, $ed_data)
    {
        $this->db->where('id_formulir', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_formulir_penelitian($id)
    {
        $this->db->where('id_formulir', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    public function getWP($id = '')
    {
        $data       = $this->db->get_where('tbl_sptpd', array('no_dokumen' => $id))->result();
        $detail_wp  = array();

        if ($data) {
            $data_nik                   = $this->db->get_where('tbl_nik', array('nik'               => $data[0]->nik))->result_array();
            $detail_wp                  = $data_nik[0];

            $arr_prop                   = array(
                'kd_propinsi' => $detail_wp['kd_propinsi']
            );
            $propinsi                   = $this->db->get_where('tbl_propinsi', $arr_prop)->result();
            $detail_wp['nm_propinsi']   = @$propinsi[0]->nama;

            $arr_kab                    = array(
                'kd_propinsi'   => $detail_wp['kd_propinsi'],
                'kd_kabupaten'  => $detail_wp['kd_kabupaten'],
            );
            $kabupaten                  = $this->db->get_where('tbl_kabupaten', $arr_kab)->result();
            $detail_wp['nm_kabupaten']  = @$kabupaten[0]->nama;

            $arr_kec                    = array(
                'kd_propinsi'   => $detail_wp['kd_propinsi'],
                'kd_kabupaten'  => $detail_wp['kd_kabupaten'],
                'kd_kecamatan'  => $detail_wp['kd_kecamatan'],
            );
            $kecamatan                  = $this->db->get_where('tbl_kecamatan', $arr_kec)->result();
            $detail_wp['nm_kecamatan']  = @$kecamatan[0]->nama;

            $arr_kel                    = array(
                'kd_propinsi'   => $detail_wp['kd_propinsi'],
                'kd_kabupaten'  => $detail_wp['kd_kabupaten'],
                'kd_kecamatan'  => $detail_wp['kd_kecamatan'],
                'kd_kelurahan'  => $detail_wp['kd_kelurahan'],
            );
            $kelurahan                  = $this->db->get_where('tbl_kelurahan', $arr_kel)->result();
            $detail_wp['nm_kelurahan']  = @$kelurahan[0]->nama;
        }

        return $detail_wp;
    }
}

/* EoF */