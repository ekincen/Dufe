<?php
/*
 * Created on 2011-3-10
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_CaptureScript extends System_View_Helper_Abstract {

	protected $_startTag;

	protected $_endTag;

	public function captureScript($scriptPath, $type = 'text/javascript') {
		$this->_startTag = '<script type="' . $type . '">';
		$this->_endTag = '</script>';
		if (is_array($scriptPath)) {
			foreach ($scriptPath as $path) {
				$this->_wrapScript($path);
			}

		} else {
			$this->_wrapScript($scriptPath);
		}
		return $this->view;
	}

	protected function _wrapScript($path) {
		echo $this->_startTag;
		readfile($path);
		echo $this->_endTag;
	}
}
?>