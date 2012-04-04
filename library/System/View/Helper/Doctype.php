<?php
/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_Doctype extends System_View_Helper_Abstract {

	protected $_doctype;

	const XHTML1_STRICT = 'XHTML1_STRICT';

	const XHTML1_TRANSITIONAL = 'XHTML1_TRANSITIONAL';

	public function doctype($type = null) {
		if (null !== $type) {
			switch ($type) {
				case self :: XHTML1_STRICT :
					$this->_doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
					break;
				case self :: XHTML1_TRANSITIONAL :
					$this->_doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
					break;
				default :
					throw new Exception("No doctype with '$type'");
			}
		} else {
			$this->doctype(self :: XHTML1_TRANSITIONAL);
		}
		return $this;
	}

	public function __toString() {
		return $this->_doctype;
	}
}
?>