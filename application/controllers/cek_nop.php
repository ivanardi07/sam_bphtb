<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/* --------------------------------------------
 * @package
 * @filename    Cek_nop.php
 * @author
 * @created     Okt 20, 2010
 * @Updated     -
 * --------------------------------------------
 */

class Cek_nop extends MY_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->helper('form');

        $this->load->helper('url_helper');
        $this->data['head']['stylesheet'] = "<link rel='stylesheet' href='" . base_url() . "assets/css/report.css' type='text/css' media='screen'> \n";
        $this->data['head']['javascript'] = "<script language='JavaScript' src='" . base_url() . "assets/scripts/jquery-1.4.2.min.js'></script> \n";
        $this->data['head']['javascript'] .= "<script language='JavaScript' src='" . base_url() . "assets/scripts/jquery.maskedinput-1.3.min.js'></script> \n";
        $this->data['report']['title'] = 'CEK VERIFIKASI SSPD';
        $this->data['body']['onload']  = 'document.form1.NOP.focus();';
        $this->load->model('mod_validasi_sptpd', 'pembayaran');
        $this->load->library('terbilang');
        $this->load->library('quotes');
        $this->load->library('tanggal');
    }

    public function Nop()
    {
        parent::Controller();
        $this->usermanager->Authentifikasi();
    }

    public function index()
    {
        // Cek Empty Validasi NOP

        if ($this->input->post('no_sspd') == '') {
            $this->antclass->skin('v_cek_nop', $this->data);
            return true;
        }

        if ($this->input->post('submit_approval')) {

            $id_sptpd = $this->input->post('txt_id_sptpd');

            $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->kode_validasi;

            if ($kode_validasi == $this->input->post('kode_approval')) {
                $id_dispenda = $this->session->userdata('s_id_dispenda');

                $kode = $this->pembayaran->get_sptpd($id_sptpd)->kode_validasi;
                $kode = substr($kode, 0, -5) . $id_dispenda;

                $this->pembayaran->update_sptpd($id_sptpd, $id_dispenda);
                $this->pembayaran->update_kode_validasi($id_sptpd, $kode);
            } else {
                @$this->data['approval']->error = "*Kode Tidak Cocok";
                $this->data['approval']->value  = $this->input->post('kode_approval');
            }
        }

        if ($this->input->post('txt_submit')) {

            $row = $this->pembayaran->get_entries_by_no_sspd(trim($this->input->post('no_sspd')));

            if (count($row) == 0) {

                $this->session->set_flashdata('flash_msg', err_msg('Nomor SSPD tidak ditemukan !'));

                redirect('cek_nop');

                return true;
            }
        }

        // Tampil data

        $this->data['report']['valid'] = true;
        $this->data['row']             = $row;

        $this->antclass->skin('v_cek_nop', $this->data);
        //$this->theme->skin('v_cek_nop.php', $this->data );
    }

    public function proses_validasi($type)
    {

        $id_user = $this->input->post('id_user');

        if ($type == 'PP') {

            $id_sptpd = $this->input->post('txt_id_sptpd');
            $jabatan  = $this->input->post('jabatan_user');

            $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->validasi_dispenda;

            if ($this->input->post('cek_kode_validasi_dispenda') != '') {

                if ($kode_validasi == trim($this->input->post('kode_approval'))) {

                    $this->pembayaran->update_sptpd($id_sptpd, $id_user, $type);
                    $this->pembayaran->update_kode_validasi($id_sptpd, $kode_validasi, $type);

                    $this->session->set_flashdata('flash_msg', succ_msg('Berhasil Melakukan Pembayaran di Bank'));
                } else {
                    @$this->data['approval']->error = "*Kode Tidak Cocok";
                    $this->data['approval']->value  = $this->input->post('kode_approval');
                }
            } else {

                $this->session->set_flashdata('flash_msg', err_msg('*Harus Melakukan Validasi ke Badan Pendapatan Daerah Kota Malang'));
            }
        } elseif ($type == 'D') {

            $id_sptpd           = $this->input->post('txt_id_sptpd');
            $tgl_valid_dispenda = $this->input->post('tgl_validasi_dispenda');
            $jabatan            = $this->input->post('jabatan_user');

            if ($tgl_valid_dispenda == '') {
                $this->session->set_flashdata('flash_msg', err_msg('*Tanggal Harus Diinputkan'));
            } else {
                $kode_validasi = $this->pembayaran->get_sptpd($id_sptpd)->kode_validasi;

                if ($kode_validasi == trim($this->input->post('kode_approval'))) {

                    $this->pembayaran->update_sptpd($id_sptpd, $id_user, $type, $tgl_valid_dispenda, $jabatan);
                    $this->pembayaran->update_kode_validasi($id_sptpd, $kode_validasi, $type);

                    $this->session->set_flashdata('flash_msg', succ_msg('Validasi di BPPD Berhasil'));
                } else {
                    @$this->data['approval']->error = "*Kode Tidak Cocok";
                    $this->data['approval']->value  = $this->input->post('kode_approval');
                }
            }
        }

        redirect('cek_nop');
    }

    public function update()
    {
        if ($this->input->post('submit_approval')) {
            $id_sptpd = $this->input->post('txt_id_sptpd');
            $nop      = $this->input->post('txt_id_nop');
            $id_ppat  = $this->mysession->userdata('SESSI_ID_PPAT');
            if ($this->pembayaran->update_sptpd($id_sptpd, $id_ppat)) {
                //echo 'yo';
            }
        }
    }

    public function rejectDokumen()
    {
        $param['no_dokumen']         = $this->input->post('no_dokumen');
        $param['alasan_reject']      = $this->input->post('alasan_reject');

        $log = $this->pembayaran->logReject($param);
        $proses = $this->pembayaran->rejectDokumen($param);

        if ($proses >= 0) {
            echo "Proses pengembalian pengajuan BPHTB berhasil!";
        } else {
            echo "Proses pengembalian pengajuan BPHTB gagal!";
        }
    }

    public function batal_bayar($id = '')
    {
        $id     = decode($id);

        $proses = $this->pembayaran->batal_bayar($id);

        if ($proses > 0) {
            $this->session->set_flashdata('flash_msg', succ_msg('SSPD Berhasil melakukan pembatalan pembayaran !'));
        } else {
            $this->session->set_flashdata('flash_msg', err_msg('SSPD Gagal melakukan pembatalan pembayaran'));
        }

        redirect('cek_nop');
    }

    public function cek_from_sptpdlist($no_sspd)
    {
        $row = $this->pembayaran->get_entries_by_no_sspd($no_sspd);

        if (count($row) == 0) :

            $this->session->set_flashdata('flash_msg', err_msg('Nomor SSPD tidak ditemukan !'));

            redirect('cek_nop');

            return true;
        endif;

        $this->data['report']['valid'] = true;
        $this->data['row']             = $row;

        $this->antclass->skin('v_cek_nop', $this->data);
    }
}

/* End of file cek_nop.php */
/* Location: ./application/controllers/cek_nop.php */
