<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style type="text/css">
    .wrap_paper {
        margin: 10px 25px;
        background-color: white;
        border: 1px solid #DDDDDC;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .surat {
        margin-left: 146px;
        margin-top: 20px;
        font-size: 14px;
    }

    .berfungsi {
        margin-left: 130px;
    }

    .dinas {
        margin-left: 321px;
        margin-top: 13px;
    }

    /* .status{
        margin-left:376px;
    }*/
    .gambar {
        margin-top: 10px;
        margin-left: 115px;
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
</style>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> <a href="<?php echo $c_loc; ?>">SSPD - BPHTB</a></h2>
</div>
<div class="page-content-wrap">


    <div class="row">
        <div class="col-md-6">
            <?php if ($this->uri->segment(4) == 'edit') : ?>
                <a class="btn btn-default" style="margin-left:18px;" href="<?php echo base_url() . 'index.php/sptpd'; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
            <?php endif; ?>
            <a class="btn btn-default" style="margin-left:18px;" href="javascript:void()" onclick="$('.inputform').printElement({overrideElementCSS:['<?= base_url_css() ?>custom_bphtb_stylo_print.css']});"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-6"></div>
    </div>

    <span id="ppat_data_id"></span>
    <span id="nik_data_id"></span>
    <span id="nop_data_id"></span>
    <div class="wrap_paper" style="overflow: auto;">
        <div class="inputform">
            <table>
                <tr>
                    <td rowspan="2" width="100" style="text-align: center;">
                        <img src="<?php echo base_url('assets/template/assets/images/user/') . '/' . $this->config->item('LOGO_KOTA'); ?>" class="gambar" />
                    </td>
                    <td colspan="2" style="font-weight:bold; vertical-align:middle;">
                        <center class="surat">
                            SURAT SETORAN PAJAK DAERAH<br />

                            BEA PEROLEHAN HAK ATAS TANAH DAN BANGUNAN<br />
                            (SSPD-BPHTB)
                        </center>
                    </td>
                    <td width="20px"></td>
                    <td style="vertical-align:top">
                        <span>Nomor SSPD</span> : <?php echo @$sptpd->no_dokumen; ?>
                    </td>

                </tr>
                <tr>
                    <td colspan="2" style="vertical-align:middle; font-size: 10px;">
                        <center class="berfungsi">

                            BERFUNGSI SEBAGAI SURAT PEMBERITAHUAN OBJEK PAJAK<br />
                            PAJAK BUMI DAN BANGUNAN (SPOP PBB)
                        </center>
                    </td>
                    <td colspan="2"> </td>
                </tr>
                <tr>
                    <td colspan="3" style="margin: 10px 0;">
                        <center class="dinas">
                            <p>BADAN PENDAPATAN DAERAH </p>
                        </center>
                    </td>
                    <td colspan="2"> </td>
                </tr>
            </table>
            <table class="status">

                <tr>
                    <td width="200"> STATUS </td>
                    <td width="25">: </td>
                    <td>
                        <?php
                        if (@$sptpd->is_lunas == '0') {
                            echo 'Entry';
                        } elseif (@$sptpd->is_lunas == '1') {
                            echo 'Lunas';
                        } elseif (@$sptpd->is_lunas == '2') {
                            echo 'Verifikasi';
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <table>
                <?php if (@$sptpd->id_ppat != '') : ?>
                    <tr>
                        <td width="200"> No ID PPAT </td>
                        <td width="25">: </td>
                        <td> <?php echo @$sptpd->id_ppat; ?> </td>
                    </tr>
                    <tr>
                        <td> Nama PPAT</td>
                        <td>: </td>
                        <td> <span id="nama_ppat_id"><?php echo @$ppat->nama; ?></span> </td>
                    </tr>
            </table>
        <?php endif; ?>
        <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>
        <table class="">
            <tr>
                <td width="200"> NIK </td>
                <td width="25">: </td>
                <td> <?php echo @$sptpd->nik; ?> </td>
            </tr>
            <tr>
                <td> Nama Wajib Pajak </td>
                <td>: </td>
                <td> <span id="nama_nik_id"><?php echo @$nik->nama; ?></span> </td>
            </tr>
            <tr>
                <td> Alamat Wajib Pajak </td>
                <td>: </td>
                <td> <span id="alamat_nik_id"><?php echo @$nik->alamat; ?></span> </td>
            </tr>
            <tr>
                <td> Kelurahan / Desa </td>
                <td>: </td>
                <td> <span id="kelurahan_nik_id"><?php echo @$nik->nm_kelurahan; ?></span> </td>
            </tr>
            <tr>
                <td> RT / RW </td>
                <td>: </td>
                <td> <span id="rtrw_nik_id"><?php echo @$nik->rtrw; ?></span> </td>
            </tr>
            <tr>
                <td> Kecamatan </td>
                <td>: </td>
                <td> <span id="kecamatan_nik_id"><?php echo @$nik->nm_kecamatan; ?></span> </td>
            </tr>
            <tr>
                <td> Kabupaten / Kota </td>
                <td>: </td>
                <td> <span id="kotakab_nik_id"><?php echo @$nik->nm_dati2; ?></span> </td>
            </tr>
            <tr>
                <td> Kode Pos </td>
                <td>: </td>
                <td> <span id="kodepos_nik_id"><?php echo @$nik->kodepos; ?></span> </td>
            </tr>
        </table>
        <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>
        <table class="">
            <tr>
                <td width="200"> Nomor Objek Pajak (N O P) PBB </td>
                <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td> <?= @$sptpd->kd_propinsi; ?>.<?= @$sptpd->kd_kabupaten; ?>.<?= @$sptpd->kd_kecamatan; ?>.<?= @$sptpd->kd_kelurahan; ?>.<?= @$sptpd->kd_blok; ?>.<?= @$sptpd->no_urut; ?>.<?= @$sptpd->kd_jns_op; ?> </td>
            </tr>
            <tr>
                <td> Letak Tanah dan/atau Bangunan </td>
                <td>: </td>
                <td> <span id="lokasi_nop_id"><?php echo @$nop->lokasi_op; ?></span> </td>
            </tr>
            <tr>
                <td> Kabupaten / Kota </td>
                <td>: </td>
                <td> <span id="kotakab_nop_id"><?php echo @$nop->nm_dati2; ?></span> </td>
            </tr>
            <tr>
                <td> Kecamatan </td>
                <td>: </td>
                <td> <span id="kecamatan_nop_id"><?php echo @$nop->nm_kecamatan; ?></span> </td>
            </tr>
            <tr>
                <td> Kelurahan </td>
                <td>: </td>
                <td> <span id="kelurahan_nop_id"><?php echo @$nop->nm_kelurahan; ?></span> </td>
            </tr>
            <tr>
                <td> RT / RW </td>
                <td>: </td>
                <td> <span id="rtrw_nop_id"><?php echo @$nop->rtrw_op; ?></span> </td>
            </tr>
        </table>
        <div class="listform" style="margin: 10px 0;">
            <h6 style="font-weight:bold;" class=" fsize">Perhitungan NJOP PBB :</h6>
            <br />
            <table class="table table-bordered table-hover">
                <tr class="tblhead">
                    <th align="center"> Uraian </th>
                    <th align="center"> Luas <br />(Diisi luas tanah dan atau bangunan yang haknya diperoleh)</th>
                    <th align="center" class="lebar_kolom_sedang"> NJOP PBB/m2 <br />(Diisi berdasarkan SPPT PBB tahun terjadinya perolehan hak/tahun)</th>
                    <th align="center" class="lebar_kolom_sedang"> Luas x NJOP PBB/m2 </th>
                </tr>
                <tr align="right">
                    <td> Tanah (bumi) </td>
                    <td> <span id="luas_tanah_nop_id"><?php echo @$sptpd->luas_tanah_op; ?></span> m2 </td>
                    <td> Rp. <span id="njop_tanah_nop_id"><?php echo number_format(@$sptpd->njop_tanah_op, 0, ',', '.'); ?></span> </td>
                    <td align="right"> Rp. <span id="l_njop_tanah_nop_id"><?php $ltnt = @$sptpd->luas_tanah_op * @$sptpd->njop_tanah_op;
                                                                            echo number_format(@$ltnt, 0, ',', '.'); ?></span> </td>
                </tr>
                <tr align="right">
                    <td> Bangunan </td>
                    <td> <span id="luas_bangunan_nop_id"><?php echo @$sptpd->luas_bangunan_op; ?></span> m2 </td>
                    <td> Rp. <span id="njop_bangunan_nop_id"><?php echo number_format(@$sptpd->njop_bangunan_op, 0, ',', '.'); ?></span> </td>
                    <td align="right"> Rp. <span id="l_njop_bangunan_nop_id"><?php $lbnb = @$sptpd->luas_bangunan_op * @$sptpd->njop_bangunan_op;
                                                                                echo number_format(@$lbnb, 0, ',', '.'); ?></span> </td>
                </tr>
                <tr align="center">
                    <td colspan="3" align="right"></td>
                    <td align="right">
                        Rp. <span id="njop_pbb_nop_id"><?php echo number_format(@$sptpd->njop_pbb_op, 0, ',', '.'); ?></span>
                    </td>
                </tr>
            </table>
        </div>
        <table class="">
            <tr>
                <td width="315"> Harga Transaksi / Nilai Pasar </td>
                <td width="25">: </td>
                <td> Rp. <span id="nilai_nop_id"><?php echo number_format(@$sptpd->nilai_pasar, 0, ',', '.'); ?></span> </td>
            </tr>
            <tr>
                <td> Jenis Perolehan Hak atas Tanah dan atau Bangunan </td>
                <td>: </td>
                <td> <span id="jns_perolehan_nop_id"><?php echo @$sptpd->jenis_perolehan . ' - ' . @$jenis_perolehan->nama; ?></span> </td>
            </tr>
            <tr>
                <td> Nomor Sertipikat </td>
                <td>: </td>
                <td> <span id="no_sertipikat_nop_id"><?php echo @$sptpd->no_sertifikat_op; ?></span> </td>
            </tr>
        </table>
        <div class="listform" style="margin: 10px 0;">
            <table class="table table-bordered table-hover">
                <tr class="tblhead">
                    <th colspan="2"> PENGHITUNGAN BPHTBP (Hanya diisi berdasarkan penghitungan Wajib)</th>
                    <th colspan="2" class="lebar_kolom_sedang"> Dalam Rupiah </th>
                </tr>
                <tr>
                    <td colspan="2"> Nilai Perolehan Objek Pajak (NPOP) </td>
                    <td align="right" colspan="2"> Rp. <?php echo number_format(@$sptpd->npop, 0, ',', '.'); ?> </td>
                </tr>
                <tr>
                    <td colspan="2"> Nilai Perolehan Objek Pajak Tidak Kena Pajak (NPOPTKP) </td>
                    <?php if ($cek_transaksi_prev) : ?>
                        <td align="right" colspan="2"> Rp. <?php echo number_format(@$sptpd->npoptkp, 0, ',', '.'); ?> </td>
                    <?php else : ?>
                        <td align="right" colspan="2"> Rp. 0 </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td> Nilai Perolehan Objek Pajak Kena Pajak (NPOPKP) </td>
                    <td> NPOP - NPOPTKP </td>
                    <td align="right" colspan="2">
                        Rp. <span id="npopkp_id">
                            <?php $npopkp = @$sptpd->npop - @$sptpd->npoptkp;
                            if ($npopkp <= 0) {
                                $npopkp = 0;
                            }
                            echo number_format(@$npopkp, 0, ',', '.'); ?>
                        </span> *
                    </td>
                </tr>
                <tr>
                    <td> Bea Perolehan Hak Atas Tanah dan Bangunan Yang Terutang </td>
                    <td> 5% x NPOPKP </td>
                    <td align="right" colspan="2">
                        Rp. <span id="bea_perolehan_id">
                            <?php $npopkp5 = 0.05 * @$npopkp;
                            echo number_format(@$npopkp5, 0, ',', '.'); ?>
                        </span> *
                    </td>
                </tr>
                <tr>
                    <td> Pengenaan 50% karena waris / Hibah wasiat / pemberian hak pengelolaan *) </td>
                    <td style="font-size: 10px;"> 50% x dari Bea Perolehan </td>
                    <td align="right" colspan="2">
                        Rp. <span id="pengenaan50_id">
                            <?php
                            $pengenaan50 = 0;
                            if ($sptpd->jenis_perolehan == '04' or $sptpd->jenis_perolehan == '05') {
                                $pengenaan50 = 0.5 * @$npopkp5;
                                if ($pengenaan50 <= 0) {
                                    $pengenaan50 = 0;
                                }
                            }
                            echo number_format(@$pengenaan50, 0, ',', '.');
                            ?>
                        </span> *
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Bea Perolehan Hak atas Tanah dan Bangunan yang dibayar </td>
                    <td align="right" colspan="2">
                        Rp. <span id="bea_bayar_id">
                            <?php $bea_bayar = 0;
                            if ($pengenaan50 <= 0) {
                                $bea_bayar = $npopkp5;
                            } else {
                                $bea_bayar = $pengenaan50;
                            }
                            echo number_format(@$bea_bayar, 0, ',', '.'); ?>
                        </span> *
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>

        <div style="margin: 10px 0;">
            <h6 style="font-weight:bold;" class="fsize">Jumlah Setoran Berdasarkan :</h6>
            <table class="">
                <tr>
                    <td class="lebar_kolom_besar">
                        <label for="pwp_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="pwp_id" value="PWP" <?php if (@$sptpd->jns_setoran == 'PWP') {
                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                }
                                                                                                                                                ?> checked="checked" /> Penghitungan Wajib Pajak</label>
                    </td>
                    <td class="lebar_kolom_besar"> </td>
                </tr>
                <tr>
                    <td class="lebar_kolom_besar"> <label for="stb_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="stb_id" value="STB" <?php if (@$sptpd->jns_setoran == 'STB') {
                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                            }
                                                                                                                                                                            ?> /> STB</label> </td>
                    <td class="">
                        <div style="float: left; " class="lebar_kolom_kecil">Nomor : <?php echo @$nomor_skb; ?></div>
                        <div style="float: left; " class="lebar_kolom_kecil">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skb); ?></div>
                        <div style="clear: both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="lebar_kolom_besar"> <label for="skbkb_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="skbkb_id" value="SKBKB" <?php if (@$sptpd->jns_setoran == 'SKBKB') {
                                                                                                                                                                                    echo 'checked="checked"';
                                                                                                                                                                                }
                                                                                                                                                                                ?> /> SKBKB</label> </td>
                    <td class="">
                        <div style="float: left; " class="lebar_kolom_kecil">Nomor : <?php echo @$nomor_skbkb; ?></div>
                        <div style="float: left; " class="lebar_kolom_kecil">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkb); ?></div>
                        <div style="clear: both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="lebar_kolom_besar"> <label for="skbkbt_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="skbkbt_id" value="SKBKBT" <?php if (@$sptpd->jns_setoran == 'SKBKBT') {
                                                                                                                                                                                        echo 'checked="checked"';
                                                                                                                                                                                    }
                                                                                                                                                                                    ?> /> SKBKBT</label> </td>
                    <td class="lebar_kolom_besar">
                        <div style="float: left; " class="lebar_kolom_kecil">Nomor : <?php echo @$nomor_skbkbt; ?></div>
                        <div style="float: left; " class="lebar_kolom_kecil">Tanggal : <?php echo @$this->antclass->fix_date(@$tanggal_skbkbt); ?></div>
                        <div style="clear: both;"></div>
                    </td>
                </tr>
                <tr>
                    <td class="lebar_kolom_besar"> <label for="pds_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="pds_id" value="PDS" <?php if (@$sptpd->jns_setoran == 'PDS') {
                                                                                                                                                                                echo 'checked="checked"';
                                                                                                                                                                            }
                                                                                                                                                                            ?> /> Pengurangan dihitung sendiri karena </td>
                    <td> <?php echo @$sptpd->jns_setoran_hitung_sendiri; ?> </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="pcustom_id"><input disabled="disabled" type="radio" name="txt_dasar_jml_setoran_sptpd" id="pcustom_id" value="PCST" <?php if (@$sptpd->jns_setoran == 'PCST') {
                                                                                                                                                            echo 'checked="checked"';
                                                                                                                                                        }
                                                                                                                                                        ?> />
                            <?php echo @$sptpd->jns_setoran_custom; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 10px ;" class="">
            Jumlah Yang Disetor ( dengan angka ) : Rp. <?php echo @$sptpd->jumlah_setor; ?>
            <div id="div_terbilang" style="margin: 5px 0;">Dengan Huruf : <b id="terbilang"><?php echo @$terbilang_jml_setor; ?></b></div>
            <script>
                $('#jml_setor_id').keyup(function() {
                    var val = $('#jml_setor_id').val();
                    var huruf = $('#terbilang');

                    $.ajax({
                        url: '<?php echo base_url() ?>index.php/sptpd/terbilang_val',
                        data: {
                            enValue: val,
                            ajax: 1
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(data) {
                            huruf.text('');
                            if (data['result'].length > 0) {
                                $('#terbilang').append(data['result'] + ' Rupiah');
                            } else {
                                huruf.text('');
                            }
                        }
                    });

                });
            </script>
        </div>
        <div style="margin-top: 10px ; " class="">Untuk Disetorkan ke Rekening <?php echo @$rekening->nama; ?> : <?php echo @$rekening->nomor; ?></div>
        <div style="margin-top: 10px ; " class=""><b>Gambar Objek Pajak</b> : <?php if ($sptpd->gambar_op != '') { ?><div class="gambar_op"><img src="<?php echo base_url_img() . 'op/' . $sptpd->gambar_op; ?>" /></div><?php } else {
                                                                                                                                                                                                                            echo '-';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                            ?></div>
        <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>

        <div class="listform" style="margin: 10px 0;">
            <table>
                <tr>
                    <td width="100"> Nomor SSPD</td>
                    <td width="10"> : </td>
                    <td> <?php echo @$sptpd->no_dokumen; ?> </td>
                </tr>
                <tr>
                    <td width="100"> NOP PBB Baru </td>
                    <td width="10"> : </td>
                    <td> <?php echo @$sptpd->nop_pbb_baru; ?> </td>
                </tr>

                <tr>

                    <td width="100"> Kode Validasi</td>

                    <td width="10"> : </td>

                    <td> <?php echo @$sptpd->kode_validasi; ?> </td>

                </tr>
            </table>
        </div>
        <div style="margin: 10px 0; border-bottom: 3px solid #CCC;"></div>
        </div>
    </div>

</div>