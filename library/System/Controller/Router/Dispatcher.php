<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_Controller_Router_Dispatcher extends System_Controller_Router_Abstract {

	protected $_loader;

	public function init() {
		$this->_loader = System_Loader_App_Component :: getInstance();
		$this->_loader->setApplicationPath($this->_invokeParam->_applicationPath)
		->setComponent($this->_response->_component);
	}

	public function run() {
		$this->dispatch($this->_response->_controller, $this->_response->_action);
	}

	public function dispatch($controller, $action) {
		$this->_loader->getController($controller, $action)->startMvc();
	}

	public function returnResponse() {
		return $this->_response;
	}
}
?>