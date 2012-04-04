<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_View_Layout extends System_View_Abstract {

	public $content;

	private static $_instance;

	protected $_view;

	protected $_controllerFront;

	protected $_themeLoader;

	protected $_theme;

	protected $_template;

	protected $_themePath;

	private function __construct() {
		$this->_controllerFront=System_Controller_Front::getInstance();
		$this->_themeLoader=System_Loader_Theme::getInstance();
		$this->_initThemeLoader();
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null === self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	public function setView($view){
		$this->_view=$view;
		return $this;
	}

	public function setTemplate($theme,$template){
		$this->_theme=$theme;
		$this->_template=$template;
		return $this;
	}

	public function setContent($content){
		$this->content=$content;
		return $this;
	}

	public function getLayout($use_component_layout=false){
		$this->_theme=$this->_theme?$this->_theme:$this->_controllerFront->template;
		$this->_themePath=$use_component_layout?$this->_themeLoader->getComponentTemplatePath($this->_theme):$this->_themeLoader->getSystemTemplatePath($this->_theme,$this->_template);
		include $this->_themePath;
	}

	public function __get($arg){
		return $this->_view->{$arg};
	}

	protected function _initThemeLoader(){
		$this->_themeLoader->setThemePath($this->_controllerFront->themePath);
	}

}
?>