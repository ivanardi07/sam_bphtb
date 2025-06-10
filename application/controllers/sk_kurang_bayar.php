<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: sk_kurang_bayar.php
 * Description: Penerbitan SK Pengurangan controller
 * Date created: 2011-12-06
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Sk_kurang_bayar extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->c_loc = base_url().'index.php/sk_kurang_bayar';
    }

    function index()
    {
        $data['info'] = $info = '';
        
        $data['c_loc'] = $this->c_loc;
        $this->antclass->skin('v_sk_kurang_bayar', $data);
    }
}

/* EoF */