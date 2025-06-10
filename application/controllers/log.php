<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: log.php
 * Description: User Log controller
 * Date created: 2011-08-05
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Log extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->antclass->auth_user();
        $this->load->model('mod_log');
        $this->c_loc = base_url().'index.php/log';
    }

    function index() {}

    function login()
    {
        $this->load->library('pagination');
        /*CONFIG STYLE PAGINATION*/
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
        /*CONFIG STYLE PAGINATION*/
        $config['base_url'] = $this->c_loc.'/login';
        $config['total_rows'] = $this->mod_log->count_log('', 'log');
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;
        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['logs'] = $this->mod_log->get_log('', 'log', 'page', $data['start'], $config['per_page']);
        $data['c_loc'] = $this->c_loc.'/login';
        $this->antclass->skin('v_log', $data);
    }
}

/* EoF */