<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
        });
    });
</script>
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span>Pengantar Permohonan</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <?php if (!empty($info)) {
        echo $info;
    } ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <form name="frm_pengantar_permohonan" class="form-horizontal" method="post" action="<?= $c_loc ?>">
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jenis Pelayanan</label>
                            <div class="col-md-4 col-xs-12" style="width: 190px;">
                                <select class="form-control select" style="display: none;">
                                    <option value="">-- Pilih Salah Satu --</option>
                                    <option value="KEBERATAN">KEBERATAN</option>
                                </select>
                                <span class="help-block">Pilih Jenis Pelayanan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tanggal Penerimaan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                    <input class="form-control" id="datepicker" type="text" name="txt_tgl_penerimaan" style="width: 190px;" value="" class="tb" />
                                </div>
                                <span class="help-block">Masukan Tanggal Penerimaan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label"></label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                    <input type="submit" name="search_submit" value="Cari" class="btn btn-info" />

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script type='text/javascript' src='<?= base_url() ?>assets/template/js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-file-input.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-select.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

<style type="text/css">
    input.btn.btn-info {
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
    }
</style>