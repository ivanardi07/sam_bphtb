<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_user.php
 * Description: User model
 * Date created: 2011-03-04
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_user extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = 'tbl_user';
    }

    function get_user($id = '', $nama_tbl = '', $tipe = '', $go_page = '', $start = '', $halt_at = '')
    {
        $tbl_tujuan = '';
        if ($id != '' && $nama_tbl != '') {

            if ($nama_tbl == 'D') {
                $tbl_tujuan = 'tbl_dispenda';
            } elseif ($nama_tbl == 'PT') {
                $tbl_tujuan = 'tbl_ppat';
            } elseif ($nama_tbl == 'WP') {
                $tbl_tujuan = 'tbl_wp';
            } elseif ($nama_tbl == 'KPP') {
                $tbl_tujuan = 'tbl_kpp';
            } elseif ($nama_tbl == 'PP') {
                $tbl_tujuan = 'tbl_paymentpoint';
            }

            $this->db->where('tbl_user.id_user', $id);
            $this->db->join($tbl_tujuan, 'tbl_user.id_user =' . $tbl_tujuan . '.id_user');
            $query = $this->db->get($this->tbl);
            return $query->row();
        } else {
            $cari = $this->input->get('cari');
            $tipe = $this->input->get('tipe');

            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }

            if ($cari != '') {
                $this->db->like('username', $cari);
                //$this->db->or_like('tipe',$cari);

            }
            if ($tipe != '') {
                $this->db->like('tipe', $tipe);
                //$this->db->or_like('tipe',$cari);

            }
            $this->db->order_by('username', 'asc');
            if ($id != '') {
                $this->db->where('id_user', $id);
            }
            $this->db->where('is_delete', 0);

            $query = $this->db->get($this->tbl);
            return $query->result();
        }
    }

    function get_user_self($id)
    {
        $this->db->where('id_user', $id);
        $query = $this->db->get($this->tbl);
        return $query->result();
    }

    function count_user()
    {
        $tipe = $this->input->get('tipe');

        if ($tipe != '') {
            $this->db->where('tipe', $tipe);
        }

        $this->db->where('is_delete', 0);
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_user(
        $tipe,
        $username,
        $password,
        $is_blokir = '0',
        $id_ppat,
        $id_dispenda,
        $nama_dispenda,
        $alamat_dispenda,
        $nama_ppat,
        $alamat_ppat,
        $email_ppat,
        $id_pp,
        $nama_pp,
        $alamat_pp,
        $nama_kepala_pp,
        $telp_pp,
        $exp_date,
        $jabatan,
        $nip,
        $nama,
        $nama_dinas,
        $id_kpp,
        $nama_kpp,
        $alamat_kpp
    ) {
        $this->db->trans_begin();

        $exp_date = explode('-', $exp_date);

        $exp_date = $exp_date[2] . '-' . $exp_date[1] . '-' . $exp_date[0];

        $add_data = array(
            'username'    => $username,
            'password'    => $password,
            'tipe'         => $tipe,
            'is_blokir'    => $is_blokir,
            'exp_date'    => $exp_date,
        );

        if ($this->db->insert($this->tbl, $add_data)) {
            $last_id_user = $this->db->insert_id();

            $add_data_dispenda = array(
                'id_user'         => $last_id_user,
                'id_dispenda'    => $id_dispenda,
                'nama'            => $nama_dispenda,
                'jabatan'       => $jabatan,
                'nip'           => $nip,
                'nama_ka'       => $nama,
                'nama_dinas'    => $nama_dinas,
                'alamat'        => $alamat_dispenda,
            );
            $add_data_ppat = array(
                'id_user'         => $last_id_user,
                'id_ppat'        => $id_ppat,
                'nama'            => $nama_ppat,
                'alamat'        => $alamat_ppat,
                'email'         => $email_ppat,
            );
            $add_data_kpp = array(
                'id_user'       => $last_id_user,
                'id_kpp'        => $id_kpp,
                'nama_kpp'      => $nama_kpp,
                'alamat_kpp'    => $alamat_kpp,
            );
            $add_data_pp = array(
                'id_user'         => $last_id_user,
                'id_pp'            => $id_pp,
                'nama'            => $nama_pp,
                'alamat'        => $alamat_pp,
                'nama_kepala'    => $nama_kepala_pp,
                'telepon'        => $telp_pp,
            );

            if ($tipe == 'D') {
                $this->db->insert('tbl_dispenda', $add_data_dispenda);

                if ($jabatan == '1' || $jabatan == '2') {
                    $this->db->where('id_dispenda <>', $id_dispenda);
                    $this->db->where('jabatan', $jabatan);
                    $this->db->update('tbl_dispenda', ['is_delete' => '1']);
                }
            } elseif ($tipe == 'PT') {

                $this->db->insert('tbl_ppat', $add_data_ppat);
            } elseif ($tipe == 'KPP') {

                $this->db->insert('tbl_kpp', $add_data_kpp);
            } elseif ($tipe == 'PP') {

                $this->db->insert('tbl_paymentpoint', $add_data_pp);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }


            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_user($id, $nama_tbl, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $exp_date, $jabatan, $nip, $nama, $nama_dinas, $password = '', $id_kpp, $nama_kpp, $alamat_kpp, $blokir, $nama_wp, $alamat_wp)
    {
        // print_r($exp_date);
        //     die();
        $this->db->trans_begin();

        $exp_date   = explode('-', $exp_date);

        $exp_date   = $exp_date[2] . '-' . $exp_date[1] . '-' . $exp_date[0];
        // print_r($exp_date);
        // die();
        $object     = array(
            'exp_date' => $exp_date,
            'is_blokir' => $blokir
        );

        if ($password) {
            $object['password'] = md5($password);
        }

        $this->db->where('id_user', $id);
        $this->db->update($this->tbl, $object);

        if ($nama_tbl == 'D') {
            $ed_data_dispenda = array(
                'nama'        => $nama_dispenda,
                'alamat'    => $alamat_dispenda,
                'jabatan'   => $jabatan,
                'nip'       => $nip,
                'nama_ka'   => $nama,
                'nama_dinas' => $nama_dinas
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_dispenda', $ed_data_dispenda);
        } elseif ($nama_tbl == 'PT') {
            $ed_data_ppat = array(
                'nama'        => $nama_ppat,
                'alamat'    => $alamat_ppat,
                'email'     => $email_ppat
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_ppat', $ed_data_ppat);
        } elseif ($nama_tbl == 'WP') {
            $nik_user = $this->session->userdata('nik_user');

            $ed_data_wp = array(
                'nama'      => $nama_wp,
                'alamat'    => $alamat_wp
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_wp', $ed_data_wp);

            $ed_data_nik = array(
                'nama'      => $nama_wp,
                'alamat'    => $alamat_wp
            );

            $this->db->from('tbl_nik');
            $this->db->where('nik', $nik_user);
            $action = $this->db->update('tbl_nik', $ed_data_nik);
        } elseif ($nama_tbl == 'KPP') {
            $ed_data_ppat = array(
                'nama_kpp'      => $nama_kpp,
                'alamat_kpp'    => $alamat_kpp
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_kpp', $ed_data_ppat);
        } elseif ($nama_tbl == 'PP') {
            $ed_data_pp = array(
                'nama'            => $nama_pp,
                'alamat'        => $alamat_pp,
                'nama_kepala'    => $nama_kepala_pp,
                'telepon'        => $telp_pp
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_paymentpoint', $ed_data_pp);
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            redirect('user');
        } else {
            $this->db->trans_commit();
        }

        if ($action) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function get_tipe_user_by_id($id)
    {
        $this->db->select("tipe");
        $this->db->from("tbl_user tu");
        $this->db->where("tu.id_user", $id);

        return $this->db->get()->row();
    }

    function edit_user_profil($id, $nama_tbl, $nama_dispenda, $alamat_dispenda, $nama_ppat, $alamat_ppat, $email_ppat, $nama_pp, $alamat_pp, $nama_kepala_pp, $telp_pp, $jabatan, $nip, $nama, $nama_dinas, $password = '', $id_kpp, $nama_kpp, $alamat_kpp, $nama_wp, $alamat_wp)
    {
        $this->db->trans_begin();


        if ($password) {
            $object['password'] = md5($password);
            $this->db->where('id_user', $id);
            $this->db->update($this->tbl, $object);
        }

        if ($nama_tbl == 'D') {
            $ed_data_dispenda = array(
                'nama'      => $nama_dispenda,
                'alamat'    => $alamat_dispenda,
                'jabatan'   => $jabatan,
                'nip'       => $nip,
                'nama_ka'   => $nama,
                'nama_dinas' => $nama_dinas
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_dispenda', $ed_data_dispenda);
        } elseif ($nama_tbl == 'PT') {
            $ed_data_ppat = array(
                'nama'      => $nama_ppat,
                'alamat'    => $alamat_ppat,
                'email'     => $email_ppat
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_ppat', $ed_data_ppat);
        } elseif ($nama_tbl == 'WP') //tambah edit profil
        {
            $nik_user = $this->session->userdata('nik_user');

            $ed_data_wp = array(
                'nama'      => $nama_wp,
                'alamat'    => $alamat_wp
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_wp', $ed_data_wp);

            // ====================================================================

            $ed_data_nik = array(
                'nama'      => $nama_wp,
                'alamat'    => $alamat_wp
            );

            $this->db->from('tbl_nik');
            $this->db->where('nik', $nik_user);
            $action = $this->db->update('tbl_nik', $ed_data_nik);
        } elseif ($nama_tbl == 'KPP') {
            $ed_data_kpp = array(
                'nama_kpp'      => $nama_kpp,
                'alamat_kpp'    => $alamat_kpp
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_kpp', $ed_data_kpp);
        } elseif ($nama_tbl == 'PP') {
            $ed_data_pp = array(
                'nama'          => $nama_pp,
                'alamat'        => $alamat_pp,
                'nama_kepala'   => $nama_kepala_pp,
                'telepon'       => $telp_pp
            );
            $this->db->where('id_user', $id);
            $action = $this->db->update('tbl_paymentpoint', $ed_data_pp);
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            redirect('user');
        } else {
            $this->db->trans_commit();
        }

        if ($action) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_user($id, $nama_tbl)
    {
        $this->db->trans_begin();

        $tbl_tujuan = '';
        $this->db->where('id_user', $id);

        if ($nama_tbl == 'D') {
            $tbl_tujuan = 'tbl_dispenda';
        } elseif ($nama_tbl == 'PT') {
            $tbl_tujuan = 'tbl_ppat';
        } elseif ($nama_tbl == 'WP') {
            $tbl_tujuan = 'tbl_wp';
        } elseif ($nama_tbl == 'KPP') {
            $tbl_tujuan = 'tbl_kpp';
        } elseif ($nama_tbl == 'PP') {
            $tbl_tujuan = 'tbl_paymentpoint';
        }

        $update_user = 'UPDATE tbl_user SET is_delete = 1 WHERE id_user = ' . $id;
        $this->db->query($update_user);

        $update_dll = ' UPDATE ' . $tbl_tujuan . '  SET is_delete= 1 WHERE id_user = ' . $id;
        $this->db->query($update_dll);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }

        echo $this->antclass->go_log($this->db->last_query());
        return TRUE;
    }

    function do_login_user($id, $password)
    {
        $this->db->where('username', $id);
        $this->db->where('password', $password);
        $this->db->where('is_blokir', 0);
        $this->db->where('is_delete', 0);
        $query = $this->db->get($this->tbl);
        if ($query->row()) {
            return $query->row();
        }

        return FALSE;
    }

    function change_password($id, $pwd_lama, $pwd_baru, $pwd_baru2)
    {
    }

    function change_status($id, $old_status)
    {
        $nu_status = 1;
        if ($old_status == '1') {
            $nu_status = '0';
        } elseif ($old_status == '0') {
            $nu_status = '1';
        }
        $ed_data = array('is_blokir' => $nu_status);
        $this->db->where('id_user', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function cekuser($username)
    {
        $query_str = "SELECT * FROM tbl_user where username = '$username'";
        $result = $this->db->query($query_str);
        $num_rows = $result->num_rows();
        return $num_rows;
    }

    function cekunique_person($tipe, $data_post)
    {
        if ($tipe == 'D') {
            $query_str = "SELECT * FROM tbl_dispenda where id_dispenda = '$data_post'";
        } elseif ($tipe == 'PT') {
            $query_str = "SELECT * FROM tbl_ppat where id_ppat = '$data_post'";
        } elseif ($tipe == 'KPP') {
            $query_str = "SELECT * FROM tbl_kpp where id_kpp = '$data_post'";
        } elseif ($tipe == 'PP') {
            $query_str = "SELECT * FROM tbl_paymentpoint where id_pp = '$data_post'";
        }
        $result = $this->db->query($query_str);
        $num_rows = $result->num_rows();
        return $num_rows;
    }

    function cek_id_ppat($id_user = '')
    {
        $this->db->where('id_user', $id_user);
        $ppat = $this->db->get('tbl_ppat');
        $ppat = $ppat->result();
        return @$ppat[0]->id_ppat;
    }

    public function get_sptpd($id_ppat = '')
    {
        $sptpd = $this->db->get_where('tbl_sptpd', array('id_ppat' => $id_ppat));
        $sptpd = $sptpd->result();
        return @$sptpd[0]->id_ppat;
    }

    public function get_user_detail($id_user = '', $tipe)
    {

        if ($tipe == 'DISPENDA') {
            $tbl_tujuan = 'tbl_dispenda';
        } elseif ($tipe == 'PPAT') {
            $tbl_tujuan = 'tbl_ppat';
        } elseif ($tipe == 'KPP') {
            $tbl_tujuan = 'tbl_kpp';
        } elseif ($tipe == 'PAYMENTPOINT') {
            $tbl_tujuan = 'tbl_paymentpoint';
        } elseif ($tipe == 'WP') {
            $tbl_tujuan = 'tbl_wp';
        }

        $data = $this->db->get_where($tbl_tujuan, array('id_user' => $id_user))->result();

        return @$data;
    }

    public function get_user_kasi()
    {
        $this->db->where('jabatan', '1');
        $user = $this->db->get('tbl_dispenda');
        $result = $user->num_rows();
        return $result;
    }

    public function get_user_kabid()
    {
        $this->db->where('jabatan', '2');
        $user = $this->db->get('tbl_dispenda');
        $result = $user->num_rows();
        return $result;
    }

    public function get_kasi()
    {
        $this->db->where('jabatan', '1');
        $user = $this->db->get('tbl_dispenda');
        $result = $user->row();
        return $result;
    }

    public function get_kabid()
    {
        $this->db->where('jabatan', '2');
        $user = $this->db->get('tbl_dispenda');
        $result = $user->row();
        return $result;
    }

    public function get_durasi()
    {
        $user = $this->db->get('tb_session');
        $result = $user->row();
        return $result;
    }

    public function get_kecamatan()
    {
        $prop = '35';
        $kab = '73';
        $sql = 'select * from tbl_kecamatan where kd_propinsi=' . $prop . ' and kd_kabupaten =' . $kab;
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function get_kelurahan($prop, $kab, $kec)
    {
        $sql = 'select * from tbl_kelurahan where kd_propinsi=' . $prop . ' and kd_kabupaten =' . $kab . ' and kd_kecamatan =' . $kec;
        $data = $this->db->query($sql);
        return $data->result();
    }
}

/* EoF */