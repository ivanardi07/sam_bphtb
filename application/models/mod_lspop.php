<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

/**
 * Filename: mod_lspop.php
 * Description: LSPOP model
 * Date created: 2022-03-11
 * Author: M. Faizal Ali Fahmi (faizal.alifahmi@gmail.com)
 */
class Mod_lspop extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_lspop';
    }

    public function add_lspop($data)
    {
        $id_sptpd       = $data['last_id_sptpd'];
        $jml_bangunan   = $data['jml_bangunan'];
        $lspopData      = json_decode($data['lspopData']);
        $values         = '';
        for ($i = 0; $i < $jml_bangunan; $i++) {
            $comma = ($i < $jml_bangunan - 1) ? ',' : '';
            $values .= "(
                $id_sptpd,
                " . $lspopData[$i]->jenis_transaksi . ",
                " . $lspopData[$i]->bangunan_ke . ",
                " . $lspopData[$i]->jenis_bangunan . ",
                " . $lspopData[$i]->luas_bangunan . ",
                " . $lspopData[$i]->jumlah_lantai . ",
                " . $lspopData[$i]->tahun_dibangun . ",
                " . $lspopData[$i]->tahun_direnovasi . ",
                " . $lspopData[$i]->daya_listrik . ",
                " . $lspopData[$i]->kondisi . ",
                " . $lspopData[$i]->konstruksi . ",
                " . $lspopData[$i]->atap . ",
                " . $lspopData[$i]->dinding . ",
                " . $lspopData[$i]->lantai . ",
                " . $lspopData[$i]->langit_langit . "
            )$comma";
        }

        if ($values != "") {
            $query = "INSERT INTO $this->tbl (
                id_sptpd,
                jenis_transaksi,
                bangunan_ke,
                jenis_bangunan,
                luas_bangunan,
                jumlah_lantai,
                tahun_dibangun,
                tahun_direnovasi,
                daya_listrik,
                kondisi,
                konstruksi,
                atap,
                dinding,
                lantai,
                langit_langit
            ) VALUES $values";

            if ($this->db->query($query)) {
                $this->antclass->go_log($this->db->last_query());
                return array(
                    "status"    => true,
                    "query"     => $query
                );
            }
        }

        return array(
            "status"        => false,
            "query"         => 'no query executed',
            "id_sptpd"      => $id_sptpd,
            "jml_bangunan"  => $jml_bangunan,
            "lspopData"     => $lspopData
        );
    }
}
