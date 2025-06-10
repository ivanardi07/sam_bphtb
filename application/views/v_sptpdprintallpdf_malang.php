<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
    th {
        text-align: center;
        padding: 5px;
    }

    td {
        padding: 5px;
    }

    .center {
        text-align: center;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/bootstrap/bootstrap.min.css" />

<!-- untuk halaman yang di print -->
<div class="wrap_paper" style="overflow: auto;">
    <div class="inputform" id="ini_di_print">
        <table class="table table-condensed" style="font-size:8px;width: 100%;">
            <tr>
                <td width="650">
                    <div style="margin-left:50px">
                        <table style="font-size:8px" class="table noborder table-condensed">
                            <tr>
                                <td width="100"> Nama</td>
                                <td width="10"> : </td>
                                <td> <?= @$ppat[0]->nama ?> </td>
                            </tr>
                            <tr>
                                <td width="100"> Alamat </td>
                                <td width="10"> : </td>
                                <td> <?= @$ppat[0]->alamat ?> </td>
                            </tr>
                            <tr>
                                <td width="100"> SNPWP </td>
                                <td width="10"> : </td>
                                <td> <?= @$ppat[0]->id_ppat ?> </td>
                            </tr>
                            <tr>
                                <td width="100"> Daerah Kerja </td>
                                <td width="10"> : </td>
                                <td> Semua Kecamatan di Kotamadya Malang </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <table class='head1'>
                        <tr>
                            <td colspan="3">
                                <p>
                                    Lampiran Keputusan Bersama Menteri A blablabla/Kepala Badan<br />
                                    Pertanahan Nasional dan Direktur Jendral Pajak<br />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="30"> Nomor </td>
                            <td width="10"> : </td>
                            <td> <u>2 TAHUN 1998</u> </td>
                        </tr>
                        <tr>
                            <td width="30"> SKB </td>
                            <td width="10"> : </td>
                            <td> KEP-179/PJ/1998 </td>
                        </tr>
                        <tr>
                            <td width="30"> Tanggal </td>
                            <td width="10"> : </td>
                            <td> 27 Agustus 1998 </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    <br />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <p>
                                    Kepada Yth:<br />
                                    1.Kepala Kantor Pertanahan Kota Malang<br />
                                    2.Kepala Kantor Pelayanan Pajak Pratama Malang Selatan<br />
                                    3.Kepala Kantor Pelayanan Pajak Pratama Malang Utara<br />
                                    4.Kepala Kantor Wilayah BPN Propinsi Jawa Timur<br />
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="text-align: center;font-size:10px;">
            LAPORAN BULANAN PEMBUATAN AKTA OLEH PPAT
            <br />
            <br />
        </div>
        <table class="table table-bordered table-condensed" style="font-size:8px;width: 100%;">
            <tr>
                <th width="10" rowspan="2">No UR UT</th>
                <th colspan="2">AKTA</th>
                <th rowspan="2">BENTUK PERBUATAN HUKUM</th>
                <th colspan="2">NAMA, ALAMAT, DAN NPWP</th>
                <th rowspan="2">JENIS DAN NOMOR HAK</th>
                <th rowspan="2">LETAK TANAH DAN BANGUNAN</th>
                <th colspan="2">LUAS(M2)</th>
                <th rowspan="2">HARGA TRANSAKSI PEROLEHAN PENGALIHAN HAK(Rp .000)</th>
                <th colspan="2">SPPT PBB</th>
                <th colspan="2">SSP</th>
                <th colspan="2">SSPD BPHTB</th>
                <th rowspan="2">KET</th>
            </tr>
            <tr>
                <th width="10">No</th>
                <th>TGL</th>
                <th>PIHAK YANG MENGALIHKAN / MEMBERIKAN</th>
                <th>PIHAK YANG MENERIMA</th>
                <th>TNH M2</th>
                <th>BNG M2</th>
                <th>NOP / Tahun</th>
                <th>NJOP (Rp .000)</th>
                <th>TGL</th>
                <th>RP .(000)</th>
                <th>TGL</th>
                <th>RP .(000)</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
                <th>13</th>
                <th>14</th>
                <th>15</th>
                <th>16</th>
                <th>17</th>
                <th>18</th>
            </tr>

            <?php $no = 1;
            foreach ($sptpds as $key => $value) : ?>
                <tr>
                    <td class="center" valign="top"><?= $no++ ?></td>
                    <td class="center" valign="top">04</td>
                    <td class="center" valign="top">21-03-2016</td>
                    <td class="center" valign="top">APHT</td>
                    <td class="" valign="top">
                        <p>
                            1 a.<?= $value->nama_penjual ?>
                            <br />
                            QQ.PT BANK PANIN Tbk<br />
                            QQ. Haji ANTON HARDIANTO. SE
                        </p>
                    </td>
                    <td class="" valign="top">
                        <p>
                            1.a. <?= $value->nama_pembeli ?><br />
                            QQ.PT BANK PANIN.Tbk
                        </p>
                    </td>
                    <td class="center" valign="top">HM 324/ Kel Barang</td>
                    <td class="center" valign="top"><?= $value->lokasi_op ?></td>
                    <td class="center" valign="top"><?= $value->luas_tanah_op ?></td>
                    <td class="center" valign="top"><?= $value->luas_bangunan_op ?></td>
                    <td class="center" valign="top"><?= $value->nilai_pasar ?></td>
                    <td class="center" valign="top">-</td>
                    <td class="center" valign="top">-</td>
                    <td class="center" valign="top">-</td>
                    <td class="center" valign="top">-</td>
                    <td class="center" valign="top"><?= tanggalIndo($value->tanggal) ?></td>
                    <td class="center" valign="top"><?= rupiah($value->jumlah_setor) ?></td>
                    <td class="center" valign="top">-</td>
                </tr>
            <?php endforeach ?>

        </table>
    </div>
    <div class="center" style="margin-left: 600px;font-size:8px;">
        Malang, <?= tanggal_indonesia(date('Y-m-d')) ?><br />
        Pejabat Pembuat Akta Tanah
    </div>
    <div class="center" style="margin-left: 600px;font-size:8px;height: 50px;">

    </div>
    <div class="center" style="margin-left: 600px;font-size:8px;">
        <?= @$ppat[0]->nama ?>
    </div>
</div>