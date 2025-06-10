<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: user.php
 * Description: User controller
 * Date created: 2011-03-17
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Setting extends MY_Controller {

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
        $this->c_loc = base_url().'index.php/user';
    }

    function index()
    {
        
        $info = '';
        $data['info'] = '';
        $data['info'] = $this->session->flashdata('info');
        
        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');

            //echo '<pre>'; print_r($check);exit;
            
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        { 
                            $dataDelete = explode(',', $ch);
                            
                            $this->mod_user->delete_user($dataDelete[0],$dataDelete[1]); 
                        }
                    break;
                    case 'status':
                        foreach($check as $ch)
                        {
                            //$dataDelete = explode(',', $ch);
                            $dataBlokir = explode(',',$ch);

                            //echo '<pre>'; print_r($dataBlokir[0]);exit;

                            $get_status = $this->mod_user->get_user($ch);
                                
                            $old_status = @$get_status->is_blokir;
                           
                            $this->mod_user->change_status($dataBlokir[0], $old_status);

                        }
                    break;
                }
            else: $info = err_msg('Pilih data terlebih dahulu.');
            endif;
            $data['info'] = $info;
        }
        
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
        
        $data['page_link']  = $this->pagination->create_links();
        $data['c_loc']      = $this->c_loc;

        if($this->session->userdata('s_tipe_bphtb') == 'D')
        {   
            $data['user'] = $this->mod_user->get_user  ('', '', '','page', $data['start'],$config['per_page']);
        }
        else
        {
            $data['user'] = $this->mod_user->get_user_self($this->session->userdata('s_tipe_bphtb'));
        }


        $data['durasi'] = $this->mod_user->get_durasi();
        
        $this->antclass->skin('v_setting', $data);

    }

    function action()
    {

      $post = $this->input->post('session_cut');
      $data[$this->table_prefix.'session_cut'] = $post;
      $result = $this->db->where('id',1)->update('tb_session',['session_cut'=>$post]);

      redirect('main','refresh');
      
    }
    
}

/* EoF */