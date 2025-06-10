<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_service extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        $this->load->model('mod_sptpd');
        $this->load->model('mod_service');
        $this->load->model('m_webservice');
    }

    public function index()
    {
        echo "This is web service";
    }

    function check_nik(){
        
        $id_nik = $this->input->post('enNikValue');
        $data = $this->mod_sptpd->get_nik($id_nik);
        if($data){
            $result_content = array(
                                    'nama'=>$data->nama,
                                    'alamat'=>$data->alamat,
                                    'kelurahan'=>$data->nm_kelurahan,
                                    'rtrw'=>$data->rtrw,
                                    'kecamatan'=>$data->nm_kecamatan,
                                    'kota'=>$data->nm_dati2,
                                    'kd_pos'=>$data->kodepos
                                    );       
        } else {
            $result_content = array('nama'=>'');  
        }

        echo json_encode($result_content);
    }

    public function login()
    {
        $param['username'] = $this->input->post('username');
        $param['password'] = $this->input->post('password');

        $login = $this->mod_service->login($param);

        $status   = 0; 

        if (count($login) > 0) {
            $status = 1;
            $data   = $login;
            $msg    = 'Berhasil login';
        } else {
            $data = '';
            $msg    = 'Gagal Login, Username/Password Tidak Cocok';
        }

        $output = array(
                        'status'    => $status,
                        'data_user' => $data,
                        'message'   => $msg,
                      );
        
        echo json_encode($output);
    }

    public function cariSspd()
    {
        $param['no_sspd']   = $this->input->get('no_sspd');
        $data               = $this->mod_service->cariSspd($param);

        $status             = 0;
        $msg                = 'Data tidak ada'; 
        
        if (@$data[0]['no_dokumen'] != '') {
            $status         = 1;
            $data           = @$data; 
            $msg            = 'Ada data';
        }else{
            $data           = array(); 
        } 
        
        $out = array(
                    'status'    => $status, 
                    'data'      => $data, 
                    'message'   => $msg, 
               );

        echo json_encode($out);
    }

    public function cekStatusSspd($value='')
    {
        $param['no_sspd']           = $this->input->get('no_sspd');

        $cek    = $this->mod_service->cek_sspd($param);

        if ($cek > 0) {
            $status = 'edit';
        } else {
            $status = 'add';
        }

        $out = array('status' => $status);

        echo json_encode($out);
        
    }

    public function simpanDetailSspd()
    {
        $param['no_sspd']           = $this->input->post('no_sspd');
        $param['foto']              = $this->input->post('foto');
        $param['latitude']          = $this->input->post('latitude');
        $param['longitude']         = $this->input->post('longitude');
        $param['status']            = $this->input->post('status');

        $proses = $this->mod_service->simpan_detail_sspd($param);

        if ($proses >= 0) {
            $status = 1;
            $msg = 'Foto berhasil di simpan';
        } else {
            $status = 0;
            $msg = 'Foto gagal disimpan';
        }

        $output = array(
                    'status'    => $status, 
                    'message'   => $msg 
                  );
        
        echo json_encode($output);
    }

    public function autoSspd()
    {
        $param['no_sspd'] = $this->input->get('no_sspd');

        $data = $this->mod_service->autoSspd($param);

        echo json_encode($data);
    }

    public function loadAllSspd()
    {
        $data = $this->mod_service->loadAllSspd();

        echo json_encode($data);
    }

    function getnopbphtb(){
        $nop = $this->input->get("nop");
        if(strlen($nop) < 24){
            echo json_encode(array('msg'=>'nop tidak tersedia'));
        }else{
            $pecahnop = explode('.', $nop);
            $nop_asli = str_replace('.', '', $nop);
            // $nop = $this->mod_service->get_detail_nop($pecahnop,'2015');
            $nop = $this->mod_service->get_detail_nop($pecahnop,date("Y"));
			
            if($nop)
				{
                $msg = array("msg" => 'Ada Data');
                $new = array_merge($msg,$nop[0]);
                $datas[]=$new;

                echo json_encode($datas[0]);}
			else
				{echo json_encode(array('msg'=>'nop '.$nop[0].' tidak tersedia!!!'));
            }
        }
    }

    function gethistorynop(){
        $nop = $this->input->get("nop");
        if(strlen($nop) < 24){
            echo json_encode(array('msg'=>'nop tidak tersedia. '));
        }else{
            $pecahnop = explode('.', $nop);
            $history = $this->mod_service->getHistory($pecahnop);
           /* if(@$history[0]['STATUS_PEMBAYARAN_SPPT'] == '0' || @$history[1]['STATUS_PEMBAYARAN_SPPT'] == '0' || @$history[2]['STATUS_PEMBAYARAN_SPPT'] == '0' || @$history[3]['STATUS_PEMBAYARAN_SPPT'] == '0' || @$history[4]['STATUS_PEMBAYARAN_SPPT'] == '0') {
                echo '0'; 
            } else { */
                $tes = '';
                foreach($history as $row => $val){
                    $tes .= '<tr>
                        <td class="text-center"> '.$val['THN_PAJAK_SPPT'].'</td>
                        <td class="text-right">'.number_format($val['PBB_YG_HARUS_DIBAYAR_SPPT'], 0, ',', '.').'</td>
                        <td class="text-center">'.$val['STATUS'].'</td>
                    </tr>';
                }
                if($history){
                    /*$msg = array("msg" => 'Ada Data');
                    $new = array_merge($msg,array("data"=>$history));
                    $datas[]=$new;
                    echo json_encode($datas[0]);*/
                    echo '<table class="table table-hover">
                        <thead>
                            <tr class="tblhead">
                                <th class="text-center" > Tahun Pajak SPPT </th>
                                <th class="text-center" > PBB Yang Harus Dibayar</th>
                                <th class="text-center" > Status</th>
                            </tr>
                        </thead>
                        <tbody>'.$tes.
                        '</tbody>
                    </table>';
                }else{
                    echo 'nop tidak tersedia';
                }
            //}
        }
    }

    function gethistorynop2(){
        $nop = $this->input->get("nop");
        if(strlen($nop) < 24){
            echo json_encode(array('msg'=>'nop tidak tersedia'));
        }else{
            $pecahnop = explode('.', $nop);
            $history = $this->mod_service->getHistory($pecahnop);
            $tes = '';
            foreach($history as $row => $val){
                $tes .= '<tr>
                    <td class="text-center"> '.$val['THN_PAJAK_SPPT'].'</td>
                    <td class="text-right">'.number_format($val['PBB_YG_HARUS_DIBAYAR_SPPT'], 0, ',', '.').'</td>
                    <td class="text-center">'.$val['STATUS'].'</td>
                </tr>';
            }
            if($history){
                /*$msg = array("msg" => 'Ada Data');
                $new = array_merge($msg,array("data"=>$history));
                $datas[]=$new;
                echo json_encode($datas[0]);*/
                echo '<table class="table table-hover">
                    <thead>
                        <tr class="tblhead">
                            <th class="text-center" > Tahun Pajak SPPT </th>
                            <th class="text-center" > PBB Yang Harus Dibayar</th>
                            <th class="text-center" > Status</th>
                        </tr>
                    </thead>
                    <tbody>'.$tes.
                    '</tbody>
                </table>';
            }else{
                echo 'nop tidak tersedia';
            }
        }
    }

    public function inquiry($db = null) {
        $post = $_POST;

        $idbilling = abs((int)$post['idbilling']);
        $idbilling = $post['idbilling'];

        // $idbilling = intval('352171270920180060');
        // die($idbilling);
        
        
            $data = $this->m_webservice->get_data($idbilling);
            $now= date('Y');
            $thun   = substr(@$data[0]->idbilling, 10, 4);
            if ($data && $thun == $now) {
            // echo json_encode($thun.$now);exit();
                $result = json_encode(['sts'=>'Id Billing Kadaluarsa']);

            }elseif ($data && strlen($idbilling) == 18) {
                $kode_vd        = ($data[0]->validasi_dispenda) ? '1' : '0'; 
                $status_vd      = ($data[0]->validasi_dispenda) ? 'Sudah Divalidasi' : 'Belum Divalidasi'; 
                $status_bayar   = ($data[0]->validasi_bank) ? '1' : '0'; 
                if ($data[0]->is_kurang_bayar == 1) {
                    $setor =$data[0]->jumlah_setor;
                    // echo $setor;exit();
                    $arr = [
                        'idbilling'     => $idbilling,
                        'nop'           => $data[0]->nop,
                        'notaris'       => @$data[0]->id_ppat,
                        'nama_wp'       => $data[0]->nama,
                        'alamat_wp'     => $data[0]->alamat,
                        'nik'           => $data[0]->nik,
                        'jumlah'        => $data[0]->jumlah_setor,
                        'v_dispenda'    => $kode_vd,
                        'v_status'      => 'Kurang Bayar',
                        's_bayar'       => $status_bayar,
                        'jumlah_setor'  => $setor,
                        'ResponseCode'  => '00'
                    ];
                }else{
                    $arr = [
                        'idbilling'     => $idbilling,
                        'nop'           => $data[0]->nop,
                        'notaris'       => @$data[0]->id_ppat,
                        'nama_wp'       => $data[0]->nama,
                        'alamat_wp'     => $data[0]->alamat,
                        'nik'           => $data[0]->nik,
                        'jumlah'        => $data[0]->jumlah_setor,
                        'v_dispenda'    => $kode_vd,
                        'v_status'      => $status_vd,
                        's_bayar'       => $status_bayar,
                        'ResponseCode'  => '00'
                    ];
                }
                $result = json_encode($arr);
            } else {
                $result = json_encode(['sts' => '0','ResponseCode'=> '01', 'msg' => $post['idbilling']]);
            }

            if($db == null) {
                echo $result;
            } else {
                echo "<pre>";
                print_r($this->db->last_query());
                echo "</pre>";
            }
           
    }

    public function change_flag()
    {
        $post = $_POST;

        // $idbilling = abs((int)$post['idbilling']);
        $idbilling = $post['idbilling'];
    
            $check = $this->m_webservice->get_data($idbilling);
            // echo json_encode($check);exit();
            $now= date('Y');
            $thun   = substr(@$check[0]->idbilling, 10, 4);
            if ($check && $thun == $now) {
                $result = ['sts'=>'Id Billing Kadaluarsa'];

            }elseif ($check && strlen($idbilling) == 18) {
                if ($check[0]->validasi_dispenda) {
                    if (!$check[0]->validasi_bank) {
                        $data = $this->m_webservice->change_flag($idbilling);

                        if ($data['sts']) {
                            if ($data['row']) {
                                $result = [
                                    'sts' => '1',
                                    'ResponseCode' => '00',
                                    'msg' => 'Berhasil melakukan update data !'
                                ];
                            } else {
                                $result = [
                                    'sts' => '0',
                                    'ResponseCode' => '01',
                                    'msg' => 'Gagal melakukan update data !'
                                ];
                            }
                        } else {
                            $result = [
                                'sts' => '0',
                                'ResponseCode' => '01',
                                'msg' => 'Gagal melakukan update data !'
                            ];
                        }
                    } else {
                        $result = [
                            'sts' => '0',
                            'ResponseCode' => '02',
                            'msg' => 'Data sudah melakukan pembayaran !'
                        ];
                    }
                } else {
                    $result = [
                        'sts' => '0',
                        'ResponseCode' => '03',
                        'msg' => 'Data belum diverifikasi oleh Bapenda !'
                    ];
                }
            } else {
                $result = [
                    'sts' => '0',
                    'ResponseCode' => '04',
                    'msg' => 'Data tidak ditemukan !'
                ];
            }
        
        echo json_encode($result);
    }

}

/* End of file web_service.php */
/* Location: ./application/controllers/web_service.php */