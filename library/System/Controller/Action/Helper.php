<?php
/*
 * Created on 2011-5-6
 *
 * @author yijian.cen
 *
 */
class System_Controller_Action_Helper {

	private static $_instance;

	protected $_helper;

	const HELPER_DIRECTORY_NAME='Helper';

	const HELPER_FILE_EXT='.php';

	const HELPER_CLASS_PREFIX = 'System_Controller_Action_Helper_';

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

	public function getHelper($helper) {
		if (!isset ($this->_helper[$helper])) {
			include self::HELPER_DIRECTORY_NAME . DS . $helper . self::HELPER_FILE_EXT;
			$helperClass = self::HELPER_CLASS_PREFIX . $helper;
			$this->_helper[$helper] = new $helperClass ();
		}
		return $this->_helper[$helper];
	}
}
?>
