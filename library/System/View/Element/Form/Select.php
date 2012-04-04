<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
class System_View_Element_Form_Select extends System_View_Element_Form_Abstract {

	protected $_singleOption;

	protected $_class_desc = 'select_desc';

	const OPTION_ARRAY = 'optionArr';

	const VALUE_INDEX = 'valueIndex';

	const DESC_INDEX = 'descIndex';

	public function __construct() {
		$this->_setDefaultOption();
	}

	protected function _setDefaultOption() {
		$this->_options = array (
			self :: OPTION_ARRAY => array(),
			self :: VALUE_INDEX=>null,
			self :: DESC_INDEX=>null
		);
	}

	protected function _getContent() {
		return '<' . $this->_innerWrapFlag . '>' . $this->_getSelects() . '</' . $this->_innerWrapFlag . '>';
	}

	protected function _getSelects() {
		$html='<select name="'.$this->_options[self::OPTION_NAME].'"><option value="">请选择</option>';
		foreach ($this->_options[self :: OPTION_ARRAY] as $option) {
			$html.='<option value="'.$option[$this->_options[self::VALUE_INDEX]].'"' .
			        ($this->_options[self::OPTION_VALUE]==$option[$this->_options[self::VALUE_INDEX]]?'selected':null).
					'>'.$option[$this->_options[self::DESC_INDEX]].'</option>';
		}
		$html.='</select>';
		return $html;
	}
}
?>