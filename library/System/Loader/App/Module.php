<?php

/*
 * Created on 2011-3-22
 *
 * @author yijian.cen
 *
 */
class System_Loader_App_Module extends System_Loader_App_Abstract {

	private static $_instance;

	protected $_modRoot;

	const MODULE_DIRECTORY_NAME='module';

	const MODULE_NAME_PREFIX='mod_';

	const MODULE_INDEX_FILE='index.php';

	const MODULE_CLASS_POSTFIX='Module';

	const MODULE_TEMPLATE_DIRECTORY_NAME='tpl';

	const MODULE_TEMPLATE_FILE_EXT='.phtml';

	const MODULE_MODEL_DIRECTORY_NAME='model';

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

	public function getModulePath($modname){
		return $this->_modRoot.DIRECTORY_SEPARATOR.$this->_getModuleDirectory($modname);
	}

	/**
	 * 模块模型位置：app_path/module/mod_模块名称/model/mdl.模型名称.php
	 **/
	public function getModel($model,$modname){
		require $this->getModulePath($modname).DIRECTORY_SEPARATOR.self::MODEL_DIRECTORY_NAME.DS.self::MODEL_FILE_PREFIX.$model.self::MODEL_FILE_EXT;
		$modelName=self::MODEL_CLASS_PREFIX.ucfirst($model);
		return new $modelName();
	}

	/**
	 * 模块类位置：app_path/module/mod_模块名称/index.php
	 **/
	public function getModuleClass($modname){
		$this->_modRoot=$this->_applicationPath.DIRECTORY_SEPARATOR.self::MODULE_DIRECTORY_NAME;
		$classPath=$this->getModulePath($modname).DIRECTORY_SEPARATOR.self::MODULE_INDEX_FILE;
		if(file_exists($classPath)){
			require $classPath;
			$modclass=ucfirst($modname).self::MODULE_CLASS_POSTFIX;
		    return new $modclass($this,$modname);
		}else return null;
	}

	/**
	 * 模块模板位置:app_path/module/mod_模块名称/tpl/模板名称.phtml
	 **/
	public function getModuleTemplate($modname,$tpl){
		return $this->getModulePath($modname).DIRECTORY_SEPARATOR.
		self::MODULE_TEMPLATE_DIRECTORY_NAME.DIRECTORY_SEPARATOR.
		$tpl.self::MODULE_TEMPLATE_FILE_EXT;
	}

	protected function _getModuleDirectory($modname){
		return self::MODULE_NAME_PREFIX.$modname;
	}
}
?>