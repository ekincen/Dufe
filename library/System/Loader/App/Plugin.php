<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_Loader_App_Plugin extends System_Loader_App_Abstract {

	private static $_instance;

	protected $_filePath;

	protected $_pluginClass;

	const PLUGIN_DIRECTORY_NAME = 'plugin';

	const PLUGIN_CLASS_PREFIX = 'Plugin_';

	const PLUGIN_FILE_EXT = '.php';

	private function __construct() {
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null === self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	public function getPlugins($className, $arg) {
		$this->_pluginClass = ucfirst($className);
		$this->_filePath = $this->_applicationPath . DIRECTORY_SEPARATOR . self :: PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . $this->_pluginClass . self :: PLUGIN_FILE_EXT;
		if (is_file($this->_filePath)) {
			require $this->_filePath;
			$this->_pluginClass = self :: PLUGIN_CLASS_PREFIX . $this->_pluginClass;
			return new $this->_pluginClass($arg);
		}
	}
}
?>