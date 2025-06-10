<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: main.php
 * Description: Dashboard controller
 * Date created: 2011-03-04
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		//$this->antclass->auth_user();
	}

	function index()
	{
		$this->antclass->auth_user();
		$this->antclass->skin('v_main');
	}
	
	function logout()
	{
	    // $this->antclass->go_log('Logout');
		
		$this->session->sess_destroy();

		redirect('main');
	}

		

}

/* EoF */