 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-arrow-circle-o-left"></span> DAFTAR SSPD BANK</h2>
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

                             <a class="btn btn-default" href="<?php echo $c_loc; ?>">
                                 <span class="fa fa-refresh"></span>Refresh Data
                             </a>
                         </div>
                         <div class="col-md-6">

                         </div>
                     </div>
                 </div>
                 <div class="col-md-4">
                 </div>
                 <div class="col-md-8">
                     <form action="<?= site_url('daftar_sptpd_bank/index') ?>" method="GET">
                         <div class="col-md-2 pull-right">
                             <input type="submit" class="btn btn-info tombol" value="Cari">
                         </div>
                         <div class="col-md-4">
                             <input type="text" class="form-control pull-right tulisan" name="cari" placeholder="Masukan NOP" value="<?php echo @$_GET['cari']; ?>">
                         </div>
                         <div class="col-md-2"><span class="form-control pull-right tulisan text-center" style="border-color: transparent;">ATAU</span></div>
                         <div class="col-md-4">
                             <input type="text" class="form-control pull-right tulisan" name="cari_dokumen" placeholder="Masukan NO SSPD" value="<?php echo @$_GET['cari_dokumen']; ?>">
                         </div>
                     </form>
                 </div>

                 <form name="frm_pegawai" method="post" action="">

                     <div class="panel-body">

                         <?php if (!@$sptpd) : echo 'Data SPTPD kosong.';
                            else : ?>
                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <td>No</td>
                                         <td>Tanggal Pembuatan</td>
                                         <td>Tanggal Validasi Bank</td>
                                         <td>NOP</td>
                                         <td>No Dokumen SSPD</td>
                                         <td>Jumlah Setor</td>

                                     </tr>
                                 </thead>

                                 <tbody>
                                     <?php
                                        $i = 1;
                                        $l = 0;
                                        $total = 0;

                                        foreach ($sptpd as $sptpd) :

                                            $total = $total + $sptpd->jumlah_setor;
                                        ?>
                                         <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                             <td width="5"><?php echo $start + $i; ?></td>

                                             <td><?php echo changeDateFormat('webview', $sptpd->tanggal); ?></td>
                                             <td><?php echo changeDateFormat('webview', $sptpd->tgl_validasi_bank); ?></td>
                                             <td><?php echo $sptpd->kd_propinsi; ?>.<?php echo $sptpd->kd_kabupaten; ?>.<?php echo $sptpd->kd_kecamatan; ?>.<?php echo $sptpd->kd_kelurahan; ?>.<?php echo $sptpd->kd_blok; ?>.<?php echo $sptpd->no_urut; ?>.<?php echo $sptpd->kd_jns_op; ?></td>
                                             <td><?php echo $sptpd->no_dokumen; ?></td>
                                             <td>Rp. <?php echo number_format($sptpd->jumlah_setor, 0, ".", "."); ?></td>
                                             <?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>

                                             <?php endif; ?>
                                         </tr>
                                     <?php $i++;
                                            $l++;
                                        endforeach; ?>
                                     <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                    else : echo "#F5F5F5";
                                                    endif; ?>">
                                         <td colspan="5" align="right"><b>Sub Total</b></td>
                                         <td><b>Rp. <?= number_format($total); ?></b></td>
                                     </tr>
                                     <?php if ($tipe_user == 'PT') : ?>
                                         <tr bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                        else : echo "#F5F5F5";
                                                        endif; ?>">
                                             <td colspan="5" align="right"><b>Grand Total</b></td>
                                             <td><b>Rp. <?php echo number_format(@$sum_jumlah_setor->grand_total); ?></b></td>
                                         </tr>
                                     <?php endif ?>

                                 </tbody>


                             </table>
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