<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: user.php
 * Description: User controller
 * Date created: 2011-03-17
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class User extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();

        //$this->antclass->cek_admin();

        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_user');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_paymentpoint');

        $id_user = $this->session->userdata('s_id_user');
        $tipe = $this->session->userdata('s_tipe_bphtb');

        $this->c_loc = base_url() . 'index.php/user';
        $this->c_loc2 = base_url() . 'index.php/user/edit_profil/' . $id_user . '/' . $tipe;
    }

    function index()
    {

        $info = '';
        $data['info'] = '';
        $data['info'] = $this->session->flashdata('info');

        if ($this->input->post('submit_multi')) {
            $check = $this->input->post('check');

            //echo '<pre>'; print_r($check);exit;

            if (!empty($check)) :
                switch ($this->input->post('submit_multi')) {
                    case 'delete':
                        foreach ($check as $ch) {
                            $dataDelete = explode(',', $ch);

                            $this->mod_user->delete_user($dataDelete[0], $dataDelete[1]);
                        }
                        break;
                    case 'status':
                        foreach ($check as $ch) {
                            //$dataDelete = explode(',', $ch);
                            $dataBlokir = explode(',', $ch);

                            //echo '<pre>'; print_r($dataBlokir[0]);exit;

                            $get_status = $this->mod_user->get_user($ch);

                            $old_status = @$get_status->is_blokir;

                            $this->mod_user->change_status($dataBlokir[0], $old_status);
                        }
                        break;
                }
            else : $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }

        $this->load->library('pagination');
        $config['base_url']     = $this->c_loc . '/index';
        $config['total_rows']   = $this->mod_user->count_user();
        $config['per_page']     = 20;
        $config['uri_segment']  = 3;

        /*STYLE PAGINATION START*/
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
        /*STYLE PAGINATION END*/



        $data['start']      = $this->uri->segment(3);
        if (empty($data['start'])) {
            $data['start'] = 0;
        }
        $this->pagination->initialize($config);

        $data['page_link']  = $this->pagination->create_links();
        $data['c_loc']      = $this->c_loc;

        if ($this->session->userdata('s_tipe_bphtb') == 'D') {
            $data['user'] = $this->mod_user->get_user('', '', '', 'page', $data['start'], $config['per_page']);
        } else {
            $data['user'] = $this->mod_user->get_user_self($this->session->userdata('s_tipe_bphtb'));
        }

        $this->antclass->skin('v_user', $data);
    }

    function add()
    {
        if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_username_user', 'Username', 'trim|required');
            $this->form_validation->set_rules('txt_password_user', 'Password', 'trim|required|matches[txt_password2_user]|min_length[5]|max_length[20]');
            $this->form_validation->set_rules('txt_password2_user', 'Ulangi Password', 'trim|required|min_length[5]|max_length[20]');

            $tipe = $this->input->post('txt_tipe_user');
            if ($tipe == 'D') {
                $this->form_validation->set_rules('id_dispenda', 'id dispenda', 'trim|required');
                $this->form_validation->set_rules('nama_dispenda', 'Nama Dispenda', 'trim|required');
                $this->form_validation->set_rules('alamat_dispenda', 'Alamat Dispenda', 'trim|required|xss_clean');
                $asal = "id_dispenda";
                $id_tbl = 'Id Dispenda';

                if (@$jabatan == '1' || @$jabatan == '2') {
                    $this->form_validation->set_rules('nip', 'NIP', 'required');
                    $this->form_validation->set_rules('nama', 'Nama', 'required');
                }
            } elseif ($tipe == 'PT') {
                $this->form_validation->set_rules('id_ppat', 'Id PPAT', 'trim|required');
                $this->form_validation->set_rules('nama_ppat', 'Nama PPAT', 'trim|required');
                $this->form_validation->set_rules('alamat_ppat', 'Alamat PPAT', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email_ppat', 'Email PPAT', 'trim|required|xss_clean');
                $asal = "id_ppat";
                $id_tbl = 'Id PPAT';
            } elseif ($tipe == 'PP') {
                $this->form_validation->set_rules('id_pp', 'Id Payment Point', 'trim|required');
                $this->form_validation->set_rules('nama_pp', 'Nama Payment Point', 'trim|required');
                $this->form_validation->set_rules('alamat_pp', 'Alamat Payment Point', 'xss_clean');
                $this->form_validation->set_rules('nama_kepala_pp', 'Nama Kepala', 'trim|required');
                $this->form_validation->set_rules('telp_pp', 'Telepon Payment Point', 'trim|required|xss_clean');
                $asal = "id_pp";
                $id_tbl = 'Id Payment Point';
            } elseif ($tipe == 'KPP') {
                $this->form_validation->set_rules('id_kpp', 'Id BPN / KPP', 'trim|required');
                $this->form_validation->set_rules('nama_kpp', 'Nama BPN / KPP', 'trim|required');
                $this->form_validation->set_rules('alamat_kpp', 'Alamat BPN / KPP', 'trim|required|xss_clean');
                $asal = "id_kpp";
                $id_tbl = 'Id BPN / KPP';
            }

            if ($this->form_validation->run() == FALSE) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $username = $this->input->post('txt_username_user');
                $hitung = $this->mod_user->cekuser($username);
                if (!empty($hitung)) {
                    $data['info'] = err_msg('Username Sudah Ada.');
                } else {

                    $hitung_person = $this->mod_user->cekunique_person($tipe, $this->input->post($asal));
                    if ($hitung_person > 0) {
                        $data['info'] = err_msg($id_tbl . ' Sudah Ada.');
                    } else {
                        $username           = $this->input->post('txt_username_user');
                        $password           = md5($this->input->post('txt_password_user'));
                        $is_blokir          = $this->input->post('txt_status_user');
                        $id_dispenda        = $this->input->post('id_dispenda');
                        $nama_dispenda      = $this->input->post('nama_dispenda');
                        $alamat_dispenda    = $this->input->post('alamat_dispenda');
                        $id_ppat            = $this->input->post('id_ppat');
                        $nama_ppat          = $this->input->post('nama_ppat');
                        $alamat_ppat        = $this->input->post('alamat_ppat');
                        $email_ppat        = $this->input->post('email_ppat');
                        $id_kpp             = $this->input->post('id_kpp');
                        $nama_kpp           = $this->input->post('nama_kpp');
                        $alamat_kpp         = $this->input->post('alamat_kpp');
                        $id_pp              = $this->input->post('id_pp');
                        $nama_pp            = $this->input->post('nama_pp');
                        $alamat_pp          = $this->input->post('alamat_pp');
                        $nama_kepala_pp     = $this->input->post('nama_kepala_pp');
                        $telp_pp            = $this->input->post('telp_pp');
                        $exp_date           = $this->input->post('exp_date');
                        $jabatan            = $this->input->post('txt_jabatan');

                        $nip              = $this->input->post('nip');
                        $nama             = $this->input->post('nama');
                        $nama_dinas       = $this->input->post('nama_dinas');

                        $info = $this->mod_user->add_user($tipe, $username, $password, $is_blokir, $id_ppat, $id_dispenda, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $id_pp, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $exp_date, $jabatan, $nip, $nama, $nama_dinas, $id_kpp, $nama_kpp, $alamat_kpp);
                        if ($info) {
                            $data['info'] = succ_msg('Input user Berhasil.');
                        } else {
                            $data['info'] = err_msg('Input user Gagal.');
                        }

                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, $data);
                    }
                }
            }
        }
        $data['kasi']  = $this->mod_user->get_user_kasi();

        $data['kabid'] = $this->mod_user->get_user_kabid();

        $data['c_loc']          = $this->c_loc;
        $data['submitvalue']    = 'Simpan';
        $data['rec_id']         = '';
        $this->antclass->skin('v_userform', $data);
    }

    function edit($id, $nama_tbl)
    {

        if ($this->input->post('submit')) {
            $this->load->library('form_validation');

            $jabatan = $this->input->post('txt_jabatan');
            $blokir  = $this->input->post('txt_status_user');

            if ($nama_tbl == 'D') {
                $this->form_validation->set_rules('nama_dispenda', 'Nama Dispenda', 'trim|required');
                $this->form_validation->set_rules('alamat_dispenda', 'Alamat Dispenda', 'trim|required|xss_clean');

                if ($jabatan == '1' || $jabatan == '2') {
                    $this->form_validation->set_rules('nip', 'NIP', 'required');
                    $this->form_validation->set_rules('nama', 'Nama', 'required');
                }
            } elseif ($nama_tbl == 'PT') {
                $this->form_validation->set_rules('nama_ppat', 'Nama PPAT', 'trim|required');
                $this->form_validation->set_rules('alamat_ppat', 'Alamat PPAT', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email_ppat', 'Email PPAT', 'trim|required|xss_clean');
            } elseif ($nama_tbl == 'KPP') {
                $this->form_validation->set_rules('id_kpp', 'Id BPN / KPP', 'trim|required');
                $this->form_validation->set_rules('nama_kpp', 'Nama BPN / KPP', 'trim|required');
                $this->form_validation->set_rules('alamat_kpp', 'Alamat BPN / KPP', 'trim|required|xss_clean');
                $asal = "id_kpp";
                $id_tbl = 'Id BPN / KPP';
            } elseif ($nama_tbl == 'PP') {
                $this->form_validation->set_rules('nama_pp', 'Nama Payment Point', 'trim|required');
                $this->form_validation->set_rules('alamat_pp', 'Alamat Payment Point', 'trim|required|xss_clean');
                $this->form_validation->set_rules('nama_kepala_pp', 'Nama Kepala', 'trim|required');
                $this->form_validation->set_rules('telp_pp', 'Telepon Payment Point', 'trim|required|xss_clean');
            } elseif ($nama_tbl == 'WP') {
                $this->form_validation->set_rules('nama_wp', 'Nama Wajib Pajak ', 'trim|required');
                $this->form_validation->set_rules('alamat_wp', 'Alamat Wajib Pajak', 'trim|required|xss_clean');
            }

            $this->form_validation->set_rules('exp_date', 'Tanggal Expired', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $nama_dispenda      = $this->input->post('nama_dispenda');
                $alamat_dispenda    = $this->input->post('alamat_dispenda');
                $nama_ppat          = $this->input->post('nama_ppat');
                $alamat_ppat        = $this->input->post('alamat_ppat');
                $email_ppat         = $this->input->post('email_ppat');
                $id_kpp             = $this->input->post('id_kpp');
                $nama_kpp           = $this->input->post('nama_kpp');
                $alamat_kpp         = $this->input->post('alamat_kpp');
                $nama_pp            = $this->input->post('nama_pp');
                $alamat_pp          = $this->input->post('alamat_pp');
                $nama_kepala_pp     = $this->input->post('nama_kepala_pp');
                $telp_pp            = $this->input->post('telp_pp');
                $exp_date           = $this->input->post('exp_date');
                $password           = $this->input->post('password');
                $password_ulang     = $this->input->post('password_ulang');
                $jabatan            = $this->input->post('txt_jabatan');
                $blokir             = $this->input->post('txt_status_user');
                $nama_wp            = $this->input->post('nama_wp');
                $alamat_wp            = $this->input->post('alamat_wp');
                // print_r($exp_date);
                // die();
                if ($jabatan == '0') {
                    $nip              = '';
                    $nama             = '';
                    $nama_dinas       = '';
                } else {
                    $nip               = $this->input->post('nip');
                    $nama              = $this->input->post('nama');
                    $nama_dinas        = $this->input->post('nama_dinas');
                }

                if ($password != '') {
                    if ($password == $password_ulang) {
                        $info = $this->mod_user->edit_user($id, $nama_tbl, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $exp_date, $jabatan, $nip, $nama, $nama_dinas, $password, $id_kpp, $nama_kpp, $alamat_kpp, $blokir, $nama_wp, $alamat_wp);
                        if ($info) {
                            $data['info'] = succ_msg('Update user Berhasil.');
                        } else {
                            $data['info'] = err_msg('Update user Gagal.');
                        }
                    } else {
                        $data['info'] = err_msg('Password yang diisi harus sama');
                    }
                } else {
                    // print_r($exp_date);
                    // die();
                    $info = $this->mod_user->edit_user($id, $nama_tbl, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $exp_date, $jabatan, $nip, $nama, $nama_dinas, '', $id_kpp, $nama_kpp, $alamat_kpp, $blokir, $nama_wp, $alamat_wp);
                    // print_r($info);exit();
                    // die();
                    if ($info) {
                        $data['info'] = succ_msg('Update user Berhasil.');
                    } else {
                        $data['info'] = err_msg('Update user Gagal.');
                    }
                }

                $this->session->set_flashdata('info', @$data['info']);
                redirect($this->c_loc, $data);
            }
        }

        //echo "<pre>";
        //print_r($this->mod_user->get_user($id, $nama_tbl));
        //echo "</pre>";
        // echo "<pre>";
        // print_r($this->db->last_query());
        // echo "</pre>";
        // exit;

        if ($data['user'] = $this->mod_user->get_user($id, $nama_tbl)) {
            $data['user'] = $this->mod_user->get_user($id, $nama_tbl);
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_userform_edit', $data);
        } else {
            $this->antclass->skin('v_notfound');
        }
    }

    function edit_profil($id, $nama_tbl)
    {
        $info = '';
        $data['info'] = '';
        $data['info'] = $this->session->flashdata('info');

        if ($this->input->post('submit')) {
            $this->load->library('form_validation');

            $jabatan = $this->input->post('txt_jabatan');

            if ($nama_tbl == 'D') {
                $this->form_validation->set_rules('nama_dispenda', 'Nama Dispenda', 'trim|required');
                $this->form_validation->set_rules('alamat_dispenda', 'Alamat Dispenda', 'trim|required|xss_clean');

                if ($jabatan == '1' || $jabatan == '2') {
                    $this->form_validation->set_rules('nip', 'NIP', 'required');
                    $this->form_validation->set_rules('nama', 'Nama', 'required');
                }
            } elseif ($nama_tbl == 'PT') {
                $this->form_validation->set_rules('nama_ppat', 'Nama PPAT', 'trim|required');
                $this->form_validation->set_rules('alamat_ppat', 'Alamat PPAT', 'trim|required|xss_clean');
                $this->form_validation->set_rules('email_ppat', 'Email PPAT', 'trim|required|xss_clean');
            } elseif ($nama_tbl == 'KPP') { //tambah edit profil
                // $this->form_validation->set_rules('id_kpp', 'Id BPN / KPP', 'trim|required');
                $this->form_validation->set_rules('nama_kpp', 'Nama BPN / KPP', 'trim|required');
                $this->form_validation->set_rules('alamat_kpp', 'Alamat BPN / KPP', 'trim|required|xss_clean');
                $asal = "id_kpp";
                $id_tbl = 'Id BPN / KPP';
            } elseif ($nama_tbl == 'PP') {
                $this->form_validation->set_rules('nama_pp', 'Nama Payment Point', 'trim|required');
                $this->form_validation->set_rules('alamat_pp', 'Alamat Payment Point', 'trim|required|xss_clean');
                $this->form_validation->set_rules('nama_kepala_pp', 'Nama Kepala', 'trim|required');
                $this->form_validation->set_rules('telp_pp', 'Telepon Payment Point', 'trim|required|xss_clean');
            } elseif ($nama_tbl == 'WP') {
                $this->form_validation->set_rules('nama_wp', 'Nama Wajib Pajak ', 'trim|required');
                $this->form_validation->set_rules('alamat_wp', 'Alamat Wajib Pajak', 'trim|required|xss_clean');
            }


            // $this->form_validation->set_rules('exp_date', 'Tanggal Expired', 'trim|required|xss_clean');
            // print_r($this->form_validation->run());exit();
            if ($this->form_validation->run() == FALSE) {
                // $data['info'] = err_msg(validation_errors());
                $data['info'] = err_msg('Pastikan data sudah terisi dengan benar');
            } else {
                $nama_dispenda      = $this->input->post('nama_dispenda');
                $alamat_dispenda    = $this->input->post('alamat_dispenda');
                $nama_ppat          = $this->input->post('nama_ppat');
                $alamat_ppat        = $this->input->post('alamat_ppat');
                $email_ppat         = $this->input->post('email_ppat');
                $id_kpp             = $this->input->post('id_kpp');
                $nama_kpp           = $this->input->post('nama_kpp');
                $alamat_kpp         = $this->input->post('alamat_kpp');
                $nama_pp            = $this->input->post('nama_pp');
                $alamat_pp          = $this->input->post('alamat_pp');
                $nama_kepala_pp     = $this->input->post('nama_kepala_pp');
                $telp_pp            = $this->input->post('telp_pp');
                // $exp_date           = $this->input->post('exp_date');
                $password           = $this->input->post('password');
                $password_ulang     = $this->input->post('password_ulang');
                $jabatan            = $this->input->post('txt_jabatan');
                $nama_wp            = $this->input->post('nama_wp');
                $alamat_wp          = $this->input->post('alamat_wp');
                // print_r($jabatan);exit();
                // die();
                if ($jabatan == '0') {
                    $nip              = '';
                    $nama             = '';
                    $nama_dinas       = '';
                } else {
                    $nip               = $this->input->post('nip');
                    $nama              = $this->input->post('nama');
                    $nama_dinas        = $this->input->post('nama_dinas');
                }

                if ($password != '') {
                    if ($password == $password_ulang) {
                        $info = $this->mod_user->edit_user_profil($id, $nama_tbl, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $jabatan, $nip, $nama, $nama_dinas, $password, $id_kpp, $nama_kpp, $alamat_kpp, $nama_wp, $alamat_wp);
                        if ($info) {
                            $data['info'] = succ_msg('Update user Berhasil.');
                        } else {
                            $data['info'] = err_msg('Update user Gagal.');
                        }
                    } else {
                        $data['info'] = err_msg('Password yang diisi harus sama1');
                    }
                } else {
                    // print_r($exp_date);
                    // die();
                    $info = $this->mod_user->edit_user_profil($id, $nama_tbl, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $jabatan, $nip, $nama, $nama_dinas, '', $id_kpp, $nama_kpp, $alamat_kpp, $nama_wp, $alamat_wp);
                    // print_r($exp_date);
                    // die();
                    if ($info) {
                        $data['info'] = succ_msg('Update user Berhasil.');
                    } else {
                        $data['info'] = err_msg('Update user Gagal.');
                    }
                }

                $this->session->set_flashdata('info', @$data['info']);
                redirect($this->c_loc2, $data);
            }
        }

        //echo "<pre>";
        //print_r($this->mod_user->get_user($id, $nama_tbl));
        //echo "</pre>";
        // echo "<pre>";
        // print_r($this->db->last_query());
        // echo "</pre>";
        // exit;
        if ($data['user'] = $this->mod_user->get_user($id, $nama_tbl)) {
            $data['user'] = $this->mod_user->get_user($id, $nama_tbl);
            // $data['c_loc'] = $this->c_loc;
            $data['c_loc'] = $this->c_loc2;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            // print_r($data['user']);exit();
            $this->antclass->skin('v_userform_edit_profil', $data);
        } else {
            $this->antclass->skin('v_notfound');
        }
    }

    function delete($id, $nama_tbl)
    {
        $data = $this->mod_user->get_user($id);
        if ($this->mod_user->get_user($id)) {
            $this->mod_user->delete_user($id, $nama_tbl);
            redirect($this->c_loc);
        } else {
            $this->antclass->skin('v_notfound');
        }
    }

    function status($id)
    {
        $data['info'] = '';
        if ($get_status = $this->mod_user->get_user($id)) {
            $old_status = $get_status[0]->is_blokir;
            if ($this->mod_user->change_status($id, $old_status)) {
                redirect($this->c_loc);
            } else {
                $data['info'] = err_msg('Update Status Blokir Username Gagal.');
            }
        } else {
            $data['info'] = err_msg('Username Tidak Ada.');
        }

        $this->antclass->skin('v_userform', $data);
    }
}

/* EoF */