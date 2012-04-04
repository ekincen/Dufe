<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
 abstract class System_Controller_Router_Abstract {

	protected $_response;

	protected $_component;

	protected $_controller;

	protected $_action;

	protected $_invokeParam;

	public function initset($response, $invokeParam) {
		$this->_response = $response;
		$this->_invokeParam = $invokeParam;
		$this->init();
	}

	public function init(){
	}

	public function getInvokeParam(){
		return $this->_invokeParam;
	}
}
?>