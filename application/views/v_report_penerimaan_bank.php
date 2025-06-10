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
    <h2><span class="fa fa-arrow-circle-o-left"></span> LAPORAN PENERIMAAN BANK</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="row">
                        <form action="" method="post" class="form-horizontal">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6" style="margin-bottom:20px;">
                                        <div class="col-md-5">
                                            <center>
                                                <h5>Tanggal Awal</h5>
                                            </center><br>
                                            <center>
                                                <h5>Tanggal Akhir</h5>
                                            </center><br>
                                            <center>
                                                <h5>Bank</h5>
                                            </center>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input id="datepicker" type="text" name="tgl_awal" class="form-control" value="<?= $this->input->get_post('tgl_awal') ?>" />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <center>
                                                <h6><span class="fa fa-arrow-down" style="opacity:0;"></span></h6>
                                            </center>
                                            <div class="input-group">
                                                <input id="datepicker2" type="text" name="tgl_akhir" class="form-control" value="<?= $this->input->get_post('tgl_akhir') ?>" />
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <center>
                                                <h6><span class="fa fa-arrow-down" style="opacity:0;"></span></h6>
                                            </center>
                                            <div class="input-group">
                                                <select name="bank" class="form-control select2">
                                                    <option value="">-- Semua Bank --</option>
                                                    <?php foreach ($bank as $key => $value) : ?>
                                                        <option value="<?= $value->id_pp ?>" <?= ($value->id_pp == $this->input->get_post('bank')) ? 'selected' : ''; ?>><?= $value->nama ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-left:241px; margin-top:20px; margin-bottom:20px;">
                                    <input type="submit" name="search_submit" value="Cari" class="btn btn-success" />
                                    <a href="<?= site_url($this->c_loc . '/cetakPenerimaan') ?>" class="btn btn-info">Print</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="1">NO</th>
                                <th>TANGGAL</th>
                                <th>NOP</th>
                                <th>PENJUAL</th>
                                <th>ALAMAT PENJUAL</th>
                                <th>PEMBELI</th>
                                <th>ALAMAT PEMBELI</th>
                                <th>NO SERTIFIKAT</th>
                                <th>JUMLAH BAYAR</th>
                                <th>BANK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($laporan as $key => $value) : ?>
                                <?php
                                $nop = $value->kd_propinsi . '.' . $value->kd_kabupaten . '.' . $value->kd_kecamatan . '.' . $value->kd_kelurahan . '.' . $value->kd_blok . '.' . $value->no_urut . '.' . $value->kd_jns_op;
                                ?>
                                <tr>
                                    <td widtd="1"><?= $start++; ?></td>
                                    <td><?= tanggalIndo($value->tanggal) ?></td>
                                    <td><?= $nop ?></td>
                                    <td><?= $value->nama_penjual ?></td>
                                    <td><?= $value->alamat_penjual ?></td>
                                    <td><?= $value->nama_pembeli ?></td>
                                    <td><?= $value->alamat_pembeli ?></td>
                                    <td><?= $value->no_sertifikat_op ?></td>
                                    <td><?= number_format($value->jumlah_setor, 0, ',', '.') ?></td>
                                    <td><?= $value->nama_bank ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- PAGINATION BELUM -->
                            <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE TITLE -->

<script type="text/javascript">
    $('#datepick input').datepicker({});
</script>

<script type="text/javascript" src="<?= base_url() ?>assets/template/js/bootstrap-datepicker.js"></script>