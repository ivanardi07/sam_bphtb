<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Filename: ppat.php
 * Description: PPAT controller
 * Date created: 2011-03-08
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Ppat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_ppat');
        $this->load->model('mod_sptpd');
        $this->c_loc = base_url() . 'index.php/ppat';
    }

    public function index()
    {
        // $cari = array();
        // if($this->input->get('cari'))
        // {
        //     $cari = array('id_ppat'=>$this->input->get('id_ppat'),'nama'=>$this->input->get('nama'),'alamat'=>$this->input->get('alamat'));
        // }
        $id_ppat = trim($this->input->get('id_ppat'));
        $nama    = trim($this->input->get('nama'));
        $alamat  = trim($this->input->get('alamat'));

        $info         = '';
        $data['info'] = '';
        $data['info'] = $this->session->flashdata('info');

        if ($this->input->post('submit_multi')) {
            $check = $this->input->post('check');
            if (!empty($check)):
                switch ($this->input->post('submit_multi')) {
                    case 'delete':
                        foreach ($check as $ch) {
                            $delete_multiple = explode('/', $ch);

                            $this->mod_ppat->delete_ppat($delete_multiple[0], $delete_multiple[1]);
                        }
                        break;
                } else :$info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }

        $this->load->library('pagination');
        $config['base_url']   = $this->c_loc . '/index';
        $config['total_rows'] = $this->mod_ppat->count_ppat($id_ppat, $nama, $alamat);
        // echo "<pre>";
        // print_r($config['total_rows']);exit();
        $config['per_page']    = 20;
        $config['uri_segment'] = 3;

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

        $data['start']                             = $this->uri->segment(3);
        if (empty($data['start'])) {$data['start'] = 0;}
        $this->pagination->initialize($config);

        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc']     = $this->c_loc;
        $data['ppats']     = $this->mod_ppat->get_ppat('', '', 'page', $data['start'], $config['per_page'], $id_ppat, $nama, $alamat);
        // echo $this->db->last_query();exit();
        $this->antclass->skin('v_ppat', $data);
    }

    public function get_ppat()
    {
        $id_ppat = $this->antclass->id_replace($this->input->post('rx_id_ppat'));
        $data    = $this->mod_ppat->get_ppat($id_ppat);
        if ($data) {
            echo '<script type="text/javascript">';
            echo '$("#nama_ppat_id").html("' . $data->nama . '");';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo '$("#nama_ppat_id").html("");';
            echo '</script>';
        }
    }

    public function add()
    {
        if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_id_ppat', 'ID PPAT', 'trim|required|is_unique[tbl_ppat.id_ppat]');
            $this->form_validation->set_rules('txt_nama_ppat', 'Nama', 'trim|required', 'trim|required');
            $this->form_validation->set_rules('txt_alamat_ppat', 'Alamat', 'xss_clean', 'trim|required');
            $this->form_validation->set_rules('txt_username_ppat', 'Username', 'trim|required|is_unique[tbl_user.username]');
            $this->form_validation->set_rules('txt_password_ppat', 'Password', 'trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $data['info'] = err_msg(validation_errors());
            } else {
                $id_ppat  = $this->antclass->id_replace($this->input->post('txt_id_ppat'));
                $nama     = $this->input->post('txt_nama_ppat');
                $alamat   = $this->input->post('txt_alamat_ppat');
                $username = $this->input->post('txt_username_ppat');
                $password = md5($this->input->post('txt_password_ppat'));
                $exp_date = $this->input->post('exp_date');
                $hitung   = $this->mod_ppat->cek_username($username);

                if ($hitung > 0) {
                    $data['info'] = err_msg('Username Sudah Ada.');
                } else {

                    $ppat_check = $this->mod_ppat->get_ppat($id_ppat);
                    // echo "<pre>";
                    // print_r($ppat_check);
                    // exit();
                    // $username_check = $this->mod_ppat->get_ppat_byusername($username);
                    // echo "<pre>";
                    // print_r($username_check);
                    // exit();
                    if ($ppat_check) {
                        $data['info'] = err_msg('ID PPAT atau Username Sudah Ada.');
                    } else {
                        $info = $this->mod_ppat->add_ppat($id_ppat, $nama, $alamat, $username, $password, $exp_date);
                        if ($info) {
                            $data['info'] = succ_msg('Input PPAT Berhasil.');
                        } else {
                            $data['info'] = err_msg('Input PPAT Gagal.');
                        }
                        $this->session->set_flashdata('info', @$data['info']);
                        redirect($this->c_loc, $data);
                    }
                }

            }
        }

        $data['c_loc']       = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id']      = '';
        $this->antclass->skin('v_ppatform', $data);

    }

    public function edit($id)
    {
        if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_ppat', 'Nama', 'trim|required', 'trim|required');
            $this->form_validation->set_rules('txt_alamat_ppat', 'Alamat', 'xss_clean', 'trim|required');

            if ($this->form_validation->run() == false) {
                $data['info'] = err_msg(validation_errors());
            } else {
                
                $id_ppat  = $this->input->post('h_rec_id');
                $id_user  = $this->input->post('txt_id_user');
                $nama     = $this->input->post('txt_nama_ppat');
                $alamat   = $this->input->post('txt_alamat_ppat');
                if ($this->input->post('txt_password_ppat') != '') {
                    $password = md5($this->input->post('txt_password_ppat'));
                } else {
                    $password = '';
                }
                
                
                $exp_date = $this->input->post('exp_date');

                $info = $this->mod_ppat->edit_ppat($id_ppat, $id_user, $nama, $alamat, $password, $exp_date);
                if ($info) {
                    $data['info'] = succ_msg('Update PPAT Berhasil.');
                } else {
                    $data['info'] = err_msg('Update PPAT Gagal.');
                }
                $this->session->set_flashdata('info', @$data['info']);
                redirect($this->c_loc, $data);
            }
        }

        $data['ppat'] = $this->mod_ppat->get_ppat($id);
        if (!empty($data['ppat'])) {

            // echo "<pre>";
            // print_r($data['ppat']);
            // exit();
            $data['c_loc']       = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id']      = $id;
            $this->antclass->skin('v_ppatform', $data);
        } else {
            $this->antclass->skin('v_notfound');
        }
    }

    public function delete($id, $id_user)
    {
        $id_ppat = $this->input->post('h_rec_id');

        if ($this->mod_ppat->get_ppat($id)) {

            $this->mod_ppat->delete_ppat($id, $id_user);

            $data['info'] = succ_msg('Data Berhasil Di Hapus');

            redirect($this->c_loc, $data);

        } else {
            $this->antclass->skin('v_notfound');
        }
    }

    public function check_ppat()
    {
        $id_ppat = $this->antclass->id_replace($this->input->post('enPpatValue'));
        $data    = $this->mod_ppat->get_ppat($id_ppat);
        if ($data) {
            $result_content = array('result' => $data->nama);
        } else {
            $result_content = array('result' => '');
        }
        echo json_encode($result_content);
    }
}

/* EoF */
