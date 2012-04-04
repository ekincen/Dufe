<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
 class System_View_Helper_Element extends System_View_Helper_Abstract{

 	protected $_elementClass;

 	const ELEMENT_CLASS_PREFIX='System_View_Element_';

 	public function element($elementName,$options=array()){
 		$this->_elementClass=$this->_getElementClassName($elementName);
 		$this->_elementClass=new $this->_elementClass();
 		return $this->_elementClass->setOptions($options)->getHtml();
 	}

 	protected function _getElementClassName($elementName){
 		return self::ELEMENT_CLASS_PREFIX.ucfirst($elementName);
 	}
 }
?>