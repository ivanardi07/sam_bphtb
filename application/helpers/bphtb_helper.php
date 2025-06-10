<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

function encode($data)
{
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function decode($data)
{
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function succ_msg($string = '')
{
	$msg = '<br><div role="alert" class="alert alert-success">
                <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>Success!</strong> ' . $string . '
            </div>';

	return $msg;
}

function tgl_format($tgl, $format = "")
{
	if ($format == "") {
		$tanggal    = date('d', strtotime($tgl));
		$bulan      = date('m', strtotime($tgl));
		$tahun      = date('Y', strtotime($tgl));

		return $tanggal . '-' . $bulan . '-' . $tahun;
	} elseif ($format == 'd/m/Y') {
		$tanggal    = date('d', strtotime($tgl));
		$bulan      = date('m', strtotime($tgl));
		$tahun      = date('Y', strtotime($tgl));

		return $tanggal . '-' . $bulan . '-' . $tahun;
	}
}

function tgl_format_jam($tgl, $format = "")
{
	if ($format == "") {
		$tanggal    = date('d', strtotime($tgl));
		$bulan      = date('m', strtotime($tgl));
		$tahun      = date('Y', strtotime($tgl));
		$jam      	= date('H', strtotime($tgl));
		$menit      = date('i', strtotime($tgl));
		$detik      = date('s', strtotime($tgl));

		return $tanggal . '/' . $bulan . '/' . $tahun . ' ' . $jam . ':' . $menit . ':' . $detik;
	} elseif ($format == 'd/m/Y') {
		$tanggal    = date('d', strtotime($tgl));
		$bulan      = date('m', strtotime($tgl));
		$tahun      = date('Y', strtotime($tgl));

		return $tanggal . '-' . $bulan . '-' . $tahun;
	}
}

function err_msg($string = '')
{
	$msg = '<br><br><div role="alert" class="alert alert-danger">
                <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>Failed!</strong> ' . $string . '
            </div>';

	return $msg;
}

function cek_sptpd($id_user = '')
{
	$CI = &get_instance();

	$CI->load->model('mod_user', 'mdb');

	$id_ppat = $CI->mdb->cek_id_ppat($id_user);

	$sptpd = $CI->mdb->get_sptpd($id_ppat);

	if ($sptpd != '') {
		return 'ada';
	} else {
		return 'kosong';
	}
}

function cek_data_lokasi($id = '', $type = '')
{
	$CI = &get_instance();

	$CI->load->model('mod_global', 'mdb');

	$cek = $CI->mdb->cekData($id, $type);

	if ($cek != '') {
		return 'ada';
	} else {
		return 'kosong';
	}
}

function getNamaBank($id = '', $type)
{
	$CI = &get_instance();

	$CI->load->model('mod_global', 'mdb');

	$cek = $CI->mdb->getNamaBank($id);

	if ($type == 'nama') {
		// $data = $cek->nama;
		@$cek->nama ? $data = $cek->nama : @$data = '';
	}
	if ($type == 'alamat') {
		// $data = @$cek->alamat;
		@$cek->alamat ? $data = $cek->alamat : @$data = ' ';
	}

	return $data;
}

function tanggalIndo($tgl = '')
{
	$tanggal = explode('-', $tgl);

	$tanggal = @$tanggal[2] . '-' . @$tanggal[1] . '-' . @$tanggal[0];

	return $tanggal;
}

function download_file($nama_file = '', $lokasi_file = '')
{
	force_download($name_file, $lokasi_file);
}

function formatrupiah($angka)
{
	$jadi = 'Rp. ' . number_format($angka, 0, ',', '.');

	return $jadi;
}

function rupiah($angka)
{
	$jadi = number_format($angka, 0, ',', '.');

	return $jadi;
}

function changeDateFormat($format, $date)
{
	if ($date == '') {
		return '';
	}

	switch ($format) {
		case "database":
			return date('Y-m-d', strtotime($date));
			break;
		case "webview":
			return date('d-m-Y', strtotime($date));
			break;
		case "datepicker":
			return date('m/d/Y', strtotime($date));
			break;
		case "download":
			return date('d/m/Y', strtotime($date));
			break;
	}
}

function tanggal_indonesia($tanggal)
{

	$date = date('Y-m-d', strtotime($tanggal)); // ubah sesuai format penanggalan standart

	$bulan = array(
		'01' => 'Januari', // array bulan konversi
		'02'                => 'Februari',
		'03'                => 'Maret',
		'04'                => 'April',
		'05'                => 'Mei',
		'06'                => 'Juni',
		'07'                => 'Juli',
		'08'                => 'Agustus',
		'09'                => 'September',
		'10'                => 'Oktober',
		'11'                => 'November',
		'12'                => 'Desember',
	);
	$date = explode('-', $date); // ubah string menjadi array dengan paramere '-'

	return $date[2] . ' ' . $bulan[$date[1]] . ' ' . $date[0]; // hasil yang di kembalikan
}

function bulan_indonesia_now()
{

	$date = date('Y-m-d'); // ubah sesuai format penanggalan standart

	$bulan = array(
		'01' => 'Januari', // array bulan konversi
		'02'                => 'Februari',
		'03'                => 'Maret',
		'04'                => 'April',
		'05'                => 'Mei',
		'06'                => 'Juni',
		'07'                => 'Juli',
		'08'                => 'Agustus',
		'09'                => 'September',
		'10'                => 'Oktober',
		'11'                => 'November',
		'12'                => 'Desember',
	);
	$date = explode('-', $date); // ubah string menjadi array dengan paramere '-'

	return $bulan[$date[1]] . ' ' . $date[0]; // hasil yang di kembalikan
}


function decode_image($base64_string, $output_file)
{
	if (!empty($base64_string)) {
		$ifp = fopen($output_file, "wb");

		$foto = '';
		$foto .= 'data:image/jpg;base64,' . $base64_string;

		$data = explode(',', $foto);

		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);

		return $output_file;
	} else {
		return '';
	}
}

function resize_image($file, $w, $h, $crop = FALSE)
{
	list($width, $height) = getimagesize($file);
	$r = $width / $height;
	if ($crop) {
		if ($width > $height) {
			$width = ceil($width - ($width * abs($r - $w / $h)));
		} else {
			$height = ceil($height - ($height * abs($r - $w / $h)));
		}
		$newwidth = $w;
		$newheight = $h;
	} else {
		if ($w / $h > $r) {
			$newwidth = $h * $r;
			$newheight = $h;
		} else {
			$newheight = $w / $r;
			$newwidth = $w;
		}
	}
	$src = imagecreatefromjpeg($file);
	$dst = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	return $dst;
}

function idbilling($no_dokumen)
{
	if (strlen($no_dokumen < 20)) {
		$x = substr($no_dokumen, 3, 12);
	} else {
		$x = substr($no_dokumen, 10, 12);
	}

	$nopel_explode = explode(".", $no_dokumen);
	$order = sprintf("%05d", (int)"$nopel_explode[3]");

	$fix   = '3573000';
	$date  = date('y') . date('m') . date('d');

	$result = $fix . $date . $order;

	return $result;
}
