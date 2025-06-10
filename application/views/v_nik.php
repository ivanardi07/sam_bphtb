<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> NIK</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="col-md-6">
                        <a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a>
                        <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <form action="" method="post">
                        <div class="col-md-5">
                            <input class="form-control tulisan" id="nama" type="text" name="txt_nik" value="<?php echo @$search['nik'];  ?>" placeholder="NIK" />
                        </div>
                        <div class="col-md-5">
                            <input class="form-control tulisan" id="nama" type="text" name="txt_nama" value="<?php echo @$search['nama'];  ?>" placeholder="Nama" />
                        </div>
                        <div class="col-md-2">
                            <input class="btn btn-info tombol" type="submit" value="Cari" name="search" />
                        </div>
                    </form>
                </div>

                <div class="panel-body">
                    <?php if (!$niks) : echo 'Data NIK kosong.';
                    else : ?>
                        <div class="listform">
                            <form name="frm_nik" method="post" action="">
                                <table class="table table-bordered table-hover">
                                    <tr class="tblhead">
                                        <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D' or $this->session->userdata('s_tipe_bphtb') == 'PT') ? 2 : 1; ?>">No</td>
                                        <td style="width: 300px;">NPWP</td>
                                        <td>Nama</td>
                                        <td style="width: 80px;">Action</td>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    $l = 0;
                                    foreach ($niks as $nik) :
                                    ?>
                                        <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                    else : echo "#F5F5F5";
                                                                    endif; ?>">
                                            <td style="width: 40px"><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D' or $this->session->userdata('s_tipe_bphtb') == 'PT') : ?> <td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $nik->nik; ?>" /> </td><?php endif; ?>
                                            <td><?php echo $nik->nik; ?></td>
                                            <td><?php echo $nik->nama; ?></td>
                                            <td>
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>index.php/nik/edit/<?php echo $nik->nik; ?>"><i class="fa fa-pencil"></i></a>
                                                <?php
                                                $check_nik = $this->mod_sptpd->check_nik($nik->nik);
                                                if (!$check_nik) :
                                                ?>

                                                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D' or $this->session->userdata('s_tipe_bphtb') == 'PT') : ?>
                                                        <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>index.php/nik/delete/<?php echo $nik->nik; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($nik->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                        $l++;
                                    endforeach; ?>
                                </table>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D' or $this->session->userdata('s_tipe_bphtb') == 'PT') : ?>
                                                <div style="margin: 5px 0 0 13px;">
                                                    <!-- <img src="<?php echo base_url_img(); ?>leftup.gif" alt="" /> -->
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
    </div>
<?php endif; ?>
<style type="text/css">
    .tulisan {
        margin: 3px;
        margin-top: 20px;
    }

    .tombol {
        margin: 3px;
        margin-top: 20px;
    }
</style>