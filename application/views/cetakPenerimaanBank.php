<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>
	<title></title>
	<style type="text/css">
		.oke {
			border: 1px solid black;
		}
	</style>
</head>

<body>
	<div style="text-align: center; font-family:sans-serif;">
		<h6>LAPORAN PENERIMAAN BANK</h6>
	</div>
	<div style="font-family:sans-serif; font-size: 10px;">
		<table style="border-collapse: collapse;" class="oke">
			<thead>
				<tr>
					<th class="oke">NO</th>
					<th class="oke">TANGGAL</th>
					<th class="oke">NOP</th>
					<th class="oke">PENJUAL</th>
					<th class="oke">ALAMAT PENJUAL</th>
					<th class="oke">PEMBELI</th>
					<th class="oke">ALAMAT PEMBELI</th>
					<th class="oke">NO SERTIFIKAT</th>
					<th class="oke">JUMLAH BAYAR</th>
					<th class="oke">BANK</th>
				</tr>
			</thead>
			<tbody>
				<?php $start = 1;
				foreach ($laporan as $key => $value) : ?>
					<?php
					$nop = $value->kd_propinsi . '.' . $value->kd_kabupaten . '.' . $value->kd_kecamatan . '.' . $value->kd_kelurahan . '.' . $value->kd_blok . '.' . $value->no_urut . '.' . $value->kd_jns_op;
					?>
					<tr class="oke">
						<td class="oke"><?= $start++; ?></td>
						<td class="oke"><?= $value->tanggal ?></td>
						<td class="oke"><?= $nop ?></td>
						<td class="oke"><?= $value->nama_penjual ?></td>
						<td class="oke"><?= $value->alamat_penjual ?></td>
						<td class="oke"><?= $value->nama_pembeli ?></td>
						<td class="oke"><?= $value->alamat_pembeli ?></td>
						<td class="oke"><?= $value->no_sertifikat_op ?></td>
						<td class="oke" style="text-align: right;"><?= number_format($value->jumlah_setor, 0, ',', '.') ?></td>
						<td class="oke"><?= $value->nama_bank ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

</body>

</html>