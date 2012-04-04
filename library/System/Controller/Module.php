<?php
/*
 * Created on 2011-3-26
 *
 * @author yijian.cen
 *
 */
 class System_Controller_Module{

 	private static $_instance;

 	protected $_loader;

 	protected $_modClass;

 	protected $_module;

 	const DEFAULT_ACTION='index';

	private function __construct() {
		$this->_getModuleLoader();
		return false;
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null === self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	protected function _getModuleLoader(){
		if(null===$this->_loader){
			$this->_loader=System_Loader_App_Module::getInstance();
		}
		return $this->_loader;
	}

	public function setApplicationPath($appPath){
		$this->_loader->setApplicationPath($appPath);
		return $this;
	}

	public function getModule($modname,$act=null){
		ob_start();
		if(!$this->_modClass=$this->_loader->getModuleClass($modname)){
			include $this->_loader->getModuleTemplate($modname,$modname.($act?'_'.$act:null));
		}else{
			$this->_runModule($modname,$act);
		}
		$this->_module=ob_get_contents();
		ob_end_clean();
		return $this->_module;
	}

	protected function _runModule($modname,$act=null){
		$act=$act?$act:self::DEFAULT_ACTION;
		return $this->_modClass->$act();
	}
 }
?>