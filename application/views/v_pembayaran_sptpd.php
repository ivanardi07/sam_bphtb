<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> <?php echo $title; ?></h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $this->session->flashdata('info'); ?>
                    <div class="col-md-12">
                        <form action="<?= site_url('kelurahan'); ?>" method="get" role="form">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3">
                                <input type="text" placeholder="Nomor Dokumen" name="cari" class="form-control">
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Cari" class="btn btn-default">
                            </div>
                        </form>
                    </div>

                </div>
                <div class="listform">
                    <form name="frm_kelurahan" method="post" action="">
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tblhead">
                                        <th colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</th>
                                        <th style="width: 100px;">Kode</th>
                                        <th style="width: 225px;">Nama Kecamatan</th>
                                        <th style="width: 225px;">Nama Kelurahan</th>

                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($data_pembayaran as $key) :
                                ?>
                                    <tbody>
                                        <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                    else : echo "#F5F5F5";
                                                                    endif; ?>">
                                            <td width="40px"><?php echo $start + $i; ?></td>
                                            <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $kelurahan->kd_propinsi . '.' . $kelurahan->kd_kabupaten . '.' . $kelurahan->kd_kecamatan . '.' . $kelurahan->kd_kelurahan; ?>" /> </td> <?php endif; ?>
                                            <td><?php echo $kelurahan->kd_kelurahan; ?></td>
                                            <td>
                                                <?php
                                                echo $kelurahan->nama_kecamatan;
                                                ?>
                                            </td>
                                            <td><?php echo $kelurahan->nama; ?></td>

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

                                </div>
                                <div class="col-md-offset-2 col-md-4">
                                    <div class="dataTables_paginate paging_bootstrap pagination"><?php echo @$page_link; ?></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>