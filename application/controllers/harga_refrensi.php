<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: user.php
 * Description: User controller
 * Date created: 2011-03-17
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Harga_refrensi extends MY_Controller {

    private $table_prefix   = '';

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_user');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_paymentpoint');
        $this->load->model('mod_register','reg');
        $this->load->model('mod_aprove_user','aprove');
        $this->c_loc = base_url().'index.php/user';
    }

    function index()
    {
        
        $this->load->library('pagination');
        $config['base_url']     = $this->c_loc.'/index';
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
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc']     = $this->c_loc;
        $data['hr']        =$this->db->query('select * from Harga_refrensi')->result();
        $data['kecamatan'] = $this->mod_user->get_kecamatan();
        
        $this->antclass->skin('v_harga_r', $data);

    }
    public function get_kel($val='')
    {
        $id_p = $_POST['id_p'];
        $id_kab = $_POST['id_kab'];
        $id_kec = $_POST['id_kec'];
        $data['kel']= $this->mod_user->get_kelurahan($id_p,$id_kab,$id_kec);
        // echo "<pre>";
        // print_r ($data['kel']);
        // echo "</pre>";
        echo json_encode($data['kel']);
    }

    function action()
    {
      $data[$this->table_prefix.'alamat'] =  $this->input->post('alamat');
      $data[$this->table_prefix.'kd_kec'] =  $this->input->post('kecamatan');
      $data[$this->table_prefix.'kd_kel'] =  $this->input->post('kelurahan');
      $data[$this->table_prefix.'harga']  =  $this->input->post('harga');
      $result = $this->db->insert('Harga_refrensi',$data);

      redirect('Harga_refrensi','refresh');
      
    }

    function action_delete($id='')
    {
      $result = $this->db->delete('Harga_refrensi',['id_hr' => $id]);

      redirect('Harga_refrensi','refresh');
      
    }

    function edit($id='')
    {
        
        $this->load->library('pagination');
        $config['base_url']     = $this->c_loc.'/index';
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
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc']     = $this->c_loc;
        $data['get']       =$this->db->query("select * from Harga_refrensi where id_hr=$id ")->row();
        $data['kecamatan'] = $this->mod_user->get_kecamatan();
        
        $this->antclass->skin('v_edit_hr', $data);

    }

    function action_edit($id)
    {
      $data[$this->table_prefix.'alamat'] =  $_POST['alamat'];
      $data[$this->table_prefix.'harga']  =  $_POST['harga'];
      $data[$this->table_prefix.'kd_kec'] =  $_POST['kecamatan'];
      $data[$this->table_prefix.'kd_kel'] =  $_POST['kelurahan'];
      $result = $this->db->where('id_hr',$id)->update('Harga_refrensi',$data);

      redirect('Harga_refrensi','refresh');
      
    }
    
}

/* EoF */