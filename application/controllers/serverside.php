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
        $this->antclass->auth_user();
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
               JOIN tbl_nik nik ON sptpd.nik = nik.nik ) tbl';
        } else if ($akses == 'D' && $jabatan == 1) {
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE proses = "0" AND (IS_LUNAS = "" OR IS_LUNAS IS NULL)) tbl';
        } else if ($akses == 'D' && $jabatan == 2) {
            if ($this->input->post('mode')) {
                $tgl1_12bulanlalu = date('Y-m-01', strtotime('-12 months'));
                $table = '(SELECT sptpd.*, nik.nama 
                FROM tbl_sptpd sptpd 
                JOIN tbl_nik nik ON sptpd.nik = nik.nik
                WHERE IS_LUNAS = "1"
                AND sptpd.tanggal > \'' . $tgl1_12bulanlalu . ' 00:00:00\'
                ) tbl';
            } else {
                $table = '(SELECT sptpd.*, nik.nama 
                FROM tbl_sptpd sptpd 
                JOIN tbl_nik nik ON sptpd.nik = nik.nik
                WHERE proses > "0"
                AND proses < "2" AND (IS_LUNAS = "" OR IS_LUNAS IS NULL))  tbl';
            }
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
                'type' => "date",
                'formatter' => function ($d, $row) {
                    $bulan = array(
                        'Januari',
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
                    return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1] - 1] . ' ' . $pecahkan[2];
                }
            ),
            array('db' => 'no_pelayanan',       'dt' => 3),
            // array('db' => 'nama',               'dt' => 4),
            array(
                'db'            => "CONCAT(nama, ' ', wajibpajak)",
                'dt'            => 4,
                'custom_column' => "nama",
            ),
            array('db' => 'nop_alamat',         'dt' => 5),
            array(
                'db' => 'jumlah_setor',
                'dt' => 6,
                'formatter' => function ($d, $row) {
                    return 'Rp. ' . number_format($d, 0, ",", ".");
                }
            ),
            array(
                'db' => "case 
                        when is_lunas='1' 										then 'LUNAS'
                        when is_lunas='2' 										then 'VALIDASI'
                        when is_lunas='4' 										then 'BATAL'
                        when is_lunas='5' 										then 'KADALUARSA'
                        when is_lunas='3' and aprove_ppat='1' 					then 'DIKEMBALIKAN BAPENDA'
                        when is_lunas='3' and aprove_ppat='-1' 				    then 'DIKEMBALIKAN PPAT'
                        when 				  aprove_ppat='1' and proses='2' 	then 'CETAK INFO PEMBAYARAN'
                        when 				  aprove_ppat='0' 					then 'PROSES PPAT'
                        else 'PROSES BAPENDA'
                    end
                ",
                'dt' => 7,
                'custom_column' => "status_sisi_wp",
                'exact_value'  => true
            ),
            array(
                'db' => "
                    case 
                        when is_lunas='1' 										then 'LUNAS'
                        when is_lunas='2' 										then 'VALIDASI'
                        when is_lunas='4' 										then 'BATAL'
                        when is_lunas='5' 										then 'KADALUARSA'
                        when is_lunas='3' and aprove_ppat='-1'and  proses='-1'	then 'DIKEMBALIKAN PPAT'
                        when is_lunas='3' and 					   proses='-1'	then 'DIKEMBALIKAN BAPENDA'
                        when is_lunas='3' and 					   proses='0'	then 'DOKUMEN DIKEMBALIKAN KASUBID'
                        when is_lunas='3' and 					   proses='1'	then 'DOKUMEN DIKEMBALIKAN KABID'
                        when 				  aprove_ppat='0'					then 'PPAT'
                        when 				   					   proses='-1'	then 'STAFF'
                        when 				   					   proses='2' 	then 'CETAK INFO PEMBAYARAN'
                        when 				   					   proses='1' 	then 'KEPALA BIDANG'
                        when 				   					   proses='0'	then 'KEPALA SUBBIDANG'
                        else 'ENTRI'
                    end
                ",
                'dt' => 8,
                'custom_column' => "status_sisi_admin",
                'exact_value'  => true
            ),
            array('db' => 'aprove_ppat',        'dt' => 9),
            array('db' => 'proses',             'dt' => 10),
            array('db' => 'is_lunas',           'dt' => 11),
            array('db' => 'no_dokumen',         'dt' => 12),
            // array('db' => "CONCAT(nama, ' ', wajibpajak) as wajibpajak",         'dt' => 13),
            array('db' => 'wajibpajak',         'dt' => 13)
        );

        $sql_details = array(
            'user' => 'root',
            'pass' => '',
            'db'   => 'bphtb_v3',
            'host' => 'localhost'
        );

        if (@$table) {
            echo json_encode($this->ssp->complex($this->input->post(), $sql_details, $table, $primaryKey, $columns));
        } else {
            echo json_encode(array());
        }
    }

    public function lunas()
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
               JOIN tbl_nik nik ON sptpd.nik = nik.nik ) tbl';
        } else if ($akses == 'D' && $jabatan == 1) {
            $table = '(SELECT sptpd.*, nik.nama 
               FROM tbl_sptpd sptpd 
               JOIN tbl_nik nik ON sptpd.nik = nik.nik
               WHERE proses = "0" AND (IS_LUNAS = "" OR IS_LUNAS IS NULL)) tbl';
        } else if ($akses == 'D' && $jabatan == 2) {
            if ($this->input->post('mode')) {
                $tgl1_12bulanlalu = date('Y-m-01', strtotime('-12 months'));
                $table = '(SELECT sptpd.*, nik.nama 
                FROM tbl_sptpd sptpd 
                JOIN tbl_nik nik ON sptpd.nik = nik.nik
                WHERE IS_LUNAS = "1"
                AND sptpd.tanggal > \'' . $tgl1_12bulanlalu . ' 00:00:00\'
                ) tbl';
            } else {
                $table = '(SELECT sptpd.*, nik.nama 
                FROM tbl_sptpd sptpd 
                JOIN tbl_nik nik ON sptpd.nik = nik.nik
                WHERE proses > "0"
                AND proses < "2" AND (IS_LUNAS = "" OR IS_LUNAS IS NULL))  tbl';
            }
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
            array(
                'db'            => "id_sptpd",
                'dt'            => 0,
                'custom_column' => "id",
            ),
            array('db' => 'id_sptpd',  'dt' => 1),
            array(
                'db' => 'tanggal',
                'dt' => 3,
                'type' => "date",
                'formatter' => function ($d, $row) {
                    $bulan = array(
                        'Januari',
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
                    return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1] - 1] . ' ' . $pecahkan[2];
                }
            ),
            array('db' => 'no_pelayanan',       'dt' => 4),
            // array('db' => 'nama',               'dt' => 4),
            array(
                'db'            => "CONCAT(nama, ' ', wajibpajak)",
                'dt'            => 5,
                'custom_column' => "nama",
            ),
            array('db' => 'nop_alamat',         'dt' => 6),
            array(
                'db' => 'jumlah_setor',
                'dt' => 7,
                'formatter' => function ($d, $row) {
                    return 'Rp. ' . number_format($d, 0, ",", ".");
                }
            ),
            array(
                'db' => "case 
                        when is_lunas='1' 										then 'LUNAS'
                        when is_lunas='2' 										then 'VALIDASI'
                        when is_lunas='4' 										then 'BATAL'
                        when is_lunas='5' 										then 'KADALUARSA'
                        when is_lunas='3' and aprove_ppat='1' 					then 'DIKEMBALIKAN BAPENDA'
                        when is_lunas='3' and aprove_ppat='-1' 				    then 'DIKEMBALIKAN PPAT'
                        when 				  aprove_ppat='1' and proses='2' 	then 'CETAK INFO PEMBAYARAN'
                        when 				  aprove_ppat='0' 					then 'PROSES PPAT'
                        else 'PROSES BAPENDA'
                    end
                ",
                'dt' => 8,
                'custom_column' => "status_sisi_wp",
                'exact_value'  => true
            ),
            array(
                'db' => "
                    case 
                        when is_lunas='1' 										then 'LUNAS'
                        when is_lunas='2' 										then 'VALIDASI'
                        when is_lunas='4' 										then 'BATAL'
                        when is_lunas='5' 										then 'KADALUARSA'
                        when is_lunas='3' and aprove_ppat='-1'and  proses='-1'	then 'DIKEMBALIKAN PPAT'
                        when is_lunas='3' and 					   proses='-1'	then 'DIKEMBALIKAN BAPENDA'
                        when is_lunas='3' and 					   proses='0'	then 'DOKUMEN DIKEMBALIKAN KASUBID'
                        when is_lunas='3' and 					   proses='1'	then 'DOKUMEN DIKEMBALIKAN KABID'
                        when 				  aprove_ppat='0'					then 'PPAT'
                        when 				   					   proses='-1'	then 'STAFF'
                        when 				   					   proses='2' 	then 'CETAK INFO PEMBAYARAN'
                        when 				   					   proses='1' 	then 'KEPALA BIDANG'
                        when 				   					   proses='0'	then 'KEPALA SUBBIDANG'
                        else 'ENTRI'
                    end
                ",
                'dt' => 9,
                'custom_column' => "status_sisi_admin",
                'exact_value'  => true
            ),
            array('db' => 'aprove_ppat',        'dt' => 10),
            array('db' => 'proses',             'dt' => 11),
            array('db' => 'is_lunas',           'dt' => 12),
            array('db' => 'no_dokumen',         'dt' => 13),
            // array('db' => "CONCAT(nama, ' ', wajibpajak) as wajibpajak",         'dt' => 13),
            array('db' => 'wajibpajak',         'dt' => 14)
        );

        $sql_details = array(
            'user' => 'root',
            'pass' => '',
            'db'   => 'bphtb_v3',
            'host' => 'localhost'
        );

        if (@$table) {
            echo json_encode($this->ssp->complex($this->input->post(), $sql_details, $table, $primaryKey, $columns));
        } else {
            echo json_encode(array());
        }
    }
}
