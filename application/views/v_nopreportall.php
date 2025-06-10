<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Laporan Perubahan NOP</h2>
</div>
<!-- END PAGE TITLE -->
<a style="margin-left:10px;" class="btn btn-default" href="javascript:void()" onclick="$('.listform').printElement({overrideElementCSS:['<?= base_url_css() ?>bphtb_stylo_print.css']});"><span class="fa fa-print"></span>Print</a>
<?php if (!empty($info)) {
    echo $info;
} ?>
<?php if (!$nops) : echo 'Data perubahan NOP kosong.';
else : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6"></div>

                    </div>

                </div>
                </form>
                <form name="frm_nop" method="post" action="">
                    <div class="panel-body">
                        <div class="listform">
                            <table class="table table-bordered table-hover">
                                <tr class="tblhead">
                                    <td>No</td>
                                    <td style="width: 140px;">Tanggal</td>
                                    <td>NOP Lama</td>
                                    <td>NOP Baru</td>
                                </tr>
                                <?php
                                $i = 1;
                                $l = 0;
                                $sub_total = 0;
                                foreach ($nops as $nop) :
                                ?>
                                    <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                else : echo "#F5F5F5";
                                                                endif; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td align="center"><?php echo $this->antclass->fix_datetime($nop->tanggal); ?></td>
                                        <td><a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop_lama; ?>"><?php echo $this->antclass->add_nop_separator($nop->nop_lama); ?></a></td>
                                        <td><a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop_baru; ?>"><?php echo $this->antclass->add_nop_separator($nop->nop_baru); ?></a></td>
                                    </tr>
                                <?php $i++;
                                    $l++;
                                endforeach; ?>
                            </table>
                        </div>

                    </div>

                    <div class="panel-footer">
                        <div class="row">
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

<script type="text/javascript" src="<?= base_url() ?>assets/template/js/bootstrap-datepicker.js"></script>