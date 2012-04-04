<?php
/*
 * Created on 2011-3-9
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_HeadScript extends System_View_Helper_Abstract {

	protected $_headBroker;

	public function __construct() {
		$this->_headBroker = System_View_Helper_Head_Broker :: getInstance();
	}

	public function headScript() {
		return $this;
	}

	public function appendNoScript($content){
		$this->_headBroker->headScript='<noscript>'.$content.'</noscript>';
		return $this;
	}
}
?>