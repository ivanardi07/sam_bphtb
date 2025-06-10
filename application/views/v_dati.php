 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-arrow-circle-o-left"></span> KABUPATEN</h2>
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
                 <div class="col-md-6">

                 </div>
                 <div class="col-md-6">
                     <form action="<?= site_url('dati/index') ?>" method="GET">

                         <div class="col-md-5">

                             <select class="form-control pull-right tulisan select2" name="propinsi">
                                 <option value="">-- Pilih Propinsi --</option>
                                 <?php foreach ($propinsis as $propinsi) : ?>
                                     <option value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
                                 <?php endforeach; ?>
                             </select>
                         </div>
                         <div class="col-md-5">
                             <input type="text" class="form-control pull-right tulisan" name="kabupaten" placeholder="Nama Kabupaten" value="<?php echo @$_GET['kabupaten']; ?>">
                         </div>
                         <div class="col-md-2">
                             <input type="submit" class="btn btn-info pull-right tombol" value="Cari">
                         </div>
                     </form>
                 </div>

                 <form name="frm_dati" method="post" action="">
                     <div class="panel-body">
                         <?php if (!$datis) : echo 'Data Distrik kosong.';
                            else : ?>
                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                         <td>Kode</td>
                                         <td>Nama Kabupaten</td>
                                         <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td width="120">Action</td><?php endif; ?>
                                     </tr>
                                 </thead>
                                 <?php
                                    $i = 1;
                                    $l = 0;
                                    foreach ($datis as $dati) :
                                    ?>
                                     <tbody>
                                         <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                             <td width="5"><?php echo $start + $i; ?></td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td width="5"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $dati->kd_kabupaten . '/' . $dati->kd_propinsi; ?>" /> </td><?php endif; ?>
                                             <td><?php echo $dati->kd_kabupaten; ?></td>
                                             <td><?php echo $dati->nama; ?></td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                 <td>
                                                     <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>index.php/dati/edit/<?php echo $dati->kd_kabupaten . '/' . $dati->kd_propinsi; ?>"><i class="fa fa-pencil"></i></a>
                                                     <?php /* 
                                                        $check_dati = $this->mod_nik->check_dati($dati->kd_kabupaten);
                                                        $check_dati_nop = $this->mod_nop->check_dati($dati->kd_kabupaten);
                                                        if( ! $check_dati && ! $check_dati_nop): */
                                                        ?>
                                                     <!-- start -->
                                                     <?php
                                                        $lokasi = $dati->kd_kabupaten . '.' . $dati->kd_propinsi;
                                                        if (cek_data_lokasi($lokasi, 'kabupaten') == 'kosong') {
                                                        ?>
                                                         <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/dati/delete/<?php echo $dati->kd_kabupaten . '/' . $dati->kd_propinsi; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($dati->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i></a>
                                                     <?php
                                                        } ?>
                                                     <!-- end -->


                                                     <?php //endif; 
                                                        ?>
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
                             <div class="col-md-offset-2 col-md-4">
                                 <!-- PAGINATION BELUM -->
                                 <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>

                             </div>
                         </div>
                     </div>
                 </form>
             </div </div>

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