<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filename: data.php
 * Description: Import data
 * Date created: 2011-09-09
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Data extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('mod_sptpd');
        $this->load->model('mod_sppt');
        $this->load->model('mod_ppat');
        $this->load->model('mod_nik');
        $this->load->model('mod_nop');
        $this->load->model('mod_dati2');
        $this->load->model('mod_propinsi');
        $this->load->model('mod_kecamatan');
        $this->load->model('mod_kelurahan');
        $this->load->model('mod_jns_perolehan');
        $this->load->model('mod_rekening');
        $this->load->model('mod_paymentpoint');
        $this->load->model('mod_nop_log');
        $this->c_loc = base_url().'index.php/data';
    }

    function index() {}
    
    function update_sppt()
    {
        $query = $this->db->get('view_data_pbb');
        $data = $query->result();
        // echo '<pre>'; print_r($data); echo '</pre>';
        //         exit;
        foreach($data as $dt)
        {
            $nop = $dt->kd_propinsi.$dt->kd_dati2.$dt->kd_kecamatan.$dt->kd_kelurahan.$dt->kd_blok.$dt->no_urut.$dt->kd_jns_op;   
            $add_data = array('kd_propinsi'=>$dt->kd_propinsi,
                              'kd_dati2'=>$dt->kd_dati2, 
                              'kd_kecamatan'=>$dt->kd_kecamatan, 
                              'kd_kelurahan'=>$dt->kd_kelurahan, 
                              'kd_blok'=>$dt->kd_blok, 
                              'no_urut'=>$dt->no_urut, 
                              'kd_jns_op'=>$dt->kd_jns_op, 
                              'thn_pajak_sppt'=>$dt->thn_pajak_sppt, 
                              'nm_wp_sppt'=>$dt->nm_wp_sppt, 
                              'jln_wp_sppt'=>$dt->jln_wp_sppt, 
                              'blok_kav_no_wp_sppt'=>$dt->blok_kav_no_wp_sppt, 
                              'rw_wp_sppt'=>str_replace('\\', '', $dt->rw_wp_sppt), 
                              'rt_wp_sppt'=>str_replace('\\', '', $dt->rt_wp_sppt), 
                              'kelurahan_wp_sppt'=>$dt->kelurahan_wp_sppt, 
                              'kota_wp_sppt'=>$dt->kota_wp_sppt,
                              'luas_bumi_sppt'=>$dt->luas_bumi_sppt,
                              'luas_bng_sppt'=>$dt->luas_bng_sppt,
                              'njop_bumi_sppt'=>$dt->njop_bumi_sppt,
                              'njop_bng_sppt'=>$dt->njop_bng_sppt,
                              'jalan_op'=>$dt->jalan_op,
                              'pbb_harus_dibayar_sppt'=>$dt->pbb_yg_harus_dibayar_sppt,
                              'token'=>0
                             );
            if($this->db->insert('sppt', $add_data))
            {
                echo $nop;
                echo '<br />';
            }
            else
            {
                echo 'no';
            }
        }   
    }
    
    // Update jln_wp_sppt dan pbb_harus_dibayar_sppt
    function update_sppt_jln_pbb()
    {
        $query = $this->db->get('view_data_pbb');
        $data = $query->result();
        foreach($data as $dt)
        {
            $nop = $dt->kd_propinsi.$dt->kd_dati2.$dt->kd_kecamatan.$dt->kd_kelurahan.$dt->kd_blok.$dt->no_urut.$dt->kd_jns_op;   
            $ed_data = array('jln_wp_sppt'=>$dt->jln_wp_sppt, 'pbb_harus_dibayar_sppt'=>$dt->pbb_yg_harus_dibayar_sppt);
            $this->db->where('kd_propinsi', $dt->kd_propinsi);
            $this->db->where('kd_dati2', $dt->kd_dati2);
            $this->db->where('kd_kecamatan', $dt->kd_kecamatan);
            $this->db->where('kd_kelurahan', $dt->kd_kelurahan);
            $this->db->where('kd_blok', $dt->kd_blok);
            $this->db->where('no_urut', $dt->no_urut);
            $this->db->where('kd_jns_op', $dt->kd_jns_op);
            if($this->db->update('sppt', $ed_data))
            {
                echo $nop;
                echo '<br />';
            }
            else
            {
                echo 'no';
            }
        }   
    }

    function update_nop()
    {
        $query = $this->db->get('sppt');
        $data = $query->result();
        foreach($data as $dt)
        {
            $nop = $dt->kd_propinsi.$dt->kd_dati2.$dt->kd_kecamatan.$dt->kd_kelurahan.$dt->kd_blok.$dt->no_urut.$dt->kd_jns_op;
            
            $this->db->where('nop', $nop);
            $query = $this->db->get('tbl_nop');
            if( ! $query->row())
            {
                $add_data = array('nop'=>$nop, 
                                  'lokasi_op'=>$dt->jln_wp_sppt, 
                                  'kelurahan_op'=>$dt->kd_propinsi.'.'.$dt->kd_dati2.'.'.$dt->kd_kecamatan.'.'.$dt->kd_kelurahan, 
                                  'rtrw_op'=>$dt->rw_wp_sppt.' / '.$dt->rt_wp_sppt,
                                  'kecamatan_op'=>$dt->kd_propinsi.'.'.$dt->kd_dati2.'.'.$dt->kd_kecamatan,
                                  'kotakab_op'=>$dt->kd_propinsi.'.'.$dt->kd_dati2,
                                  'luas_tanah_op'=>$dt->luas_bumi_sppt,
                                  'luas_bangunan_op'=>$dt->luas_bng_sppt,
                                  'njop_tanah_op'=>$dt->njop_bumi_sppt/$dt->luas_bumi_sppt,
                                  'njop_bangunan_op'=>$dt->njop_bng_sppt/$dt->luas_bng_sppt,
                                  'njop_pbb_op'=>$dt->njop_bumi_sppt+$dt->njop_bng_sppt,
                                  //'nilai_op'=>$nilai_op,
                                  'jenis_perolehan_op'=>'',
                                  'no_sertipikat_op'=>''
                                 );
                if($this->db->insert('tbl_nop', $add_data))
                {
                    echo $nop;
                    echo '<br />';
                }
                else
                {
                    echo 'no';
                }
            }
        }   
    }
}

/* EoF */