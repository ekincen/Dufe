<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
class System_View_Element_Form_InputRadio extends System_View_Element_Form_Abstract {

	protected $_class_row_radio = 'radiorow';

	const OPTION_RADIOS = 'radios';

	const OPTION_CHECKED ='checked';

	public function __construct() {
		$this->_setDefaultOptions();
	}

	protected function _setDefaultOptions() {
		$this->_options = array (
			self :: OPTION_NAME => null,
			self :: OPTION_RADIOS => array(),
			self :: OPTION_CHECKED => null
		);
	}

	protected function _getContent() {
		return '<' . $this->_innerWrapFlag . ' class="' . $this->_class_rowcont . ' ' . $this->_class_row_radio . '">' .
		$this->_getRadios() .
		'</' . $this->_innerWrapFlag . '>';
	}

	protected function _getRadios() {
		$radios = null;
		foreach ($this->_options[self :: OPTION_RADIOS] as $value=>$label) {
			$checked=null;
			if($this->_options[self::OPTION_CHECKED]==$value)$checked='checked';
			$radios .= '<label>' . $label .
			'<input type="radio" name="' . $this->_options[self :: OPTION_NAME] . '" ' .
			'value="' . $value . '" '.$checked.' /></label>';
		}
		return $radios;
	}
}
?>
