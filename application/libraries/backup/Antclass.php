<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Antclass
{
    function __construct()
    {
        $this->CI = &get_instance();
    }

    function skin($view, $vars = '')
    {
        $dadata['child'] = $this->CI->load->view($view, $vars, TRUE);
        return $this->CI->load->view('v_skin', $dadata);
    }

    function go_log($query)
    {
        $this->CI->load->library('session');
        $this->CI->load->database();
        $id_log = date('YmdHisu');
        $pos_log = strpos($query, 'Login');
        if ($pos_log !== FALSE) {
            if ($pos_log == 0) {
                $this->CI->session->set_userdata('s_idlog', $id_log);
            }
        }
        $add_data = array(
            'id_log' => $id_log,
            'login_user' => $this->CI->session->userdata('s_username_bphtb'),
            'date_log' => date('Y-m-d H:i:s'),
            'query_log' => 'ID Log: ' . @$this->CI->session->userdata('s_idlog') . ' - ' . $query,
            'ip_log' => $_SERVER['REMOTE_ADDR']
        );
        $this->CI->db->insert('tbl_log', $add_data);
    }

    function auth_user()
    {
        $this->CI->load->library('session');
        if ($this->CI->session->userdata('s_id_user') == '') {
            redirect('bphtb');
        }
    }

    function go_upload($dafile, $path, $allow, $overwrite = 'FALSE', $maxw = '', $maxh = '')
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = $allow;
        $config['max_size'] = '999999999999';
        $config['max_width']  = $maxw;
        $config['max_height']  = $maxh;
        $config['overwrite']  = $overwrite;
        //$config['encrypt_name']  = TRUE;
        $this->CI->load->library('upload', $config);
        $this->CI->upload->initialize($config);
        if (!$this->CI->upload->do_upload($dafile)) {
            echo $this->CI->upload->display_errors();
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function go_thumb($path, $newpath, $twidth = '120', $theight = '120')
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['new_image'] = $newpath;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['thumb_marker'] = '';
        $config['quality'] = 100;
        $config['width'] = $twidth;
        $config['height'] = $theight;

        $this->CI->load->library('image_lib', $config);
        if (!$this->CI->image_lib->resize()) {
            //            echo $this->CI->image_lib->display_errors();
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function go_crop($path, $newpath)
    {
        $this->CI->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['new_image'] = $newpath;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = FALSE;
        $config['quality'] = 100;
        $config['width'] = '370';
        $config['height'] = '135';
        $info = getimagesize($path);
        $config['x_axis'] = $info[0] / 4;
        $config['y_axis'] = $info[1] / 4;

        $this->CI->image_lib->initialize($config);
        if (!$this->CI->image_lib->crop()) {
            //		    echo $this->CI->image_lib->display_errors();
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function link_image($string)
    {
        $nustring = preg_replace('/<img(.*?)src="(.*?)\/thumb\/(.*?)\/>/', '<a href="$2/real/$3" class="lightbox"><img$1src="$2/thumb/$3 /></a>', $string);
        return $nustring;
    }

    function back_value($value, $name)
    {
        if (empty($value)) {
            return set_value($name);
        } else {
            return form_prep($value);
        }
    }
    function back_valuex($value, $name)
    {
        if (empty($value)) {
            return isset($_POST[$name]) ? $_POST[$name] : '';
        } else {
            return form_prep($value);
        }
    }

    function remove_img($string)
    {
        $nustring = preg_replace('/<img*[^<>]*>/', '', $string);
        return $nustring;
    }

    function page_break($string, $id, $page, $next = '[ More ... ]')
    {
        $nustring = preg_replace('/<!-- pagebreak -->[\S\s]+/', '<a href="' . base_url() . $page . '/' . $id . '"> ' . $next . ' </a>', $string);
        return $nustring;
    }

    function remove_page_break($string)
    {
        $nustring = preg_replace('/<!-- pagebreak -->/', '', $string);
        return $nustring;
    }

    function remove_div($string)
    {
        $nustring = preg_replace('/<\/?div*[^<>]*>/', '', $string);
        return $nustring;
    }

    function remove_tag($string)
    {
        $nustring = preg_replace('/<\/?[a-z][a-z0-9]*[^<>]*>/', '', $string);
        return $nustring;
    }

    function fix_date($tglasal)
    {
        $tglasal = explode("-", $tglasal);
        $thn = $tglasal[0];
        $bln = $tglasal[1];
        $tgl = $tglasal[2];
        $tglasal = $tgl . '-' . $bln . '-' . $thn;
        return $tglasal;
    }

    function fix_datetime($tglwktasal)
    {
        $list = explode(' ', $tglwktasal);
        $tglwktasal = explode("-", $list[0]);
        $thn = $tglwktasal[0];
        $bln = $tglwktasal[1];
        $tgl = $tglwktasal[2];
        $tglwktasal = $tgl . '-' . $bln . '-' . $thn . ' ' . $list[1];
        return $tglwktasal;
    }

    function set_currency($currency, $decimal)
    {
        $nu_currency = number_format($currency, $decimal, ',', '.');
        return $nu_currency;
    }

    function kekata($x)
    {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = $this->kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->kekata($x / 10) . " puluh" . $this->kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x < 1000) {
            $temp = $this->kekata($x / 100) . " ratus" . $this->kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->kekata($x / 1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->kekata($x / 1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->kekata($x / 1000000000) . " milyar" . $this->kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = $this->kekata($x / 1000000000000) . " trilyun" . $this->kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim($this->kekata($x));
        } else {
            $hasil = trim($this->kekata($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

    function id_replace($str)
    {
        $pattern = array();
        $pattern[0] = '.';
        $pattern[1] = '_';
        return str_replace($pattern, '', $str);
    }

    function remove_separator($string, $separator = '.-')
    {
        return preg_replace("/[$separator]/", '', $string);
    }

    function add_nop_separator($string, $separator = '.')
    {
        $da_string = '';
        $da_string .= substr($string, 0, 2);
        $da_string .= $separator;
        $da_string .= substr($string, 2, 2);
        $da_string .= $separator;
        $da_string .= substr($string, 4, 3);
        $da_string .= $separator;
        $da_string .= substr($string, 7, 3);
        $da_string .= $separator;
        $da_string .= substr($string, 10, 3);
        $da_string .= $separator;
        $da_string .= substr($string, 13, 4);
        $da_string .= $separator;
        $da_string .= substr($string, 17, 1);
        return $da_string;
    }

    function add_ppat_separator($string, $separator = '.')
    {
        $da_string = '';
        $da_string .= substr($string, 0, 1);
        $da_string .= $separator;
        $da_string .= substr($string, 1, 7);
        $da_string .= $separator;
        $da_string .= substr($string, 8, 2);
        $da_string .= $separator;
        $da_string .= substr($string, 10, 2);
        $da_string .= $separator;
        $da_string .= substr($string, 12, 4);
        return $da_string;
    }

    function get_unique_code($length = '')
    {
        $code = md5(uniqid(rand(), true));
        if ($length != "") return substr($code, 0, $length);
        else return $code;
    }

    function generate_token($format = 'aaaaaaaaaa', $splitter = '-')
    {
        $split_format = explode($splitter, $format);
        $sid = '';
        foreach ($split_format as $split) {
            $len = strlen($split);
            $sid .= $this->get_unique_code($len) . '-';
        }
        return strtoupper(substr($sid, 0, -1));
    }

    function fix_name_file($s)
    {
        preg_match_all('!\.[0-9a-z]+$!', $s, $match);
        $extention = count($match[0]) > 0 ? $match[0][0] : "";
        $file_name = str_replace(".", "_", ($extention == "" ? NULL : explode($extention, $s)[0]));
        return $file_name . $extention;
    }
}
