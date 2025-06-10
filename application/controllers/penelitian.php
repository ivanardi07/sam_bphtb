<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: propinsi.php
 * Description: Propinsi controller
 * Date created: 2011-03-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Penelitian extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->antclass->auth_user();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->model('mod_formulir_penelitian');
		$this->c_loc = base_url().'index.php/penelitian';
	}
	function index()
	{
		$info = '';
		$data['info'] = '';
		
		if($this->input->post('submit_multi'))
		{
			$check = $this->input->post('check');
			if( ! empty($check)):
				switch($this->input->post('submit_multi'))
				{
					case 'delete':
						foreach($check as $ch)
						{ $this->mod_formulir_penelitian->delete_formulir_penelitian($ch); }
					break;
				}
			else: $info = err_msg('Pilih data terlebih dahulu.');
			endif;
			$data['info'] = $info;
		}
        
		$this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->mod_formulir_penelitian->count_formulir_penelitian();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        $config['full_tag_open'] = '<ul>';
         $config['full_tag_close'] = '</ul>';
         $config['first_link'] = 'First';
         $config['first_tag_open'] = '<li>';
         $config['first_tag_close'] = '</li>';
         $config['last_link'] = 'Last';
         $config['last_tag_open'] = '<li>';
         $config['last_tag_close'] = '</li>';
         $config['next_link'] = 'Next →';
         $config['next_tag_open'] = '<li class="next">';
         $config['next_tag_close'] = '</li>';
         $config['prev_link'] = '← Prev';
         $config['prev_tag_open'] = '<li class="prev disabled">';
         $config['prev_tag_close'] = '</li>';
         $config['cur_tag_open'] = '<li class = "active"> <a href="#">';
         $config['cur_tag_close'] = '</a></li>';
         $config['num_tag_open'] = '<li>';
         $config['num_tag_close'] = '</li>';
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['info'] = $this->session->flashdata('info');
        $data['page_link'] = $this->pagination->create_links();
		$data['c_loc'] = $this->c_loc;
		$data['penelitians'] = $this->mod_formulir_penelitian->get_formulir_penelitian('', '', 'page', $data['start'], $config['per_page']);
		$this->antclass->skin('v_penelitianlist', $data);
	}
	function add()
	{
		
		$data = array();
		
		if($this->input->post('simpan') == 'Simpan'){
			$data = array();
			$data['no_sspd'] = $this->input->post('no_sspd');
			$data['tanggal_no_sspd'] = $this->input->post('tanggal_no_sspd');
			$data['no_formulir'] = $this->input->post('no_formulir');
			$data['tanggal_no_formulir'] = $this->input->post('tanggal_no_formulir');
			$data['lampiran_sspd_1'] = $this->input->post('lampiran_sspd_1');
			$data['lampiran_sspd_2'] = $this->input->post('lampiran_sspd_2');
			$data['lampiran_fotocopi_identitas'] = $this->input->post('lampiran_fotocopi_identitas');
			$data['lampiran_surat_kuasa_wp'] = $this->input->post('lampiran_surat_kuasa_wp');
			$data['lampiran_nama_kuasa_wp'] = $this->input->post('lampiran_nama_kuasa_wp');
			$data['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
			$data['lampiran_fotocopy_identitas_kwp'] = $this->input->post('lampiran_fotocopy_identitas_kwp');
			$data['lampiran_identitas_lainya'] = $this->input->post('lampiran_identitas_lainya');
			$data['lampiran_identitas_lainya_val'] = $this->input->post('lampiran_identitas_lainya_val');
			$data['lampiran_fotocopy_kartu_npwp'] = $this->input->post('lampiran_fotocopy_kartu_npwp');
			$data['penelitian_data_objek'] = $this->input->post('penelitian_data_objek');
			$data['penelitian_nilai_bphtb'] = $this->input->post('penelitian_nilai_bphtb');
			$data['penelitian_dokumen'] = $this->input->post('penelitian_dokumen');
		//	$data['nama_petugas_fungsi_pelayanan'] = $this->input->post('nama_petugas_fungsi_pelayanan');
			$data['id_pegawai'] = $this->input->post('id_pegawai');
			
			 $this->load->library('form_validation');

            $this->form_validation->set_rules('no_sspd', 'NO SSPD', 'required|xss_clean');
            $this->form_validation->set_rules('no_formulir', 'NO Formulir', 'required|xss_clean');
            $this->form_validation->set_rules('id_pegawai', 'Nama petugas', 'required|xss_clean');
			
			$config['upload_path'] = FCPATH.'assets/files/penelitian/';
			$upload = true;
			$no_sspd_ok = true;
			$no_sspd_find = true;
			$lunas = true;
			$this->load->model('mod_sptpd','find_sptpd');
			$find = $this->find_sptpd->get_sptpd_no_dokumen($data['no_sspd']);
			$this->mod_formulir_penelitian->add_formulir_penelitian($data);
			// echo $this->db->last_query();exit;
			if(!$find){
				$no_sspd_find = false;
			}
			if($no_sspd_find and $find->is_lunas != '1'){
				$lunas = false;
			}
			if($used = $this->mod_formulir_penelitian->getByNoSSPD($data['no_sspd'])){
				$no_sspd_ok = false;
			}
			
			
			if($_FILES['lampiran_sspd_1_file']['name']){
				if($_FILES['lampiran_sspd_1_file']['type']=='image/gif' or $_FILES['lampiran_sspd_1_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_1_file']['type']=='image/png')
					$upload = true;
				else
					$upload = false;
			}
			if($_FILES['lampiran_sspd_2_file']['name']){
				if($_FILES['lampiran_sspd_2_file']['type']=='image/gif' or $_FILES['lampiran_sspd_2_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_2_file']['type']=='image/png')
					$upload = true;
				else
					$upload = false;
			}
			if($_FILES['lampiran_fotocopi_identitas_file']['name']){
				if($_FILES['lampiran_fotocopi_identitas_file']['type']=='image/gif' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/jpeg' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/png')
					$upload = true;
				else
					$upload = false;
			}

			if($this->form_validation->run() and $upload and $no_sspd_ok and $no_sspd_find and $lunas){
				if($this->mod_formulir_penelitian->add_formulir_penelitian($data)){
					if($data['penelitian_data_objek']=="1" and $data['penelitian_nilai_bphtb']=="1" and $data['penelitian_dokumen']=="1"){
						$this->load->model('mod_sptpd','sptpd');
						$this->sptpd->set_lunas($data['no_sspd'],'2');
					}
					$data['info'] = succ_msg('Input Formulir Penelitian Berhasil.');
					if($_FILES['lampiran_sspd_1_file']['name']){
						move_uploaded_file($_FILES['lampiran_sspd_1_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$this->db->insert_id().'_lampiran_sspd_1_file.jpg');
					}
					if($_FILES['lampiran_sspd_2_file']['name']){
						move_uploaded_file($_FILES['lampiran_sspd_2_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$this->db->insert_id().'_lampiran_sspd_2_file.jpg');
					}
					if($_FILES['lampiran_fotocopi_identitas_file']['name']){
						move_uploaded_file($_FILES['lampiran_fotocopi_identitas_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$this->db->insert_id().'_lampiran_fotocopi_identitas_file.jpg');
					}
				}
				else{
					$data['info'] = err_msg('Input Formulir Gagal.');
				}
			}
			else{
				$data['info']= '<div class="warn_text">';
				if($no_sspd_find==false){
					$data['info'] = $data['info'].'<p>NO SSPD Tidak Ditemukan</p>';
				}
				if($lunas == false){
					$data['info'] = $data['info'].'<p>NO SSPD Belum Dilunasi</p>';
				}
				// if($no_sspd_ok==false){
				// 	$data['info'] = $data['info'].'<p>NO SSPD Sudah Digunakan Diformulir Dengan No Formlulir <a href="'.$this->c_loc.'/edit/'.$used->id_formulir.'">'.$used->no_formulir.'</a></p>';
				// }
				if($upload==false){
					$data['info'] = $data['info'].'<p>File Upload Harus Gambar *.jpg,*.png,*.gif.</p>';
				}
				$data['info'] = $data['info'].validation_errors().'</div>';
			}
		}
		$data['info'] = $this->session->flashdata('info');
		$data['submitvalue'] = 'Simpan';
		$data['c_loc'] = $this->c_loc;
		$data['pegawais'] = array(''=>'- Pilih -');			
		$this->load->model('mod_pegawai','pegawai');
		$pegawais = $this->pegawai->get_pegawai();
		foreach($pegawais as $pegawai){
			$data['pegawais'][$pegawai->id] = $pegawai->nama;
		}
		$this->antclass->skin('v_penelitian', $data);
		
	}

	public function penelitian_save()
	{
		
		// CEK INPUT LAMPIRAN

        $paramFormulir = array();

        $no_formulir = $this->input->post('no_formulir');
        $no_sspd = $this->input->post('no_sspd');

        $no_dokumen_file = str_replace('.', '', $no_sspd);
        
        if ($_FILES['txt_picture_lampiran_sspd_1_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_sspd_1_file', $no_dokumen_file.'_lampiran_sspd_1');

                $paramFormulir['lampiran_sspd'] = $file;
        }

        if ($_FILES['txt_picture_lampiran_sspd_2_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_sspd_2_file', $no_dokumen_file.'_lampiran_sppt');

                $paramFormulir['lampiran_sppt'] = $file;
        }

        if ($_FILES['txt_picture_lampiran_fotocopi_identitas_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_fotocopi_identitas_file', $no_dokumen_file.'_lampiran_fotocopy_identitas');

                $paramFormulir['lampiran_fotocopi_identitas'] = $file;
        }

        if ($this->input->post('lampiran_nama_kuasa_wp') != '') {

                $paramFormulir['lampiran_nama_kuasa_wp'] = $this->input->post('lampiran_nama_kuasa_wp');
                $paramFormulir['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');

        }

        if ($_FILES['txt_picture_lampiran_fotocopy_identitas_kwp_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_fotocopy_identitas_kwp_file', $no_dokumen_file.'_lampiran_fotocopy_identitas_kwp');

                $paramFormulir['lampiran_fotocopy_identitas_kwp'] = $file;
        }

        if ($_FILES['txt_picture_lampiran_fotocopy_kartu_npwp_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_fotocopy_kartu_npwp_file', $no_dokumen_file.'_lampiran_fotocopy_kartu_npwp');

                $paramFormulir['lampiran_fotocopy_kartu_npwp'] = $file;
        }

        if ($_FILES['txt_picture_lampiran_fotocopy_akta_jb_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_fotocopy_akta_jb_file', $no_dokumen_file.'_lampiran_fotocopy_akta_jb');

                $paramFormulir['lampiran_fotocopy_akta_jb'] = $file;
        }

        if ($_FILES['txt_picture_lampiran_sertifikat_kepemilikan_tanah_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_sertifikat_kepemilikan_tanah_file', $no_dokumen_file.'_lampiran_sertifikat_kepemilikan_tanah');

                $paramFormulir['lampiran_sertifikat_kepemilikan_tanah'] = $file;
        }

        if ($_FILES['txt_picture_lampiran_fotocopy_keterangan_waris_file']['name'] != '') {

                $file = $this->uploadFile('txt_picture_lampiran_fotocopy_keterangan_waris_file', $no_dokumen_file.'_lampiran_fotocopy_keterangan_waris');

                $paramFormulir['lampiran_fotocopy_keterangan_waris'] = $file;
        }

        if($this->input->post('lampiran_identitas_lainya_val') != '') {
        	$paramFormulir['lampiran_identitas_lainya_val'] = $this->input->post('lampiran_identitas_lainya_val');
        }


        $this->db->where('no_formulir', $no_formulir);
        $this->db->update('tbl_formulir_penelitian', $paramFormulir);

        $data['info'] = succ_msg('Update Formulir Berhasil.');

        $this->session->set_flashdata('info', $data['info']);

        redirect('penelitian');

	}

	public function uploadFile($file='', $name_fix = '')
    {
        $name = $_FILES[$file]['name']; // get file name from form
        $fileNameParts   = explode( ".", $name ); // explode file name to two part
        $fileExtension   = end( $fileNameParts ); // give extension
        $fileExtension   = strtolower( $fileExtension ); // convert to lower case
        $fix_name_file   = $name_fix.".".$fileExtension;  // new file name
        
        $config['upload_path'] = 'assets/files/penelitian/';
        $config['allowed_types'] = 'pdf|gif|jpg|png';
        $config['max_size']  = '2048';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['file_name'] = $fix_name_file; //set file name
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($file)){
            $error = array('error' => $this->upload->display_errors());
            
            echo 'kesalahan ada di tahap = '.$file;

            echo "<pre>";
            print_r($error); exit;
        }
        else{
            $data = array('upload_data' => $this->upload->data());
        }

        return $fix_name_file;
    }

	function penelitian_save_backup(){
		if($this->input->post('simpan') == 'Simpan'){
				$data = array();
				$data['no_sspd'] = trim($this->input->post('no_sspd'));
				$data['tanggal_no_sspd'] = trim($this->input->post('tanggal_no_sspd'));
				$data['no_formulir'] = trim($this->input->post('no_formulir'));
				$data['tanggal_no_formulir'] = trim($this->input->post('tanggal_no_formulir'));
				$data['lampiran_sspd_1'] = trim($this->input->post('lampiran_sspd_1'));
				$data['lampiran_sspd_2'] = trim($this->input->post('lampiran_sspd_2'));
				$data['lampiran_fotocopi_identitas'] = trim($this->input->post('lampiran_fotocopi_identitas'));
				$data['lampiran_surat_kuasa_wp'] = trim($this->input->post('lampiran_surat_kuasa_wp'));
				$data['lampiran_nama_kuasa_wp'] = trim($this->input->post('lampiran_nama_kuasa_wp'));
				$data['lampiran_alamat_kuasa_wp'] = trim($this->input->post('lampiran_alamat_kuasa_wp'));
				$data['lampiran_fotocopy_identitas_kwp'] = trim($this->input->post('lampiran_fotocopy_identitas_kwp'));
				$data['lampiran_identitas_lainya'] = trim($this->input->post('lampiran_identitas_lainya'));
				$data['lampiran_identitas_lainya_val'] = trim($this->input->post('lampiran_identitas_lainya_val'));
				$data['lampiran_fotocopy_kartu_npwp'] = trim($this->input->post('lampiran_fotocopy_kartu_npwp'));
				$data['penelitian_data_objek'] = trim($this->input->post('penelitian_data_objek'));
				$data['penelitian_nilai_bphtb'] = trim($this->input->post('penelitian_nilai_bphtb'));
				$data['penelitian_dokumen'] = trim($this->input->post('penelitian_dokumen'));
			//	$data['nama_petugas_fungsi_pelayanan'] = $this->input->post('nama_petugas_fungsi_pelayanan');
				// $data['id_pegawai'] = $this->input->post('id_pegawai');
				
				 $this->load->library('form_validation');

	            $this->form_validation->set_rules('no_sspd', 'NO SSPD', 'required|xss_clean|trim');
	            $this->form_validation->set_rules('no_formulir', 'NO Formulir', 'required|xss_clean|trim');
	            // $this->form_validation->set_rules('id_pegawai', 'Nama petugas', 'required|xss_clean');
				
				$config['upload_path'] = FCPATH.'assets/files/penelitian/';
				$upload = true;
				$no_sspd_ok = true;
				$no_sspd_find = true;
				$lunas = true;
				$this->load->model('mod_sptpd','find_sptpd');
				$find = $this->find_sptpd->get_sptpd_no_dokumen($data['no_sspd']);
				// echo $this->db->last_query();exit;
				if(!$find){
					$no_sspd_find = false;
				}
				if($no_sspd_find and $find->is_lunas != '1'){
					$lunas = false;
				}
				if($used = $this->mod_formulir_penelitian->getByNoSSPD($data['no_sspd'])){
					$no_sspd_ok = false;
				}
				
				
				if($_FILES['lampiran_sspd_1_file']['name']){
					if($_FILES['lampiran_sspd_1_file']['type']=='image/gif' or $_FILES['lampiran_sspd_1_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_1_file']['type']=='image/png')
						$upload = true;
					else
						$upload = false;
				}
				if($_FILES['lampiran_sspd_2_file']['name']){
					if($_FILES['lampiran_sspd_2_file']['type']=='image/gif' or $_FILES['lampiran_sspd_2_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_2_file']['type']=='image/png')
						$upload = true;
					else
						$upload = false;
				}
				if($_FILES['lampiran_fotocopi_identitas_file']['name']){
					if($_FILES['lampiran_fotocopi_identitas_file']['type']=='image/gif' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/jpeg' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/png')
						$upload = true;
					else
						$upload = false;
				}

				if($this->form_validation->run() and $upload and $no_sspd_ok and $no_sspd_find and $lunas){
					if($this->mod_formulir_penelitian->add_formulir_penelitian($data)){
						$data['info'] = succ_msg('Input Formulir Penelitian Berhasil.');
						if($data['penelitian_data_objek']=="1" and $data['penelitian_nilai_bphtb']=="1" and $data['penelitian_dokumen']=="1"){
							$this->load->model('mod_sptpd','sptpd');
							$this->sptpd->set_lunas($data['no_sspd'],'2');
						}
						
						if($_FILES['lampiran_sspd_1_file']['name']){
							move_uploaded_file($_FILES['lampiran_sspd_1_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$this->db->insert_id().'_lampiran_sspd_1_file.jpg');
							
							
						}
						if($_FILES['lampiran_sspd_2_file']['name']){
							move_uploaded_file($_FILES['lampiran_sspd_2_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$this->db->insert_id().'_lampiran_sspd_2_file.jpg');
						}
						if($_FILES['lampiran_fotocopi_identitas_file']['name']){
							move_uploaded_file($_FILES['lampiran_fotocopi_identitas_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$this->db->insert_id().'_lampiran_fotocopi_identitas_file.jpg');
						}
					}
					else{
						$data['info'] = err_msg('Input Formulir Gagal.');
					}
				}else{
					$data['info']= '<div class="warn_text">';
					if($no_sspd_find==false){
						$data['info'] = $data['info'].'<p>NO SSPD Tidak Ditemukan</p>';
					}
					if($lunas == false){
						$data['info'] = $data['info'].'<p>NO SSPD Belum Dilunasi</p>';
					}
					if($no_sspd_ok==false){
						$data['info'] = $data['info'].'<p>NO SSPD Sudah Digunakan Diformulir Dengan No Formlulir <a href="'.$this->c_loc.'/edit/'.$used->id_formulir.'">'.$used->no_formulir.'</a></p>';
					}
					if($upload==false){
						$data['info'] = $data['info'].'<p>File Upload Harus Gambar *.jpg,*.png,*.gif.</p>';
					}
					$data['info'] = $data['info'].validation_errors().'</div>';
				}
				$this->session->set_flashdata('info', $data['info']);
		}elseif($this->input->post('simpan') == 'Edit'){
				$id = $this->input->post('id_pel');
				$data = array();
				$data['no_sspd'] = $this->input->post('no_sspd');
				$data['tanggal_no_sspd'] = $this->input->post('tanggal_no_sspd');
				$data['no_formulir'] = $this->input->post('no_formulir');
				$data['tanggal_no_formulir'] = $this->input->post('tanggal_no_formulir');
				$data['lampiran_sspd_1'] = $this->input->post('lampiran_sspd_1');
				$data['lampiran_sspd_2'] = $this->input->post('lampiran_sspd_2');
				$data['lampiran_fotocopi_identitas'] = $this->input->post('lampiran_fotocopi_identitas');
				$data['lampiran_surat_kuasa_wp'] = $this->input->post('lampiran_surat_kuasa_wp');
				$data['lampiran_nama_kuasa_wp'] = $this->input->post('lampiran_nama_kuasa_wp');
				$data['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
				$data['lampiran_fotocopy_identitas_kwp'] = $this->input->post('lampiran_fotocopy_identitas_kwp');
				$data['lampiran_identitas_lainya'] = $this->input->post('lampiran_identitas_lainya');
				$data['lampiran_identitas_lainya_val'] = $this->input->post('lampiran_identitas_lainya_val');
				$data['lampiran_fotocopy_kartu_npwp'] = $this->input->post('lampiran_fotocopy_kartu_npwp');
				$data['penelitian_data_objek'] = $this->input->post('penelitian_data_objek');
				$data['penelitian_nilai_bphtb'] = $this->input->post('penelitian_nilai_bphtb');
				$data['penelitian_dokumen'] = $this->input->post('penelitian_dokumen');
			//	$data['nama_petugas_fungsi_pelayanan'] = $this->input->post('nama_petugas_fungsi_pelayanan');
				$data['id_pegawai'] = $this->input->post('id_pegawai');
				
				$this->load->library('form_validation');

	            $this->form_validation->set_rules('no_sspd', 'NO SSPD', 'required|xss_clean');
	            $this->form_validation->set_rules('no_formulir', 'NO Formulir', 'required|xss_clean');
	            $this->form_validation->set_rules('id_pegawai', 'Nama petugas', 'required|xss_clean');
				
				$config['upload_path'] = FCPATH.'assets/files/penelitian/';
				$upload = true;
				if($_FILES['lampiran_sspd_1_file']['name']){
					if($_FILES['lampiran_sspd_1_file']['type']=='image/gif' or $_FILES['lampiran_sspd_1_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_1_file']['type']=='image/png')
						$upload = true;
					else
						$upload = false;
				}
				if($_FILES['lampiran_sspd_2_file']['name']){
					if($_FILES['lampiran_sspd_2_file']['type']=='image/gif' or $_FILES['lampiran_sspd_2_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_2_file']['type']=='image/png')
						$upload = true;
					else
						$upload = false;
				}
				if($_FILES['lampiran_fotocopi_identitas_file']['name']){
					if($_FILES['lampiran_fotocopi_identitas_file']['type']=='image/gif' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/jpeg' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/png')
						$upload = true;
					else
						$upload = false;
				}

				if($upload){
					$input_pel = $this->mod_formulir_penelitian->edit_formulir_penelitian($id,$data);
					if($input_pel > 0){
						$data['info'] = succ_msg('Update Formulir Penelitian Berhasil.');
						
						if($data['penelitian_data_objek']=="1" and $data['penelitian_nilai_bphtb']=="1" and $data['penelitian_dokumen']=="1"){
							$this->load->model('mod_sptpd','sptpd');
							$this->sptpd->set_lunas($data['no_sspd'],'2');
						}
						
						if($_FILES['lampiran_sspd_1_file']['name']){
							if(file_exists(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg')) unlink(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg');
							move_uploaded_file($_FILES['lampiran_sspd_1_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg');
						
						}
						if($_FILES['lampiran_sspd_2_file']['name']){
							if(file_exists(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg')) unlink(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg');
							move_uploaded_file($_FILES['lampiran_sspd_2_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg');
						}
						if($_FILES['lampiran_fotocopi_identitas_file']['name']){
							if(file_exists(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg')) unlink(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg');
							move_uploaded_file($_FILES['lampiran_fotocopi_identitas_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg');
						}
					}
					else{
						$data['info'] = err_msg('Update Formulir Gagal.');
					}
				}
				else if($upload==false){
					$data['info'] = err_msg('File Upload Harus Gambar *.jpg,*.png,*.gif.');
				}
				else
				{
					$data['info'] = err_msg(validation_errors());
				}
				$this->session->set_flashdata('info', $data['info']);
		}
			redirect('penelitian');
	}
	
	function edit($id)
	{
		$data = array();
		$data['submitvalue'] = 'Edit';
		$data['id_pel'] = $id;
		$data['c_loc'] = $this->c_loc;
		if($this->input->post('simpan')){
			$data = array();
			$data['no_sspd'] = $this->input->post('no_sspd');
			$data['tanggal_no_sspd'] = $this->input->post('tanggal_no_sspd');
			$data['no_formulir'] = $this->input->post('no_formulir');
			$data['tanggal_no_formulir'] = $this->input->post('tanggal_no_formulir');
			$data['lampiran_sspd_1'] = $this->input->post('lampiran_sspd_1');
			$data['lampiran_sspd_2'] = $this->input->post('lampiran_sspd_2');
			$data['lampiran_fotocopi_identitas'] = $this->input->post('lampiran_fotocopi_identitas');
			$data['lampiran_surat_kuasa_wp'] = $this->input->post('lampiran_surat_kuasa_wp');
			$data['lampiran_nama_kuasa_wp'] = $this->input->post('lampiran_nama_kuasa_wp');
			$data['lampiran_alamat_kuasa_wp'] = $this->input->post('lampiran_alamat_kuasa_wp');
			$data['lampiran_fotocopy_identitas_kwp'] = $this->input->post('lampiran_fotocopy_identitas_kwp');
			$data['lampiran_identitas_lainya'] = $this->input->post('lampiran_identitas_lainya');
			$data['lampiran_identitas_lainya_val'] = $this->input->post('lampiran_identitas_lainya_val');
			$data['lampiran_fotocopy_kartu_npwp'] = $this->input->post('lampiran_fotocopy_kartu_npwp');
			$data['penelitian_data_objek'] = $this->input->post('penelitian_data_objek');
			$data['penelitian_nilai_bphtb'] = $this->input->post('penelitian_nilai_bphtb');
			$data['penelitian_dokumen'] = $this->input->post('penelitian_dokumen');
		//	$data['nama_petugas_fungsi_pelayanan'] = $this->input->post('nama_petugas_fungsi_pelayanan');
			$data['id_pegawai'] = $this->input->post('id_pegawai');
			
			 $this->load->library('form_validation');

            $this->form_validation->set_rules('no_sspd', 'NO SSPD', 'required|xss_clean');
            $this->form_validation->set_rules('no_formulir', 'NO Formulir', 'required|xss_clean');
            $this->form_validation->set_rules('id_pegawai', 'Nama petugas', 'required|xss_clean');
			
			$config['upload_path'] = FCPATH.'assets/files/penelitian/';
			$upload = true;
			if($_FILES['lampiran_sspd_1_file']['name']){
				if($_FILES['lampiran_sspd_1_file']['type']=='image/gif' or $_FILES['lampiran_sspd_1_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_1_file']['type']=='image/png')
					$upload = true;
				else
					$upload = false;
			}
			if($_FILES['lampiran_sspd_2_file']['name']){
				if($_FILES['lampiran_sspd_2_file']['type']=='image/gif' or $_FILES['lampiran_sspd_2_file']['type']=='image/jpeg' or $_FILES['lampiran_sspd_2_file']['type']=='image/png')
					$upload = true;
				else
					$upload = false;
			}
			if($_FILES['lampiran_fotocopi_identitas_file']['name']){
				if($_FILES['lampiran_fotocopi_identitas_file']['type']=='image/gif' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/jpeg' or $_FILES['lampiran_fotocopi_identitas_file']['type']=='image/png')
					$upload = true;
				else
					$upload = false;
			}
			if($this->form_validation->run() and $upload){
				if($this->mod_formulir_penelitian->edit_formulir_penelitian($id,$data)){
					$data['info'] = succ_msg('Input Formulir Penelitian Berhasil.');
					if($data['penelitian_data_objek']=="1" and $data['penelitian_nilai_bphtb']=="1" and $data['penelitian_dokumen']=="1"){
						$this->load->model('mod_sptpd','sptpd');
						$this->sptpd->set_lunas($data['no_sspd'],'2');
					}
					
					if($_FILES['lampiran_sspd_1_file']['name']){
						if(file_exists(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg')) unlink(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg');
						move_uploaded_file($_FILES['lampiran_sspd_1_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg');
					
					}
					if($_FILES['lampiran_sspd_2_file']['name']){
						if(file_exists(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg')) unlink(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg');
						move_uploaded_file($_FILES['lampiran_sspd_2_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg');
					}
					if($_FILES['lampiran_fotocopi_identitas_file']['name']){
						if(file_exists(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg')) unlink(FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg');
						move_uploaded_file($_FILES['lampiran_fotocopi_identitas_file']['tmp_name'], FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg');
					}
				}
				else{
					$data['info'] = err_msg('Input Formulir Gagal.');
				}
			}
			else if($upload==false){
				$data['info'] = err_msg('File Upload Harus Gambar *.jpg,*.png,*.gif.');
			}
			else
			{
				$data['info'] = err_msg(validation_errors());
			}
		}

		if($data['penelitian'] = $this->mod_formulir_penelitian->get_formulir_penelitian($id))
        {
        	$formulir 				= $data['penelitian'];
        	$data['wp']				= $this->mod_formulir_penelitian->getWP($formulir->no_sspd);	
        	$data['c_loc'] 			= $this->c_loc;
	        $data['submitvalue']	= 'Edit';
	        $data['rec_id'] 		= $id;
	        $data['pegawais'] 		= array(''=>'- Pilih -');			
			$this->load->model('mod_pegawai','pegawai');
			$pegawais 				= $this->pegawai->get_pegawai();
			foreach($pegawais as $pegawai){
				$data['pegawais'][$pegawai->id] = $pegawai->nama;
			}

			$this->antclass->skin('v_penelitian', $data);
		}
		else
		{
			$this->antclass->skin('v_notfound');
		}		
	}
	function getSSPD()
	{
		$this->load->model('mod_sptpd','sptpd');
		$this->load->model('mod_nik','nik');
		$this->load->model('mod_dati2','dati');
		$this->load->model('mod_kelurahan','kelurahan');
		$this->load->model('mod_penelitian','mp');
		
		$ret= array();
		
		$no = $this->input->post('no_dokumen');
		$sptpd 		= $this->sptpd->get_sptpd_no_dokumen($no);	

		
		if($sptpd):
			if($sptpd->is_lunas == 1):
				$nik		= $this->nik->get_nik($sptpd->nik);
				$propinsi 	= $this->mp->get_propinsi($nik->kd_propinsi);
				$kabupaten 	= $this->mp->get_kabupaten($nik->kd_propinsi,$nik->kd_kabupaten);
				$kecamatan 	= $this->mp->get_kecamatan($nik->kd_propinsi,$nik->kd_kabupaten,$nik->kd_kecamatan);
				$kelurahan 	= $this->mp->get_kelurahan($nik->kd_propinsi,$nik->kd_kabupaten,$nik->kd_kecamatan,$nik->kd_kelurahan);
		
				$ret['valid']	= 1;
				$ret['nama'] 	= @$nik->nama; 
				$ret['nik'] 	= @$nik->nik; 
				$ret['alamat'] 	= @$nik->alamat; 
				$ret['propinsi'] 	= @$propinsi->nama;
				$ret['kabupaten'] 	= @$kabupaten->nama;
				$ret['kecamatan'] 	= @$kecamatan->nama; 
				$ret['kelurahan'] 	= @$kelurahan->nama;
				$ret['tanggal'] 	= @$sptpd->tanggal;
			elseif($sptpd->is_lunas == 2):
				$ret['valid'] = 0;
				$ret['message'] = 'NO SSPD Sudah Diverivikasi';
			else:
				$ret['valid'] = 0;
				$ret['message'] = 'NO SSPD Belum Lunas';
			endif;
		else:
			$ret['valid'] = 0;
			$ret['message'] = 'NO SSPD Tidak Ditemukan';
		endif;

		// echo '<pre>';
		// print_r($kecamatan); exit;
		
		echo json_encode($ret);
	}
	function getSSPDEdit()
	{
		$this->load->model('mod_sptpd','sptpd');
		$this->load->model('mod_nik','nik');
		$this->load->model('mod_dati2','dati');
		$this->load->model('mod_kelurahan','kelurahan');
		
		$ret= array();
		
		$no = $this->input->post('no_dokumen');
		
		$sptpd 		= $this->sptpd->get_sptpd_no_dokumen($no);	

		
		if($sptpd):
			if($sptpd->is_lunas == 1 or $sptpd->is_lunas == 2):
				$nik		= $this->nik->get_nik($sptpd->nik);
				// echo "<pre>"; print_r($nik); exit;
				$kelurahan 	= $this->kelurahan->get_kelurahan($nik->kd_propinsi.'.'.$nik->kd_kabupaten.'.'.$nik->kd_kecamatan.'.'.$nik->kd_kelurahan);
				$kabupaten 	= $this->dati->get_dati2($nik->kd_kabupaten);
		
				$ret['valid']	= 1;
				$ret['nama'] 	= @$nik->nama; 
				$ret['nik'] 	= @$nik->nik; 
				$ret['alamat'] 	= @$nik->alamat; 
				$ret['kelurahan'] 	= @$kelurahan->nama; 
				$ret['kabupaten'] 	= @$kabupaten->nama;
				$ret['tanggal'] 	= @$sptpd->tanggal;
			else:
				$ret['valid'] = 0;
				$ret['message'] = 'NO SSPD Belum Lunas';
			endif;
		else:
			$ret['valid'] = 0;
			$ret['message'] = 'NO SSPD Tidak Ditemukan';
		endif;
		
		echo json_encode($ret);
	}
	function delete($id)
	{
		if($data['dati'] = $this->mod_formulir_penelitian->get_formulir_penelitian($id))
        {
            $this->mod_formulir_penelitian->delete_formulir_penelitian($id);
			$file1 = FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_1_file.jpg';
			$file2 = FCPATH.'assets/files/penelitian/'.$id.'_lampiran_sspd_2_file.jpg';
			$file3 = FCPATH.'assets/files/penelitian/'.$id.'_lampiran_fotocopi_identitas_file.jpg';
			if(file_exists($file1)) unlink($file1);
			if(file_exists($file2)) unlink($file2);
			if(file_exists($file3)) unlink($file3);
			$data['info'] = succ_msg('Hapus Formulir Penelitian Berhasil.');
			$this->session->set_flashdata('info', @$data['info']);
            redirect($this->c_loc, $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
	}
}