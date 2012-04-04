<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_Loader_Theme{

	private static $_instance;

	protected $_themePath;

	const DEFAULT_TEMPLATE='index';

	const TEMPLATE_FILE_EXT='.phtml';

	const THEME_DIRECTORY_NAME='theme';

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

	public function setThemePath($themePath){
		$this->_themePath=$themePath;
		return $this;
	}

	/**
	 * 系统模板路径：系统根目录/theme/模板名称/index.phtml
	 **/
	public function getSystemTemplatePath($theme,$template=self::DEFAULT_TEMPLATE){
		return $this->_themePath.DIRECTORY_SEPARATOR.$theme.DIRECTORY_SEPARATOR.$template.self::TEMPLATE_FILE_EXT;
	}

	/**
	 * 组件模板路径：组件目录/theme/模板名称.phtml
	 **/
	public function getComponentTemplatePath($template=self::DEFAULT_TEMPLATE){
		return System_Loader_App_Component::getInstance()->getComponentPath().DIRECTORY_SEPARATOR.self::THEME_DIRECTORY_NAME.DIRECTORY_SEPARATOR.$template.self::TEMPLATE_FILE_EXT;
	}

	/**
	 * 系统模板模块路径：/theme/模块.phtml
	 **/
	public function getSystemModPath($modPath=self::DEFAULT_TEMPLATE){
		return $this->_themePath.DIRECTORY_SEPARATOR.$modPath.self::TEMPLATE_FILE_EXT;
	}
}
?>