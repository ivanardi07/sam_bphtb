<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> NOP</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="col-md-12"><?php if (!empty($info)) {
                                            echo $info;
                                        } ?></div>
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?> <a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $c_loc . '/' . 'refresh'; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>


                    </div>


                </div>
                <div class="panel-body">

                    <div class="col-md-4 pull-right">
                        <form class="form-inline" role="form" action="" method="post">
                            <div class="form-group">
                                <label class="sr-only" for="cari">Cari</label>
                                <input type="text" placeholder="Cari berdasarkan NOP" class="form-control" name="txt_nop" value="<?php echo @$search_value['nop']; ?>" />
                            </div>
                            <input type="submit" class="btn btn-info" value="Cari" name="search" />
                        </form>
                    </div>
                    <br>
                    <br>
                    <br>
                    <?php if (!$nops) : ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>No.</td>
                                    <td>NOP</td>
                                    <td>Letak Tanah Atau Bangunan</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <center>Data NOP kosong.</center>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    <?php else : ?>
                        <form name="frm_nop" method="post" action="">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>" width="1">No</td>
                                        <td>NOP</td>
                                        <td>Letak Tanah dan atau Bangunan</td>
                                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td>Action</td><?php endif; ?>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($nops as $nop) :
                                ?>
                                    <tbody>
                                        <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                    else : echo "#F5F5F5";
                                                                    endif; ?>">
                                            <td><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                <td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $nop->kd_propinsi; ?>" /> </td>
                                            <?php endif; ?>
                                            <td><?= $nop->kd_propinsi; ?>.<?= $nop->kd_kabupaten; ?>.<?= $nop->kd_kecamatan; ?>.<?= $nop->kd_kelurahan; ?>.<?= $nop->kd_blok; ?>.<?= $nop->no_urut; ?>.<?= $nop->kd_jns_op; ?></td>
                                            <td><?php echo $nop->lokasi_op; ?></td>

                                            <td>
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>index.php/nop/edit/<?= $nop->kd_propinsi; ?><?= $nop->kd_kabupaten; ?><?= $nop->kd_kecamatan; ?><?= $nop->kd_kelurahan; ?><?= $nop->kd_blok; ?><?= $nop->no_urut; ?><?= $nop->kd_jns_op; ?>"><i class="fa fa-pencil"></i></a>

                                                <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                    <?php
                                                    $lokasi = $nop->kd_propinsi . '.' . $nop->kd_kabupaten . '.' . $nop->kd_kecamatan . '.' . $nop->kd_kelurahan . '.' . $nop->kd_blok . '.' . $nop->no_urut . '.' . $nop->kd_jns_op;
                                                    if (cek_data_lokasi($lokasi, 'nop') == 'kosong') {
                                                    ?>
                                                        <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>index.php/nop/delete/<?= $nop->kd_propinsi; ?><?= $nop->kd_kabupaten; ?><?= $nop->kd_kecamatan; ?><?= $nop->kd_kelurahan; ?><?= $nop->kd_blok; ?><?= $nop->no_urut; ?><?= $nop->kd_jns_op; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($nop->lokasi_op); ?>&quot;?')">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    <?php
                                                    } ?>

                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php $i++;
                                    $l++;
                                endforeach; ?>
                                    </tbody>
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