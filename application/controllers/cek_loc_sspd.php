<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/* --------------------------------------------
 * @package
 * @filename    cek_loc_sspd.php
 * @author      BAN
 * @created     Jun 8, 2016
 * @Updated     -
 * --------------------------------------------
 */

class Cek_loc_sspd extends MY_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');

        // $this->load->library('googlemaps');

        $this->load->helper('url_helper');
        $this->load->model('M_global', 'global');
    }

    public function index()
    {
        // $config['center'] = "-7.9666204, 112.6326321";
        // $config['cluster']= true;
        // $config['zoom'] = 'auto';
        // $config['sensor'] = true;
        // $this->googlemaps->initialize($config);
        // $data['map']   = $this->googlemaps->create_map();
        $data['title'] = 'Cek Lokasi SSPD';
        $this->antclass->skin('v_cek_loc_sspd', $data);
        //$this->theme->skin('v_cek_nop.php', $this->data );
    }
}

/* End of file cek_nop.php */
/* Location: ./application/controllers/cek_nop.php */
