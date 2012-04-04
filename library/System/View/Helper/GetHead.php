<?php
/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
 class System_View_Helper_GetHead extends System_View_Helper_Abstract{

 	protected $_headBroker;

 	const HEADER_BEGIN_TAG='<head>';

 	const HEADER_END_TAG='</head>';

 	public function __construct(){
 		$this->_headBroker=System_View_Helper_Head_Broker::getInstance();
 	}

 	public function getHead(){
 		return $this;
 	}

 	public function __toString(){
 		return self::HEADER_BEGIN_TAG.
 		$this->_headBroker->getHeadMeta().
 		$this->_headBroker->getHeadTitle().
 		$this->_headBroker->getHeadLink().
 		$this->_headBroker->getHeadScript().
 		self::HEADER_END_TAG;
 	}
 }
?>