<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_register extends CI_Model
{



	public function get_prop($id_prop)
	{
		$sql = "select * from tbl_propinsi where kd_propinsi = $id_prop";
		$data = $this->db->query($sql);
		return $data->row();
	}

	public function get_kab($id_prov = '', $id_kab = '')
	{
		$sql = "select * from tbl_kabupaten where kd_propinsi = $id_prov and kd_kabupaten = $id_kab";
		$data = $this->db->query($sql);
		return $data->row();
	}

	public function get_kec($id_prov = '', $id_kab = '', $id_kec = '')
	{
		$sql = "select * from tbl_kecamatan where kd_propinsi =$id_prov and kd_kabupaten = $id_kab and kd_kecamatan = $id_kec";
		$data = $this->db->query($sql);
		return $data->row();
	}

	public function get_kel($id_prov = '', $id_kab = '', $id_kec = '', $id_kel = '')
	{
		$sql = "select * from tbl_kelurahan where  kd_propinsi =$id_prov and kd_kabupaten = $id_kab and kd_kecamatan = $id_kec and kd_kelurahan = $id_kel";
		$data = $this->db->query($sql);
		return $data->row();
	}

	public function get_propinsi1()
	{
		$sql = 'select * from tbl_propinsi ';
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_kabupaten1($id_prov = '', $id_kab = '')
	{
		$sql = "select * from tbl_kabupaten where kd_propinsi = $id_prov and kd_kabupaten = $id_kab";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_kecamatan1($id_prov = '', $id_kab = '', $id_kec = '')
	{
		$sql = "select * from tbl_kecamatan where kd_propinsi =$id_prov and kd_kabupaten = $id_kab and kd_kecamatan = $id_kec";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_kelurahan1($id_prov = '', $id_kab = '', $id_kec = '', $id_kel = '')
	{
		$sql = "select * from tbl_kelurahan where  kd_propinsi =$id_prov and kd_kabupaten = $id_kab and kd_kecamatan = $id_kec and kd_kelurahan = $id_kel";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_kabupaten($val)
	{
		$sql = 'select * from tbl_kabupaten where kd_propinsi=' . $val;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();
		return $data->result();
	}
	public function get_kecamatan($prop, $kab)
	{
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
	public function get_ID($val)
	{
		$sql = 'select * from tbl_user where username="' . $val . '"';
		$data = $this->db->query($sql);
		return $data->result();
	}
	public function insert_user($val)
	{

		$data = $this->db->insert('tbl_user', $val);
		if ($data) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function insert_wp($val)
	{

		$data = $this->db->insert('tbl_wp', $val);
		if ($data) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function email($email1, $subject1, $header1, $body1, $kode1)
	{
		// die($body1); 'ssl://smtp.googlemail.com',
		//print_r($email1);
		// exit();
		//'smtp_user' => '',
		//     'smtp_pass' => '',
		$this->load->library('email');
		$config = array(
			'protocol' => 'smtp',
			//'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_host' => 'ssl://smtp.mail.yahoo.com',
			'smtp_port' => 465,
			'smtp_user' => 'bphtbmalang@yahoo.com',
			'smtp_pass' => 'B3p3h4t3b3_M19',
			'mailtype' => 'html',
			'charset' => 'utf-8'
		);

		//$this->email->bcc('masraga.setiawan@gmail.com')$subject1;
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		$this->email->from('bphtbmalang@yahoo.com', 'E-BPHTB Kota Malang');
		$email = str_replace(';', ',', $email1);
		$this->email->to($email);
		$this->email->subject($subject1);

		$body = '
        <html>
        <body style="background: #ffffff; color: #222; font-family: Arial; margin: 20px; color: #363636; font-size:11px;">
            <table style="font-family: Arial; border-collapse:collapse;">
                <tr>
                    <td style="width:90px;color: #009900;font-size: 20px;" valign="middle">E-BPHTB</td>
                    <td style="color: #222; padding-left:15px; font-size: 20px; border-left:1px solid;"><b>' . $header1 . '</b>
                        <div style="color: #888; font-size: 10px;">Badan Pendapatan Daerah Kota Malang</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" height="5"></td>
                </tr>
            </table>
            <div style="height:15px;">
            </div>
            <table style="background: #efefef; font-size:11px; color: #444; font-family: Arial;"  cellpadding=3 cellspacing=2>
                <tr>
                    <td>' . $body1 . '</td>
                </tr>
                <tr>
                    <td><h2><b>' . $kode1 . '</b></h2></td>
                </tr>
            </table>
            <div style="font-size: 10px; color: #888;"><br>
                <b style="color:#222;">Copyright 2019 - BP2D KOTA MALANG
            </div>
        </body>
        </html>';
		$this->email->message($body);
		return $this->email->send();
	}
	public function acc_verifikasi($id)
	{
		$sql = 'update tbl_wp set status = "1" where id_user = ' . $id;
		$data = $this->db->query($sql);
		// echo $this->db->last_query();exit();
		if ($data) {
			return true;
		}
		return false;
	}
}

/* End of file mod_register.php */
/* Location: ./application/models/mod_register.php */