<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en" class="body-full-height">

<head>
	<!-- META SECTION -->
	<title><?php echo $this->config->item('site_name'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Cendana2000" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />

	<link rel="icon" href="<?= base_url() . 'assets/template/assets/images/users/logo_malang.gif'; ?>" type="image/x-icon" />
	<!-- END META SECTION -->

	<!-- CSS INCLUDE -->
	<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/bootstrap/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/theme-default.css" />
	<link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/mystyle.css" />
	<link rel="stylesheet" type="text/css" id="theme" href="<?= base_url() ?>assets/template/css/style_27012015.css" />

	<script type="text/javascript" src="<?= base_url() ?>assets/template/js/plugins/jquery/jquery.min.js"></script>
	<!-- EOF CSS INCLUDE -->
</head>

<body>

	<div class="login-container">

		<div class="login-box animated fadeInDown">

			<div id="formlogin">
				<div class="login-logo"><span class="logo-text">SAM-BPHTB</span></div>
				<div class="login-body">
					<form name="frm_login" method="post" action="<?php echo site_url() ?>/register/acc_verifikasi" class="form-horizontal">
						<div class="row">

							<div class=" col-md-12">
								<div class="form-group">
									<div class="col-md-12" align="center">
										<span style="font-size: 20px;text-align: center">Masukan Kode Verifikasi</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">

										<input type="hidden" name="user" id="user" value="<?php echo $user ?>">
										<input type="hidden" name="kode" id="hidden" value="<?php echo $kode ?>">
										<input type="text" class="form-control" style="background-color:white; color: #555; border: 1px solid #D5D5D5" name="inputan" id="inp" value="">

										<br>
										<span>* Cek email anda yang anda masukan saat register untuk mengetahui kode verifikasi</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12" align="center">

										<button type="submit" class="btn btn-info btn-block btn-lg" target="blank" onclick="return cek()">Verifikasi</button>
										<a class="" style="margin-right: 10px" href="<?php echo site_url() ?>/bphtb">Login</a>
										<a class="" href="<?php echo site_url() ?>/register">Register</a>

									</div>
								</div>

							</div>


						</div>

				</div>
				</form>
			</div>

</body>

</html>


<script type="text/javascript">
	function cek() {
		var user = $('#user').val();
		var a = $('#hidden').val();
		var b = $('#inp').val();

		if (a != b) {
			alert('Kode Tidak Sama');
			return false;
		}

		return true;

		// $.post( "<?php echo site_url() ?>"+"/register/acc_verifikasi",{data:user}, function( data ) {
		// 	alert('verifikasi Berhasil Silahkan Login');
		// });

	}
</script>