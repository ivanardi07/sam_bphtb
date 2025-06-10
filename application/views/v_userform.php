<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- UNTUK MEMILIH DISPENDA SECARA OTOMATIS -->
<script>
    $(document).ready(function() {
        $('.ds_id').show();
        $('.jabatan').hide();
        $('#jabatan').change(function() {
            var jab = $('#jabatan').val();
            if (jab == 0) {
                $('.jabatan').hide();
            } else
            if (jab == 1) {
                $('.jabatan').show();
            } else
            if (jab == 2) {
                $('.jabatan').show();
            }
        });
    });
</script>
<!-- END -->


<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_rekening" method="post" action="">
                <div class="panel panel-default">
                    <div class="col-md-12">
                        <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">User</a> &raquo; <?php echo $submitvalue; ?></h3>

                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>

                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Username</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_username_user" id="username_id" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(@$user->username, 'txt_username_user'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                } ?> class="form-control" />

                                </div>
                                <span class="help-block">Masukan Username</span>
                            </div>
                        </div>

                        <?php if ($submitvalue != 'Edit') : ?>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Password</label>
                                <div class="col-md-4 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                        <input type="password" name="txt_password_user" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value('', 'txt_password_user'); ?>" class="form-control" />

                                    </div>
                                    <span class="help-block">Masukan Password</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label">Ulangi Password</label>
                                <div class="col-md-4 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                        <input type="password" name="txt_password2_user" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value('', 'txt_password2_user'); ?>" class="form-control" />

                                    </div>
                                    <span class="help-block">Ulangi Password</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tipe</label>

                            <div class="col-md-2"><label class="check" for="id_dispenda"><input class="iradio" type="radio" id="id_dispenda" name="txt_tipe_user" <?php if (@$user->tipe == 'D') {
                                                                                                                                                                        echo "checked='checked'";
                                                                                                                                                                    } ?> value="D" onclick="$('.ds_id').show();$('.pt_id').hide();$('.pp_id').hide();$('.kpp_id').hide();" /> DISPENDA</label> &nbsp;</div>
                            <div class="col-md-2"><label class="check" for="id_ppat"><input class="iradio" type="radio" id="id_ppat" name="txt_tipe_user" <?php if (@$user->tipe == 'PT') {
                                                                                                                                                                echo "checked='checked'";
                                                                                                                                                            } ?> value="PT" onclick="$('.ds_id').hide();$('.pt_id').show();$('.pp_id').hide();$('.kpp_id').hide();"" />PPAT</label> &nbsp;</div>
                        <div class=" col-md-2"><label class="check" for="id_pp"><input class="iradio" type="radio" id="id_pp" name="txt_tipe_user" <?php if (@$user->tipe == 'PP') {
                                                                                                                                                        echo "checked='checked'";
                                                                                                                                                    } ?> value="PP" onclick="$('.ds_id').hide();$('.pt_id').hide();$('.pp_id').show();$('.kpp_id').hide();"" />BANK</label> &nbsp;</div>
                        <div class=" col-md-2"><label for="id_kpp" class="check"><input type="radio" class="iradio" id="id_kpp" name="txt_tipe_user" <?php if (@$user->tipe == 'kpp') {
                                                                                                                                                            echo "checked='checked'";
                                                                                                                                                        } ?> value="KPP" onclick="$('.ds_id').hide();$('.pt_id').hide();$('.pp_id').hide();$('.kpp_id').show();">BPN / KPP</label> &nbsp;</div>
                        </div>

                        <!-- DISPENDA -->
                        <div class="form-group ds_id">
                            <label class="col-md-3 col-xs-12 control-label">Jabatan</label>
                            <div class="col-md-2">
                                <select name="txt_jabatan" id="jabatan" class="form-control">
                                    <option>-- Pilih Jabatan --</option>
                                    <option id="pegawai" value="0" value="0">Pegawai</option>
                                    <option id="kasi" value="1">KASI</option>
                                    <option id="kabid" value="2">KABID</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group jabatan ds_id">
                            <label class="col-md-3 col-xs-12 control-label">NIP</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nip" id="nip" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nip, 'nip'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                        } ?> class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group jabatan ds_id">
                            <label class="col-md-3 col-xs-12 control-label">Nama</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama" id="nama" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                            } ?> class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group jabatan ds_id">
                            <label class="col-md-3 col-xs-12 control-label">Nama Dinas</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama_dinas" id="nama_dinas" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_dinas, 'nama_dinas'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                    } ?> class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group ds_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">ID Dispenda</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="id_dispenda" id="dispenda_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_dispenda, 'id_dispenda'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                        } ?> class="form-control id_input" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group ds_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Nama Dispenda</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_dispenda'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group ds_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Alamat Dispenda</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="alamat_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_dispenda'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>

                        <!-- PPAT -->
                        <div class="form-group pt_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">No KTP</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="id_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_ppat, 'id_ppat'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                        } ?> class="form-control id_input" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pt_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Nama PPAT</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_ppat'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pt_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Alamat PPAT</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="alamat_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_ppat'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pt_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Email PPAT</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                                    <input type="text" name="email_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->email, 'email_ppat'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>

                        <!-- BANK -->
                        <div class="form-group pp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Id BANK</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="id_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_pp, 'id_pp'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                    } ?> class="form-control id_input" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Nama BANK</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_pp'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Alamat BANK</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="alamat_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_pp'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Nama Kepala</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama_kepala_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_kepala, 'nama_kepala_pp'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group pp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Telepon</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="telp_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->telepon, 'telp_pp'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>

                        <!-- KPP -->
                        <div class="form-group kpp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">No KTP</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="id_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_kpp, 'id_kpp'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                        } ?> class="form-control id_input" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group kpp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Nama</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="nama_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_kpp'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>
                        <div class="form-group kpp_id" style="<?php if ($submitvalue != 'Edit' or @$user->tipe != 'P') {
                                                                    echo 'display: none;';
                                                                } ?>">
                            <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="alamat_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_kpp'); ?>" class="form-control" />
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tanggal Expired</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                    <input type="text" name="exp_date" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value('', 'exp_date'); ?>" class="form-control datepicker" required />

                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Is Blokir</label>
                            <div class="col-md-2"><label class="check" for="id_no"><input type="radio" class="iradio" id="id_no" name="txt_status_user" <?php if (@$user->is_blokir == '0') {
                                                                                                                                                            echo "checked='checked'";
                                                                                                                                                        } ?> checked="checked" value="0" /> Tidak</label> &nbsp;</div>
                            <div class="col-md-2"><label class="check" for="id_yes"><input type="radio" class="iradio" id="id_yes" name="txt_status_user" <?php if (@$user->is_blokir == '1') {
                                                                                                                                                                echo "checked='checked'";
                                                                                                                                                            } ?> value="1" /> Ya</label>&nbsp;</div>
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

<script type="text/javascript">
    jQuery(function($) {
        $(".id_input").mask("99999");
    });
</script>