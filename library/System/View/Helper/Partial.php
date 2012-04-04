<?php
/*
 * Created on 2011-3-10
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_Partial extends System_View_Helper_Abstract {

	protected $_themeLoader;

	protected $_partial;

	public function __construct() {
		$this->_themeLoader = System_Loader_Theme :: getInstance();
	}

	public function partial($modPath) {
		ob_start();
		readfile($this->_themeLoader->getSystemModPath($modPath));
		$this->_partial=ob_get_contents();
		ob_end_clean();
		return $this;
	}

	public function __toString(){
		return $this->_partial;
	}
}
?>