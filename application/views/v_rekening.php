 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-arrow-circle-o-left"></span>Rekening</h2>
 </div>
 <!-- END PAGE TITLE -->
 <div class="page-content-wrap">

     <div class="row">
         <div class="col-md-12">
             <div class="panel panel-default">
                 <div class='col-md-12'>
                     <?= $this->session->flashdata('flash_message'); ?>
                     <?php if (!empty($info)) {
                            echo $info;
                        } ?>
                 </div>
                 <div class="panel-heading">

                     <div class="row">
                         <div class="col-md-6">
                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><a class="btn btn-info" href="<?php echo $c_loc; ?>/add"><span class="fa fa-plus"></span>Tambah</a><?php endif; ?>
                             <a class="btn btn-default" href="<?php echo $c_loc; ?>" name="reset" value="reset"><span class="fa fa-refresh"></span>Refresh Data</a>
                         </div>
                         <div class='col-md-6'></div>

                     </div>

                 </div>
                 <div class='col-md-6'>

                 </div>
                 <div class='col-md-6'>
                     <form class="" action="" method="post">
                         <div class="form-group">
                             <div class='col-md-4'>
                             </div>
                             <div class="col-md-6">
                                 <input class="form-control tulisan" id="nama" type="text" placeholder='Masukkan Nama' name="txt_nama" value="<?php echo @$search['nama'];  ?>" />
                             </div>

                             <div class="col-md-2 text-center">
                                 <input class="btn btn-info tombol" type="submit" value="Cari" name="search" />&nbsp;
                             </div>
                         </div>
                     </form>
                 </div>
                 <?php if (!$rekenings) : echo 'Data Rekening kosong.';
                    else : ?>
                     <form name="frm_rekening" method="post" action="">
                         <div class="panel-body">
                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <td colspan="<?php echo ($this->session->userdata('s_tipe_bphtb') == 'D') ? 2 : 1; ?>">No</td>
                                         <td>Nama Bank</td>
                                         <td>Nomor Rekening</td>
                                         <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?> <td>Action</td><?php endif; ?>
                                     </tr>
                                     <thead>
                                         <?php
                                            $i = 1;
                                            $l = 0;
                                            foreach ($rekenings as $rekening) :
                                            ?>
                                     <tbody>
                                         <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                             <td width="1"><?php echo $start + $i; ?></td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?><td style="width: 13px;"> <input type="checkbox" name="check[]" id="id<?php echo $l; ?>" value="<?php echo $rekening->id_rekening; ?>" /> </td><?php endif; ?>
                                             <td width="180"><?php echo $rekening->nama; ?></td>
                                             <td><?php echo $rekening->nomor; ?></td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
                                                 <td width="130">
                                                     <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/rekening/edit/<?php echo $rekening->id_rekening; ?>" title="Edit" alt="Edit" /><i class="fa fa-pencil"></i></a>
                                                     <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/rekening/delete/<?php echo $rekening->id_rekening; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($rekening->nama); ?>&quot;?')"><i class="fa fa-trash-o"></i> </a>
                                                 </td>
                                             <?php endif; ?>
                                         </tr>
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

     .tombol {
         margin: 3px;
         margin-top: 20px;
     }
 </style>