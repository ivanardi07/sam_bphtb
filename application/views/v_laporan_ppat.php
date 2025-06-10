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
    <h2><span class="fa fa-arrow-circle-o-left"></span> Laporan SSPD - BPHTB</h2>
</div>
<!-- END PAGE TITLE -->
<div class="page-content-wrap">
    <div class="col-md-12" style="margin-bottom: 10px;">

        <form name="frm_sptpd" method="post" action="">
            <div class="panel-body">
                <?php if (!$hr) : echo 'Data SPTPD kosong.';
                else : ?>
                    <table class="table table-bordered table-hover">
                        <tr class="tblhead">
                            <td width="1">No</td>
                            <td style="width: 140px;">No Pelayanan</td>
                            <td style="width: 150px;">No SSPD</td>
                            <td style="width: 50px;">Nama WP</td>
                            <td style="width: 150px;">Alamat OP</td>
                            <td style="width: 70px;">Jumlah Setor</td>
                            <td style="width: 55px;">tanggal</td>
                            <!-- <td style="width: 45px;">Action</td> -->
                        </tr>
                        <?php
                        $i         = 1;
                        $l         = 0;
                        $sub_total = 0;
                        foreach ($hr as $sptpd) :
                        ?>
                            <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                <td><?php echo $start + $i; ?></td>
                                <td><?php echo $sptpd->no_pelayanan; ?></td>
                                <td><?php echo $sptpd->no_dokumen; ?><?php echo $page_link; ?></td>
                                <td>
                                    <?php
                                    $nik = $this->mod_nik->get_nik($sptpd->nik);
                                    echo @$nik->nama;
                                    ?>
                                </td>
                                <td>kel <?php echo @$nop_nm_kelurahan; ?> Kec <?php echo @$nop_nm_kecamatan; ?> <?php echo @$nop_nm_kabupaten; ?> <?php echo @$nop_nm_propinsi; ?></td>
                                <td>
                                    <div style="float: right;">Rp. <?php echo number_format($sptpd->jumlah_setor, 0, ',', '.'); ?></div>
                                </td>
                                <td>
                                    <div style="float: right;"><?php echo tgl_format_jam($sptpd->tanggal); ?></div>
                                </td>
                                <!--                                         <td align="center">
                                                <a class="btn btn-xs btn-success" target="_blank" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>"><span class="fa fa-print"></span></a>
                                                <?php if ($this->session->userdata('s_tipe_bphtb') == 'B') : if ($sptpd->is_lunas == '0') : ?>
                                                    <a href="<?php echo base_url(); ?>index.php/sptpd/setlunas/<?php echo $sptpd->id_sptpd . '/' . $sptpd->no_dokumen; ?>"><img src="<?php echo base_url_img(); ?>lunas.png" title="Set Lunas" alt="Set Lunas" /></a>
                                                    <?php endif;
                                                endif; ?>
                                            </td> -->
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