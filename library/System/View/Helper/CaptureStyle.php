<?php

/*
 * Created on 2011-3-10
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_CaptureStyle extends System_View_Helper_Abstract {

	public function captureStyle($stylePath, $type = 'text/css') {
		echo '<style type="' . $type . '">';
		if (is_array($stylePath)) {
			foreach ($stylePath as $path) {
                            readfile($path) ;
			}
		} else {
			readfile($stylePath);
		}
		echo '</style>';
		return $this->view;
	}
}
?>