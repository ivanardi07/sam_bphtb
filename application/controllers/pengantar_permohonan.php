<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: pengantar_permohonan.php
 * Description: Penerbitan SK Pengantar Permohonan controller
 * Date created: 2011-12-06
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Pengantar_permohonan extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->c_loc = base_url().'index.php/pengantar_permohonan';
    }

    function index()
    {
        $data['info'] = $info = '';
        
        $data['c_loc'] = $this->c_loc;
        $this->antclass->skin('v_pengantar_permohonan', $data);
    }
}

/* EoF */