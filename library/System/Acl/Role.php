<?php
/*
 * Created on 2011-3-13
 *
 * @author yijian.cen
 *
 * @desc implements System_Acl_Resource_Interface
 */
 class System_Acl_Role{

 	protected $_roleId;

 	public function __construct($roleId){
 		$this->_roleId=$roleId;
 	}

 	public function getRoleId(){
 		return $this->_roleId;
 	}

 	public function __toString(){
 		return $this->_roleId;
 	}
 }
?>