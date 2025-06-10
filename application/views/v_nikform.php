<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup_kecamatan(string) {
        if (string == '') {
            $('#kecamatan_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/nik/get_kecamatan_bydati2", {
                rx_kd_dati2: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#kecamatan_id').html(data);
                }
            });
        }
    }

    function lookup_kelurahan(string) {
        if (string == '') {
            $('#kelurahan_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/nik/get_kelurahan_bykecamatan", {
                rx_kd_kecamatan: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#kelurahan_id').html(data);
                }
            });
        }
    }

    function lookup_dati(string) {
        if (string == '') {
            $('#dati2_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/nik/get_dati2_bypropinsi", {
                rx_kd_propinsi: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#dati2_id').html(data);
                }
            });
        }
    }
    jQuery(function($) {
        $("#rtrw_id").mask('999/999');
    });
</script>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">NIK</a> &raquo; <?php echo $submitvalue; ?></h3>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="panel-body">
                    <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                </div>
                <br><br>
                <?php if (!empty($info)) {
                    echo $info;
                }
                ?>
                <div class="inputform">
                    <form class="form-horizontal" name="frm_nik" method="post" action="">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="nik_id" class="col-sm-4 control-label">No. KTP &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input class="form-control" type="text" name="txt_id_nik" id="nik_id" style="width: 150px;" maxlength="16" value="<?php echo $this->antclass->back_value(@$nik->nik, 'txt_id_nik'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                        ?> />
                                            </div>
                                            <span class="help-block">Masukan NIK</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="nama_id" class="col-sm-4 control-label">Nama &raquo;</label>
                                        <div class="col-sm-8">
                                            <?php if ($submitvalue != 'Edit') : ?>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                    <input class="form-control" type="text" name="txt_nama_nik" id="nama_id" style="width: 250px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$nik->nama, 'txt_nama_nik'); ?>" />
                                                </div>
                                            <?php else : ?>
                                                <?php echo @$nik->nama; ?>
                                                <input type="hidden" name="txt_nama_nik" id="nama_id" value="<?php echo @$nik->nama; ?>" />
                                            <?php endif; ?>
                                            <span class="help-block">Masukan Nama</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="alamat_id" class="col-sm-4 control-label">Alamat &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input class="form-control" type="text" name="txt_alamat_nik" id="alamat_id" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$nik->alamat, 'txt_alamat_nik'); ?>" />
                                            </div>
                                            <span class="help-block">Masukan Alamat</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="propinsi_id" class="col-sm-4 control-label">Propinsi / Kota &raquo;</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" style="width: 150px;" id="propinsi_id" name="txt_kd_propinsi_nik" onchange="lookup_dati($(this).val());">
                                                <option></option>
                                                <?php foreach ($propinsis as $propinsi) : ?>
                                                    <option <?php if ($propinsi->kd_propinsi == $kd_propinsi) {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?> value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="help-block">Pilih Propinsi / Kota</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="dati2_id" class="col-sm-4 control-label">Kabupaten / Kota &raquo;</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" style="width: 240px;" id="dati2_id" name="txt_kd_dati2_nik" onchange="lookup_kecamatan($(this).val());">
                                                <?php if ($kd_kecamatan == '') : ?>
                                                    <option></option>
                                                <?php else : ?>
                                                    <option></option>
                                                    <?php foreach ($dati2s as $dati2) : ?>
                                                        <option <?php if ($dati2->kd_dati2 == $kd_dati2) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?> value="<?php echo $dati2->kd_dati2; ?>"><?php echo $dati2->kd_dati2 . ' - ' . $dati2->nama; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <span class="help-block">Pilih Kabupaten / Kota</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="kecamatan_id" class="col-sm-4 control-label">Kode Distrik &raquo;</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" style="width: 240px;" id="kecamatan_id" name="txt_kd_kecamatan_nik" <?php if ($submitvalue != 'Edit') { ?> onchange="lookup_kelurahan($(this).val());" <?php }
                                                                                                                                                                                                                                        ?> onchange="lookup_kelurahan($(this).val());">
                                                <?php if ($kd_kecamatan == '') : ?>
                                                    <option></option>
                                                <?php else : ?>
                                                    <?php foreach ($kecamatans as $kecamatan) : ?>
                                                        <option <?php if ($kecamatan->kd_kecamatan == $kd_kecamatan) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?> value="<?php echo $kecamatan->kd_kecamatan; ?>"><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <span class="help-block">Pilih Kode Distrik</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="kelurahan_id" class="col-sm-4 control-label">Kode Kelurahan &raquo;</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" style="width: 240px;" id="kelurahan_id" name="txt_kd_kelurahan_nik">
                                                <?php if ($kd_kelurahan == '') : ?>
                                                    <option></option>
                                                <?php else : ?>
                                                    <?php foreach ($kelurahans as $kelurahan) : ?>
                                                        <option <?php if ($kelurahan->kd_kelurahan == $kd_kelurahan) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?> value="<?php echo $kelurahan->kd_kelurahan; ?>"><?php echo $kelurahan->kd_kelurahan . ' - ' . $kelurahan->nama; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <span class="help-block">Pilih Kode Kelurahan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="rtrw_id" class="col-sm-4 control-label">RT / RW &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input class="form-control" type="text" name="txt_rtrw_nik" id="rtrw_id" style="width: 100px;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nik->rtrw, 'txt_rtrw_nik'); ?>" />
                                            </div>
                                            <span class="help-block">Masukan RT / RW</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="rtrw_id" class="col-sm-4 control-label">Kode Pos &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input class="form-control" type="text" name="txt_kodepos_nik" id="kodepos_id" style="width: 100px;" maxlength="10" value="<?php echo $this->antclass->back_value(@$nik->kodepos, 'txt_kodepos_nik'); ?>" />
                                            </div>
                                            <span class="help-block">Masukan Kode Pos</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $submitvalue; ?>" />
                            <input class="btn btn-default" type="reset" name="reset" value="Reset" />
                            <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />
                        </div>
                    </form>
                </div>
                <script type='text/javascript' src='<?= base_url() ?>assets/template/js/plugins/icheck/icheck.min.js'></script>
                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-file-input.js"></script>
                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-select.js"></script>
                <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>