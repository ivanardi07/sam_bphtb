<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> NOP</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <div class="col-md-3 pull-right" style="text-align:center; margin-bottom: 10px;">
        <form action="" method="post">
            <input type="text" placeholder="Cari berdasarkan NOP" class="form-control" name="txt_nop" value="<?php echo @$search['nop']; ?>" /><br><input type="submit" class="btn btn-default" value="search" name="search" />&nbsp;<input type="submit" class="btn btn-default" value="reset" name="reset" />
        </form>
    </div>
    <?php if (!empty($info)) {
        echo $info;
    } ?>
    <?php if (!$nops) : echo 'Data NOP kosong.';
    else : ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?> <a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                                <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                            </div>
                            <div class="col-md-6"></div>

                        </div>

                    </div>
                    <form name="frm_nop" method="post" action="">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
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
                                                <td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $nop->nop; ?>" /> </td>
                                            <?php endif; ?>
                                            <td><?php echo $this->antclass->add_nop_separator($nop->nop); ?></td>
                                            <td><?php echo $nop->lokasi_op; ?></td>

                                            <td>
                                                <a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop; ?>"><i class="fa fa-pencil"></i></a>
                                                <?php
                                                $check_nop = $this->mod_sptpd->check_nop($nop->nop);
                                                if (!$check_nop) :
                                                ?>
                                                    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>

                                                        <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>index.php/nop/delete/<?php echo $nop->nop; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($nop->nop); ?>&quot;?')">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    <?php endif; ?>
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

<h1>NOP</h1>
<div class="nav_box">
    <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>[ <a href="<?php echo $c_loc; ?>/add">Tambah</a> ] | <?php endif; ?>
[ <a href="<?php echo $c_loc; ?>">Refresh Data</a> ]
</div>
<div class="nav_box" style="text-align:center">
    <form action="" method="post">
        NOP : <input type="text" class="tb" name="txt_nop" value="<?php echo @$search['nop']; ?>" /><br><input type="submit" class="bt" value="search" name="search" />&nbsp;<input type="submit" class="bt" value="reset" name="reset" />
    </form>
</div>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$nops) : echo 'Data NOP kosong.';
else : ?>
    <div class="listform">
        <form name="frm_nop" method="post" action="">
            <table>
                <tr class="tblhead">
                    <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                    <td style="width: 150px;">NOP</td>
                    <td>Letak Tanah dan atau Bangunan</td>
                    <td style="width: 45px;">Action</td>

                </tr>
                <?php
                $i = 1;
                $l = 0;
                foreach ($nops as $nop) :
                ?>
                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                else : echo "#F5F5F5";
                                                endif; ?>">
                        <td><?php echo $start + $i; ?></td>
                        <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                            <td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $nop->nop; ?>" /> </td>
                        <?php endif; ?>
                        <td><?php echo $this->antclass->add_nop_separator($nop->nop); ?></td>
                        <td><?php echo $nop->lokasi_op; ?></td>

                        <td>
                            <a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop; ?>"><img src="<?php echo base_url_img(); ?>edit.gif" title="Edit" alt="Edit" /></a>
                            <?php
                            $check_nop = $this->mod_sptpd->check_nop($nop->nop);
                            if (!$check_nop) :
                            ?>
                                <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>

                                    <a href="<?php echo base_url(); ?>index.php/nop/delete/<?php echo $nop->nop; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($nop->nop); ?>&quot;?')">
                                        <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php $i++;
                    $l++;
                endforeach; ?>
            </table>
            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                <div style="margin: 5px 0 0 13px;">
                    <img src="<?php echo base_url_img(); ?>leftup.gif" alt="" />
                    <a href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;">Check All</a> -
                    <a href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;">Uncheck All</a>
                    - with selected :
                    <button class="multi_submit" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')">
                        <img src="<?php echo base_url_img(); ?>trash.gif" title="Delete" alt="Delete" />
                    </button>
                </div>

            <?php endif; ?>
        </form>
    </div>
    <div class="paging"><?php echo $page_link; ?></div>
<?php endif; ?>