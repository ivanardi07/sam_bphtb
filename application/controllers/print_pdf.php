<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: ppat.php
 * Description: PPAT controller
 * Date created: 2011-03-08
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Print_pdf extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_sppt');
        $this->load->model('mod_ppat');
        $this->load->model('mod_nik');
        $this->load->model('mod_nop');
        $this->load->model('mod_dati2');
        $this->load->model('mod_propinsi');
        $this->load->model('mod_kecamatan');
        $this->load->model('mod_kelurahan');
        $this->load->model('mod_jns_perolehan');
        $this->load->model('mod_rekening');
        $this->load->model('mod_paymentpoint');
        $this->load->model('mod_nop_log');
        $this->load->model('mod_user');
        $this->load->model('mod_prefix');
        $this->load->model('mod_validasi_sptpd', 'pembayaran');
    }

    public function index()
    {
    }

    public function sspdbphtbsigned($id_sptpd)
    {
        $this->load->library("pdf");

        #1 get nama file pdf
        $file_validasi_sspd = $this->mod_sptpd->get_file_validasi_name($id_sptpd)->file_validasi;

        #2 muat pdf di browser
        $fileloc = FCPATH . "assets/files/sspd_bphtb/$id_sptpd/$file_validasi_sspd";
        $this->pdf->load_saved_pdf($fileloc, $file_validasi_sspd);
    }

    public function SSPDBPHTBPDF($id)
    {
        $data['id']       = $id;
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);

        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $jatuhtempo        = $data['sptpd']->tgl_exp_billing;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        $sk_pengurangan   = $data['sptpd']->sk_pengurangan;
        $tgl_sk_pengurangan = $data['sptpd']->tgl_sk_pengurangan;

        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        @$data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);

        $wil_nik                     = (array) $data['nik'];
        $wil_nik                     = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);

        $data['kabid']  = $this->mod_user->get_kabid();

        $ltnt = @$data['sptpd']->tanah_inp_aphb3 * @$data['sptpd']->njop_tanah_op;
        $lbnb = @$data['sptpd']->bangunan_inp_aphb3 * @$data['sptpd']->njop_bangunan_op;

        $npopkp = @$data['sptpd']->npop - @$data['sptpd']->npoptkp;
        if ($npopkp <= 0) {
            $npopkp = 0;
        };
        $npopkp5 = 0.05 * @$npopkp;
        // echo $npopkp;exit(); 

        if (!is_null(@$data['sptpd']->tgl_sk_pengurangan)) {
            @$tanggal_sk = strtotime(@$data['sptpd']->tgl_sk_pengurangan);
            @$tgl_sk = date("d-m-Y", $tanggal_sk);
        } else {
            @$tgl_sk = NULL;
        }

        $tujuan = array(
            1 => 'Untuk Wajib Pajak',
            2 => 'Untuk PPAT/Notaris',
            3 => 'Untuk Kepala Kantor Bidang Pertanahan',
            4 => 'Untuk Badan Pendapatan Daerah',
            5 => 'Untuk Bank',
            6 => 'Untuk Bank yang ditunjuk Bendahara',
        );


        for ($i = 1; $i < 7; $i++) {
            if ($i > 1) {
                // $this->fpdf->pdf->AddPage();
            }
            $data['nomor'] = $i;
            $data['tujuan'] = $tujuan[$i];
            // echo "<pre>";
            // print_r ($tujuan);exit();
            // echo "</pre>";

        }


        $this->load->library('fpdf_gen');
        $pdf = new fpdf('P', 'mm', array(210, 340));

        foreach ($tujuan as $key => $value) {

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 0);

            $image = base_url() . 'assets/template/assets/images/users/logo_malang.gif';
            $pdf->Image($image, 20, 12, 35, 35);

            $imageTTE = base_url() . 'assets/images/spesiment/3573031709750006.jpg';
            $pdf->Image($imageTTE, 146, 275, 53, 17);

            $image_logo_bsre = base_url() . 'assets/images/bsre-logo.png';
            $pdf->Image($image_logo_bsre, 130, 315, 25, 9);

            $image_logo_ebphtb = base_url() . 'assets/images/logo-ebphtb.png';
            $pdf->Image($image_logo_ebphtb, 160, 315, 40, 9);

            $qr_file = base_url() . 'assets/images/qrcode/coba.png';
            $pdf->Image($qr_file, 10, 310, 20, 20);

            // $pdf->Image(base_url() . 'assets/template/assets/images/users/avatar.jpg');  

            // header----------

            if ($value == 'Untuk Wajib Pajak') {
            } elseif ($value == 'Untuk PPAT/Notaris') {
                $pdf->SetFillColor(45, 255, 85);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Kepala Kantor Bidang Pertanahan') {
                $pdf->SetFillColor(0, 165, 255);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Badan Pendapatan Daerah') {
                $pdf->SetFillColor(255, 105, 180);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Bank') {
                $pdf->SetFillColor(229, 255, 0);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Bank yang ditunjuk Bendahara') {
                $pdf->SetFillColor(255, 0, 0);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            }
            $masabulan = date("m", strtotime($data['sptpd']->tanggal));
            $masatahun = date("Y", strtotime($data['sptpd']->tanggal));

            $pdf->SetFont('Times', 'B', 11);
            $pdf->Cell(55, 5, '', 'LTR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LTR', 0, 'C');
            $pdf->Cell(55, 5, '', 'LTR', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'No. SSPD', 'R', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, @$data['sptpd']->no_dokumen, 'R', 1, 'C');


            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, 'SURAT SETORAN PAJAK DAERAH', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'NTPD/Kode Billing', 'R', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, 'BEA PEROLEHAN HAK ATAS TANAH', 'LR', 0, 'C');
            $pdf->Cell(55, 5, @$data['sptpd']->idbilling, 'R', 1, 'C');
            //$pdf->Cell(55,5,idbilling(@$data['sptpd']->no_dokumen), 'R', 1, 'C');

            /*
            $pdf->Cell(55,5,'', 'LR', 0, 'C');
            $pdf->Cell(80,5,'DAN BANGUNAN', 'LR', 0, 'C');
            $pdf->Cell(55,5,'Lembar '.$key, 'R', 1, 'C');

            $pdf->Cell(55,5,'', 'LR', 0, 'C');
            $pdf->Cell(80,5,'(SSPD-BPHTB)', 'LR', 0, 'C');
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(55,5,$value, 'R', 1, 'C');
            

            $pdf->Cell(55,5,'', 'LR', 0, 'C');
            $pdf->Cell(80,5,'', 'LR', 0, 'C');
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(55,5,'', 'R', 1, 'C');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(55,2,'BADAN PENDAPATAN', 'LR', 0, 'C');
            $pdf->Cell(80,2,'', 'LR', 0, 'C');
            $pdf->Cell(55,2,'', 'R', 1, 'C');

            $pdf->Cell(55,5,'DAERAH KOTA MALANG', 'LR', 0, 'C');
            $pdf->Cell(80,5,'', 'LR', 0, 'C');
            $pdf->Cell(55,5,'', 'R', 1, 'C'); 
            */

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, 'DAN BANGUNAN', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'Masa Pajak : ' . $masabulan . ' - ' . $masatahun, 'R', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '(SSPD-BPHTB)', 'LR', 0, 'C');
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(55, 5, 'Lembar ' . $key, 'R', 1, 'C');


            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(55, 5, '' . $value, 'R', 1, 'C');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(55, 2, 'BADAN PENDAPATAN', 'LR', 0, 'C');
            $pdf->Cell(80, 2, '', 'LR', 0, 'C');
            $pdf->Cell(55, 2, '', 'R', 1, 'C');

            $pdf->Cell(55, 5, 'DAERAH KOTA MALANG', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, '', 'R', 1, 'C');


            // $pdf->Cell(55,5,'KOTA TABALONG', 'LR', 0, 'C');
            // $pdf->Cell(80,5,'', 'LR', 0, 'C');
            // $pdf->Cell(55,5,'', 'R', 1, 'C');

            // batas header ------------------------------------

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(190, 5, '', 1, 1, 'L');

            // $pdf->SetFont('Times', '', 10);
            // $pdf->Cell(25, 5, 'PERHATIAN:', 'LTB', 0, 'L');

            // $pdf->SetFont('Times', '', 10);
            // $pdf->Cell(165, 5, ' ', 'BTR', 1, 'L');

            $pdf->SetFont('Times', '', 10);

            $pdf->Cell(190, 3, '', 'RL', 1, 'L');

            $pdf->Cell(10, 5, 'A.', 'L', 0, 'L');
            $pdf->Cell(40, 5, '1. Nama Wajib Pajak ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(135, 5, @$data['nik']->nama . " " . @$data['sptpd']->wajibpajak, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '2. NIK ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(135, 5, @$data['nik']->nik, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '3. Alamat Wajib Pajak ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(135, 5, @$data['nik']->alamat, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '4. Kelurahan/Desa', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nik_nm_kelurahan'], 0, 0, 'L');
            $pdf->Cell(30, 5, '5. RT/RW : ' . @$data['nik']->rtrw, 0, 0, 'L');
            $pdf->Cell(75, 5, '6. Kecamatan : ' . @$data['nik_nm_kecamatan'], 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '7. Kabupaten/Kota', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nik_nm_kabupaten'], 0, 0, 'L');
            $pdf->Cell(105, 5, '8. Kode Pos : ' . @$data['nik']->kodepos, 'R', 1, 'L');

            $pdf->Cell(190, 3, '', 'LBR', 1, 'L');
            $pdf->Cell(190, 3, '', 'LR', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(10, 5, 'B.', 'L', 0, 'L');
            $pdf->Cell(52, 5, '1. Nomor Wajib Pajak (NOP) PBB ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(123, 5, @$data['sptpd']->kd_propinsi . @$data['sptpd']->kd_kabupaten . @$data['sptpd']->kd_kecamatan . @$data['sptpd']->kd_kelurahan . @$data['sptpd']->kd_blok . @$data['sptpd']->no_urut . @$data['sptpd']->kd_jns_op, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(52, 5, '2. Letak tanah dan bangunan ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(123, 5, @$data['sptpd']->nop_alamat, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(52, 5, '3. Kelurahan / Desa ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nop_nm_kelurahan'], 0, 0, 'L');
            $pdf->Cell(93, 5, '4. RT/RW : ' . @$data['nop']->rtrw_op, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(52, 5, '5. Kecamatan ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nop_nm_kecamatan'], 0, 0, 'L');
            $pdf->Cell(93, 5, '6. Kabupaten / Kota : ' . @$data['nop_nm_kabupaten'], 'R', 1, 'L');


            $pdf->Cell(190, 5, '', 'LR', 1, 'L');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, ' ', 'LT', 0, 'C');
            $pdf->Cell(40, 5, 'LUAS', 'LT', 0, 'C');
            $pdf->Cell(40, 5, 'NJOP PBB/ M2', 'LT', 0, 'C');
            $pdf->Cell(40, 3, '', 'LTR', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, 'URAIAN ', 'L', 0, 'C');
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 3, '(Diisi luas tanah dan atau', 'L', 0, 'C');
            $pdf->Cell(40, 4, '(Diisi berdasarkan SPPT PBB', 'L', 0, 'C');
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(40, 3, 'LUAS NJOP PBB/ M2', 'LR', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, ' ', 'L', 0, 'C');
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 3, 'bangunan yang haknya diperoleh)', 'L', 0, 'C');
            $pdf->Cell(40, 3, 'tahun terjadinya perolehan hak/', 'L', 0, 'C');
            $pdf->Cell(40, 3, '', 'LR', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, ' ', 'LB', 0, 'C');
            $pdf->Cell(40, 3, '', 'LB', 0, 'C');
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 3, 'tahun.....)', 'LB', 0, 'C');
            $pdf->Cell(40, 3, '', 'LRB', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(10, 4, '', 'L', 0, 'C');
            $pdf->Cell(45, 4, 'Tanah (bumi)', 'L', 0, 'L');
            $pdf->Cell(5, 4, '7', 'L', 0, 'C');
            $pdf->Cell(35, 4, number_format(@$data['sptpd']->tanah_inp_aphb3, 1, ',', '.') . ' m2', 'L', 0, 'L');
            $pdf->Cell(5, 4, '9', 'LR', 0, 'C');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$data['sptpd']->njop_tanah_op, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(5, 4, '11', 'LR', 0, 'L');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$ltnt, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(15, 4, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LRB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(5, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(35, 3, 'angka 7 x angka 9', 'LBR', 0, 'L');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 4, '', 'L', 0, 'C');
            $pdf->Cell(45, 4, 'Bangunan', 'L', 0, 'L');
            $pdf->Cell(5, 4, '8', 'L', 0, 'C');
            $pdf->Cell(35, 4, number_format(@$data['sptpd']->bangunan_inp_aphb3, 1, ',', '.') . ' m2', 'L', 0, 'L');
            $pdf->Cell(5, 4, '10', 'LR', 0, 'C');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$data['sptpd']->njop_bangunan_op, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(5, 4, '12', 'LR', 0, 'L');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$lbnb, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(15, 4, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LRB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(5, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(35, 3, 'angka 8 x angka 10', 'LBR', 0, 'L');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 4, '', 'L', 0, 'C');
            $pdf->Cell(45, 4, 'NJOP PBB :', 0, 0, 'L');
            $pdf->Cell(5, 4, '', 0, 0, 'C');
            $pdf->Cell(35, 4, '', 0, 0, 'L');
            $pdf->Cell(5, 4, '', 0, 0, 'C');
            $pdf->Cell(35, 4, '', 0, 0, 'L');
            $pdf->Cell(5, 4, '13', 'L', 0, 'L');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$data['sptpd']->njop_pbb_op, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(15, 4, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, '', 0, 0, 'L');
            $pdf->Cell(5, 3, '', 0, 0, 'C');
            $pdf->Cell(35, 3, '', 0, 0, 'L');
            $pdf->Cell(5, 3, '', 0, 0, 'C');
            $pdf->Cell(35, 3, '', 0, 0, 'L');
            $pdf->Cell(5, 3, '', 'LB', 0, 'L');
            $pdf->Cell(35, 3, 'angka 11 + angka 12', 'LBR', 0, 'L');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(75, 5, '14. Harga transaksi/Nilai pasar', 0, 0, 'L');
            $pdf->Cell(50, 5, '', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Rp. ' . number_format(@$data['sptpd']->nilai_pasar, 0, ',', '.'), 1, 0, 'L');
            $pdf->Cell(15, 5, '', 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(30, 5, '15. Jenis perolehan hak atas tanah dan atau bangunan = ' . @$data['sptpd']->jenis_perolehan, 0, 0, 'L');
            $pdf->Cell(65, 5, '', 0, 0, 'L');
            $pdf->Cell(70, 5, '', 0, 0, 'L');
            $pdf->Cell(15, 5, '', 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(30, 5, '16. Nomor Sertifikat =', 0, 0, 'L');
            $pdf->Cell(65, 5, @$data['sptpd']->no_sertifikat_op, 0, 0, 'L');
            $pdf->Cell(70, 5, '', 0, 0, 'L');
            $pdf->Cell(15, 5, '', 'R', 1, 'L');

            $pdf->Cell(190, 3, '', 'LR', 1, 'L');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(50, 5, 'C. PENGHITUNGAN BPHTB', 'LTB', 0, 'L');
            $pdf->Cell(140, 5, '(hanya diisi berdasarkan penghitungan Wajib Pajak)', 'TRB', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(120, 5, '1. Nilai Perolehan Objek Pajak (NPOP) memperhatikan nilai pada B.13 dan B.14', 1, 0, 'L');
            $pdf->Cell(5, 5, '1', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$data['sptpd']->npop, 0, ',', '.'), 1, 1, 'L');

            $pdf->Cell(120, 5, '2. Nilai Perolehan Objek Pajak Tidak Kena Pajak (NPOPTKP)', 1, 0, 'L');
            $pdf->Cell(5, 5, '2', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$data['sptpd']->npoptkp, 0, ',', '.'), 1, 1, 'L');

            $pdf->Cell(90, 5, '3. Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP)', 1, 0, 'L');
            $pdf->Cell(30, 5, 'angka 1 - angka 2', 1, 0, 'L');
            $pdf->Cell(5, 5, '3', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$npopkp, 0, ',', '.'), 1, 1, 'L');

            $pdf->Cell(90, 5, '4. Bea Perolehan hak atas tanah dan bangunan yang terutang', 1, 0, 'L');
            $pdf->Cell(30, 5, '5% x angka 3', 1, 0, 'L');
            $pdf->Cell(5, 5, '4', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$npopkp5, 0, ',', '.'), 1, 1, 'L');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(50, 5, 'D. Jumlah setoran berdasarkan', 'LTB', 0, 'L');
            $pdf->Cell(140, 5, '', 'TRB', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(190, 2, '', 'LR', 1, 'L');
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'PWP') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'Penghitungan Wajib Pajak', 0, 0, 'L');
            $pdf->Cell(40, 5, '', 0, 0, 'L');
            $pdf->Cell(80, 5, '', 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'STB') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'STB', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Nomor :' . @$nomor_skb, 0, 0, 'L');
            $pdf->Cell(80, 5, 'Tanggal : ' . @$this->antclass->fix_date(@$tanggal_skb), 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'SKBKB') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'SKBKB', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Nomor :' . @$nomor_skb, 0, 0, 'L');
            $pdf->Cell(80, 5, 'Tanggal : ' . @$this->antclass->fix_date(@$tanggal_skb), 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'SKBKBT') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'SKBKBT', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Nomor :' . @$nomor_skb, 0, 0, 'L');
            $pdf->Cell(80, 5, 'Tanggal : ' . @$this->antclass->fix_date(@$tanggal_skb), 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'PDS') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'Perhitungan dihitung sendiri karena', 0, 0, 'L');
            //$pdf->Cell(120,5,'SK Pengurangan', 0, 0, 'L');


            $pdf->Cell(120, 5, @$data['sptpd']->sk_pengurangan . ' ' . @$tgl_sk, 'R', 1, 'L');

            //$sk_pengurangan   = $data['sptpd']->sk_pengurangan;
            //$tgl_sk_pengurangan = $data['sptpd']->tgl_sk_pengurangan;

            $pdf->Cell(190, 2, '', 'LRB', 1, 'L');

            // $pdf->Cell(190,3,'', 'LR', 1, 'L');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(80, 5, 'JUMLAH YANG DISETOR(dalam angka)', 'L', 0, 'L');
            $pdf->Cell(110, 5, '(dalam huruf)', 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(80, 5, 'Rp. ' . number_format(@$data['sptpd']->jumlah_setor, 0, ',', '.'), 'L', 0, 'L');
            $pdf->Cell(110, 5, @$data['terbilang_jml_setor'], 'R', 1, 'L');

            $pdf->SetFont('Times', '', 7);
            $pdf->Cell(80, 5, 'berdasarkan pilihan C4 dan pilihan D', 'L', 0, 'L');
            $pdf->Cell(110, 5, '', 'R', 1, 'L');

            $pdf->Cell(190, 2, '', 'LRB', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(48, 5, '', 'L', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 'L', 'C');
            $pdf->Cell(40, 5, '', 'LR', 'L', 'C');
            $pdf->Cell(55, 5, 'Telah diverifikasi:', 'LR', 1, 'C');

            $pdf->Cell(48, 5, '............, ' . changeDateFormat('webview', $data['sptpd']->tanggal), 'LR', 0, 'C');
            $pdf->Cell(47, 5, 'MENGETAHUI', 'LR', 0, 'C');
            $pdf->Cell(40, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'An Kepala Badan Pendapatan', 'LR', 1, 'C');

            $pdf->Cell(48, 2, 'WAJIB PAJAK / PENYETOR', 'LR', 0, 'C');
            $pdf->Cell(47, 2, 'PPAT / NOTARIS', 'LR', 0, 'C');
            $pdf->Cell(40, 2, 'TEMPAT PEMBAYARAN', 'LR', 0, 'C');
            $pdf->Cell(55, 2, 'Daerah Kota Malang', 'LR', 1, 'C');

            $pdf->Cell(48, 5, '', 'LR', 0, 'C');
            $pdf->Cell(47, 5, '/ PEJABAT LELANG', 'LR', 0, 'C');
            $pdf->Cell(40, 5, '    Tanggal :', 'LR', 0, 'L');
            $pdf->Cell(55, 5, 'Kepala Bidang Pajak Daerah', 'LR', 1, 'C');

            $pdf->Cell(48, 20, '', 'LR', 0, 'C');
            $pdf->Cell(47, 20, '', 'LR', 0, 'C');
            $pdf->Cell(40, 20, '', 'LR', 0, 'C');
            $pdf->Cell(55, 20, '', 'LR', 1, 'C');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(48, 5, '', 'LR', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 0, 'C');
            $pdf->Cell(40, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, '', 'LR', 1, 'C');

            //2021 05 03 
            $StrNamaWP = @$data['nik']->nama . " " . @$data['sptpd']->wajibpajak;
            if (strlen($StrNamaWP) > 25) {
                $NamaWPWW = wordwrap($StrNamaWP, 25, "--");
                $NamaWP = explode("--", $NamaWPWW);
            } else {
                $NamaWP['0'] = @$data['nik']->nama . " " . @$data['sptpd']->wajibpajak;
                $NamaWP['1'] = '';
            }

            $pdf->Cell(48, 5, $NamaWP['0'], 'LR', 0, 'C');
            $pdf->Cell(47, 5, @$data['ppat']->nama, 'LR', 0, 'C');
            $pdf->Cell(40, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, '', 'LR', 1, 'C');

            //2021 05 03 
            $pdf->Cell(48, 5, $NamaWP['1'], 'LR', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 0, 'C');
            $pdf->Cell(40, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, '', 'LR', 1, 'C');

            $pdf->SetFont('Times', '', 7);
            $pdf->Cell(48, 5, 'Nama lengkap dan tanda tangan', 'LRB', 0, 'C');
            $pdf->Cell(47, 5, 'Nama lengkap, stempel dan tanda tangan', 'LRB', 0, 'C');
            $pdf->Cell(40, 5, '', 'LRB', 0, 'C');
            $pdf->Cell(55, 5, '', 'LRB', 1, 'C');

            // $pdf->SetFont('Times', '', 9);
            // $pdf->Cell(190, 5, 'Tanggal Jatuh Tempo Pembayaran : ' . changeDateFormat('webview', $jatuhtempo), 'LRB', 0, 'L');
        }

        $pdf->Output("SSPDBPHTBPDF.pdf", "I");
    }

    public function SSPDBPHTBPDF_batas($id)
    {

        $data['id']       = $id;
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);

        $a = $data['sptpd']->batas + 1;

        $batas = $this->mod_sptpd->batas($id, $a);

        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';



        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        @$data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);

        $wil_nik                     = (array) $data['nik'];
        $wil_nik                     = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);

        $data['kabid']  = $this->mod_user->get_kabid();

        $ltnt = @$data['sptpd']->tanah_inp_aphb3 * @$data['sptpd']->njop_tanah_op;
        $lbnb = @$data['sptpd']->bangunan_inp_aphb3 * @$data['sptpd']->njop_bangunan_op;

        $npopkp = @$data['sptpd']->npop - @$data['sptpd']->npoptkp;
        if ($npopkp <= 0) {
            $npopkp = 0;
        };
        $npopkp5 = 0.05 * @$npopkp;
        // echo $npopkp;exit(); 

        $tujuan = array(
            1 => 'Untuk Wajib Pajak',
            2 => 'Untuk PPAT/Notaris',
            3 => 'Untuk Kepala Kantor Bidang Pertanahan',
            4 => 'BP2D',
            5 => 'Untuk Bank',
            6 => 'Untuk Bank yang ditunjuk Bendahara',
        );


        for ($i = 1; $i < 7; $i++) {
            if ($i > 1) {
                // $this->fpdf->pdf->AddPage();
            }
            $data['nomor'] = $i;
            $data['tujuan'] = $tujuan[$i];
            // echo "<pre>";
            // print_r ($tujuan);exit();
            // echo "</pre>";

        }


        $this->load->library('fpdf_gen');
        $pdf = new fpdf('P', 'mm', array(210, 330));

        foreach ($tujuan as $key => $value) {

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 0);

            $image = base_url() . 'assets/template/assets/images/users/logo_malang.gif';
            $pdf->Image($image, 20, 10, 35, 37);
            // $pdf->Image(base_url() . 'assets/template/assets/images/users/logo_tabalong.png',20,11,30,37);

            // $pdf->Image(base_url() . 'assets/template/assets/images/users/avatar.jpg');  

            // header----------

            if ($value == 'Untuk Wajib Pajak') {
            } elseif ($value == 'Untuk PPAT/Notaris') {
                $pdf->SetFillColor(45, 255, 85);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Kepala Kantor Bidang Pertanahan') {
                $pdf->SetFillColor(0, 165, 255);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Badan Pendapatan Daerah') {
                $pdf->SetFillColor(255, 105, 180);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Bank') {
                $pdf->SetFillColor(229, 255, 0);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            } elseif ($value == 'Untuk Bank yang ditunjuk Bendahara') {
                $pdf->SetFillColor(255, 0, 0);
                $pdf->Rect(145, 10, 55, 47, 'DF');
            }

            $masabulan = date("m", strtotime($data['sptpd']->tanggal));
            $masatahun = date("Y", strtotime($data['sptpd']->tanggal));

            $pdf->SetFont('Times', 'B', 11);
            $pdf->Cell(55, 5, '', 'LTR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LTR', 0, 'C');
            $pdf->Cell(55, 5, '', 'LTR', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'No. SSPD', 'R', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, @$data['sptpd']->no_dokumen, 'R', 1, 'C');


            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, 'SURAT SETORAN PAJAK DAERAH', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'NTPD/Kode Billing', 'R', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, 'BEA PEROLEHAN HAK ATAS TANAH', 'LR', 0, 'C');
            $pdf->Cell(55, 5, @$data['sptpd']->idbilling, 'R', 1, 'C');
            /*
        $pdf->Cell(55,5,'', 'LR', 0, 'C');
        $pdf->Cell(80,5,'DAN BANGUNAN', 'LR', 0, 'C');
        $pdf->Cell(55,5,'Lembar '.$key, 'R', 1, 'C');

        $pdf->Cell(55,5,'', 'LR', 0, 'C');
        $pdf->Cell(80,5,'(SSPD-BPHTB)', 'LR', 0, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(55,5,$value, 'R', 1, 'C');
        

        $pdf->Cell(55,5,'', 'LR', 0, 'C');
        $pdf->Cell(80,5,'', 'LR', 0, 'C');
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(55,5,'', 'R', 1, 'C');

        $pdf->SetFont('Times', '', 11);
        $pdf->Cell(55,2,'BADAN PENDAPATAN', 'LR', 0, 'C');
        $pdf->Cell(80,2,'', 'LR', 0, 'C');
        $pdf->Cell(55,2,'', 'R', 1, 'C');

        $pdf->Cell(55,5,'DAERAH KOTA MALANG', 'LR', 0, 'C');
        $pdf->Cell(80,5,'', 'LR', 0, 'C');
        $pdf->Cell(55,5,'', 'R', 1, 'C');
		*/

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, 'DAN BANGUNAN', 'LR', 0, 'C');
            $pdf->Cell(55, 5, 'Masa Pajak : ' . $masabulan . ' - ' . $masatahun, 'R', 1, 'C');

            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '(SSPD-BPHTB)', 'LR', 0, 'C');
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(55, 5, 'Lembar ' . $key, 'R', 1, 'C');


            $pdf->Cell(55, 5, '', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(55, 5, '$value', 'R', 1, 'C');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(55, 2, 'BADAN PENDAPATAN', 'LR', 0, 'C');
            $pdf->Cell(80, 2, '', 'LR', 0, 'C');
            $pdf->Cell(55, 2, '', 'R', 1, 'C');

            $pdf->Cell(55, 5, 'DAERAH KOTA MALANG', 'LR', 0, 'C');
            $pdf->Cell(80, 5, '', 'LR', 0, 'C');
            $pdf->Cell(55, 5, '', 'R', 1, 'C');

            // $pdf->Cell(55,5,'KOTA TABALONG', 'LR', 0, 'C');
            // $pdf->Cell(80,5,'', 'LR', 0, 'C');
            // $pdf->Cell(55,5,'', 'R', 1, 'C');

            // batas header ------------------------------------

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(190, 5, 'BADAN PENDAPATAN DAERAH', 1, 1, 'L');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(25, 5, 'PERHATIAN :', 'LTB', 0, 'L');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(165, 5, '  ', 'BTR', 1, 'L');

            $pdf->SetFont('Times', '', 10);

            $pdf->Cell(190, 3, '', 'RL', 1, 'L');

            $pdf->Cell(10, 5, 'A.', 'L', 0, 'L');
            $pdf->Cell(40, 5, '1. Nama Wajib Pajak ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(135, 5, @$data['nik']->nama . " " . @$data['sptpd']->wajibpajak, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '2. NIK ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(135, 5, @$data['nik']->nik, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '3. Alamat Wajib Pajak ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(135, 5, @$data['nik']->alamat, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '4. Kelurahan/Desa', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nik_nm_kelurahan'], 0, 0, 'L');
            $pdf->Cell(30, 5, '5. RT/RW : ' . @$data['nik']->rtrw, 0, 0, 'L');
            $pdf->Cell(75, 5, '6. Kecamatan : ' . @$data['nik_nm_kecamatan'], 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(40, 5, '7. Kabupaten/Kota', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nik_nm_kabupaten'], 0, 0, 'L');
            $pdf->Cell(105, 5, '8. Kode Pos : ' . @$data['nik']->kodepos, 'R', 1, 'L');

            $pdf->Cell(190, 3, '', 'LBR', 1, 'L');
            $pdf->Cell(190, 3, '', 'LR', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(10, 5, 'B.', 'L', 0, 'L');
            $pdf->Cell(52, 5, '1. Nomor Wajib Pajak (NOP) PBB ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(123, 5, @$data['sptpd']->kd_propinsi . @$data['sptpd']->kd_kabupaten . @$data['sptpd']->kd_kecamatan . @$data['sptpd']->kd_kelurahan . @$data['sptpd']->kd_blok . @$data['sptpd']->no_urut . @$data['sptpd']->kd_jns_op, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(52, 5, '2. Letak tanah dan bangunan  ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(123, 5, @$data['sptpd']->nop_alamat, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(52, 5, '3. Kelurahan / Desa ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nop_nm_kelurahan'], 0, 0, 'L');
            $pdf->Cell(93, 5, '4. RT/RW : ' . @$data['nop']->rtrw_op, 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(52, 5, '5. Kecamatan ', 0, 0, 'L');
            $pdf->Cell(5, 5, ':', 0, 0, 'L');
            $pdf->Cell(30, 5, @$data['nop_nm_kecamatan'], 0, 0, 'L');
            $pdf->Cell(93, 5, '6. Kabupaten / Kota : ' . @$data['nop_nm_kabupaten'], 'R', 1, 'L');


            $pdf->Cell(190, 5, '', 'LR', 1, 'L');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, ' ', 'LT', 0, 'C');
            $pdf->Cell(40, 5, 'LUAS', 'LT', 0, 'C');
            $pdf->Cell(40, 5, 'NJOP PBB/ M2', 'LT', 0, 'C');
            $pdf->Cell(40, 3, '', 'LTR', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, 'URAIAN ', 'L', 0, 'C');
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 3, '(Diisi luas tanah dan atau', 'L', 0, 'C');
            $pdf->Cell(40, 4, '(Diisi berdasarkan SPPT PBB', 'L', 0, 'C');
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(40, 3, 'LUAS NJOP PBB/ M2', 'LR', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, ' ', 'L', 0, 'C');
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 3, 'bangunan yang haknya diperoleh)', 'L', 0, 'C');
            $pdf->Cell(40, 3, 'tahun terjadinya perolehan hak/', 'L', 0, 'C');
            $pdf->Cell(40, 3, '', 'LR', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, ' ', 'LB', 0, 'C');
            $pdf->Cell(40, 3, '', 'LB', 0, 'C');
            $pdf->SetFont('Times', '', 8);
            $pdf->Cell(40, 3, 'tahun.....)', 'LB', 0, 'C');
            $pdf->Cell(40, 3, '', 'LRB', 0, 'C');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(10, 4, '', 'L', 0, 'C');
            $pdf->Cell(45, 4, 'Tanah (bumi)', 'L', 0, 'L');
            $pdf->Cell(5, 4, '7', 'L', 0, 'C');
            $pdf->Cell(35, 4, @$data['sptpd']->luas_tanah_op . ' m2', 'L', 0, 'L');
            $pdf->Cell(5, 4, '9', 'LR', 0, 'C');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$data['sptpd']->njop_tanah_op, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(5, 4, '11', 'LR', 0, 'L');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$ltnt, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(15, 4, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LRB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(5, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(35, 3, 'angka 7 x angka 9', 'LBR', 0, 'L');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 4, '', 'L', 0, 'C');
            $pdf->Cell(45, 4, 'Bangunan', 'L', 0, 'L');
            $pdf->Cell(5, 4, '8', 'L', 0, 'C');
            $pdf->Cell(35, 4, @$data['sptpd']->luas_bangunan_op . ' m2', 'L', 0, 'L');
            $pdf->Cell(5, 4, '10', 'LR', 0, 'C');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$data['sptpd']->njop_bangunan_op, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(5, 4, '12', 'LR', 0, 'L');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$lbnb, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(15, 4, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LB', 0, 'L');
            $pdf->Cell(5, 3, '', 'LRB', 0, 'C');
            $pdf->Cell(35, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(5, 3, '', 'LBR', 0, 'L');
            $pdf->Cell(35, 3, 'angka 8 x angka 10', 'LBR', 0, 'L');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 4, '', 'L', 0, 'C');
            $pdf->Cell(45, 4, 'NJOP PBB :', 0, 0, 'L');
            $pdf->Cell(5, 4, '', 0, 0, 'C');
            $pdf->Cell(35, 4, '', 0, 0, 'L');
            $pdf->Cell(5, 4, '', 0, 0, 'C');
            $pdf->Cell(35, 4, '', 0, 0, 'L');
            $pdf->Cell(5, 4, '13', 'L', 0, 'L');
            $pdf->Cell(35, 4, 'Rp. ' . number_format(@$data['sptpd']->njop_pbb_op, 0, ',', '.'), 'LR', 0, 'L');
            $pdf->Cell(15, 4, '', 'R', 1, 'C');

            $pdf->Cell(10, 3, '', 'L', 0, 'C');
            $pdf->Cell(45, 3, '', 0, 0, 'L');
            $pdf->Cell(5, 3, '', 0, 0, 'C');
            $pdf->Cell(35, 3, '', 0, 0, 'L');
            $pdf->Cell(5, 3, '', 0, 0, 'C');
            $pdf->Cell(35, 3, '', 0, 0, 'L');
            $pdf->Cell(5, 3, '', 'LB', 0, 'L');
            $pdf->Cell(35, 3, 'angka 11 + angka 12', 'LBR', 0, 'L');
            $pdf->Cell(15, 3, '', 'R', 1, 'C');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(75, 5, '14. Harga transaksi/Nilai pasar', 0, 0, 'L');
            $pdf->Cell(50, 5, '', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Rp. ' . number_format(@$data['sptpd']->nilai_pasar, 0, ',', '.'), 1, 0, 'L');
            $pdf->Cell(15, 5, '', 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(30, 5, '15. Jenis perolehan hak atas tanah dan atau bangunan = ' . @$data['sptpd']->jenis_perolehan, 0, 0, 'L');
            $pdf->Cell(65, 5, '', 0, 0, 'L');
            $pdf->Cell(70, 5, '', 0, 0, 'L');
            $pdf->Cell(15, 5, '', 'R', 1, 'L');

            $pdf->Cell(10, 5, '', 'L', 0, 'L');
            $pdf->Cell(30, 5, '16. Nomor Sertifikat =', 0, 0, 'L');
            $pdf->Cell(65, 5, @$data['sptpd']->no_sertifikat_op, 0, 0, 'L');
            $pdf->Cell(70, 5, '', 0, 0, 'L');
            $pdf->Cell(15, 5, '', 'R', 1, 'L');

            $pdf->Cell(190, 3, '', 'LR', 1, 'L');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(50, 5, 'C. PENGHITUNGAN BPHTB', 'LTB', 0, 'L');
            $pdf->Cell(140, 5, '(hanya diisi berdasarkan penghitungan Wajib Pajak)', 'TRB', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(120, 5, '1. Nilai Perolehan Objek Pajak (NPOP) memperhatikan nilai pada B.13 dan B.14', 1, 0, 'L');
            $pdf->Cell(5, 5, '1', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$data['sptpd']->npop, 0, ',', '.'), 1, 1, 'L');

            $pdf->Cell(120, 5, '2. Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP)', 1, 0, 'L');
            $pdf->Cell(5, 5, '2', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$data['sptpd']->npoptkp, 0, ',', '.'), 1, 1, 'L');

            $pdf->Cell(90, 5, '3. Nilai Perolehan Objek Pajak Tidak Kena Pajak (NPOPTKP)', 1, 0, 'L');
            $pdf->Cell(30, 5, 'angka 1 - angka 2', 1, 0, 'L');
            $pdf->Cell(5, 5, '3', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$npopkp, 0, ',', '.'), 1, 1, 'L');

            $pdf->Cell(90, 5, '4. Bea Perolehan hak atas tanah dan bangunan yang terutang', 1, 0, 'L');
            $pdf->Cell(30, 5, '5% x angka 3', 1, 0, 'L');
            $pdf->Cell(5, 5, '4', 1, 0, 'L');
            $pdf->Cell(65, 5, 'Rp. ' . number_format(@$npopkp5, 0, ',', '.'), 1, 1, 'L');

            $pdf->SetFont('Times', '', 11);
            $pdf->Cell(50, 5, 'D. Jumlah setoran berdasarkan', 'LTB', 0, 'L');
            $pdf->Cell(140, 5, '', 'TRB', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(190, 2, '', 'LR', 1, 'L');
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'PWP') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'Penghitungan Wajib Pajak', 0, 0, 'L');
            $pdf->Cell(40, 5, '', 0, 0, 'L');
            $pdf->Cell(80, 5, '', 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'STB') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'STB', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Nomor :' . @$nomor_skb, 0, 0, 'L');
            $pdf->Cell(80, 5, 'Tanggal : ' . @$this->antclass->fix_date(@$tanggal_skb), 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'SKBKB') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'SKBKB', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Nomor :' . @$nomor_skb, 0, 0, 'L');
            $pdf->Cell(80, 5, 'Tanggal : ' . @$this->antclass->fix_date(@$tanggal_skb), 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'SKBKBT') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'SKBKBT', 0, 0, 'L');
            $pdf->Cell(40, 5, 'Nomor :' . @$nomor_skb, 0, 0, 'L');
            $pdf->Cell(80, 5, 'Tanggal : ' . @$this->antclass->fix_date(@$tanggal_skb), 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(5, 5, '', 'L', 0, 'L');
            if (@$data['sptpd']->jns_setoran == 'PDS') {
                $pdf->Cell(5, 5, '*', 0, 0, 'L');
            } else {
                $pdf->Cell(5, 5, '', 0, 0, 'L');
            }
            $pdf->Cell(60, 5, 'Perhitungan dihitung sendiri karena', 0, 0, 'L');
            $pdf->Cell(40, 5, '', 0, 0, 'L');
            $pdf->Cell(80, 5, '', 'R', 1, 'L');

            $pdf->Cell(190, 2, '', 'LRB', 1, 'L');

            $pdf->Cell(190, 3, '', 'LR', 1, 'L');

            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(80, 5, 'JUMLAH YANG DISETOR(dalam angka)', 'L', 0, 'L');
            $pdf->Cell(110, 5, '(dalam huruf)', 'R', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(80, 5, 'Rp. ' . number_format(@$data['sptpd']->jumlah_setor, 0, ',', '.'), 'L', 0, 'L');
            $pdf->Cell(110, 5, @$data['terbilang_jml_setor'], 'R', 1, 'L');

            $pdf->SetFont('Times', '', 7);
            $pdf->Cell(80, 5, 'berdasarkan pilihan C4 dan pilihan D', 'L', 0, 'L');
            $pdf->Cell(110, 5, '', 'R', 1, 'L');

            $pdf->Cell(190, 2, '', 'LRB', 1, 'L');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(48, 5, '', 'L', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 'L', 'C');
            $pdf->Cell(47, 5, '', 'LR', 'L', 'C');
            $pdf->Cell(48, 5, 'Telah diverifikasi:', 'LR', 1, 'C');

            $pdf->Cell(48, 5, '............, ' . changeDateFormat('webview', $data['sptpd']->tanggal), 'LR', 0, 'C');
            $pdf->Cell(47, 5, 'MENGETAHUI', 'LR', 0, 'C');
            $pdf->Cell(47, 5, 'DITERIMA OLEH', 'LR', 0, 'C');
            $pdf->Cell(48, 5, 'An KEPALA BADAN PENDAPATAN', 'LR', 1, 'C');

            $pdf->Cell(48, 2, 'WAJIB PAJAK / PENYETOR', 'LR', 0, 'C');
            $pdf->Cell(47, 2, 'PPAT / NOTARIS', 'LR', 0, 'C');
            $pdf->Cell(47, 2, 'TEMPAT PEMBAYARAN BPHTB', 'LR', 0, 'C');
            $pdf->Cell(48, 2, 'DAERAH KOTA MALANG', 'LR', 1, 'C');

            $pdf->Cell(48, 5, '', 'LR', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 0, 'C');
            $pdf->Cell(47, 5, 'Tanggal :', 'LR', 0, 'C');
            $pdf->Cell(48, 5, 'KEPALA BIDANG PAJAK DAERAH', 'LR', 1, 'C');

            $pdf->Cell(48, 20, '', 'LR', 0, 'C');
            $pdf->Cell(47, 20, '', 'LR', 0, 'C');
            $pdf->Cell(47, 20, '', 'LR', 0, 'C');
            $pdf->Cell(48, 20, '', 'LR', 1, 'C');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(48, 5, '', 'LR', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 0, 'C');
            $pdf->Cell(48, 5, '', 'LR', 1, 'C');
            /*


*/
            $pdf->Cell(48, 5, @$data['nik']->nama . " " . @$data['sptpd']->wajibpajak, 'LR', 0, 'C');
            $pdf->Cell(47, 5, @$data['ppat']->nama, 'LR', 0, 'C');
            $pdf->Cell(47, 5, '', 'LR', 0, 'C');
            $pdf->Cell(48, 5, '', 'LR', 1, 'C');

            $pdf->SetFont('Times', '', 7);
            $pdf->Cell(48, 5, 'Nama lengkap dan tanda tangan', 'LRB', 0, 'C');
            $pdf->Cell(47, 5, 'Nama lengkap, stempel dan tanda tangan', 'LRB', 0, 'C');
            $pdf->Cell(47, 5, 'Nama lengkap, stempel dan tanda tangan', 'LRB', 0, 'C');
            $pdf->Cell(48, 5, 'Nama lengkap, stempel dan tanda tangan', 'LRB', 1, 'C');

            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(190, 5, ' . ', 'LRB', 0, 'C');
        }

        $pdf->Output("SSPDBPHTBPDF.pdf", "I");
    }



    public function print_transaksi($id)
    {
        $params = array('c', 'F4-L');
        $this->load->library('m_pdf', $params);

        $data['id']       = $id;
        $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['c_loc']    = $this->c_loc;
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);
        $id_jp            = $data['sptpd']->jenis_perolehan_op;
        $data['jenper']   = $this->db->query("SELECT nama from tbl_jns_perolehan where kd_perolehan = $id_jp")->row();

        $id_user          = $data['sptpd']->id_ppat;
        $data['ppat1']   = $this->db->query("SELECT * from tbl_ppat where id_ppat = $id_user")->row();

        @$kec = @$data['sptpd']->kd_kecamatan;
        @$kel = @$data['sptpd']->kd_kelurahan;

        $data['hr']       = $this->db->query("SELECT b.alamat, b.harga from tbl_sptpd a
                                    join harga_refrensi b on b.kd_kec = a.kd_kecamatan and b.kd_kel = a.kd_kelurahan
                                    where a.kd_propinsi='35' and a.kd_kabupaten='73' and b.kd_kec = $kec and b.kd_kel = $kel and a.id_sptpd = $id")->result();

        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        $data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);
        $wil_nik                     = (array) $data['nik'];
        $wil_nik                     = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        $data['penelitian'] = $this->mod_sptpd->get_lampiran($data['sptpd']->no_dokumen);

        $data['kabid']  = $this->mod_user->get_kabid();
        //load mPDF library
        $this->load->library('m_pdf');

        //this the the PDF filename that user will get to download
        $pdfFilePath = date('d-m-y') . $id . 'print_transaksi.pdf';

        $html          = $this->load->view('v_print_transaksi', $data, true);

        //generate the PDF from the given html
        // echo $html;exit();

        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }

    public function terbilang_val($nilai = null)
    {
        if (isset($_POST['ajax'])) {
            $convert         = $this->antclass->terbilang($this->input->post('enValue'), 3);
            $terbilang_array = array('result' => $convert);
            echo json_encode($terbilang_array);
        } else {
            $convert = $this->antclass->terbilang($nilai, 3);
            return $convert . ' Rupiah';
        }
    }

    public function SPTPDPRINTALL()
    {
        //this the the PDF filename that user will get to download
        //load mPDF library
        $params = array('c', 'A4-L');
        $this->load->library('m_pdf', $params);
        $pdfFilePath = date('d-m-y') . 'SPTPDPRINTALLs.pdf';

        $sptpds         = $this->db->query($this->session->userdata('ses_sql_laporan_ppat'))->result();

        $data['sptpds'] = $sptpds;
        $data['ppat']   = $this->db->get_where('tbl_ppat', array('id_ppat' => @$sptpds[0]->id_ppat))->result();

        $html           = $this->load->view('v_sptpdprintallpdf_malang', $data, true);

        /*
		require('fpdf_protect.php');

		$pdf = new FPDF_Protection();
		$pdf->SetProtection(array('print'));
		$pdf->AddPage();
		$pdf->SetFont('Arial');
		$pdf->Write(10,'ASDFDFSDFSDFSDF');
		$pdf->Output();
		
		*/


        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
    }
}

/* EoF */
