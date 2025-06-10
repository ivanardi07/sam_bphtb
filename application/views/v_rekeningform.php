<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_rekening" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Rekening</a> &raquo; <?php echo $submitvalue; ?></h3>

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
                            <label class="col-md-3 col-xs-12 control-label">Nama Bank</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-bank"></span></span>
                                    <input class="form-control" type="text" name="txt_nama_rekening" id="rekening_id" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(@$rekening->nama, 'txt_nama_rekening'); ?>" />

                                </div>
                                <span class="help-block">Masukan Nama Bank</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Rekening</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-credit-card"></span></span>
                                    <input class="form-control" type="text" name="txt_nomor_rekening" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(@$rekening->nomor, 'txt_nomor_rekening'); ?>" />

                                </div>
                                <span class="help-block">Masukan Nomer Rekenining</span>
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