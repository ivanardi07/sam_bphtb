<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	
	$data_url = $uri.$_SERVER['REQUEST_URI'];

	$url = explode('assets', $data_url)[0];

	header('Location: '.$url);
	exit;
?>