<?php
/*
 * Created on 2011-3-11
 *
 * @author yijian.cen
 *
 */
class System_Session {

	protected static $_defaultExpiredTime = '259200'; //一个月(单位秒)

	const SESSION_NAME_FLAG = 'SID';

	public static function rememberMe($seconds = null) {
		$seconds = $seconds ? $seconds : self :: $_defaultExpiredTime;
		self :: rememberUntil($seconds);
	}

	public static function forgetMe() {
		self :: rememberUntil(0);
		session_destroy();
	}

	public static function start() {
		if (!isset ($_SESSION)) {
			if (isset($_POST[self :: SESSION_NAME_FLAG])&&$_POST[self :: SESSION_NAME_FLAG]) {
				session_id($_POST[self :: SESSION_NAME_FLAG]);
			}
			session_start();
		}
	}

	protected static function rememberUntil($seconds = 0) {
		$cookieParams = session_get_cookie_params();

		session_set_cookie_params($seconds, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure']);
                
                setcookie(session_name(), session_id(), time() + $seconds, $cookieParams['path']);
	}
}
?>