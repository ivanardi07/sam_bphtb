<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: sptpd.php
 * Description: SPTPD controller
 * Date created: 2011-03-18
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Penerbitanlapangan extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->c_loc = base_url().'index.php/penerbitanlapangan';
    }

    function index()
    {
        $this->add();
    }
    
    function add()
    {
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $this->antclass->skin('v_penerbitanlapanganform', $data);
    }
    function get_nik()
    {
    
        $this->load->model('mod_nik');
        $id_nik = $this->input->post('rx_id_nik');
        $data = $this->mod_nik->get_nik($id_nik);
        if($data)
        {
            $ret = array();
            $ret['nama'] = $data->nama;
            $ret['alamat'] = $data->alamat;
            $ret['nm_kelurahan'] = $data->nm_kelurahan;
            $ret['nm_kecamatan'] = $data->nm_kecamatan;
            $ret['nm_dati2'] = $data->nm_dati2;
            $ret['rtrw'] = $data->rtrw;
            $ret['kodepos'] = $data->kodepos;
            echo json_encode($ret);
        }
        else
        {
            $ret = array();
            $ret['nama'] = '';
            $ret['alamat'] = '';
            $ret['nm_kelurahan'] = '';
            $ret['nm_kecamatan'] = '';
            $ret['nm_dati2'] = '';
            $ret['rtrw'] = '';
            $ret['kodepos'] = '';
            echo json_encode($ret);
        }
    }
    function get_nop()
    {
    
        $this->load->model('mod_nop');
        $id_nop = $this->antclass->id_replace($this->input->post('rx_id_nop'));
        $id_nik = $this->antclass->id_replace($this->input->post('rx_id_nik'));
        $data = $this->mod_nop->get_nop($id_nop);
        if($data)
        {
            $ret = array();
            $ret['lokasi_op'] = $data->lokasi_op;
            $ret['nm_kelurahan'] = $data->nm_kelurahan;
            $ret['nm_kecamatan'] = $data->nm_kecamatan;
            $ret['nm_dati2'] = $data->nm_dati2;

    
            echo json_encode($ret);
        }
        else
        {
      $ret = array();
            $ret['lokasi_op'] = $data->lokasi_op;
            $ret['nm_kelurahan'] = $data->nm_kelurahan;
            $ret['nm_kecamatan'] = $data->nm_kecamatan;
            $ret['nm_dati2'] = $data->nm_dati2;

    
            echo json_encode($ret);
        }
    }           
    
    
}

/* EoF */
