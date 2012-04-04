<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
abstract class System_View_Element_Form_Abstract {

	protected $_style;

	protected $_options = array ();

	protected $_wrapFlag = 'tr';

	protected $_innerWrapFlag = 'td';

	protected $_class_title = 'title';

	protected $_class_row = 'row';

	protected $_class_rowcont = 'rowcont';

	protected $_class_tips = 'tips';

	const STYLE_TABLE = 'table';

	const STYLE_DIV = 'div';

	const OPTION_TIPS = 'tips';

	const OPTION_LABEL = 'label';

	const OPTION_NAME = 'name';

	const OPTION_VALUE = 'value';

	const OPTION_CLASS = 'class';

	const OPTION_ID = 'id';

	public function setOptions($options, $style) {
		$this->_style = $style ? $style : self :: STYLE_TABLE;
		$this->_options = array_merge($this->_options, $options);
		return $this;
	}

	public function getHtml() {
		switch ($this->_style) {
			case self :: STYLE_TABLE :
				break;
			case self :: STYLE_DIV :
				$this->_wrapFlag = 'div';
				$this->_innerWrapFlag = 'div';
				$this->_class_row = $this->_class_row . ' relt';
				break;
			default :
				throw new Exception("Style " . $this->_style . " has not been customed");
		}
		return '<' . $this->_wrapFlag . ' class="' . $this->_class_row . '">' .
		 (isset ($this->_options[self :: OPTION_LABEL]) ? $this->_getTitle() : null) .
		$this->_getContent() .
		 (isset ($this->_options[self :: OPTION_TIPS]) ? $this->_getTips() : null) .
		'</' . $this->_wrapFlag . '>';
	}

	protected function _getTitle() {
		return '<' . $this->_innerWrapFlag . ' class="' . $this->_class_title . '">' .
		'<label' . (isset ($this->_options[self :: OPTION_ID]) ? ' for="' . $this->_options[self :: OPTION_ID] . '"' : null) . '>' .
		$this->_options[self :: OPTION_LABEL] . '</label></' . $this->_innerWrapFlag . '>';
	}

	protected function _getContent() {
	}

	protected function _getTips() {
		return '<' . $this->_innerWrapFlag . ' class="' . $this->_class_tips . '"><label class="desc">' .
		$this->_options[self :: OPTION_TIPS] .
		'</label></' . $this->_innerWrapFlag . '>';
	}

	protected function _getId() {
		return isset ($this->_options[self :: OPTION_ID]) ? 'id="' . $this->_options[self :: OPTION_ID] . '" ' : null;
	}
}
?>