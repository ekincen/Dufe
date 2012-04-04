<?php
/*
 * Created on 2011-3-13
 *
 * @author yijian.cen
 *
 */
class Acl {

	protected $_auth;

	protected $_acl;

	public function init() {
		$this->_auth = System_Auth :: getInstance();
		$this->_acl = System_Acl::getInstance();
	}

	public function run() {
		$this->init();
		$this->_setAuth()->_setAclRole()->_setAclResource()->_allocateAcl();
	}

	protected function _setAuth() {
		if (!$this->_auth->hasIdentity()) {
			$this->_auth->getStorage()->write((object)array (
				'username' => '游客',
				'role' => 'guest'
			));
		}
		return $this;
	}

	protected function _setAclRole() {
		$this->_acl
		->addRole(new System_Acl_Role('guest'))
		->addRole(new System_Acl_Role('member'), 'guest');
		return $this;
	}

	protected function _setAclResource() {
		$this->_acl->addResource(new System_Acl_Resource('portal'));
		return $this;
	}

	protected function _allocateAcl() {
		$this->_acl->allow('member','portal');
		return $this;
	}
}
?>