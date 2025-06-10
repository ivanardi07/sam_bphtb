<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$this->load->helper('form');
$type_user = $this->session->userdata('s_username_bphtb');

$type = $this->session->userdata('s_tipe_bphtb');
$jabatan = $this->session->userdata('jabatan');

if ($type == 'PT') {
    $id_user = $this->session->userdata('s_id_ppat');
} elseif ($type == 'D') {
    $id_user = $this->session->userdata('s_id_dispenda');
} elseif ($type == 'PP') {
    $id_user = $this->session->userdata('s_id_paymentpoint');
}

// echo $type.' - '.$id_user; exit;
$no_dokumen_file_assets = base_url() . 'assets/files/penelitian/' . str_replace('.', '', $sptpd->no_dokumen) . '/';
?>

<style>
    th,
    td {
        text-align: center;
        vertical-align: top;
    }
</style>

<?php if ($type == 'PT') { ?>

    <form action="<?= base_url() . 'index.php/sptpd/action_update/' . $sptpd->id_sptpd ?>" style="padding-left: 10px;margin-left: 20px" method="post" id="usrform">

        <table>
            <tr>
                <td></td>
                <td></td>
                <td><label>SSP</label></td>
            </tr>
            <tr>
                <td>

                    <table>
                        <tr>
                            <td style="text-align: left"><label>No Akta</label></td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left"><input type="text" name="no_akta"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left"><label>Tanggal Akta</label></td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left"><input type="text" class="tgl" name="tgl_akta"></td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp &nbsp &nbsp</td>
                <td>
                    <table>
                        <tr>
                            <td style="text-align: left"><label>Tanggal</label></td>
                            <td style="text-align: left">:</td>
                            <td style="text-align: left"><input type="text" class="tgl" name="tgl"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <br>
        <label>Pihak Mengalihkan</label><br>
        <textarea rows="4" cols="50" name="pihak_mengalihkan" form="usrform"></textarea><br>
        <div class="panel-footer">
            <input type="submit" name="submit" value="Submit" class="btn btn-primary " />
            <br>
            <br>
    </form>

    <body class="container">

        <div class="row">

            <center>
                <a class="btn btn-default" style="margin-left:18px;" href="<?= site_url('print_pdf/print_transaksi/' . $this->uri->segment(3)) ?>" target="_blank"><i class="fa fa-print"></i> Print</a>
            </center>
            <br>

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

            <table border="1" cellpadding="2" cellspacing="5">
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
                        <td>kel <?php echo @$nop_nm_kelurahan; ?> <br> Kec <?php echo @$nop_nm_kecamatan; ?> <br> <?php echo @$nop_nm_kabupaten; ?> <br> <?php echo @$nop_nm_propinsi; ?></td>
                        <td><?php echo @$sptpd->luas_tanah_op; ?></td>
                        <td><?php echo @$sptpd->luas_bangunan_op; ?></td>
                        <td><?= @$sptpd->kd_propinsi; ?>.<?= @$sptpd->kd_kabupaten; ?><br>.<?= @$sptpd->kd_kecamatan; ?><br>.<?= @$sptpd->kd_kelurahan; ?><br>.<?= @$sptpd->kd_blok; ?><br>.<?= @$sptpd->no_urut; ?><br>.<?= @$sptpd->kd_jns_op; ?></td>
                        <td><?php echo number_format(@$sptpd->njop_pbb_op, 0, ',', '.'); ?></td>
                        <td><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></td>

                        <td><?php echo @$sptpd->pihak_mengalihkan; ?></td>

                        <td><?php echo @$nik->nama; ?> <br> <?php echo @$nik->alamat; ?> <br> <?php echo @$nik->rtrw; ?> <br> <?php echo @$nik_nm_kelurahan; ?> <br> <?php echo @$nik_nm_kecamatan; ?> <br> <?php echo @$nik_nm_kabupaten; ?></td>

                        <td><?php echo @$sptpd->tgl; ?></td>
                        <td><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></td>
                        <td><?php echo @$jenper->nama; ?></td>
                        <td><?php echo @$sptpd->no_sertifikat_op; ?></td>
                        <td><?php echo @$sptpd->no_dokumen; ?></td>
                        <td><?php echo tgl_format_jam(@$sptpd->tanggal); ?></td>
                        <td><?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>

<?php } elseif ($type == 'D') { ?>


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

    <table class="tabel" border="2" cellpadding="2" cellspacing="2" style="padding: 5px;margin: 5px;">
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
                <td>kel <?php echo @$nop_nm_kelurahan; ?> <br> Kec <?php echo @$nop_nm_kecamatan; ?> <br> <?php echo @$nop_nm_kabupaten; ?> <br> <?php echo @$nop_nm_propinsi; ?></td>
                <td><?php echo @$sptpd->luas_tanah_op; ?></td>
                <td><?php echo @$sptpd->luas_bangunan_op; ?></td>
                <td><?= @$sptpd->kd_propinsi; ?>.<?= @$sptpd->kd_kabupaten; ?><br>.<?= @$sptpd->kd_kecamatan; ?><br>.<?= @$sptpd->kd_kelurahan; ?><br>.<?= @$sptpd->kd_blok; ?><br>.<?= @$sptpd->no_urut; ?><br>.<?= @$sptpd->kd_jns_op; ?></td>
                <td><?php echo number_format(@$sptpd->njop_pbb_op, 0, ',', '.'); ?></td>
                <td><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></td>

                <td><?php echo @$sptpd->pihak_mengalihkan; ?></td>

                <td><?php echo @$nik->nama; ?> <br> <?php echo @$nik->alamat; ?> <br> <?php echo @$nik->rtrw; ?> <br> <?php echo @$nik_nm_kelurahan; ?> <br> <?php echo @$nik_nm_kecamatan; ?> <br> <?php echo @$nik_nm_kabupaten; ?></td>

                <td><?php echo @$sptpd->tgl; ?></td>
                <td><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></td>
                <td><?php echo @$jenper->nama; ?></td>
                <td><?php echo @$sptpd->no_sertifikat_op; ?></td>
                <td><?php echo @$sptpd->no_dokumen; ?></td>
                <td><?php echo tgl_format_jam(@$sptpd->tanggal); ?></td>
                <td><?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></td>
            </tr>
        </tbody>
    </table>

<?php } ?>


<script type="text/javascript">
    jQuery(document).ready(function() {
        var rule = {};
        var message = {};
        var form = '.form-add';

        $('.tgl').datepicker({
            format: 'yyyy-mm-dd'
        });

    });
</script>