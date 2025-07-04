<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

/**
 * Filename: mod_sptpd.php
 * Description: SPTPD model
 * Date created: 2011-03-19
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_sptpd extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_sptpd';
    }

    public function batas($id_sptpd, $a)
    {
        $sql = "update tbl_sptpd set batas = '$a' where id_sptpd = " . $id_sptpd;
        $data = $this->db->query($sql);
        // echo $this->db->last_query();exit();
        if ($data) {
            return true;
        }
        return false;
    }

    public function get_sptpd($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '', $nop = '', $id_ppat = '', $nodok = '', $no_pelayanan = '', $date_start = '', $date_end = '')
    {
        if ($id != '') {
            $this->db->where('id_sptpd', $id);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->row();
        } elseif ($nik != '') {
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if (count(@$nop[1][0]) > 0) {
                $this->db->where('kd_propinsi', @$nop[0]);
                $this->db->where('kd_kabupaten', @$nop[1]);
                $this->db->where('kd_kecamatan', @$nop[2]);
                $this->db->where('kd_kelurahan', @$nop[3]);
                $this->db->where('kd_blok', @$nop[4]);
                $this->db->where('no_urut', @$nop[5]);
                $this->db->where('kd_jns_op', @$nop[6]);
            }
            if ($id_ppat != '') {
                $this->db->where('id_ppat', $id_ppat);
            }
            if ($nodok != '') {
                $this->db->where('no_dokumen', $nodok);
            }
            if ($no_pelayanan != '') {
                $this->db->where('no_pelayanan', $no_pelayanan);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            if ($date_start != '') {
                $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
            }

            $type_user = $this->session->userdata('s_tipe_bphtb');

            if ($type_user == 'PT') {
                $id_ppat = $this->session->userdata('s_id_ppat');
                $this->db->where('id_ppat', $id_ppat);
                // $this->db->where('aprove_ppat','1');
            }
            if ($type_user == 'WP') {
                $id_wp = $this->session->userdata('s_id_wp');
                $this->db->where('id_wp', $id_wp);
                // $this->db->where('aprove_ppat','1');
            }



            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            // echo $this->db->last_query();
            return $query->result();
        }
    }

    //tambahan search function get_sptpd1
    public function get_sptpd1($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '', $nop = '', $nodok = '', $no_pelayanan = '', $date_start = '', $date_end = '', $nama_wp = '')
    {
        if ($id != '') {
            $this->db->where('id_sptpd', $id);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if (!isset($_POST['search'])) {
                if ($go_page != '') {
                    $this->db->limit($halt_at, $start); //limit untuk pagination halt_at = batas, start = data dimulai

                }

                $type_user = $this->session->userdata('s_tipe_bphtb');

                if ($type_user == 'PT') {
                    $id_ppat = $this->session->userdata('s_id_ppat');
                    $this->db->where('id_ppat', $id_ppat);
                    // $this->db->where('aprove_ppat','1');
                    $this->db->order_by('id_sptpd', 'desc');
                    $query = $this->db->get($this->tbl);
                    return $query->result();
                }
                if ($type_user == 'WP') {
                    $id_wp = $this->session->userdata('s_id_wp');
                    $this->db->where('id_wp', $id_wp);
                    // $this->db->where('aprove_ppat','1');
                    $this->db->order_by('id_sptpd', 'desc');
                    $query = $this->db->get($this->tbl);
                    return $query->result();
                }
                $this->db->order_by('id_sptpd', 'desc');
                $query = $this->db->get($this->tbl);
                return $query->result();
            } else if (isset($_POST['search'])) {
                if (count(@$nop[1][0]) > 0) {
                    $this->db->where('kd_propinsi', @$nop[0]);
                    $this->db->where('kd_kabupaten', @$nop[1]);
                    $this->db->where('kd_kecamatan', @$nop[2]);
                    $this->db->where('kd_kelurahan', @$nop[3]);
                    $this->db->where('kd_blok', @$nop[4]);
                    $this->db->where('no_urut', @$nop[5]);
                    $this->db->where('kd_jns_op', @$nop[6]);
                } else if ($nodok != '') {
                    $this->db->where('no_dokumen', $nodok);
                } else if ($no_pelayanan != '') {
                    $this->db->where("no_pelayanan LIKE '%$no_pelayanan%'");
                } else if ($nik != '') {
                    $this->db->where('nik', $nik);
                } else if ($nama_wp != '') {
                    $this->db->where("nama_wp LIKE '%$nama_wp%'");
                } else if ($limit != '') {
                    $this->db->limit($limit);
                } else if ($date_start != '') {
                    $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
                }

                $type_user = $this->session->userdata('s_tipe_bphtb');

                if ($type_user == 'PT') {
                    $id_ppat = $this->session->userdata('s_id_ppat');
                    $this->db->where('id_ppat', $id_ppat);
                    // $this->db->where('aprove_ppat','1');
                    $this->db->order_by('id_sptpd', 'desc');
                    $query = $this->db->get($this->tbl);
                    return $query->result();
                }
                if ($type_user == 'WP') {
                    $id_wp = $this->session->userdata('s_id_wp');
                    $this->db->where('id_wp', $id_wp);
                    // $this->db->where('aprove_ppat','1');
                    $this->db->order_by('id_sptpd', 'desc');
                    $query = $this->db->get($this->tbl);
                    return $query->result();
                }

                $this->db->order_by('id_sptpd', 'desc');
                $query = $this->db->get($this->tbl);
                return $query->result();
            }
        }
    }

    public function get_reject_pt($ppat = '')
    {

        $sql = "select * from tbl_sptpd where id_ppat = '$ppat' and is_lunas = '3' and proses = '-1' and aprove_ppat = '-1' ";

        $data = $this->db->query($sql);
        // echo $this->db->last_query();
        return $data->result();
    }

    public function get_reject_d()
    {

        $get  = $this->session->all_userdata();
        $tipe = $get['s_tipe_bphtb'];
        $jab  = @$get['jabatan'];

        if ($tipe == 'D' && $jab == '0') {
            $sql = "select * from tbl_sptpd where is_lunas = '3' and proses = '-1' ";
        } elseif ($tipe == 'D' && $jab == '1') {
            $sql = "select * from tbl_sptpd where is_lunas = '3' and proses = '0' ";
        } elseif ($tipe == 'D' && $jab == '2') {
            $sql = "select * from tbl_sptpd where is_lunas = '3' and proses = '1' ";
        } elseif ($tipe == 'D' && $jab == null) {
            $sql = "select * from tbl_sptpd where is_lunas = '3'";
        }

        $data = $this->db->query($sql);
        // echo $this->db->last_query();
        return $data->result();
    }

    public function get_fileUpload($no_dokumen)
    {
        $this->db->where('no_sspd', $no_dokumen);
        $query = $this->db->get('tbl_formulir_penelitian');
        return $query->row();
    }

    public function get_sspd_no($sspd_no)
    {
        $this->db->select('no_dokumen');
        $this->db->where('id_sptpd', $sspd_no);
        $query = $this->db->get('tbl_sptpd');
        return $query->row();
    }

    public function get_sptpd_previous($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '')
    {
        if ($id != '') {
            $this->db->where('id_sptpd', $id);
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            //if ($nik != '') {$this->db->array('nik' => $nik, 'is_lunas !=' => '4' );}   array('name !=' => $name, 'id <' => $id, 'date >' => $date);
            if ($nik != '') {
                $this->db->where('nik', $nik);
            } //and is_lunas = 4 => batal, NPOPTKP 
            if ($limit != '') {
                $this->db->limit($limit);
            }
            $this->db->order_by('tanggal', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    public function get_nik($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '')
    {
        if ($id != '') {
            //$this->db->where('nik',$id);
            //$query = $this->db->get($this->tbl);
            $sql = "SELECT a.*, b.id_wp
                    FROM tbl_nik a
                    left join tbl_wp b on b.nik = a.nik
                    WHERE a.nik = '$id'";
            $query = $this->db->query($sql, $id);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            if ($nik['nik'] != '') {
                $this->db->where('nik', str_replace('.', '', $nik['nik']));
            }
            if ($nik['nama'] != '') {
                $this->db->like('nama', $nik['nama']);
            }
            $this->db->order_by('nik', 'asc');
            $query = $this->db->get('tbl_nik');

            return $query->result();
        }
    }

    /*
    function get_last_autonum(){
        $this->db->limit(1);
        $this->db->order_by('no_dokumen','desc');
        $this->db->where("no_dokumen LIKE '".date('d').date('m').date('Y')."%'");
        $this->db->select('no_dokumen');
        $query = $this->db->get($this->tbl);
        return $query->result();
    }
    */

    public function get_last_autonum()
    {
        $this->db->limit(1);
        $this->db->order_by('no_dokumen', 'desc');
        $this->db->where("no_dokumen LIKE '" . date('d') . '.' . date('m') . '.' . date('Y') . '.' . "%'");
        $this->db->select('no_dokumen');
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    public function check_nop($nop)
    {
        if ($nop != '') {
            $this->db->where('nop', $nop);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return true;
            }
        }

        return false;
    }

    public function check_ppat($ppat)
    {
        if ($ppat != '') {
            $this->db->where('id_ppat', $ppat);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return true;
            }
        }

        return false;
    }

    public function check_nik($nik)
    {
        if ($nik != '') {
            $this->db->where('nik', $nik);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return true;
            }
        }

        return false;
    }

    public function get_report_sptpd($id = '', $date_start = '', $date_end = '', $pp = '', $ppat = '', $pwp = '', $stb = '', $skbkb = '', $skbkbt = '', $user = '', $nodok = '', $status = '', $go_page = '', $start = '', $halt_at = '')
    {
        if ($id != '') {
            $this->db->where('id_sptpd', $id);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($date_start != '') {
                $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
            }
            if ($pp != '') {
                $this->db->where('id_bank', $pp);
            }
            if ($user != '') {
                $this->db->where('id_user', $user);
            }
            if ($nodok != '') {
                $this->db->where('no_dokumen', $nodok);
            }
            if ($status != '') {

                if ($status == 'lunas') {
                    $this->db->where('validasi_dispenda !=', 'null');
                } elseif ($status == 'belum') {
                    $this->db->where('validasi_dispenda IS NULL');
                    $this->db->where('npop >= npoptkp');
                } elseif ($status == 'tidak_kena_pajak') {
                    $this->db->where('npop < npoptkp');
                }
            }
            if ($ppat != '' && $ppat != 'DISPENDA') {
                $this->db->where('id_ppat', $ppat);
            }
            if ($ppat == 'DISPENDA') {
                $this->db->where("id_ppat = ''");
            }
            $dasar = array($pwp, $stb, $skbkb, $skbkbt);
            if ($pwp != '' or $stb != '' or $skbkb != '' or $skbkbt != '') {
                $this->db->where_in('jns_setoran', $dasar);
            }
            $this->db->order_by('id_sptpd', 'desc');

            $this->db->select('tbl_sptpd.*, tbl_nop.nama_penjual, tbl_nop.alamat_penjual, tbl_nop.lokasi_op, tbl_nik.nama as nama_pembeli, tbl_nik.alamat as alamat_pembeli');
            $this->db->from('tbl_sptpd');
            $this->db->join('tbl_nop', 'tbl_sptpd.kd_propinsi = tbl_nop.kd_propinsi', 'left');
            $this->db->join('tbl_nik', 'tbl_nik.nik = tbl_sptpd.nik', 'left');
            $this->db->where('tbl_nop.kd_kabupaten = tbl_sptpd.kd_kabupaten');
            $this->db->where('tbl_nop.kd_kecamatan = tbl_sptpd.kd_kecamatan');
            $this->db->where('tbl_nop.kd_kelurahan = tbl_sptpd.kd_kelurahan');
            $this->db->where('tbl_nop.kd_blok = tbl_sptpd.kd_blok');
            $this->db->where('tbl_nop.no_urut = tbl_sptpd.no_urut');
            $this->db->where('tbl_nop.kd_jns_op = tbl_sptpd.kd_jns_op');
            $this->db->where('tbl_nop.thn_pajak_sppt = tbl_sptpd.thn_pajak_sppt');

            $query = $this->db->get();
            return $query->result();
        }
    }

    public function sum_jumlah_setor($date_start = '', $date_end = '', $pp = '', $ppat = '', $pwp = '', $stb = '', $skbkb = '', $skbkbt = '', $nodok = '')
    {
        if ($date_start != '') {
            $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        }
        if ($pp != '') {
            $this->db->where('id_pp', $pp);
        }
        if (@$user != '') {
            $this->db->where('id_user', $user);
        }
        if ($ppat != '' && $ppat != 'DISPENDA') {
            $this->db->where('id_ppat', $ppat);
        }
        if ($ppat == 'DISPENDA') {
            $this->db->where("id_ppat = ''");
        }
        if ($stb != '') {
            $this->db->where('jns_setoran', $stb);
        }
        if ($skbkb != '') {
            $this->db->where('jns_setoran', $skbkb);
        }
        if ($skbkbt != '') {
            $this->db->where('jns_setoran', $skbkbt);
        }
        if ($nodok != '') {
            $this->db->where('no_dokumen', $nodok);
        }
        $this->db->select("SUM(jumlah_setor) AS grand_total");
        $query = $this->db->get($this->tbl);
        return $query->row();
    }

    public function count_sptpd($date_start = '', $date_end = '', $pp = '', $ppat = '', $pwp = '', $stb = '', $skbkb = '', $skbkbt = '', $user = '', $nodok = '', $status = '')
    {
        // echo $nodok;exit();
        if ($date_start != '') {
            $this->db->where("tanggal BETWEEN '$date_start' AND '$date_end'");
        }
        if ($pp != '') {
            $this->db->where('id_pp', $pp);
        }
        if ($ppat != '' && $ppat != 'DISPENDA') {
            $this->db->where('id_ppat', $ppat);
        }
        if ($ppat == 'DISPENDA') {
            $this->db->where("id_ppat = ''");
        }
        if ($stb != '') {
            $this->db->where('jns_setoran', $stb);
        }
        if ($skbkb != '') {
            $this->db->where('jns_setoran', $skbkb);
        }
        if ($skbkbt != '') {
            $this->db->where('jns_setoran', $skbkbt);
        }
        if ($user != '') {
            $this->db->where('id_user', $user);
        }
        // echo $nodok;exit();
        if ($nodok != '') {
            $this->db->where('no_dokumen', $nodok);
        }

        if ($status != '') {

            if ($status == 'lunas') {
                $this->db->where('validasi_dispenda !=', 'null');
            } elseif ($status == 'belum') {
                $this->db->where('validasi_dispenda IS NULL');
            } elseif ($status == 'tidak_kena_pajak') {
                $this->db->where('npop < npoptkp');
            }

            $type_user = $this->session->userdata('s_tipe_bphtb');

            if ($type_user == 'PT') {
                $id_ppat = $this->session->userdata('s_id_ppat');
                $this->db->where('id_ppat', $id_ppat);
                $this->db->where('aprove_ppat', '1');
            }
            if ($type_user == 'WP') {
                $id_user = $this->session->userdata('s_id_user');
                $this->db->where('id_user', $id_user);
                // $this->db->where('aprove_ppat','1');
            }
        }



        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    public function add_sptpd($id_ppat, $nik, $wajibpajak, $nop = '', $nop_alamat, $nilai_pasar, $jenis_perolehan, $jenis_kepemilikan, $npop, $npoptkp, $dasar_jml_setoran, $nomor_jml_setoran, $tgl_jml_setoran, $hitung_sendiri_jml_setoran, $custom_jml_setoran, $jml_setor, $tanggal, $no_dokumen, $nop_pbb_baru, $kode_validasi, $id_user, $id_pp, $picture = '', $luas_tanah_op, $luas_bangunan_op, $luas_tanah_b_op, $luas_bangunan_b_op, $njop_tanah_op, $njop_bangunan_op, $njop_tanah_b_op, $njop_bangunan_b_op, $njop_pbb_sptpd, $text_no_sertifikat, $text_lokasi_op, $text_thn_pajak_sppt, $tanah_inp_aphb1, $tanah_inp_aphb2, $tanah_inp_aphb3, $bangunan_inp_aphb1, $bangunan_inp_aphb2, $bangunan_inp_aphb3, $tanah_b_inp_aphb1, $tanah_b_inp_aphb2, $tanah_b_inp_aphb3, $bangunan_b_inp_aphb1, $bangunan_b_inp_aphb2, $bangunan_b_inp_aphb3, $nama_nik, $alamat_nik, $text_propinsi, $text_kotakab, $text_kecamatan, $text_kelurahan, $rtrw_nik, $kodepos_nik, $no_pelayanan, $nama_petugas_lapangan = '', $kurang_bayar = '', $sspd_lama = '')
    {
        $kd_propinsi  = $nop[0];
        $kd_kabupaten = $nop[1];
        $kd_kecamatan = $nop[2];
        $kd_kelurahan = $nop[3];
        $kd_blok      = $nop[4];
        $no_urut      = $nop[5];
        $kd_jns_op    = $nop[6];
        $nama_wp = str_replace("'", "`", $nama_nik);
        $alamat_wp = str_replace("'", "`", $alamat_nik);
        $idbilling       = idbilling($no_dokumen);
        $id_wp = $this->session->userdata('s_id_wp');

        /*CEK
		if($njop_pbb_sptpd > $nilai_op )
			{$npop = $njop_pbb_sptpd;}
		else
			{$npop = $nilai_op;}
		
		$jml_setor = 0.05 * ($npop - $npoptkp);
		if($jml_setor < 0)
			{$jml_setor =0;}
		
		*/

        if ($tgl_jml_setoran == '') {
            $query = "INSERT INTO $this->tbl (id_ppat,
                                                nik,
                                                wajibpajak,
                                                kd_propinsi,
                                                kd_kabupaten,
                                                kd_kecamatan,
                                                kd_kelurahan,
                                                kd_blok,
                                                no_urut,
                                                nop_alamat,
                                                kd_jns_op,
                                                nilai_pasar,
                                                jenis_perolehan,
                                                npop,
                                                npoptkp,
                                                jns_setoran,
                                                jns_setoran_nomor,
                                                jns_setoran_tanggal,
                                                jns_setoran_hitung_sendiri,
                                                jns_setoran_custom,
                                                jumlah_setor,
                                                tanggal,
                                                no_dokumen,
                                                nop_pbb_baru,
                                                id_user,
                                                id_pp,
                                                kode_validasi,
                                                gambar_op,
                                                luas_tanah_op,
                                                luas_bangunan_op,
                                                luas_tanah_b_op,
                                                luas_bangunan_b_op,
                                                njop_tanah_op,
                                                njop_bangunan_op,
                                                njop_tanah_b_op,
                                                njop_bangunan_b_op,
                                                nilai_op,
                                                jenis_perolehan_op,
                                                jenis_kepemilikan,
                                                njop_pbb_op,
                                                no_sertifikat_op,
                                                lokasi_op,
                                                thn_pajak_sppt,
                                                tanah_inp_aphb1,
                                                tanah_inp_aphb2,
                                                tanah_inp_aphb3,
                                                bangunan_inp_aphb1,
                                                bangunan_inp_aphb2,
                                                bangunan_inp_aphb3,
                                                tanah_b_inp_aphb1,
                                                tanah_b_inp_aphb2,
                                                tanah_b_inp_aphb3,
                                                bangunan_b_inp_aphb1,
                                                bangunan_b_inp_aphb2,
                                                bangunan_b_inp_aphb3,
                                                kurang_bayar,
                                                sspd_lama,
                                                flag_dispenda,
                                                idbilling,
                                                nama_wp,
                                                alamat,
                                                propinsi,
                                                kabupaten,
                                                kecamatan,
                                                kelurahan,
                                                kodepos,
                                                rtrw,
                                                id_wp,
                                                no_pelayanan,
                                                nama_petugas_lapangan
                                                )
                      VALUES ('$id_ppat',
                                '$nik',
                                '$wajibpajak',
                                '$kd_propinsi',
                                '$kd_kabupaten',
                                '$kd_kecamatan',
                                '$kd_kelurahan',
                                '$kd_blok',
                                '$no_urut',
                                '$nop_alamat',
                                '$kd_jns_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$npop',
                                '$npoptkp',
                                '$dasar_jml_setoran',
                                '$nomor_jml_setoran',
                                NULL,
                                '$hitung_sendiri_jml_setoran',
                                '$custom_jml_setoran',
                                '$jml_setor',
                                '$tanggal',
                                '$no_dokumen',
                                '$nop_pbb_baru',
                                '$id_user',
                                '$id_pp',
                                '$kode_validasi',
                                '$picture',
                                '$luas_tanah_op',
                                '$luas_bangunan_op',
                                '$luas_tanah_b_op',
                                '$luas_bangunan_b_op',
                                '$njop_tanah_op',
                                '$njop_bangunan_op',
                                '$njop_tanah_b_op',
                                '$njop_bangunan_b_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$jenis_kepemilikan',
                                '$njop_pbb_sptpd',
                                '$text_no_sertifikat',
                                '$text_lokasi_op',
                                '$text_thn_pajak_sppt',
                                '$tanah_inp_aphb1',
                                '$tanah_inp_aphb2',
                                '$tanah_inp_aphb3',
                                '$bangunan_inp_aphb1',
                                '$bangunan_inp_aphb2',
                                '$bangunan_inp_aphb3',
                                '$tanah_b_inp_aphb1',
                                '$tanah_b_inp_aphb2',
                                '$tanah_b_inp_aphb3',
                                '$bangunan_b_inp_aphb1',
                                '$bangunan_b_inp_aphb2',
                                '$bangunan_b_inp_aphb3',
                                '$kurang_bayar',
                                '$sspd_lama',
                                '1',
                                '$idbilling',
                                '$nama_wp',
                                '$alamat_wp',
                                '$text_propinsi',
                                '$text_kotakab',
                               ' $text_kecamatan',
                                '$text_kelurahan',
                                '$kodepos_nik',
                                '$rtrw_nik',
                                '$id_wp',
                                '$no_pelayanan',
                                '$nama_petugas_lapangan'
                              )";
        } else {
            $query = "INSERT INTO $this->tbl (id_ppat,
                                                nik,
                                                wajibpajak,
                                                kd_propinsi,
                                                kd_kabupaten,
                                                kd_kecamatan,
                                                kd_kelurahan,
                                                kd_blok,
                                                no_urut,
                                                nop_alamat,
                                                kd_jns_op,
                                                nilai_pasar,
                                                jenis_perolehan,
                                                npop,
                                                npoptkp,
                                                jns_setoran,
                                                jns_setoran_nomor,
                                                jns_setoran_tanggal,
                                                jns_setoran_hitung_sendiri,
                                                jns_setoran_custom,
                                                jumlah_setor,
                                                tanggal,
                                                no_dokumen,
                                                nop_pbb_baru,
                                                id_user,
                                                id_pp,
                                                kode_validasi,
                                                gambar_op,
                                                luas_tanah_op,
                                                luas_bangunan_op,
                                                luas_tanah_b_op,
                                                luas_bangunan_b_op,
                                                njop_tanah_op,
                                                njop_bangunan_op,
                                                njop_tanah_b_op,
                                                njop_bangunan_b_op,
                                                nilai_op,
                                                jenis_perolehan_op,
                                                njop_pbb_op,
                                                no_sertifikat_op,
                                                lokasi_op,
                                                thn_pajak_sppt,
                                                tanah_inp_aphb1,
                                                tanah_inp_aphb2,
                                                tanah_inp_aphb3,
                                                bangunan_inp_aphb1,
                                                bangunan_inp_aphb2,
                                                bangunan_inp_aphb3,
                                                tanah_b_inp_aphb1,
                                                tanah_b_inp_aphb2,
                                                tanah_b_inp_aphb3,
                                                bangunan_b_inp_aphb1,
                                                bangunan_b_inp_aphb2,
                                                bangunan_b_inp_aphb3,
                                                kurang_bayar,
                                                sspd_lama,
                                                flag_dispenda,
                                                idbilling,
                                                nama_wp,
                                                alamat,
                                                propinsi,
                                                kabupaten,
                                                kecamatan,
                                                kelurahan,
                                                kodepos,
                                                rtrw,
                                                id_wp,
                                                no_pelayanan,
                                                nama_petugas_lapangan)
                      VALUES ('$id_ppat',
                                '$nik',
                                '$wajibpajak',
                                '$kd_propinsi',
                                '$kd_kabupaten',
                                '$kd_kecamatan',
                                '$kd_kelurahan',
                                '$kd_blok',
                                '$no_urut',
                                '$nop_alamat',
                                '$kd_jns_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$npop',
                                '$npoptkp',
                                '$dasar_jml_setoran',
                                '$nomor_jml_setoran',
                                '$tgl_jml_setoran',
                                '$hitung_sendiri_jml_setoran',
                                '$custom_jml_setoran',
                                '$jml_setor',
                                '$tanggal',
                                '$no_dokumen',
                                '$nop_pbb_baru',
                                '$id_user',
                                '$id_pp',
                                '$kode_validasi',
                                '$picture',
                                '$luas_tanah_op',
                                '$luas_bangunan_op',
                                '$luas_tanah_b_op',
                                '$luas_bangunan_b_op',
                                '$njop_tanah_op',
                                '$njop_bangunan_op',
                                '$njop_tanah_b_op',
                                '$njop_bangunan_b_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$njop_pbb_sptpd',
                                '$text_no_sertifikat',
                                '$text_lokasi_op',
                                '$text_thn_pajak_sppt',
                                '$tanah_inp_aphb1',
                                '$tanah_inp_aphb2',
                                '$tanah_inp_aphb3',
                                '$bangunan_inp_aphb1',
                                '$bangunan_inp_aphb2',
                                '$bangunan_inp_aphb3',
                                '$tanah_b_inp_aphb1',
                                '$tanah_b_inp_aphb2',
                                '$tanah_b_inp_aphb3',
                                '$bangunan_b_inp_aphb1',
                                '$bangunan_b_inp_aphb2',
                                '$bangunan_b_inp_aphb3',
                                '$kurang_bayar',
                                '$sspd_lama',
                                '1',
                                '$idbilling',
                                '$nama_wp',
                                '$alamat_wp',
                                '$text_propinsi',
                                '$text_kotakab',
                                '$text_kecamatan',
                                '$text_kelurahan',
                                '$kodepos_nik',
                                '$rtrw_nik',s
                                '$id_wp',
                                '$no_pelayanan',
                                '$nama_petugas_lapangan'
                            )";
        }
        // echo $this->db->last_query();exit();

        if ($this->db->query($query)) {
            // echo $this->db->last_query();exit();
            $this->antclass->go_log($this->db->last_query());
            return true;
        }

        return false;
    }

    public function add_sptpd_dispenda($id_ppat, $nik, $wajibpajak, $nop = '', $nop_alamat, $nilai_pasar, $jenis_perolehan, $npop, $npoptkp, $dasar_jml_setoran, $nomor_jml_setoran, $tgl_jml_setoran, $hitung_sendiri_jml_setoran, $custom_jml_setoran, $jml_setor, $tanggal, $no_dokumen, $nop_pbb_baru, $kode_validasi, $id_user, $id_pp, $picture = '', $luas_tanah_op, $luas_bangunan_op, $luas_tanah_b_op, $luas_bangunan_b_op, $njop_tanah_op, $njop_bangunan_op, $njop_tanah_b_op, $njop_bangunan_b_op, $njop_pbb_sptpd, $text_no_sertifikat, $text_lokasi_op, $text_thn_pajak_sppt, $tanah_inp_aphb1, $tanah_inp_aphb2, $tanah_inp_aphb3, $bangunan_inp_aphb1, $bangunan_inp_aphb2, $bangunan_inp_aphb3, $tanah_b_inp_aphb1, $tanah_b_inp_aphb2, $tanah_b_inp_aphb3, $bangunan_b_inp_aphb1, $bangunan_b_inp_aphb2, $bangunan_b_inp_aphb3, $nama_nik, $alamat_nik, $text_propinsi, $text_kotakab, $text_kecamatan, $text_kelurahan, $rtrw_nik, $kodepos_nik, $no_pelayanan, $nama_petugas_lapangan = '', $kurang_bayar = '', $sspd_lama = '')
    {
        $kd_propinsi  = $nop[0];
        $kd_kabupaten = $nop[1];
        $kd_kecamatan = $nop[2];
        $kd_kelurahan = $nop[3];
        $kd_blok      = $nop[4];
        $no_urut      = $nop[5];
        $kd_jns_op    = $nop[6];
        $nama_wp = addslashes($nama_nik);
        $idbilling    = idbilling($no_dokumen);

        $sql = $this->db->query("SELECT a.*, b.id_wp FROM tbl_nik a left join tbl_wp b on b.nik = a.nik WHERE a.nik = '$nik'")->row();

        $id_wp = $sql->id_wp;
        if ($tgl_jml_setoran == '') {
            $query = "INSERT INTO $this->tbl (id_ppat,
                                                nik,
                                                wajibpajak,
                                                kd_propinsi,
                                                kd_kabupaten,
                                                kd_kecamatan,
                                                kd_kelurahan,
                                                kd_blok,
                                                no_urut,
                                                nop_alamat,
                                                kd_jns_op,
                                                nilai_pasar,
                                                jenis_perolehan,
                                                npop,
                                                npoptkp,
                                                jns_setoran,
                                                jns_setoran_nomor,
                                                jns_setoran_tanggal,
                                                jns_setoran_hitung_sendiri,
                                                jns_setoran_custom,
                                                jumlah_setor,
                                                tanggal,
                                                no_dokumen,
                                                nop_pbb_baru,
                                                id_user,
                                                id_pp,
                                                kode_validasi,
                                                gambar_op,
                                                luas_tanah_op,
                                                luas_bangunan_op,
                                                luas_tanah_b_op,
                                                luas_bangunan_b_op,
                                                njop_tanah_op,
                                                njop_bangunan_op,
                                                njop_tanah_b_op,
                                                njop_bangunan_b_op,
                                                nilai_op,
                                                jenis_perolehan_op,
                                                njop_pbb_op,
                                                no_sertifikat_op,
                                                lokasi_op,
                                                thn_pajak_sppt,
                                                tanah_inp_aphb1,
                                                tanah_inp_aphb2,
                                                tanah_inp_aphb3,
                                                bangunan_inp_aphb1,
                                                bangunan_inp_aphb2,
                                                bangunan_inp_aphb3,
                                                tanah_b_inp_aphb1,
                                                tanah_b_inp_aphb2,
                                                tanah_b_inp_aphb3,
                                                bangunan_b_inp_aphb1,
                                                bangunan_b_inp_aphb2,
                                                bangunan_b_inp_aphb3,
                                                kurang_bayar,
                                                sspd_lama,
                                                flag_dispenda,
                                                idbilling,
                                                nama_wp,
                                                alamat,
                                                propinsi,
                                                kabupaten,
                                                kecamatan,
                                                kelurahan,
                                                kodepos,
                                                rtrw,
                                                id_wp,
                                                no_pelayanan,
                                                nama_petugas_lapangan
                                                )
                      VALUES ('$id_ppat',
                                '$nik',
                                '$wajibpajak',
                                '$kd_propinsi',
                                '$kd_kabupaten',
                                '$kd_kecamatan',
                                '$kd_kelurahan',
                                '$kd_blok',
                                '$no_urut',
                                '$nop_alamat',
                                '$kd_jns_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$npop',
                                '$npoptkp',
                                '$dasar_jml_setoran',
                                '$nomor_jml_setoran',
                                NULL,
                                '$hitung_sendiri_jml_setoran',
                                '$custom_jml_setoran',
                                '$jml_setor',
                                '$tanggal',
                                '$no_dokumen',
                                '$nop_pbb_baru',
                                '$id_user',
                                '$id_pp',
                                '$kode_validasi',
                                '$picture',
                                '$luas_tanah_op',
                                '$luas_bangunan_op',
                                '$luas_tanah_b_op',
                                '$luas_bangunan_b_op',
                                '$njop_tanah_op',
                                '$njop_bangunan_op',
                                '$njop_tanah_b_op',
                                '$njop_bangunan_b_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$njop_pbb_sptpd',
                                '$text_no_sertifikat',
                                '$text_lokasi_op',
                                '$text_thn_pajak_sppt',
                                '$tanah_inp_aphb1',
                                '$tanah_inp_aphb2',
                                '$tanah_inp_aphb3',
                                '$bangunan_inp_aphb1',
                                '$bangunan_inp_aphb2',
                                '$bangunan_inp_aphb3',
                                '$tanah_b_inp_aphb1',
                                '$tanah_b_inp_aphb2',
                                '$tanah_b_inp_aphb3',
                                '$bangunan_b_inp_aphb1',
                                '$bangunan_b_inp_aphb2',
                                '$bangunan_b_inp_aphb3',
                                '$kurang_bayar',
                                '$sspd_lama',
                                '1',
                                '$idbilling',
                                '$nama_wp',
                                '$alamat_nik',
                                '$text_propinsi',
                                '$text_kotakab',
                               ' $text_kecamatan',
                                '$text_kelurahan',
                                '$kodepos_nik',
                                '$rtrw_nik',
                                '$id_wp',
                                '$no_pelayanan',
                                '$nama_petugas_lapangan'
                              )";
        } else {
            $query = "INSERT INTO $this->tbl (id_ppat,
                                                nik,
                                                wajibpajak,
                                                kd_propinsi,
                                                kd_kabupaten,
                                                kd_kecamatan,
                                                kd_kelurahan,
                                                kd_blok,
                                                no_urut,
                                                nop_alamat,
                                                kd_jns_op,
                                                nilai_pasar,
                                                jenis_perolehan,
                                                npop,
                                                npoptkp,
                                                jns_setoran,
                                                jns_setoran_nomor,
                                                jns_setoran_tanggal,
                                                jns_setoran_hitung_sendiri,
                                                jns_setoran_custom,
                                                jumlah_setor,
                                                tanggal,
                                                no_dokumen,
                                                nop_pbb_baru,
                                                id_user,
                                                id_pp,
                                                kode_validasi,
                                                gambar_op,
                                                luas_tanah_op,
                                                luas_bangunan_op,
                                                luas_tanah_b_op,
                                                luas_bangunan_b_op,
                                                njop_tanah_op,
                                                njop_bangunan_op,
                                                njop_tanah_b_op,
                                                njop_bangunan_b_op,
                                                nilai_op,
                                                jenis_perolehan_op,
                                                njop_pbb_op,
                                                no_sertifikat_op,
                                                lokasi_op,
                                                thn_pajak_sppt,
                                                tanah_inp_aphb1,
                                                tanah_inp_aphb2,
                                                tanah_inp_aphb3,
                                                bangunan_inp_aphb1,
                                                bangunan_inp_aphb2,
                                                bangunan_inp_aphb3,
                                                tanah_b_inp_aphb1,
                                                tanah_b_inp_aphb2,
                                                tanah_b_inp_aphb3,
                                                bangunan_b_inp_aphb1,
                                                bangunan_b_inp_aphb2,
                                                bangunan_b_inp_aphb3,
                                                kurang_bayar,
                                                sspd_lama,
                                                flag_dispenda,
                                                idbilling,
                                                nama_wp,
                                                alamat,
                                                propinsi,
                                                kabupaten,
                                                kecamatan,
                                                kelurahan,
                                                kodepos,
                                                rtrw,
                                                id_wp,
                                                no_pelayanan,
                                                nama_petugas_lapangan)
                      VALUES ('$id_ppat',
                                '$nik',
                                'wajibpajak',
                                '$kd_propinsi',
                                '$kd_kabupaten',
                                '$kd_kecamatan',
                                '$kd_kelurahan',
                                '$kd_blok',
                                '$no_urut',
                                '$nop_alamat',
                                '$kd_jns_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$npop',
                                '$npoptkp',
                                '$dasar_jml_setoran',
                                '$nomor_jml_setoran',
                                '$tgl_jml_setoran',
                                '$hitung_sendiri_jml_setoran',
                                '$custom_jml_setoran',
                                '$jml_setor',
                                '$tanggal',
                                '$no_dokumen',
                                '$nop_pbb_baru',
                                '$id_user',
                                '$id_pp',
                                '$kode_validasi',
                                '$picture',
                                '$luas_tanah_op',
                                '$luas_bangunan_op',
                                '$luas_tanah_b_op',
                                '$luas_bangunan_b_op',
                                '$njop_tanah_op',
                                '$njop_bangunan_op',
                                '$njop_tanah_b_op',
                                '$njop_bangunan_b_op',
                                '$nilai_pasar',
                                '$jenis_perolehan',
                                '$njop_pbb_sptpd',
                                '$text_no_sertifikat',
                                '$text_lokasi_op',
                                '$text_thn_pajak_sppt',
                                '$tanah_inp_aphb1',
                                '$tanah_inp_aphb2',
                                '$tanah_inp_aphb3',
                                '$bangunan_inp_aphb1',
                                '$bangunan_inp_aphb2',
                                '$bangunan_inp_aphb3',
                                '$tanah_b_inp_aphb1',
                                '$tanah_b_inp_aphb2',
                                '$tanah_b_inp_aphb3',
                                '$bangunan_b_inp_aphb1',
                                '$bangunan_b_inp_aphb2',
                                '$bangunan_b_inp_aphb3',
                                '$kurang_bayar',
                                '$sspd_lama',
                                '1',
                                '$idbilling',
                                '$nama_wp',
                                '$alamat_nik',
                                '$text_propinsi',
                                '$text_kotakab',
                                '$text_kecamatan',
                                '$text_kelurahan',
                                '$kodepos_nik',
                                '$rtrw_nik',s
                                '$id_wp',
                                '$no_pelayanan',
                                '$nama_petugas_lapangan'
                            )";
        }
        // echo $this->db->last_query();exit();

        if ($this->db->query($query)) {
            // echo $this->db->last_query();exit();
            $this->antclass->go_log($this->db->last_query());
            return true;
        }

        return false;
    }

    public function edit_sptpd($id_ppat = '', $nik, $wajibpajak, $nop = '', $nop_alamat = '', $nilai_pasar = '', $jenis_perolehan = '', $npop = '', $npoptkp = '', $dasar_jml_setoran = '', $nomor_jml_setoran = '', $tgl_jml_setoran = '', $hitung_sendiri_jml_setoran = '', $custom_jml_setoran = '', $jml_setor = '', $tanggal = '', $no_dokumen = '', $nop_pbb_baru = '', $id_user = '', $id_pp = '', $picture = '', $luas_tanah_op = '', $luas_bangunan_op = '', $luas_tanah_b_op = '', $luas_bangunan_b_op = '', $njop_tanah_op = '', $njop_bangunan_op = '', $njop_tanah_b_op = '', $njop_bangunan_b_op = '', $njop_pbb_sptpd = '', $text_no_sertifikat = '', $text_lokasi_op = '', $text_thn_pajak_sppt = '', $tanah_inp_aphb1 = '', $tanah_inp_aphb2 = '', $tanah_inp_aphb3 = '', $bangunan_inp_aphb1 = '', $bangunan_inp_aphb2 = '', $bangunan_inp_aphb3 = '', $tanah_b_inp_aphb1 = '', $tanah_b_inp_aphb2 = '', $tanah_b_inp_aphb3 = '', $bangunan_b_inp_aphb1 = '', $bangunan_b_inp_aphb2 = '', $bangunan_b_inp_aphb3 = '', $nama_nik = '', $alamat_nik = '', $text_propinsi = '', $text_kotakab = '', $text_kecamatan = '', $text_kelurahan = '', $rtrw_nik = '', $kodepos_nik = '')
    {
        $kd_propinsi  = $nop[0];
        $kd_kabupaten = $nop[1];
        $kd_kecamatan = $nop[2];
        $kd_kelurahan = $nop[3];
        $kd_blok      = $nop[4];
        $no_urut      = $nop[5];
        $kd_jns_op    = $nop[6];
        $nama_wp = addcslashes($nama_nik);

        /*CEK
		if($njop_pbb_sptpd > $nilai_op )
			{$npop = $njop_pbb_sptpd;}
		else
			{$npop = $nilai_op;}
		
		*/

        $jml_setor = 0.05 * ($npop - $npoptkp);
        if ($jml_setor < 0) {
            $jml_setor = 0;
        }

        if ($picture != '') {

            $query = "UPDATE $this->tbl set 
                        nik = '$nik',
                        wajibpajak = '$wajibpajak',
                        kd_propinsi = '$kd_propinsi',
                        kd_kabupaten = '$kd_kabupaten' ,
                        kd_kecamatan = '$kd_kecamatan',
                        kd_kelurahan = '$kd_kelurahan',
                        kd_blok = '$kd_blok',
                        no_urut = '$no_urut',
                        nop_alamat = '$nop_alamat',
                        kd_jns_op = '$kd_jns_op',
                        nilai_pasar = '$nilai_pasar',
                        jenis_perolehan = '$jenis_perolehan',
                        npop = '$npop' ,
                        npoptkp = '$npoptkp',
                        jns_setoran = '$dasar_jml_setoran',
                        jns_setoran_nomor = '$nomor_jml_setoran',
                        jns_setoran_tanggal = NULL,
                        jns_setoran_hitung_sendiri = '$hitung_sendiri_jml_setoran',
                        jns_setoran_custom = '$custom_jml_setoran',
                        jumlah_setor = '$jml_setor', 
                        tanggal = '$tanggal',
                        nop_pbb_baru = '$nop_pbb_baru',
                        id_user = '$id_user',
                        id_pp = '$id_pp',
                        gambar_op = '$picture',
                        luas_tanah_op = '$luas_tanah_op',
                        luas_bangunan_op = '$luas_bangunan_op',
                        luas_tanah_b_op = '$luas_tanah_b_op',
                        luas_bangunan_b_op = '$luas_bangunan_b_op',
                        njop_tanah_op = '$njop_tanah_op',
                        njop_bangunan_op = '$njop_bangunan_op',
                        njop_tanah_b_op = '$njop_tanah_b_op',
                        njop_bangunan_b_op = '$njop_bangunan_b_op',
                        nilai_op = '$nilai_pasar',
                        jenis_perolehan_op = '$jenis_perolehan',
                        njop_pbb_op = '$njop_pbb_sptpd',
                        no_sertifikat_op = '$text_no_sertifikat',
                        lokasi_op = '$text_lokasi_op',
                        thn_pajak_sppt = '$text_thn_pajak_sppt',
                        tanah_inp_aphb1 = '$tanah_inp_aphb1',
                        tanah_inp_aphb2 = '$tanah_inp_aphb2',
                        tanah_inp_aphb3 = '$tanah_inp_aphb3',
                        bangunan_inp_aphb1 = '$bangunan_inp_aphb1',
                        bangunan_inp_aphb2 = '$bangunan_inp_aphb2',
                        bangunan_inp_aphb3 = '$bangunan_inp_aphb3',
                        tanah_b_inp_aphb1 = '$tanah_b_inp_aphb1',
                        tanah_b_inp_aphb2 = '$tanah_b_inp_aphb2',
                        tanah_b_inp_aphb3 = '$tanah_b_inp_aphb3',
                        bangunan_b_inp_aphb1 = '$bangunan_b_inp_aphb1',
                        bangunan_b_inp_aphb2 = '$bangunan_b_inp_aphb2',
                        bangunan_b_inp_aphb3 = '$bangunan_b_inp_aphb3',
                        flag_dispenda = '1',
                        flag_ppat = '0',
                        is_lunas = NULL,
                        nama_wp= '$nama_wp',
                        alamat= '$alamat_nik',
                        propinsi= '$text_propinsi',
                        kabupaten= '$text_kotakab',
                        kecamatan= '$text_kecamatan',
                        kelurahan= '$text_kelurahan',
                        kodepos= '$kodepos_nik',
                        rtrw= '$rtrw_nik'
                        where 
                        no_dokumen = '$no_dokumen'";
        } else {

            $query = "UPDATE $this->tbl set 
                    nik = '$nik',
                    wajibpajak = '$wajibpajak',
                    kd_propinsi = '$kd_propinsi',
                    kd_kabupaten = '$kd_kabupaten' ,
                    kd_kecamatan = '$kd_kecamatan',
                    kd_kelurahan = '$kd_kelurahan',
                    kd_blok = '$kd_blok',
                    no_urut = '$no_urut',
                    nop_alamat = '$nop_alamat',
                    kd_jns_op = '$kd_jns_op',
                    nilai_pasar = '$nilai_pasar',
                    jenis_perolehan = '$jenis_perolehan',
                    npop = '$npop' ,
                    npoptkp = '$npoptkp',
                    jns_setoran = '$dasar_jml_setoran',
                    jns_setoran_nomor = '$nomor_jml_setoran',
                    jns_setoran_tanggal = NULL,
                    jns_setoran_hitung_sendiri = '$hitung_sendiri_jml_setoran',
                    jns_setoran_custom = '$custom_jml_setoran',
                    jumlah_setor = '$jml_setor', 
                    tanggal = '$tanggal',
                    nop_pbb_baru = '$nop_pbb_baru',
                    id_user = '$id_user',
                    id_pp = '$id_pp',
                    luas_tanah_op = '$luas_tanah_op',
                    luas_bangunan_op = '$luas_bangunan_op',
                    luas_tanah_b_op = '$luas_tanah_b_op',
                    luas_bangunan_b_op = '$luas_bangunan_b_op',
                    njop_tanah_op = '$njop_tanah_op',
                    njop_bangunan_op = '$njop_bangunan_op',
                    njop_tanah_b_op = '$njop_tanah_b_op',
                    njop_bangunan_b_op = '$njop_bangunan_b_op',
                    nilai_op = '$nilai_pasar',
                    jenis_perolehan_op = '$jenis_perolehan',
                    njop_pbb_op = '$njop_pbb_sptpd',
                    no_sertifikat_op = '$text_no_sertifikat',
                    lokasi_op = '$text_lokasi_op',
                    thn_pajak_sppt = '$text_thn_pajak_sppt',
                    tanah_inp_aphb1 = '$tanah_inp_aphb1',
                    tanah_inp_aphb2 = '$tanah_inp_aphb2',
                    tanah_inp_aphb3 = '$tanah_inp_aphb3',
                    bangunan_inp_aphb1 = '$bangunan_inp_aphb1',
                    bangunan_inp_aphb2 = '$bangunan_inp_aphb2',
                    bangunan_inp_aphb3 = '$bangunan_inp_aphb3',
                    tanah_b_inp_aphb1 = '$tanah_b_inp_aphb1',
                    tanah_b_inp_aphb2 = '$tanah_b_inp_aphb2',
                    tanah_b_inp_aphb3 = '$tanah_b_inp_aphb3',
                    bangunan_b_inp_aphb1 = '$bangunan_b_inp_aphb1',
                    bangunan_b_inp_aphb2 = '$bangunan_b_inp_aphb2',
                    bangunan_b_inp_aphb3 = '$bangunan_b_inp_aphb3',
                    flag_dispenda = '1',
                    flag_ppat = '0',
                    is_lunas = NULL,
                    nama_wp= '$nama_wp',
                    alamat= '$alamat_nik',
                    propinsi= '$text_propinsi',
                    kabupaten= '$text_kotakab',
                    kecamatan= '$text_kecamatan',
                    kelurahan= '$text_kelurahan',
                    kodepos= '$kodepos_nik',
                    rtrw= '$rtrw_nik'
                    where 
                    no_dokumen = '$no_dokumen'
                 ";
        }

        if ($this->db->query($query)) {
            // echo $this->db->last_query(); exit;
            $this->antclass->go_log($this->db->last_query());
            return true;
        }

        return false;
    }

    public function edit_sptpd_wp($id_ppat = '', $nik, $wajibpajak, $nop = '', $nop_alamat = '', $nilai_pasar = '', $jenis_perolehan = '', $npop = '', $npoptkp = '', $dasar_jml_setoran = '', $nomor_jml_setoran = '', $tgl_jml_setoran = '', $hitung_sendiri_jml_setoran = '', $custom_jml_setoran = '', $jml_setor = '', $tanggal = '', $no_dokumen = '', $nop_pbb_baru = '', $id_user = '', $id_pp = '', $picture = '', $luas_tanah_op = '', $luas_bangunan_op = '', $luas_tanah_b_op = '', $luas_bangunan_b_op = '', $njop_tanah_op = '', $njop_bangunan_op = '', $njop_tanah_b_op = '', $njop_bangunan_b_op = '', $njop_pbb_sptpd = '', $text_no_sertifikat = '', $text_lokasi_op = '', $text_thn_pajak_sppt = '', $tanah_inp_aphb1 = '', $tanah_inp_aphb2 = '', $tanah_inp_aphb3 = '', $bangunan_inp_aphb1 = '', $bangunan_inp_aphb2 = '', $bangunan_inp_aphb3 = '', $tanah_b_inp_aphb1 = '', $tanah_b_inp_aphb2 = '', $tanah_b_inp_aphb3 = '', $bangunan_b_inp_aphb1 = '', $bangunan_b_inp_aphb2 = '', $bangunan_b_inp_aphb3 = '', $nama_nik = '', $alamat_nik = '', $text_propinsi = '', $text_kotakab = '', $text_kecamatan = '', $text_kelurahan = '', $rtrw_nik = '', $kodepos_nik = '')
    {
        $kd_propinsi  = $nop[0];
        $kd_kabupaten = $nop[1];
        $kd_kecamatan = $nop[2];
        $kd_kelurahan = $nop[3];
        $kd_blok      = $nop[4];
        $no_urut      = $nop[5];
        $kd_jns_op    = $nop[6];
        $nama_wp = addslashes($nama_nik);

        /*CEK
		if($njop_pbb_sptpd > $nilai_op )
			{$npop = $njop_pbb_sptpd;}
		else
			{$npop = $nilai_op;}
		
		*/

        $jml_setor = 0.05 * ($npop - $npoptkp);
        if ($jml_setor < 0) {
            $jml_setor = 0;
        }

        if ($picture != '') {

            $query = "UPDATE $this->tbl set 
                        nik = '$nik',
                        wajibpajak = '$wajibpajak',
                        kd_propinsi = '$kd_propinsi',
                        kd_kabupaten = '$kd_kabupaten' ,
                        kd_kecamatan = '$kd_kecamatan',
                        kd_kelurahan = '$kd_kelurahan',
                        kd_blok = '$kd_blok',
                        no_urut = '$no_urut',
                        nop_alamat = '$nop_alamat',
                        kd_jns_op = '$kd_jns_op',
                        nilai_pasar = '$nilai_pasar',
                        jenis_perolehan = '$jenis_perolehan',
                        npop = '$npop' ,
                        npoptkp = '$npoptkp',
                        jns_setoran = '$dasar_jml_setoran',
                        jns_setoran_nomor = '$nomor_jml_setoran',
                        jns_setoran_tanggal = NULL,
                        jns_setoran_hitung_sendiri = '$hitung_sendiri_jml_setoran',
                        jns_setoran_custom = '$custom_jml_setoran',
                        jumlah_setor = '$jml_setor', 
                        tanggal = '$tanggal',
                        nop_pbb_baru = '$nop_pbb_baru',
                        id_user = '$id_user',
                        id_pp = '$id_pp',
                        gambar_op = '$picture',
                        luas_tanah_op = '$luas_tanah_op',
                        luas_bangunan_op = '$luas_bangunan_op',
                        luas_tanah_b_op = '$luas_tanah_b_op',
                        luas_bangunan_b_op = '$luas_bangunan_b_op',
                        njop_tanah_op = '$njop_tanah_op',
                        njop_bangunan_op = '$njop_bangunan_op',
                        njop_tanah_b_op = '$njop_tanah_b_op',
                        njop_bangunan_b_op = '$njop_bangunan_b_op',
                        nilai_op = '$nilai_pasar',
                        jenis_perolehan_op = '$jenis_perolehan',
                        njop_pbb_op = '$njop_pbb_sptpd',
                        no_sertifikat_op = '$text_no_sertifikat',
                        lokasi_op = '$text_lokasi_op',
                        thn_pajak_sppt = '$text_thn_pajak_sppt',
                        tanah_inp_aphb1 = '$tanah_inp_aphb1',
                        tanah_inp_aphb2 = '$tanah_inp_aphb2',
                        tanah_inp_aphb3 = '$tanah_inp_aphb3',
                        bangunan_inp_aphb1 = '$bangunan_inp_aphb1',
                        bangunan_inp_aphb2 = '$bangunan_inp_aphb2',
                        bangunan_inp_aphb3 = '$bangunan_inp_aphb3',
                        tanah_b_inp_aphb1 = '$tanah_b_inp_aphb1',
                        tanah_b_inp_aphb2 = '$tanah_b_inp_aphb2',
                        tanah_b_inp_aphb3 = '$tanah_b_inp_aphb3',
                        bangunan_b_inp_aphb1 = '$bangunan_b_inp_aphb1',
                        bangunan_b_inp_aphb2 = '$bangunan_b_inp_aphb2',
                        bangunan_b_inp_aphb3 = '$bangunan_b_inp_aphb3',
                        flag_dispenda = '1',
                        flag_ppat = '0',
                        is_lunas = null,
                        nama_wp= '$nama_wp',
                        alamat= '$alamat_nik',
                        propinsi= '$text_propinsi',
                        kabupaten= '$text_kotakab',
                        kecamatan= '$text_kecamatan',
                        kelurahan= '$text_kelurahan',
                        kodepos= '$kodepos_nik',
                        rtrw= '$rtrw_nik',
                        aprove_ppat= '0'
                        where 
                        no_dokumen = '$no_dokumen'";
        } else {
            $query = "UPDATE $this->tbl set 
                    nik = '$nik',
                    wajibpajak = '$wajibpajak',
                    kd_propinsi = '$kd_propinsi',
                    kd_kabupaten = '$kd_kabupaten' ,
                    kd_kecamatan = '$kd_kecamatan',
                    kd_kelurahan = '$kd_kelurahan',
                    kd_blok = '$kd_blok',
                    no_urut = '$no_urut',
                    nop_alamat = '$nop_alamat',
                    kd_jns_op = '$kd_jns_op',
                    nilai_pasar = '$nilai_pasar',
                    jenis_perolehan = '$jenis_perolehan',
                    npop = '$npop' ,
                    npoptkp = '$npoptkp',
                    jns_setoran = '$dasar_jml_setoran',
                    jns_setoran_nomor = '$nomor_jml_setoran',
                    jns_setoran_tanggal = NULL,
                    jns_setoran_hitung_sendiri = '$hitung_sendiri_jml_setoran',
                    jns_setoran_custom = '$custom_jml_setoran',
                    jumlah_setor = '$jml_setor', 
                    tanggal = '$tanggal',
                    nop_pbb_baru = '$nop_pbb_baru',
                    id_user = '$id_user',
                    id_pp = '$id_pp',
                    luas_tanah_op = '$luas_tanah_op',
                    luas_bangunan_op = '$luas_bangunan_op',
                    luas_tanah_b_op = '$luas_tanah_b_op',
                    luas_bangunan_b_op = '$luas_bangunan_b_op',
                    njop_tanah_op = '$njop_tanah_op',
                    njop_bangunan_op = '$njop_bangunan_op',
                    njop_tanah_b_op = '$njop_tanah_b_op',
                    njop_bangunan_b_op = '$njop_bangunan_b_op',
                    nilai_op = '$nilai_pasar',
                    jenis_perolehan_op = '$jenis_perolehan',
                    njop_pbb_op = '$njop_pbb_sptpd',
                    no_sertifikat_op = '$text_no_sertifikat',
                    lokasi_op = '$text_lokasi_op',
                    thn_pajak_sppt = '$text_thn_pajak_sppt',
                    tanah_inp_aphb1 = '$tanah_inp_aphb1',
                    tanah_inp_aphb2 = '$tanah_inp_aphb2',
                    tanah_inp_aphb3 = '$tanah_inp_aphb3',
                    bangunan_inp_aphb1 = '$bangunan_inp_aphb1',
                    bangunan_inp_aphb2 = '$bangunan_inp_aphb2',
                    bangunan_inp_aphb3 = '$bangunan_inp_aphb3',
                    tanah_b_inp_aphb1 = '$tanah_b_inp_aphb1',
                    tanah_b_inp_aphb2 = '$tanah_b_inp_aphb2',
                    tanah_b_inp_aphb3 = '$tanah_b_inp_aphb3',
                    bangunan_b_inp_aphb1 = '$bangunan_b_inp_aphb1',
                    bangunan_b_inp_aphb2 = '$bangunan_b_inp_aphb2',
                    bangunan_b_inp_aphb3 = '$bangunan_b_inp_aphb3',
                    flag_dispenda = '1',
                    flag_ppat = '0',
                    is_lunas = null,
                    nama_wp= '$nama_wp',
                    alamat= '$alamat_nik',
                    propinsi= '$text_propinsi',
                    kabupaten= '$text_kotakab',
                    kecamatan= '$text_kecamatan',
                    kelurahan= '$text_kelurahan',
                    kodepos= '$kodepos_nik',
                    rtrw= '$rtrw_nik',
                    aprove_ppat= '0'
                    where 
                    no_dokumen = '$no_dokumen'
                 ";
        }

        if ($this->db->query($query)) {
            // echo $this->db->last_query(); exit;
            $this->antclass->go_log($this->db->last_query());
            return true;
        }

        return false;
    }

    public function delete_sptpd($id)
    {
        $this->db->where('id_sptpd', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return true;
        }

        return false;
    }

    public function set_lunas($no_dokumen, $lunas = '')
    {
        $ed_data = array('is_lunas' => '1');
        if ($lunas != '') {
            $ed_data = array('is_lunas' => $lunas);
        }

        //$this->db->where('is_lunas', '0');
        $this->db->where('no_dokumen', $no_dokumen);
        if ($this->db->update($this->tbl, $ed_data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_sptpd_no_dokumen($no)
    {
        $this->db->where('no_dokumen', $no);
        $query = $this->db->get($this->tbl);
        // echo $this->db->last_query(); exit;
        return $query->row();
    }

    public function get_lampiran($no_dokumen)
    {
        $this->db->select('
            tbl_sptpd.no_dokumen,
            tbl_formulir_penelitian.no_sspd,
            tbl_formulir_penelitian.id_formulir,
            tbl_formulir_penelitian.tanggal_no_sspd,
            tbl_formulir_penelitian.no_formulir,
            tbl_formulir_penelitian.tanggal_no_formulir,
            tbl_formulir_penelitian.lampiran_sspd,
            tbl_formulir_penelitian.lampiran_sppt,
            tbl_formulir_penelitian.lampiran_fotocopi_identitas,
            tbl_formulir_penelitian.lampiran_surat_kuasa_wp,
            tbl_formulir_penelitian.lampiran_nama_kuasa_wp,
            tbl_formulir_penelitian.lampiran_alamat_kuasa_wp,
            tbl_formulir_penelitian.lampiran_fotocopy_identitas_kwp,
            tbl_formulir_penelitian.lampiran_fotocopy_kartu_npwp,
            tbl_formulir_penelitian.lampiran_identitas_lainya,
            tbl_formulir_penelitian.lampiran_identitas_lainya_val,
            tbl_formulir_penelitian.lampiran_fotocopy_akta_jb,
            tbl_formulir_penelitian.lampiran_sertifikat_kepemilikan_tanah,
            tbl_formulir_penelitian.lampiran_fotocopy_keterangan_waris,
            tbl_formulir_penelitian.lampiran_fotocopy_surat_pernyataan,
            tbl_formulir_penelitian.penelitian_data_objek,
            tbl_formulir_penelitian.penelitian_nilai_bphtb,
            tbl_formulir_penelitian.penelitian_dokumen,
            tbl_formulir_penelitian.id_pegawai
            ');
        $this->db->where('no_dokumen', $no_dokumen);
        $this->db->join('tbl_formulir_penelitian', 'tbl_sptpd.no_dokumen = tbl_formulir_penelitian.no_sspd', 'inner');
        $data = $this->db->get('tbl_sptpd');
        return $data->row();
    }

    public function get_kelurahan($kd_kecamatan = '', $selected = '')
    {

        if ($selected != '') {
            $this->db->where('kd_kelurahan', $selected);
        }

        $this->db->where('kd_kecamatan', $kd_kecamatan);
        $data = $this->db->get('tbl_kelurahan');
        return $data->result();
    }

    public function edit_by_ppat($id_sptpd = '', $data = '')
    {
        $this->db->where('nik', $data['txt_id_nik_sptpd']);
        $data_nik = array(
            'nama'   => $data['nama_nik_name'],
            'alamat' => $data['alamat_nik_name'],
        );
        $this->db->update('tbl_nik', $data_nik);

        // echo $this->db->last_query();exit();

        $this->db->where('id_sptpd', $id_sptpd);
        $data_sptpd = array(
            'luas_tanah_op'    => $data['txt_luas_tanah_sptpd'],
            'luas_bangunan_op' => $data['txt_luas_bangunan_sptpd'],
            'njop_pbb_op'      => $data['txt_njop_pbb_h_sptpd'],
        );
        $this->db->update('tbl_sptpd', $data_sptpd);

        return $this->db->affected_rowS();
    }

    public function get_nik_detail($nik = '')
    {
        $this->db->where('tbl_nik.nik', $nik);
        $this->db->select(
            '	tbl_nik.nik,
							tbl_nik.nama,
							tbl_nik.alamat,
							tbl_nik.kd_propinsi,
							tbl_nik.kd_kabupaten,
							tbl_nik.kd_kecamatan,
							tbl_nik.kd_kelurahan,
							tbl_nik.rtrw,
							tbl_nik.kodepos'
        );

        $data = $this->db->get('tbl_nik');
        return $data->row();
    }

    public function get_dispenda($id_dispenda = '')
    {
        $this->db->where('id_dispenda', $id_dispenda);
        $data = $this->db->get('tbl_dispenda');
        return $data->row();
    }

    public function getall_sptpd($id_sptpd)
    {
        $this->db->where('id_sptpd', $id_sptpd);
        $data = $this->db->get('tbl_sptpd');
        return $data->row();
    }

    public function get_ppat($id_ppat = '')
    {
        if ($id_ppat) {
            $this->db->where('id_ppat', $id_ppat);
        }

        $data = $this->db->get('tbl_ppat');
        return $data->row();
    }

    public function get_ppat_opt($id_ppat = '')
    {
        if ($id_ppat) {
            $this->db->where('id_ppat', $id_ppat);
        }

        $data = $this->db->get('tbl_ppat');
        return $data->result();
    }

    public function get_wilayah_detail($tipe, $nop)
    {
        if ($tipe == 'propinsi') {
            $where = array(
                'kd_propinsi' => $nop[0],
            );
            $table_wil = 'tbl_propinsi';
        }
        if ($tipe == 'kabupaten') {
            $where = array(
                'kd_propinsi'   => $nop[0],
                'kd_kabupaten'  => $nop[1],
            );
            $table_wil = 'tbl_kabupaten';
        }
        if ($tipe == 'kecamatan') {
            $where = array(
                'kd_propinsi'   => $nop[0],
                'kd_kabupaten'  => $nop[1],
                'kd_kecamatan'  => $nop[2],
            );
            $table_wil = 'tbl_kecamatan';
        }
        if ($tipe == 'kelurahan') {
            $where = array(
                'kd_propinsi'   => $nop[0],
                'kd_kabupaten'  => $nop[1],
                'kd_kecamatan'  => $nop[2],
                'kd_kelurahan'  => $nop[3],
            );
            $table_wil = 'tbl_kelurahan';
        }

        $data = $this->db->get_where($table_wil, $where)->result();
        return @$data[0]->nama;
    }

    public function get_notif()
    {

        $type_user = $this->session->userdata('s_tipe_bphtb');
        $jabatan = $this->session->userdata('jabatan');
        $username = $this->session->userdata('s_username_bphtb');
        $id_ppat = $this->session->userdata('s_id_ppat');
        // print_r($id_user);exit();

        if ($type_user == 'D' && $jabatan == 0) {
            $this->db->where('proses', '-1');
            $this->db->where('aprove_ppat', '1');
            $this->db->where('is_lunas', null);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        } else if ($type_user == 'D' && $jabatan == 1) {
            $this->db->where('proses', '0');
            $this->db->where('is_lunas', '');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        } else if ($type_user == 'D' && $jabatan == 2) {
            $this->db->where('proses', '1');
            $this->db->where('is_lunas', '');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        } else if ($type_user == 'PT') {
            $this->db->or_where('proses', '1');
            $this->db->or_where('proses', '0');
            $this->db->or_where('proses', '2');
            // $this->db->where('id_ppat', $id_ppat);
            // $this->db->where('is_lunas', '');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        } else if ($type_user == 'WP') {
            $this->db->or_where('aprove_ppat', '0');
            $this->db->where('id_user', $username);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        } else if ($type_user == 'D' && $jabatan == null) {
            $this->db->or_where('aprove_ppat', '0');
            $this->db->where('id_user', $username);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        }
    }

    public function get_notif2()
    {

        $data = $this->db->query("
            select * 
            from tbl_user 
            join tbl_wp on tbl_wp.id_user = tbl_user.id_user
            where tbl_user.is_blokir = '1' and tbl_wp.status = '1'")->num_rows();

        return $data;
    }

    public function updateNotif($id = '')
    {
        if ($this->session->userdata('s_tipe_bphtb') == 'D') {
            $object = array('flag_dispenda' => 0);
        } else if ($this->session->userdata('s_tipe_bphtb') == 'PT') {
            $object = array('flag_ppat' => 0);
        }

        $this->db->where('id_sptpd', $id);
        $this->db->update($this->tbl, $object);
    }

    public function get_last_autonum2()
    {
        $date = date('d') . '.' . date('m') . '.' . date('Y') . '.';
        $sql = "SELECT
                    cast(
                        substring(
                            REPLACE (
                                `no_dokumen`,
                                '$date',
                                ''
                            ),
                            1,
                            position(
                                '.' IN REPLACE (
                                    `no_dokumen`,
                                    '$date',
                                    ''
                                )
                            ) - 1
                        ) AS SIGNED
                    ) + 1 AS nodok
                FROM
                    (`tbl_sptpd`)
                WHERE
                    `no_dokumen` LIKE '$date%'
                ORDER BY
                    nodok DESC
                LIMIT 1";
        $query = $this->db->query($sql);
        return $query->result();
    }

    /*ORI
	 public function cek_progressif($nik, $jenis)
    {
        $this->db->where('nik', $nik);
        $this->db->where('jenis_perolehan_op', $jenis);
        $this->db->where('thn_pajak_sppt', date('Y'));
		//$this->db->where('is_lunas', 4);
        $data = $this->db->get($this->tbl)->num_rows();

        return $data;
    } */


    public function cek_progressif($nik)
    {
        //$this->db->where('nik', $nik);
        //$this->db->where('jenis_perolehan_op', $jenis);
        //$this->db->where('thn_pajak_sppt', date('Y'));
        //$this->db->where('is_lunas', 4);
        //$data = $this->db->get($this->tbl)->num_rows();
        $data = NULL;
        return $data;
    }

    public function cek_progressif_kurang($nik)
    {

        $this->db->where('nik', $nik);
        $this->db->where('thn_pajak_sppt', date('Y'));
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    public function kurang_bayar($id, $status)
    {
        $query = "UPDATE $this->tbl set 
                    is_kurang_bayar = '$status'
                    where 
                    id_sptpd = '$id'
                 ";

        if ($this->db->query($query)) {
            return true;
        }

        return false;
    }

    public function hitung_berkas()
    {
        $type_user = $this->session->userdata('s_tipe_bphtb');
        $jabatan = $this->session->userdata('jabatan');

        if ($type_user == 'D' && $jabatan == 0) {
            $this->db->where('proses', '-1');
            $this->db->where('aprove_ppat', '1');
            $this->db->where('is_lunas', null);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        }
        if ($type_user == 'D' && $jabatan == 1) {
            $this->db->where('proses', '0');
            $this->db->where('is_lunas', '');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        }
        if ($type_user == 'D' && $jabatan == 2) {
            $this->db->where('proses', '1');
            $this->db->where('is_lunas', '');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->num_rows();
        }
    }
    //tambah search
    public function get_sptpddata()
    {
        $type_user = $this->session->userdata('s_tipe_bphtb');
        $jabatan = $this->session->userdata('jabatan');

        if ($type_user == 'WP') {
            $id_wp = $this->session->userdata('s_id_wp');

            $this->db->where('id_wp', $id_wp);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        } else if ($type_user == 'PT') {
            $id_ppat = $this->session->userdata('s_id_ppat');

            $this->db->where('id_ppat', $id_ppat);
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        } else if ($type_user == 'D' && $jabatan == 0) {
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        } else if ($type_user == 'D' && $jabatan == 1) {
            $this->db->where('proses', '0');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        } else if ($type_user == 'D' && $jabatan == 2) {
            $this->db->where('proses >', '0');
            $this->db->where('proses <', '2');
            $this->db->order_by('id_sptpd', 'desc');
            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }
}
