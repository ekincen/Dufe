<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
abstract class System_View_Element_Abstract {

	protected $_options = array ();

	public function setOptions($options) {
		$this->_options = array_merge($this->_options, $options);
		return $this;
	}

	public function getHtml(){
	}
}
?>