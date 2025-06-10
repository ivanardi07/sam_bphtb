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

        $('#kecamatan_id').html('');
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
    jQuery(function($) {
        $("#kelurahan_id").mask('999');
    });
</script>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Kelurahan</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $this->session->flashdata('info'); ?>
                    <div class="col-md-12">
                        <form action="<?= site_url('kelurahan'); ?>" method="get" role="form">
                            <div class="col-md-2">
                                <select class="form-control select2" style="width: 150px;" id='txt_kd_propinsi' name="txt_kd_propinsi" onchange="lookup_dati2($(this).val());">
                                    <option value="">Pilih propinsi</option>
                                    <?php foreach ($propinsis as $propinsi) : ?>
                                        <option value="<?php echo $propinsi->kd_propinsi; ?>" <?= ($this->input->get('txt_kd_propinsi') == $propinsi->kd_propinsi) ? 'selected="selected"' : ''; ?>><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 225px;" id="dati2_id" name="txt_kd_dati2" onchange="lookup_kecamatan();">
                                    <?php if ($kd_dati2 == '') : ?>
                                        <option value="">Pilih kabupaten</option>
                                        <?php echo $this->mod_dati2->get_dati2('', '', $kd_propinsi); ?>
                                    <?php else : ?>
                                        <?php foreach ($dati2s as $dati2) : ?>
                                            <option value="<?php echo $dati2->kd_dati2; ?>"><?php echo $dati2->kd_dati2 . ' - ' . $dati2->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" style="width: 225px;" id="kecamatan_id" name="txt_kd_kecamatan">
                                    <?php if ($kd_kecamatan == '') : ?>
                                        <option value="">Pilih kecamatan</option>
                                    <?php else : ?>
                                        <?php foreach ($kecamatans as $kecamatan) : ?>
                                            <option></option>
                                            <option value="<?php echo $kecamatan->kd_kecamatan; ?>"><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" value="<?= $get ?>" placeholder="Nama kelurahan" name="cari" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Cari" class="btn btn-default">
                            </div>
                        </form>
                    </div>

                    <?php if (!empty($info)) {
                        echo $info;
                    }
                    ?>
                    <?php if (!$kelurahans) : ?>
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tblhead">
                                        <th colspan="2">No</th>
                                        <th style="width: 100px;">Kode</th>
                                        <th style="width: 225px;">Nama Kelurahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tblhov" bgcolor="#E5E5E5">
                                        <td colspan="5" class="text-center">Data tidak ada</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <? php;
                    else : ?>
                </div>
                <div class="listform">
                    <form name="frm_kelurahan" method="post" action="">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tblhead">
                                        <th colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</th>
                                        <th style="width: 100px;">Kode</th>
                                        <th style="width: 225px;">Nama Kelurahan</th>
                                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><th style="width: 45px;">Action</th> <?php endif; ?>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($kelurahans as $kelurahan) :
                                ?>
                                    <tbody>
                                        <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                    else : echo "#F5F5F5";
                                                                    endif; ?>">
                                            <td width="40px"><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $kelurahan->kd_propinsi . '.' . $kelurahan->kd_kabupaten . '.' . $kelurahan->kd_kecamatan . '.' . $kelurahan->kd_kelurahan; ?>" /> </td> <?php endif; ?>
                                            <td><?php echo $kelurahan->kd_kelurahan; ?></td>
                                            <td><?php echo $kelurahan->nama; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                <td>
                                                    <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>index.php/kelurahan/edit/<?php echo $kelurahan->kd_propinsi . '.' . $kelurahan->kd_kabupaten . '.' . $kelurahan->kd_kecamatan . '.' . $kelurahan->kd_kelurahan; ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php
                                                    $check_kelurahan     = $this->mod_nik->check_kelurahan($kelurahan->kd_kelurahan);
                                                    $check_kelurahan_nop = $this->mod_nop->check_kelurahan($kelurahan->kd_kelurahan);
                                                    if (!$check_kelurahan && !$check_kelurahan_nop) :
                                                    ?>

                                                        <?php
                                                        $lokasi = $kelurahan->kd_propinsi . '.' . $kelurahan->kd_kabupaten . '.' . $kelurahan->kd_kecamatan . '.' . $kelurahan->kd_kelurahan;
                                                        if (cek_data_lokasi($lokasi, 'kelurahan') == 'kosong') {
                                                        ?>
                                                            <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>index.php/kelurahan/delete/<?php echo $kelurahan->kd_propinsi . '.' . $kelurahan->kd_kabupaten . '.' . $kelurahan->kd_kecamatan . '.' . $kelurahan->kd_kelurahan; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($kelurahan->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
                                                        <?php } ?>

                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    </tbody>
                                <?php $i++;
                                    $l++;
                                endforeach; ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                        <div style="margin: 5px 0 0 13px;">
                                            <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;"><span class="fa fa-check"></span>Check All</a> -
                                            <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;"><span class="fa fa fa-check-square-o"></span>Uncheck All</a>
                                            - with selected :
                                            <button class="multi_submit btn btn-danger" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')"><span class="fa fa-trash-o"></span></button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-offset-2 col-md-4">
                                    <!-- PAGINATION BELUM -->
                                    <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    jQuery(document).ready(function($) {
        // alert();
        if ('<?= $txt_kd_dati2_selected ?>' == '') {
            $('#dati2_id').html('');
        } else {

            $.post("<?php echo base_url(); ?>index.php/dati/get_dati2_bypropinsi", {
                rx_kd_propinsi: "" + $('#txt_kd_propinsi').val() + "",
                rx_kd_dati: "" + '<?= $txt_kd_dati2_selected ?>' + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#dati2_id').html(data);
                }
                // console.log(data);

                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/kelurahan/get_kecamatan_bydati2?idp=' + $('#txt_kd_propinsi').val() + '&idk=' + '<?= $txt_kd_dati2_selected ?>' + '&idkec_selected=' + '<?= $txt_kd_kecamatan_selected ?>'
                }).done(function(kecamatan) {
                    // alert(kecamatan);
                    $('#kecamatan_id').html(kecamatan);
                });
            });
        }
    });
</script>