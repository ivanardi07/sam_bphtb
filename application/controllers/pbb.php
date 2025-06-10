<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: pbb.php
 * Description: PBB controller
 * Date created: 2011-04-14
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Pbb extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->model('mod_pbb');
        $this->load->library('session');
        $this->c_loc = base_url().'index.php/pbb';
    }

    function index()
    {
        $nop = $this->uri->segment(3);
        $date_start = $this->uri->segment(4);
        $date_end = $this->uri->segment(5);

        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/report/'.$nop.'/'.$date_start.'/'.$date_end;
        $config['total_rows'] = $this->mod_pbb->count_nop_pbb($nop, $date_start, $date_end);
        $config['per_page'] = 20;
        $config['uri_segment'] = 10;
        $data['start'] = $this->uri->segment(10);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);

        $data['page_link'] = $this->pagination->create_links();
        $data['nop_pbbs'] = $this->mod_pbb->get_nop_pbb();
        $data['sum_pbb_bayar'] = $this->mod_pbb->sum_pbb_bayar();
        $data['c_loc'] = $this->c_loc;
        $this->antclass->skin('v_pbb', $data);
    }
}

/* EoF */