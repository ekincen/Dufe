<?php
/*
 * Created on 2011-2-27
 *
 * @author yijian.cen
 *
 */
class System_Controller_Request_Http {

	public function isXmlHttpRequest() {
		return true;
	}

	public function getGet($key = null, $default = null) {
		if ($key) {
			return isset ($_GET[$key]) ? trim($_GET[$key]) : $default;
		}
		return $_GET;
	}

	public function getPost($key = null, $default = null) {
		if ($key) {
			return isset ($_POST[$key]) ? trim($_POST[$key]) : $default;
		}
		return $_POST;
	}
}
?>