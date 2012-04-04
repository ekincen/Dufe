<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
 class System_View_Helper_FormElement extends System_View_Helper_Abstract{

 	protected $_elementClass;

 	const FORM_ELEMENT_CLASS_PREFIX='System_View_Element_Form_';

 	public function formElement($elementName,$options,$style=null){
 		$this->_elementClass=$this->_getElementClassName($elementName);
 		$this->_elementClass=new $this->_elementClass();
 		return $this->_elementClass->setOptions($options,$style)->getHtml();
 	}

 	protected function _getElementClassName($elementName){
 		return self::FORM_ELEMENT_CLASS_PREFIX.ucfirst($elementName);
 	}
 }
?>