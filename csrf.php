<?php

	if(!function_exists('hash_equals')) {
		function hash_equals($str1, $str2) {
		if(strlen($str1) != strlen($str2)) {
			return false;
		} else {
			$res = $str1 ^ $str2;
			$ret = 0;
			for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
			return !$ret;
		}
		}
	}
	//create a key for hash_hmac function
	if (empty($_SESSION['key']))
		$_SESSION['key'] = bin2hex(rand(32,32));// random_bytes(32) for PHP 5.6 above 

	//create CSRF token
	$csrf = hash_hmac('sha256', 'this is some string: index.php', $_SESSION['key']);
?>