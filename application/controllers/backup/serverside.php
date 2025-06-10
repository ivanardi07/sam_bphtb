<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: serverside.php
 * Description: Serverside Controller
 * Date created: 2023-05-23
 * Author: Mokhamad Faizal Ali FAhmi (faizal.alifahmi@gmail.com)
 */
class Serverside extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('ssp');
    }

    public function index()
    {

        $id_ppat    = $this->input->post('id_ppat');
        $id_wp      = $this->input->post('id_wp');
        $akses      = $this->input->post('akses');
        $jabatan    = $this->input->post('userdata');

        if ($akses == 'PT') {
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE id_ppat = ' . $id_ppat . ') tbl';
        } else if ($akses == 'D' && $jabatan == 0) {
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik WHERE YEAR(tanggal) >= YEAR(curdate())-1 ) tbl';
        } else if ($akses == 'D' && $jabatan == 1) {
            //12115
            //WHERE sptpd.id_sptpd BETWEEN 12116 AND 14000
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE proses = "0" AND YEAR(tanggal) >= YEAR(curdate())-1 ) tbl';
        } else if ($akses == 'D' && $jabatan == 2) {
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE proses > "0"
               AND proses < "2") tbl';
        } else if ($akses == 'D' && $jabatan == 3) {
            /* AKSES BAPENDA DI BPN VALIDASI */
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE is_lunas = "1"
               OR is_lunas = "2") tbl';
        } else if ($akses == 'WP') {
            /* END AKSES BAPENDA DI BPN VALIDASI */
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE id_wp = ' . $id_wp . ') tbl';
        }

        $primaryKey = 'id_sptpd';

        $columns = array(
            array('db' => 'id_sptpd',  'dt' => 0),
            array(
                'db' => 'tanggal',
                'dt' => 2,
                'formatter' => function ($d, $row) {
                    $bulan = array(
                        1   =>  'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    );
                    $a = date('d-m-Y', strtotime($d));
                    $pecahkan = explode('-', $a);
                    return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
                }
            ),
            array('db' => 'no_pelayanan',       'dt' => 3),
            array('db' => 'nama',               'dt' => 4),
            array('db' => 'nop_alamat',         'dt' => 5),
            array(
                'db' => 'jumlah_setor',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    return 'Rp. ' . number_format($d, 0, ",", ".");
                }
            ),

            array('db' => 'aprove_ppat',        'dt' => 9),
            array('db' => 'proses',             'dt' => 10),
            array('db' => 'is_lunas',           'dt' => 11),
            array('db' => 'no_dokumen',         'dt' => 12),
            array('db' => 'wajibpajak',         'dt' => 13),
        );

        // $sql_details = array(
        //     'user' => 'bphtb',
        //     'pass' => 'D3vc0n1028',
        //     'db'   => 'bphtb_v3',
        //     'host' => 'localhost'
        // );

        $sql_details = array(
            'user' => 'bphtb',
            'pass' => 'bphtb_vitri',
            'db'   => 'bphtb_v3',
            'host' => 'localhost'
        );

        echo json_encode(
            $this->ssp->simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }
}
