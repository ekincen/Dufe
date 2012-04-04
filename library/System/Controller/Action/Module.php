<?php
/*
 * Created on 2011-3-26
 *
 * @author yijian.cen
 *
 */
class System_Controller_Action_Module {

	public $view;

	protected $_loader;

	protected $_modname;

	protected $_request;

	protected $_cssPath;

	protected $_jsPath;

	const ASSETS_DIRECTORY = 'assets';

	public function __construct($loader, $modname) {
		$this->_loader = $loader;
		$this->_modname = $modname;
		$this->_setView()->_setRequest()->_setBasicPath();
		$this->init();
	}

	public function init() {
	}

	public function index() {
	}

	public function render($tpl = null) {
		$this->view->render($this->_modname, $tpl ? $tpl : $this->_modname);
	}

	public function getModel($model) {
		return $this->_loader->getModel($model, $this->_modname);
	}

	public function jsonEncode($data){
		return '('.json_encode($data).')';
	}

	protected function _setBasicPath() {
		$this->_basePath = $this->_loader->getModulePath($this->_modname);
		$this->_cssPath = $this->_basePath . DIRECTORY_SEPARATOR . self :: ASSETS_DIRECTORY . DIRECTORY_SEPARATOR . 'css';
		$this->_jsPath = $this->_basePath . DIRECTORY_SEPARATOR . self :: ASSETS_DIRECTORY . DIRECTORY_SEPARATOR . 'js';
		return $this;
	}

	protected function _setView() {
		$this->view = new System_View_Module($this->_loader);
		return $this;
	}

	protected function _setRequest(){
		$this->_request=new System_Controller_Request_Http();;
		return $this;
	}
}
?>