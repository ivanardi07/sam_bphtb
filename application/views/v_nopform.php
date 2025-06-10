<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    <?php if ($submitvalue != "Edit") : ?>
        $(window).load(function() {
            $("#nop_id").val("");
        });
    <?php endif; ?>

    function lookup_kabupaten() {
        var string = $('#propinsi_id').val();
        if (string == '') {
            $('#dati2_id').html('');
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/nop/get_kabupaten_bypropinsi",
                type: "POST",
                data: "propinsi_id=" + string,
                cache: false,
                success: function(data) {
                    $('#dati2_id').html(data);
                }
            });
        }
    }

    function lookup_kecamatan() {
        var string = $('#dati2_id').val();
        if (string == '') {
            $('#kecamatan_id').html('');
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/nop/get_kecamatan_bydati2",
                type: "POST",
                data: "dati2_id=" + string,
                cache: false,
                success: function(data) {
                    $('#kecamatan_id').html(data);
                }
            });
        }
    }

    function lookup_kelurahan() {
        var string = $('#kecamatan_id').val();
        if (string == '') {
            $('#kelurahan_id').html('');
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/nop/get_kelurahan_bykecamatan",
                type: "POST",
                data: "kecamatan_id=" + string,
                cache: false,
                success: function(data) {
                    $('#kelurahan_id').html(data);
                }
            });
        }
    }
    <?php if ($submitvalue != 'Edit') : ?>
        jQuery(function($) {
            $("#nop_id").mask(<?php echo "'" . $this->config->item('input_nop_id') . "'"; ?>);
        });

        $(document).ready(function() {
            $('#nop_id').focusout(function() {
                var nilai_nop = $('#nop_id').val();
                var count_nop_length = nilai_nop.length;
                var count_nop_length2 = nilai_nop.replace('_', '');
                if (count_nop_length2.length < <?php echo $this->config->item('length_nop_id'); ?>) {
                    $('#nop_id').text(nilai_nop);
                    $('#nop_error').text('NOP harus <?php echo $this->config->item('length_nop_id'); ?> characters!!');
                    $('#nop_error').fadeIn(300).delay(1000).fadeOut('fast');
                    //alert('ID NOP harus <?php //echo $this->config->item('length_nop_id');
                                            ?> characters!!');
                }
            });
        });
    <?php endif; ?>
</script>

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_nop" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title submitval"><a href="<?php echo $c_loc; ?>">NOP</a> &raquo; <?php echo $submitvalue; ?></h3>

                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                        <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">NOP</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input autocomplete="off" type="text" name="txt_id_nop" id="nop_id" value="<?php echo $this->antclass->back_value($this->antclass->add_nop_separator(@$rec_id), 'txt_id_nop'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                        } ?> class="form-control" />

                                </div>
                                <b id="nop_error" style="color:gray; margin:5px 0px; display:none"></b>
                                <span class="help-block">Masukan NOP</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Letak Tanah dan atau Bangunan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_lokasi_nop" id="lokasi_id" maxlength="100" value="<?php echo $this->antclass->back_value(@$nop->lokasi_op, 'txt_lokasi_nop'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukkan Letak Tanah</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Propinsi</label>
                            <div class="col-md-4 col-xs-12">
                                <select id="propinsi_id" name="txt_kd_propinsi_nop" class="form-control select2" onchange="lookup_kabupaten();">
                                    <option></option>
                                    <?php foreach ($propinsis as $propinsi) : ?>
                                        <option <?php if ($propinsi->kd_propinsi == $kd_propinsi) {
                                                    echo 'selected="selected"';
                                                } ?> value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="help-block">Masukkan Propinsi</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kabupaten / Kota</label>
                            <div class="col-md-4 col-xs-12">
                                <select id="dati2_id" name="txt_kd_dati2_nop" class="form-control select2" <?php if ($submitvalue != 'Edit') { ?> onclick="lookup_kecamatan();" <?php } ?> onchange="lookup_kecamatan();">
                                    <?php if ($kd_dati2 == '') : ?>
                                        <option></option>
                                    <?php else : ?>
                                        <?php foreach ($dati2s as $dati2) : ?>
                                            <option <?php if ($dati2->kd_kabupaten == $kd_dati2) {
                                                        echo 'selected="selected"';
                                                    } ?> value="<?php echo $dati2->kd_kabupaten; ?>"><?php echo $dati2->kd_kabupaten . ' - ' . $dati2->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="help-block">Masukkan Kabupaten / Kota</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kecamatan</label>
                            <div class="col-md-4 col-xs-12">
                                <select id="kecamatan_id" name="txt_kd_kecamatan_nop" class="form-control select2" <?php if ($submitvalue != 'Edit') { ?> onchange="lookup_kelurahan();" <?php } ?> onchange="lookup_kelurahan();">
                                    <?php if ($kd_kecamatan == '') : ?>
                                        <option></option>
                                    <?php else : ?>
                                        <?php foreach ($kecamatans as $kecamatan) : ?>
                                            <option <?php if ($kecamatan->kd_kecamatan == $kd_kecamatan) {
                                                        echo 'selected="selected"';
                                                    } ?> value="<?php echo $kecamatan->kd_kecamatan; ?>"><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="help-block">Masukkan Kecamatan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kelurahan</label>
                            <div class="col-md-4 col-xs-12">
                                <select id="kelurahan_id" name="txt_kd_kelurahan_nop" class="form-control select2">
                                    <?php if ($kd_kelurahan == '') : ?>
                                        <option></option>
                                    <?php else : ?>
                                        <?php foreach ($kelurahans as $kelurahan) : ?>
                                            <option <?php if ($kelurahan->kd_kelurahan == $kd_kelurahan) {
                                                        echo 'selected="selected"';
                                                    } ?> value="<?php echo $kelurahan->kd_kelurahan; ?>"><?php echo $kelurahan->kd_kelurahan . ' - ' . $kelurahan->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <span class="help-block">Masukkan Kelurahan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">RT / RW</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_rtrw_nop" id="rtrw_id" style="width: 100px;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nop->rtrw_op, 'txt_rtrw_nop'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan RT / RW</span>
                            </div>
                        </div>

                        <div class="listform" style="margin: 10px 0;">
                            <label>
                                <h4>Perhitungan NJOP PBB &raquo;</h4>
                            </label>
                            <table class="table">
                                <tr class="tblhead">
                                    <td align="center" width="80"> Uraian </td>
                                    <td align="center" width="180"> Luas <br />(Diisi luas tanah dan atau bangunan yang haknya diperoleh)</td>
                                    <td align="center" width="180"> NJOP PBB/m2 <br />(Diisi berdasarkan SPPT PBB tahun terjadinya perolehan hak/tahun)</td>
                                    <td align="center" width="150"> Luas x NJOP PBB/m2 </td>
                                </tr>
                                <tr align="center">
                                    <td> Tanah (bumi) </td>
                                    <td>
                                        <div class="input-group col-md-8">
                                            <input autocomplete="off" onchange="count_calc($('#luas_tanah_id').val(), $('#njop_tanah_id').val(), '*', 'l_njop_tanah')" type="text" name="txt_luas_tanah_nop" id="luas_tanah_id" style="text-align: right;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nop->luas_tanah_op, 'txt_luas_tanah_nop'); ?>" class="form-control" />
                                            <span class="input-group-addon"><span>m2</span></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group col-md-8">
                                            <span class="input-group-addon"><span>Rp.</span></span>
                                            <input autocomplete="off" onchange="count_calc($('#luas_tanah_id').val(), $('#njop_tanah_id').val(), '*', 'l_njop_tanah')" type="text" name="txt_njop_tanah_nop" id="njop_tanah_id" style="text-align: right;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->njop_tanah_op, 'txt_njop_tanah_nop'); ?>" class="form-control" />
                                            <span class="input-group-addon"><span>*</span></span>
                                        </div>
                                    </td>
                                    <td align="right">
                                        Rp. <span onchange="count_njop_pbb($('#h_l_njop_tanah').val(), $('#h_l_njop_bangunan').val(), '+', 'njop_pbb_id')" id="l_njop_tanah">
                                            <?php echo number_format(@$nop->luas_tanah_op * @$nop->njop_tanah_op, 0, ',', '.'); ?>
                                        </span>
                                        <input type="hidden" name="txt_h_njop_tanah_nop" id="h_l_njop_tanah" value="<?php echo @$nop->luas_tanah_op * @$nop->njop_tanah_op; ?>" />
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td> Bangunan </td>
                                    <td>
                                        <div class="input-group col-md-8">
                                            <input autocomplete="off" onchange="count_calc($('#luas_bangunan_id').val(), $('#njop_bangunan_id').val(), '*', 'l_njop_bangunan')" type="text" name="txt_luas_bangunan_nop" id="luas_bangunan_id" style="text-align: right;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nop->luas_bangunan_op, 'txt_luas_bangunan_nop'); ?>" class="form-control" />
                                            <span class="input-group-addon"><span>m2</span></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group col-md-8">
                                            <span class="input-group-addon"><span>Rp.</span></span>
                                            <input autocomplete="off" onchange="count_calc($('#luas_bangunan_id').val(), $('#njop_bangunan_id').val(), '*', 'l_njop_bangunan')" type="text" name="txt_njop_bangunan_nop" id="njop_bangunan_id" style="text-align: right;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->njop_bangunan_op, 'txt_njop_bangunan_nop'); ?>" class="form-control" />
                                            <span class="input-group-addon"><span>*</span></span>
                                        </div>
                                    </td>
                                    <td align="right">
                                        Rp. <span onchange="count_njop_pbb($('#h_l_njop_bangunan').val(), $('#h_l_njop_tanah').val(), '+', 'njop_pbb_id')" id="l_njop_bangunan">
                                            <?php echo number_format(@$nop->luas_bangunan_op * @$nop->njop_bangunan_op, 0, ',', '.'); ?>
                                        </span>
                                        <input type="hidden" name="txt_h_njop_bangunan_nop" id="h_l_njop_bangunan" value="<?php echo @$nop->luas_bangunan_op * @$nop->njop_bangunan_op; ?>" />
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td colspan="3" align="right"></td>
                                    <td align="right">
                                        Rp. <span id="njop_pbb_lbl_id"><?php echo number_format(@$nop->njop_pbb_op, 0, ',', '.'); ?></span>
                                        <input type="hidden" readonly="readonly" type="text" name="txt_njop_pbb_nop" id="njop_pbb_id" style="width: 120px; text-align: right;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->njop_pbb_op, 'txt_njop_pbb_nop'); ?>" class="tb" />
                                    </td>
                                </tr>
                            </table>
                            <table class="table">
                                <tr style="display: none;">
                                    <td width="315"> Harga Transaksi / Nilai Pasar &raquo; </td>
                                    <td> Rp. <input autocomplete="off" type="text" name="txt_nilai_nop" id="nilai_id" style="width: 100px;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->nilai_op, 'txt_nilai_nop'); ?>" class="tb" /> * </td>
                                </tr>
                                <tr>
                                    <td>
                                        <center><strong>Nomor Sertipikat</strong></center>
                                    </td>
                                    <td> <input autocomplete="off" type="text" name="txt_no_sertipikat_nop" id="no_sertipikat_id" style="width: 150px;" maxlength="20" value="<?php echo $this->antclass->back_value(@$nop->no_sertipikat_op, 'txt_no_sertipikat_nop'); ?>" class="form-control" /> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <center><strong>Tahun Pajak SPPT</strong></center>
                                    </td>
                                    <td> <input type="text" name="txt_thn_sppt_nop" id="thn_sppt_id" style="width: 150px;" maxlength="20" value="<?= @$nop->thn_pajak_sppt; ?>" class="form-control" /> </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />
                                    </td>
                                </tr>
                            </table>
                        </div>


                    </div>
                    <div class="panel-footer">
                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="btn btn-primary " /><?php endif; ?>
                        <input type="reset" name="reset" value="Reset" class="btn btn-default" />
                        <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />

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