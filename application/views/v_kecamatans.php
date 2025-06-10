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
    <?php if (!empty($info)) {
        echo $info;
    } ?>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-4">
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>

                    </div>
                </div>
                <?php if (!$kecamatans) : echo 'Data Distrik kosong.';
                else : ?>
                    <div class="clearfix" style="margin-top: 70px;"></div>
                    <div class="col-md-7" style="float:right;">
                        <form class="form-inline" role="form" action="<?php echo site_url('kecamatan/index'); ?>" method="get">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-control select2" name="propinsi" onchange="lookup($(this).val());">
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach ($propinsis as $propinsi) : ?>
                                            <option <?php if ($propinsi->kd_propinsi == @$kecamatan->kd_propinsi) ?> value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->nama; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control select2" id="dati2_id" name="kd_dati2">
                                    <?php if ($kecamatan->kd_kabupaten == '') : ?>
                                        <option>Pilih Kabupaten</option>
                                    <?php else : ?>
                                        <?php foreach ($dati2s as $dati2) : ?>
                                            <option <?php if ($dati2->kd_kabupaten == @$kecamatan->kd_kabupaten) ?> value="<?php echo $dati2->kd_kabupaten; ?>"><?php echo $dati2->nama; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control pull-right tulisan" name="kecamatan" placeholder="Nama Kecamatan">
                            </div>
                            <input type="submit" class="btn btn-info pull-right tombol" value="Cari">
                        </form>
                    </div>
                    <form name="frm_dati" method="post" action="">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                        <td>Kode</td>
                                        <td>Nama Kecamatan</td>
                                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td>Action</td><?php endif; ?>
                                    </tr>
                                </thead>
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
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td width="1"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $kecamatan->kd_kecamatan; ?>" /> </td><?php endif; ?>

                                            <td><?php echo $kecamatan->kd_kecamatan; ?></td>
                                            <td><?php echo $kecamatan->nama; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                <td>
                                                    <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>index.php/kecamatan/edit/<?php echo $kecamatan->kd_kecamatan; ?>"><i class="fa fa-pencil"></i></a>
                                                    <?php
                                                    $check_kecamatan = $this->mod_nik->check_kecamatan($kecamatan->kd_kecamatan);
                                                    $check_kecamatan_nop = $this->mod_nop->check_kecamatan($kecamatan->kd_kecamatan);
                                                    if (!$check_kecamatan && !$check_kecamatan_nop) :
                                                    ?>
                                                        <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>index.php/kecamatan/delete/<?php echo $kecamatan->kd_kecamatan; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($kecamatan->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
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
            </div </div>

        </div>
    </div>

</div>
<?php endif; ?>