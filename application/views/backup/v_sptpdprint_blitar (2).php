<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$this->load->helper('form');
$type_user = $this->session->userdata('s_username_bphtb');

$type = $this->session->userdata('s_tipe_bphtb');
$jabatan = $this->session->userdata('jabatan');
// echo $jabatan;exit();

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

<?php
$disabled = '';
?>

<style type="text/css">
    .wrap_paper {
        margin: 10px 25px;
        background-color: white;
        border: 1px solid #DDDDDC;
        padding: 1px 1px;
        border-radius: 5px;
    }

    .surat {
        font-size: 14px;
        line-height: 14px;
    }

    .berfungsi {
        margin-left: 130px;
    }

    .dinas {
        margin-left: 321px;
        margin-top: 13px;
    }

    .gambar {
        margin-top: 10px;
        width: 60px;
    }

    . {
        margin-left: 116px;
    }

    .lebar_kolom_besar {
        width: 300px;
    }

    .lebar_kolom_kecil {
        width: 150px;
    }

    .fsize {
        font-size: 12px;
    }

    @media (max-width:1100px) {
        .surat {
            margin-left: 90px;
        }

        .berfungsi {
            margin-left: -90px;
        }

        .dinas {
            margin-left: 300px;
        }

        .status {
            margin-left: 350px;
        }
    }

    .ket_luas_njop {
        font-size: 8px;
        border: 1px solid gray;
        padding: 2px;
        width: 90px;
        z-index: 2;
        margin-bottom: -5px;
    }

    table {
        margin-bottom: 0 !important;
    }

    table .noborder tbody tr td {
        border: none !important;
    }

    tr.border_btm td:not(:first-child) {
        border-bottom: 1px solid #E5E5E5;
    }

    table .tbl_perhitungan_njop tbody tr td {
        border: 1px solid #e5e5e5 !important;
    }

    table .tbl_perhitungan_njop tbody tr td p,
    table .tbl_perhitungan_njop tbody tr td p b {
        line-height: 10px;
    }

    .pad_btm_20 {
        padding-bottom: 20px;
    }

    .ket_njop {
        text-align: right;
        font-size: 10px;
        padding: 2px;
        border: 1px solid #e5e5e5;
        width: 117px;
        margin-bottom: -23px;
        position: relative;
        z-index: 2;
        top: 13px;
        right: -59px;
        margin-right: 31px;
    }

    .ket_njop_print {
        text-align: right;
        font-size: 8px;
        padding: 2px;
        border: 1px solid #e5e5e5;
        width: 117px;
        margin-bottom: -23px;
        position: relative;
        z-index: 2;
        top: 9px;
        right: -45px;
        margin-right: 31px;
    }

    .kop_surat td {
        text-align: center;
    }

    .kop_surat td:first-child p {
        font-size: 10px;
        font-weight: bold;
    }

    ..kop_surat td:nth-child(2) {
        vertical-align: middle;
    }

    .kop_surat td:nth-child(2) p {
        line-height: 10px;
        font-size: 15px;
        font-weight: bold;
    }

    .kop_surat td:nth-child(2) h1 {
        color: #000;
        font-weight: bold;
    }

    tr .tanda_tangan td p {
        line-height: 8px;
    }

    label {
        margin-bottom: 0 !important;
    }

    h4 {
        color: #000;
    }
</style>

<?php
$kd_perolehan1 = $sptpd->jenis_perolehan;

$this->db->select('*');
$this->db->from('tbl_jns_perolehan');
$this->db->where('kd_perolehan', $kd_perolehan1);
$query = $this->db->get();
$query = $this->db->query("SELECT * FROM tbl_jns_perolehan WHERE kd_perolehan = " . $kd_perolehan1);
$a = $query->result();

$b = json_decode(json_encode($a), true);
$nama = "";
foreach ($b as $nama => $value) {
    $nama = $value['nama'];
}
?>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> <a href="<?php echo $c_loc; ?>">SSPD - BPHTB</a></h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <?php

        if ($sptpd->proses == '2'  && $jabatan == '0') {
            $url = site_url('sptpd/proses_validasi_akhir/' . $id);
        } else {
            $url = site_url('sptpd/proses_validasi/' . $type);
        }
        ?>
        <form name="frm_cek_dinas" method="post" action="<?php echo site_url('sptpd/proses_validasi/' . $type) ?>">
            <input type="hidden" name="jabatan_user" value="<?= $jabatan; ?>">
            <div class="col-md-2">
                <?php if ($this->uri->segment(4) == 'edit') : ?>
                    <a class="btn btn-default" style="margin-left:18px;" href="<?php echo base_url() . 'index.php/sptpd'; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                <?php endif; ?>
                <!--  <a class="btn btn-default" style="margin-left:18px;" href="javascript:void()" onclick="$('.inputform').printElement({overrideElementCSS:['<?= base_url_css() ?>custom_bphtb_stylo_print.css});"><i class="fa fa-print"></i> Print</a> -->

                <!-- <a class="btn btn-default" style="margin-left:18px;" onclick="print_sptpd();"><i class="fa fa-print"></i> Print</a> -->
                <!-- <a class="btn btn-default" style="margin-left:18px;" href="<?= site_url('sptpd/print_wprn/' . $this->uri->segment(3)) ?>" target = "_blank"><i class="fa fa-print"></i> Print</a> -->
                <?php //if ($sptpd->proses == '2' && $sptpd->batas < '3' ) {
                if ($sptpd->proses == '2') {
                    if ($type == 'WP' || $type == 'PT') {
                ?>
                        <a class="btn btn-default" style="margin-left:18px;" href="<?= site_url('print_pdf/SSPDBPHTBPDF/' . $this->uri->segment(3)) ?>"><i class="fa fa-print"> &nbsp CETAK SSPD </i><i class="label label-info"></i></a>
                    <?php
                    } elseif ($sptpd->proses == '2' && $type == 'D') { ?>
                        <a class="btn btn-default" style="margin-left:18px;" href="<?= site_url('print_pdf/SSPDBPHTBPDF/' . $this->uri->segment(3)) ?>"><i class="fa fa-print"></i> CETAK SSPD</a>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-md-4">
                <table class="table">
                    <?php if ($type == 'D') { ?>
                        <tr>
                            <td>Verifikasi Staf</td>
                            <td>:</td>
                            <td><?php echo ($sptpd->nama_staf) ?: 'Staf Belum Verifikasi'; ?></td>
                        </tr>

                    <?php } else {
                    } ?>
                    <tr>
                        <td>Verifikasi Dispenda</td>
                        <td>:</td>
                        <td><?php echo ($sptpd->validasi_dispenda) ? 'Sudah Diverifikasi' : 'Belum Diverifikasi'; ?></td>
                    </tr>

                    <tr>
                        <td>Petugas Lapangan</td>
                        <td>:</td>
                        <td><?php echo @$sptpd->nama_petugas_lapangan ?></td>
                    </tr>

                    <?php if ($type == 'D' && $jabatan == '0') { ?>

                        <tr>
                            <td>Petugas Lapangan</td>
                            <td>:</td>
                            <td><input type="text" class="form-control" name="petugas_lapangan"></td>
                        </tr>
                    <?php } else {
                    } ?>

                    <?php if ($sptpd->alasan_reject != '') : ?>
                        <tr>
                            <td class="fields_label" align="left" valign="top">Alasan Reject</td>
                            <td align="center">:</td>
                            <td class="linebottom"><span class="text_header"><b><?php echo $sptpd->alasan_reject; ?></b></span></td>
                        </tr>
                    <?php endif ?>
                    <tr>
                        <td class="fields_label" align="left" valign="top">Verifikasi Bank</td>
                        <td align="center">:</td>
                        <td class="linebottom"><span class="text_header"><?php echo ($sptpd->validasi_bank) ? 'Sudah Diverifikasi <br><br>  ' . getNamaBank($sptpd->id_bank, 'nama') . ' <br>  ' . getNamaBank($sptpd->id_bank, 'alamat') . ' ' : 'Belum Diverifikasi'; ?></span></td>
                    </tr>
                    <?php if (($type == 'PT' || $type == 'PP') && $sptpd->tgl_validasi_dispenda == '') : ?>

                    <?php else : ?>
                        <tr>
                            <?php if ($sptpd->proses == '0') {
                                $ol = 'Tanggal Verifikasi Staf';
                            } elseif ($sptpd->proses == '1') {
                                $ol = ' Tanggal Verifikasi Kasubid';
                            } elseif ($sptpd->proses == '2') {
                                $ol = 'Tanggal Verifikasi Kabid';
                            } ?>
                            <?php if ($sptpd->proses != '-1') : ?>
                                <td class="fields_label" align="left" valign="top"> <?php echo $ol ?></td>
                                <td align="center">:</td>
                                <td class="linebottom">
                                    <input type="text" class="form-control tanggal" name="tgl_validasi_dispenda" placeholder="Tanggal Verifikasi Dispenda" value="<?= ($sptpd->tgl_validasi_dispenda == '') ? date('d-m-Y') : changeDateFormat('webview', $sptpd->tgl_validasi_dispenda) ?>" required <?= ($sptpd->tgl_validasi_dispenda != '') ? 'readonly' : ''; ?>>
                                <?php endif ?>
                                </td>
                        </tr>
                    <?php endif ?>
                    <tr>
                        <td colspan="3">
                            <?php if ($type == 'D') { ?>
                                <?php if ($sptpd->proses !== '2' && ((int)$sptpd->proses + 1) == $jabatan && $sptpd->aprove_ppat == '1') { ?>
                                    <input type="submit" <?= $disabled; ?> name="submit_approval" value="<?= ($this->session->userdata('jabatan') == '2') ? 'Setuju' : 'Verifikasi'; ?>" class="btn btn-primary" />
                                    <a class="btn btn-danger" <?= $disabled; ?> data-toggle="modal" data-target="#myModal" /> Tolak </a>
                                    <input type="hidden" name="kode_approval" value="<?php echo @$sptpd->kode_validasi; ?>">
                                    <input type="hidden" name="txt_id_sptpd" value="<?php echo $sptpd->id_sptpd; ?>" />
                                    <input type="hidden" name="cek_kode_validasi_dispenda" value="<?php echo @$sptpd->validasi_dispenda; ?>" />
                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                                    <input type="hidden" name="txt_id_nop" value="<?php echo $this->quotes->add_nop_separator($sptpd->kd_propinsi . $sptpd->kd_kabupaten . $sptpd->kd_kecamatan . $sptpd->kd_kelurahan . $sptpd->kd_blok . $sptpd->no_urut . $sptpd->kd_jns_op); ?>" />
                                    <input name="NOP" type="hidden" value="<?php echo @$form->NOP; ?>" />
                                    <br />
                                    <?php echo $this->session->flashdata('flash_msg'); ?>
                                <?php } elseif ($sptpd->proses == '2'  && $jabatan == '0' && $sptpd->is_lunas == '1') { ?>
                                    <a class="btn btn-success" href="<?= site_url('sptpd/proses_validasi_akhir/' . $this->uri->segment(3)) ?>">Validasi</a>



                                <?php } else { ?>
                                    <?php if ($sptpd->proses == '0') {
                                        $oleh = 'Status Sudah di-approve oleh Staf';
                                    } elseif ($sptpd->proses == '1') {
                                        $oleh = 'Status Sudah di-approve oleh Kasubid';
                                    } elseif ($sptpd->proses == '2' && $sptpd->is_lunas != '2') {
                                        $oleh = 'Status Sudah di-approve oleh Kabid';
                                    } elseif ($sptpd->is_lunas == '2') {
                                        $oleh = 'Status Sudah Validasi';
                                    } ?>
                                    <b><?php echo @$oleh ?>.</b>
                                <?php } ?>
                            <?php } else if ($type == 'PP') { ?>
                                <?php if ($sptpd->validasi_bank == '') : ?>
                                    <input type="submit" <?= $disabled; ?> name="submit_approval" value="Approve" class="btn btn-primary" />
                                    nput type="hidden" name="kode_approval" value="<?php echo @$sptpd->kode_validasi; ?>">
                                    <input type="hidden" name="txt_id_sptpd" value="<?php echo $sptpd->id_sptpd; ?>" />
                                    <input type="hidden" name="cek_kode_validasi_dispenda" value="<?php echo @$sptpd->validasi_dispenda; ?>" />
                                    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
                                    <input type="hidden" name="txt_id_nop" value="<?php echo $this->quotes->add_nop_separator($sptpd->kd_propinsi . $sptpd->kd_kabupaten . $sptpd->kd_kecamatan . $sptpd->kd_kelurahan . $sptpd->kd_blok . $sptpd->no_urut . $sptpd->kd_jns_op); ?>" />
                                    <input name="NOP" type="hidden" value="<?php echo @$form->NOP; ?>" />
                                    <br />
                                    <?php echo $this->session->flashdata('flash_msg'); ?>
                                <?php else : ?>
                                    <b>Status Sudah di-approve oleh DISPENDA.</b>
                                <?php endif ?>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <table class="table">
                    <?php if ($sptpd->proses == '2') { ?>
                        <tr>
                            <td width="100"> Idbilling</td>
                            <td width="10"> : </td>
                            <!-- <td> <?php echo idbilling(@$sptpd->no_dokumen); ?> </td> -->
                            <td> <?php echo @$sptpd->idbilling; ?> </td>
                        </tr>
                    <?php } else {
                    } ?>
                    <tr>
                        <td width="100"> Nomor Pelayanan</td>
                        <td width="10"> : </td>
                        <td> <?php echo @$sptpd->no_pelayanan; ?> </td>
                    </tr>
                    <tr>
                        <td width="100"> Nomor SSPD</td>
                        <td width="10"> : </td>
                        <td> <?php echo @$sptpd->no_dokumen; ?> </td>
                    </tr>
                    <tr>
                        <td width="100"> Tanggal Jatuh Tempo Pembayaran</td>
                        <td width="10"> : </td>
                        <td> <?php echo @$sptpd->tgl_exp_pembayaran; ?> </td>
                    </tr>
                    <!--                     <tr>
                         <td width="100"> NOP PBB Baru </td>
                         <td width="10"> : </td>
                        <td> <?php echo @$sptpd->nop_pbb_baru; ?> </td>
                    </tr> -->
                    <!-- 
                        <tr>

                            <td width="100"> Kode Verifikasi</td>

                            <td width="10"> : </td>

                            <td> <?php echo @$sptpd->kode_validasi; ?> </td>

                        </tr> -->
                </table>
            </div>
        </form>
    </div>
</div>
<span id="ppat_data_id"></span>
<span id="nik_data_id"></span>
<span id="nop_data_id"></span>
<div class="wrap_paper" style="overflow: auto;">
    <div class="inputform" id="form_sspd">
        <table class="table table-bordered">
            <tr>
                <td colspan="4"><b>PERHATIAN : </b>Bacalah petunjuk pengisian pada halaman belakang lembar ini terlebih dahulu</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table noborder">
                        <tr>
                            <td>A. </td>
                            <td>1. Nama Wajib Pajak</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$nik->nama . " " . @$sptpd->wajibpajak;
                                            ?>
                            </td>
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
                            <td colspan="7"><?php echo @$nik->alamat; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td width="5%"></td>
                            <td width="13%">4. Kelurahan / Desa</td>
                            <td width="2%">:</td>
                            <td width="15%"><?php echo @$nik_nm_kelurahan; ?></td>
                            <td width="5%">5. RT/RW</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$nik->rtrw; ?></td>
                            <td width="8%">6. Kecamatan</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$nik_nm_kecamatan; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>7. Kabupaten / Kota</td>
                            <td>:</td>
                            <td colspan="2"><?php echo @$nik_nm_kabupaten; ?></td>
                            <td colspan="2"></td>
                            <td>8. Kode Pos</td>
                            <td>:</td>
                            <td><?php echo @$nik->kodepos; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table noborder">
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
                            <td width="25%">3. Kelurahan / Desa</td>
                            <td width="2%">:</td>
                            <td width="30%"><?php echo @$nop_nm_kelurahan; ?></td>
                            <!--  <td width="10%"> </td>
                            <td width="5%"> </td> -->
                            <!-- <td width="10%"></td> -->
                            <td width="15%">4. RT / RW</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$sptpd->rtrw_op; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>5. Kecamatan</td>
                            <td>:</td>
                            <td><?php echo @$nop_nm_kecamatan; ?></td>
                            <td>6. Kabupaten / Kota</td>
                            <td>:</td>
                            <td><?php echo @$nop_nm_kabupaten; ?></td>
                        </tr>
                        <tr>
                            <td></td>

                            <?php if ($jabatan == '0' && $type == 'D') { ?>
                                <td>
                                    <select class="form-control" id="s_alamat">
                                        <option value="">--Pilih Alamat--</option>
                                        <?php foreach ($hr as $key => $value) { ?>
                                            <option value="" data-1="<?= 'Rp ' . rupiah($value->harga) ?>"><?= $value->alamat ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td></td>
                                <td align="right">Harga Refrensi</td>
                                <td><input type="text" name="" value="" class="form-control" id="s_alamat2" readonly></td>

                            <?php } else {
                            } ?>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Penghitungan NJOP PBB :</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="7">
                                <table class="table tbl_perhitungan_njop">
                                    <?php if ($type == 'WP') { ?>
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
                                    <?php } else { ?>

                                        <tr>
                                            <td class="text-center">
                                                <p style="margin-top:20px"><b>Uraian</b></p>
                                            </td>
                                            <td colspan="2" class="text-center">
                                                <p style="margin-top:20px"><b>Luas</b></p>
                                            </td>
                                            <td colspan="2" class="text-center">
                                                <p style="margin-top:20px"><b>NJOP PBB /m<sup>2</sup></b></p>
                                            </td>
                                            <td colspan="2" class="text-center">
                                                <p style="margin-top:20px"><b>Luas x NJOP PBB /m<sup>2</sup></b></p>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                    <tr>
                                        <td class="text-center" width="20%">Tanah (bumi)</td>
                                        <td width="2%">7</td>
                                        <td class="text-center" width="20%">
                                            <?php //echo @$sptpd->luas_tanah_op;
                                            ?>
                                            <?php echo @$sptpd->tanah_inp_aphb3; ?>
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
                                            <!-- <span class="pull-right pad_btm_20"><?php
                                                                                        $ltnt = @$sptpd->luas_tanah_op * @$sptpd->njop_tanah_op;
                                                                                        echo number_format(@$ltnt, 0, ',', '.'); ?> -->
                                            <span class="pull-right pad_btm_20"><?php $ltnt = @$sptpd->tanah_inp_aphb3 * @$sptpd->njop_tanah_op;
                                                                                echo number_format(@$ltnt, 0, ',', '.'); ?>
                                            </span>
                                            <p class="ket_njop">angka 7 x angka 9</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> Bangunan</td>
                                        <td> 8</td>
                                        <td class="text-center">
                                            <?php //echo @$sptpd->luas_bangunan_op;
                                            ?>
                                            <?php echo @$sptpd->bangunan_inp_aphb3; ?>
                                            <span class="pull-right">m<sup>2</sup></span>
                                        </td>
                                        <td> 10</td>
                                        <td>
                                            Rp.
                                            <span class="pull-right"><?php echo number_format(@$sptpd->njop_bangunan_op, 0, ',', '.'); ?></span>
                                        </td>
                                        <td> 12</td>
                                        <td>
                                            Rp.
                                            <span class="pull-right pad_btm_20"><?php $lbnb = @$sptpd->bangunan_inp_aphb3 * @$sptpd->njop_bangunan_op;
                                                                                echo number_format(@$lbnb, 0, ',', '.'); ?></span>
                                            <p class="ket_njop">angka 8 x angka 10</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="border-bottom:none !important; border-left:none !important" class="text-right">
                                            NJOP PBB :
                                        </td>
                                        <td> 13</td>
                                        <td>
                                            Rp.
                                            <span class="pull-right pad_btm_20"><?php echo number_format(@$sptpd->njop_pbb_op, 0, ',', '.'); ?></span>
                                            <p class="ket_njop">angka 11 x angka 12</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none!important" colspan="7"></td>
                                    </tr>
                                    <tr>
                                        <td style="border:none!important" colspan="3">15. Jenis perolehan hak atas tanah dan atau bangunan
                                            <span><?php echo @$sptpd->jenis_perolehan . ' - ' . $nama ?></span>
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
                <td colspan="4">
                    <span style="margin-left:10px">C. </span>
                    <span style="margin-left:30px"> PENGHITUNGAN BPHTB (hanya diisi berdasarkan penghitungan Wajib Pajak)</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <!-- <span style="margin-left:50px">1. Nilai Perolehan Objek pajak (NPOP) memperhatikan nilai pada B.13 dan B.14</span> -->
                    <div style="margin-left:50px">
                        <table class="table table-bordered">
                            <tr>
                                <td>1. NPOP</td>
                                <td>
                                    <i class="fa fa-play"></i>
                                    Rp.
                                    <span class="pull-right">Rp. <?php echo number_format(@$sptpd->npop, 0, ',', '.'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>2. NPOPTKP</td>
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
                                <td width="40%">3. NPOPKP</td>
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
                                <td>
                                    <i class="fa fa-play"></i>
                                    Rp.
                                    <span class="pull-right"><?php $npopkp5 = 0.05 * @$npopkp;
                                                                echo number_format(@$npopkp5, 0, ',', '.'); ?></span>
                                </td>
                            </tr>
                            <tr style="display: none">
                                <td>5. Bea Perolehan Hak atas Tanah dan Bangunan yang dibayar </td>
                                <td>
                                    <i class="fa fa-play"></i>
                                    Rp.
                                    <span class="pull-right"><?php
                                                                echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></span>
                                </td>
                            </tr>
                            <?php if (@$sptpd->kurang_bayar != '0') { ?>
                                <tr style="display: none">
                                    <td>5. Bea Perolehan Hak atas Tanah dan Bangunan bayar</td>
                                    <td></td>
                                    <td class="text-center">5</td>
                                    <td>
                                        <i class="fa fa-play"></i>
                                        Rp.
                                        <span class="pull-right"><?php $sudahbayar = $npopkp5 - @$sptpd->kurang_bayar;
                                                                    echo number_format($sudahbayar, 0, ',', '.'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5. Bea Perolehan Hak atas Tanah dan Bangunan kurang bayar</td>
                                    <td></td>
                                    <td class="text-center">5</td>
                                    <td>
                                        <i class="fa fa-play"></i>
                                        Rp.
                                        <span class="pull-right"><?php echo number_format(@$sptpd->kurang_bayar, 0, ',', '.'); ?></span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span style="margin-left:10px">D. </span>
                    <span style="margin-left:30px"> Jumlah setoran berdasarkan</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-left:50px">
                        <table>
                            <tr>
                                <td class="lebar_kolom_besar">
                                    <input type="checkbox" disabled="disabled" name="txt_dasar_jml_setoran_sptpd" id="pwp_id" value="PWP" checked <?php if (@$sptpd->jns_setoran == 'PWP') {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    }
                                                                                                                                                    ?> />
                                    <label for="pwp_id"> Penghitungan Wajib Pajak</label>
                                </td>
                                <td class="lebar_kolom_besar"> </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="stb_id">
                                        <input type="checkbox" disabled="disabled" name="txt_dasar_jml_setoran_sptpd" id="stb_id" value="STB" <?php if (@$sptpd->jns_setoran == 'STB') {
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                } ?> /> STB</label> </td>
                                <td class="">
                                    <div style="float: left; " class="lebar_kolom_kecil">Nomor : <?php echo @$nomor_skb; ?></div>
                                    <div style="float: left; " class="lebar_kolom_kecil">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skb); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="skbkb_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="skbkb_id" value="SKBKB" <?php if (@$sptpd->jns_setoran == 'SKBKB') {
                                                                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                                                                } ?> /> SKBKB</label> </td>
                                <td class="">
                                    <div style="float: left; " class="lebar_kolom_kecil">Nomor : <?php echo @$nomor_skbkb; ?></div>
                                    <div style="float: left; " class="lebar_kolom_kecil">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkb); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="skbkbt_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="skbkbt_id" value="SKBKBT" <?php if (@$sptpd->jns_setoran == 'SKBKBT') {
                                                                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                                                                    } ?> /> SKBKBT</label> </td>
                                <td class="lebar_kolom_besar">
                                    <div style="float: left; " class="lebar_kolom_kecil">Nomor : <?php echo @$nomor_skbkbt; ?></div>
                                    <div style="float: left; " class="lebar_kolom_kecil">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkbt); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="pds_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="pds_id" value="PDS" <?php if (@$sptpd->jns_setoran == 'PDS') {
                                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                                            } ?> /> Pengurangan dihitung sendiri karena </td>
                                <td> <?php echo @$sptpd->jns_setoran_hitung_sendiri; ?> </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-left:50px">
                        <table class="table noborder">
                            <tr>
                                <td width="30%"><b>JUMLAH YANG DISETOR (dengan angka) :</b></td>
                                <td width="10%"></td>
                                <td width="50%"><b>(dengan huruf) :</b></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #c7c7c7">
                                    <b>Rp</b>
                                    <span class=""><?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></span>
                                </td>
                                <td></td>
                                <td style="border:1px solid #c7c7c7; background-color:#e5e5e5" rowspan="2">
                                    <?php echo @$terbilang_jml_setor; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><sup>(berdasarkan perhitungan C.4 dam pilihan di D)</sup></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span style="margin-left:10px">E. </span>
                    <span style="margin-left:30px"> Lampiran</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-left:50px">
                        <table>
                            <tr>
                                <td class="lebar_kolom_besar"><label>Nama Petugas Lapangan</label></td>
                                <td>
                                    <p><?= @$sptpd->nama_petugas_lapangan ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>Gambar OP</label></td>
                                <td>
                                    <?php if ($sptpd->gambar_op != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . @$sptpd->gambar_op ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$sptpd->gambar_op ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>a. SSPD</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_sspd != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_sspd, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_sspd ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>b. Scan SPPT dan STTS/Struk ATM bukti pembayaran PBB/Bukti Pembayaran PBB</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_sppt != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_sppt, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_sppt ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>c. Scan Identitas Wajib Pajak</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_fotocopi_identitas != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_fotocopi_identitas, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_fotocopi_identitas ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>d. Surat Kuasa Dari Wajib Pajak</label></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Nama Kuasa Wp</strong>
                                    <div style="width:250px;">
                                        <input disabled type="text" class="form-control" id="nop_id" name="lampiran_nama_kuasa_wp" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_nama_kuasa_wp, 'lampiran_nama_kuasa_wp', $sptpd->no_dokumen) ?>">
                                    </div>
                                </td>
                                <td>
                                    <strong>Alamat Kuasa Wp</strong>
                                    <div style="width:250px;"><input disabled type="text" class="form-control" id="nop_id" name="lampiran_alamat_kuasa_wp" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_alamat_kuasa_wp, 'lampiran_alamat_kuasa_wp', $sptpd->no_dokumen) ?>" autocomplete="off">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>e. Scan Identitas Kuasa Wajib Pajak</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_fotocopy_identitas_kwp != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_fotocopy_identitas_kwp, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_fotocopy_identitas_kwp ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>f. Scan kartu NPWP</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_fotocopy_kartu_npwp != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_fotocopy_kartu_npwp, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_fotocopy_kartu_npwp ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>g. Scan Akta Jual Beli / Hibah / Waris</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_fotocopy_akta_jb != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_fotocopy_akta_jb, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_fotocopy_akta_jb ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>h. Scan Sertifikat / Keterangan Kepemilikan Tanah</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_sertifikat_kepemilikan_tanah != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_sertifikat_kepemilikan_tanah, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_sertifikat_kepemilikan_tanah ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>i. Scan Keterangan Waris</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_fotocopy_keterangan_waris != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_fotocopy_keterangan_waris, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_fotocopy_keterangan_waris ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>j. Scan Surat Pernyataan</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_fotocopy_surat_pernyataan != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_fotocopy_surat_pernyataan, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_fotocopy_surat_pernyataan ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>k. Scan SPOP/LSPOP</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_spoplspop != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_spoplspop, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_spoplspop ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"><label>l. Identitas lainya</label></td>
                                <td>
                                    <?php if (@$penelitian->lampiran_identitas_lainya != '') : ?>
                                        <a onclick="window.open('<?php echo $no_dokumen_file_assets . $this->antclass->fix_name_file(@$penelitian->lampiran_identitas_lainya, $sptpd->no_dokumen) ?>', 'cetak', 'status=0, title=0, height=500px, width=500px, scrollbars=1')"><?= @$penelitian->lampiran_identitas_lainya ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="tanda_tangan">
                <td class="text-center" width="25%" style="height: 200px; position: relative;">
                    <div style="line-height:10px">
                        <b>
                            <p>.................., tgl <?= changeDateFormat('webview', $sptpd->tanggal) ?></p>
                            <p>WAJIB PAJAK / PENYETOR</p>
                        </b>
                    </div>
                    <div style="bottom: 0px; position: absolute; width: 100%; margin-left: -8px; margin-bottom: 8px;">
                        <p style="margin: 0px"><b><?php echo @$nik->nama . " " . @$sptpd->wajibpajak; ?></b></p>
                        <small style="border-top:1px solid #e5e5e5">Nama lengkap dan tanda tangan</small>
                    </div>
                </td>
                <td class="text-center" width="25%" style="height: 200px; position: relative;">
                    <div style="line-height:10px">
                        <b>
                            <p>MENGETAHUI</p>
                            <p>PPAT / NOTARIS</p>
                        </b>
                    </div>
                    <div style="bottom: 0px; position: absolute; width: 100%; margin-left: -8px; margin-bottom: 8px;">
                        <p style="margin: 0px"><b><?php echo @$ppat->nama; ?></b></p>
                        <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                    </div>
                </td>
                <td class="text-center" width="25%" style="height: 200px; position: relative;">
                    <div style="line-height:10px">
                        <b>
                            <p>DITERIMA OLEH :</p>
                            <p>TEMPAT PEMBAYARAN BPHTB</p>
                            <p>Tanggal : <?= changeDateFormat('webview', @$sptpd->tgl_validasi_bank) ?></p>
                        </b>
                    </div>
                    <div style="bottom: 0px; position: absolute; width: 100%; margin-left: -8px; margin-bottom: 8px;">
                        <p style="margin: 0px"><b><?= getNamaBank($sptpd->id_bank, 'nama') ?></b></p>
                        <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                    </div>
                </td>
                <td class="text-center" width="25%" style="height: 200px; position: relative;">
                    <div style="line-height:10px">
                        <b>
                            <p>Telah diverifikasi :</p>
                            <p>An. Kepala Badan Pendapatan <br> Daerah Kota Malang<br>Kepala Bidang Pajak Daerah <?php //echo @$kabid->nama_dinas
                                                                                                                    ?></p>
                        </b>
                    </div>
                    <div style="bottom: 0px; position: absolute; width: 100%; margin-left: -8px; margin-bottom: 8px;">
                        <p style="margin: 0px"><b><?php //echo @$kabid->nama_ka;
                                                    ?> <?php //echo ($kabid->nip) ? '('.@$kabid->nip.')' : ''; 
                                                        ?></b></p>
                        <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>


<!-- untuk halaman yang di print -->
<div class="wrap_paper" style="overflow: auto; display:none;">
    <div class="inputform" id="ini_di_print">
        <table class="table table-bordered table-condensed" style="font-size:8px; ">
            <tr class="kop_surat">
                <td>
                    <img src="<?= base_url() . 'assets/template/assets/images/users/' . $this->config->item('LOGO_KOTA'); ?>" class="gambar" />
                    <p style="margin-top:5px"><?php echo $this->config->item('NAMA_DINAS'); ?></p>
                </td>
                <td colspan="2">
                    <h6 style="margin-top:20px"><b>SURAT SETORAN PAJAK DAERAH</b></h6>
                    <h6 class="heading"><b>BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN</b></h6>
                    <h4><b>(SSPD-BPHTB)</b></h4>
                </td>
                <td style="vertical-align:middle">
                    <h6><b>No. SSPD</b></h6>
                    <h6 class="no_dokumen"><b><?php echo @$sptpd->no_dokumen; ?></b></h6>
                    <h6><b>Lembar 1</b></h6>
                    <p>Untuk Wajib Pajak</p>
                </td>
            </tr>
            <tr>
                <td colspan="4"><b>BADAN PELAYANAN PAJAK DAERAH KOTA MALANG</b></td>
            </tr>
            <tr>
                <td colspan="4"><b>PERHATIAN : </b>Bacalah petunjuk pengisian pada halaman belakang lembar ini terlebih dahulu</td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table noborder table-condensed" style="font-size:8px;">
                        <tr>
                            <td>A. </td>
                            <td>1. Nama Wajib Pajak</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$nik->nama; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>2. NIK</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$nik->nik; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>3. Alamat Wajib Pajak</td>
                            <td>:</td>
                            <td colspan="7"><?php echo @$nik->alamat; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td width="5%"></td>
                            <td width="13%">4. Kelurahan / Desa</td>
                            <td width="2%">:</td>
                            <td width="15%"><?php echo @$nik_nm_kelurahan; ?></td>
                            <td width="5%">5. RT/RW</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$nik->rtrw; ?></td>
                            <td width="8%">6. Kecamatan</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$nik_nm_kecamatan; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>7. Kabupaten / Kota</td>
                            <td>:</td>
                            <td colspan="2"><?php echo @$nik_nm_kabupaten; ?></td>
                            <td colspan="2"></td>
                            <td>8. Kode Pos</td>
                            <td>:</td>
                            <td><?php echo @$nik->kodepos; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table class="table noborder table-condensed" style="font-size:8px">
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
                            <td width="25%">3. Kelurahan / Desa</td>
                            <td width="2%">:</td>
                            <td width="30%"><?php echo @$nop_nm_kelurahan; ?></td>
                            <!--  <td width="10%"> </td>
                                <td width="5%"> </td> -->
                            <!-- <td width="10%"></td> -->
                            <td width="15%">4. RT / RW</td>
                            <td width="2%">:</td>
                            <td width="10%"><?php echo @$nop->rtrw_op; ?></td>
                        </tr>
                        <tr class="border_btm">
                            <td></td>
                            <td>5. Kecamatan</td>
                            <td>:</td>
                            <td><?php echo @$nop_nm_kecamatan; ?></td>
                            <td>6. Kabupaten / Kota</td>
                            <td>:</td>
                            <td><?php echo @$nop_nm_kabupaten; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Penghitungan NJOP PBB :</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="7">
                                <table class="table tbl_perhitungan_njop table-condensed" style="font-size:8px">
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
                                        <td>Bangunan</td>
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
                <td colspan="4">
                    <span style="margin-left:10px">C. </span>
                    <span style="margin-left:30px"> PENGHITUNGAN BPHTB (hanya diisi berdasarkan penghitungan Wajib Pajak)</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <!-- <span style="margin-left:50px">1. Nilai Perolehan Objek pajak (NPOP) memperhatikan nilai pada B.13 dan B.14</span> -->
                    <div style="margin-left:50px">
                        <table class="table table-bordered table-condensed" style="font-size:8px">
                            <tr>
                                <td colspan="2">1. Nilai Perolehan Objek Pajak (NPOP) memperhatikan nilai pada B.13 dan B.14</td>
                                <td class="text-center">1</td>
                                <td>
                                    <i class="fa fa-play"></i>
                                    Rp.
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
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span style="margin-left:10px">D. </span>
                    <span style="margin-left:30px"> Jumlah setoran berdasarkan</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-left:50px">
                        <table style="font-size:8px" class="table noborder table-condensed">
                            <tr>
                                <td class="lebar_kolom_besar">
                                    <label for="pwp_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" value="PWP" <?php if (@$sptpd->jns_setoran == 'PWP') {
                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                    }
                                                                                                                                                    ?> checked="checked" /> Penghitungan Wajib Pajak</label>
                                </td>
                                <td class="lebar_kolom_besar"> </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="stb_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="stb_id" value="STB" <?php if (@$sptpd->jns_setoran == 'STB') {
                                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                                            }
                                                                                                                                                                                            ?> /> STB</label> </td>
                                <td class="">
                                    <div style="float: left; ">Nomor : <?php echo @$nomor_skb; ?></div>
                                    <div style="float: left; ">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skb); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="skbkb_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="skbkb_id" value="SKBKB" <?php if (@$sptpd->jns_setoran == 'SKBKB') {
                                                                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                                                                }
                                                                                                                                                                                                ?> /> SKBKB</label> </td>
                                <td class="">
                                    <div style="float: left; ">Nomor : <?php echo @$nomor_skbkb; ?></div>
                                    <div style="float: left; ">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkb); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="skbkbt_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="skbkbt_id" value="SKBKBT" <?php if (@$sptpd->jns_setoran == 'SKBKBT') {
                                                                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?> /> SKBKBT</label> </td>
                                <td class="lebar_kolom_besar">
                                    <div style="float: left; ">Nomor : <?php echo @$nomor_skbkbt; ?></div>
                                    <div style="float: left; ">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkbt); ?></div>
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="lebar_kolom_besar"> <label for="pds_id"><input disabled="disabled" type="checkbox" name="txt_dasar_jml_setoran_sptpd" id="pds_id" value="PDS" <?php if (@$sptpd->jns_setoran == 'PDS') {
                                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                                            }
                                                                                                                                                                                            ?> /> Pengurangan dihitung sendiri karena </td>
                                <td> <?php echo @$sptpd->jns_setoran_hitung_sendiri; ?> </td>
                            </tr>
                            <!--  <tr>
                                    <td colspan="2">
                                        <label for="pcustom_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="pcustom_id" value="PCST" <?php if (@$sptpd->jns_setoran == 'PCST') {
                                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                                        }
                                                                                                                                                                        ?> />
                                            <?php echo @$sptpd->jns_setoran_custom; ?>
                                        </label>
                                    </td>
                                </tr> -->
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-left:50px">
                        <table class="table noborder table-condensed" style="font-size:8px">
                            <tr>
                                <td width="30%"><b>JUMLAH YANG DISETOR (dengan angka) :</b></td>
                                <td width="10%"></td>
                                <td width="50%"><b>(dengan huruf) :</b></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #c7c7c7">
                                    <b>Rp</b>
                                    <span class=""><?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></span>
                                </td>
                                <td></td>
                                <td style="border:1px solid #c7c7c7; background-color:#e5e5e5" rowspan="2">
                                    <?php echo @$terbilang_jml_setor; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><sup>(berdasarkan perhitungan C.4 dam pilihan di D)</sup></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="tanda_tangan">
                <td class="text-center" width="25%">
                    <div style="line-height:0">
                        <b>
                            <p>.................., tgl <?= changeDateFormat('webview', $sptpd->tanggal) ?></p>
                            <p>WAJIB PAJAK / PENYETOR</p>
                        </b>
                    </div>
                    <p style="margin:40px 0 0 0"><b><?php echo @$nik->nama; ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap dan tanda tangan</small>
                </td>
                <td class="text-center" width="25%">
                    <div style="line-height:0">
                        <b>
                            <p>MENGETAHUI</p>
                            <p>PPAT / NOTARIS</p>
                        </b>
                    </div>
                    <p style="margin:40px 0 0 0"><b><?php echo @$ppat->nama; ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                </td>
                <td class="text-center" width="25%">
                    <div style="line-height:0">
                        <b>
                            <p>DITERIMA OLEH :</p>
                            <p>TEMPAT PEMBAYARAN BPHTB</p>
                            <p>Tanggal : <?= changeDateFormat('webview', @$sptpd->tgl_validasi_bank) ?></p>
                        </b>
                    </div>
                    <p style="margin:30px 0 0 0"><b><?= getNamaBank(@$sptpd->id_bank, 'nama') ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                </td>
                <td class="text-center" width="25%">
                    <div style="line-height:0">
                        <b>
                            <p>Telah diverifikasi :</p>
                            <p>An. Kepala Badan Pelayanan Pajak Daerah</p>
                        </b>
                    </div>
                    <p style="margin:40px 0 0 0"><b><?php echo @$dispenda->nama; ?></b></p>
                    <small style="border-top:1px solid #e5e5e5">Nama lengkap, stempel dan tanda tangan</small>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- end of halaman yang di print -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tolak Verifikasi</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form_reject">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Alasan</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="exampleInputName2" name="alasan_reject" id="alasan_reject"></textarea>
                            <input type="hidden" id="no_dokumen" name="no_dokumen" value="<?= @$sptpd->no_dokumen ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="saveReject();" class="btn btn-primary">Tolak</button>
            </div>
        </div>
    </div>
</div>



<script src="<?= base_url() . 'assets/scripts/jquery.print/jquery.print.js' ?>"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        var rule = {};
        var message = {};
        var form = '.form-add';

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy'
        });


        $('#s_alamat').on('change', function() {
            var data1 = $(this).find(':selected').attr('data-1');
            console.log(data1);
            $('#s_alamat2').val(data1);
        });

    });

    var jns_setoran = "<?= @$sptpd->jns_setoran ?>";

    if (jns_setoran == 'PWP') {
        $('#pwp_id').attr('checked', true);
    } else if (jns_setoran == 'STB') {
        $('#stb_id').attr('checked', true);
    } else if (jns_setoran == 'SKBKB') {
        $('#skbkb_id').attr('checked', true);
    } else if (jns_setoran == 'SKBKBT') {
        $('#skbkbt_id').attr('checked', true);
    } else if (jns_setoran == 'PDS') {
        $('#pds_id').attr('checked', true);
    }

    function print_sptpd() {
        $.print("#ini_di_print");
    }

    function saveReject() {
        $.ajax({
            type: 'POST',
            url: "<?= site_url('cek_nop/rejectdokumen') ?>",
            data: $('#form_reject').serialize()
        }).done(function(hasil) {
            $('#myModal').modal('hide');
            alert(hasil);
            window.location = "<?= site_url('sptpd/printform') . '/' . $sptpd->id_sptpd ?>";
        });
    }
</script>

<style>
    #ini_di_print {
        color: red;
    }
</style>