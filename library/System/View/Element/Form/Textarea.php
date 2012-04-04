<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
 class System_View_Element_Form_Textarea extends System_View_Element_Form_Abstract{

 	protected $_class_textarea_wrap='txt-wrap';

 	public function __construct(){
 		$this->_setDefaultOptions();
 	}

 	protected function _setDefaultOptions(){
 		$this->_options=array(
 		  self::OPTION_VALUE=>null,
 		  self::OPTION_NAME=>null,
 		  self::OPTION_CLASS=>null
 		);
 	}

 	protected function _getContent(){
 		return '<'.$this->_innerWrapFlag.'>'.$this->_getTextarea().'</'.$this->_innerWrapFlag.'>';
 	}

 	protected function _getTextarea(){
 		return '<div class="'.$this->_class_textarea_wrap.'"><textarea '.
        ' name="'. $this->_options[self :: OPTION_NAME] .'" class=" '.
        $this->_options[self::OPTION_CLASS].'"'.$this->_getId().
 		'>'.$this->_options[self::OPTION_VALUE].'</textarea></div>';
 	}
 }
?>