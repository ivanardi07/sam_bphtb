<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Lampiran</h2>
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
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                        <div class="col-md-6"></div>

                    </div>

                </div>
                <?php if (!$penelitians) : echo '<center><h4>Data formulir penelitian kosong.</h4></center>';
                else : ?>
                    <form name="frm_penelitian" method="post" action="">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                        <td style="width: 100px;">No Formulir</td>
                                        <td style="width: 450px;">No SSPD</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($penelitians as $penelitian) :
                                ?>
                                    <tbody>
                                        <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                    else : echo "#F5F5F5";
                                                                    endif; ?>">
                                            <td width="1"><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $penelitian->id_formulir; ?>" /> </td><?php endif; ?>
                                            <td><?php echo $penelitian->no_formulir; ?></td>
                                            <td><?php echo $penelitian->no_sspd; ?></td>

                                            <td>
                                                <a class="btn btn-xs btn-success" href="<?php echo base_url(); ?>index.php/penelitian/edit/<?php echo $penelitian->id_formulir; ?>"><span class="fa fa-edit"></span></a>

                                                <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                    <a class="btn btn-xs btn-danger" href="<?php echo base_url(); ?>index.php/penelitian/delete/<?php echo $penelitian->id_formulir; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($penelitian->no_formulir); ?>&quot;?')">
                                                        <span class="fa fa-times"></span>
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
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