<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aprove_user extends CI_Controller
{
	private $enableEmailing = false;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		$this->antclass->auth_user();
		$this->load->model('mod_register', 'reg');
		$this->load->model('mod_aprove_user', 'aprove');
		$this->load->model('m_global', 'global');
	}
	public function index()
	{
		$data['user'] = $this->aprove->get_user();
		$data['c_loc'] = site_url() . 'aprove_user';

		$this->antclass->skin('v_aprove_user', $data);
	}
	public function lihat_wp($id_user)
	{
		$data['user']     = $this->aprove->get_user1($id_user);
		$data['propinsi'] = $this->reg->get_propinsi1();
		// print_r($data['user']);
		$data['kabupaten'] = $this->reg->get_kabupaten1($data['user']->kd_propinsi, $data['user']->kd_kabupaten);
		$data['kecamatan'] = $this->reg->get_kecamatan1($data['user']->kd_propinsi, $data['user']->kd_kabupaten, $data['user']->kd_kecamatan);
		$data['kelurahan'] = $this->reg->get_kelurahan1($data['user']->kd_propinsi, $data['user']->kd_kabupaten, $data['user']->kd_kecamatan, $data['user']->kd_kelurahan);
		$data['c_loc']    = site_url() . 'aprove_user';

		$this->antclass->skin('v_lihat_wp', $data);
	}

	public function action_aprove($id = '', $email = '')
	{
		$enableInsert = true;
		if ($enableInsert) {
			$data = $this->aprove->acc_user($this->input->post('id'));
		} else {
			$data = 1;
		}
		$email1 			= base64_decode($this->input->post('email'));
		$nama_wp_filter 	= $this->input->post('nama');
		$nama_wp_filter2 	= str_replace("'", "`", $nama_wp_filter);

		if ($data == 1) {
			if ($enableInsert) {
				$masuk = [
					'nik'          =>  $this->input->post('nik'),
					'nama'         =>  $nama_wp_filter2,
					'alamat'       =>  $this->input->post('alamat'),
					'kd_propinsi'  =>  $this->input->post('propinsi'),
					'kd_kabupaten' =>  $this->input->post('kota'),
					'kd_kecamatan' =>  $this->input->post('kecamatan'),
					'kd_kelurahan' =>  $this->input->post('kelurahan'),
					'rtrw'         =>  $this->input->post('rtrw'),
					'kodepos'      =>  $this->input->post('kodepos'),
				];

				$result = $this->db->insert('tbl_nik', $masuk);

				$nama_user = $this->aprove->get_user_id($this->input->post('id'))['nama'];
				$user_name = $this->aprove->get_user_id($this->input->post('id'))['username'];

				$body1 = 'Akun ' . $user_name . 'an ' . $nama_user . ' telah aktif. Silahkan login dengan username dan password yang telah dibuat sebelumnya';
				if ($this->enableEmailing) {
					$this->global->email($_POST['email'], 'Aprove Akun', 'Aprove Akun', $body1, '');
				}
			}

			//$waBot = shell_exec("node -v"); // . $_SERVER['DOCUMENT_ROOT'] . "/bphtb_baru/wabot/index.js");
			$waBot = ""; // . $_SERVER['DOCUMENT_ROOT'] . "/bphtb_baru/wabot/index.js");


			$dataq['info']  = 'Aktifasi Berhasil';
			// $msg 			= @$dataq['info'] . $_SERVER['DOCUMENT_ROOT'] . "/bphtb_baru/wabot/index.js"  . $waBot;
			$msg 			= @$dataq['info'];
			$this->session->set_flashdata('info', $msg);
			redirect(site_url() . '/aprove_user', @$data);
		} else {
			$data['info'] .= 'Aktifasi Gagal';
			$this->session->set_flashdata('info', @$data['info']);
			redirect(site_url() . '/aprove_user', @$data);
		}
	}

	public function action_delete($id = '')
	{
		$email1 = $this->aprove->get_user_id($_POST['id'])['email'];
		$user_name = $this->aprove->get_user_id($_POST['id'])['username'];
		$namauser = $this->aprove->get_user_id($_POST['id'])['nama'];
		$data = $this->aprove->delete_user($_POST['id']);


		$alasan = $this->input->post('alasan_reject');
		// die($data);
		if ($data == 1) {

			$body1 = 'Pendaftaran akun E-BPHTB Kota Malang dengan username <b>' . $user_name . '</b> atas nama wajib pajak <b>' . $namauser . '</b> ditolak oleh Badan Pendapatan Daerah Kota Malang dengan alasan : "' . $alasan . '"';
			if ($this->enableEmailing) {
				$this->global->email($email1, 'Reject Akun', 'Reject Akun', $body1, '');
			}

			$dataq['info'] = 'Reject Berhasil';
			$this->session->set_flashdata('info', @$dataq['info']);
			redirect(site_url() . '/aprove_user', @$data);
		} else {
			$data['info'] .= 'Reject Gagal';
			$this->session->set_flashdata('info', @$data['info']);
			redirect(site_url() . '/aprove_user', @$data);
		}
	}

	public function refresh()
	{
		$data['user'] = $this->aprove->get_user();
		$data['c_loc'] = site_url() . 'aprove_user';
		$this->antclass->skin('v_aprove_user', $data);
	}

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
		// 	print_r ($_FILES);
		// 	echo "</pre>";
		// echo "<pre>";
		// print_r ($_POST);
		// echo "</pre>";exit();
		$user = [
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'tipe' => 'WP',
			'is_blokir' => '1',
			'is_delete' => '0',
			'exp_date' => '2100-01-12',
			'status_admin' => '0',
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
			// die($kode);    
			// die('masuk');

			// die($ismail); 

			$name          = $_FILES['foto']['name']; // get file name from form			
			$new_folder = 'assets/files/ktp/' . $id_user[0]->id_user;
			$fileNameParts = explode(".", $name); // explode file name to two part
			$fileExtension = end($fileNameParts); // give extension
			$fileExtension = strtolower($fileExtension); // convert to lower case
			$fix_name_file = $id_user[0]->id_user . "." . $fileExtension; // new file name

			$wp = [
				'id_user' => $id_user[0]->id_user,
				'nik'		=>  $this->input->post('nik'),
				'nama'		=>  $this->input->post('nama'),
				'alamat'		=>  $this->input->post('alamat'),
				'kd_propinsi'		=>  $this->input->post('propinsi'),
				'kd_kabupaten'		=>  $this->input->post('kota'),
				'kd_kecamatan'		=>  $this->input->post('Kecamatan'),
				'kd_kelurahan'		=>  $this->input->post('kelurahan'),
				'email'		=>  $this->input->post('email'),
				'no_hp'		=>  $this->input->post('no_hp'),
				'rtrw'		=>  $this->input->post('rtrw'),
				'kode'		=> $kode,
				'foto'		=> $new_folder . '/' . $fix_name_file,
				'tanggal'	=> date('Y-m-d H:i:s')

			];
			// echo "<pre>";
			// print_r($_POST);
			// echo "</pre>";
			// echo "<pre>";
			// print_r ($wp);
			// echo "</pre>";exit();
			$ins = $this->reg->insert_wp($wp);
			if ($ins == 1) {
				$en = base64_encode($kode);
				if ($this->enableEmailing) {
					$ismail = $this->global->email($this->input->post('email'), 'Verifikasi Akun E-BPHTB Kota Malang', 'Verifikasi Akun E-BPHTB Kota Malang', 'Untuk mengaktifkan user anda, silahkan menginputkan kode berikut ini kolom verifikasi atau klik kode berikut: <a href="localhost/bphtb_malang/index.php/register/acc_verifikasi_direct/' . $id_user[0]->id_user . '" target="_blank">' . $kode . '</a>');
				}

				if (!is_dir($new_folder)) {

					$oldmask = umask(0);
					mkdir($new_folder, 0777, true);
					umask($oldmask);
				}
				copy(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . 'assets/index.php', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . $new_folder . '/index.php');


				$config['upload_path']   = $new_folder;
				$config['allowed_types'] = 'gif|png|jpg|jpeg|pdf';
				$config['overwrite']     = TRUE;
				$config['max_size']      = '1000003048';
				$config['file_name'] = $fix_name_file;

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
		$data['user'] = $user;
		$data['kode'] = base64_decode($kode);
		$this->load->view('v_verifikasi_akun', $data, FALSE);
	}

	public function acc_verifikasi()
	{
		$id = $_POST['user'];
		$data = $this->reg->acc_verifikasi($id);

		if ($data) {
			// echo $data;
			// echo $this->db->last_query();
			echo "<script>alert('Silahkan datang ke kantor untuk aktivasi akun (jika yg membuat PPAT maka harus disertakan surat kuasa)')</script>";
			redirect(base_url() . 'index.php/bphtb', 'refresh');
		}
	}


	public function acc_verifikasi_direct($id)
	{
		$data = $this->reg->acc_verifikasi($id);

		if ($data) {
			// echo $data;
			// echo $this->db->last_query();
			echo "<script>alert('Verifikasi Berhasil Silahkan menunggu status aktifasi melalui email.')</script>";
			redirect(base_url() . 'index.php/bphtb', 'refresh');
		}
	}
}

/* End of file aprove_user.php */
/* Location: ./application/controllers/aprove_user.php */