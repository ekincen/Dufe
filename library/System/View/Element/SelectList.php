<?php
class System_View_Element_SelectList extends System_View_Element_Abstract {

	public function __construct() {
		$this->_options = array (
			'value' => null,
			'listArr' => array (),
			'name' => null,
			'desc' => null
		);
	}

	public function getHtml() {

	}
}
?>