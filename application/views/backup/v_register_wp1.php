<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/register.css' ?>">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?= base_url() ?>assets/plugin/select2/select2.full.min.js" type="text/javascript"></script>
<!-- EOF CSS INCLUDE -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugin/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugin/select2/select2-bootstrap.min.css">
<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css"> -->

	<!-- Website CSS style -->
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/main.css"> -->

	<!-- Website Font style -->
	<link rel="icon" href="<?= base_url() . 'assets/template/assets/images/users/logo_malang.gif'; ?>" type="image/x-icon" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/css/style_register.css">
	<title>Admin</title>
</head>

<body>

	<div class="container">
		<div class="row main">
			<div class="panel-heading">

				<div class="panel-title text-center ">

					<div class="col-sm-8 col-xs-offset-2">

						<h1 class="title">E-BPHTB KOTA MALANG</h1>
					</div>
				</div>
			</div>
			<div class="main-login main-center">
				<form enctype="multipart/form-data" class="form-horizontal" id="myform" onsubmit="alertq()" method="post" action="<?php echo site_url() ?>/register/add_user">

					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label"></label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span>Form pendaftaran wajib diinput sesuai dengan KTP.</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">No KTP *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="16" class="form-control" name="nik" id="nik" placeholder="Nomor KTP (16 Digit)" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Nama *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="100" class="form-control" name="nama" id="nama" placeholder="Masukan nama sesuai KTP" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="alamat" class="cols-sm-2 control-label">Alamat *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="50" class="form-control" name="alamat" id="alamat" placeholder="Masukan alamat sesuai KTP" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Propinsi *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<select id="propinsi_nik_id_text" name="propinsi" class="form-control select2-c" onchange="lookup_kabupaten_text();" style="">
									<option value=""></option>
									<?php foreach ($propinsi as $propinsi) : ?>
										<option value="<?php echo $propinsi->kd_propinsi; ?>"><?php echo $propinsi->kd_propinsi . ' - ' . $propinsi->nama; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Kabupaten/Kota *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<select id="kotakab_nik_id_text" name="kota" class="form-control select2-c" onchange="lookup_kecamatan_text();" style="">
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Kecamatan *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<select id="kecamatan_nik_id_text" name="Kecamatan" class="form-control select2-c" onchange="lookup_kelurahan_text();" style="">
								</select>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Kelurahan *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<select id="kelurahan_nik_id_text" name="kelurahan" class="form-control select2-c" style="">
								</select>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">RT/RW</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="7" class="form-control" name="rtrw" id="rtrw" placeholder="RT/RW" />
								</select>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label">Kode Pos</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="5" class="form-control" name="kodepos" id="kodepos" placeholder="Masukan Kode Pos" />
								</select>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="cols-sm-2 control-label">Alamat Email *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="45" class="form-control" name="email" id="email" placeholder="Email" />
							</div>
						</div>
					</div>


					<div class="form-group">
						<label for="username" class="cols-sm-2 control-label">No Telepon/HP *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-phone fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="13" class="form-control" name="no_hp" id="no_hp" placeholder="Nomor HP" />
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="username" class="cols-sm-2 control-label">Username *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
								<input type="text" maxlength="15" class="form-control" name="username" id="username" placeholder="Username Min 8 Karakter" />
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="password" class="cols-sm-2 control-label">Password *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
								<input type="password" maxlength="15" class="form-control" name="password" id="password" placeholder="Password Min 8 Karakter" />
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="confirm" class="cols-sm-2 control-label">Confirm Password *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
								<input type="password" maxlength="15" class="form-control" name="confirm" id="confirm" placeholder="Masukan Password lagi" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="confirm" class="cols-sm-2 control-label">Upload Foto KTP *</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
								<input type="file" class="form-control lam" name="foto" id="foto">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="cols-sm-2 control-label"></label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span>(*) wajib diisi<br><br> Dengan menekan tombol Daftar, saya menyatakan bahwa data yang dientri diatas telah sesuai dengan aslinya.</span>
							</div>
						</div>
					</div>

					<div class="form-group ">
						<button type="submit" class="btn btn-primary btn-lg btn-block login-button">DAFTAR</button>
					</div>
					<div class="login-register">
						<br><a href="bphtb">Login</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- <script type="text/javascript" src="assets/js/bootstrap.js"></script> -->
</body>

</html>

<script type="text/javascript">
	$(document).ready(function() {
		// select2();
		$('.lam').change(function() {
			var file = this.files[0];
			name = file.name;
			size = file.size;
			type = file.type;
			if (size > 2200000) {
				alert('File maksimal 2Mb');
				this.value = '';
			}
		});
	});


	function alertq() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/register/get_data',
		}).done(function(data) {
			var nik = $('#nik').val();
			var nama = $('#nama').val();
			var alamat = $('#alamat').val();
			var propinsi = $('#propinsi_nik_id_text').val();
			var kota = $('#kotakab_nik_id_text').val();
			var kecamatan = $('#kecamatan_nik_id_text').val();
			var kelurahan = $('#kelurahan_nik_id_text').val();
			var rtrw = $('#rtrw').val();
			var no_hp = $('#no_hp').val();
			var foto = $('#foto').val();
			var email = $('#email').val();
			data = JSON.parse(data);
			$.each(data, function(index, val) {
				if (nik == val.nik) {
					// console.log('oke');
					alert('Nik Sudah ada');
					return false;
				}
			});

			if (nik.length < 16) {
				alert("NIP harus 16 digit");
				return false;
			} else if (nama == null || nama == '') {
				alert("Nama Harus Diisi");
				return false;
			} else if (alamat == null || alamat == '') {
				alert("Alamat Harus Diisi");
				return false;
			} else if (propinsi == null || propinsi == '') {
				alert("Propinsi Harus Diisi");
				return false;
			} else if (kota == null || kota == '') {
				alert("Kabupaten/Kota Harus Diisi");
				return false;
			} else if (kecamatan == null || kecamatan == '') {
				alert("kecamatan Harus Diisi");
				return false;
			} else if (kelurahan == null || kelurahan == '') {
				alert("kecamatan Harus Diisi");
				return false;
			} else if (email == null || email == '') {
				alert("Email Harus Diisi");
				return false;
			} else if (no_hp == null || no_hp == '') {
				alert("No Hp Harus Diisi");
				return false;
			} else if (foto == null || foto == '') {
				alert("Foto Harus Di upload");
				return false;
			}
			return false;


		});
	}

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

				$('.kb').remove();
				$('.kc').remove();
				$('.kl').remove();
				$('#kotakab_nik_id_text').append(str_kab);
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
				$('.kc').remove();
				$('.kl').remove();
				$('#kecamatan_nik_id_text').append(str_kec);

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