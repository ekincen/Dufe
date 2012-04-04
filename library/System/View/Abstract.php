<?php
/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
abstract class System_View_Abstract {

	protected $_helperClass;

	protected $_helper = array ();

	const HELPER_CLASS_PREFIX = 'System_View_Helper_';

	public function __call($method, $args = array ()) {
		if (!isset ($this->_helper[$method])) {
			$this->_helperClass = self :: HELPER_CLASS_PREFIX . ucfirst($method);
			if (class_exists($this->_helperClass)) {
				$this->_helper[$method] = new $this->_helperClass();
				$this->_helper[$method]->setView($this);
			} else {
				throw new Exception("Function : '$function' does not exists.");
			}
		}
		return call_user_func_array(array (
			$this->_helper[$method],
			$method
		), $args);
	}
}
?>