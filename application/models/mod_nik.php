<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
/**
 * Filename: mod_nik.php
 * Description: NIK model
 * Date created: 2011-03-11
 * Author: Anton Ashardi (ashardi@seven7sign.com)
 */
class Mod_nik extends CI_Model
{

    var $query_get_data_nik = "SELECT a.*
                                FROM tbl_nik as a 
                                WHERE a.nik = ?";

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tbl = $this->config->item('pg_schema') . 'tbl_nik';
        $this->tbl_propinsi = $this->config->item('pg_schema') . 'tbl_propinsi';
        $this->tbl_kabupaten = $this->config->item('pg_schema') . 'tbl_kabupaten';
        $this->tbl_kecamatan = $this->config->item('pg_schema') . 'tbl_kecamatan';
        $this->tbl_kelurahan = $this->config->item('pg_schema') . 'tbl_kelurahan';
    }

    function get_nik($id = '', $limit = '', $go_page = '', $start = '', $halt_at = '', $nik = '')
    {
        if ($id != '') {
            //$this->db->where('nik',$id);
            //$query = $this->db->get($this->tbl);
            $query = $this->db->query($this->query_get_data_nik, $id);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            if (@$nik['nik'] != '') {
                $this->db->where('nik', str_replace('.', '', $nik['nik']));
            }
            if (@$nik['nama'] != '') {
                $this->db->like('nama', $nik['nama']);
            }
            $this->db->order_by('nik', 'asc');
            $query = $this->db->get($this->tbl);

            return $query->result();
        }
    }

    function get_dati2s($data = '')
    {
        if (@$id != '') {
            if ($kd_propinsi != '') {
                $this->db->where("kd_kabupaten = '$kd_propinsi'");
            }
            $this->db->where('kd_kabupaten', $id);
            $query = $this->db->get($this->tbl_kabupaten);
            return $query->row();
        } else {
            if ($data != '') {
                $sql = "select * from tbl_kelurahan where  kd_propinsi='$data->kd_propinsi'";
            }

            $query = $this->db->query($sql);
            //echo $this->db->last_query();exit;
            return $query->result();
        }
    }


    function get_kecamatans($data = '')
    {
        if (@$id != '') {
            if ($kd_dati2 != '') {
                $this->db->where("kd_kabupaten = '$kd_dati2'");
            }
            $query = $this->db->get($this->tbl_kecamatan);
            return $query->row();
        } else {
            if ($data != '') {
                $sql = "select * from tbl_kelurahan where kd_kabupaten='$data->kd_kabupaten' 
                                    and kd_propinsi='$data->kd_propinsi'";
            }

            $query = $this->db->query($sql);
            //echo $this->db->last_query();exit;
            return $query->result();
        }
    }

    function get_kelurahans($data = '')
    {
        // print_r($data);exit();
        if (@$id != '') {
            if ($kd_dati2 != '') {
                $this->db->where("kd_kecamatan = '$data->kd_kecamatan'");
            }
            $query = $this->db->get($this->tbl_kelurahan);
            return $query->row();
        } else {
            if ($data != '') {
                $sql = "select * from tbl_kelurahan where kd_kecamatan = '$data->kd_kecamatan'  and kd_kabupaten='$data->kd_kabupaten' 
                                    and kd_propinsi='$data->kd_propinsi'";
            }
            $query = $this->db->query($sql);
            // echo $this->db->last_query();exit();
            return $query->result();
        }
    }

    function check_kecamatan($kd_kecamatan)
    {
        if ($kd_kecamatan != '') {
            $this->db->where('kd_kecamatan', $kd_kecamatan);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function check_kelurahan($kd_kelurahan)
    {
        if ($kd_kelurahan != '') {
            $this->db->where('kd_kelurahan', $kd_kelurahan);
            $query = $this->db->get($this->tbl);
            if ($query->row()) {
                return TRUE;
            }
        }

        return FALSE;
    }

    function count_nik($nik = '')
    {
        if ($nik['nik'] != '') {
            $this->db->where('nik', str_replace('.', '', $nik['nik']));
        }
        if ($nik['nama'] != '') {
            $this->db->like('nama', $nik['nama']);
        }
        $this->db->from($this->tbl);
        return $this->db->count_all_results();
    }

    function add_nik($id, $nama, $alamat, $propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $rtrw, $kodepos)
    {
        $add_data = array(
            'nik' => $id,
            'nama' => $nama,
            'alamat' => $alamat,
            'kd_propinsi' => $propinsi,
            'kd_kabupaten' => $kd_dati2,
            'kd_kecamatan' => $kd_kecamatan,
            'kd_kelurahan' => $kd_kelurahan,
            'rtrw' => $rtrw,
            'kodepos' => $kodepos
        );
        if ($this->db->insert($this->tbl, $add_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function edit_nik($id, $nama, $alamat, $propinsi, $kd_dati2, $kd_kecamatan, $kd_kelurahan, $rtrw, $kodepos, $nik = '')
    {
        if ($nik != '') {
            $ed_data = array(
                'nik' => $nik,
                'nama' => $nama,
                'alamat' => $alamat,
                'kd_propinsi' => $propinsi,
                'kd_kabupaten' => $kd_dati2,
                'kd_kecamatan' => $kd_kecamatan,
                'kd_kelurahan' => $kd_kelurahan,
                'rtrw' => $rtrw,
                'kodepos' => $kodepos
            );
        } else {
            $ed_data = array(
                'nama' => $nama,
                'alamat' => $alamat,
                'kd_propinsi' => $propinsi,
                'kd_kabupaten' => $kd_dati2,
                'kd_kecamatan' => $kd_kecamatan,
                'kd_kelurahan' => $kd_kelurahan,
                'rtrw' => $rtrw,
                'kodepos' => $kodepos
            );
        }

        $this->db->where('nik', $id);
        if ($this->db->update($this->tbl, $ed_data)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function delete_nik($id)
    {
        $this->db->where('nik', $id);
        if ($this->db->delete($this->tbl)) {
            $this->antclass->go_log($this->db->last_query());
            return TRUE;
        }

        return FALSE;
    }

    function get_dati2_bypropinsi($kd_propinsi = '')
    {
        if ($id != '') {
            if ($kd_propinsi != '') {
                $this->db->where("kd_kabupaten = '$kd_propinsi'");
            }
            $this->db->where('kd_kabupaten', $id);
            $query = $this->db->get($this->tbl_kabupaten);
            return $query->row();
        } else {
            if ($go_page != '') {
                $this->db->limit($halt_at, $start);
            }
            if ($kd_propinsi != '') {
                $this->db->where("kd_propinsi = '$kd_propinsi'");
            }
            if ($limit != '') {
                $this->db->limit($limit);
            }
            $this->db->order_by('kd_kabupaten', 'asc');
            $query = $this->db->get($this->tbl_kabupaten);
            return $query->result();
        }
    }

    function get_propinsi($id = '')
    {
        if ($id != '') {
            $this->db->where('kd_propinsi', $id);
            $query = $this->db->get($this->tbl_propinsi);
            return $query->row();
        } else {
            $this->db->order_by('kd_propinsi', 'asc');
            $query = $this->db->get($this->tbl_propinsi);
            return $query->result();
        }
    }

    function get_dati2($kd_propinsi = '')
    {
        if (@$id != '') {
            if ($kd_propinsi != '') {
                $this->db->where("kd_kabupaten = '$kd_propinsi'");
            }
            $this->db->where('kd_kabupaten', $id);
            $query = $this->db->get($this->tbl_kabupaten);
            return $query->row();
        } else {
            if ($kd_propinsi != '') {
                $this->db->where("kd_propinsi = '$kd_propinsi'");
            }
            $this->db->order_by('kd_kabupaten', 'asc');
            $query = $this->db->get($this->tbl_kabupaten);
            return $query->result();
        }
    }

    function get_kecamatan($kd_dati2 = '')
    {
        if (@$id != '') {
            if ($kd_dati2 != '') {
                $this->db->where("kd_kabupaten = '$kd_dati2'");
            }
            $query = $this->db->get($this->tbl_kecamatan);
            return $query->row();
        } else {
            if ($kd_dati2 != '') {
                $this->db->where("kd_kabupaten ='$kd_dati2'");
            }
            $this->db->order_by('kd_kecamatan', 'asc');
            $query = $this->db->get($this->tbl_kecamatan);
            //echo $this->db->last_query();exit;
            return $query->result();
        }
    }

    function get_kelurahan($kd_kecamatan = '')
    {
        if (@$id != '') {
            if ($kd_dati2 != '') {
                $this->db->where("kd_kecamatan = '$kd_kecamatan'");
            }
            $query = $this->db->get($this->tbl_kelurahan);
            return $query->row();
        } else {
            if ($kd_kecamatan != '') {
                $this->db->where("kd_kecamatan = '$kd_kecamatan'");
            }
            $this->db->order_by('kd_kelurahan', 'asc');
            $query = $this->db->get($this->tbl_kelurahan);
            return $query->result();
        }
    }

    function ceknik($nik)
    {
        $query_str = "SELECT * FROM tbl_nik where nik = '$nik'";
        $result = $this->db->query($query_str);
        $num_rows = $result->num_rows();
        return $num_rows;
    }
}

/* EoF */
