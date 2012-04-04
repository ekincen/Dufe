<?php
/*
 * Created on 2011-2-22
 *
 * @author yijian.cen
 *
 */
class System_View_Renderer extends System_View_Abstract {

	public $use_component_layout = false;

	public $setLayout = true;

	protected $_loader;

	protected $_viewPath;

	protected $_templateDirectory = null;

	protected $_templatePath;

	protected $_viewLayout;

	protected $_layoutTheme;

	protected $_layoutTemplate='index';

	protected $_content;

	public function __construct($ctrlLoader) {
		$this->_loader=$ctrlLoader;
	}

	public function assign($arg1, $arg2 = null) {
		if (is_array($arg1)) {
			foreach ($arg1 as $key => $val) {
				$this-> $key = $val;
			}
		} else {
			$this-> $arg1 = $arg2;
		}
		return $this;
	}

	public function render($template = null, $is_absolute_path = false, $ctrlContent = null) {
		$this->_templatePath = $is_absolute_path ? $template : $this->_loader->getTemplatePath($this->_getTemplateDirectory() .$template);
		if (is_file($this->_templatePath)) {
			ob_start();
			echo $ctrlContent;
			include $this->_templatePath;
			$this->_content = ob_get_contents();
			ob_end_clean();
			$this->_outPutContent();
		} else {
			throw new Exception("Template File : $this->_templatePath does not exists.");
		}
		return $this;
	}

	public function setLayout($boolean) {
		$this->setLayout = (bool) $boolean;
		return $this;
	}

	/**
	 * 主题模板(/theme/模板位置)
	 **/
	public function setLayoutTempalte($layoutTheme, $layoutTemplate='index',$use_component_layout = false) {
		$this->use_component_layout = $use_component_layout;
		$this->_layoutTemplate = $layoutTemplate;
		$this->_layoutTheme = $layoutTheme;
		return $this;
	}

	/**
	 * 组件下的模板目录(组件目录/view/模板目录/模板位置)
	 **/
	public function setTemplateDirectory($templateDirectory){
		$this->_templateDirectory=$templateDirectory;
	}

	public function _getTemplateDirectory() {
		return $this->_templateDirectory?$this->_templateDirectory.DIRECTORY_SEPARATOR:null;
	}

	protected function _outPutContent() {
		if (!$this->setLayout) {
			ob_start();
			echo $this->_content;
		} else {
			ob_start();
			$this->_viewLayout = System_View_Layout :: getInstance();
			$this->_viewLayout->setView($this)
			->setTemplate($this->_layoutTheme,$this->_layoutTemplate)
			->setContent($this->_content)
			->getLayout($this->use_component_layout);
		}
	}
}
?>