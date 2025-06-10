<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup_dati2(string) {
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

    function lookup_kecamatan() {
        var id_propinsi = $('#txt_kd_propinsi').val();
        var id_kabupaten = $('#dati2_id').val();

        if (id_kabupaten == '') {
            $('#kecamatan_id').html('');
        } else {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/kelurahan/get_kecamatan_bydati2?idp=' + id_propinsi + '&idk=' + id_kabupaten
            }).done(function(data) {
                $('#kecamatan_id').html(data);
            });
        }
    }
    // function lookup_kecamatan(string){
    //     if(string == '') {
    //         $('#kecamatan_id').html('');
    //     }
    //     else {
    //         $.post("<?php echo base_url(); ?>index.php/kelurahan/get_kecamatan_bydati2", {
    //             rx_kd_dati2: "" + string + ""
    //         }, function(data){
    //             if (data.length > 0) {
    //                 $('#kecamatan_id').html(data);
    //             }
    //         });
    //     }
    // }
    jQuery(function($) {
        $("#kelurahan_id").mask('999');
    });
</script>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Kelurahan</a> &raquo; <?php echo $submitvalue; ?></h3>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="panel-body">
                    <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                </div><br><br>

                <?php if (!empty($info)) {
                    echo $info;
                } ?>
                <div class="inputform">
                    <form class="form-horizontal" name="frm_kelurahan" method="post" action="">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="txt_kd_propinsi" class="col-sm-4 control-label">Kode Propinsi &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <select class="form-control select2" style="width: 240px;" id='txt_kd_propinsi' name="txt_kd_propinsi" onchange="lookup_dati2($(this).val());">
                                                    <option></option>
                                                    <?php foreach ($propinsis as $propinsi) : ?>
                                                        <option <?php if ($propinsi->kd_propinsi == $kd_propinsi) {
                                                                    echo 'selected="selected"';
                                                                } ?> value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <span class="help-block">Pilih Kode Propinsi</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="dati2_id" class="col-sm-4 control-label">Kode Kabupaten &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <select class="form-control select2" style="width: 240px;" id="dati2_id" name="txt_kd_dati2" <?php if ($submitvalue != 'Edit') { ?> <?php } ?> onchange="lookup_kecamatan($(this).val());">
                                                    <?php if ($kd_dati2 == '') : ?>
                                                        <option></option>
                                                        <?php echo $this->mod_dati2->get_dati2('', '', $kd_propinsi); ?>
                                                    <?php else : ?>
                                                        <?php foreach ($dati2s as $dati2) : ?>
                                                            <option <?php if ($dati2->kd_kabupaten == $kd_dati2) {
                                                                        echo 'selected="selected"';
                                                                    } ?> value="<?php echo $dati2->kd_kabupaten; ?>"><?php echo $dati2->kd_kabupaten . ' - ' . $dati2->nama; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <span class="help-block">Pilih Kode Kabupaten</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="kecamatan_id" class="col-sm-4 control-label">Kode Kecamatan &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <select class="form-control select2" style="width: 240px;" id="kecamatan_id" name="txt_kd_kecamatan">
                                                    <?php if ($kd_kecamatan == '') : ?>
                                                        <option></option>
                                                    <?php else : ?>
                                                        <?php foreach ($kecamatans as $kecamatan) : ?>
                                                            <option></option>
                                                            <option <?php if ($kecamatan->kd_kecamatan == $kd_kecamatan) {
                                                                        echo 'selected="selected"';
                                                                    } ?> value="<?php echo $kecamatan->kd_kecamatan; ?>"><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <span class="help-block">Pilih Kode Kecamatan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="kelurahan_id" class="col-sm-4 control-label">Kode Kelurahan &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input class="form-control" type="text" name="txt_kd_kelurahan" id="kelurahan_id" style="width: 50px;" maxlength="5" value="<?php echo $this->antclass->back_value(@$kd_kelurahan, 'txt_kd_kelurahan'); ?>" />
                                            </div>
                                            <span class="help-block">Masukan Kode Kelurahan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="txt_nama_kelurahan" class="col-sm-4 control-label">Nama &raquo;</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <input class="form-control" type="text" name="txt_nama_kelurahan" style="width: 300px;" maxlength="50" value="<?php echo $this->antclass->back_value(@$kelurahan->nama, 'txt_nama_kelurahan'); ?>" />
                                            </div>
                                            <span class="help-block">Masukan Nama</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input class="btn btn-primary" type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="bt" />
                            <input class="btn btn-default" type="reset" name="reset" value="Reset" class="bt" />
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
                <script type="text/javascript">
                    $('#kelurahan_id').on('change', function() {
                        var str = $('#kelurahan_id').val();
                        var string = str.length;
                        if (string < 3) {
                            $('#kelurahan_id').val('');
                        }
                    });
                </script>