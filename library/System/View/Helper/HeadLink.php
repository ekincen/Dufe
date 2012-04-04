<?php
/*
 * Created on 2011-3-9
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_HeadLink extends System_View_Helper_Abstract {

	protected $_headBroker;

	protected $_headScript;

	protected $_headStyle;

	const DEFAULT_SCRIPT_TYPE = 'text/javascript';

	const DEFAULT_STYLE_TYPE = 'text/css';

	const DEFAULT_STYLE_REL = 'stylesheet';

	const DEFAULT_MODE = 'append';

	const HEAD_SCRIPT_KEY = 'headScript';

	const HEAD_LINK_KEY = 'headLink';

	public function __construct() {
		$this->_headBroker = System_View_Helper_Head_Broker :: getInstance();
	}

	public function headLink($linkType = null, $args = array (), $mode = self :: DEFAULT_MODE) {
		if ($linkType !== null) {
			$args=is_array($args)?$args:array($args);
			switch ($linkType) {
				case 'script' :
					call_user_func_array(array (
						$this,
						$mode . 'Script'
					), $args);
					break;
				case 'link' :
					call_user_func_array(array (
						$this,
						$mode . 'Link'
					), $args);
					break;
				default :
					throw new Exception("Wrong link type with '$linkType'");
			}
		}
		return $this;
	}

	public function appendScript($scriptPath, $type = self :: DEFAULT_SCRIPT_TYPE) {
		if(is_array($scriptPath)){
			foreach($scriptPath as $path){
				$this->_headBroker->headLink[self :: HEAD_SCRIPT_KEY] .= $this->_getScript($path, $type);
			}
		}else{
				$this->_headBroker->headLink[self :: HEAD_SCRIPT_KEY] .= $this->_getScript($scriptPath, $type);
		}
		return $this;
	}

	public function appendLink($stylePath, $type = self :: DEFAULT_STYLE_TYPE, $rel = self :: DEFAULT_STYLE_REL) {
		if (is_array($stylePath)) {
			foreach ($stylePath as $path) {
				$this->_headBroker->headLink[self :: HEAD_LINK_KEY] .= $this->_getLink($path, $type, $rel);
			}
		} else {
			$this->_headBroker->headLink[self :: HEAD_LINK_KEY] .= $this->_getLink($stylePath, $type, $rel);
		}
		return $this;
	}

	public function prependScript($scriptPath, $type = self :: DEFAULT_SCRIPT_TYPE) {
		if(is_array($scriptPath)){
			foreach($scriptPath as $path){
				$this->_headBroker->headLink[self :: HEAD_SCRIPT_KEY] = $this->_getScript($scriptPath, $type) . $this->_headBroker->headLink[self :: HEAD_SCRIPT_KEY];
			}
		}else{
			$this->_headBroker->headLink[self :: HEAD_SCRIPT_KEY] = $this->_getScript($scriptPath, $type) . $this->_headBroker->headLink[self :: HEAD_SCRIPT_KEY];
		}
		return $this;
	}

	public function prependLink($stylePath, $type = self :: DEFAULT_STYLE_TYPE, $rel = self :: DEFAULT_STYLE_REL) {
		if(is_array($stylePath)){
			foreach($stylePath as $path){
				$this->_headBroker->headLink[self :: HEAD_LINK_KEY] = $this->_getStyle($stylePath, $type, $rel) . $this->_headBroker->headLink[self :: HEAD_LINK_KEY];
			}
		}else{
			$this->_headBroker->headLink[self :: HEAD_LINK_KEY] = $this->_getStyle($stylePath, $type, $rel) . $this->_headBroker->headLink[self :: HEAD_LINK_KEY];
		}
		return $this;
	}

	protected function _getScript($scriptPath, $type) {
		return '<script type="' . $type . '" src="' . $scriptPath . '"></script>';
	}

	protected function _getLink($stylePath, $type, $rel) {
		return '<link rel="' . $rel . '" type="' . $type . '" href="' . $stylePath . '"></link>';
	}
}
?>