<?php
/*
 * Created on 2011-3-3
 *
 * @author yijian.cen
 *
 */
class System_Loader_App_Component extends System_Loader_App_Abstract {

	private static $_instance;

	protected $_controller;

	protected $_action;

	protected $_componentPath;

	protected $_ctrlClassName;

	protected $_modelClassName;

	protected $_modelFileName;

	protected $_viewPath;

	const COMPONENT_ROOT_NAME = 'component';

	const COMPONENT_DIRECTORY_PREFIX = 'com_';

	const CONTROLLER_DIRECTORY_NAME = 'controller';

	const CONTROLLER_CLASS_POSTFIX = 'Controller';

	const CONTROLLER_FILE_EXT = '.php';

	const VIEW_DIRECTORY_NAME = 'view';

	const VIEW_FILE_EXT = '.phtml';

	const MODEL_DIRECTORY_NAME = 'model';

	const MODEL_CLASS_PREFIX = 'Model';

	const MODEL_FILE_PREFIX = 'mdl.';

	const MODEL_FILE_EXT = '.php';

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

	public function setComponent($component) {
		$this->_componentPath = $this->_getComponentPath($component);
		return $this;
	}

	public function getComponentPath(){
		return $this->_componentPath;
	}

	public function getViewPath(){
		return  $this->_componentPath . DIRECTORY_SEPARATOR . self :: VIEW_DIRECTORY_NAME;
	}

	public function getController($controller, $action = null) {
		return $this->_setController($controller)->_setCtrlClassName($controller)->_loadController()->_getController($action);
	}

	public function getTemplatePath($template) {
		return $this->_setViewPath()->_getTemplatePath($template);
	}

	public function getModel($model,$component) {
		return $this->_setModelClassName($model)->_setModelFileName($model)->_loadModel($component)->_getModel($component);
	}

	protected function _setController($controller){
		$this->_controller=$controller;
		return $this;
	}

	protected function _setCtrlClassName($controller) {
		$this->_ctrlClassName = ucfirst($controller) . self :: CONTROLLER_CLASS_POSTFIX;
		return $this;
	}

	protected function _loadController() {
		if(!is_file($file=$this->_componentPath. DIRECTORY_SEPARATOR . self :: CONTROLLER_DIRECTORY_NAME . DIRECTORY_SEPARATOR . $this->_ctrlClassName . self :: CONTROLLER_FILE_EXT))
		throw new Exception("$file does not exists.");
		require $file;
		return $this;
	}

	protected function _getController($action) {
		return new $this->_ctrlClassName($action);
	}

	protected function _setViewPath() {
		$this->_viewPath = $this->_componentPath . DIRECTORY_SEPARATOR . self :: VIEW_DIRECTORY_NAME;
		return $this;
	}

	protected function _getTemplatePath($template) {
		return $this->_viewPath . DIRECTORY_SEPARATOR . ($template ? $template : $this->_controller) . self :: VIEW_FILE_EXT;
	}

	protected function _setModelClassName($model) {
		$this->_modelClassName = self :: MODEL_CLASS_PREFIX . ucfirst($model);
		return $this;
	}

	protected function _setModelFileName($model) {
		$this->_modelFileName = self :: MODEL_FILE_PREFIX . $model . self :: MODEL_FILE_EXT;
		return $this;
	}

	protected function _LoadModel($component) {
		$componentPath =$component?$this->_getComponentPath($component):$this->_componentPath;
		require $componentPath.DIRECTORY_SEPARATOR . self :: MODEL_DIRECTORY_NAME . DIRECTORY_SEPARATOR . $this->_modelFileName;
		return $this;
	}

	protected function _getModel($component) {
		return new $this->_modelClassName($component);
	}

	protected function _getComponentPath($component){
		return $this->_applicationPath . DIRECTORY_SEPARATOR . self :: COMPONENT_ROOT_NAME . DIRECTORY_SEPARATOR . self :: COMPONENT_DIRECTORY_PREFIX . $component;
	}
}
?>