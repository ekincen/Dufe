<?php
/*
 * Created on 2011-3-13
 *
 * @author yijian.cen
 *
 * @desc implements System_Acl_Resource_Interface
 */
class System_Acl_Resource{

	protected $_resourceId;

	public function __construct($resourceId) {
		$this->_resourceId = $resourceId;
	}

	public function getResourceId(){
		return $this->_resourceId;
	}

	public function __toString() {
		return $this->_resourceId;
	}
}
?>