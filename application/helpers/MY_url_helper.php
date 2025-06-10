<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Base URL
 *
 * Returns the "base_url" item from your config file
 *
 * @access	public
 * @return	string
 */

if (!function_exists('base_url')) {
	// function base_url()
	// {
	// 	$CI =& get_instance();
	// 	return $CI->config->slash_item('base_url');
	// }

	function base_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->base_url($uri, $protocol);
	}
}

if (!function_exists('base_url_img')) {
	function base_url_img()
	{
		$CI = &get_instance();
		return $CI->config->slash_item('base_url') . 'assets/images/';
	}
}

if (!function_exists('base_url_js')) {
	function base_url_js()
	{
		$CI = &get_instance();
		return $CI->config->slash_item('base_url') . 'assets/scripts/';
	}
}

if (!function_exists('base_url_css')) {
	function base_url_css()
	{
		$CI = &get_instance();
		return $CI->config->slash_item('base_url') . 'assets/css/';
	}
}


/* End of file my_url_helper.php */