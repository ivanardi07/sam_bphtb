<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $akses = $this->session->userdata('s_tipe_bphtb'); ?>
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Daftar Pengajuan BPHTB</h2>
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
                            <?php
                            $add_url_dispenda = $c_loc . '/add_by_dispenda';
                            $add_url_wp = $c_loc . '/add_by_wp';
                            $add_url = $c_loc . '/add';
                            // echo "<pre>";
                            // print_r ($this->session->all_userdata());
                            // echo "</pre>";

                            ?>
                            <?php
                            if ($akses == 'D' && $userdata['jabatan'] == '0') { ?>
                                <a class="btn btn-info" href="<?php echo $add_url_dispenda; ?>"><span class="fa fa-plus"></span>Tambah</a>
                            <?php } elseif ($akses == 'WP') { ?>
                                <a class="btn btn-info" href="<?php echo $add_url_wp; ?>"><span class="fa fa-plus"></span>Tambah</a>
                            <?php } ?>

                            <a class="btn btn-default" href="<?php echo $c_loc . '/' . 'refresh'; ?>"><span class="fa fa-refresh"></span>Refresh Data</a>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <form class="form-inline pull-left" action="" method="post" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control tanggal" name="txt_search_dstart" placeholder="Tanggal awal" value="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control tanggal" name="txt_search_dstop" placeholder="Tanggal akhir" value="">
                            </div>
                            <div class="form-group">
                                <select id="pilihan" class="form-control">
                                    <option value="1" selected>No Pelayanan</option>
                                    <option value="2">NOP</option>
                                    <option value="3">No SSPD</option>

                                    <!-- option -->
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_search_nop" id="nop" placeholder="NOP" value="<?= @$search['nop'] ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_search_no_pelayanan" id="nopel" placeholder="No Pelayanan" value="<?= @$search['no_pelayanan'] ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_search_nodok" id="no_sspd" placeholder="No. SPPD" value="<?= @$search['nodok'] ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-info" value="Cari" name="search" />
                            </div>
                        </form>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <?php if (!$sptpds) : echo 'Data SSPD kosong.';
                        else : ?>
                    </div>
                </div>
                <div class="listform">
                    <div class="panel-body">
                        <form name="frm_sptpd" method="post" action="">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tblhead">
                                        <th>No</th>
                                        <th style="width: 100px;">Tanggal</th>
                                        <th style="width: 65px;">No Pelayanan</th>
                                        <th>NOP</th>
                                        <th style="width: 160px;">Nama</th>
                                        <th>No. SSPD</th>
                                        <th>Posisi Berkas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                $l = 0;
                                foreach ($sptpds as $sptpd) :
                                ?>

                                    <?php
                                    if ($akses == 'D') {
                                        if ($sptpd->flag_dispenda == 1) {
                                            $warna = "#FAFB04";
                                        } else {
                                            if ($i % 2) {
                                                $warna = "#E5E5E5";
                                            } else {
                                                $warna = "#F5F5F5";
                                            }
                                        }
                                    } else {
                                        if ($sptpd->flag_ppat == 1) {
                                            $warna = "#FAFB04";
                                        } else {
                                            if ($i % 2) {
                                                $warna = "#E5E5E5";
                                            } else {
                                                $warna = "#F5F5F5";
                                            }
                                        }
                                    }
                                    ?>
                                    <tbody>
                                        <tr class="tblhov" bgcolor="<?= $warna ?>">
                                            <td><?php echo $start + $i; ?></td>
                                            <td><?php echo $sptpd->tanggal; ?></td>
                                            <td><?php echo $sptpd->no_pelayanan; ?></td>
                                            <td><?= $sptpd->kd_propinsi; ?>.<?= $sptpd->kd_kabupaten; ?>.<?= $sptpd->kd_kecamatan; ?>.<?= $sptpd->kd_kelurahan; ?>.<?= $sptpd->kd_blok; ?>.<?= $sptpd->no_urut; ?>.<?= $sptpd->kd_jns_op; ?></td>
                                            <td>

                                                <?php

                                                $nik = $this->mod_nik->get_nik($sptpd->nik);
                                                echo @$nik->nama;


                                                ?>
                                            </td>
                                            <td><?php echo $sptpd->no_dokumen; ?></td>
                                            <td align="center">


                                                <?php if ($akses == "WP") : ?>
                                                    <?php
                                                    if ($sptpd->is_lunas == '0') {
                                                        echo 'Entry';
                                                    } elseif ($sptpd->is_lunas == '1') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-success">Lunas</span></a>';
                                                    } elseif ($sptpd->is_lunas == '2') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-success">Validasi</span></a>';
                                                    } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '-1') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-danger">Dokumen Dikembalikan PPAT</span></a>';
                                                    } elseif ($sptpd->proses == '0') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-info">Dokumen di Proses BP2D</span></a>';
                                                    } elseif ($sptpd->proses == '2') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-info">Silahkan Cetak Dokumen</span></a>';
                                                        // } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '1') {
                                                        //     echo '<a href = "#myModal" data-toggle="modal" onclick = "detail('.$sptpd->id_sptpd.')"><span class="label label-danger">Dokumen Dikembalikan KABID</span></a>';
                                                        // } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '0') {
                                                        //     echo '<a href = "#myModal" data-toggle="modal" onclick = "detail('.$sptpd->id_sptpd.')"><span class="label label-danger">Dokumen Dikembalikan KASUBID</span></a>';
                                                    } elseif ($sptpd->aprove_ppat == '0') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-info">PPAT</span></a>';
                                                    } else {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-info">Dokumen di Proses BP2D</span></a>';
                                                    }
                                                else : ?>
                                                <?php
                                                    if ($sptpd->is_lunas == '0') {
                                                        echo 'Entry';
                                                    } elseif ($sptpd->is_lunas == '1') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-success">Lunas</span></a>';
                                                    } elseif ($sptpd->is_lunas == '2') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-success">Validasi</span></a>';
                                                    } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '-1' && $sptpd->aprove_ppat == '-1') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-danger">Dokumen Dikembalikan PPAT</span></a>';
                                                    } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '-1') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-danger">Dokumen Dikembalikan STAFF</span></a>';
                                                    } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '0') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-danger">Dokumen Dikembalikan KASUBID</span></a>';
                                                    } elseif ($sptpd->is_lunas == '3' && $sptpd->proses == '1') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-danger">Dokumen Dikembalikan KABID</span></a>';
                                                    } elseif ($sptpd->aprove_ppat == '0') {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-info">Menunggu PPAT</span></a>';
                                                    } else {
                                                        echo '<a href = "#myModal" data-toggle="modal" onclick = "detail(' . $sptpd->id_sptpd . ')"><span class="label label-info">Proses</span></a>';
                                                        if ($sptpd->proses == '2') {
                                                            echo ' <span class="label label-info">Cetak SPTPD</span>';
                                                        } elseif ($sptpd->proses == '1') {
                                                            echo ' <span class="label label-info">Verifikasi Kabid</span>';
                                                        } elseif ($sptpd->proses == '0') {
                                                            echo ' <span class="label label-info">Verifikasi Kasubid</span>';
                                                        }
                                                    }

                                                endif  ?>
                                            </td>
                                            <td>
                                                <?php if ($akses == 'D' && $userdata['jabatan'] == '0') { ?>
                                                    <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/<?php echo $sptpd->id_sptpd; ?>" class="btn btn-xs">Edit</a>
                                                <?php } else {
                                                } ?>
                                                <?php if ($akses == 'D' && $sptpd->proses == $userdata['jabatan']  && $sptpd->is_lunas == '3' && $userdata['jabatan'] != '0') { ?>
                                                    <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/<?php echo $sptpd->id_sptpd; ?>" class="btn btn-xs">Edit</a>
                                                <?php } else {
                                                } ?>

                                                <?php if ($akses == 'D' && $sptpd->proses == $userdata['jabatan']) { ?>
                                                <?php } elseif ($akses != 'PT' && $sptpd->proses == $userdata['jabatan']) { ?>
                                                    <a class="btn btn-xs btn-primary" href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/<?php echo $sptpd->id_sptpd; ?>" class="btn btn-xs">Edit</a>
                                                <?php } ?>
                                                <?php if ($akses == 'D') : ?>
                                                    <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>" target="_blank">Lihat</a>
                                                    <?php if ($sptpd->is_kurang_bayar == 0 && $userdata['jabatan'] == 0) : ?>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/kurang_bayar/<?php echo $sptpd->id_sptpd; ?>">Kurang Bayar</a>
                                                    <?php endif ?>

                                                    <?php if ($akses == 'D' && $userdata['jabatan'] == '1') { ?>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/delete/<?php echo $sptpd->id_sptpd; ?>" onclick="return confirm('Are you sure to delete &quot;<?php echo addslashes($sptpd->id_sptpd); ?>&quot;?')">Hapus</a>
                                                    <?php } else {
                                                    } ?>

                                                <?php elseif ($akses == 'WP') : ?>
                                                    <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>" target="_blank">Lihat</a>
                                                    <?php if ($sptpd->is_lunas == '3' && $sptpd->aprove_ppat == '-1') : ?>
                                                        <a href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd_wp/<?php echo $sptpd->id_sptpd; ?>" class="btn btn-xs btn-primary">Edit</a>

                                                    <?php endif ?>
                                                    <?php if ($sptpd->aprove_ppat == '1') { ?>
                                                        <?php if ($sptpd->is_lunas == '1' && $akses == "WP") : ?>
                                                            <!-- <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>" target = "_blank">Cetak</a> -->
                                                        <?php else : ?>

                                                            <button type="button" class="btn btn-primary btn-xs" onclick="cetak_buktipendaftaran(<?= $sptpd->id_sptpd; ?>)"> Cetak </button>
                                                        <?php endif ?>
                                                    <?php } ?>
                                                <?php else : ?>

                                                    <?php if ($sptpd->is_lunas == '3' && $sptpd->aprove_ppat != '-1' && $sptpd->proses != '0') : ?>
                                                        <a href="<?php echo base_url(); ?>index.php/sptpd/edit_sptpd/<?php echo $sptpd->id_sptpd; ?>" class="btn btn-xs btn-primary">Edit</a>
                                                    <?php endif ?>

                                                    <?php if ($akses == 'PT' && $sptpd->aprove_ppat == '0') : ?>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/aprove_sspd/lihat/<?php echo $sptpd->id_sptpd; ?>" target="_blank">Lihat</a>
                                                    <?php endif ?>

                                                    <?php if ($akses == 'PT' && $sptpd->aprove_ppat == '1') :
                                                        if ($sptpd->aprove_ppat == '1' || $sptpd->proses >= '0') :  ?>
                                                            <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>" target="_blank">Lihat</a>
                                                        <?php endif ?>
                                                    <?php endif ?>

                                                    <?php if ($akses == 'KPP') : ?>
                                                        <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>" target="_blank">Lihat</a>
                                                    <?php endif ?>

                                                    <?php if ($sptpd->is_lunas == '1') : ?>
                                                        <!-- <a class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>index.php/sptpd/printform/<?php echo $sptpd->id_sptpd; ?>" target = "_blank">Cetak</a> -->
                                                    <?php else : ?>
                                                        <!-- <button type="button" class="btn btn-primary btn-xs" onclick="cetak_buktipendaftaran(<?= $sptpd->id_sptpd; ?>)"> Cetak </button>         -->
                                                    <?php endif ?>
                                                <?php endif; ?>
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
                                <div class="dataTables_paginate paging_bootstrap pagination"><?php echo $page_link; ?></div>
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
            $('#nop').hide();
            $('#no_sspd').hide();
            $('#pilihan').change(function() {
                var pilih = $('#pilihan').val();
                if (pilih == 1) {
                    $('#nopel').show();
                    $('#nop').hide();
                    $('#no_sspd').hide();
                } else
                if (pilih == 2) {
                    $('#nopel').hide();
                    $('#nop').show();
                    $('#no_sspd').hide();
                } else
                if (pilih == 3) {
                    $('#nopel').hide();
                    $('#nop').hide();
                    $('#no_sspd').show();
                }
            });
        });
    </script>

    <script>
        function cetak_buktipendaftaran(id_sptpd) {
            $.ajax({
                    url: "<?= site_url('sptpd/cetak_buktipendaftaran') ?>",
                    type: 'POST',
                    data: {
                        id: id_sptpd
                    },
                })
                .done(function(ress) {
                    $('#ini_di_print').html(ress);
                    $.print("#ini_di_print");
                    $('#ini_di_print').html(' ');
                });


        }

        function detail(id_sptpd) {
            $.ajax({
                    type: 'POST',
                    url: "<?= site_url('sptpd/detail_rejek') ?>",
                    data: {
                        id_sptpd: id_sptpd
                    }
                })
                .done(function(ress) {
                    $('#detail_rejek').html(ress);
                });
        }
    </script>