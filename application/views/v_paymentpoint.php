 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-arrow-circle-o-left"></span>Payment Point</h2>
 </div>
 <!-- END PAGE TITLE -->
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
                         <div class="col-md-6">
                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                             <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                         </div>
                         <div class="col-md-6">
                         </div>
                     </div>

                 </div>

                 <div class="panel-body">
                     <div class="col-md-12 pencarian">
                         <form action="<?= site_url('paymentpoint/index') ?>" method="GET">
                             <?php
                                $id_ppat = $this->input->get('id_pp');
                                $nama = $this->input->get('nama');
                                $alamat = $this->input->get('alamat');
                                ?>
                             <div class="col-md-2">
                             </div>
                             <div class="col-md-3">
                                 <input type="text" class="form-control pull-right tulisan" name="id_pp" placeholder="Masukan No ID" value="<?= $id_ppat ?>">
                             </div>
                             <div class="col-md-3">
                                 <input type="text" class="form-control pull-right tulisan" name="nama" placeholder="Masukan Nama" value="<?= $nama ?>">
                             </div>
                             <div class="col-md-3">
                                 <input type="text" class="form-control pull-right tulisan" name="alamat" placeholder="Masukan Nama Alamat" value="<?= $alamat ?>">
                             </div>
                             <div class="col-md-1">
                                 <button type="submit" class="btn btn-info pull-right tombol" name="cari">Cari</button>
                             </div>
                         </form>
                     </div><br><br><br><br><br>
                     <?php if (!$paymentpoints) : ?>
                         <table class="table table-bordered table-hover">
                             <thead>
                                 <tr>
                                     <td width="1">No.</td>
                                     <td style="width: 155px;">ID paymentpoint</td>
                                     <td style="width:380px;">Nama</td>
                                     <td style="width:800px;">Alamat</td>
                                     <td style="width: 170px;">
                                         <center>Action</center>
                                     </td>
                                 </tr>
                             </thead>
                             <tbody bgcolor="#E5E5E5">
                                 <td colspan="5">
                                     <center>-- Data Payment Point Tidak Ada --</center>
                                 </td>
                             </tbody>
                         </table>


                     <?php else : ?>
                         <form name="frm_paymentpoint" method="post" action="">
                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                         <td style="width: 155px;">ID paymentpoint</td>
                                         <td>Nama</td>
                                         <td>Alamat</td>
                                         <!--  <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 45px;"><center>Blokir</center></td> -->
                                         <td style="width: 170px;">
                                             <center>Action</center>
                                         </td><?php endif; ?>
                                     </tr>
                                 </thead>
                                 <?php
                                    $i = 1;
                                    $l = 0;
                                    foreach ($paymentpoints as $paymentpoint) :
                                    ?>
                                     <tbody>
                                         <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                             <td width="1"><?php echo $start + $i; ?></td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $paymentpoint->id_pp; ?>/<?php echo $paymentpoint->id_user; ?>" /> </td><?php endif; ?>
                                             <td>
                                                 <center><?php echo $paymentpoint->id_pp; ?></center>
                                             </td>
                                             <td style="width:380px;"><?php echo $paymentpoint->nama; ?></td>
                                             <td style="width:800px;">
                                                 <?php echo $paymentpoint->alamat; ?><br />
                                                 Telepon: <?php echo $paymentpoint->telepon; ?><br />
                                                 Nama Kepala: <?php echo $paymentpoint->nama_kepala; ?>
                                             </td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                 <!-- <td align="center">
                                                    <?php if ($paymentpoint->is_blokir == '1') : ?>
                                                        <a href="<?php echo $c_loc; ?>/status/<?php echo $paymentpoint->id_pp; ?>" class="btn btn-info btn-sm" title="Blokir" alt="Blokir" /><i class="fa fa-check"></i></a>
                                                    <?php else : ?>
                                                        <a href="<?php echo $c_loc; ?>/status/<?php echo $paymentpoint->id_pp; ?>" class="btn btn-danger btn-sm" title="Non Blokir" alt="Non Blokir" /><i class="fa fa-ban"></i></a>
                                                    <?php endif; ?>
                                                </td> -->
                                                 <td style="width:140px;">
                                                     <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>index.php/paymentpoint/edit/<?php echo $paymentpoint->id_pp; ?>/<?php echo $paymentpoint->id_user; ?>" title="Edit" alt="Edit" /><i class="fa fa-pencil"></i></a>
                                                     <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/paymentpoint/delete/<?php echo $paymentpoint->id_pp; ?>/<?php echo $paymentpoint->id_user; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($paymentpoint->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
                                                 </td>
                                             <?php endif; ?>
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
                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                 <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = true;"><span class="fa fa-check"></span>Check All</a> -
                                 <a class="btn btn-default" href="#" onclick="for (k = 0; k < <?php echo $l; ?>; k++) document.getElementById('id'+k).checked = false;"><span class="fa fa fa-check-square-o"></span>Uncheck All</a>
                                 - with selected :
                                 <button class="multi_submit btn btn-danger" type="submit" name="submit_multi" value="delete" title="Delete" onclick="return confirm('Are you sure to delete these records status?')"><span class="fa fa-trash-o"></span>
                                 </button>
                             <?php endif; ?>


                         </div>
                         <div class="col-md-offset-1 col-md-5">
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

 <style type="text/css">
     .tulisan {
         margin: 3px;
         margin-top: 20px;
     }

     .col-md-12.pencarian {
         padding-right: 0px;
         padding-left: 0px;
     }

     .tombol {
         margin: 3px;
         margin-top: 20px;
     }
 </style>