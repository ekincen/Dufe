<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
class System_View_Element_Form_InputText extends System_View_Element_Form_Abstract {

	protected $_class_input = 'iptxt';

	protected $_class_input_wrap = 'txt-wrap';

	protected $_inputType='text';

	public function __construct() {
		$this->_setDefaultOptions();
	}

	protected function _setDefaultOptions() {
		$this->_options = array (
			self :: OPTION_VALUE => null,
			self :: OPTION_NAME => null
		);
	}

	protected function _getContent() {
		return '<' . $this->_innerWrapFlag . ' class="' . $this->_class_rowcont . '">' .
		'<div class="' . $this->_class_input_wrap . '">' .
		'<input type="'.$this->_inputType.'" class="' . $this->_class_input . '" ' . $this->_getId() .
		'name="' . $this->_options[self :: OPTION_NAME] . '" ' .
		'value="' . $this->_options[self :: OPTION_VALUE] . '" /></div>' .
		'</' . $this->_innerWrapFlag . '>';
	}
}
?>