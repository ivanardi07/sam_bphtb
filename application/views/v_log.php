 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE TITLE -->
 <div class="page-title">
     <h2><span class="fa fa-arrow-circle-o-left"></span> Laporan Login User</h2>
 </div>
 <!-- END PAGE TITLE -->
 <div class="page-content-wrap">
     <?php if (!empty($info)) {
            echo $info;
        } ?>
     <?php if (!$logs) : echo 'Data Log kosong.';
        else : ?>
         <div class="row">
             <div class="col-md-12">
                 <div class="panel panel-default">
                     <div class="panel-heading">

                         <div class="row">
                             <div class="col-md-6">
                                 <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                             </div>
                             <div class="col-md-6"></div>

                         </div>

                     </div>
                     <form name="frm_log" method="post" action="">
                         <div class="panel-body">
                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <td style="width: 12px;">No</td>
                                         <td style="width: 80px;">Tanggal</td>
                                         <td style="width: 145px;">ID Log</td>
                                         <td style="width: 80px;">User</td>
                                         <td style="width: 250px;">Activity</td>
                                         <td style="width: 100px;">IP</td>
                                     </tr>
                                 </thead>
                                 <?php
                                    $i = 1;
                                    $l = 0;
                                    foreach ($logs as $log) :
                                    ?>
                                     <tbody>
                                         <tr class="tblhov" bgcolor="<?php if ($i % 2) : echo "#E5E5E5";
                                                                        else : echo "#F5F5F5";
                                                                        endif; ?>">
                                             <td><?php echo $start + $i; ?></td>
                                             <td align="center"><?php echo $this->antclass->fix_datetime($log->date_log); ?></td>
                                             <td><?php echo $log->id_log; ?></td>
                                             <td><?php echo $log->login_user; ?></td>
                                             <td>
                                                 <?php
                                                    $pos_log = strpos($log->query_log, 'Login');
                                                    if ($pos_log !== FALSE) {
                                                        echo 'Login(ID Log: ' . substr($log->query_log, 8, 20) . ')';
                                                    } else {
                                                        $pos_log = strpos($log->query_log, 'Logout');
                                                        if ($pos_log !== FALSE) {
                                                            echo 'Logout(ID Log: ' . substr($log->query_log, 8, 20) . ') ';
                                                        }
                                                    }
                                                    ?>
                                             </td>
                                             <td><?php echo $log->ip_log; ?></td>
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
                                 <div class="col-md-offset-1 col-md-5">
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