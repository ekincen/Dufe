<?php
/*
 * Created on 2011-3-3
 *
 * @author yijian.cen
 *
 */
abstract class System_Loader_App_Abstract {

	protected $_applicationPath;

	public function setApplicationPath($applicationPath){
		$this->_applicationPath=$applicationPath;
		return $this;
	}

	public function getApplicationPath(){
		return $this->_applicationPath;
	}
}
?>