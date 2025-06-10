<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Dati extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->antclass->auth_user();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->model('mod_propinsi');
		$this->load->model('mod_dati2');
		$this->c_loc = base_url() . 'index.php/dati';
	}

	function index() {
		$info         = '';
		$data['info'] = '';

		$kabupaten = trim($this->input->get('kabupaten'));

		$propinsi = trim($this->input->get('propinsi'));

		if ($this->input->post('submit_multi')) {
			$check = $this->input->post('check');
			// print_r($check);
			// exit();

			if (!empty($check)):
				switch ($this->input->post('submit_multi')) {
					case 'delete':
						foreach ($check as $ch) {
							$id           = explode('/', $ch);
							$kd_kabupaten = $id[0];
							$kd_propinsi  = $id[1];

							$this->mod_dati2->delete_dati2($kd_kabupaten, $kd_propinsi);

							$data['info'] = succ_msg('Hapus Kabupaten Berhasil.');
							$this->session->set_flashdata('info', $data['info']);
							redirect('dati', $data);	}
						break;

				} else :
				$info = err_msg('Pilih data terlebih dahulu.');
			endif;
			$data['info'] = $info;

		}

		$this->load->library('pagination');
		$config['page_query_string'] = TRUE;
		$config['base_url']          = $this->c_loc . trim("/index?propinsi=$propinsi&kabupaten=$kabupaten");
		$config['total_rows']  = $this->mod_dati2->count_dati2($propinsi, $kabupaten);
		// echo $this->db->last_query(); exit;
		$config['per_page']    = 20;
		$config['uri_segment'] = 3;

		/*CONFIG STYLE PAGINATION*/
		$config['full_tag_open']   = '<ul>';
		$config['full_tag_close']  = '</ul>';
		$config['first_link']      = 'First';
		$config['first_tag_open']  = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link']       = 'Last';
		$config['last_tag_open']   = '<li>';
		$config['last_tag_close']  = '</li>';
		$config['next_link']       = 'Next →';
		$config['next_tag_open']   = '<li class="next">';
		$config['next_tag_close']  = '</li>';
		$config['prev_link']       = '← Prev';
		$config['prev_tag_open']   = '<li class="prev disabled">';
		$config['prev_tag_close']  = '</li>';
		$config['cur_tag_open']    = '<li class = "active"> <a href="#">';
		$config['cur_tag_close']   = '</a></li>';
		$config['num_tag_open']    = '<li>';
		$config['num_tag_close']   = '</li>';
		/*CONFIG STYLE PAGINATION*/

		$data['propinsis']                         = $this->mod_propinsi->get_propinsi();
		$data['info']                              = $this->session->flashdata('info');
		$data['start']                             = @$this->input->get('per_page');
		if (empty($data['start'])) {$data['start'] = 0;}
		$this->pagination->initialize($config);

		$data['page_link'] = $this->pagination->create_links();
		$data['c_loc']     = $this->c_loc;
		$data['datis']     = $this->mod_dati2->get_dati2('', '', '', 'page', $data['start'], $config['per_page'], $propinsi, $kabupaten);
		$this->antclass->skin('v_dati', $data);
	}

	function get_kecamatan_bydati2() {
		$kd_kabupaten = $this->input->post('rx_kd_kabupaten');
		$data         = $this->mod_kecamatan->get_kecamatan('', '', $kd_kabupaten);
		if ($data) {
			foreach ($data as $data) {
				echo '<option value="' . $data->kd_kecamatan . '">' . $data->kd_kecamatan . ' - ' . $data->nama . '</option>';
			}
		} else {
			echo 'no';
		}
	}

	function get_dati2_bypropinsi() {
		$kd_propinsi = $this->input->post('rx_kd_propinsi');
		$kd_dati2    = $this->input->post('rx_kd_dati');
		$selected    = '';
		// echo $kd_dati2; exit()
		$datas = $this->mod_dati2->get_dati2('', '', $kd_propinsi);
		if ($datas) {
			echo '<option>pilih kabupaten</option>';
			foreach ($datas as $data) {
				if ($data->kd_kabupaten == $kd_dati2) {
					$selected = 'selected';
				} else {
					$selected = '';
				}

				echo '<option value="' . $data->kd_kabupaten . '" ' . $selected . '>' . $data->kd_kabupaten . ' - ' . $data->nama . '</option>';
			}
		} else {
			echo 'no';
		}
	}
	function add() {
		if ($this->input->post('submit')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_kd_propinsi', 'Propinsi', 'trim|required');
			$this->form_validation->set_rules('txt_kd_dati', 'Dati', 'trim|required');
			$this->form_validation->set_rules('txt_nama_dati', 'Nama', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['info'] = err_msg(validation_errors());
			} else {
				// $this->input->post('txt_kd_propinsi');
				$kd_propinsi = $this->input->post('txt_kd_propinsi');
				$kd_dati     = $this->input->post('txt_kd_dati');
				$nama        = $this->input->post('txt_nama_dati');

				// print_r($this->input->post());
				// exit();

				$dati_check = $this->mod_dati2->get_dati($kd_dati, $kd_propinsi);

				if ($dati_check) {
					$data['info'] = err_msg('Kode Kabupaten Sudah Ada.');
				} else {
					$info = $this->mod_dati2->add_dati2($kd_propinsi, $kd_dati, $nama);

					if ($info) {

						$data['info'] = succ_msg('Input Kabupaten Berhasil.');
						$this->session->set_flashdata('info', $data['info']);
						redirect('dati', $data);
					} else {
						$data['info'] = err_msg('Input Dati Gagal.');
					}
				}
			}
		}

		$data['propinsis']    = $this->mod_propinsi->get_propinsi();
		$data['kd_propinsi']  = '';
		$data['kd_kabupaten'] = '';

		$data['c_loc']       = $this->c_loc;
		$data['submitvalue'] = 'Simpan';
		$data['rec_id']      = '';
		$this->antclass->skin('v_datiform', $data);

	}

	function edit($kode_dati, $kode_propinsi) {
		if ($this->input->post('submit')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_kd_propinsi', 'Propinsi', 'required');
			$this->form_validation->set_rules('txt_kd_dati', 'Dati', 'required');
			$this->form_validation->set_rules('txt_nama_dati', 'Nama', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data['info'] = err_msg(validation_errors());
			} else {
				$kd_propinsi_ed = $this->input->post('txt_kd_propinsi');
				$kd_dati_ed     = $this->input->post('txt_kd_dati');
				$nama_ed        = $this->input->post('txt_nama_dati');

				$data_lama = $this->mod_dati2->get_dati2($kode_dati, 1, $kode_propinsi);

				$check_pk = false;
				$continue = true;

				$data_where = array('kd_propinsi' => $data_lama->kd_propinsi,
					'kd_kabupaten'                    => $data_lama->kd_kabupaten);

				if ($data_lama->nama != $nama_ed) {
					$data_update['nama'] = $nama_ed;
				}
				if ($data_lama->kd_propinsi != $kd_propinsi_ed) {
					$check_pk                   = true;
					$data_update['kd_propinsi'] = $kd_propinsi_ed;
				}
				if ($data_lama->kd_kabupaten != $kd_dati_ed) {
					$check_pk                    = true;
					$data_update['kd_kabupaten'] = $kd_dati_ed;
				}

				if ($check_pk == true) {
					$check_pk_action = $this->mod_dati2->get_dati2($kd_dati_ed, 1, $kd_propinsi_ed);
					if (!empty($check_pk_action)) {
						$data['info'] = err_msg('Kode Dati Sudah Ada.');
						$continue     = false;
					}
				}

				if (!empty($data_update)) {
					if ($continue == true) {
						$action_update = $this->mod_dati2->edit_dati2($data_update, $data_where);
						if ($action_update == true) {
							$data['info'] = succ_msg('Update Kabupaten Berhasil.');
							$this->session->set_flashdata('info', $data['info']);
							redirect('dati', $data);
						}
					}
				} else {
					$data['info'] = succ_msg('Tidak ada data yang dirubah.');
					$this->session->set_flashdata('info', $data['info']);
					redirect('dati', $data);
				}

				/*
			$dati_check = $this->mod_dati2->get_dati($kd_dati_ed, $kd_propinsi_ed);
			$data_lama = $this->mod_dati2->get_dati2($id, $kode_propinsi);
			$kd_propinsi = $data_lama->kd_propinsi;
			if($dati_check->kd_propinsi == $kd_propinsi_ed && $dati_check->kd_kabupaten == $kd_dati_ed)
			{
			$data['info'] = succ_msg('Tidak ada perubahan Data.');
			if($dati_check->nama != $nama)
			{
			$info = $this->mod_dati2->edit_dati2($id, $nama, '', $kode_propinsi);
			$data['info'] = succ_msg('Update Kabupaten Berhasil.');
			$this->session->set_flashdata('info',$data['info']);
			redirect('dati',$data);
			}
			}

			else
			{
			// if($dati_check->)
			if(!empty($dati_check))
			{
			$dati_check = TRUE;
			}
			else
			{
			$dati_check = FALSE;
			}
			// if($id != $kd_dati_ed)
			// {
			//     $id = $kd_dati_ed;
			// }
			// else
			// {
			//     $dati_check = FALSE;
			// }
			if($dati_check)
			{
			$data['info'] = err_msg('Kode Dati Sudah Ada.');
			}
			else
			{
			$info = $this->mod_dati2->edit_dati2($id, $nama, $kd_dati_ed, $kd_propinsi, $kd_propinsi_ed);
			// exit;
			if($info)
			{
			$data['info'] = succ_msg('Update Kabupaten Berhasil.');
			$this->session->set_flashdata('info',$data['info']);
			redirect('dati',$data);
			}
			else
			{
			$data['info'] = err_msg('Update Kabupaten Gagal.');
			}
			}
			}
			 */
			}
		}

		if ($data['dati'] = $this->mod_dati2->get_dati2($kode_dati, 1, $kode_propinsi)) {
			$data['dati']        = $this->mod_dati2->get_dati2($kode_dati, 1, $kode_propinsi);
			$kodedati            = $data['dati']->kd_kabupaten;
			$kodepropinsi        = $data['dati']->kd_propinsi;
			$data['kd_propinsi'] = $kodepropinsi;
			$data['kd_dati']     = $kodedati;

			$data['propinsis']   = $this->mod_propinsi->get_propinsi();
			$data['c_loc']       = $this->c_loc;
			$data['submitvalue'] = 'Edit';
			$data['rec_id']      = $kode_dati;
			$this->antclass->skin('v_datiform', $data);
		} else {
			$this->antclass->skin('v_notfound');
		}
	}

	function delete($id, $kode_propinsi) {
		if ($data['dati'] = $this->mod_dati2->get_dati2($id, $kode_propinsi)) {

			$this->mod_dati2->delete_dati2($id, $kode_propinsi);

			$data['info'] = succ_msg('Hapus Kabupaten Berhasil.');
			$this->session->set_flashdata('info', $data['info']);
			redirect('dati', $data);
		} else {
			$this->antclass->skin('v_notfound');
		}
	}
}

/* EoF */