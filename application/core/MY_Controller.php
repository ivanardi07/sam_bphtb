<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->produk = "BPHTB";

        // ====================== AKTIVASI APP ===============================================================

        // if (@$_POST['aktifkan']) {
        //     $this->aktifkan();
        // } else {
        //     $this->check_activate();
        // }

        // ====================== END AKTIVASI APP ===============================================================

        $this->load->model('mod_user', 'auth');
        $this->output->enable_profiler(false);
        if (!@$this->db->conn_id) {
            exit('Sorry, you can\'t connect to database.  Contact your database administrator.');
        }

        $user = $this->session->userdata('s_id_user');

        if (!$user) {
            redirect('bphtb');
        }

        // $status = $this->cekakses($user, curUrl());
        // if ($status == true) {

        // } else {
        //     $data['title']       = 'SIM PBB';
        //     $data['form_title']  = 'Selamat Datang';
        //     $data['form_button'] = '';
        //     echo $this->template->display('ijin', $data, true);
        //     exit;
        // }
    }

    /*function check_activate()
    {
    $_IP_SERVER = $_SERVER['SERVER_ADDR'];
    $_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
    // ambil mac address mesin
    ob_start();
    system('wmic cpu get ProcessorId');
    $_PERINTAH2  = ob_get_contents();
    ob_clean();
    $_PECAH2 = str_replace("ProcessorId",NULL, trim($_PERINTAH2));


    $acak=strtoupper(md5(trim($_PECAH2)));
    //------ masukkan data ke file ini -------//
    $sn = strtoupper(md5(md5(md5($acak))));

    //echo file_exists("id.ini");
    //exit();
    if(file_exists("id.ini") == ''){
    $tes = fopen("id.ini", "w");
    $replace="aktif=0;id=0;sn=0;idlast=0;snlast=0;";
    fwrite($tes,$replace);
    fclose($tes);
    }

    $str=implode("", file("id.ini"));
    $fo = fopen("id.ini", "w");
    $strid=str_replace("id=0", "id=".$acak,$str);
    $pecahstr = explode(";", $strid);
    $replace =str_replace($pecahstr[2], "sn=".$sn,$strid);
    fwrite($fo,$replace);
    fclose($fo);

    //----------------------------------------//

    $buka = fopen(base_url()."id.ini", "r");

    $baris = fgets($buka);
    $datas = explode(";",$baris);
    $idawal = explode("=", $datas[1]);
    $snawal = explode("=", $datas[2]);
    $idakhir = explode("=", $datas[3]);
    $snakhir = explode("=", $datas[4]);
    fclose($buka);

    if($acak != $idakhir[1] || $sn != $snakhir[1] || ($idakhir[1] != $acak || $snakhir[1] != $sn)){
    $flash_msg = $this->session->flashdata("flash_msg","Gagal");
    if(empty($flash_msg))
    {
    $flash_msg = "Silahkan Melakukan Aktivasi";
    }
    $idawal = $acak;
    echo '
    <form style="width:450px;font-family:Tahoma; border:solid 1px #CCC;padding:10px; margin: 10px auto;" method="POST" action="#" >
    <h3 style="margin:0px;">Aktivasi</h3>
    <div style="display:block; margin: 10px;padding:5px; background-color: yellow;color: red;">' . @$flash_msg . '</div>
    <div style="width:100%;float:left;margin:5px 0px;">
    <div style="float:left;width:120px;padding:7px 0px;">ID Aktivasi &nbsp&nbsp&nbsp&nbsp&nbsp:</div>
    <div style="float:left;margin-top:7px;">
    <input style="padding:10px; border: #ccc solid 1px;width:300px;" type="hidden" placeholder="" name="id_mesin" id="userid" value="' . substr($idawal, 0,8)."-".substr($idawal, 8,8)."-".substr($idawal, 16,8)."-".substr($idawal, 24,8) . '"/>
    ' . substr($idawal, 0,8)."-".substr($idawal, 8,8)."-".substr($idawal, 16,8)."-".substr($idawal, 24,8) . '
    </div>
    </div>
    <div style="width:100%;float:left;">
    <div style="float:left;width:120px;padding:7px 0px;">Serial Number :</div>
    <div style="float:left;">
    <input  style="padding:10px; border: #ccc solid 1px;width:300px;" type="text" placeholder="" name="id" id="userid" autocomplete="off"/>
    </div>
    </div>
    <div style="">
    <button type="submit" style="width:100%;padding:5px;margin-top:5px;border: #ccc solid 1px;font-weight:bold;" value="aktifkan" name="aktifkan">
    Aktifkan <i class="m-icon-swapright m-icon-white"></i>
    </button>
    </div>
    </form>';
    exit();
    }
    }
    function aktifkan()
    {
    $buka = fopen(base_url()."id.ini", "r");

    $baris = fgets($buka);
    $datas = explode(";",$baris);

    $idawal = explode("=", $datas[1]);
    $snawal = explode("=", $datas[2]);
    $idakhir = explode("=", $datas[3]);
    $snakhir = explode("=", $datas[4]);

    fclose($buka);

    ob_start();
    system('wmic cpu get ProcessorId');
    $_PERINTAH2  = ob_get_contents();
    ob_clean();
    $_PECAH2 = str_replace("ProcessorId",NULL, trim($_PERINTAH2));


    $acak=strtoupper(md5(trim($_PECAH2)));
    //------ masukkan data ke file ini -------//
    $sn = strtoupper(md5(md5(md5($acak))));

    $md5an = md5(strtolower($this->input->post("id")));
    if($sn == strtoupper($md5an))
    {
    $str=implode("", file("id.ini"));
    $fo = fopen("id.ini", "w");
    $str1=str_replace($datas[4], "snlast=".strtoupper($md5an),$str);
    $str2=str_replace($datas[3], "idlast=".str_replace("-",'',$this->input->post("id_mesin")),$str1);
    fwrite($fo,$str2);
    fclose($fo);
    redirect($_SERVER['HTTP_REFERER']);
    }
    else
    {
    $this->session->set_flashdata("flash_msg","Gagal, Silahkan Masukkan Serial Yang Telah Terdaftar");
    redirect($_SERVER['HTTP_REFERER']);
    }
    }*/
    public function check_activate()
    {
        $_IP_SERVER  = $_SERVER['SERVER_ADDR'];
        $_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
        // ambil mac address mesin
        ob_start();
        system('wmic cpu get ProcessorId');
        $_PERINTAH2 = ob_get_contents();
        ob_clean();
        $_PECAH2 = str_replace("ProcessorId", null, trim($_PERINTAH2));

        //echo file_exists("id.ini");
        //exit();
        if (file_exists("id.ini") == '') {
            $acak = strtoupper(md5(trim($_PECAH2)));
            //------ masukkan data ke file ini -------//
            $sn = strtoupper(md5(md5(md5($acak))));

            $tes     = fopen("id.ini", "w");
            $replace = "aktif=0;id=0;sn=0;idlast=0;snlast=0;";
            fwrite($tes, $replace);
            fclose($tes);

            $str      = implode("", file("id.ini"));
            $fo       = fopen("id.ini", "w");
            $strid    = str_replace("id=0", "id=" . $acak, $str);
            $pecahstr = explode(";", $strid);
            $replace  = str_replace($pecahstr[2], "sn=" . $sn, $strid);
            fwrite($fo, $replace);
            fclose($fo);

            $buka = fopen(base_url() . "id.ini", "r");

            $baris   = fgets($buka);
            $datas   = explode(";", $baris);
            $produk  = explode("=", $datas[0]);
            $idawal  = explode("=", $datas[1]);
            $snawal  = explode("=", $datas[2]);
            $idakhir = explode("=", $datas[3]);
            $snakhir = explode("=", $datas[4]);
            fclose($buka);
        } else {
            $buka = fopen(base_url() . "id.ini", "r");

            $baris   = fgets($buka);
            $datas   = explode(";", $baris);
            $produk  = explode("=", $datas[0]);
            $idawal  = explode("=", $datas[1]);
            $snawal  = explode("=", $datas[2]);
            $idakhir = explode("=", $datas[3]);
            $snakhir = explode("=", $datas[4]);
            fclose($buka);

            $acak = strtoupper(md5(trim($_PECAH2)));
            //------ masukkan data ke file ini -------//
            $sn = strtoupper(md5(md5(md5($acak . $produk[1]))));
        }
        //----------------------------------------//

        if ($acak != $idakhir[1] || $sn != $snakhir[1] || ($idakhir[1] != $acak || $snakhir[1] != $sn)) {
            $flash_msg = $this->session->flashdata("flash_msg", "Gagal");
            if (empty($flash_msg)) {
                $flash_msg = "Silahkan Melakukan Aktivasi";
            }
            $idawal = $acak;
            echo '
            <form style="width:450px;font-family:Tahoma; border:solid 1px #CCC;padding:10px; margin: 10px auto;" method="POST" action="#" >
                <h3 style="margin:0px;">Aktivasi</h3>
                <div style="display:block; margin: 10px;padding:5px; background-color: yellow;color: red;">' . @$flash_msg . '</div>
                <div style="width:100%;float:left;display:none">
                    <div style="float:left;width:120px;padding:7px 0px;">Produk &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:</div>
                    <div style="float:left;margin:5px 0px;">
                        <input type="text" name="produk" value=' . $this->produk . '>
                    </div>
                </div>
                <div style="width:100%;float:left;margin:5px 0px;">
                    <div style="float:left;width:120px;padding:7px 0px;">ID Aktivasi &nbsp&nbsp&nbsp&nbsp&nbsp:</div>
                    <div style="float:left;margin-top:7px;">
                        <input style="padding:10px; border: #ccc solid 1px;width:300px;" type="hidden" placeholder="" name="id_mesin" id="userid" value="' . substr($idawal, 0, 8) . "-" . substr($idawal, 8, 8) . "-" . substr($idawal, 16, 8) . "-" . substr($idawal, 24, 8) . '"/>
                        ' . substr($idawal, 0, 8) . "-" . substr($idawal, 8, 8) . "-" . substr($idawal, 16, 8) . "-" . substr($idawal, 24, 8) . '
                    </div>
                </div>
                <div style="width:100%;float:left;">
                    <div style="float:left;width:120px;padding:7px 0px;">Serial Number :</div>
                    <div style="float:left;">
                        <input  style="padding:10px; border: #ccc solid 1px;width:300px;" type="text" placeholder="" name="id" id="userid" autocomplete="off"/>
                    </div>
                </div>
                <div style="">
                    <button type="submit" style="width:100%;padding:5px;margin-top:5px;border: #ccc solid 1px;font-weight:bold;" value="aktifkan" name="aktifkan">
                        Aktifkan <i class="m-icon-swapright m-icon-white"></i>
                    </button>
                </div>
            </form>';
            exit();
        }
    }
    public function aktifkan()
    {
        $buka = fopen(base_url() . "id.ini", "r");

        $baris = fgets($buka);
        $datas = explode(";", $baris);

        $idawal  = explode("=", $datas[1]);
        $snawal  = explode("=", $datas[2]);
        $idakhir = explode("=", $datas[3]);
        $snakhir = explode("=", $datas[4]);

        fclose($buka);

        ob_start();
        system('wmic cpu get ProcessorId');
        $_PERINTAH2 = ob_get_contents();
        ob_clean();
        $_PECAH2 = str_replace("ProcessorId", null, trim($_PERINTAH2));

        $acak = strtoupper(md5(trim($_PECAH2)));

        //------ masukkan data ke file ini -------//
        $sn = strtoupper(md5(md5(md5($acak . $this->input->post("produk")))));

        $md5an = md5(strtolower($this->input->post("id")));
        /*echo $md5an."<br>";
        print_r($sn2);
        exit();*/
        if ($sn == strtoupper($md5an)) {
            $str  = implode("", file("id.ini"));
            $fo   = fopen("id.ini", "w");
            $str1 = str_replace($datas[4], "snlast=" . strtoupper($md5an), $str);
            $str2 = str_replace($datas[3], "idlast=" . str_replace("-", '', $this->input->post("id_mesin")), $str1);
            $str3 = str_replace($datas[2], "sn=" . strtoupper($sn), $str2);
            $str4 = str_replace($datas[0], "aktif=" . $this->input->post("produk"), $str3);
            fwrite($fo, $str4);
            fclose($fo);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata("flash_msg", "Gagal, Silahkan Masukkan Serial Yang Telah Terdaftar");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function cekakses($user, $url)
    {

        if ($this->auth->isallow($user, $url)) {
            return true;
        }
        return false;
    }
}
