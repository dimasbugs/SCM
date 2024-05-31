<?php
	function validate_email($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		else {
			return "* Email Invalid ";
		}
	}
	function validate_name($name) {
		if(preg_match("/^[a-zA-Z ]{2,50}$/",$name)) {
			return true;
		}
		else {
			return "* Nama Invalid";
		}
	}
	function validate_password($password) {
		if(strlen($password) > 4 && strlen($password) < 31) {
			return true;
		}
		else {
			return "* Gunakan 5-30 karakter";
		}
	}
	function validate_phone($phone) {
		if(preg_match("/^[0-9]{10,12}$/",$phone)) {
			return true;
		}
		else {
			return "* No. telp Invalid";
		}
	}
	function validate_number($number) {
		if(preg_match("/^[0-9]*$/",$number)) {
			return true;
		}
		else {
			return "* Nomor Invalid ";
		}
	}
	function validate_price($price) {
		if(preg_match("/^[0-9.]*$/",$price)) {
			return true;
		}
		else {
			return "* Harga Invalid ";
		}
	}
	function validate_username($username) {
		if(preg_match("/^[a-zA-Z0-9]{5,14}$/",$username)) {
			return true;
		}
		else {
			return "* 5-14 karakter, gunakan huruf dan angka saja";
		}
	}
?>