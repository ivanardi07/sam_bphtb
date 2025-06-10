<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

// $stts = $sptpd->status_sspd;
$nop  = $sptpd->kd_propinsi . '.' . $sptpd->kd_kabupaten . '.' . $sptpd->kd_kecamatan . '.' . $sptpd->kd_kelurahan . '.' . $sptpd->kd_blok . '.' . $sptpd->no_urut . '.' . $sptpd->kd_jns_op;

if ($sptpd->is_lunas == '1') {
	$lunas = 'Lunas';
} elseif ($sptpd->is_lunas == '2') {
	$lunas = 'Verifikasi';
} elseif ($sptpd->is_lunas == '3') {
	$lunas = 'Dokumen Dikembaikan';
} elseif ($sptpd->validasi_dispenda != '') {
	$lunas = 'SUDAH Diverifikasi Bapenda - Belum Lunas';
} else {
	$lunas = 'BELUM Diverifikasi Bapenda - Belum Lunas';
}

$status = $lunas;

?>
<div class="row">
	<div class="col-md-12">
		<center>
			<h3>Bukti Pendaftaran SSPD</h3>
		</center>
	</div>
</div>
<div class="row" style="margin-top:100px ">
	<div class="col-md-12">
		<table class="table">
			<tbody>
				<tr>
					<td width="30%">No. SSPD</td>
					<td width="5%">:</td>
					<td><?= $sptpd->no_dokumen ?></td>
				</tr>
				<tr>
					<td>Kode Validasi</td>
					<td>:</td>
					<td><?= $sptpd->kode_validasi ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?= @$nik->nama ?></td>
				</tr>
				<tr>
					<td>NIK</td>
					<td>:</td>
					<td><?= @$nik->nik ?></td>
				</tr>
				<tr>
					<td>NOP</td>
					<td>:</td>
					<td><?= $nop ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?= @$nik->alamat ?></td>
				</tr>
				<tr>
					<td>Jumlah Yang Disetor</td>
					<td>:</td>
					<td>Rp. <?php echo number_format(@$sptpd->jumlah_setor, 0, ',', '.'); ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td>:</td>
					<td><b><?= $status ?></b></td>
				</tr>
				<?php if ($sptpd->is_lunas == '3') : ?>
					<tr>
						<td>Alasan</td>
						<td>:</td>
						<td><b><?= $sptpd->alasan_reject ?></b></td>
					</tr>
				<?php endif ?>
			</tbody>
		</table>
	</div>
</div>

<div class="row" style="float:right; width:300px">
	<div class="col-md-offset-9 col-md-3 text-center">
		<center>
			<p><?= tanggal_indonesia(changeDateFormat('webview', $sptpd->tanggal)) ?></p>
			<br>
			<br>
			<p><?= $ppat->nama ?></p>
		</center>
	</div>
</div>