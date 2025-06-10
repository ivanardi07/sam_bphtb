<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $ppat = $this->uri->segment(6); ?>
<style type="text/css" media="print">
    * {
        font-size: 11px;
    }
</style>
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Laporan SSPD - BPHTB</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <div class="col-md-12" style="margin-bottom: 10px;">

        <?php if (!empty($info)) {
            echo $info;
        } ?>
        <?php if (!$sptpds) : echo 'Data SPTPD kosong.';
        else : ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?= str_replace('report_all', 'report', current_url()) ?>" class="btn btn-default">Back</a>
                                    <?php if ($ppat != '-') : ?>
                                        <a style="margin-left:10px;" class="btn btn-info" href="<?= site_url('print_pdf/SPTPDPRINTALL') ?>" target="_blank"><span class="fa fa-print"></span>Print</a>
                                    <?php else : ?>
                                        <a style="margin-left:10px;" class="btn btn-info" href="javascript:void()" onclick="$('.listform').printElement({overrideElementCSS:['<?= base_url_css() ?>bphtb_stylo_print.css']});"><span class="fa fa-print"></span>Print</a>
                                    <?php endif ?>
                                </div>
                                <div class="col-md-6"></div>

                            </div>

                        </div>
                        <form name="frm_sptpd" method="post" action="">
                            <div class="panel-body listform">
                                <table class="table table-bordered table-hover">
                                    <tr class="tblhead">
                                        <td width="1">No</td>
                                        <td style="width: 70px;">Tanggal</td>
                                        <td style="width: 150px;">NOP</td>
                                        <td style="width: 150px;">Nama WP</td>
                                        <td style="width: 170px;">Payment Point</td>
                                        <td width="3">Jumlah Setor</td>
                                    </tr>
                                    <?php
                                    $i         = 1;
                                    $l         = 0;
                                    $sub_total = 0;
                                    foreach ($sptpds as $sptpd) :
                                    ?>
                                        <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                    else : echo "#F5F5F5";
                                                                    endif; ?>">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $this->antclass->fix_date($sptpd->tanggal); ?></td>
                                            <td>
                                                <?= $sptpd->kd_propinsi; ?>.<?= $sptpd->kd_kabupaten; ?>.<?= $sptpd->kd_kecamatan; ?>.<?= $sptpd->kd_kelurahan; ?>.<?= $sptpd->kd_blok; ?>.<?= $sptpd->no_urut; ?>.<?= $sptpd->kd_jns_op; ?>
                                            </td>
                                            <td>
                                                <?php

                                                $nik = $this->mod_nik->get_nik($sptpd->nik);
                                                echo @$nik->nama;


                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($sptpd->is_lunas == '1') {
                                                    echo 'Lunas';
                                                } else {
                                                    if ($sptpd->jumlah_setor == '0') {
                                                        echo 'Tidak Kena Pajak';
                                                    } else {
                                                        echo 'Belum Lunas';
                                                    }
                                                }
                                                //if (empty($sptpd->id_bank)) {echo 'Belum Lunas';} else {
                                                //echo getNamaBank($sptpd->id_bank, 'nama');
                                                //}
                                                ?>
                                            </td>
                                            <td>
                                                <div style="float: left;">Rp. </div>
                                                <div style="float: right;"><?php echo number_format($sptpd->jumlah_setor, 0, ',', '.'); ?></div>
                                                <div style="clear: both;"></div>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                        $l++;
                                        $sub_total += $sptpd->jumlah_setor;
                                    endforeach;
                                    ?>
                                    <tr>
                                        <td colspan="5" align="right"> Sub Total: </td>
                                        <td>
                                            <div style="float: left;">Rp. </div>
                                            <div style="float: right;"><?php echo number_format($sub_total, 0, ',', '.'); ?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right"> Jumlah Keseluruhan: </td>
                                        <td>
                                            <div style="float: left;">Rp. </div>
                                            <div style="float: right;"><?php echo number_format($sum_jumlah_setor->grand_total, 0, ',', '.'); ?></div>
                                        </td>
                                    </tr>
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


<script type="text/javascript" src="<?= base_url() ?>assets/template/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
    function print() {

    }
</script>