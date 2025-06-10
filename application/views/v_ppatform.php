<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script>
    jQuery(function($) {
        $("#ppat_id").mask('99999');
    });
</script>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" name="frm_ppatform" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">PPAT</a> &raquo; <?php echo $submitvalue; ?></h3>

                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                        <?php if (!empty($info)) {
                            echo $info;
                        }
                        ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">ID PPAT</label>
                            <div class="col-md-4 col-xs-12">
                                <input class="form-control" type="text" name="txt_id_ppat" id="ppat_id" style="width: 70px;" maxlength="5" value="<?php echo $this->antclass->back_value(@$ppat->id_ppat, 'txt_id_ppat'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                ?> class="tb" />
                            </div>
                        </div>


                        <input class="form-control" type="hidden" name="txt_id_user" id="user_id" style="width: 70px;" maxlength="5" value="<?php echo $this->antclass->back_value(@$ppat->id_user, 'txt_id_user'); ?>" class="tb" />


                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input class="form-control" type="text" name="txt_nama_ppat" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$ppat->nama, 'txt_nama_ppat'); ?>" class="tb" />
                                </div>
                                <span class="help-block">Masukan Nama</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-home"></span></span>
                                    <input class="form-control" type="text" name="txt_alamat_ppat" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$ppat->alamat, 'txt_alamat_ppat'); ?>" />
                                </div>
                                <span class="help-block">Masukan Alamat</span>
                            </div>
                        </div>

                        <!--  <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">No Telepon</label>
                        <div class="col-md-4 col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                <input  class="form-control" type="text" name="txt_telp_ppat" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(@$ppat->no_telp, 'txt_telp_ppat'); ?>" class="tb" />
                            </div>
                            <span class="help-block">Masukan Nomer Telepon</span>
                        </div>
                    </div>
 -->
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Username</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                    <input <?php if ($submitvalue == 'Edit') {
                                                echo 'disabled="disabled"';
                                            }
                                            ?> class="form-control" type="text" name="txt_username_ppat" style="width: 200px;" maxlength="30" value="<?php echo $this->antclass->back_value(@$ppat->username, 'txt_username_ppat'); ?>" class="tb" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Password</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input class="form-control" type="password" name="txt_password_ppat" style="width: 200px;" value="<?php echo set_value('txt_username_ppat'); ?>" class="tb" />
                                </div>
                                <span class="help-block">* Isi untuk mengganti Password, atau kosongkan untuk tetap menggunakan Password lama.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tanggal Expired</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    <input type="text" name="exp_date" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(changeDateFormat('webview', @$ppat->exp_date), 'txt_alamat_ppat'); ?>" class="form-control datepicker" required />

                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                        <label class="col-md-3 col-xs-12 control-label">Is Blokir</label>
                        <div class="col-md-4 col-xs-12">
                            <div class="input-group">

                                <label for="id_no"><input  type="radio" id="id_no" name="txt_status_ppat" <?php if (@$ppat->is_blokir == '0') {
                                                                                                                echo "checked='checked'";
                                                                                                            }
                                                                                                            ?> checked="checked" value="0" /> Tidak</label> &nbsp;
                                <label for="id_yes"><input  type="radio" id="id_yes" name="txt_status_ppat" <?php if (@$ppat->is_blokir == '1') {
                                                                                                                echo "checked='checked'";
                                                                                                            }
                                                                                                            ?> value="1" /> Ya</label>&nbsp;
                            </div>
                            <span class="help-block">Pilih Salah Satu</span>
                        </div>
                    </div> -->



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