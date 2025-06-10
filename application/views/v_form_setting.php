 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrap">

     <div class="row">
         <div class="col-md-12">

             <form class="form-horizontal" name="frm_rekening" method="post" action="">
                 <div class="panel panel-default">
                     <div class="panel-heading">
                         <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">Setting</a> &raquo; <?php echo $submitvalue; ?></h3>

                         <ul class="panel-controls">
                             <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                         </ul>
                     </div>
                     <div class="panel-body">
                         <a class="btn btn-default" href="<?= base_url() . 'index.php/setting' ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                         <?php if (!empty($info)) {
                                echo $info;
                            } ?>
                     </div>
                     <div class="panel-body">

                         <?php if (@$user->tipe == 'D') : ?>
                             <!-- DISPENDA -->
                             <div class="form-group ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Id Dispenda</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="id_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_dispenda, 'id_dispenda'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                                            } ?> class="form-control id_input" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Dispenda</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_dispenda'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat Dispenda</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_dispenda'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat Dispenda</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_dispenda'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                         <?php endif ?>


                         <?php if (@$user->tipe == 'PT') : ?>
                             <!-- PPAT -->
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Id PPAT</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="id_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_ppat, 'id_ppat'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                                } ?> class="form-control id_input" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama PPAT</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_ppat'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat PPAT</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_ppat'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                         <?php endif ?>

                         <?php if (@$user->tipe == 'PP') : ?>
                             <!-- PAYMENT POINT -->
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Id Payment Point</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="id_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_pp, 'id_pp'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                            echo 'disabled="disabled"';
                                                                                                                                                                                                        } ?> class="form-control id_input" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Payment Point</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_pp'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat Payment Point</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_pp'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Kepala</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_kepala_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_kepala, 'nama_kepala_pp'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Telepon</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="telp_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->telepon, 'telp_pp'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                         <?php endif ?>
                         <?php if (@$user->tipe == 'KPP') : ?>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Id BPN / KPP</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="id_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_kpp, 'id_kpp'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                echo 'disabled="disabled"';
                                                                                                                                                                                                            } ?> class="form-control id_input" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_kpp, 'nama_kpp'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat_kpp, 'alamat_kpp'); ?>" class="form-control" readonly />
                                     </div>

                                 </div>
                             </div>
                         <?php endif; ?>

                         <br>
                         <br>
                         <div class="form-group pt_id">
                             <label class="col-md-3 col-xs-12 control-label">Atur Masa Login</label>
                             <div class="col-md-4 col-xs-12">

                                 <select name="" class="form-control">
                                     <option value="">--Pilih--</option>
                                     <option value="3600">1 Jam</option>
                                     <option value="7200">2 Jam</option>
                                     <option value="10800">3 Jam</option>
                                     <option value="14400">4 Jam</option>

                                 </select>

                             </div>
                         </div>

                     </div>
                     <div class="panel-footer">
                         <input type="submit" name="submit" value="<?php echo $submitvalue; ?>" class="btn btn-primary " />
                         <input type="reset" name="reset" value="Reset" class="btn btn-default" />
                         <input type="hidden" name="h_rec_id" value="<?php echo $rec_id; ?>" />

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