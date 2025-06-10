<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: tagih_bea.php
 * Description: Penerbitan SK Surah Tagih Bea controller
 * Date created: 2011-12-06
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Tagih_bea extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->c_loc = base_url().'index.php/tagih_bea';
    }

    function index()
    {
        $data['info'] = $info = '';
        
        $data['c_loc'] = $this->c_loc;
        $this->antclass->skin('v_tagih_bea', $data);
    }
}

/* EoF */