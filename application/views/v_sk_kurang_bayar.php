<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_dati" method="post" action="<?= $c_loc ?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pencetakan Surat Keputusan</h3>

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
                            <label class="col-md-3 col-xs-12 control-label">Jenis SK &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-th-list"></span></span>
                                    <select name="txt_jns_sk" class='form-control select2'>
                                        <option value="STB">STB</option>
                                        <option value="SKBKB" selected="selected">SKBKB</option>
                                        <option value="SKPENGURANGAN">SK PENGURANGAN</option>
                                    </select>
                                </div>
                                <span class="help-block">Pilih jenis SK</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor &raquo;</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_nomor" style="width: 150px;" value="" class="form-control tb" />
                                </div>
                                <span class="help-block">Masukkan Nomor</span>
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <input type="submit" name="search_submit" value="Cari" class="bt btn btn-primary" />
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