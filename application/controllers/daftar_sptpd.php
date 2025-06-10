<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class daftar_sptpd extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('sptpd_model');   
        $this->load->model('mod_nik');
        $this->load->helper('url_helper');
        $this->load->model('mod_export_excel','excel');
        $this->load->library('session'); 
        $this->c_loc = base_url().'index.php/daftar_sptpd';  
    }
    
    function index()
    {
        $cari['nop']     = trim($this->input->get('cari'));
        $cari['no_sspd'] = trim($this->input->get('no_sspd'));

        if ($cari['nop'] != '' || $cari['no_sspd'] != '') {
            $array = array(
                'pencarian' => $cari
            );
            
            $this->session->set_userdata( $array );
        }
        
        $id_user = $this->session->userdata('s_id_user');

        $tipe_user = $this->sptpd_model->get_user($id_user);
        
        $this->load->library('pagination');
        $config['base_url'] = $this->c_loc.'/index';
        $config['total_rows'] = $this->sptpd_model->count_sptpd();
        $config['per_page'] = 20;
        $config['uri_segment'] = 3;

        /*STYLE PAGINATION START*/
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

        /*STYLE PAGINATION END*/

        $data['start'] = $this->uri->segment(3);
        if(empty($data['start'])){ $data['start'] = 0; }
        $this->pagination->initialize($config);
        
        $data['page_link'] = $this->pagination->create_links();
        $data['c_loc'] = $this->c_loc;
        $data['tipe_user'] = $tipe_user;
        
        if($tipe_user == 'D'){
            $id_ppat="";
            $data['sptpd'] = $this->sptpd_model->get_sptpd('', '', 'page', $data['start'], $config['per_page']);

        }
        elseif($tipe_user == 'PT')
        {
            
            $id_ppat = $this->sptpd_model->get_id_ppat($id_user);
            $data['sptpd'] = $this->sptpd_model->get_sptpd('', '', 'page', $data['start'], $config['per_page'], @$id_ppat);
            // echo $this->db->last_query(); exit;
        }
        
        if ($tipe_user == 'PT') {
            $data['sum_jumlah_setor'] = $this->sptpd_model->sum_jumlah_setor(@$id_ppat,true);
        }
        
        
        $this->antclass->skin('v_daftar_sptpd', $data);
    }    

    public function print_pdf()
    {
        $data['isi']    = $this->db->query("SELECT * from tbl_sptpd")->result();
        // echo "<pre>";
        // print_r ($data['isi']);exit();
        // echo "</pre>";


        $this->load->library('fpdf_gen');
        $pdf = new fpdf('L','mm',array(260,380));

        $pdf->AddPage();        
        $pdf->SetAutoPageBreak(true, 0);

        // header----------

        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(310,10,'Laporan SSPD', 0, 1, 'L');

        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(15,5,'ID SSPD', 1, 0, 'C');
        $pdf->Cell(20,5,'ID PPAT', 1, 0, 'C');
        $pdf->Cell(25,5,'NIK', 1, 0, 'C');
        $pdf->Cell(15,5,'No Urut', 1, 0, 'C');
        $pdf->Cell(25,5,'Jns Perolehan', 1, 0, 'C');
        $pdf->Cell(25,5,'Luas Tanah OP', 1, 0, 'C');
        $pdf->Cell(30,5,'Luas Bangunan OP', 1, 0, 'C');
        $pdf->Cell(30,5,'NJOP Tanah OP', 1, 0, 'C');
        $pdf->Cell(30,5,'NJOP Bangunan OP', 1, 0, 'C');
        $pdf->Cell(20,5,'Nilai OP', 1, 0, 'C');
        $pdf->Cell(20,5,'Nilai Pasar', 1, 0, 'C');
        $pdf->Cell(25,5,'No Sertifikat', 1, 0, 'C');
        $pdf->Cell(25,5,'NJOP PBB OP', 1, 0, 'C');
        $pdf->Cell(28,5,'Tahun SPPT', 1, 0, 'C');
        $pdf->Cell(30,5,'No Dokumen', 1, 1, 'C');

        foreach ($data['isi'] as $key => $value) {
            // echo "<pre>";
            // print_r ($value);exit();
            // echo "</pre>";

        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(15,5,$value->id_sptpd, 1, 0, 'C');
        $pdf->Cell(20,5,$value->id_ppat, 1, 0, 'C');
        $pdf->Cell(25,5,$value->nik, 1, 0, 'C');
        $pdf->Cell(15,5,$value->no_urut, 1, 0, 'C');
        $pdf->Cell(25,5,$value->jenis_perolehan, 1, 0, 'C');
        $pdf->Cell(25,5,$value->luas_tanah_op, 1, 0, 'C');
        $pdf->Cell(30,5,$value->luas_bangunan_op, 1, 0, 'C');
        $pdf->Cell(30,5,$value->njop_tanah_op, 1, 0, 'C');
        $pdf->Cell(30,5,$value->njop_bangunan_op, 1, 0, 'C');
        $pdf->Cell(20,5,$value->nilai_op, 1, 0, 'C');
        $pdf->Cell(20,5,$value->nilai_pasar, 1, 0, 'C');
        $pdf->Cell(25,5,$value->no_sertifikat_op, 1, 0, 'C');
        $pdf->Cell(25,5,$value->njop_pbb_op, 1, 0, 'C');
        $pdf->Cell(28,5,$value->thn_pajak_sppt, 1, 0, 'C');
        $pdf->Cell(30,5,$value->no_dokumen, 1, 1, 'C');
            
        }

        $pdf->Output("printsspd.pdf","I");

    }

    public function export_excel($value='')
    {
        $this->excel->export_laporan();
    }
}