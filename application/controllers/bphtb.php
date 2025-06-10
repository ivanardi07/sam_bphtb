<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * Filename: bpthb.php
 * Description: Login controller
 * Date created: 2011-03-04
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Bphtb extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin: *");
		$this->produk = "BPHTB";
		// ini ngetes

		// ====================== AKTIVASI APP ===============================================================

		// if (@$_POST['aktifkan']) {
		//     $this->aktifkan();
		// } else {
		//     $this->check_activate();
		// }

		// ====================== END AKTIVASI APP ===============================================================

		$this->load->model('mod_user');
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('captcha');
	}

	private function _create_captcha()
	{
		// we will first load the helper. We will not be using autoload because we only need it here
		$original_string = array_merge(range(0, 9));
		$original_string = implode("", $original_string);
		$captcha = substr(str_shuffle($original_string), 0, 3);

		$vals = array(
			'word'          => $captcha,
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url() . 'assets/captcha/',
			'font_path'     => FCPATH . 'assets\fonts\verdana.ttf',
			'font_size'     => 14,
			'img_width'     => '100',
			'img_height'    => 43,
			'expiration'    => 30,
			'colors'        => array(
				'background'     => array(255, 160, 119),
				'border'         => array(255, 255, 255),
				'text'           => array(40, 84, 164),
				'grid'           => array(40, 84, 164)
			)
		);
		$c_captcha 	= create_captcha($vals);
		$image 		= $c_captcha['image'];
		$this->session->set_userdata('captchaCode1', $c_captcha['word']);
		// we will return the image html code
		return $image;
	}

	public function check_captcha($string)
	{

		if ($string == $this->session->userdata('captchaCode1')) {
			return TRUE;
		} elseif ($string == '') {
			return false;
		} else {
			$this->form_validation->set_message('check_captcha', 'Wrong captcha code');
			return false;
		}
	}

	public function index()
	{

		if ($this->session->userdata('s_username_bphtb') != '') {
			redirect(base_url() . 'index.php/main');
		}
		$data['info']           = '';
		$data['username_error'] = '';
		$data['password_error'] = '';
		if (@$_POST['captcha'] == "") {
			$data['cap'] = $this->_create_captcha();
		}

		if ($this->input->post('submit_login') == 'Login') {

			$username = $this->input->post('txt_username');
			$password = md5($this->input->post('txt_password'));

			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_username', 'Username', 'required');
			$this->form_validation->set_rules('txt_password', 'Password', 'required');
			$this->form_validation->set_rules('captcha', 'captcha', 'trim|callback_check_captcha|required');

			if ($this->form_validation->run() == false && @$_POST['captcha'] != "") {
				$data['username_error'] = form_error('txt_username');
				$data['password_error'] = form_error('txt_password');
				$data['cap'] 			= $this->_create_captcha();
				$data['info'] 			= '<div class="warn_text">Captcha Salah!</div>';

				// }else if(@$_POST['captcha'] == ""){
				// 	$data['info'] = '<div class="warn_text">Captcha Tidak Boleh Kosong!</div>';
			} elseif ($_POST['captcha'] == '') {
				//$data['info'] = '<div class="warn_text">Captcha Salah!</div>';
			} else {
				$login_check = $this->mod_user->do_login_user($username, $password);
				if (date('Y-m-d') <= @$login_check->exp_date) {
					$id_ppat         = '';
					$id_dispenda     = '';
					$id_paymentpoint = '';
					$id_kpp          = '';
					$id_wp          = '';
					$nama            = '';
					$jabatan         = null;
					$login_type_name = '';
					if ($login_check->tipe == 'D') {
						$data_disependa  = $this->mod_user->get_user_detail($login_check->id_user, 'DISPENDA');
						$id_dispenda     = $data_disependa[0]->id_dispenda;
						$nama            = $data_disependa[0]->nama;
						$jabatan         = $data_disependa[0]->jabatan;
						$login_type_name = $this->config->item('dispenda_site_name');
					} elseif ($login_check->tipe == 'P') {
						$login_type_name = $this->config->item('pp_site_name');
					} elseif ($login_check->tipe == 'PT') {
						$data_ppat       = $this->mod_user->get_user_detail($login_check->id_user, 'PPAT');
						$id_ppat         = $data_ppat[0]->id_ppat;
						$nama            = $data_ppat[0]->nama;
						$login_type_name = $this->config->item('pt_site_name');
					} elseif ($login_check->tipe == 'KPP') {
						$data_kpp        = $this->mod_user->get_user_detail($login_check->id_user, 'KPP');
						$id_kpp          = $data_kpp[0]->id_kpp;
						$nama            = $data_kpp[0]->nama;
						$login_type_name = $this->config->item('pt_site_name');
					} elseif ($login_check->tipe == 'PP') {
						$data_paymentpoint = $this->mod_user->get_user_detail($login_check->id_user, 'PAYMENTPOINT');
						$id_paymentpoint   = $data_paymentpoint[0]->id_pp;
						$nama              = $data_paymentpoint[0]->nama;
						$login_type_name   = $this->config->item('pt_site_name');
					} elseif ($login_check->tipe == 'B') {
						$login_type_name = $this->config->item('bank_site_name');
					} elseif ($login_check->tipe == 'WP') {
						$login_type_name = $this->config->item('wp');
						$data_wp		 = $this->mod_user->get_user_detail($login_check->id_user, 'WP');
						$id_wp   		 = $data_wp[0]->id_wp;
						$nama            = $data_wp[0]->nama;
						$nik             = $data_wp[0]->nik; //tambah edit profil
					} else {
						$login_type_name = $login_check->tipe;
					}

					$token_log = $this->antclass->get_unique_code(5);

					$sess_data = array(
						's_id_user'           => $login_check->id_user,
						's_id_ppat'           => $id_ppat,
						's_id_kpp'            => $id_kpp,
						's_id_dispenda'       => $id_dispenda,
						's_id_paymentpoint'   => $id_paymentpoint,
						's_id_wp'   		  => $id_wp,
						's_username_bphtb'    => $login_check->username,
						's_nama_bphtb'        => $nama,
						's_tipe_bphtb'        => $login_check->tipe,
						's_nama_tipe_bphtb'   => $login_type_name,
						's_source_site_bphtb' => current_url(),
						's_password_bphtb'    => $login_check->password,
						'token_log'           => $token_log,
						'status_admin'        => $login_check->status_admin,
						'jabatan'             => $jabatan,
						'nik_user'			  => $nik
					);

					$this->session->set_userdata($sess_data);

					//$this->antclass->go_log('LOGIN:'.$login_check->username.'|'.$token_log);
					if ($login_check->tipe == 'PBB') {
						$data = base64_encode($username . '|' . $password . '|' . current_url());
						redirect($this->config->item('pospbb_site') . 'start/hot_login/' . $data);
					}
					$this->antclass->go_log('Login: ' . $this->db->last_query());
					redirect('main');
				} else {
					$data['info'] = '<div class="warn_text">Username / Password salah!</div>';
					$data['cap'] = $this->_create_captcha();
				}
			}
		}

		// $data['captcha'] = $this->get_captcha();

		$this->load->view('v_login', $data);
		$this->session->set_userdata("oldCaptchaLogin", $data['cap']);
	}

	function ambil_curl()
	{
		$this->antclass->auth_user();
		$a = curl_init("http://localhost/bphtb_malang/index.php/bphtb/");
		// $a = curl_init("http://localhost/tes/");
		curl_setopt($a, CURLOPT_URL, "http://localhost/bphtb_malang/index.php/bphtb/");
		// curl_setopt($a, CURLOPT_URL, "http://localhost/tes/");
		curl_setopt($a, CURLOPT_RETURNTRANSFER, 1);
		$hasil = curl_exec($a);
		curl_close($a);
		$ambil_kata = explode('<title>', $hasil);
		echo $ambil_kata[1];
	}

	public function check_activate()
	{
		$_IP_SERVER  = $_SERVER['SERVER_ADDR'];
		$_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
		// ambil mac address mesin
		ob_start();
		system('wmic cpu get ProcessorId');
		$_PERINTAH2 = ob_get_contents();
		ob_clean();
		$_PECAH2 = str_replace("ProcessorId", null, trim($_PERINTAH2));

		//echo file_exists("id.ini");
		//exit();
		if (file_exists("id.ini") == '') {
			$acak = strtoupper(md5(trim($_PECAH2)));
			//------ masukkan data ke file ini -------//
			$sn = strtoupper(md5(md5(md5($acak))));

			$tes     = fopen("id.ini", "w");
			$replace = "aktif=0;id=0;sn=0;idlast=0;snlast=0;";
			fwrite($tes, $replace);
			fclose($tes);

			$str      = implode("", file("id.ini"));
			$fo       = fopen("id.ini", "w");
			$strid    = str_replace("id=0", "id=" . $acak, $str);
			$pecahstr = explode(";", $strid);
			$replace  = str_replace($pecahstr[2], "sn=" . $sn, $strid);
			fwrite($fo, $replace);
			fclose($fo);

			$buka = fopen(base_url() . "id.ini", "r");

			$baris   = fgets($buka);
			$datas   = explode(";", $baris);
			$produk  = explode("=", $datas[0]);
			$idawal  = explode("=", $datas[1]);
			$snawal  = explode("=", $datas[2]);
			$idakhir = explode("=", $datas[3]);
			$snakhir = explode("=", $datas[4]);
			fclose($buka);
		} else {
			$buka = fopen(base_url() . "id.ini", "r");

			$baris   = fgets($buka);
			$datas   = explode(";", $baris);
			$produk  = explode("=", $datas[0]);
			$idawal  = explode("=", $datas[1]);
			$snawal  = explode("=", $datas[2]);
			$idakhir = explode("=", $datas[3]);
			$snakhir = explode("=", $datas[4]);
			fclose($buka);

			$acak = strtoupper(md5(trim($_PECAH2)));
			//------ masukkan data ke file ini -------//
			$sn = strtoupper(md5(md5(md5($acak . $produk[1]))));
		}
		//----------------------------------------//

		if ($acak != $idakhir[1] || $sn != $snakhir[1] || ($idakhir[1] != $acak || $snakhir[1] != $sn)) {
			$flash_msg = $this->session->flashdata("flash_msg", "Gagal");
			if (empty($flash_msg)) {
				$flash_msg = "Silahkan Melakukan Aktivasi";
			}
			$idawal = $acak;
			echo '
			<form style="width:450px;font-family:Tahoma; border:solid 1px #CCC;padding:10px; margin: 10px auto;" method="POST" action="#" >
				<h3 style="margin:0px;">Aktivasi</h3>
				<div style="display:block; margin: 10px;padding:5px; background-color: yellow;color: red;">' . @$flash_msg . '</div>
				<div style="width:100%;float:left;display:none">
					<div style="float:left;width:120px;padding:7px 0px;">Produk &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</div>
					<div style="float:left;margin:5px 0px;">
						<input type="text" name="produk" value=' . $this->produk . '>
					</div>
				</div>
				<div style="width:100%;float:left;margin:5px 0px;">
					<div style="float:left;width:120px;padding:7px 0px;">ID Aktivasi &nbsp&nbsp&nbsp&nbsp&nbsp:</div>
					<div style="float:left;margin-top:7px;">
						<input style="padding:10px; border: #ccc solid 1px;width:300px;" type="hidden" placeholder="" name="id_mesin" id="userid" value="' . substr($idawal, 0, 8) . "-" . substr($idawal, 8, 8) . "-" . substr($idawal, 16, 8) . "-" . substr($idawal, 24, 8) . '"/>
						' . substr($idawal, 0, 8) . "-" . substr($idawal, 8, 8) . "-" . substr($idawal, 16, 8) . "-" . substr($idawal, 24, 8) . '
					</div>
				</div>
				<div style="width:100%;float:left;">
					<div style="float:left;width:120px;padding:7px 0px;">Serial Number :</div>
					<div style="float:left;">
						<input  style="padding:10px; border: #ccc solid 1px;width:300px;" type="text" placeholder="" name="id" id="userid" autocomplete="off"/>
					</div>
				</div>
				<div style="">
					<button type="submit" style="width:100%;padding:5px;margin-top:5px;border: #ccc solid 1px;font-weight:bold;" value="aktifkan" name="aktifkan">
						Aktifkan <i class="m-icon-swapright m-icon-white"></i>
					</button>
				</div>
			</form>';
			exit();
		}
	}
	public function aktifkan()
	{
		$buka = fopen(base_url() . "id.ini", "r");

		$baris = fgets($buka);
		$datas = explode(";", $baris);

		$idawal  = explode("=", $datas[1]);
		$snawal  = explode("=", $datas[2]);
		$idakhir = explode("=", $datas[3]);
		$snakhir = explode("=", $datas[4]);

		fclose($buka);

		ob_start();
		system('wmic cpu get ProcessorId');
		$_PERINTAH2 = ob_get_contents();
		ob_clean();
		$_PECAH2 = str_replace("ProcessorId", null, trim($_PERINTAH2));

		$acak = strtoupper(md5(trim($_PECAH2)));

		//------ masukkan data ke file ini -------//
		$sn = strtoupper(md5(md5(md5($acak . $this->input->post("produk")))));

		$md5an = md5(strtolower($this->input->post("id")));
		/*echo $md5an."<br>";
		print_r($sn2);
		exit();*/
		if ($sn == strtoupper($md5an)) {
			$str  = implode("", file("id.ini"));
			$fo   = fopen("id.ini", "w");
			$str1 = str_replace($datas[4], "snlast=" . strtoupper($md5an), $str);
			$str2 = str_replace($datas[3], "idlast=" . str_replace("-", '', $this->input->post("id_mesin")), $str1);
			$str3 = str_replace($datas[2], "sn=" . strtoupper($sn), $str2);
			$str4 = str_replace($datas[0], "aktif=" . $this->input->post("produk"), $str3);
			fwrite($fo, $str4);
			fclose($fo);
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata("flash_msg", "Gagal, Silahkan Masukkan Serial Yang Telah Terdaftar");
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function get_captcha()
	{
		$this->load->helper('captcha');

		$vals = array(
			'img_path'  	=> base_url() . 'assets/captcha/',
			'img_url'   	=> base_url() . 'assets/captcha/',
			'img_width' 	=> '150',
			'img_height' 	=> 30,
			'expiration' 	=> 7200
		);

		$cap = create_captcha($vals);

		$captcha_word   = $cap['word'];
		$captcha_image  = $cap['image'];

		$this->session->set_userdata('kota_malang_captcha', $captcha_word);

		echo "<pre>";
		print_r($vals);
		echo "</pre>";
		echo "<pre>";
		print_r($cap);
		echo "</pre>";
	}
}

/* EoF */
