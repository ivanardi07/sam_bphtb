 <?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

 <!-- PAGE CONTENT WRAPPER -->
 <div class="page-content-wrap">

     <div class="row">
         <div class="col-md-12">

             <form class="form-horizontal" name="frm_rekening" method="post" action="">
                 <div class="panel panel-default">
                     <div class="panel-heading">
                         <h3 class="panel-title"><a href="<?php echo $c_loc; ?>">User</a> &raquo; <?php echo $submitvalue; ?></h3>

                         <ul class="panel-controls">
                             <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                         </ul>
                     </div>
                     <div class="panel-body">
                         <a class="btn btn-default" href="<?php echo $c_loc; ?>"><i class="fa fa-mail-reply"></i> Kembali</a>
                         <?php if (!empty($info)) {
                                echo $info;
                            } ?>
                     </div>
                     <div class="panel-body">
                         <div class="form-group">
                             <label class="col-md-3 col-xs-12 control-label">Username</label>
                             <div class="col-md-4 col-xs-12">
                                 <div class="input-group">
                                     <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                     <input type="text" name="txt_username_user" id="username_id" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(@$user->username, 'txt_username_user'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                                                        echo 'disabled="disabled"';
                                                                                                                                                                                                                                    } ?> class="form-control" />

                                 </div>

                             </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 col-xs-12 control-label">Password</label>
                             <div class="col-md-3 col-xs-12">
                                 <div class="input-group">
                                     <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                     <input type="password" name="password" style="width: 200px;" maxlength="50" value="" class="form-control" />
                                 </div>
                             </div>
                             <div class="col-md-4 col-xs-12"><b>* Isi jika ingin mengubah password</b></div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 col-xs-12 control-label">Ulangi Password</label>
                             <div class="col-md-3 col-xs-12">
                                 <div class="input-group">
                                     <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                     <input type="password" name="password_ulang" style="width: 200px;" maxlength="50" value="" class="form-control" />
                                 </div>
                             </div>
                             <div class="col-md-4 col-xs-12"><b>* Isi jika ingin mengubah password</b></div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 col-xs-12 control-label">Tipe</label>
                             <div class="col-md-4 col-xs-12">
                                 <div class="input-group">
                                     <span class="input-group-addon"><span class="fa fa-building"></span></span>
                                     <input type="text" name="txt_password2_user" style="width: 200px;" maxlength="50" class="form-control" readonly="readonly" value="<?php if (@$user->tipe == 'D') {
                                                                                                                                                                            echo "Bapenda";
                                                                                                                                                                        };
                                                                                                                                                                        if (@$user->tipe == 'PT') {
                                                                                                                                                                            echo "PPAT";
                                                                                                                                                                        };
                                                                                                                                                                        if (@$user->tipe == 'KPP') {
                                                                                                                                                                            echo "BPN / KPP";
                                                                                                                                                                        };
                                                                                                                                                                        if (@$user->tipe == 'PP') {
                                                                                                                                                                            echo "Payment Point";
                                                                                                                                                                        };
                                                                                                                                                                        if (@$user->tipe == 'WP') {
                                                                                                                                                                            echo "Wajib Pajak";
                                                                                                                                                                        };
                                                                                                                                                                        ?>" />
                                 </div>
                             </div>
                         </div>

                         <?php if (@$user->tipe == 'WP') : ?>
                             <!-- WP -->
                             <input type="hidden" name="id_wp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->id_wp, 'id_wp'); ?>" <?php if ($submitvalue == 'Edit') {
                                                                                                                                                                                                    echo 'disabled="disabled"';
                                                                                                                                                                                                } ?> class="form-control id_input" />

                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Wajib Pajak</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_wp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_wp'); ?>" class="form-control" />
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat Wajib Pajak</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_wp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_wp'); ?>" class="form-control" />
                                     </div>
                                 </div>
                             </div>
                         <?php endif ?>


                         <?php if (@$user->tipe == 'D') : ?>
                             <!-- DISPENDA -->
                             <div class="form-group ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Jabatan</label>
                                 <div class="col-md-2">
                                     <label class="check" for="pegawai">
                                         <input class="iradio" type="radio" id="pegawai" name="txt_jabatan" value="0" <?php if (@$user->jabatan == '0') {
                                                                                                                            echo "checked='checked'";
                                                                                                                        } ?> onclick="$('.jabatan').hide();"> Pegawai
                                     </label>
                                 </div>
                                 <?php //if($user->jabatan == 1) { 
                                    ?>
                                 <div class="col-md-2">
                                     <label class="check" for="kasi">
                                         <input class="iradio" type="radio" id="kasi" name="txt_jabatan" value="1" <?php if (@$user->jabatan == '1') {
                                                                                                                        echo "checked='checked'";
                                                                                                                    } ?> onclick="$('.jabatan').show();"> KASI
                                     </label>
                                 </div>
                                 <?php //} 
                                    ?>
                                 <?php //if($user->jabatan == 2) { 
                                    ?>
                                 <div class="col-md-2">
                                     <label class="check" for="kabid">
                                         <input class="iradio" type="radio" id="kabid" name="txt_jabatan" value="2" <?php if (@$user->jabatan == '2') {
                                                                                                                        echo "checked='checked'";
                                                                                                                    } ?> onclick="$('.jabatan').show();"> KABID
                                     </label>
                                 </div>
                                 <?php //} 
                                    ?>
                             </div>

                             <div class="form-group jabatan ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">NIP</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nip" id="nip" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nip, 'nip'); ?>" class="form-control" />
                                     </div>
                                 </div>
                             </div>

                             <div class="form-group jabatan ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama" id="nama" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_ka, 'nama_ka'); ?>" class="form-control" />
                                     </div>
                                 </div>
                             </div>

                             <div class="form-group jabatan ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Dinas</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_dinas" id="nama_dinas" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_dinas, 'nama_dinas'); ?>" class="form-control" />
                                     </div>
                                 </div>
                             </div>

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
                                         <input type="text" name="nama_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_dispenda'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group ds_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat Dispenda</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_dispenda" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_dispenda'); ?>" class="form-control" />
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
                                                                                                                                                                                                                } ?> class="form-control id_input" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama PPAT</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_ppat'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat PPAT</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_ppat'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Email PPAT</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="email_ppat" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->email, 'email_ppat'); ?>" class="form-control" />
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
                                                                                                                                                                                                        } ?> class="form-control id_input" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Payment Point</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama, 'nama_pp'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat Payment Point</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat, 'alamat_pp'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama Kepala</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_kepala_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_kepala, 'nama_kepala_pp'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pp_id">
                                 <label class="col-md-3 col-xs-12 control-label">Telepon</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="telp_pp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->telepon, 'telp_pp'); ?>" class="form-control" />
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
                                                                                                                                                                                                            } ?> class="form-control id_input" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Nama</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="nama_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->nama_kpp, 'nama_kpp'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                             <div class="form-group pt_id">
                                 <label class="col-md-3 col-xs-12 control-label">Alamat</label>
                                 <div class="col-md-4 col-xs-12">
                                     <div class="input-group">
                                         <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                         <input type="text" name="alamat_kpp" id="nama_id" style="width: 200px;" maxlength="100" value="<?php echo $this->antclass->back_value(@$user->alamat_kpp, 'alamat_kpp'); ?>" class="form-control" />
                                     </div>

                                 </div>
                             </div>
                         <?php endif; ?>

                         <div class="form-group">
                             <label class="col-md-3 col-xs-12 control-label">Tanggal Expired</label>
                             <div class="col-md-4 col-xs-12">
                                 <div class="input-group">
                                     <span class="input-group-addon"><span class="fa fa-clock-alt"></span></span>
                                     <input type="text" name="exp_date" style="width: 200px;" maxlength="50" value="<?php echo $this->antclass->back_value(tanggalIndo(@$user->exp_date), 'exp_date'); ?>" class="form-control datepicker" required />

                                 </div>
                             </div>
                         </div>



                         <div class="form-group">
                             <label class="col-md-3 col-xs-12 control-label">Is Blokir</label>
                             <div class="col-md-2"><label class="check" for="id_no"><input type="radio" class="iradio" id="id_no" name="txt_status_user" <?php if (@$user->is_blokir == '0') {
                                                                                                                                                                echo "checked='checked'";
                                                                                                                                                            } ?> checked="checked" value="0" /> Tidak</label> &nbsp;</div>
                             <div class="col-md-2"><label class="check" for="id_yes"><input type="radio" class="iradio" id="id_yes" name="txt_status_user" <?php if (@$user->is_blokir == '1') {
                                                                                                                                                                echo "checked='checked'";
                                                                                                                                                            } ?> value="1" /> Ya</label>&nbsp;</div>
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