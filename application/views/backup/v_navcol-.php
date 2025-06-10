<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div>
	<h1>Main Menu</h1>
	<div>Login sebagai: <i><?php echo $this->session->userdata('s_nama_bphtb'); ?></i></div>
	<ul class="main_menu">
		<li><a href="<?php echo base_url(); ?>index.php/main">Home</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/main/logout">Log out</a></li>
	</ul>

	<h2>Payment Point</h2>
	<ul class="main_menu">
		<li><a href="<?php echo base_url(); ?>index.php/sptpd">SSPD - BPHTB</a></li>
	</ul>

	<!-- <h2>PBB</h2>
    <ul class="main_menu">
        <?php $data = base64_encode($this->session->userdata('s_username_bphtb') . '|' . $this->session->userdata('s_password_bphtb') . '|' . $this->session->userdata('s_source_site_bphtb')); ?>
        <li><a href="<?php echo $this->config->item('pospbb_site'); ?>start/hot_login/<?php echo $data; ?>" target="_blank">Cetak STTS PBB</a></li>
    </ul> -->

	<h2>Laporan</h2>
	<ul class="main_menu">
		<li><a href="<?php echo base_url(); ?>index.php/sptpd/report">Laporan SSPD - BPHTB</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/nop/report">Laporan Perubahan NOP</a></li>
		<?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
			<li><a href="<?php echo base_url(); ?>index.php/log/login">Laporan Login User</a></li>
		<?php endif; ?>
	</ul>

	<h2>Penerbitan SK</h2>
	<ul class="main_menu">
		<li><a href="<?php echo base_url(); ?>index.php/penerbitanlapangan">Pemeriksaan Lapangan</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/tagihandenda">Tagihan Denda</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/pengantar_permohonan">Pengantar Permohonan</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/tagih_bea">Surat Tagih Bea</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/sk_pengurangan">SK Pengurangan</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/sk_kurang_bayar">Kurang Bayar</a></li>
	</ul>

	<h2>Master Data</h2>
	<ul class="main_menu">
		<li><a href="<?php echo base_url(); ?>index.php/nop">NOP</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ppat">PPAT</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/nik">NIK</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/propinsi">Propinsi</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/dati">Dati</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/kecamatan">Distrik</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/kelurahan">Kelurahan</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/paymentpoint">Payment Point</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/jns_perolehan">Jenis Perolehan</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/rekening">Rekening</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/prefix">Prefix</a></li>
	</ul>

	<?php if ($this->session->userdata('s_tipe_bphtb') == 'D') : ?>
		<h2>Utilitas</h2>
		<ul class="main_menu">
			<li><a href="<?php echo base_url(); ?>index.php/user">User Management</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/setting">setting</a></li>
		</ul>
	<?php endif; ?>
</div>