<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script>
    jQuery(function($) {
        $("#paymentpoint_id").mask('9999999999999999');
    });
</script>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" name="frm_paymentpointform" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Payment Point</a> &raquo; <?php echo $submitvalue; ?></h3>

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
                            <label class="col-md-3 col-xs-12 control-label">ID Payment Point</label>
                            <div class="col-md-4 col-xs-12">
                                <input type="text" class="form-control" name="txt_id_pp" id="paymentpoint_id" style="width: 285px;" maxlength="16" value="<?php echo $this->antclass->back_value(@$paymentpoint->id_pp, 'txt_id_pp'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                                            } ?> />
                            </div>
                        </div>

                        <input class="form-control" type="hidden" name="txt_id_user" id="user_id" style="width: 70px;" maxlength="5" value="<?php echo $this->antclass->back_value(@$paymentpoint->id_user, 'txt_id_user'); ?>" class="tb" />

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" class="form-control" name="txt_nama_paymentpoint" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$paymentpoint->nama, 'txt_nama_paymentpoint'); ?>" />
                                </div>
                                <span class="help-block">Masukan Nama</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-home"></span></span>
                                    <input type="text" class="form-control" name="txt_alamat_paymentpoint" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$paymentpoint->alamat, 'txt_alamat_paymentpoint'); ?>" />
                                </div>
                                <span class="help-block">Masukan Alamat</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">No Telepon</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                    <input type="text" class="form-control" name="txt_telepon_paymentpoint" style="width: 250px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$paymentpoint->telepon, 'txt_telepon_paymentpoint'); ?>" />
                                </div>
                                <span class="help-block">Masukan Nomer Telepon</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kepala</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                    <input type="text" class="form-control" name="txt_namakepala_paymentpoint" style="width: 250px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$paymentpoint->nama_kepala, 'txt_namakepala_paymentpoint'); ?>" /> </td>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Username</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                    <input <?php if ($submitvalue == 'Edit') {
                                                echo 'disabled="disabled"';
                                            } ?> class="form-control" type="text" name="txt_username_user" style="width: 200px;" maxlength="30" value="<?php echo $this->antclass->back_value(@$paymentpoint->username, 'txt_username_user'); ?>" class="tb" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Password</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input class="form-control" type="password" name="txt_password_user" style="width: 200px;" value="<?php echo set_value('txt_password_user'); ?>" class="tb" />
                                </div>
                                <span class="help-block">* Isi untuk mengganti Password, atau kosongkan untuk tetap menggunakan Password lama.</span>
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