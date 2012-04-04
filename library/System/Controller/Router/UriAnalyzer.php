<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_Controller_Router_UriAnalyzer extends System_Controller_Router_Abstract {

	protected $_uriComponent;

	protected $_defaultComponent;

	protected $_defaultController;

	protected $_defaultAction;

	public function init() {
		$this->_defaultComponent = $this->_invokeParam->_defaultComponent;
		$this->_defaultController=$this->_invokeParam->_defaultController;
		$this->_defaultAction=$this->_invokeParam->_defaultAction;
	}

	public function run() {
		$this->_getUriComponent();
		$this->_analyze();
	}

	public function returnResponse() {
		$this->_response = new stdClass();
		$this->_response->_component = $this->_component;
		$this->_response->_controller = $this->_controller;
		$this->_response->_action = $this->_action;
		return $this->_response;
	}

	protected function _getUriComponent() {
		preg_match_all('|(?<=[\/])[\w]+|i', $_SERVER['REQUEST_URI'], $this->_uriComponent, PREG_PATTERN_ORDER);
		$this->_uriComponent = $this->_uriComponent[0];
	}

	protected function _analyze() {
		$this->_component = isset ($this->_uriComponent[0]) ? strtolower($this->_uriComponent[0]) : $this->_defaultComponent;
		$this->_controller = isset ($this->_uriComponent[1]) ? strtolower($this->_uriComponent[1]) : $this->_defaultController;
		$this->_action = isset ($this->_uriComponent[2]) ? strtolower($this->_uriComponent[2]) : $this->_defaultAction;
	}
}
?>