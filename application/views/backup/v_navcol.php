<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$admin = $this->session->userdata('status_admin');
$akses = $this->session->userdata('s_tipe_bphtb');
$user  = $this->session->userdata('s_username_bphtb');
$all_user  = $this->session->all_userdata('');
// echo "<pre>";
// print_r ($all_user);exit();
// echo "</pre>";
?>
<style type="text/css">
    .notif {
        float: right;
    }
</style>
<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="#">
                <?php
                if ($akses == 'B') :
                    echo "Bank";
                elseif ($akses == 'D' && $all_user['jabatan'] == '0') :
                    echo "Staf";
                elseif ($akses == 'D' && $all_user['jabatan'] == '1') :
                    echo "Kasubid";
                elseif ($akses == 'D' && $all_user['jabatan'] == '2') :
                    echo "Kabid";
                elseif ($akses == 'D') :
                    echo "Admin";
                elseif ($akses == 'WP') :
                    echo "Wajib Pajak";
                elseif ($akses == 'P') :
                    echo "Payment Point";
                elseif ($akses == 'PP') :
                    echo "BANK";
                elseif ($akses == 'KPP') :
                    echo "BPN";
                else :
                    echo "PPAT";
                endif;
                ?>
            </a>
            <a href="#" class="x-navigation-control"></a>
        </li>

        <?php
        $dashboard = 'main';
        $paymentpoint = 'sptpd';
        $penelitian = 'penelitian';
        $laporan = array('report', 'login', 'report_all');
        $penerbitansk = array(
            'penerbitanlapangan',
            'tagihandenda',
            'pengantar_permohonan',
            'tagih_bea',
            'sk_pengurangan',
            'sk_kurang_bayar'
        );

        $masterdata = array(
            'nop',
            'ppat',
            'nik',
            'propinsi',
            'dati',
            'kecamatan',
            'kelurahan',
            'paymentpoint',
            'jns_perolehan',
            'rekening',
            'pegawai',
        );
        $utilitas = 'user';
        $param1 = $this->uri->segment(1);
        $param2 = $this->uri->segment(2);
        $addedit = $param2 == 'add' or $param2 == 'edit';

        ?>

        <li class="<?php echo $status = ($param1 == 'main') ? 'activenav' : ''; ?>">
            <a href="<?php echo site_url(); ?>/main"><span class="fa fa-desktop"></span> <span class="xn-text">Halaman Utama</span></a>
        </li>



        <?php if ($akses == 'PT' || $akses == 'D' || $akses == "WP" || $akses == "KPP") : ?>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == '' or $param2 == 'add' or $param2 == 'printform' or $param2 == 'add_by_dispenda' or $param2 == 'edit_sptpd')) ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/sptpd"><span class="fa fa-image"></span>Pengajuan BPHTB
                    <span class="label label-warning notif" id="notif_sspd">
                </a>
            </li>
        <?php endif ?>


        <?php if ($akses == 'PT') : ?>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == '' or $param2 == 'add' or $param2 == 'printform' or $param2 == 'add_by_dispenda' or $param2 == 'edit_sptpd')) ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/aprove_sspd"><span class="fa fa-image"></span>Setujui SSPD
                </a>
            </li>

        <?php endif ?>



        <?php if ($akses == 'D' && $all_user['jabatan'] == '0') : ?>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == '' or $param2 == 'add' or $param2 == 'printform' or $param2 == 'add_by_dispenda' or $param2 == 'edit_sptpd')) ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/aprove_user"><span class="fa fa-image"></span>Setujui User WP
                    <span class="label label-warning notif" id="notif_sspd2">
                </a>
            </li>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == '' or $param2 == 'add' or $param2 == 'printform' or $param2 == 'add_by_dispenda' or $param2 == 'edit_sptpd')) ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/harga_refrensi"><span class="fa fa-image"></span>Harga Refrensi
                    <span>
                </a>
            </li>

        <?php endif ?>

        <?php if ($akses == 'PT') : ?>

            <li class="<?php echo $status = ($param1 == 'penelitian' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/penelitian"><span class="fa fa-heart"></span> Lampiran</a>
            </li>
            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == 'report' or $param2 == 'report_all')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/sptpd/laporan_ppat"><span class="fa fa-adjust"></span> Pembayaran SSPD </a></li>


        <?php endif ?>

        <?php if ($akses == 'D') { ?>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == 'report' or $param2 == 'report_all')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/sptpd/report"><span class="fa fa-adjust"></span> Laporan SSPD - BPHTB</a></li>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == 'report' or $param2 == 'report_all')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/sptpd/laporan_bp2d"><span class="fa fa-adjust"></span> Pembayaran SSPD </a></li>

            <li class="<?php echo $status = ($param1 == 'kurang_bayar') ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/kurang_bayar"><span class="fa fa-money"></span> <span class="xn-text"> Kurang Bayar SSPD</span></a>
            </li>

            <?php if ($admin == 1) : ?>
                <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == '' or $param2 == 'add' or $param2 == 'printform' or $param2 == 'add_by_dispenda' or $param2 == 'edit_sptpd')) ? 'activenav' : ''; ?>">
                    <a href="<?php echo site_url(); ?>/aprove_user"><span class="fa fa-image"></span>Setujui User WP
                        <span class="label label-warning notif" id="notif_sspd2">
                    </a>
                </li>
                <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == '' or $param2 == 'add' or $param2 == 'printform' or $param2 == 'add_by_dispenda' or $param2 == 'edit_sptpd')) ? 'activenav' : ''; ?>">
                    <a href="<?php echo site_url(); ?>/aprove_sspd"><span class="fa fa-image"></span>Setujui SSPD
                    </a>
                </li>
                <li class="xn-openable <?php echo $status = (in_array($param1, $masterdata) and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'active activenav' : ''; ?>">
                    <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Master Data</span></a>
                    <ul>
                        <li class="<?php echo $status = ($param1 == 'nop' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/nop"><span class="fa fa-envelope"></span>NOP</a></li>
                        <li class="<?php echo $status = ($param1 == 'ppat' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/ppat"><span class="fa fa-leaf"></span>PPAT</a></li>
                        <li class="<?php echo $status = ($param1 == 'nik' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/nik"><span class="fa fa-magnet"></span>NIK</a></li>
                        <li class="<?php echo $status = ($param1 == 'propinsi' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/propinsi"><span class="fa fa-rocket"></span>Propinsi</a></li>
                        <li class="<?php echo $status = ($param1 == 'dati' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/dati"><span class="fa fa-shield"></span>Kabupaten</a></li>
                        <li class="<?php echo $status = ($param1 == 'kecamatan' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/kecamatan"><span class="fa fa-suitcase"></span>Kecamatan</a></li>
                        <li class="<?php echo $status = ($param1 == 'kelurahan' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/kelurahan"><span class="fa fa-tachometer"></span>Kelurahan</a></li>
                        <li class="<?php echo $status = ($param1 == 'paymentpoint' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/paymentpoint"><span class="fa fa-truck"></span>Bank User</a></li>
                        <li class="<?php echo $status = ($param1 == 'jns_perolehan' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/jns_perolehan"><span class="fa fa-ticket"></span>Jenis Perolehan</a></li>
                        <li class="<?php echo $status = ($param1 == 'rekening' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/rekening"><span class="fa fa-trophy"></span>Rekening</a></li>
                        <li class="<?php echo $status = ($param1 == 'pegawai' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/pegawai"><span class="fa fa-dot-circle-o"></span>Pegawai</a></li>
                    </ul>
                </li>
            <?php endif ?>

        <?php } ?>

        <!--         <li class="<?php echo $status = ($param1 == 'cek_referensi') ? 'activenav' : ''; ?>">
            <a href="<?php echo site_url(); ?>/cek_referensi"><span class="fa fa-money"></span> <span class="xn-text">Cek Referensi Nilai Pasar</span></a>
        </li> -->

        <?php if ($akses !== 'KPP' && $akses !== 'WP') : ?>
            <li class="<?php echo $status = ($param1 == 'report_penerimaan_bank') ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/report_penerimaan_bank"><span class="fa fa-adjust"></span> Laporan Penerimaan Bank</a></li>

            <li class="<?php echo $status = ($param1 == 'cek_jumlah_transaksi') ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/cek_jumlah_transaksi"><span class="fa fa-money"></span> Cek Jumlah Transaksi WP</a></li>
        <?php endif; ?>

        <!-- MODIF DISINI -->
        <?php if ($akses == 'PP') { ?>
            <li class="<?php echo $status = ($param1 == 'daftar_sptpd_bank') ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/daftar_sptpd_bank"><span class="fa fa-building-o"></span> <span class="xn-text">Daftar SSPD BANK</span></a>
            </li>
        <?php } ?>
        <!-- MODIF DISINI -->

        <?php if ($akses == 'D' || $akses == 'PT') { ?>
            <li class="<?php echo $status = ($param1 == 'daftar_sptpd') ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/daftar_sptpd"><span class="fa fa-list-alt"></span> <span class="xn-text">Daftar SSPD</span></a>
            </li>

            <li class="<?php echo $status = ($param1 == 'sptpd' and ($param2 == 'report' or $param2 == 'report_all')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/reject_sspd"><span class="fa fa-image"></span> Tolak SSPD </a></li>

            <li class="<?php echo $status = ($param1 == 'transaksi') ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/transaksi"><span class="fa fa-list-alt"></span> <span class="xn-text">Transaksi</span></a>
            </li>

            <li class="<?php echo $status = ($param1 == 'cek_nop') ? 'activenav' : ''; ?>">
                <a href="<?php echo site_url(); ?>/cek_nop"><span class="fa fa-money"></span> <span class="xn-text">Cek Verifikasi SSPD</span></a>
            </li>
        <?php } ?>

        <?php if ($akses == 'D') { ?>
            <!--         <li class="<?php echo $status = ($param1 == 'daftar_sptpd_lama') ? 'activenav' : ''; ?>">
            <a href="<?php echo site_url(); ?>/daftar_sptpd_lama"><span class="fa fa-list-alt"></span> <span class="xn-text">Daftar SSPD Lama</span></a>
        </li> -->
            <?php if ($admin == 1) : ?>
                <li class="xn-openable <?php echo $status = ($param1 == 'user' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'active activenav' : ''; ?>">
                    <a href="#"><span class="fa fa-users"></span> <span class="xn-text">Utilitas</span></a>
                    <ul>
                        <li class="<?php echo $status = ($param1 == 'user' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/user"><span class="fa fa-user"></span>User Management</a></li>
                        <li class="<?php echo $status = ($param1 == 'user' and ($param2 == '' or $param2 == 'add' or $param2 == 'edit')) ? 'activenav' : ''; ?>"><a href="<?php echo site_url(); ?>/setting"><span class="fa fa-gears"></span>Setting Session</a></li>
                    </ul>
                </li>
            <?php endif ?>

        <?php } ?>
        <!--         <li class="<?php echo $status = ($param1 == 'cek_loc_sspd') ? 'activenav' : ''; ?>">
            <a href="<?php echo site_url(); ?>/cek_loc_sspd"><span class="fa fa-location-arrow"></span> <span class="xn-text">Cek Lokasi SSPD</span></a>
        </li>  -->
    </ul>
    <!-- END X-NAVIGATION -->
</div>

<script type="text/javascript">
    getNotif();
    getNotif2();

    function getNotif() {
        $.ajax({
            url: "<?= site_url('sptpd/get_notif') ?>",
        }).done(function(hasil) {
            $('#notif_sspd').html(hasil);
        });
    }

    function getNotif2() {
        $.ajax({
            url: "<?= site_url('sptpd/get_notif2') ?>",
        }).done(function(hasil) {
            $('#notif_sspd2').html(hasil);
        });
    }
</script>