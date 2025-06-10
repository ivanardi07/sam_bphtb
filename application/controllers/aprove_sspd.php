<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aprove_sspd extends CI_Controller
{
    private $enableEmailing = false;

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('mod_aprove_sspd', 'aprove');
        $this->antclass->auth_user();
        $this->load->library('session');
        $this->load->library('quotes');
        $this->load->helper('form');
        $this->load->helper('file');
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
        $this->load->model('mod_user');
        $this->load->model('mod_prefix');
        $this->load->model('mod_formulir_penelitian');
        $this->load->model('mod_validasi_sptpd', 'pembayaran');
        $this->c_loc = base_url() . 'index.php/sptpd';
        $this->load->model('mod_aprove_user', 'aprove1');
        $this->load->model('m_global', 'global');
    }
    public function index()
    {
        $ppat = $this->session->userdata('s_id_ppat');
        $data['user'] = $this->aprove->get_sspd($ppat);

        $data['c_loc'] = site_url() . '/sptpd';

        $this->antclass->skin('v_aprove_sspd', $data);
    }

    public function action_aprove($id)
    {
        $data = $this->aprove->acc_sspd($id);
        if ($data == 1) {

            // $email1 = $this->aprove1->get_user_id($id_user);
            $body1 = 'Dokumen Anda Telah Di Aprove Oleh PPAT ';
            if ($this->enableEmailing) {
                $this->global->email($_POST['email'], 'Aprove Dokumen', 'Aprove Dokumen', $body1);
            }

            @$data['info'] = 'Aprove Berhasil';
            $this->session->set_flashdata('info', @$data['info']);
            redirect(site_url() . '/sptpd', @$data);
        } else {
            @$data['info'] .= 'Aprove Gagal';
            $this->session->set_flashdata('info', @$data['info']);
            die('tes');
            redirect(site_url() . '/sptpd', @$data);
        }
    }

    public function reject()
    {
        // die('efwefw');
        $param['no_dokumen']         = $this->input->post('no_dokumen');
        $param['alasan_reject']      = $this->input->post('alasan_reject');

        $proses = $this->aprove->rejectDokumen($param);
        // echo $this->db->last_query();exit();

        if ($proses >= 0) {
            $body1 = 'Pengajuan BPHTB dikembalikan oleh PPAT dengan alasan :<br> "' . $this->input->post('alasan_reject') . '"';
            if ($this->enableEmailing) {
                $this->global->email($this->input->post('email'), 'Reject Dokumen', 'Reject Dokumen', $body1);
            }
            echo "Dokumen berhasil ditolak";
        } else {
            echo "Gagal tolak dokumen";
        }
    }

    public function refresh()
    {
        $data['user'] = $this->aprove->get_user();
        $data['c_loc'] = site_url() . 'sptpd';
        $this->antclass->skin('v_aprove_sspd', $data);
    }

    public function lihat($id)
    {
        $data['id']       = $id;
        // $data['rekening'] = $this->mod_rekening->get_rekening(1);
        $data['c_loc']    = $this->c_loc;
        $data['sptpd']    = $this->mod_sptpd->get_sptpd($id);

        $data['hasil']    = $data['sptpd']->batas - 10;

        $data['email'] = $this->aprove1->get_user_id_bywp($data['sptpd']->id_wp);

        $kd_propinsi      = $data['sptpd']->kd_propinsi;
        $kd_kabupaten     = $data['sptpd']->kd_kabupaten;
        $kd_kecamatan     = $data['sptpd']->kd_kecamatan;
        $kd_kelurahan     = $data['sptpd']->kd_kelurahan;
        $kd_blok          = $data['sptpd']->kd_blok;
        $no_urut          = $data['sptpd']->no_urut;
        $kd_jns_op        = $data['sptpd']->kd_jns_op;
        $nop_compile      = array($kd_propinsi, $kd_kabupaten, $kd_kecamatan, $kd_kelurahan, $kd_blok, $no_urut, $kd_jns_op);

        $nomor_skb      = '';
        $tanggal_skb    = '';
        $nomor_skbkb    = '';
        $tanggal_skbkb  = '';
        $nomor_skbkbt   = '';
        $tanggal_skbkbt = '';
        if ($data['sptpd']->jns_setoran == 'STB') {
            $data['nomor_skb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKB') {
            $data['nomor_skbkb']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkb'] = $data['sptpd']->jns_setoran_tanggal;
        } elseif ($data['sptpd']->jns_setoran == 'SKBKBT') {
            $data['nomor_skbkbt']   = $data['sptpd']->jns_setoran_nomor;
            $data['tanggal_skbkbt'] = $data['sptpd']->jns_setoran_tanggal;
        }
        $data['ppat']                = $this->mod_ppat->get_ppat($data['sptpd']->id_ppat);
        $data['nik']                 = $this->mod_nik->get_nik($data['sptpd']->nik);
        $wil_nik                     = (array) $data['nik'];
        // echo "<pre>";
        // print_r ($data['nik']);
        // echo "</pre>";
        $wil_nik                     = array($wil_nik['kd_propinsi'], $wil_nik['kd_kabupaten'], $wil_nik['kd_kecamatan'], $wil_nik['kd_kelurahan']);
        $data['nik_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $wil_nik);
        $data['nik_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $wil_nik);
        $data['nik_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $wil_nik);
        $data['nik_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $wil_nik);
        $data['nop']                 = $this->mod_nop->get_nop($nop_compile);
        $data['nop_nm_propinsi']     = $this->mod_sptpd->get_wilayah_detail('propinsi', $nop_compile);
        $data['nop_nm_kabupaten']    = $this->mod_sptpd->get_wilayah_detail('kabupaten', $nop_compile);
        $data['nop_nm_kecamatan']    = $this->mod_sptpd->get_wilayah_detail('kecamatan', $nop_compile);
        $data['nop_nm_kelurahan']    = $this->mod_sptpd->get_wilayah_detail('kelurahan', $nop_compile);
        $data['dispenda']            = $this->mod_sptpd->get_dispenda($data['sptpd']->id_dispenda);
        $data['jenis_perolehan']     = $this->mod_jns_perolehan->get_jns_perolehan($data['sptpd']->jenis_perolehan);
        $data['rec_id']              = $id;
        $data['submitvalue']         = 'Edit';
        $data['cek_transaksi_prev']  = $this->mod_sptpd->get_sptpd_previous('', '', '', '', '', $data['sptpd']->nik); // Cek apakah NPWP pernah transaksi sebelumnya
        $setor                       = $this->antclass->back_value($data['sptpd']->jumlah_setor, 'txt_jml_setor_sptpd');
        $data['terbilang_jml_setor'] = $this->terbilang_val($setor);
        $data['penelitian'] = $this->mod_sptpd->get_lampiran($data['sptpd']->no_dokumen);

        $data['kabid']  = $this->mod_user->get_kabid();

        $this->antclass->skin('v_lihat_aprove_ppat', $data);
    }


    public function terbilang_val($nilai = null)
    {
        if (isset($_POST['ajax'])) {
            $convert         = $this->antclass->terbilang($this->input->post('enValue'), 3);
            $terbilang_array = array('result' => $convert);
            echo json_encode($terbilang_array);
        } else {
            $convert = $this->antclass->terbilang($nilai, 3);
            return $convert . ' Rupiah';
        }
    }
}

/* End of file aprove_sspd.php */
/* Location: ./application/controllers/aprove_sspd.php */