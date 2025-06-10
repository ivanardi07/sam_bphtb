<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<!-- <section class="content-header">
		<h1>
			DATA WAJIB PAJAK
			<small></small>
		</h1>
	</section> -->
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">DATA WAJIB PAJAK</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="row">
						<div class="col-md-12">
							<form role="form" method="POST" action="<?php echo base_url(); ?>index.php/aprove_user/action_aprove">
								<div class="box-body">
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">No KTP</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->nik ?>" name="nik" id="nik" placeholder="Masukan No KTP" />
												<input type="hidden" class="form-control" value="<?= $user->id_user ?>" name="id">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Nama</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->nama ?>" name="nama" id="nama" placeholder="Masukan Nama" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Alamat</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->alamat ?>" name="alamat" id="alamat" placeholder="Masukan Alamat" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Propinsi</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<select id="propinsi_nik_id_text" name="propinsi" class="form-control select2-c" onchange="lookup_kabupaten_text();" style="">
													<option value=""></option>
													<?php foreach ($propinsi as $propinsi) : ?>
														<option value="<?php echo $propinsi->kd_propinsi; ?>" <?= @$user->kd_propinsi == @$propinsi->kd_propinsi ? 'selected' : '' ?>><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Kabupaten</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<select id="kotakab_nik_id_text" name="kota" class="form-control select2-c" onchange="lookup_kecamatan_text();" style="">
													<?php foreach ($kabupaten as $kabupaten) : ?>
														<option value="<?php echo $kabupaten->kd_kabupaten; ?>" <?= @$user->kd_kabupaten == @$kabupaten->kd_kabupaten ? 'selected' : '' ?>><?php echo $kabupaten->kd_kabupaten . ' - ' . $kabupaten->nama; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Kecamatan</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<select id="kecamatan_nik_id_text" name="kecamatan" class="form-control select2-c" onchange="lookup_kelurahan_text();" style="">
													<?php foreach ($kecamatan as $kecamatan) : ?>
														<?php if ($kecamatan->kd_kecamatan == @$user->kd_kecamatan) : ?>
															<option value="<?php echo $kecamatan->kd_kecamatan; ?>" <?= @$user->kd_kecamatan == @$kecamatan->kd_kecamatan ? 'selected' : '' ?>><?php echo $kecamatan->kd_kecamatan . ' - ' . $kecamatan->nama; ?></option>
														<?php endif ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Kelurahan</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<select id="kelurahan_nik_id_text" name="kelurahan" class="form-control select2-c" style="">
													<?php foreach ($kelurahan as $kelurahan) : ?>
														<?php if ($kelurahan->kd_kelurahan == @$user->kd_kelurahan) : ?>
															<option value="<?php echo $kelurahan->kd_kelurahan; ?>" <?= @$user->kd_kelurahan == @$kelurahan->kd_kelurahan ? 'selected' : '' ?>><?php echo $kelurahan->kd_kelurahan . ' - ' . $kelurahan->nama; ?></option>
														<?php endif ?>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">RT/RW</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->rtrw ?>" name="rtrw" id="rtrw" placeholder="Masukan RTRW" />
												</select>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="name" class="cols-sm-2 control-label">Kode Pos</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->kodepos ?>" name="kodepos" id="kodepos" placeholder="Masukan RTRW" />
												</select>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label for="email" class="cols-sm-2 control-label">Email</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-envelope fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->email ?>" name="email" id="email" placeholder="Masukan Email" />
											</div>
										</div>
									</div>


									<div class="form-group">
										<label for="username" class="cols-sm-2 control-label">No HP</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-phone fa"></i></span>
												<input type="text" class="form-control" value="<?= $user->no_hp ?>" name="no_hp" id="no_hp" placeholder="Masukan No HP" />
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="confirm" class="cols-sm-2 control-label">Foto KTP</label>
										<div class="cols-sm-10">
											<div class="input-group">
												<?php
												$full_path = FCPATH . $user->foto;
												if (file_exists($full_path)) {
													$disabled = "";
												} else {
													$disabled = "disabled";
												}
												?>
												<a class="btn btn-info" target="_blank" href="<?= base_url() . $user->foto ?>" <?= $disabled ?>>Lihat</a>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="confirm" class="cols-sm-2 control-label">Infokan Ke WP</label>
										<div class="cols-sm-10">
											<?php
											$currentAdminName = ($this->session->userdata('s_nama_bphtb')) ? $this->session->userdata('s_nama_bphtb') : $this->session->userdata('s_username_bphtb');
											// $formatSetuju = "Yth Bpk/Ibu " . ucwords($user->nama) . ", Saya $currentAdminName dari BAPENDA KOTA MALANG.

											// 	Menginformasikan bahwa pengajuan akun E-BPHTB anda sudah *berhasil diverifikasi* dan dapat digunakan, untuk melakukan login dapat melalui alamat berikut

											// 	" . urlencode("http://pajak.malangkota.go.id:8088/bphtb_malang/") . "

											// 	Gunakan username dan password sesuai dengan yang telah anda inputkan di form pendaftaran, Terimakasih.";

											// $formatPenolakan = "Yth Bpk/Ibu " . ucwords($user->nama) . ", Saya $currentAdminName dari BAPENDA KOTA MALANG.

											// Menginformasikan bahwa pengajuan akun E-BPHTB anda gagal dikarenakan ALASANNYA, Terimakasih.

											// " . urlencode("http://pajak.malangkota.go.id:8088/bphtb_malang/");

											$formatSetuju 		= "https://web.whatsapp.com/send?phone=62" . substr($user->no_hp, 1) . "&text=Yth%20Bpk%2FIbu%20" . ucwords($user->nama) . "%2C%20Saya%20" . $currentAdminName . "%20dari%20BAPENDA%20KOTA%20MALANG.%0A%0AMenginformasikan%20bahwa%20pengajuan%20akun%20E-BPHTB%20sudah%20terverifikasi%20dan%20dapat%20digunakan%2C%20untuk%20melakukan%20login%20dapat%20melalui%20alamat%20berikut%2C%20Terimakasih.%0A%0Ahttp%3A%2F%2Fpajak.malangkota.go.id%2Fbphtb%2F";
											$formatPenolakan 	= "https://web.whatsapp.com/send?phone=62" . substr($user->no_hp, 1) . "&text=Yth%20Bpk%2FIbu%20" . ucwords($user->nama) . "%2C%20Saya%20" . $currentAdminName . "%20dari%20BAPENDA%20KOTA%20MALANG.%0A%0AMenginformasikan%20bahwa%20pengajuan%20akun%20E-BPHTB%20anda%20gagal%20dikarenakan%20ALASANNYA%2C%20Terimakasih.%0A%0Ahttp%3A%2F%2Fpajak.malangkota.go.id%2Fbphtb%2F";

											// $urlSetuju 			= str_replace(
											// 	array("{{NOMORTLP}}", "{{TEXT}}"),
											// 	array($user->no_hp, $formatSetuju),
											// 	"https://wa.me/{{NOMORTLP}}?text={{TEXT}}"
											// );
											// $urlTolak 	= str_replace(
											// 	array("{{NOMORTLP}}", "{{TEXT}}"),
											// 	array($user->no_hp, $formatPenolakan),
											// 	"https://wa.me/{{NOMORTLP}}?text={{TEXT}}"
											// );
											?>
											<a class="btn btn-success" target="_blank" href="<?= $formatSetuju  ?>">Infokan Setuju Ke WP</a>
										</div>
									</div>
								</div>
								<br>
								<!-- /.box-body -->

								<div class="box-footer">
									<button type="submit" class="btn btn-primary">Setujui</button>
									<a class="btn btn-danger" data-toggle="modal" data-target="#myModal"> Tolak </a>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /.box -->


			</div>
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

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
							<label for="exampleInputName2" class="col-sm-2 control-label">Alasan</label>
							<div class="col-sm-10">
								<textarea class="form-control alasan" id="exampleInputName2" name="alasan_reject" id="alasan_reject"></textarea>
								<input type="hidden" class="form-control" value="<?= $user->id_user ?>" name="id">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<a class="btn btn-danger btn-tolak" target="_blank" href="<?= $formatPenolakan ?>">Infokan Penolakan Ke WP</a>
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

<script type="text/javascript">
	var formatPenolakan = "<?= $formatPenolakan ?>";
	$(document).ready(function() {
		// select2();

		$(".btn-tolak").click(function(e) {
			var alasanValue = $(".alasan").val();
			if (alasanValue == "") {
				var btnNewValue = formatPenolakan.replaceAll("%20dikarenakan%20ALASANNYA", "");
			} else {
				var btnNewValue = formatPenolakan.replaceAll(/ALASANNYA/g, alasanValue);
			}
			$(this).attr("href", btnNewValue);
			return true;
		});
	});

	function lookup_kabupaten_text() {
		// console.log($('#propinsi_nik_id_text').val());
		var string = $('#propinsi_nik_id_text').val();
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/register/get_kab",
			type: "POST",
			data: "propinsi_id=" + string,
			cache: false,
			success: function(data) {
				// $str =''
				data = JSON.parse(data);
				var str_kab = '<option  class="kb" value="">Pilih Kabupaten</option>';
				$.each(data, function(i, val) {

					str_kab += '<option class="kb" value="' + val.kd_kabupaten + '">' + val.nama + '</option>';
				});

				// $('#kecamatan_nik_id_text').remove();

				$('#kelurahan_nik_id_text').find('option').remove().end();
				$('#kecamatan_nik_id_text').find('option').remove().end();
				$('#kotakab_nik_id_text').find('option').remove().end().append(str_kab);
			}
		});
	}


	function lookup_kecamatan_text() {
		var id_p = $('#propinsi_nik_id_text').val();
		var id_kab = $('#kotakab_nik_id_text').val();
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/register/get_kec",
			type: "POST",
			data: {
				id_p: id_p,
				id_kab: id_kab
			},
			cache: false,
			success: function(data) {
				// $str =''
				data = JSON.parse(data);
				var str_kec = '<option class="kc" value="">Pilih Kecamatan</option>';
				console.log(data);
				$.each(data, function(i, val) {

					str_kec += '<option class="kc" value="' + val.kd_kecamatan + '">' + val.nama + '</option>';
				});

				// $('#kecamatan_nik_id_text').remove();

				$('#kelurahan_nik_id_text').find('option').remove().end();
				$('#kecamatan_nik_id_text').find('option').remove().end().append(str_kec);

			}
		});
	}


	// Jika Session Kecamatan ada




	/* Memilih kelurahan */

	function lookup_kelurahan_text() {
		var kd_propinsi = $('#propinsi_nik_id_text').val();
		var kd_kabupaten = $('#kotakab_nik_id_text').val();
		var string = $('#kecamatan_nik_id_text').val();
		if (string == '') {
			$('#kelurahan_nik_id_text').html('');
		} else {
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/register/get_kel",
				type: "POST",
				data: {
					id_p: kd_propinsi,
					id_kab: kd_kabupaten,
					id_kec: string,
				},
				cache: false,
				success: function(data) {
					// console.log()
					// $str =''
					data = JSON.parse(data);
					var str_kel = '<option class="kl" value="">Pilih Kelurahan</option>';
					console.log(data);
					$.each(data, function(i, val) {

						str_kel += '<option class="kl" value="' + val.kd_kelurahan + '">' + val.nama + '</option>';
					});

					// $('#kecamatan_nik_id_text').remove();
					$('.kl').remove();
					$('#kelurahan_nik_id_text').append(str_kel);
				}
			});
		}
	}

	// JIka Session KELURAHAN ADA maka
	<?php if ($this->session->userdata('s_kd_kelurahan_nik') != '') { ?>


		var id_kecamatan = "<?php echo $this->session->userdata('s_kd_kecamatan_nik'); ?>";
		var id_kelurahan = "<?php echo $this->session->userdata('s_kd_kelurahan_nik'); ?>";
		// alert(id_kabupaten);
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/sptpd/get_kelurahan_bykecamatan_session?kd_kecamatan=" + id_kecamatan + "&kd_kelurahan=" + id_kelurahan,
			success: function(data) {
				$('#kelurahan_nik_id_text').html(data);
			}
		});
	<?php }
	?>
</script>