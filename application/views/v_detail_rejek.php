<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
//$stts = $sptpd->status_sspd;
$nop  = $sptpd->kd_propinsi . '.' . $sptpd->kd_kabupaten . '.' . $sptpd->kd_kecamatan . '.' . $sptpd->kd_kelurahan . '.' . $sptpd->kd_blok . '.' . $sptpd->no_urut . '.' . $sptpd->kd_jns_op;

if ($sptpd->is_lunas == '1') {
	$lunas = 'Lunas';
} elseif ($sptpd->is_lunas == '2') {
	$lunas = 'Verifikasi';
} elseif ($sptpd->is_lunas == '3') {
	$lunas = 'Dokumen Dikembalikan';
} elseif ($sptpd->validasi_dispenda != '') {
	$lunas = 'SUDAH Diverifikasi Bapenda - Belum Lunas';
} else {
	$lunas = 'BELUM Diverifikasi Bapenda - Belum Lunas';
}

// $status = $stts_sspd . ' - ' . $lunas;
$status = $lunas;

?>
<div class="row">
	<div class="col-md-12">
		<center>
			<h3>Detail SSPD</h3>
		</center>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table">
			<tbody>
				<tr>
					<td width="20%">No. SSPD</td>
					<td width="5%">:</td>
					<td><?= $sptpd->no_dokumen ?></td>
				</tr>
				<tr>
					<td width="20%">PPAT / Notaris</td>
					<td width="5%">:</td>
					<td><?= $ppat->nama ?></td>
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
				<?php if (@$sptpd->alasan_reject != '' && $sptpd->validasi_dispenda == '') : ?>
					<tr>
						<td>Alasan Reject</td>
						<td>:</td>
						<td><b><?= @$sptpd->alasan_reject ?></b></td>
					</tr>
				<?php endif ?>
				<?php if ($sptpd->proses == "2") : ?>
					<tr>
						<td colspan="3" style="text-align: center;font-weight:bold">INFO TAGIHAN</td>
					</tr>
					<tr>
						<td>ID Billing Bank Jatim</td>
						<td>:</td>
						<td><?php print_r($sptpd->idbilling); ?></td>
					</tr>
					<tr>
						<td>Virtual Account Bank Jatim</td>
						<td>:</td>
						<td><span class="va"><?= @$sptpd->va_jatim; ?></span><span class="copy-va" style="float: right;"><i class="fa fa-copy"></i></span></td>
					</tr>
					<tr>
						<td>QRIS</td>
						<td>:</td>
						<td><img style="<?= @$sptpd->qr_code == "" ? "width:95%" : "width:25%" ?>" src="<?= @$sptpd->qr_image ?>"></td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>