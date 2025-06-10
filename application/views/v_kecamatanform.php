<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup(string) {
        if (string == '') {
            $('#dati2_id').html('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/dati/get_dati2_bypropinsi", {
                rx_kd_propinsi: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#dati2_id').html(data);
                }
            });
        }
    }
    jQuery(function($) {
        $("#kecamatan_id").mask('999');
    });
</script>

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_dati" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Distrik</a> &raquo; <?php echo $submitvalue; ?></h3>

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
                            <label class="col-md-3 col-xs-12 control-label">Kode Propinsi</label>
                            <div class="col-md-4 col-xs-12">
                                <select class="form-control select2" name="txt_kd_propinsi" onchange="lookup($(this).val());">
                                    <option></option>
                                    <?php foreach ($propinsis as $propinsi) : ?>
                                        <option <?php if ($propinsi->kd_propinsi == @$kecamatan->kd_propinsi) {
                                                    echo 'selected="selected"';
                                                } ?> value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="help-block">Masukan Kode Provinsi</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kode Kabupaten <?= $kd_dati2 ?></label>
                            <div class="col-md-4 col-xs-12">
                                <select class="form-control select2" id="dati2_id" name="txt_kd_dati2">

                                    <?php if ($kd_dati2 == '') : ?>
                                        <option></option>
                                    <?php else : ?>
                                        <?php foreach ($dati2s as $dati2) : ?>
                                            <option <?php if ($kd_dati2 == $dati2->kd_kabupaten) {
                                                        echo 'selected="selected"';
                                                    } ?> value="<?php echo $dati2->kd_kabupaten; ?>"><?php echo $dati2->kd_kabupaten . ' - ' . $dati2->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>
                                <span class="help-block">Masukan Kode Dati2</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kode Kecamatan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input class="form-control" type="text" name="txt_kd_kecamatan" id="kecamatan_id" style="width: 50px;" maxlength="5" value="<?php echo $this->antclass->back_value(@$kd_kecamatan, 'txt_kd_kecamatan'); ?>" />
                                </div>
                                <span class="help-block">Kode Distrik</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input class="form-control" type="text" name="txt_nama_kecamatan" maxlength="50" value="<?php echo $this->antclass->back_value(@$kecamatan->nama, 'txt_nama_kecamatan'); ?>" />
                                </div>
                                <span class="help-block">Nama</span>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">

                        <input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="btn btn-primary " />
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