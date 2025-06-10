 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-arrow-circle-o-left"></span> DAFTAR SSPD LAMA</h2>
 </div>
 <!-- END PAGE TITLE -->
 <div class="page-content-wrap">
     <?php if (!empty($info)) {
            echo $info;
        } ?>
     <div class="row">
         <div class="col-md-12">
             <div class="panel panel-default">
                 <div class="panel-heading">

                     <div class="row">
                         <div class="col-md-6">

                             <a class="btn btn-default" href="<?php echo $this->c_loc . '/reset'; ?>">
                                 <span class="fa fa-refresh"></span>Refresh Data
                             </a>
                         </div>
                         <div class="col-md-6">

                         </div>
                     </div>
                 </div>
                 <div class="col-md-6">
                 </div>
                 <div class="col-md-6">
                     <form action="<?= $this->c_loc ?>" method="POST">
                         <div class="col-md-2 pull-right">
                             <input type="submit" class="btn btn-info tombol" value="Cari">
                         </div>
                         <div class="col-md-10">
                             <input type="text" class="form-control pull-right tulisan" name="cari" placeholder="Nama WP" value="<?php echo $this->session->userdata('cari'); ?>">
                         </div>
                     </form>
                 </div>
                 <div class="panel-body">
                     <?php if (!@$sptpd) : echo 'Data SPTPD kosong.';
                        else : ?>
                         <!-- <pre><?php print_r($sptpd); ?></pre> -->
                         <table class="table table-bordered table-hover">
                             <thead>
                                 <tr>
                                     <td><b>Tanggal</b></td>
                                     <td><b>Nomor Pelayanan</b></td>
                                     <td><b>Nomor</b></td>
                                     <td><b>Nama WP</b></td>
                                     <td><b>Jumlah Setor</b></td>
                                     <td><b>Detail</b></td>
                                 </tr>
                             </thead>

                             <tbody>
                                 <?php
                                    foreach ($sptpd as $sptpd) :
                                    ?>
                                     <tr>
                                         <td><?php echo tanggalIndo($sptpd->Tgl); ?></td>
                                         <td><?php echo $sptpd->NoPel; ?></td>
                                         <td><?php echo $sptpd->nomor; ?></td>
                                         <td><?php echo $sptpd->namawp; ?></td>
                                         <td>Rp. <?php echo number_format($sptpd->JumlahSetoran, 0, ".", "."); ?></td>
                                         <td><a href="<?= site_url('daftar_sptpd_lama/detail/' . $sptpd->Id) ?>" class="btn btn-xs btn-success">Detail</a></td>
                                     </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>
                 </div>
                 <div class="panel-footer">
                     <div class="row">
                         <div class="col-md-12">
                             <!-- PAGINATION BELUM -->
                             <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $paging; ?></div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <?php endif; ?>

 <style type="text/css">
     .tulisan {
         margin: 3px;
         margin-top: 20px;
     }

     .tombol {
         margin: 3px;
         margin-top: 20px;
     }
 </style>