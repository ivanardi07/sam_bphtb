<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
    .wrap_paper {
        margin: 5px 10px;
        background-color: white;
        border: 1px solid black;
        padding: 5px 5px;
        border-radius: 5px;
        height: 3000px;
    }

    .gambar {
        margin-top: 10px;
        width: 500px;
    }

    .lebar_kolom_besar {
        width: 300px;
    }

    .lebar_kolom_kecil {
        width: 150px;
    }

    .kop_surat td {
        text-align: center;
    }

    .kop_surat td:first-child p {
        /*font-size: 10px;*/
        font-weight: bold;
    }

    .kop_surat td:nth-child(2) {
        vertical-align: middle;
    }

    .kop_surat td:nth-child(2) p {
        line-height: 10px;
        /*font-size: 15px;*/
        font-weight: bold;
    }

    .kop_surat td:nth-child(2) h1 {
        color: #000;
        font-weight: bold;
    }

    .kolom {
        line-height: 200px;
        padding-left: 30px;
        font-size: 30px;
    }

    table {
        margin-bottom: 0 !important;
    }

    table.table-bordered tr td {
        border: 1px solid black !important;
    }

    table .noborder tr td {
        border: none !important;
    }

    tr.border_btm td:not(:first-child) {
        border-bottom: 1px solid #E5E5E5;
    }

    table .tbl_perhitungan_njop tr td {
        border: 1px solid black !important;
    }

    table .tbl_perhitungan_njop tr td p,
    table .tbl_perhitungan_njop tr td p b {
        line-height: 10px;
    }

    table.hitung tr td {
        border-left: none;
        border-right: none;
        border-bottom: none;
    }

    tr .tanda_tangan td p {
        line-height: 8px;
    }

    label {
        margin-bottom: 0 !important;
    }

        {
        font-size: 30px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/bootstrap.min.css" />

<!-- untuk halaman yang di print -->
<div class="wrap_paper" style="overflow: auto;">
    <div class="inputform" id="ini_di_print" style="width: 100%">
        <table class="table table-bordered" style="font-size:60px;">
            <tr class="kop_surat">
                <td>
                    <img src="<?= base_url() . 'assets/template/assets/images/users/' . $this->config->item('LOGO_KOTA'); ?>" class="gambar" />
                    <p style="margin-top:5px;"><?php echo $this->config->item('NAMA_DINAS'); ?></p>
                </td>
                <td colspan="2">
                    <p style="margin-top:20px;"><b>SURAT SETORAN PAJAK DAERAH</b></p>
                    <p class="heading"><b>BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN</b></p>
                    <p><b>(SSPD-BPHTB)</b></p>
                </td>
                <td style="vertical-align:middle;">
                    <p><b>idbilling</b></p>
                    <p><?php //echo idbilling(@$sptpd->no_dokumen);
                        echo @$sptpd->idbilling; ?></p>
                    <p><b>No. SSPD</b></p>
                    <p class="no_dokumen"><b><?php echo @$sptpd->no_dokumen; ?></b></p>
                    <p><b>Lembar <?= @$nomor ?></b></p>
                    <p><?= $tujuan ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="kolom" style="font-size: 60px;">
                    <b>BADAN PENDAPATAN DAERAH</b>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="kolom" style="font-size: 60px;">
                    <b>PERHATIAN : </b>Bacalah petunjuk pengisian pada halaman belakang lembar ini terlebih dahulu
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 30px; line-height: 100px;">
                    <table class="table noborder table-condensed" style="font-size:50px;">
                        <tr>
                            <td>A. </td>
                            <td>1. Nama Wajib Pajak</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$sptpd->nama; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>2. NIK</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$sptpd->nik; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>3. Alamat Wajib Pajak</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$sptpd->alamat; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td width="5%"></td>
                            <td width="13%">4. Kelurahan / Desa</td>
                            <td width="2%">:</td>
                            <td width="15%"><?php echo @$sptpd; ?></td>
                            <td width="5%">5. RT/RW</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$sptpd->rtrw; ?></td>
                            <td width="8%">6. Kecamatan</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$sptpd->kecamatan; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>7. Kabupaten / Kota</td>
                            <td>:</td>
                            <td colspan="2"><?php echo @$sptpd->kabupaten; ?></td>
                            <td colspan="2"></td>
                            <td>8. Kode Pos</td>
                            <td>:</td>
                            <td><?php echo @$sptpd->kodepos; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 30px;">
                    <table class="table noborder table-condensed" style="font-size:50px">
                        <tr>
                            <td>B. </td>
                            <td>1. Nomor Objek Pajak (NOP) PBB</td>
                            <td>:</td>
                            <td colspan="5"> <?= @$sptpd->kd_propinsi; ?>.<?= @$sptpd->kd_kabupaten; ?>.<?= @$sptpd->kd_kecamatan; ?>.<?= @$sptpd->kd_kelurahan; ?>.<?= @$sptpd->kd_blok; ?>.<?= @$sptpd->no_urut; ?>.<?= @$sptpd->kd_jns_op; ?> </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>2. Letak tanah dan atau bangunan</td>
                            <td>:</td>
                            <td colspan="5"><?php echo @$sptpd->nop_alamat; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td width="5%"></td>
                            <td>3. Kelurahan / Desa</td>
                            <td width="2%">:</td>
                            <td width="30%"><?php echo @$sptpd->kelurahan_op; ?></td>
                            <td width="15%">4. RT / RW</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$sptpd->rtrw_op; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>5. Kecamatan</td>
                            <td>:</td>
                            <td><?php echo @$sptpd->kecamatan_op; ?></td>
                            <td>6. Kabupaten / Kota</td>
                            <td>:</td>
                            <td><?php echo @$sptpd->kotakab_op; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Penghitungan NJOP PBB :</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="7" style="padding-right: 30px;">
                                <table class="table tbl_perhitungan_njop table-condensed" style="font-size:30px;">
                                    <tr>
                                        <td class="text-center">
                                            <p style="margin-top:20px"><b>Uraian</b></p>
                                        </td>
                                        <td colspan="2" class="text-center">
                                            <p><b>Luas</b></p>
                                            <p><small>(Diisi luas tanah dan atau bangunan yang haknya diperoleh)</small></p>
                                        </td>
                                        <td colspan="2" class="text-center">
                                            <p><b>NJOP PBB /m<sup>2</sup></b></p>
                                            <p><small>(Diisi berdasarkan SPPT PBB tahun terjadinya perolehan hak / tahun ....)</small></p>
                                        </td>
                                        <td colspan="2" class="text-center">
                                            <p style="margin-top:20px"><b>Luas x NJOP PBB /m<sup>2</sup></b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Tanah (bumi)</td>
                                        <td width="2%">7</td>
                                        <td width="20%">
                                            <?php echo @$sptpd->luas_tanah_op; ?>
                                            <span class="pull-right">m<sup>2</sup></span>
                                        </td>
                                        <td width="2%">9</td>
                                        <td width="20%">
                                            Rp.
                                            <span class="pull-right pad_btm_10"><?php echo number_format(@$sptpd->njop_tanah_op, 0, ',', '.'); ?></span>
                                        </td>
                                        <td width="2%">11</td>
                                        <td width="20%">
                                            Rp.
                                            <span class="pull-right pad_btm_20"><?php
                                                                                $ltnt = @$sptpd->luas_tanah_op * @$sptpd->njop_tanah_op;
                                                                                echo number_format(@$ltnt, 0, ',', '.'); ?>
                                            </span>
                                            <p class="ket_njop_print">angka 7 x angka 9</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bangunan b</td>
                                        <td>8</td>
                                        <td>
                                            <?php echo @$sptpd->luas_bangunan_op; ?>
                                            <span class="pull-right">m<sup>2</sup></span>
                                        </td>
                                        <td>10</td>
                                        <td>
                                            Rp.
                                            <span class="pull-right"><?php echo number_format(@$sptpd->njop_bangunan_op, 0, ',', '.'); ?></span>
                                        </td>
                                        <td>12</td>
                                        <td>
                                            Rp.
                                            <span class="pull-right pad_btm_20"><?php $lbnb = @$sptpd->luas_bangunan_op * @$sptpd->njop_bangunan_op;
                                                                                echo number_format(@$lbnb, 0, ',', '.'); ?></span>
                                            <p class="ket_njop_print">angka 8 x angka 10</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="border-bottom:none !important; border-left:none !important" class="text-right">
                                            NJOP PBB :
                                        </td>
                                        <td>13</td>
                                        <td>
                                            Rp.
                                            <span class="pull-right pad_btm_20"><?php echo number_format(@$sptpd->njop_pbb_op, 0, ',', '.'); ?></span>
                                            <p class="ket_njop_print">angka 11 x angka 12</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none!important" colspan="7"></td>
                                    </tr>
                                    <tr>
                                        <td style="border:none!important" colspan="3">15. Jenis perolehan hak atas tanah dan atau bangunan
                                            <span><?php echo @$sptpd->jenis_perolehan; ?></span>
                                        </td>
                                        <td style="border:none!important" colspan="2">14. Harga transaksi / Nilai Pasar
                                        </td>
                                        <td colspan="2">
                                            Rp.
                                            <span class="pull-right"><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none!important" colspan="2">16. Nomor Sertifikat
                                        </td>
                                        <td style="border:none!important" colspan="5"><?php echo @$sptpd->no_sertifikat_op; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 30px;">
                    <span style="margin-left:10px">C. </span>
                    <span style="margin-left:30px"> PENGHITUNGAN BPHTB (hanya diisi berdasarkan penghitungan Wajib Pajak)</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table table-bordered table-condensed hitung" style="font-size:50px;">
                        <tr>
                            <td colspan="2">1. Nilai Perolehan Objek Pajak (NPOP) memperhatikan nilai pada B.13 dan B.14</td>
                            <td class="text-center">1</td>
                            <td>
                                <i class="fa fa-play"></i>
                                <span class="pull-right">Rp. <?php echo number_format(@$sptpd->npop, 0, ',', '.'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">2. Nilai Perolehan Objek Pajak Tidak Kena Pajak (NPOPTKP)</td>
                            <td class="text-center">2</td>
                            <td>
                                <i class="fa fa-play"></i>
                                Rp.

                                <?php if ($cek_transaksi_prev) : ?>
                                    <span class="pull-right"><?php echo number_format(@$sptpd->npoptkp, 0, ',', '.'); ?></span>
                                <?php else : ?>
                                    <span class="pull-right">0</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">3. Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP)</td>
                            <td width="15%">angka 1 - angka 2</td>
                            <td width="5%" class="text-center">3</td>
                            <td width="20%">
                                <i class="fa fa-play"></i>
                                Rp.
                                <span class="pull-right">
                                    <?php $npopkp = @$sptpd->npop - @$sptpd->npoptkp;
                                    if ($npopkp <= 0) {
                                        $npopkp = 0;
                                    }
                                    echo number_format(@$npopkp, 0, ',', '.'); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>4. Bea Perolehan hak atas tanah dan Bangunan yang terutang</td>
                            <td>5% x angka 3</td>
                            <td class="text-center">4</td>
                            <td>
                                <i class="fa fa-play"></i>
                                Rp.
                                <span class="pull-right"><?php $npopkp5 = 0.05 * @$npopkp;
                                                            echo number_format(@$npopkp5, 0, ',', '.'); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 30px;">
                    <span style="margin-left:10px">D. </span>
                    <span style="margin-left:30px"> Jumlah setoran berdasarkan</span>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 10px;">
                    <table style="font-size:50px" class="table noborder table-condensed">
                        <tr>
                            <td class="lebar_kolom_besar" style="padding-left: 30px;">
                                <label for="pwp_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="pwp_id" value="PWP" <?php if (@$sptpd->jns_setoran == 'PWP') {
                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                        }
                                                                                                                                                        ?> checked="checked" /> &nbsp;Penghitungan Wajib Pajak</label>
                            </td>
                            <td class="lebar_kolom_besar"> </td>
                        </tr>
                        <tr>
                            <td class="lebar_kolom_besar" style="padding-left: 30px;"> <label for="stb_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="stb_id" value="STB" <?php if (@$sptpd->jns_setoran == 'STB') {
                                                                                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?> /> &nbsp;STB</label> </td>
                            <td>
                                <div style="float: left; ">Nomor : <?php echo @$nomor_skb; ?></div>
                                <div style="float: left; ">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skb); ?></div>
                                <div style="clear: both;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="lebar_kolom_besar" style="padding-left: 30px;"> <label for="skbkb_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="skbkb_id" value="SKBKB" <?php if (@$sptpd->jns_setoran == 'SKBKB') {
                                                                                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    ?> /> &nbsp;SKBKB</label> </td>
                            <td>
                                <div style="float: left; ">Nomor : <?php echo @$nomor_skbkb; ?></div>
                                <div style="float: left; ">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkb); ?></div>
                                <div style="clear: both;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="lebar_kolom_besar" style="padding-left: 30px;"> <label for="skbkbt_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="skbkbt_id" value="SKBKBT" <?php if (@$sptpd->jns_setoran == 'SKBKBT') {
                                                                                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                        ?> /> &nbsp;SKBKBT</label> </td>
                            <td class="lebar_kolom_besar">
                                <div style="float: left; ">Nomor : <?php echo @$nomor_skbkbt; ?></div>
                                <div style="float: left; ">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkbt); ?></div>
                                <div style="clear: both;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="lebar_kolom_besar" style="padding-left: 30px;"> <label for="pds_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="pds_id" value="PDS" <?php if (@$sptpd->jns_setoran == 'PDS') {
                                                                                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                                                                                }
                                                                                                                                                                                                                ?> /> &nbsp;Pengurangan dihitung sendiri karena </td>
                            <td> <?php echo @$sptpd->jns_setoran_hitung_sendiri; ?> </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 30px; padding-right: 30px;">
                    <table class="table noborder table-condensed" style="font-size:50px">
                        <tr>
                            <td width="30%"><b>JUMLAH YANG DISETOR (dengan angka) :</b></td>
                            <td width="10%"></td>
                            <td width="50%"><b>(dengan huruf) :</b></td>
                        </tr>
                        <tr>
                            <td style="border:1px solid black">
                                <b>Rp</b>
                                <span class="pull-right"><?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></span>
                            </td>
                            <td></td>
                            <td style="border:1px solid black; background-color:#e5e5e5" rowspan="2">
                                <?php echo @$terbilang_jml_setor; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><sup>(berdasarkan perhitungan C.4 dam pilihan di D)</sup></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="tanda_tangan">
                <td class="text-center">
                    <div style="line-height:0">
                        <b>
                            <p>.................., tgl <?= changeDateFormat('webview', $sptpd->tanggal) ?></p>
                            <p>WAJIB PAJAK / PENYETOR</p>
                        </b>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <p style="margin:40px 0 0 0"><b><?php echo @$nik->nama; ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap dan tanda tangan</small>
                </td>
                <td class="text-center">
                    <div style="line-height:0">
                        <b>
                            <p>MENGETAHUI</p>
                            <p>PPAT / NOTARIS</p>
                        </b>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <p style="margin:40px 0 0 0"><b><?php echo @$ppat->nama; ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                </td>
                <td class="text-center">
                    <div style="line-height:0">
                        <b>
                            <p>DITERIMA OLEH :</p>
                            <p>TEMPAT PEMBAYARAN BPHTB</p>
                            <p>Tanggal : <?= changeDateFormat('webview', @$sptpd->tgl_validasi_bank) ?></p>
                        </b>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                    <p style="margin:40px 0 0 0"><b><?= getNamaBank(@$sptpd->id_bank, 'nama') ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                </td>
                <td class="text-center">
                    <div style="line-height:0">
                        <b>
                            <p style="font-size:60px">Telah diverifikasi :<br>An Kepala Badan Pendapatan Daerah<br>Daerah Kota Malang<br>Kepala Bidang Pajak Daerah</p>
                            <p><?php //echo @$kabid->nama_dinas
                                ?></p>
                        </b>

                        <br />
                        <br />
                    </div>
                    <p style="margin:40px 0 0 0"><b><?php //echo @$kabid->nama_ka;
                                                    ?></b></p>
                    <p><b><?php //echo @$kabid->nip
                            ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                </td>
            </tr>
        </table>
    </div>
</div>