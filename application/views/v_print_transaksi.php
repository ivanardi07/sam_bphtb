<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
    th,
    td {
        text-align: center;
        vertical-align: top;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/bootstrap/bootstrap.min.css" />

<body class="container">


    <!-- untuk halaman yang di print -->
    <table style="padding-left: 10px;margin-left: 10px">
        <tr>
            <td style="text-align: left">Nama</td>
            <td>:</td>
            <td style="text-align: left"><?php echo @$ppat1->nama; ?></td>
        </tr>
        <tr>
            <td style="text-align: left">Alamat</td>
            <td>:</td>
            <td style="text-align: left"><?php echo @$ppat1->alamat; ?></td>
        </tr>
        <tr>
            <td style="text-align: left">NPWP</td>
            <td>:</td>
            <td style="text-align: left"><?php echo @$ppat1->npwp; ?></td>
        </tr>
    </table>
    <br>

    <center>

        <H5>LAPORAN PENERBITAN AKTA OLEH PPAT/PPATS/NOTARIS DAN PEJABAT LELANG</H5>

    </center>

    <table class="table table-bordered table-condensed" style="width: 100%;">
        <thead>
            <tr align="center">
                <th rowspan="2">no</th>
                <th colspan="2">Akta</th>
                <th rowspan="2">Letak Tanah</th>
                <th colspan="2">Luas</th>
                <th colspan="2">Luas</th>
                <th rowspan="2">Harga Transaksi Pengalihan Hak(Rp)</th>
                <th colspan="2">Nama, Alamat dan NPWP</th>
                <th colspan="2">SSP</th>
                <th rowspan="2">Bentuk Pembuatan atau Hukum</th>
                <th rowspan="2">Jenis dan No.Hak</th>
                <th colspan="3">SSPD-BPHTB</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Tgl</th>
                <th>Tanah</th>
                <th>Bgn</th>
                <th>NOP/Th</th>
                <th>NJOP(Rp)</th>
                <th>Pihak Yang mengalihkan</th>
                <th>pihak yang menerima</th>
                <th>Tgl</th>
                <th>Rp</th>
                <th>No</th>
                <th>Tgl</th>
                <th>Rp</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><?php echo @$sptpd->no_akta; ?></td>
                <td><?php echo @$sptpd->tgl_akta; ?></td>
                <td>kel <?php echo @$nop_nm_kelurahan; ?> Kec <?php echo @$nop_nm_kecamatan; ?> <?php echo @$nop_nm_kabupaten; ?> <?php echo @$nop_nm_propinsi; ?></td>
                <td><?php echo @$sptpd->luas_tanah_op; ?></td>
                <td><?php echo @$sptpd->luas_bangunan_op; ?></td>
                <td><?= @$sptpd->kd_propinsi; ?>.<?= @$sptpd->kd_kabupaten; ?>.<?= @$sptpd->kd_kecamatan; ?>.<?= @$sptpd->kd_kelurahan; ?>.<?= @$sptpd->kd_blok; ?>.<?= @$sptpd->no_urut; ?>.<?= @$sptpd->kd_jns_op; ?></td>
                <td><?php echo number_format(@$sptpd->njop_pbb_op, 0, ',', '.'); ?></td>
                <td><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></td>

                <td><?php echo @$sptpd->pihak_mengalihkan; ?></td>

                <td><?php echo @$nik->nama; ?> <?php echo @$nik->alamat; ?> <?php echo @$nik->rtrw; ?> <?php echo @$nik_nm_kelurahan; ?> <?php echo @$nik_nm_kecamatan; ?> <?php echo @$nik_nm_kabupaten; ?></td>

                <td><?php echo tgl_format(@$sptpd->tgl); ?></td>
                <td><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></td>
                <td><?php echo @$jenper->nama; ?></td>
                <td><?php echo @$sptpd->no_sertifikat_op; ?></td>
                <td><?php echo @$sptpd->no_dokumen; ?></td>
                <td><?php echo tgl_format_jam(@$sptpd->tanggal); ?></td>
                <td><?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>
</body>