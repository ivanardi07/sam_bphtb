<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/template/css/bootstrap/datepicker3.css">
<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });

        $("#datepicker2").datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showOn: 'button',
            buttonImage: '<?= base_url_img() ?>calendar.gif',
            buttonImageOnly: true
        });
    });
</script>
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Laporan Perubahan NOP</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form name="frm_s_nop" method="post" action="<?= $c_loc ?>/go_report">
            <div class="row">
                <div class="col-md-6" style="margin-bottom:20px;">
                    <div class="col-md-5">
                        <center>
                            <h5>Tanggal Awal</h5>
                        </center><br>
                        <center>
                            <h5>Tanggal Akhir</h5>
                        </center>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group">
                            <input id="datepicker" class="form-control" name="txt_c_tgl_awal" value="<?php if ($this->uri->segment(3) != '') {
                                                                                                            echo $this->uri->segment(3);
                                                                                                        } ?>" type="text">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <center style="opacity:0;">
                            <h6><span class="fa fa-arrow-down"></span></h6>
                        </center>
                        <div class="input-group">
                            <input id="datepicker2" class="form-control" name="txt_c_tgl_akhir" value="<?php if ($this->uri->segment(4) != '') {
                                                                                                            echo $this->uri->segment(4);
                                                                                                        } ?>" type="text">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-5">
                        <center>
                            <h5>NOP Lama</h5>
                        </center><br>
                        <center>
                            <h5>NOP Baru</h5>
                        </center>
                    </div>
                    <div class="col-md-7">
                        <div>
                            <input type="text" name="txt_c_nop_lama" class="form-control" value="<?php if ($this->uri->segment(5) == '-' or $this->uri->segment(5) != '') {
                                                                                                        echo $this->antclass->add_nop_separator($this->uri->segment(5));
                                                                                                    } ?>">
                        </div>
                        <br>
                        <div>
                            <input type="text" name="txt_c_nop_baru" class="form-control" value="<?php if ($this->uri->segment(6) == '-' or $this->uri->segment(6) != '') {
                                                                                                        echo $this->antclass->add_nop_separator($this->uri->segment(6));
                                                                                                    } ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div style="margin-left:241px; margin-top:20px; margin-bottom:20px;">
                <input type="submit" name="search_submit" value="Cari" class="btn btn-default" />
                <input type="submit" name="submit_print_all" value="Print" class="btn btn-default" />
            </div>
            <a style="margin-left:10px;" class="btn btn-default" href="<?php echo $c_loc; ?>/report"><span class="fa fa-refresh"></span>Kosongkan Filter</a>
            <?php if (!empty($info)) {
                echo $info;
            } ?>

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
                <?php if (!$nops) : echo 'Data perubahan NOP kosong.';
                else : ?>
                    <table class="table table-bordered table-hover">
                        <tr class="tblhead">
                            <td width="1">No</td>
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
                                <td><?php echo $start + $i; ?></td>
                                <td align="center"><?php echo $this->antclass->fix_datetime($nop->tanggal); ?></td>
                                <td><a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop_lama; ?>"><?php echo $this->antclass->add_nop_separator($nop->nop_lama); ?></a></td>
                                <td><a href="<?php echo base_url(); ?>index.php/nop/edit/<?php echo $nop->nop_baru; ?>"><?php echo $this->antclass->add_nop_separator($nop->nop_baru); ?></a></td>
                            </tr>
                        <?php $i++;
                            $l++;
                        endforeach; ?>
                    </table>
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

<script type="text/javascript">
    $('#datepick input').datepicker({});
</script>

<script type="text/javascript" src="<?= base_url() ?>assets/template/js/bootstrap-datepicker.js"></script>