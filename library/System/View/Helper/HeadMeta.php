<?php
/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_HeadMeta extends System_View_Helper_Abstract {

	protected $_headBroker;

	public function __construct() {
		$this->_headBroker = System_View_Helper_Head_Broker :: getInstance();
	}

	public function headMeta() {
		return $this;
	}

	public function appendHttpEquiv($httpEquiv, $content) {
		$this->_headBroker->headMeta .= $this->getHttpEquiv($httpEquiv, $content);
		return $this;
	}

	public function getHttpEquiv($httpEquiv, $content){
		return '<meta http-equiv="'.$httpEquiv.'" content="'.$content.'">';
	}
}
?>