<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */
class System_Controller_Front {

	public $themePath;

	public $template;

	private static $_instance;

	protected $_invokeParam;

	protected $_response;

	protected $_applicationPath;

	protected $_defaultComponent = 'index';

	protected $_defaultController = 'index';

	protected $_defaultAction = 'index';

	const DEFAULT_COMPONENT_KEY = '_defaultComponent';

	const DEFAULT_CONTROLLER_KEY = '_defaultController';

	const DEFAULT_ACTION_KEY = '_defaultAction';

	const APPLICATION_PATH_KEY = '_applicationPath';

	private function __construct() {
		$this->_invokeParam = new stdClass();
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null === self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	public function setApplicationPath($applicationPath) {
		$this->_applicationPath = $applicationPath;
		return $this;
	}

	public function setDefaultComponent($component) {
		$this->_defaultComponent = $component;
		return $this;
	}

	public function setThemePath($themePath) {
		$this->themePath=$themePath;
		return $this;
	}

	public function setTemplate($template) {
		$this->template=$template;
		return $this;
	}

	public function getResponse(){
		return $this->_response;
	}

	public function getApplicationPath(){
		return $this->_applicationPath;
	}

	public function run() {
		$this->_setPluginLoader()->_analyzeUri()->_dispatch();
	}

	protected function _setPluginLoader() {
		System_Loader_App_Plugin :: getInstance()->setApplicationPath($this->_applicationPath);
		return $this;
	}

	protected function _analyzeUri() {
		$this->_router = new System_Controller_Router_UriAnalyzer();
		$this->_setParams(array (
			self :: DEFAULT_COMPONENT_KEY => $this->_defaultComponent,
			self :: DEFAULT_CONTROLLER_KEY => $this->_defaultController,
			self :: DEFAULT_ACTION_KEY => $this->_defaultAction
		))->_runRouter();
		return $this;
	}

	protected function _dispatch() {
		$this->_router = new System_Controller_Router_Dispatcher();
		$this->_setParam(self :: APPLICATION_PATH_KEY, $this->_applicationPath)->_runRouter();
		return $this;
	}

	protected function _runRouter() {
		$this->_router->initset($this->_response, $this->_invokeParam);
		$this->_router->run();
		$this->_response = $this->_router->returnResponse();
		return $this;
	}

	protected function _setParam($key, $val) {
		$this->_invokeParam-> $key = $val;
		return $this;
	}

	protected function _setParams(array $arr) {
		foreach ($arr as $key => $val) {
			$this->_invokeParam-> $key = $val;
		}
		return $this;
	}
}
?>