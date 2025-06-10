<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: bpthb.php
 * Description: Login controller
 * Date created: 2011-03-04
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Bphtb extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mod_user');
		$this->load->library('session');
		$this->load->helper('url');
	}

	function index()
	{
	    if($this->session->userdata('s_username_bphtb') != ''){ redirect(base_url().'index.php/main'); }
		$data['info'] = '';
		$data['username_error'] = '';
		$data['password_error'] = '';
		
		if($this->input->post('submit_login') == 'Login')
		{
			$username = $this->input->post('txt_username');
			$password = md5($this->input->post('txt_password'));
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txt_username', 'Username', 'required');
			$this->form_validation->set_rules('txt_password', 'Password', 'required');
			if($this->form_validation->run() == FALSE)
			{
				$data['username_error'] = form_error('txt_username');
				$data['password_error'] = form_error('txt_password');
			}
			else
			{
				$login_check = $this->mod_user->do_login_user($username, $password);
				if($login_check)
				{
					//echo 'OK';
					$login_type_name = '';
					if($login_check->tipe == 'D'){ $login_type_name = $this->config->item('dispenda_site_name'); }
					elseif($login_check->tipe == 'P'){ $login_type_name = $this->config->item('pp_site_name'); }
					else{ $login_type_name = $login_check->tipe; }
                    $token_log = $this->antclass->get_unique_code(5);
	                $sess_data = array('s_username_bphtb'=>$login_check->username, 
	                				   's_nama_bphtb'=>$login_check->nama,
	                				   's_tipe_bphtb'=>$login_check->tipe,
	                				   's_nama_tipe_bphtb'=>$login_type_name,
	                				   's_id_pp_bphtb'=>$login_check->id_pp,
	                				   's_source_site_bphtb'=>current_url(),
	                				   's_password_bphtb'=>$login_check->password,
	                				   'token_log'=>$token_log
									   );
	                $this->session->set_userdata($sess_data);
                    //$this->antclass->go_log('LOGIN:'.$login_check->username.'|'.$token_log);
                    if($login_check->tipe == 'PBB')
                    {
                        $data = base64_encode($username.'|'.$password.'|'.current_url());
                        redirect($this->config->item('pospbb_site').'start/hot_login/'.$data);
                    }
                    $this->antclass->go_log('Login: '.$this->db->last_query());
					redirect('main');
				}
				else
				{
					$data['info'] = '<div class="warn_text">Username / Password salah!</div>';
				}
			}
		}
		
		$this->load->view('v_login', $data);
	}
}

/* EoF */