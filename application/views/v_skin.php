<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META SECTION -->
    <title><?php echo $this->config->item('site_name'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="author" content="Cendana2000" />
    <meta name="keywords" content="<?php echo $this->config->item('header'); ?>" />
    <meta name="description" content="Cendana2000" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="<?= base_url() . 'assets/template/assets/images/users/logo.png'; ?>" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/theme-default.css" />
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/mystyle.css" />
    <!-- CSS BARU 27 JANUARI 2015 -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/style_27012015.css" />
    <link href='<?php echo base_url(); ?>assets/template/mask/hold_on.css' rel='stylesheet' />
    <!-- EOF CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugin/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugin/select2/select2-bootstrap.min.css">

    <!-- START SCRIPTS -->
    <!-- START PLUGINS -->
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugin/select2/select2.full.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='<?php echo base_url(); ?>assets/template/mask/hold_on.js'></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap.min.js"></script>
    <!-- END PLUGINS -->


    <!-- THIS PAGE PLUGINS -->
    <script type='text/javascript' src='<?= base_url() ?>assets/template/js/plugins/icheck/icheck.min.js'></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- THIS PAGE PLUGINS -->

    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-file-input.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap-select.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
    <!-- END THIS PAGE PLUGINS -->
    <!-- END PAGE PLUGINS -->

    <!-- START TEMPLATE -->
    <!--<script type="text/javascript" src="<?= base_url() ?>assets/template/js/settings.js"></script>-->

    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/actions.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/settings.js"></script>

    <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    <!-- SCRIPT AWAL -->
    <script type="text/javascript" src="<?= base_url_js() ?>jquery-ui-numeric-min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/template/js/jquery.mask.js"></script>
    <!-- <script type="text/javascript" src="<?= base_url_js() ?>jquery.maskedinput-1.3.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url_js() ?>bphtb.js"></script>
    <script type="text/javascript" src="<?= base_url_js() ?>handler.js"></script>

    <!-- // <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script> -->
    <script src="<?= base_url_js() ?>jquery-migrate-1.2.1.js"></script>

    <script type="text/javascript" src="<?= base_url_js() ?>jquery.printElement.js"></script>


    <script type="text/javascript">
        function load_masking() {
            HoldOn.open({
                theme: 'sk-cube-grid',
                message: "Loading... "
            });
        }

        function close_masking() {
            HoldOn.close();
        }

        function inArray(needle, haystack) {
            var length = haystack.length;
            for (var i = 0; i < length; i++) {
                if (haystack[i] == needle) return true;
            }
            return false;
        }
    </script>



</head>

<!--body class="page-container-boxed"-->

<body class="">
    <!-- START PAGE CONTAINER -->
    <div class="page-container">

        <!-- START PAGE SIDEBAR -->
        <?php $this->load->view('v_navcol'); ?>
        <!-- END PAGE SIDEBAR -->

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">


                <!-- SIGN OUT -->
                <li>
                    <h3 class="" style="padding-top: 15px;padding-left:15px;color: white;">SISTEM APLIKASI MANAJEMEN - BPHTB</h3>
                </li>
                <ul class="pull-right">
                    <li class="pull-right">
                        <a href="<?php echo base_url(); ?>index.php/main/logout">KELUAR</a>
                    </li>
                    <li class="pull-right">
                        <a href="<?php echo base_url(); ?>index.php/user/edit_profil/<?php echo $this->session->userdata('s_id_user'); ?>/<?php echo $this->session->userdata('s_tipe_bphtb'); ?>"><?php echo strtoupper(($this->session->userdata('s_nama_bphtb')) ? $this->session->userdata('s_nama_bphtb') : $this->session->userdata('s_username_bphtb')); ?></a>
                    </li>
                </ul>
                <!-- END SIGN OUT -->
            </ul>
            <!-- END X-NAVIGATION VERTICAL -->

            <!-- START BREADCRUMB -->
            <?php

            $list_page = array(
                //Dashboard
                'main/'                 => '<li><a href="#">Dashboard</a></li>',
                //Payment Point
                'tagih_bea/'            => '<li><a href="#">Payment Point</a></li><li class="active">SSPD - BPHTB</li>',
                'sptpd/'                => '<li><a href="#">Payment Point</a></li><li class="active">SPTPD</li>',
                //Penelitian
                'penelitian/'           => '<li><a href="#">Penelitian</a></li><li class="active">Formulir Penelitian</li>',
                //Laporan
                'sptpd/report'          => '<li><a href="#">Laporan</a></li><li class="active">Laporan SSPD - BPHTB</li>',
                'nop/report'            => '<li><a href="#">Laporan</a></li><li class="active">Laporan Perubahan NOP</li>',
                'log/login'             => '<li><a href="#">Laporan</a></li><li class="active">Laporan Login User</li>',
                //Penerbitan SK
                'penerbitanlapangan/'   => '<li><a href="#">Penerbitan SK</a></li><li class="active">Pemeriksaan Lapangan</li>',
                'tagihandenda/'         => '<li><a href="#">Penerbitan SK</a></li><li class="active">Tagihan Denda</li>',
                'pengantar_permohonan/' => '<li><a href="#">Penerbitan SK</a></li><li class="active">Pengantar Permohonan</li>',
                'tagih_bea/'            => '<li><a href="#">Penerbitan SK</a></li><li class="active">Surat Tagih Bea</li>',
                'sk_pengurangan/'       => '<li><a href="#">Penerbitan SK</a></li><li class="active">SK Pengurangan</li>',
                'sk_kurang_bayar/'      => '<li><a href="#">Penerbitan SK</a></li><li class="active">Kurang Bayar</li>',
                //Master Data
                'nop/'                  => '<li><a href="#">Master Data</a></li><li class="active">NOP</li>',
                'ppat/'                 => '<li><a href="#">Master Data</a></li><li class="active">PPAT</li>',
                'nik/'                  => '<li><a href="#">Master Data</a></li><li class="active">NIK</li>',
                'propinsi/'             => '<li><a href="#">Master Data</a></li><li class="active">Propinsi</li>',
                'dati/'                 => '<li><a href="#">Master Data</a></li><li class="active">Dati</li>',
                'kecamatan/'            => '<li><a href="#">Master Data</a></li><li class="active">Distrik</li>',
                'kelurahan/'            => '<li><a href="#">Master Data</a></li><li class="active">Kelurahan</li>',
                'paymentpoint/'         => '<li><a href="#">Master Data</a></li><li class="active">Payment Point</li>',
                'jns_perolehan/'        => '<li><a href="#">Master Data</a></li><li class="active">Jenis Perolehan</li>',
                'rekening/'             => '<li><a href="#">Master Data</a></li><li class="active">Rekening</li>',
                'pegawai/'              => '<li><a href="#">Master Data</a></li><li class="active">Pegawai</li>',
                //Utilitas
                'user/'                 => '<li><a href="#">Utilitas</a></li><li class="active">User Management</li>',
            );

            $segment_1 = $this->uri->segment(1);
            $segment_2 = $this->uri->segment(2);
            if ($segment_2 == 'add') {
                $active_page = @$list_page[$segment_1 . '/'] . '<li class="active">Tambah Data</li>';
            } elseif ($segment_2 == 'edit') {
                $active_page = @$list_page[$segment_1 . '/'] . '<li class="active">Perbaharui Data</li>';
            } else {
                $active_page = @$list_page[$segment_1 . '/' . $segment_2];
            }

            ?>

            <ul class="breadcrumb">
                <?= @$active_page ?>
            </ul>
            <!-- END BREADCRUMB -->



            <!-- PAGE CONTENT WRAPPER -->
            <?php echo $child; ?>
            <!-- PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->



    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            // console.log(charCode);
            if (charCode == 46) {
                return true;
            }
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $(".tanggal").datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>

</body>

</html>