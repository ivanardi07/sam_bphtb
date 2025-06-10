<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_global extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function setdateformat($date)
    {

        $date = date('d-m-Y', strtotime($date));
        return $date;
    }

    public function count_data_all($table, $join = NULL, $where = NULL, $where_e = NULL, $group = NULL)
    {
        $this->db->select("count(*) as jumlah")->from($table);

        if(!is_null($join)){
            foreach ($join as $rows) {
                $tipe = (@$rows['tipe'] != '') ? $rows['tipe'] : 'INNER';
                $this->db->join($rows['table'], $rows['on'], $tipe);
            }
        }

        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');

        $query  = $this->db->get();
        $result = $query->row();

        return $result->jumlah;
    }
    
    public function nomor($tipe)
    {
        if ($tipe=="idbilling") {
             $query = $this->db->query("SELECT prefix,
                CONCAT(
                    IFNULL(
                    REPLACE(
                        REPLACE(
                        REPLACE (
                            prefix,
                            'tgl',
                            DATE_FORMAT(NOW(), '%d%m%Y')
                        ),
                            'year',
                            DATE_FORMAT(NOW(), '%Y')
                        ),
                        'bln',DATE_FORMAT(NOW(), '%m')
                        ),
                        ''
                    ),
                    LPAD(nomor + 1, digit, 0),
                    IFNULL(
                REPLACE(
                     postfix,
                      'year',
                      DATE_FORMAT(NOW(), '%Y')),''
                     )
                ) AS nomor,
                TYPE
            FROM
                m_nomor
            WHERE
                type = 'idbilling'")->row();
            $nomor = $query->nomor;
            // print_r($nomor);
        }else{
            $query = $this->db->query("SELECT CONCAT(prefix, LPAD(nomor, digit, 0), postfix) AS nomor FROM m_nomor WHERE type = '$tipe'")->row();
        
            $nomor = $query->nomor;
            $bln = date('m');
            if ($bln == '1') {
                $hasil = 'I';
            }elseif($bln == '2') {
                $hasil = 'II';   
            }elseif($bln == '3') {
                $hasil = 'III';   
            }elseif($bln == '4') {
                $hasil = 'IV';   
            }elseif($bln == '5') {
                $hasil = 'V';   
            }elseif($bln == '6') {
                $hasil = 'VI';   
            }elseif($bln == '7') {
                $hasil = 'VII';   
            }elseif($bln == '8') {
                $hasil = 'VIII';   
            }elseif($bln == '9') {
                $hasil = 'IX';   
            }elseif($bln == '10') {
                $hasil = 'X';   
            }elseif($bln == '11') {
                $hasil = 'XI';   
            }elseif($bln == '12') {
                $hasil = 'XII';   
            }
            
            if(!strpos($nomor, "%DD/MM/YYYY%") === false){
                $nomor = str_replace('%DD/MM/YYYY%', $hasil.'/'.date('Y'), $nomor);
            }
        }
            // die();
        
        $this->db->query("UPDATE m_nomor SET nomor = (nomor + 1) WHERE  type = '$tipe'");
        return $nomor;

    }
    
    public function num($tipe)
    {
        $query = $this->db->query("SELECT CONCAT(prefix, LPAD(nomor, digit, 0), postfix) AS nomor FROM m_nomor WHERE type = '$tipe'")->row();
        $nomor = $query->nomor;
        $this->db->query("UPDATE m_nomor SET nomor = (nomor + 1) WHERE  type = '$tipe'");
        return $nomor;

    }

    public function get_data_all($table, $join = NULL, $where = NULL, $select = '*', $where_e = NULL, $order = NULL, $start = 0, $tampil = NULL, $group = NULL)
    {
        $this->db->select($select)->from($table);

        if(!is_null($join)){
            foreach ($join as $rows) {
                $tipe = (@$rows['tipe'] != '') ? $rows['tipe'] : 'INNER';
                $this->db->join($rows['table'], $rows['on'], $tipe);
            }
        }

        (!is_null($order) ? $this->db->order_by($order[0], $order[1]) : '');
        (!is_null($tampil) ? $this->db->limit($tampil, $start) : '');
        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');
        (!is_null($group) ? $this->db->group_by($group, NULL, FALSE) : '');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function insert($table, $data = NULL)
    {
        $result    = $this->db->insert($table, $data);
        if($result == TRUE){
            $result = [];
            $result['status'] = TRUE;
            $result['id']     = $this->db->insert_id();
        }else{
            $result = [];
            $result['status'] = FALSE;
        }

        return $result;
    }

    public function update($table, $data = NULL, $where = NULL, $where_e = NULL)
    {
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');
        $result    = $this->db->update($table, $data, $where);
        return $result;
    }

    public function delete($table, $where = NULL, $where_e = NULL)
    {
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');
        $result    = $this->db->delete($table, $where);
        return $result;
    }

    public function validation($table, $where, $where_e = NULL)
    {
        $this->db->select('*')->from($table);
        
        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');

        $query  = $this->db->get();
		
        $result = $query->num_rows();
		if($result > 0){
            $result = FALSE;
        }else{
            $result = TRUE;
        }
        return $result;

    }
	public function validation_pass($table, $where, $where_e = NULL)
    {
        $this->db->select('*')->from($table);
        
        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');

        $query  = $this->db->get();
		
        $result = $query->num_rows();
		if($result > 0){
            $result = TRUE;
        }else{
            $result = FALSE;
        }
        return $result;

    }

    function getData($id){
        $sql = "SELECT * FROM eoffice_circulation_attachment where attachment_id = {$this->db->escape($id)}";
        $act = $this->db->query($sql)->result();
        return $act;
    }

    public function email($email1, $subject1, $header1, $body1, $kode1='')
    {
        // die($body1); 'ssl://smtp.googlemail.com',
       //  print_r($kode1);
       // exit();
        //'smtp_user' => 'bppdmalang@gmail.com',
	
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
                    <td style="color: #222; padding-left:15px; font-size: 20px; border-left:1px solid;"><b>'.$header1.'</b>
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
                    <td><h3>'.$body1.'</h3></td>
                </tr>
                <tr>
                    <td><h2><b>'.@$kode1.'</b></h2></td>
                </tr>
            </table>
            <div style="font-size: 10px; color: #888;"><br>
                <b style="color:#222;">Copyright 2019 - Badan Pendapatan Daerah Kota Malang
            </div>
        </body>
        </html>';
        $this->email->message($body);
        return $this->email->send();
    }

    // End Core Model
}

/* End of file m_global.php */
/* Location: ./application/modules/global/models/m_global.php */