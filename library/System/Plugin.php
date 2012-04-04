<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_Plugin {

	protected static $_loader;

	protected static $_plugins = array ();

	public static function trigger($directory, $method, $arg = null) {
		if (null === self :: $_loader) {
			self :: $_loader = System_Loader_App_Plugin :: getInstance();
		}
		if (self :: $_plugins = self :: $_loader->getPlugins($directory, $arg)) {
			self::_runPlugins($method);
		}
	}

	public static function reTrigger($method) {
		self::_runPlugins($method);
	}

	protected static function _runPlugins($method){
		self :: $_plugins-> $method ();
	}
}
?>