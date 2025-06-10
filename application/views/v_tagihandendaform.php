<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_dati" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Penerbitan Surat Tagihan Denda (STD)</a> &raquo; <?php echo $submitvalue; ?></h3>

                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Bulan / Tahun Dikenakan STD &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-th-list"></span></span>
                                    <?php echo form_dropdown("txt_bulan", $bulan, $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'), 'class="form-control"'); ?>
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_wp_npwp" style="width: 70px;" maxlength="4" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="tb form-control" />
                                </div>
                                <span class="help-block">Masukan Bulan Tahun</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jenis Denda &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-th-list"></span></span>
                                    <?php echo form_dropdown("txt_jenisdenda", $jenisdenda, $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'), 'class="form-control tb"'); ?>

                                </div>
                                <span class="help-block">Pilih jenis denda</span>
                            </div>
                            <div class="col-md-4"><input type="button" value="Lihat Denda" class="btn btn-defult">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor STD &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_no_std" maxlength="75" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="tb form-control" />
                                </div>
                                <span class="help-block">Masukkan Nomor STD</span>
                            </div>
                            <div class="col-md-4"><input type="button" value="0_0" class="btn btn-defult"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kode / Nama Pejabat &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 90px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                                                        } ?> class="form-control tb" />
                                    <input disabled="disabled" type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 150px;" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                } ?> class="form-control tb" />
                                </div>
                                <span class="help-block">Masukkan Kode / Nama Pejabat</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Surat Laporan Pejabat &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                                                            } ?> class="form-control tb" />
                                </div>
                                <span class="help-block">Nomor Surat Laporan Pejabat</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Besarnya Denda &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                                                            } ?> class="form-control tb" />
                                </div>
                                <span class="help-block">Masukkan Besar Denda</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tempat Bayar STD &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 90px;" maxlength="90" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                                                        } ?> class="form-control tb" />
                                    <input disabled="disabled" type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 150px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                                                                                } ?> class="form-control tb" />
                                </div>
                                <span class="help-block">Masukkan Besar Denda</span>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="btn btn-primary " />
                        <input type="submit" name="cetak" value="cetak" class="bt btn btn-default" />
                        <input type="reset" name="reset" value="Reset" class="btn btn-default" />


                    </div>
                    <div class="panel-footer">
                        <table class="table table-bordered table-hover tblhead">
                            <thead>
                                <tr>
                                    <td align="center"> Nomor STD </td>
                                    <td align="center"> Tanggal STD</td>
                                    <td align="center"> Nomor Laporan</td>
                                    <td align="center"> Kode PPAT </td>
                                    <td align="center"> Nama Pejabat </td>
                                    <td align="center"> Alamat Pejabat </td>
                                </tr>
                                <tr>
                                    <td colspan=6>
                                        <center>Data Kosong</center>
                                    </td>
                                </tr>
                            </thead>

                        </table>
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