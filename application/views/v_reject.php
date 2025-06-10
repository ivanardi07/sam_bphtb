<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $akses = $this->session->userdata('s_tipe_bphtb'); ?>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> TOLAK SSPD</h2>
</div>

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

                            <a class="btn btn-default" href="<?php echo $c_loc; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <?php if (!$user) : echo 'Data SSPD kosong.';
                        else : ?>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body table-responsive">
                        <form name="frm_sptpd" method="post" action="">
                            <table class="table table-bordered table-hover" id="tablerejectsspd">
                                <thead>
                                    <tr class="tblhead">
                                        <th width="20px">No</th>
                                        <th width="150px">Tanggal</th>
                                        <th>No Pelayanan</th>
                                        <th>No. SSPD</th>
                                        <th>Nama</th>
                                        <th>Alasan Reject</th>
                                        <th width="50px">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($user as $user) :
                                ?>


                                    <tbody>
                                        <tr class="tblhov" ">
                                    <td><?php echo  $i; ?></td>
                                    <td><?php echo $user->tanggal ?></td>
                                    <td><?php echo $user->no_pelayanan ?></td>
                                    <td><?php echo $user->no_dokumen ?></td>
                                    <td><?php $nik = $this->mod_nik->get_nik($user->nik);
                                        echo @$nik->nama; ?></td>
                                    <td><?php echo $user->alasan_reject ?></td>


                                    <td>
                                        <a class=" btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $user->id_sptpd; ?>" target="_blank">Lihat</a>

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
                                <!-- <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div> -->
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


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
        $(document).ready(function() {
            var table = $('#tablerejectsspd').DataTable({
                responsive: true,
            });
        });
    </script>