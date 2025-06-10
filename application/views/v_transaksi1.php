<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $akses = $this->session->userdata('s_tipe_bphtb');
$type = $this->session->userdata('s_tipe_bphtb'); ?>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> TRANSAKSI</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="col-md-12">
                    <?php if (!empty($info)) {
                        echo $info;
                    } ?>
                </div>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <form class="form-inline pull-left" action="" method="post" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control tanggal" name="txt_search_dstart" placeholder="Tanggal awal" value="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control tanggal" name="txt_search_dstop" placeholder="Tanggal akhir" value="">
                            </div>
                            <?php if ($type == "D") { ?>
                                <div class="form-group">
                                    <select name="ppat" class="form-control select2-c">
                                        <option value="">--Pilih PPAT--</option>
                                        <?php foreach ($ppat as $val) { ?>
                                            <option value="<?= $val->id_ppat ?>"><?= $val->nama ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } else {
                            } ?>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info" value="Cari" name="search" />
                            </div>
                        </form>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <?php if (!$sptpds) : echo 'Data SSPD kosong.';
                        else : ?>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <form name="frm_sptpd" method="post" action="">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tblhead">
                                        <th>No</th>
                                        <th style="width: 100px;">Tanggal</th>
                                        <th style="width: 65px;">No Pelayanan</th>
                                        <th>NOP</th>
                                        <th style="width: 160px;">Nama</th>
                                        <th>No. SSPD</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($sptpds as $sptpd) :
                                ?>
                                    <tbody>
                                        <tr class="tblhov">
                                            <td><?php echo $start + $i; ?></td>
                                            <td><?php echo $sptpd->tanggal; ?></td>
                                            <td><?php echo $sptpd->no_pelayanan; ?></td>
                                            <td><?= $sptpd->kd_propinsi; ?>.<?= $sptpd->kd_kabupaten; ?>.<?= $sptpd->kd_kecamatan; ?>.<?= $sptpd->kd_kelurahan; ?>.<?= $sptpd->kd_blok; ?>.<?= $sptpd->no_urut; ?>.<?= $sptpd->kd_jns_op; ?></td>
                                            <td>

                                                <?php

                                                $nik = $this->mod_nik->get_nik($sptpd->nik);
                                                echo @$nik->nama;


                                                ?>
                                            </td>
                                            <td><?php echo $sptpd->no_dokumen; ?></td>

                                            <td>
                                                <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/lihat_transaksi/<?php echo $sptpd->id_sptpd; ?>" target="_blank">Transaksi</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                                    $i++;
                                    $l++;
                                endforeach; ?>
                            </table>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-offset-8 col-md-4">
                                <!-- PAGINATION BELUM -->
                                <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail</h4>
                </div>
                <div class="modal-body" id="detail_rejek">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="ini_di_print">
    </div>

    <script src="<?= base_url() . 'assets/scripts/jquery.print/jquery.print.js' ?>"></script>

    <script>
        function cetak_buktipendaftaran(id_sptpd) {
            $.ajax({
                    url: "<?= site_url('sptpd/cetak_buktipendaftaran') ?>",
                    type: 'POST',
                    data: {
                        id: id_sptpd
                    },
                })
                .done(function(ress) {
                    $('#ini_di_print').html(ress);
                    $.print("#ini_di_print");
                    $('#ini_di_print').html(' ');
                });


        }

        function detail(id_sptpd) {
            $.ajax({
                    type: 'POST',
                    url: "<?= site_url('sptpd/detail_rejek') ?>",
                    data: {
                        id_sptpd: id_sptpd
                    }
                })
                .done(function(ress) {
                    $('#detail_rejek').html(ress);
                });
        }
    </script>