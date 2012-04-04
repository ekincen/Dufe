<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
abstract class System_Controller_Action_Abstract {

	public $view;

	protected $_identity;

	protected $_request;

	protected $_action;

	protected $_loader;

	protected $_modLoader;

	protected $_basePath;

	protected $_cssPath;

	protected $_jsPath;

	const ASSETS_DIRECTORY = 'assets';

	public function __construct($action = null) {
		ob_start();
		$this->_loader = System_Loader_App_Component :: getInstance();
		$this->_action = $action;
		$this->_setView()->_setRequest()->_setBasicPath()->_setAuth();
		$this->init();
	}

	public function init() {
	}

	public final function startMvc() {
		$action = $this->_action;
		$this-> $action ();
	}

	public function render($template = null, $is_absolute_path = false) {
		$controllerContent = ob_get_contents();
		ob_end_clean();
		$this->view->render($template, $is_absolute_path, $controllerContent);
		exit();
	}

	public final function getController($controller) {
		return $this->_loader->getController($controller);
	}

	public final function getModel($model,$component=null) {
		return $this->_loader->getModel($model,$component);
	}

	public final function getModule($modname,$act){
		return $this->_getModLoader()->getModule($modname,$act);
	}

	public final function redispatch($component,$controller,$action){
		$this->_loader->setComponent($component)
		->getController($controller, $action)
		->startMvc();
		exit();
	}

	public function __call($function, $args) {
		throw new Exception("Undefined function : $function");
	}

	public function jsonEncode($data){
		return '('.json_encode($data).')';
	}

	protected function _redirect($location) {
		header("location:$location");
	}

	protected function _getModLoader(){
		if(!$this->_modLoader){
			$this->_modLoader=System_Controller_Module::getInstance()
 			->setApplicationPath($this->_loader->getApplicationPath());
		}
		return $this->_modLoader;
	}

	protected function _setView() {
		$this->view = new System_View_Renderer($this->_loader);
		return $this;
	}

	protected function _setRequest() {
		$this->_request = new System_Controller_Request_Http();
		return $this;
	}

	protected function _setBasicPath() {
		$this->_basePath = $this->_loader->getComponentPath();
		$this->_cssPath = $this->_basePath . DIRECTORY_SEPARATOR . self :: ASSETS_DIRECTORY . DIRECTORY_SEPARATOR . 'css';
		$this->_jsPath = $this->_basePath . DIRECTORY_SEPARATOR . self :: ASSETS_DIRECTORY . DIRECTORY_SEPARATOR . 'js';
		return $this;
	}

	protected function _setAuth(){
		$this->_identity = System_Auth :: getInstance()->getIdentity();
		if (!System_Acl :: getInstance()->isAllowed($this->_identity->role, 'portal')){
			$this->redispatch('portal','portal','index');
		}
	}
}
?>