<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('mod_register', 'reg');
		$this->load->model('m_global', 'global');
		$this->load->helper('captcha');
	}

	public function index()
	{
		$data['propinsi']    = $this->reg->get_propinsi1();

		$data['submitvalue'] = "Add";

		//----CAPTCHA--------
		//----SC : FAIZAL----
		if (@$_POST['captcha'] == "") {
			$data['cap'] = $this->_create_captcha();
		}

		$this->load->view('v_register_wp', $data, FALSE);
		$this->session->set_userdata("oldCaptcha2", $data['cap']);
	}

	/*function get_data()
    {
        $query = $this->db->get('tbl_nik')->result();
        echo json_encode($query);
        
    }*/

	public function get_kab($val = '')
	{
		$id = $_POST['propinsi_id'];
		$data['kab'] = $this->reg->get_kabupaten($id);
		echo json_encode($data['kab']);
	}
	public function get_kec($val = '')
	{
		$id_p = $_POST['id_p'];
		$id_kab = $_POST['id_kab'];
		$data['kec'] = $this->reg->get_kecamatan($id_p, $id_kab);

		echo json_encode($data['kec']);
	}
	public function get_kel($val = '')
	{
		$id_p = $_POST['id_p'];
		$id_kab = $_POST['id_kab'];
		$id_kec = $_POST['id_kec'];
		$data['kel'] = $this->reg->get_kelurahan($id_p, $id_kab, $id_kec);
		// echo "<pre>";
		// print_r ($data['kel']);
		// echo "</pre>";
		echo json_encode($data['kel']);
	}

	public function add_user()
	{
		// echo "<pre>";
		// print_r ($_POST);exit();
		// echo "</pre>";
		/*
		    if ($_POST['nama'] != '' 
		    	&& $_POST['alamat'] != '' 
		    	&& $_POST['rtrw'] != '' 
		    	&& $_POST['kodepos'] != '' 
		    	&& $_POST['email'] != '' 
		    	&& $_POST['no_hp'] != '') 
		    {
		    	echo "Berkas Anda Tidak Lengkap";
				echo $_POST['nama']."-".$_POST['alamat']."-".$_POST['rtrw']."-".$_POST['kodepos']."-".$_POST['email']."-".$_POST['no_hp'];
            } 
			else 
			{
                redirect('register','refresh');
            }
			*/
		/* ORI
			$query    = $this->db->query("SELECT nik from tbl_nik")->result();
            foreach ($query as $key => $value) 
			{
                if ($_POST['nik'] == $value->nik) 
				{
                    redirect('register','refresh');
                } 
				else 
				{}
            }*/

		$nik 	= $_POST['nik'];
		$query  = $this->db->query("SELECT nik from tbl_nik where nik='$nik'")->result();
		foreach ($query as $nik => $value) {
			//return $value->nik."xxx<br>";
			$rownik = $value->nik;
		}
		if (!isset($rownik)) {
			$rownik = 'NULL';
		}

		$query1    = $this->db->query("SELECT nik from tbl_wp where nik='$nik'")->result();
		foreach ($query1 as $nik => $value) {
			//return $value->nik."xxx<br>";
			$rownik1 = $value->nik;
		}
		if (!isset($rownik1)) {
			$rownik1 = 'NULL';
		}

		//$ret = $query->row();
		//return $ret->nik`;
		$query2   = $this->db->query("SELECT username from tbl_user where username='" . $_POST['username'] . "'")->result();
		foreach ($query2 as $key2 => $value2) {
			$rowusername = $value2->username;
		}
		if (!isset($rowusername)) {
			$rowusername = 'NULL';
		}

		//echo $_POST['nik']."+".$_POST['username']." ".$_POST['nama']."-".$_POST['alamat']."-".$_POST['rtrw']."-".$_POST['kodepos']."-".$_POST['email']."-".$_POST['no_hp']."<br>"."-".$rowusername."--";
		//$row = $query->row_array();
		//$row2 = $query2->row_array();

		//$query as $key => $value;
		//$query2 as $key2 => $value2;

		$validationFail = false;
		if ($this->session->userdata("captchaRegisterCode") != $this->input->post('captcha')) {
			$validationFail = true;
			$data["captcha"] = array(
				"oldValue"	=> "",
				"hasError"	=> true,
				"errorMsg"	=> "Captcha Salah!",
			);
		}

		$data["nik"]["oldValue"] = $this->input->post('nik');
		if ($this->input->post('nik') == $rownik || $this->input->post('nik') == $rownik1) {
			$validationFail = true;
			$data["nik"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "NIK sudah pernah terdaftar",
			);
		}

		if (strlen($this->input->post('nik')) != '16' || $this->input->post('nik') == 'NULL') {
			$validationFail = true;
			$data["nik"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "NIK harus terdiri 16 karakter",
			);
		}

		$data["nama"]["oldValue"] = $this->input->post('nama');
		if ($this->input->post('nama') == '') {
			$validationFail = true;
			$data["nama"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Nama tidak boleh kosong",
			);
		}

		$data["alamat"]["oldValue"] = $this->input->post('alamat');
		if ($this->input->post('alamat') == '') {
			$validationFail = true;
			$data["alamat"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Alamat tidak boleh kosong",
			);
		}

		$data["propinsi_"]["oldValue"] = $this->input->post('propinsi');
		if ($this->input->post('propinsi') == '') {
			$validationFail = true;
			$data["propinsi_"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Propinsi tidak boleh kosong",
			);
		}

		$data["kota"]["oldValue"] = $this->input->post('kota');
		if ($this->input->post('kota') == '') {
			$validationFail = true;
			$data["kota"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Kabupaten/Kota tidak boleh kosong",
			);
		}

		$data["Kecamatan"]["oldValue"] = $this->input->post('Kecamatan');
		if ($this->input->post('Kecamatan') == '') {
			$validationFail = true;
			$data["Kecamatan"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Kecamatan tidak boleh kosong",
			);
		}

		$data["kelurahan_"]["oldValue"] = $this->input->post('kelurahan');
		if ($this->input->post('kelurahan') == '') {
			$validationFail = true;
			$data["kelurahan_"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Kelurahan tidak boleh kosong",
			);
		}

		$data["rtrw"]["oldValue"] = $this->input->post('rtrw');
		$data["kodePos"]["oldValue"] = $this->input->post('kodepos');

		$data["username"]["oldValue"] = $this->input->post('username');
		if ($this->input->post('username') == $rowusername) {
			$validationFail = true;
			$data["username"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Username sudah digunakan",
			);
		}

		if (strlen($this->input->post('username')) < 6 || strlen($this->input->post('username')) > 15 || is_null($this->input->post('username'))) {
			$validationFail = true;
			$data["username"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Username harus terdiri dari 7-15 karakter",
			);
		}

		if (strlen($this->input->post('password')) < 7 || strlen($this->input->post('password')) > 15 || is_null($this->input->post('password'))) {
			$validationFail = true;
			$data["password"] = array(
				"oldValue"	=> "",
				"hasError"	=> true,
				"errorMsg"	=> "Password harus terdiri dari 8-15 karakter",
			);
		}

		if ($this->input->post('password') != $this->input->post('confirm')) {
			$validationFail = true;
			$data["confirm"] = array(
				"oldValue"	=> "",
				"hasError"	=> true,
				"errorMsg"	=> "Password konfirmasi harus sama",
			);
		}

		$data["email"]["oldValue"] = $this->input->post('email');
		if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$validationFail = true;
			$data["email"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Format email salah.",
			);
		}

		if ($this->input->post('email') == "") {
			$validationFail = true;
			$data["email"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Email tidak boleh kosong.",
			);
		}

		$data["no_hp"]["oldValue"] = $this->input->post('no_hp');
		if ($this->input->post('no_hp') == "") {
			$validationFail = true;
			$data["no_hp"] = array(
				"hasError"	=> true,
				"errorMsg"	=> "Nomer handphone tidak boleh kosong.",
			);
		}

		if (!$validationFail) {
			$this->add_user_();
		} else {
			$this->session->set_flashdata("validation", $data);
			redirect('/register');
		}
	}

	public function add_user_()
	{
		$user = [
			'username' 		=> $this->input->post('username'),
			'password' 		=> md5($this->input->post('password')),

			'tipe' 			=> 'WP',
			'is_blokir' 	=> '1',
			'is_delete' 	=> '0',
			'exp_date' 		=> '2100-01-01',
			'status_admin' 	=> '0',
		];

		$ins = $this->reg->insert_user($user);
		// die($ins);
		// $ins=1;
		if ($ins == 1) {
			# code...
			$id_user = $this->reg->get_id($this->input->post('username'));
			$kode = '';
			$i = 0;
			while ($i < 6) {
				$kode .= mt_rand(0, 9);
				$i++;
			}
			// die($id_user[0]->id_user);    
			// die('masuk');

			// die($ismail); 

			$name          = $_FILES['foto']['name']; 						// get file name from form			
			$new_folder    = 'assets/files/ktp/' . $id_user[0]->id_user;
			$fileNameParts = explode(".", $name); 							// explode file name to two part
			$fileExtension = end($fileNameParts); 							// give extension
			$fileExtension = strtolower($fileExtension); 					// convert to lower case
			$fix_name_file = $id_user[0]->id_user . "." . $fileExtension; 	// new file name

			$password     	 	= $this->input->post('password');
			$username      		= $this->input->post('username');
			$nama_wp_filter 	= $this->input->post('nama');
			$nama_wp_filter2 	= str_replace("'", "`", $nama_wp_filter);

			$wp = [
				'id_user'      =>  $id_user[0]->id_user,
				'nik'          =>  $this->input->post('nik'),
				'nama'         =>  $nama_wp_filter2,
				'alamat'       =>  strtoupper($this->input->post('alamat')),
				'kd_propinsi'  =>  $this->input->post('propinsi'),
				'kd_kabupaten' =>  $this->input->post('kota'),
				'kd_kecamatan' =>  $this->input->post('Kecamatan'),
				'kd_kelurahan' =>  $this->input->post('kelurahan'),
				'email'        =>  $this->input->post('email'),
				'no_hp'        =>  $this->input->post('no_hp'),
				'rtrw'         =>  $this->input->post('rtrw'),
				'kodepos'      =>  $this->input->post('kodepos'),
				'kode'         =>  $kode,
				'foto'         =>  $new_folder . '/' . $fix_name_file,
				'tanggal'      =>  date('Y-m-d H:i:s')

			];
			// echo "<pre>";
			// print_r($wp['nama']);
			// echo "</pre>";
			// die();
			$ins = $this->reg->insert_wp($wp);
			if ($ins == 1) {
				$en 	= base64_encode($kode);
				$ismail = $this->global->email(
					$this->input->post('email'),
					'Verifikasi Akun E-BPHTB Kota Malang',
					'Untuk Verifikasi akun wajib pajak "' . $wp['nama'] . '" mohon inputkan kode berikut ini kolom verifikasi atau klik link dibawah ini.',
					'NIK : ' . $wp['nik'] . '<br>Nama Wajib Pajak : ' . $wp['nama'] . '<br>Username : ' . $username . '<br>Password : ' . $password . '<hr><a style="color:blue; text-decoration:none" href="http://36.91.58.53:8088/bphtb_malang/index.php/register/acc_verifikasi_direct/' . $id_user[0]->id_user . '" target="_blank" ' . $kode . '>Klik Disini (Link Verifikasi)</a>',
					$kode
				);

				/*
				'Untuk verifikasi akun silahkan inputkan kode berikut ini kolom verifikasi atau klik kode berikut',
				'Nama : '.$wp['nama'].'<br>NIK : '.$wp['nik'].'<hr><a style="color:black; text-decoration:none" href="http://36.91.58.53:8088/bphtb_malang/index.php/register/acc_verifikasi_direct/'.$id_user[0]->id_user.'" target="_blank" '.$kode.'>Link Verifikasi</a>',
				$kode);
				*/

				if (!is_dir($new_folder)) {
					$oldmask = umask(0);
					mkdir($new_folder, 0777, true);
					umask($oldmask);
				}
				copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . 'assets/index.php', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $new_folder . '/index.php');


				$config['upload_path']   = $new_folder;
				$config['allowed_types'] = 'png|jpg|jpeg|pdf';
				$config['overwrite']     = TRUE;
				$config['max_size']      = '5000';
				$config['file_name'] 	 = $fix_name_file;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('foto')) {

					$error = array('error' => $this->upload->display_errors());

					// echo 'kesalahan ada di tahap = ' . $file;
					// print_r($error);exit;
					print_r($error);
				} else {
					$data = array('upload_data' => $this->upload->data());

					redirect(site_url() . '/register/verifikasi_email/' . $id_user[0]->id_user . '/' . $en);
				}
			}
		}

		// $btn ' <a href="'.site_url("register/verifikasi_email/".$this->input->post("username").'/'.$kode.'" target="_blank">'.$kode.'</a>';
		// $btn ' <a href="localhost/bphtb_malang/index.php/register/verifikasi_email/"'.$this->input->post("username").'/'.$kode.'" target="_blank">'.$kode.'</a>';
		// $body =  'Untuk memverifikasi user anda mohon inputkan kode dibawah ini<br>Kode Verifikasi :'.$btn;
	}

	public function verifikasi_email($user, $kode)
	{
		$data['user'] 		= $user;
		$data['kode'] 		= base64_decode($kode);
		$data['captcha'] 	= $this->create_captcha_without_session($data['kode']);
		$this->load->view('v_verifikasi_akun', $data, FALSE);
	}

	public function acc_verifikasi()
	{
		$id = $_POST['user'];
		$data = $this->reg->acc_verifikasi($id);

		if ($data) {
			// echo $data;
			// echo $this->db->last_query();
			echo "<script>alert('Akun Anda dalam proses verifikasi. Jika setelah 3 hari kerja belum disetujui, silahkan menghubungi Badan Pendapatan Daerah Kota Malang)')</script>";
			redirect(base_url() . 'index.php', 'refresh');
		}
	}


	public function acc_verifikasi_direct($id)
	{
		$data = $this->reg->acc_verifikasi($id);

		if ($data) {
			// echo $data;
			// echo $this->db->last_query();
			echo "<script>alert('Verifikasi Berhasil Silahkan Tunggu Persetujuan dari Badan Pendapatan Daerah Kota Malang untuk aktivasi akun.Pemberitahuan aktivasi akun akan di kirimkan ke email.')</script>";
			redirect(base_url() . 'index.php', 'refresh');
		}
	}

	//----MEMBUAT FUNGSI UNTUK GENERATE GAMBAR CAPTCHA DAN MENGESET SESSION UNTUK KODE CAPTCHA
	//----SC : FAIZAL----
	private function _create_captcha()
	{
		// we will first load the helper. We will not be using autoload because we only need it here
		$original_string = array_merge(range(0, 9));
		$original_string = implode("", $original_string);
		$captcha		 = substr(str_shuffle($original_string), 0, 3);

		$vals = array(
			'word'          => $captcha,
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url() . 'assets/captcha/',
			'font_path'     => FCPATH . 'assets\fonts\verdana.ttf',
			'font_size'     => 16,
			'img_width'     => '110',
			'img_height'    => 48,
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
		$this->session->set_userdata('captchaRegisterCode', $c_captcha['word']);
		// we will return the image html code
		return $image;
	}

	private function create_captcha_without_session($word = "")
	{
		$vals = array(
			'word'          => $word,
			'img_path'      => './assets/captcha/',
			'img_url'       => base_url() . 'assets/captcha/',
			'font_path'     => FCPATH . 'assets\fonts\verdana.ttf',
			'font_size'     => 16,
			'img_width'     => '110',
			'img_height'    => 48,
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
		// we will return the image html code
		return $image;
	}
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */