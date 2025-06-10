<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quotes
{
    function __construct()
    {
    }
    function clean($params)
    {
        $result  = '';
        $search  = array("'", '"');
        $replace = array("", "");
        if (!empty($params)) {
            $result = str_replace($search, $replace, trim($params));
        }
        return $result;
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
}
