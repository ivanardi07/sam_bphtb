<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
    function lookup(string) {
        if (string == '') {
            $('#dati2_id').html('');
        } else {

            $.post("<?php echo base_url(); ?>index.php/dati/get_dati2_bypropinsi", {
                rx_kd_propinsi: "" + string + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#dati2_id').html(data);
                }
                console.log(data);
            });
        }
    }
    jQuery(function($) {
        $("#kecamatan_id").mask('999');
    });
</script>
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> KECAMATAN</h2>
</div>

<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <?php if (!empty($info)) {
                        echo $info;
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    &nbsp;
                </div>
                <div class="col-md-9" style="float:right;">
                    <form class="form-inline" role="form" action="<?php echo site_url('kecamatan/index'); ?>" method="get">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control select2" style="width:160px;" id="propinsi" name="propinsi" onchange="lookup($(this).val());">
                                    <option value="">&nbsp;--Pilih Propinsi--&nbsp;</option>
                                    <?php foreach ($propinsis as $propinsi) : ?>
                                        <option value="<?php echo $propinsi->kd_propinsi; ?>" <?= ($this->input->get('propinsi') == $propinsi->kd_propinsi) ? 'selected="selected"' : ''; ?>><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control select2" id="dati2_id" name="kd_dati2" style="width:160px;">



                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="kecamatan" placeholder="Nama Kecamatan" value="<?= $get ?>">
                        </div>
                        <input type="submit" class="btn btn-info" value="Cari">
                    </form>
                </div>


                <form name="frm_dati" method="post" action="">
                    <div class="panel-body">
                        <?= $this->session->flashdata('info'); ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                    <td>Kode</td>
                                    <td>Nama Kecamatan</td>
                                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td>Action</td><?php endif; ?>
                                </tr>
                            </thead>
                            <?php if (!$kecamatans) : echo 'Data Distrik kosong.';
                            else : ?>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($kecamatans as $kecamatan) :
                                ?>
                                    <tbody>
                                        <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">

                                            <td width="1"><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                <td width="1">
                                                    <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?= $kecamatan->kd_propinsi . '.' . $kecamatan->kd_kabupaten . '.' . $kecamatan->kd_kecamatan; ?>" />
                                                </td>
                                            <?php endif; ?>

                                            <td><?php echo $kecamatan->kd_kecamatan; ?></td>
                                            <td><?php echo $kecamatan->nama; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                <td>
                                                    <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>index.php/kecamatan/edit/<?php echo $kecamatan->kd_propinsi . '.' . $kecamatan->kd_kabupaten . '.' . $kecamatan->kd_kecamatan; ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php
                                                    $check_kecamatan     = $this->mod_nik->check_kecamatan($kecamatan->kd_kecamatan);
                                                    $check_kecamatan_nop = $this->mod_nop->check_kecamatan($kecamatan->kd_kecamatan);
                                                    if (!$check_kecamatan && !$check_kecamatan_nop) :
                                                    ?>
                                                        <?php
                                                        $lokasi = $kecamatan->kd_propinsi . '.' . $kecamatan->kd_kabupaten . '.' . $kecamatan->kd_kecamatan;
                                                        if (cek_data_lokasi($lokasi, 'kecamatan') == 'kosong') {
                                                        ?>
                                                            <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>index.php/kecamatan/delete/<?php echo $kecamatan->kd_propinsi . '.' . $kecamatan->kd_kabupaten . '.' . $kecamatan->kd_kecamatan; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($kecamatan->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
                                                        <?php
                                                        }
                                                        ?>
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
                                    <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;"><span class="fa fa-check"></span>Check All</a> -
                                    <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;"><span class="fa fa fa-check-square-o"></span>Uncheck All</a>
                                    - with selected :
                                    <button class="multi_submit btn btn-danger" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')"><span class="fa fa-trash-o"></span>
                                    </button>
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

</div>
<?php endif; ?>

<script>
    jQuery(document).ready(function($) {
        // alert();
        if ('<?= $kd_dati2_selected ?>' == '') {
            $('#dati2_id').html('');
        } else {

            $.post("<?php echo base_url(); ?>index.php/dati/get_dati2_bypropinsi", {
                rx_kd_propinsi: "" + $('#propinsi').val() + "",
                rx_kd_dati: "" + '<?= $kd_dati2_selected ?>' + ""
            }, function(data) {
                if (data.length > 0) {
                    $('#dati2_id').html(data);
                }
                console.log(data);
            });
        }
    });
</script>