<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: bukti_terima_surat.php
 * Description: Bukti Penerimaan Surat controller
 * Date created: 2011-10-03
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Bukti_terima_surat extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_bukti_terima_surat');
        $this->c_loc = base_url().'index.php/bukti_terima_surat';
    }

    function index()
    {
        $info = '';
        $data['info'] = '';
        
        if($this->input->post('submit_multi'))
        {
            $check = $this->input->post('check');
            if( ! empty($check)):
                switch($this->input->post('submit_multi'))
                {
                    case 'delete':
                        foreach($check as $ch)
                        { $this->mod_dati2->delete_dati2($ch); }
                    break;
                }
            else: $info = '<div class="warn_text">Please select data first.</div>';
            endif;
            $data['info'] = $info;
        }
        $data['c_loc'] = $this->c_loc;
        $data['bts'] = $this->mod_bukti_terima_surat->get_bukti_terima_surat();
        $this->antclass->skin('v_bukti_terima_surat', $data);
    }
    
    function add()
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nop', 'NOP', 'required');
            $this->form_validation->set_rules('txt_tgl_masuk', 'Tanggal Masuk', 'required');
            $this->form_validation->set_rules('txt_tgl_keluar', 'Tanggal Keluar', 'required');
            $this->form_validation->set_rules('txt_masa_pajak', 'Masa Pajak', 'required');
            $this->form_validation->set_rules('txt_pemeriksaan', 'Pemeriksaan', '');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $nop = $this->antclass->remove_separator($this->input->post('txt_nop'));
                $tgl_surat = date('Y-m-d');
                $tgl_masuk = $this->input->post('txt_tgl_masuk');
                $tgl_keluar = $this->input->post('txt_tgl_keluar');
                $masa_pajak = $this->input->post('txt_masa_pajak');
                $pemeriksaan = $this->input->post('txt_pemeriksaan');
                
                // function add_bukti_terima_surat($nop, $tgl_surat, $tgl_masuk, $tgl_keluar, $pemeriksaan, $masa_pajak)
                $info = $this->mod_bukti_terima_surat->add_bukti_terima_surat($nop, $tgl_surat, $tgl_masuk, $tgl_keluar, $pemeriksaan, $masa_pajak);
                if($info)
                {
                    $data['info'] = '<div class="note_text">Input Bukti Penerimaan Surat Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Input Bukti Penerimaan Surat Gagal.</div>';
                }
            }
        }
        
        $data['c_loc'] = $this->c_loc;
        $data['submitvalue'] = 'Simpan';
        $data['rec_id'] = '';
        $this->antclass->skin('v_bukti_terima_suratform', $data);
    }

    function edit($id)
    {
        if($this->input->post('submit'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('txt_nama_dati2', 'Nama', 'required');
            
            if($this->form_validation->run() == FALSE)
            {
                $data['info'] = '<div class="warn_text">'.validation_errors().'</div>';
            }
            else
            {
                $kd_dati2 = $this->input->post('h_rec_id');
                $nama = $this->input->post('txt_nama_dati2');
                
                $info = $this->mod_dati2->edit_dati2($kd_dati2, $nama);
                if($info)
                {
                    $data['info'] = '<div class="note_text">Update dati2 Berhasil.</div>';
                }
                else
                {
                    $data['info'] = '<div class="warn_text">Update dati2 Gagal.</div>';
                }
            }
        }
        
        if($data['bts'] = $this->mod_bukti_terima_surat->get_bukti_terima_surat($id))
        {
            $data['c_loc'] = $this->c_loc;
            $data['submitvalue'] = 'Edit';
            $data['rec_id'] = $id;
            $this->antclass->skin('v_bukti_terima_suratform', $data);
        }
        else
        {
            $this->antclass->skin('v_notfound');
        }
    }
}

/* EoF */