<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['site_name']          = 'SAM-BPHTB';
$config['dispenda_site_name'] = 'Bapenda';
$config['pp_site_name']       = 'Payment Point';
$config['wp'] 			      = 'Wajib Pajak';

//$config['pospbb_site'] = 'http://localhost/cendana/jayapura/pospbb/';

$config['header'] 	= 'BPHTB MALANG';

$config['LOGO_KOTA']  = 'logo_edit.png';
$config['NAMA_DINAS'] = "BADAN PENDAPATAN DAERAH KOTA MALANG";

/*
 * Pengaturan Input ID PPAT | ID NOP | No Document | NOP PBB Baru
 *
 * view
 *  |--> v_sptpdform [line 77-126]
 *  |--> v_nopform [line 31-47]
 *  |--> v_ppatform [line 2-18]
 */
$config['conf_kd_propinsi'] = '35';
$config['conf_kd_kabupaten'] = '73';
$config['input_ppat_id']  = "99999";
$config['length_ppat_id'] = 5;

$config['input_nop_id']  = "99.99.999.999.999.9999.9";
$config['length_nop_id'] = 24;

$config['input_document_sptpd']  = "99.99.9999.9999.999";
$config['length_document_sptpd'] = 19;

$config['input_nop_pbb_baru']  = "99.99.999.999.999.9999.9";
$config['length_nop_pbb_baru'] = 24;

$config['conf_npoptkp']     = 80000000;
$config['conf_npoptkp_300'] = 400000000;
$config['conf_npoptkp_49']  = 49000000;
$config['conf_npoptkp_10']  = 60000000;
$config['conf_npoptkp_60']  = 80000000;
$config['conf_npoptkp_pbb'] = 6000000;

$config['img_op_path'] = FCPATH . 'assets/images/op/';

// $config['url_service_nop']                = 'http://localhost/malang/index.php/';
// $config['url_service_nop']                = 'http://27.124.92.114/sismiop/';
// $config['url_service_history_pembayaran'] = 'http://27.124.92.114/sismiop/web_service/gethistorynop?nop=';
// $config['url_service_nop']                = 'http://192.168.1.106/sis_project/sismiop_blitar/';
// $config['url_service_history_pembayaran'] = 'http://192.168.1.106/sis_project/sismiop_blitar/web_service/gethistorynop?nop=';

$base_url = $this->config['base_url'].'/';
$config['url_service_nop']                	= $base_url;
$config['url_service_history_pembayaran'] 	= $base_url.'web_service/gethistorynop?nop=';
$config['url_service_history_pembayaran_2'] = $base_url.'web_service/gethistorynop2?nop=';

//$config['url_service_nop']                	= 'http://192.168.0.199/malang/index.php/';
//$config['url_service_history_pembayaran'] 	='http://192.168.0.199/malang/index.php/web_service/gethistorynop?nop=';
//$config['url_service_history_pembayaran_2'] = 'http://192.168.0.199/malang/index.php/web_service/gethistorynop2?nop=';
