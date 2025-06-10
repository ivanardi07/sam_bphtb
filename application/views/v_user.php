<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> USER MANAGEMENT</h2>
</div>
<!-- END PAGE TITLE -->
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
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                        <div class="col-md-6"></div>


                    </div>
                </div>

                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <form action="" method="GET">

                        <div class="col-md-5">

                            <select class="form-control pull-right tulisan select" name="tipe">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="D" <?= ($this->input->get('tipe') == 'D') ? 'selected="selected"' : ''; ?>>Dispenda</option>
                                <option value="PT" <?= ($this->input->get('tipe') == 'PT') ? 'selected="selected"' : ''; ?>>PPAT</option>
                                <option value="KPP" <?= ($this->input->get('tipe') == 'KPP') ? 'selected="selected"' : ''; ?>>BPN / KPP</option>
                                <option value="PP" <?= ($this->input->get('tipe') == 'PP') ? 'selected="selected"' : ''; ?>>Payment Point</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control pull-right tulisan" name="cari" placeholder="Masukan nama user" value="<?= $this->input->get('cari') ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="submit" class="btn btn-info pull-right tombol" value="Cari">
                        </div>
                    </form>

                </div>




                <?php if (!$user) : echo 'Data user kosong.';
                else : ?>
                    <form name="frm_user" method="post" action="">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <td colspan="2">No</td>
                                        <td style="width: 120px;">Username</td>

                                        <td style="width: 90px;">Tipe</td>
                                        <td style="width: 45px;">Blokir</td>
                                        <td style="width: 45px;">Action</td>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($user as $user) :
                                ?>
                                    <tbody>
                                        <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                            <td width="1"><?php echo $start + $i; ?></td>
                                            <td width="5"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $user->id_user . ',' . $user->tipe; ?>" /> </td>
                                            <td><?php echo $user->username; ?></td>

                                            <td>
                                                <?php if ($user->tipe == 'PP') : echo 'Payment Point'; ?>
                                                <?php elseif ($user->tipe == 'D') : echo 'DISPENDA'; ?>
                                                <?php elseif ($user->tipe == 'PT') : echo 'PPAT'; ?>
                                                <?php elseif ($user->tipe == 'B') : echo 'Bank'; ?>
                                                <?php else : echo $user->tipe;
                                                endif; ?>
                                            </td>
                                            <td align="center">
                                                <?php if ($user->is_blokir == '1') : ?>
                                                    <a href="<?php echo $c_loc; ?>/status/<?php echo $user->id_user; ?>" class="btn btn-default"><img src="<?php echo base_url_img(); ?>approve.gif" title="Blokir" alt="Blokir" /></a>
                                                <?php else : ?>
                                                    <a href="<?php echo $c_loc; ?>/status/<?php echo $user->id_user; ?>" class="btn btn-default"><img src="<?php echo base_url_img(); ?>pending.gif" title="Non Blokir" alt="Non Blokir" /></a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>index.php/user/edit/<?php echo $user->id_user; ?>/<?php echo $user->tipe; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                                                <?php if ($user->id_user != $this->session->userdata('s_username_bphtb')) : ?>

                                                    <?php

                                                    $cek_ppat = cek_sptpd($user->id_user);

                                                    if ($cek_ppat == 'kosong') {
                                                    ?>

                                                        <a href="<?php echo base_url(); ?>index.php/user/delete/<?php echo $user->id_user; ?>/<?php echo $user->tipe; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete <?php echo $user->username; ?>?')">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>

                                                    <?php
                                                    }
                                                    ?>
                                                <?php endif; ?>
                                            </td>
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
                                    <img src="<?php echo base_url_img(); ?>leftup.gif" alt="" />
                                    <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;">Check All</a> -
                                    <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;">Uncheck All</a>
                                    - with selected :
                                    <button class="btn btn-default multi_submit" type="submit" name="submit_multi" value="status" title="Update Status" onclick="return confirm('Are you sure to update these records status?')">
                                        <img src="<?php echo base_url_img(); ?>apppend.gif" title="Status" alt="Status" />
                                    </button>
                                    <button class="btn btn-default multi_submit" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')">
                                        <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                                    </button>
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