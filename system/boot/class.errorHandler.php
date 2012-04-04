<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */
class ErrorHandler{

	protected $_errorLevel;

	protected $_showDebug;

	protected $_globalConfig;

	public function init(){
		$this->_globalConfig=System_Globals::get('config');
		$this->_errorLevel=$this->_globalConfig->ERROR_LEVEL;
		$this->_showDebug=$this->_globalConfig->SHOW_DEBUG;
	}

	public function run() {
		$this->init();
		$this->_setErrorLevel()->_setExceptionHandler()->_setErrorExceptionHandler();
	}

	protected function _setErrorLevel(){
		error_reporting($this->_errorLevel);
		return $this;
	}

	protected function _setExceptionHandler() {
		function exceptionHandler($e) {
			ob_end_clean();
			include System_Loader_Theme::getInstance()->setThemePath(THEME_PATH)->getSystemTemplatePath('exception');
		}
		if($this->_showDebug)set_exception_handler('exceptionHandler');
		return $this;
	}

	protected function _setErrorExceptionHandler() {
		function errorExceptionHandler($errorLevel,$errorMessage,$errorFile,$errorLine,$errorContext) {
			throw new Exception($errorMessage);
		}
		set_error_handler('errorExceptionHandler');
		return $this;
	}
}
?>