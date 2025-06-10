<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup_sspd(string) {
        if (string == '') {
            $('#nama_ppat_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/penelitian/getSSPD<?php echo ($submitvalue == 'Edit') ? 'Edit' : '' ?>", {
                no_dokumen: "" + string + ""
            }, function(data) {
                if (data) {
                    $('#ppat_data_id').html(data);
                }
            });
        }
    }

    function kosong() {
        $("#d_nama").val('');
        $("#d_alamat").val('');
        $("#d_nik").val('');
        $("#d_kelurahan").val('');
        $("#d_kabupaten").val('');
    }

    function loadNoSSPD(v) {
        if (v != '') {
            $.post("<?php echo base_url(); ?>index.php/penelitian/getSSPD<?php echo ($submitvalue == 'Edit') ? 'Edit' : '' ?>", {
                no_dokumen: "" + v + ""
            }, function(data) {
                if (data.valid) {
                    // $("#d_nama").val(data.nama);
                    // $("#d_alamat").val(data.alamat);
                    // $("#d_nik").val(data.nik);
                    // $("#d_propinsi").val(data.propinsi);
                    // $("#d_kecamatan").val(data.kecamatan);
                    // $("#d_kelurahan").val(data.kelurahan);
                    // $("#d_kabupaten").val(data.kabupaten);
                    // $("#tglsspd").val(data.tanggal);
                } else {
                    alert(data.message);
                    // kosong();
                }
            }, "json");
        } else {
            kosong();
        }

    }
    $(function() {
        <?php if ($submitvalue != 'Edit') : ?>
            $("#datepicker").datepicker({
                format: 'yyyy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                buttonImage: '<?= base_url_img() ?>calendar.gif',
                buttonImageOnly: true
            });

            $("#datepicker2").datepicker({
                format: 'yyyy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showOn: 'button',
                buttonImage: '<?= base_url_img() ?>calendar.gif',
                buttonImageOnly: true
            });
        <?php endif; ?>
        $("#no_sspd").mask('99.99.9999.9999.999');

        $("#no_sspd").change(function() {
            var v = $(this).val();
            loadNoSSPD(v);
        });
        loadNoSSPD($("#no_sspd").val());
    });
</script>
<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });

        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });


        $("#datepicker2").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });
    });
</script>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_dati" method="post" action="<?= site_url('penelitian/penelitian_save'); ?>" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Lampiran</a> </h3>

                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                        <a class="btn btn-default" style="margin-left:18px;" href="javascript:void()" onclick="$('#print_form').css('z-index',-1).show().printElement({overrideElementCSS:['<?= base_url_css() ?>custom_bphtb_stylo_print.css']}).hide();"><i class="fa fa-print"></i> Print</a>
                        <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                    </div>
                    <div id="print_form" hidden>
                        <table>
                            <tr>
                                <td colspan="4">
                                    <center>
                                        <b>Detail Laporan</b>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>NO SSPD</td>
                                <td>
                                    <input type="text" class="form-control std float_l " <?php if ($submitvalue == 'Edit') {
                                                                                                echo 'readonly';
                                                                                            } ?> id="no_sspd" name="no_sspd" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->no_sspd, 'no_sspd'); ?>"> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>
                                </td>
                                <td>Tanggal SSPD</td>
                                <td><input id="datepicker" readonly="readonly" type="text" name="tanggal_no_sspd" style="width: 100px;" class="form-control std float_l" value="<?php if (@$this->antclass->back_valuex(@$penelitian->tanggal_no_sspd, 'tanggal_no_sspd')) {
                                                                                                                                                                                    echo @$this->antclass->back_valuex(@$penelitian->tanggal_no_sspd, 'tanggal_no_sspd');
                                                                                                                                                                                } else {
                                                                                                                                                                                }; ?>" /> </td>
                            </tr>
                            <tr>
                                <td>No Formulir</td>
                                <td>
                                    <input type="text" class="form-control std float_l " <?php if ($submitvalue == 'Edit') {
                                                                                                echo 'readonly';
                                                                                            } ?> value="<?php echo $this->antclass->back_valuex(@$penelitian->no_formulir, 'no_formulir'); ?>" maxlength="100" id="lokasi_id" name="no_formulir">
                                </td>
                                <td>Tanggal No Formulir</td>
                                <td>
                                    <input <?php if ($submitvalue == 'Edit') {
                                                echo 'readonly';
                                            }
                                            ?> type="text" name="tanggal_no_formulir" style="width: 100px;" value="<?php if (@$this->antclass->back_valuex(@$penelitian->tanggal_no_formulir, 'tanggal_no_formulir')) {
                                                                                                                        echo @$this->antclass->back_valuex(@$penelitian->tanggal_no_formulir, 'tanggal_no_formulir');
                                                                                                                    } else {
                                                                                                                        echo date('Y-m-d');
                                                                                                                    }; ?>" class="form-control std float_l" id="datepicker2" />
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Wajib Pajak</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nama'] ?>" id="d_nama" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nik'] ?>" maxlength="100" id="d_nik" name="" disabled=disabled>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Alamat Wajib Pajak</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['alamat'] ?>" id="d_alamat" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Propinsi</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_propinsi'] ?>" maxlength="100" id="d_propinsi" name="" disabled=disabled>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Kabupaten / Kota</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_kabupaten'] ?>" id="d_kabupaten" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_kecamatan'] ?>" id="d_kecamatan" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Kelurahan / Desa</td>
                                <td>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_kelurahan'] ?>" maxlength="100" id="d_kelurahan" name="" disabled=disabled>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>

                        </table>
                        <center style="margin:40px 0px;">
                            <h3>Lampiran - Lampiran</h3>
                        </center>
                        <div style="margin: 10px 0;">
                            <table class="table">
                                <tbody>
                                    <tr height="24" valign="top">
                                        <td> <label for="stb_id"><input type="checkbox" value="1" id="" name="lampiran_sspd_1" <?php echo (@$penelitian->lampiran_sspd != '') ? 'checked' : ''; ?>> SSPD </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_sspd_1_file" />
                                            <?php if (@$penelitian->lampiran_sspd != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_sspd; ?>"><?= @$penelitian->lampiran_sspd ?></a>
                                            <?php endif ?>

                                        </td>
                                    </tr>
                                    <tr height="24" valign="top">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_sspd_2" <?php echo (@$penelitian->lampiran_sppt != '') ? 'checked' : ''; ?>> Scan SPPT dan STTS/Struk ATM bukti pembayaran PBB/Bukti Pembayaran PBB </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_sspd_2_file" />
                                            <?php if (@$penelitian->lampiran_sppt != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_sppt; ?>"><?= @$penelitian->lampiran_sppt ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr height="24">
                                    <tr height="24" valign="top">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopi_identitas" <?php echo (@$penelitian->lampiran_fotocopi_identitas != '') ? 'checked' : ''; ?>> Scan Identitas Wajib Pajak </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopi_identitas_file" />
                                            <?php if (@$penelitian->lampiran_fotocopi_identitas != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopi_identitas; ?>"><?= @$penelitian->lampiran_fotocopi_identitas ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_surat_kuasa_wp" <?php echo (@$penelitian->lampiran_nama_kuasa_wp != '') ? 'checked' : ''; ?>> Surat Kuasa Dari Wajib Pajak </label> </td>
                                    </tr>
                                    <tr height="24">
                                        <td colspan=2 style="padding-left:20px"><strong>Nama Kuasa Wp</strong>
                                            <div style="width:250px;"><input type="text" class="form-control   id=" nop_id" name="lampiran_nama_kuasa_wp" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_nama_kuasa_wp, 'lampiran_nama_kuasa_wp'); ?>"></div> <strong>Alamat Kuasa Wp</strong>
                                            <div style="width:250px;"><input type="text" class="form-control   id=" nop_id" name="lampiran_alamat_kuasa_wp" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_alamat_kuasa_wp, 'lampiran_alamat_kuasa_wp'); ?>" autocomplete="off"></div>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_identitas_kwp" <?php echo (@$penelitian->lampiran_fotocopy_identitas_kwp != '') ? 'checked' : ''; ?>> Scan Identitas Kuasa Wajib Pajak </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_identitas_kwp_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_identitas_kwp != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_identitas_kwp; ?>"><?= @$penelitian->lampiran_fotocopy_identitas_kwp ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_kartu_npwp" <?php echo (@$penelitian->lampiran_fotocopy_kartu_npwp != '') ? 'checked' : ''; ?>> Scan kartu NPWP</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_kartu_npwp_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_kartu_npwp != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_kartu_npwp; ?>"><?= @$penelitian->lampiran_fotocopy_kartu_npwp ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_akta_jb" <?php echo (@$penelitian->lampiran_fotocopy_akta_jb != '') ? 'checked' : ''; ?>> Scan Akta Jual Beli / Hibah / Waris</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_akta_jb_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_akta_jb != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_akta_jb; ?>"><?= @$penelitian->lampiran_fotocopy_akta_jb ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_sertifikat_kepemilikan_tanah" <?php echo (@$penelitian->lampiran_sertifikat_kepemilikan_tanah != '') ? 'checked' : ''; ?>> Scan Sertifikat / Keterangan Kepemilikan Tanah</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_sertifikat_kepemilikan_tanah_file">
                                            <?php if (@$penelitian->lampiran_sertifikat_kepemilikan_tanah != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_sertifikat_kepemilikan_tanah; ?>"><?= @$penelitian->lampiran_sertifikat_kepemilikan_tanah ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_keterangan_waris" <?php echo (@$penelitian->lampiran_fotocopy_keterangan_waris != '') ? 'checked' : ''; ?>> Scan Keterangan Waris</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_keterangan_waris_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_keterangan_waris != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_keterangan_waris; ?>"><?= @$penelitian->lampiran_fotocopy_keterangan_waris ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24" valign=top>
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_identitas_lainya" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya, 'lampiran_identitas_lainya') == '1' ? 'checked' : ''; ?>> Identitas lainya</label> </td>
                                        <td style="">
                                            <textarea class="form-control" cols=50 rows=3 name="lampiran_identitas_lainya_val"><?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya_val, 'lampiran_identitas_lainya_val'); ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel-body">
                        <center style="margin-bottom:40px;">
                            <h3>Detail Laporan</h3>
                        </center>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l ">NO SSPD</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l " <?php if ($submitvalue == 'Edit') {
                                                                                                echo 'readonly';
                                                                                            } ?> id="no_sspd" name="no_sspd" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->no_sspd, 'no_sspd'); ?>"> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>

                                </div>
                                <span class="help-block hide_print">Masukan NO SSPD</span>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input id="datepicker" readonly="readonly" type="text" name="tanggal_no_sspd" style="width: 100px;" class="form-control std float_l" value="<?php if (@$this->antclass->back_valuex(@$penelitian->tanggal_no_sspd, 'tanggal_no_sspd')) {
                                                                                                                                                                                    echo @$this->antclass->back_valuex(@$penelitian->tanggal_no_sspd, 'tanggal_no_sspd');
                                                                                                                                                                                } else {
                                                                                                                                                                                }; ?>" />

                                </div>
                                <span class="help-block std float_l hide_print">Tanggal SSPD</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">No Formulir</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l " <?php if ($submitvalue == 'Edit') {
                                                                                                echo 'readonly';
                                                                                            } ?> value="<?php echo $this->antclass->back_valuex(@$penelitian->no_formulir, 'no_formulir'); ?>" maxlength="100" id="lokasi_id" name="no_formulir">

                                </div>
                                <span class="help-block hide_print">Masukan No Formulir</span>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input <?php if ($submitvalue == 'Edit') {
                                                echo 'readonly';
                                            } ?> type="text" name="tanggal_no_formulir" style="width: 100px;" value="<?php if (@$this->antclass->back_valuex(@$penelitian->tanggal_no_formulir, 'tanggal_no_formulir')) {
                                                                                                                            echo @$this->antclass->back_valuex(@$penelitian->tanggal_no_formulir, 'tanggal_no_formulir');
                                                                                                                        } else {
                                                                                                                            echo date('Y-m-d');
                                                                                                                        }; ?>" class="form-control std float_l" id="datepicker2" />

                                </div>
                                <span class="help-block std float_l">Tanggal No Formulir</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">Nama Wajib Pajak</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nama'] ?>" id="d_nama" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>

                                </div>
                                <span class="help-block hide_print">Masukan Nama Wajib Pajak</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">NIK</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nik'] ?>" maxlength="100" id="d_nik" name="" disabled=disabled>

                                </div>
                                <span class="help-block hide_print">Masukan NIK</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">Alamat Wajib Pajak</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['alamat'] ?>" id="d_alamat" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>

                                </div>
                                <span class="help-block hide_print">Masukan Alamat Wajib Pajak</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">Propinsi</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_propinsi'] ?>" maxlength="100" id="d_propinsi" name="" disabled=disabled>

                                </div>
                                <span class="help-block hide_print">Masukan Propinsi</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">Kabupaten / Kota</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_kabupaten'] ?>" id="d_kabupaten" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>

                                </div>
                                <span class="help-block hide_print">Masukan Kabupaten / Kota</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">Kecamatan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_kecamatan'] ?>" id="d_kecamatan" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b>

                                </div>
                                <span class="help-block hide_print">Masukan Kecamatan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label std float_l">Kelurahan / Desa</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control std float_l" value="<?= $wp['nm_kelurahan'] ?>" maxlength="100" id="d_kelurahan" name="" disabled=disabled>

                                </div>
                                <span class="help-block hide_print">Masukan Kelurahan / Desa</span>
                            </div>
                        </div>


                        <center style="margin:40px 0px;">
                            <h3>Lampiran - Lampiran</h3>
                        </center>
                        <div style="margin: 10px 0;">
                            <table class="table">
                                <tbody>
                                    <tr height="24" valign="top">
                                        <td> <label for="stb_id"><input type="checkbox" value="1" id="" name="lampiran_sspd_1" <?php echo (@$penelitian->lampiran_sspd != '') ? 'checked' : ''; ?>> SSPD </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_sspd_1_file" />
                                            <?php if (@$penelitian->lampiran_sspd != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_sspd; ?>"><?= @$penelitian->lampiran_sspd ?></a>
                                            <?php endif ?>

                                        </td>
                                    </tr>
                                    <tr height="24" valign="top">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_sspd_2" <?php echo (@$penelitian->lampiran_sppt != '') ? 'checked' : ''; ?>> Scan SPPT dan STTS/Struk ATM bukti pembayaran PBB/Bukti Pembayaran PBB </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_sspd_2_file" />
                                            <?php if (@$penelitian->lampiran_sppt != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_sppt; ?>"><?= @$penelitian->lampiran_sppt ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr height="24">
                                    <tr height="24" valign="top">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopi_identitas" <?php echo (@$penelitian->lampiran_fotocopi_identitas != '') ? 'checked' : ''; ?>> Scan Identitas Wajib Pajak </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopi_identitas_file" />
                                            <?php if (@$penelitian->lampiran_fotocopi_identitas != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopi_identitas; ?>"><?= @$penelitian->lampiran_fotocopi_identitas ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_surat_kuasa_wp" <?php echo (@$penelitian->lampiran_nama_kuasa_wp != '') ? 'checked' : ''; ?>> Surat Kuasa Dari Wajib Pajak </label> </td>
                                    </tr>
                                    <tr height="24">
                                        <td colspan=2 style="padding-left:20px"><strong>Nama Kuasa Wp</strong>
                                            <div style="width:250px;"><input type="text" class="form-control   id=" nop_id" name="lampiran_nama_kuasa_wp" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_nama_kuasa_wp, 'lampiran_nama_kuasa_wp'); ?>"></div> <strong>Alamat Kuasa Wp</strong>
                                            <div style="width:250px;"><input type="text" class="form-control   id=" nop_id" name="lampiran_alamat_kuasa_wp" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_alamat_kuasa_wp, 'lampiran_alamat_kuasa_wp'); ?>" autocomplete="off"></div>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_identitas_kwp" <?php echo (@$penelitian->lampiran_fotocopy_identitas_kwp != '') ? 'checked' : ''; ?>> Scan Identitas Kuasa Wajib Pajak </label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_identitas_kwp_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_identitas_kwp != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_identitas_kwp; ?>"><?= @$penelitian->lampiran_fotocopy_identitas_kwp ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_kartu_npwp" <?php echo (@$penelitian->lampiran_fotocopy_kartu_npwp != '') ? 'checked' : ''; ?>> Scan kartu NPWP</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_kartu_npwp_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_kartu_npwp != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_kartu_npwp; ?>"><?= @$penelitian->lampiran_fotocopy_kartu_npwp ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_akta_jb" <?php echo (@$penelitian->lampiran_fotocopy_akta_jb != '') ? 'checked' : ''; ?>> Scan Akta Jual Beli / Hibah / Waris</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_akta_jb_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_akta_jb != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_akta_jb; ?>"><?= @$penelitian->lampiran_fotocopy_akta_jb ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_sertifikat_kepemilikan_tanah" <?php echo (@$penelitian->lampiran_sertifikat_kepemilikan_tanah != '') ? 'checked' : ''; ?>> Scan Sertifikat / Keterangan Kepemilikan Tanah</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_sertifikat_kepemilikan_tanah_file">
                                            <?php if (@$penelitian->lampiran_sertifikat_kepemilikan_tanah != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_sertifikat_kepemilikan_tanah; ?>"><?= @$penelitian->lampiran_sertifikat_kepemilikan_tanah ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24">
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_keterangan_waris" <?php echo (@$penelitian->lampiran_fotocopy_keterangan_waris != '') ? 'checked' : ''; ?>> Scan Keterangan Waris</label> </td>
                                        <td style="">
                                            <input type="file" name="txt_picture_lampiran_fotocopy_keterangan_waris_file" />
                                            <?php if (@$penelitian->lampiran_fotocopy_keterangan_waris != '') : ?>
                                                <a href="<?php echo base_url() . 'assets/files/penelitian/' . @$penelitian->lampiran_fotocopy_keterangan_waris; ?>"><?= @$penelitian->lampiran_fotocopy_keterangan_waris ?></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr height="24" valign=top>
                                        <td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_identitas_lainya" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya_val, 'lampiran_identitas_lainya_val') == '1' ? 'checked' : ''; ?>> Identitas lainya</label> </td>
                                        <td style="">
                                            <textarea class="form-control" cols=50 rows=3 name="lampiran_identitas_lainya_val"><?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya_val, 'lampiran_identitas_lainya_val'); ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" name="id_pel" value="<?= @$id_pel ?>">
                    </div>
                    <div class="panel-footer">
                        <input type="submit" name="simpan" value="<?php echo $submitvalue; ?>" class="btn btn-primary " />
                        <input type="reset" name="reset" value="Reset" class="btn btn-default" />

                    </div>
                </div>
            </form>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->

<script type='text/javascript' src='<?= base_url() ?>assets/template/js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-select.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>