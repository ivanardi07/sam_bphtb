<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script type="text/javascript">
	function lookup_sspd(string) {
		if (string == '') {
			$('#nama_ppat_id').html('');
		} else {
			$.post("<?php echo base_url(); ?>index.php/penelitian/getSSPD<?php echo ($submitvalue == 'Edit') ? 'Edit' : '' ?>", {
				no_dokumen: "" + string + ""
			}, function(data) {
				if (data) {
					$('#ppat_data_id').html(data);
				}
			});
		}
	}

	function kosong() {
		$("#d_nama").val('');
		$("#d_alamat").val('');
		$("#d_nik").val('');
		$("#d_kelurahan").val('');
		$("#d_kabupaten").val('');
	}

	function loadNoSSPD(v) {
		if (v != '') {
			$.post("<?php echo base_url(); ?>index.php/penelitian/getSSPD<?php echo ($submitvalue == 'Edit') ? 'Edit' : '' ?>", {
				no_dokumen: "" + v + ""
			}, function(data) {
				if (data.valid) {
					$("#d_nama").val(data.nama);
					$("#d_alamat").val(data.alamat);
					$("#d_nik").val(data.nik);
					$("#d_kelurahan").val(data.kelurahan);
					$("#d_kabupaten").val(data.kabupaten);
					$("#tglsspd").val(data.tanggal);
				} else {
					alert(data.message);
					kosong();

				}
			}, "json");
		} else {
			kosong();
		}

	}
	$(function() {
		<?php if ($submitvalue != 'Edit') : ?>
			$("#datepicker").datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				showOn: 'button',
				buttonImage: '<?= base_url_img() ?>calendar.gif',
				buttonImageOnly: true
			});

			$("#datepicker2").datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true,
				showOn: 'button',
				buttonImage: '<?= base_url_img() ?>calendar.gif',
				buttonImageOnly: true
			});
		<?php endif; ?>
		$("#no_sspd").mask('99.99.99.99.99.9999.99.999');

		$("#no_sspd").change(function() {
			var v = $(this).val();
			loadNoSSPD(v);
		});
		loadNoSSPD($("#no_sspd").val());
	});
</script>
<h1><a href="<?php echo $c_loc; ?>">Formulir Penelitian</a> &raquo; <?php echo $submitvalue; ?></h1>
<div class="nav_box">
	[ <a href="<?php echo $c_loc; ?>">Kembali</a> ]
</div>
<h1>Formulir Penelitian</h1>

<?php if (!empty($info)) {
	echo $info;
} ?>
<form action="" method="post" name="frm_nop" enctype="multipart/form-data">
	<table>
		<tbody>
			<tr>
				<td> NO SSPD &raquo; </td>
				<td> <input type="text" class="tb" <?php if ($submitvalue == 'Edit') echo 'readonly'; ?> id="no_sspd" name="no_sspd" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->no_sspd, 'no_sspd'); ?>"> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b></td>
				<td>Tanggal &raquo; </td>
				<td><input id="tglsspd" readonly="readonly" type="text" name="tanggal_no_sspd" style="width: 70px;" class="tb" value="<?php if (@$this->antclass->back_valuex(@$penelitian->tanggal_no_sspd, 'tanggal_no_sspd')) {
																																			echo @$this->antclass->back_valuex(@$penelitian->tanggal_no_sspd, 'tanggal_no_sspd');
																																		} else {
																																		}; ?>" /></td>
			</tr>
			<tr>
				<td> No Formulir &raquo; </td>
				<td> <input type="text" class="tb" <?php if ($submitvalue == 'Edit') echo 'readonly'; ?> value="<?php echo $this->antclass->back_valuex(@$penelitian->no_formulir, 'no_formulir'); ?>" maxlength="100" id="lokasi_id" name="no_formulir"> </td>
				<td> Tanggal&raquo; </td>
				<td> <input id="datepicker2" <?php if ($submitvalue == 'Edit') echo 'readonly'; ?> type="text" name="tanggal_no_formulir" style="width: 70px;" value="<?php if (@$this->antclass->back_valuex(@$penelitian->tanggal_no_formulir, 'tanggal_no_formulir')) {
																																											echo @$this->antclass->back_valuex(@$penelitian->tanggal_no_formulir, 'tanggal_no_formulir');
																																										} else {
																																											echo date('Y-m-d');
																																										}; ?>" class="tb" /> </td>
			</tr>
		</tbody>
	</table>

	<table style="margin-left:30px">
		<tbody>
			<tr>
				<td> Nama Wajib Pajak &raquo; </td>
				<td> <input type="text" class="tb" id="d_nama" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b></td>
			</tr>
			<tr>
				<td> Nik &raquo; </td>
				<td> <input type="text" class="tb" value="" maxlength="100" id="d_nik" name="" disabled=disabled> </td>
			</tr>
			<tr>
				<td> Alamat Wajib Pajak &raquo; </td>
				<td> <input type="text" class="tb" id="d_alamat" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b></td>
			</tr>
			<tr>
				<td> Kelurahan / Desa &raquo; </td>
				<td> <input type="text" class="tb" value="" maxlength="100" id="d_kelurahan" name="" disabled=disabled> </td>
			</tr>
			<tr>
				<td> Kabupaten / Kota &raquo; </td>
				<td> <input type="text" class="tb" id="d_kabupaten" name="" autocomplete="off" disabled=disabled> <b style="background-color:#800;color:#fff;margin-left:20px;padding:0 10px;display:none" id="nop_error"></b></td>
			</tr>
		</tbody>
	</table><br>
	<h1>Lampiran - Lampiran</h1>
	<div style="margin: 10px 0;">
		<table>
			<tbody>
				<tr height="24" valign="top">
					<td> <label for="stb_id"><input type="checkbox" value="1" id="" name="lampiran_sspd_1" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_sspd_1, 'lampiran_sspd_1') == '1' ? 'checked' : ''; ?>> SSPD </label> </td>
					<td style="">
						<input type="file" name="lampiran_sspd_1_file">
						<?php if ($submitvalue == 'Edit') :
							$file = FCPATH . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_sspd_1_file.jpg';
							if (file_exists($file)) :
						?>

								<br> <a class="lightbox" href="<?php echo base_url() . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_sspd_1_file.jpg'; ?>"><img src="<?php echo base_url() . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_sspd_1_file.jpg'; ?>" width="250" /></a>

							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr height="24" valign="top">
					<td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_sspd_2" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_sspd_2, 'lampiran_sspd_2') == '1' ? 'checked' : ''; ?>> SSPD </label> </td>
					<td style="">
						<input type="file" name="lampiran_sspd_2_file">
						<?php if ($submitvalue == 'Edit') :
							$file = FCPATH . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_sspd_2_file.jpg';
							if (file_exists($file)) :
						?>
								<br> <a class="lightbox" href="<?php echo base_url() . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_sspd_2_file.jpg'; ?>"><img src="<?php echo base_url() . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_sspd_2_file.jpg'; ?>" width="250" /></a>


							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr height="24">
				<tr height="24" valign="top">
					<td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopi_identitas" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopi_identitas, 'lampiran_fotocopi_identitas') == '1' ? 'checked' : ''; ?>> Fotocopy Identitas </label> </td>
					<td style="">
						<input type="file" name="lampiran_fotocopi_identitas_file">
						<?php if ($submitvalue == 'Edit') :
							$file = FCPATH . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_fotocopi_identitas_file.jpg';
							if (file_exists($file)) :
						?>
								<br><a class="lightbox" href="<?php echo base_url() . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_fotocopi_identitas_file.jpg'; ?>"><img src="<?php echo base_url() . 'assets/files/penelitian/' . $penelitian->id_formulir . '_lampiran_fotocopi_identitas_file.jpg'; ?>" width="250" /></a>




							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr height="24">
					<td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_surat_kuasa_wp" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_surat_kuasa_wp, 'lampiran_surat_kuasa_wp') == '1' ? 'checked' : ''; ?>> Surat Kuasa Dari Wajib Pajak </label> </td>
				</tr>
				<tr height="24">
					<td colspan=2 style="padding-left:20px">Nama Kuasa Wp <input type="text" class="tb" id="nop_id" name="lampiran_nama_kuasa_wp" autocomplete="off" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_nama_kuasa_wp, 'lampiran_nama_kuasa_wp'); ?>"> Alamat Kuasa Wp <input type="text" class="tb" id="nop_id" name="lampiran_alamat_kuasa_wp" value="<?php echo $this->antclass->back_valuex(@$penelitian->lampiran_alamat_kuasa_wp, 'lampiran_alamat_kuasa_wp'); ?>" autocomplete="off"> </td>
				</tr>
				<tr height="24">
					<td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_identitas_kwp" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_identitas_kwp, 'lampiran_fotocopy_identitas_kwp') == '1' ? 'checked' : ''; ?>> Fotocopy Identitas Kuasa Wajib Pajak </label> </td>
				</tr>
				<tr height="24">
					<td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_fotocopy_kartu_npwp" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_fotocopy_kartu_npwp, 'lampiran_fotocopy_kartu_npwp') == '1' ? 'checked' : ''; ?>> Fotocopy kartu Npwp</label> </td>
				</tr>
				<tr height="24" valign=top>
					<td> <label for="skbkb_id"><input type="checkbox" value="1" id="" name="lampiran_identitas_lainya" <?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya, 'lampiran_identitas_lainya') == '1' ? 'checked' : ''; ?>> Identitas lainya</label> </td>
					<td style="">
						<textarea cols=50 rows=3 name="lampiran_identitas_lainya_val"><?php echo $this->antclass->back_valuex(@$penelitian->lampiran_identitas_lainya_val, 'lampiran_identitas_lainya_val'); ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<h1>Penelitian</h1>
	<div style="margin: 10px 0;">
		<table>
			<tbody>
				<tr>
					<td>
						<input type="checkbox" <?php echo $this->antclass->back_valuex(@$penelitian->penelitian_data_objek, 'penelitian_data_objek') == '1' ? 'checked' : ''; ?> name="penelitian_data_objek" value="1"> &nbsp;- Data objek pajak yang tercantum dalam sppd - bphtb telah sesuai
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" <?php echo $this->antclass->back_valuex(@$penelitian->penelitian_nilai_bphtb, 'penelitian_nilai_bphtb') == '1' ? 'checked' : ''; ?> name="penelitian_nilai_bphtb" value="1"> &nbsp;- Nilai BPHTB terutang yang tercantum dalam SSPD-BPHTB telah sesuai
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" <?php echo $this->antclass->back_valuex(@$penelitian->penelitian_dokumen, 'penelitian_dokumen') == '1' ? 'checked' : ''; ?> name="penelitian_dokumen" value="1"> &nbsp;- Dokumen pendukung perolehan hak atas tanah dan bangunan telah lengkap
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<h1></h1>
	<div style="margin: 10px 0;">
		<table>
			<tbody>
				<tr>
					<td>
						Nama petugas fungsi pelayanan &nbsp; <?php echo form_dropdown('id_pegawai', $pegawais, $this->antclass->back_valuex(@$penelitian->id_pegawai, 'id_pegawai'), 'class="tb"'); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div align="center">
		<!--    <input type="button" name="" value="Sebelumnya" class="bt" /> -->
		<input type="submit" name="simpan" value="<?php echo $submitvalue; ?>" class="bt" />
		<!--    <input type="button" name="" value="Tutup" class="bt" />
            <input type="button" name="" value="Lanjut" class="bt" />
            <input type="button" name="" value="Preview" class="bt" /> -->
	</div>
</form>