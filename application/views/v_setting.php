 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrap">

     <div class="row">
         <div class="col-md-12">

             <form class="form-horizontal" method="post" action="<?= base_url() . 'index.php/setting/action' ?>">
                 <div class="panel panel-default">
                     <div class="panel-heading">
                         <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Setting Session</a></h3>

                         <ul class="panel-controls">
                             <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                         </ul>
                     </div>
                     <div class="panel-body">
                         <?php if (!empty($info)) {
                                echo $info;
                            } ?>
                     </div>
                     <div class="panel-body">


                         <br>
                         <br>
                         <div class="form-group pt_id">
                             <label class="col-md-3 col-xs-12 control-label">Atur Masa Login</label>
                             <div class="col-md-4 col-xs-12">

                                 <select name="session_cut" class="form-control">
                                     <option value="">--Pilih--</option>
                                     <option value="3600" <?= @$durasi->session_cut == 3600 ? 'selected' : '' ?>>1 Jam</option>
                                     <option value="7200" <?= @$durasi->session_cut == 7200 ? 'selected' : '' ?>>2 Jam</option>
                                     <option value="10800" <?= @$durasi->session_cut == 10800 ? 'selected' : '' ?>>3 Jam</option>
                                     <option value="14400" <?= @$durasi->session_cut == 14400 ? 'selected' : '' ?>>4 Jam</option>

                                 </select>

                             </div>
                         </div>

                     </div>
                     <div class="panel-footer">
                         <input type="submit" name="submit" value="Submit" class="btn btn-primary " />

                     </div>
                 </div>
             </form>

         </div>
     </div>

 </div>
 <!-- END PAGE CONTENT WRAPPER -->

 <script type='text/javascript' src='<?= base_url() ?>assets/template/js/plugins/icheck/icheck.min.js'></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-file-input.js"></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-select.js"></script>
 <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>

 <script type="text/javascript">
     jQuery(function($) {
         $(".id_input").mask("99999");
     });
 </script>