<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $akses = $this->session->userdata('s_tipe_bphtb'); ?>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> SETUJUI USER WP</h2>
</div>

<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">

                            <a class="btn btn-default" href="./aprove_user "><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="listform">
                    <!--                 
                    <div class="panel-body">
                        <form class="form-inline pull-right" action="" method="post" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control tanggal"  name="txt_search_dstart" placeholder="Tanggal awal" value="<?= changeDateFormat('webview', @$search['date_start']) ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control tanggal"  name="txt_search_dstop" placeholder="Tanggal akhir" value="<?= changeDateFormat('webview', @$search['date_stop']) ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_search_nop" placeholder="NOP" value="<?= @$search['nop'] ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_search_nodok" placeholder="No. SPPD" value="<?= @$search['nodok'] ?>">
                            </div>
                            <input type="submit" class="btn btn-info" value="Cari" name="search" />
                        </form>
                        <br>
                        <br>
                        <br>
                    </div> 
                    -->
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <?php if (!$user) : echo 'Data SSPD kosong.';
                        else : ?>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <div>
                            <?php if (!empty($this->session->flashdata("info"))) {
                                echo '
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        ' . $this->session->flashdata("info") . '
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                ';
                            } ?>
                        </div>
                        <form name="frm_sptpd" method="post" action="" class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tblhead">
                                        <th width="20px">No</th>
                                        <th width="80px">ID User</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th style="text-align: center">Foto KTP</th>
                                        <th width="50px">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($user as $user) :
                                ?>

                                    <?php
                                    $full_path = FCPATH . $user->foto;
                                    $path = (file_exists($full_path)) ? base_url($user->foto) : base_url("assets/images/avatar.jpg");
                                    preg_match_all('!\.[0-9a-z]+$!', $user->foto, $match);
                                    $path = count($match[0]) > 0 ? (($match[0][0] == ".pdf") ? base_url("assets/images/pdf.png") : $path) : $path;
                                    ?>

                                    <tbody>
                                        <tr class="tblhov">
                                            <td><?php echo  $i; ?></td>
                                            <td><?php echo $user->id_user ?></td>
                                            <td><?php echo $user->nik ?></td>
                                            <td><?= $user->nama ?></td>
                                            <td align=" center"><img width="10%" id=image1 src="<?= $path ?>"></td>
                                            <td>
                                                <a class="btn btn-info " href="<?php echo base_url(); ?>index.php/aprove_user/lihat_wp/<?php echo $user->id_user; ?>">Lihat</a>
                                                <a class="btn btn-danger" data-toggle="modal" data-target="#myModal"> Tolak </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                                    $i++;
                                    $l++;
                                endforeach; ?>
                            </table>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-offset-8 col-md-4">
                                <!-- PAGINATION BELUM -->
                                <!-- <div class="dataTables_paginate paging_bootstrap pagination"><?php echo @$page_link; ?></div> -->
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL REJECT-->
    <form role="form" method="POST" action="<?php echo base_url(); ?>index.php/aprove_user/action_delete">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Reject</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="form_reject">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Alasan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="exampleInputName2" name="alasan_reject" id="alasan_reject"></textarea>
                                    <input type="hidden" class="form-control" value="<?= $user->id_user ?>" name="id">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tolak</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--MODAL REJECT-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detail</h4>
                </div>
                <div class="modal-body" id="detail_rejek">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="ini_di_print">
    </div>

    <script src="<?= base_url() . 'assets/scripts/jquery.print/jquery.print.js' ?>"></script>

    <script>

    </script>