<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
class System_View_Element_Form_MultiSelect extends System_View_Element_Form_Abstract {

	protected $_singleOption;

	protected $_class_desc = 'select_desc';

	const OPTION_SELECTS = 'selects';

	const OPTION_OPTIONS = 'options';

	const OPTION_DESC = 'desc';

	public function __construct() {
		$this->_setDefaultOption();
	}

	protected function _setDefaultOption() {
		$this->_singleOption = array (
			self :: OPTION_DESC => null,
			self :: OPTION_NAME => null,
			self :: OPTION_OPTIONS => array ()
		);
		$this->_options = array (
			self :: OPTION_SELECTS => array (
				$this->_singleOption
			)
		);
	}

	protected function _getContent() {
		return '<' . $this->_innerWrapFlag . '>' . $this->_getSelects() . '</' . $this->_innerWrapFlag . '>';
	}

	protected function _getSelects() {
		$selects = null;
		foreach ($this->_options[self :: OPTION_SELECTS] as $select) {
			$options = null;
			$select=array_merge($this->_singleOption,$select);
			foreach ($select[self :: OPTION_OPTIONS] as $value => $desc) {
				$options .= '<option value="' . $value . '">' . $desc . '</option>';
			}
			$selects .= '<select name="' . $select[self :: OPTION_NAME] . '">' . $options . '</select>' .
			'<span class="' . $this->_class_desc . '">' . $select[self :: OPTION_DESC] . '</span>';
		}
		return $selects;
	}
}
?>