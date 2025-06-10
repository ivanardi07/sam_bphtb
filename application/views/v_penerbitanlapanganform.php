<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup_nik(string) {
        if (string == '') {
            $('#nama_nik_nama').val('');
        } else {
            $.post("<?php echo base_url(); ?>index.php/penerbitanlapangan/get_nik", {
                rx_id_nik: "" + string + ""
            }, function(data) {
                $('#nik_data_nama').val(data.nama);

            }, "json");
        }
    }

    function lookup_nop(string, nik) {
        if (nik == '') {
            alert('Nomor NIK atau NOP tidak boleh kosong.');
        } else {
            if (string == '') {
                $('#nop_alamat').val('');
            } else {
                $.post("<?php echo base_url(); ?>index.php/penerbitanlapangan/get_nop", {
                    rx_id_nop: "" + string + "",
                    rx_id_nik: "" + nik + ""
                }, function(data) {

                    $('#nop_alamat').val(data.lokasi_op);
                    $('#nop_kelurahan').val(data.nm_kelurahan);
                    $('#nop_kecamatan').val(data.nm_kecamatan);
                    $('#nop_dati2').val(data.nm_dati2);

                }, 'json');
            }
        }
    }
</script>
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <form class="form-horizontal" name="frm_jns_perolehan" method="post" action="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Pemeriksaan Lapangan</a> &raquo; <?php echo $submitvalue; ?></h3>

                        <ul class="panel-controls">
                            <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                        </ul>
                        <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title">Data petugas</h3>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">NIP</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_wp_nama" style="width: 200px;" maxlength="120" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan NIP</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">NAMA</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_wp_npwp" style="width: 350px;" maxlength="75" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan nama</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jabatan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_wp_npwp" style="width: 100px;" maxlength="75" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan jabatan</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <h3 class="panel-title">Wajib Pajak</h3>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">NIK</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" id="nik_data_id" onchange="lookup_nik($(this).val())" name="txt_wp_npwp" style="width: 200px;" maxlength="75" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan NIK</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nama</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input id="nik_data_nama" type="text" name="txt_wp_nama" style="width: 350px;" maxlength="120" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan nama</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <h3 class="panel-title">Objeck Pajak</h3>
                    </div>


                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Pejabat</label>
                            <div class="col-md-8 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 90px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                                                                        } ?> class="form-control" />
                                    <input type="text" name="txt_kd_jns_perolehan" id="jns_perolehan_id" style="width: 250px; margin-left: 10px" value="<?php echo $this->antclass->back_value(@$jns_perolehan->kd_perolehan, 'txt_kd_jns_perolehan'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                                                            } ?> class="form-control" />
                                </div>
                                <span class="help-block">Masukan nama pejabat</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Nomor Akta</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_nama_jns_perolehan" style="width: 100px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan nomor akta</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Tanggal Akta</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_nama_jns_perolehan" style="width: 100px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan tanggal</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">NOP PBB</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_nama_jns_perolehan" onchange="lookup_nop($(this).val())" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan NOP PBB</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" id="nop_alamat" name="txt_nama_jns_perolehan" style="width: 300px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan alamat</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kelurahan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" id="nop_kelurahan" name="txt_nama_jns_perolehan" style="width: 160px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan nama kelurahan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kecamatan</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" id="nop_kecamatan" name="txt_nama_jns_perolehan" style="width: 160px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan nama kecamatan</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kota</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" id="nop_dati2" name="txt_nama_jns_perolehan" style="width: 160px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan nama kota</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Kode Pos</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_nama_jns_perolehan" style="width: 100px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control" />

                                </div>
                                <span class="help-block">Masukan kode pos</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Jangka Waktu</label>
                            <div class="col-md-4 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    <input type="text" name="txt_nama_jns_perolehan" style="width: 50px;" maxlength="5" value="<?php echo $this->antclass->back_value(@$jns_perolehan->nama, 'txt_nama_jns_perolehan'); ?>" class="form-control">&nbsp&nbsp&nbsp&nbspHari

                                </div>
                                <span class="help-block">Masukan jangka waktu</span>
                            </div>
                        </div>
                    </div>





                    <div class="panel-footer">
                        <input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="btn btn-primary " />
                        <input type="submit" name="cetak" value="cetak " class="btn btn-success" />
                        <input type="reset" name="reset" value="Reset" class="btn btn-default" />

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