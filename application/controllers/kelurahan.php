<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/**
 * Filename: kelurahan.php
 * Description: Kelurahan controller
 * Date created: 2011-03-10
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Kelurahan extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->antclass->auth_user();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->model('mod_dati2');
		$this->load->model('mod_propinsi');
		$this->load->model('mod_kecamatan');
		$this->load->model('mod_kelurahan');
		$this->load->model('mod_nik');
		$this->load->model('mod_nop');
		$this->c_loc = base_url() . 'index.php/kelurahan';
	}

	function index() {
		$info         = '';
		$data['info'] = '';
		$cari         = $this->input->get('cari');
		$cari1        = $this->input->get('txt_kd_propinsi');
		$cari2        = $this->input->get('txt_kd_dati2');
		$cari3        = $this->input->get('txt_kd_kecamatan');

		if ($this->input->post('submit_multi')) {
			$check = $this->input->post('check');
			if (!empty($check)):
				switch ($this->input->post('submit_multi')) {
					case 'delete':
						foreach ($check as $ch) {$this->mod_kelurahan->delete_kelurahan($ch);	}
						break;
				} else :$info = err_msg('Pilih data terlebih dahulu.');
			endif;
			$data['info'] = $info;
		}

		$this->load->library('pagination');
		$config['page_query_string'] = TRUE;
		$config['base_url']          = $this->c_loc . trim("/index?txt_kd_propinsi=$cari1&txt_kd_dati2=$cari2&txt_kd_kecamatan=$cari3&cari=$cari");
		$config['total_rows']        = $this->mod_kelurahan->count_kelurahan($cari, $cari1, $cari2, $cari3);
		$config['per_page']          = 20;
		$config['uri_segment']       = 3;

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

		$data['start']                             = @$this->input->get('per_page');
		if (empty($data['start'])) {$data['start'] = 0;};
		$this->pagination->initialize($config);

		$data['page_link'] = $this->pagination->create_links();
		$data['c_loc']     = $this->c_loc;
		$data['kelurahans'] = $this->mod_kelurahan->get_kelurahan('', '', '', 'page', $data['start'], $config['per_page'], $cari, $cari1, $cari2, $cari3);
		$data['propinsis']                 = $this->mod_propinsi->get_propinsi();
		$data['txt_kd_dati2_selected']     = $this->input->get('txt_kd_dati2');
		$data['txt_kd_kecamatan_selected'] = $this->input->get('txt_kd_kecamatan');
		$data['get']                       = $cari;
		
		$this->antclass->skin('v_kelurahan', $data);
	}

	function get_kelurahan_bykecamatan() {
		$kd_kecamatan = $this->input->post('rx_kd_kecamatan');
		$data         = $this->mod_kelurahan->get_kelurahan('', '', $kd_kecamatan);
		if ($data) {
			foreach ($data as $data) {
				echo '<option value="' . $data->kd_kelurahan . '">' . $data->kd_kelurahan . ' - ' . $data->nama . '</option>';
			}
		} else {
			echo 'no';
		}
	}

	function add() {
		if ($this->input->post('submit')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_kd_propinsi', 'Propinsi', 'required');
			$this->form_validation->set_rules('txt_kd_dati2', 'Dati2', 'required');
			$this->form_validation->set_rules('txt_kd_kelurahan', 'Kode kelurahan', 'required|min_length[3]');
			$this->form_validation->set_rules('txt_nama_kelurahan', 'Nama', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['info'] = err_msg(validation_errors());
			} else {
				$kd_propinsi  = $this->input->post('txt_kd_propinsi');
				$kd_dati2     = $this->input->post('txt_kd_dati2');
				$kd_kecamatan = $this->input->post('txt_kd_kecamatan');
				$kd_kelurahan = $this->input->post('txt_kd_kelurahan');
				$nama         = $this->input->post('txt_nama_kelurahan');

				$kelurahan_check = $this->mod_kelurahan->check_kelurahan($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $nama);
				if ($kelurahan_check) {
					$data['info'] = err_msg('Data kelurahan Sudah Ada.');
				} else {
					$info = $this->mod_kelurahan->add_kelurahan($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $nama);
					if ($info) {
						$data['info'] = succ_msg('Update kelurahan Berhasil.');
						$this->session->set_flashdata('info', $data['info']);
					} else {
						$data['info'] = err_msg('Input kelurahan Gagal.');
					}
					redirect('kelurahan');
				}
			}
		}

		$data['propinsis']   = $this->mod_propinsi->get_propinsi();
		$data['dati2s']      = $this->mod_dati2->get_dati2();
		$data['kecamatans']  = $this->mod_kecamatan->get_kecamatan();
		$data['kd_propinsi'] = '';
		$data['kd_dati2']    = '';

		$data['c_loc']       = $this->c_loc;
		$data['submitvalue'] = 'Simpan';
		$data['rec_id']      = '';
		$this->antclass->skin('v_kelurahanform', $data);
	}

	function edit($id) {
		if ($this->input->post('submit')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_kd_propinsi', 'Propinsi', 'required');
			$this->form_validation->set_rules('txt_kd_dati2', 'Dati2', 'required');
			$this->form_validation->set_rules('txt_kd_kecamatan', 'Kecamatan', 'required');
			$this->form_validation->set_rules('txt_kd_kelurahan', 'Kode kelurahan', 'required|min_length[3]');
			$this->form_validation->set_rules('txt_nama_kelurahan', 'Nama', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['info'] = err_msg(validation_errors());
			} else {
				$kd_propinsi     = $this->input->post('txt_kd_propinsi');
				$kd_dati2        = $this->input->post('txt_kd_dati2');
				$kd_kecamatan    = $this->input->post('txt_kd_kecamatan');
				$kd_kelurahan_ed = $this->input->post('txt_kd_kelurahan');
				$kd_kelurahan    = $this->input->post('h_rec_id');
				$nama            = $this->input->post('txt_nama_kelurahan');
				if ($id != $kd_kelurahan_ed) {
					$id              = $kd_kelurahan;
					$kelurahan_check = $this->mod_kelurahan->check_kelurahan($kd_propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan_ed, $nama);
				} else {
					$kelurahan_check = FALSE;
				}

				if ($kelurahan_check) {
					$data['info'] = err_msg('Data kelurahan Sudah Ada.');
				} else {
					$data = explode('.', $kd_kelurahan);
					$info = $this->mod_kelurahan->edit_kelurahan($data, $nama, $kd_kelurahan_ed, $kd_propinsi, $kd_dati2, $kd_kecamatan);
					if ($info) {
						$data['info'] = succ_msg('Update kelurahan Berhasil.');
						$this->session->set_flashdata('info', $data['info']);
					} else {
						$data['info'] = err_msg('Update kelurahan Gagal.');
					}
					// $this->db->last_query();exit;
					redirect('kelurahan');
				}
			}
		}

		if ($data['kelurahan'] = $this->mod_kelurahan->get_kelurahan($id)) {
			$kelurahan = $this->mod_kelurahan->get_kelurahan($id);
			// $data['kelurahan'] = $this->mod_kelurahan->get_kelurahan($id);
			// $kode = explode('.', $data['kelurahan']->kd_kelurahan);
			$data['kd_propinsi'] = $kelurahan->kd_propinsi;
			$data['kd_dati2']    = $kelurahan->kd_kabupaten;

			$data['kd_kecamatan'] = $kelurahan->kd_kecamatan;
			$data['kd_kelurahan'] = $kelurahan->kd_kelurahan;

			$data['propinsis']   = $this->mod_propinsi->get_propinsi();
			$data['dati2s']      = $this->mod_dati2->get_dati2('','',$kelurahan->kd_propinsi);
			$data['kecamatans']  = $this->mod_kelurahan->getKecamatanOption($kelurahan->kd_propinsi,$kelurahan->kd_kabupaten);
			$data['c_loc']       = $this->c_loc;
			$data['submitvalue'] = 'Edit';
			$data['rec_id']      = $id;
			$this->antclass->skin('v_kelurahanform', $data);
		} else {
			$this->antclass->skin('v_notfound');
		}
	}

	function get_kecamatan_bydati2() {
		$kd_propinsi    = $this->input->get('idp');
		$kd_kabupaten   = $this->input->get('idk');
		$idkec_selected = $this->input->get('idkec_selected');

		$data = $this->mod_kelurahan->getKecamatanOption($kd_propinsi, $kd_kabupaten);

		// print_r($data); exit;
		if ($data) {
			echo '<option>Pilih Kecamatan</option>';
			foreach ($data as $data) {
				if ($data->kd_kecamatan == $idkec_selected) {
					$selected = 'selected';
				} else {
					$selected = '';
				}

				echo '<option value="' . $data->kd_kecamatan . '"' . $selected . '>' . $data->kd_kecamatan . ' - ' . $data->nama . '</option>';
			}
		} else {
			echo 'no';
		}
	}

	function delete($id) {
		if ($data['kelurahan'] = $this->mod_kelurahan->get_kelurahan($id)) {
			$this->mod_kelurahan->delete_kelurahan($id);
			redirect($this->c_loc);
		} else {
			$this->antclass->skin('v_notfound');
		}
	}
}

/* EoF */