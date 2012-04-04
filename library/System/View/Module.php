<?php
/*
 * Created on 2011-3-26
 *
 * @author yijian.cen
 *
 */
class System_View_Module extends System_View_Abstract {

	protected $_loader;

	public function __construct($loader) {
		$this->_loader = $loader;
	}

	public function assign($arg1, $arg2 = null) {
		if (is_array($arg1)) {
			foreach ($arg1 as $key => $val) {
				$this-> $key = $val;
			}
		} else {
			$this-> $arg1 = $arg2;
		}
		return $this;
	}

	public function render($modname,$tpl) {
		include $this->_loader->getModuleTemplate($modname,$tpl);
	}
}
?>