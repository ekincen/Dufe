<?php
/*
 * Created on 2011-3-13
 *
 * @author yijian.cen
 *
 */
class System_Acl {

	private static $_instance;

	protected $_roles = array ();

	protected $_resources = array ();

	protected $_previleges = array ();

	protected $_rules;

	private function __construct() {
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null == self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	/* @param role (implement from System_Acl_Role_Interface) */
	public function addRole($role, $parentId = null) {
		$roleId = $role->getRoleId();
		$roleParent = null;

		if ($parentId !== null) {
			if (!isset ($this->_roles[$parentId]))
				throw new Exception("Parent role '$parentId' is undefined.");
			$roleParent = $this->_roles[$parentId]['instance'];
			$this->_roles[$parentId]['children'][$roleId] = $role;
		}
		$this->_roles[$roleId] = array (
			'instance' => $role,
			'parent' => $roleParent,
			'children' => array ()
		);
		return $this;
	}

	/* @param resource (implement from System_Acl_Resource_Interface) */
	public function addResource($resource, $parentId = null) {
		$resourceId = $resource->getResourceId();
		$resourceParent = null;

		if ($parentId !== null) {
			if (!isset ($this->_resources[$parentId]))
				throw new Exception("Parent resource '$parentId' is undefined.");
			$resourceParent = $this->_resources[$parentId]['instance'];
			$this->_resources[$parentId]['children'][$resourceId] = $resource;
		}
		$this->_resources[$resourceId] = array (
			'instance' => $resource,
			'parent' => $resourceParent,
			'children' => array ()
		);
		return $this;
	}

	public function allow($roleId, $resourceId = null, $previlege = null) {
		$this->_checkRoleId($roleId);
		if (!is_array($resourceId)) {
			$resourceId = array (
				$resourceId
			);
		}
		if (!is_array($previlege)) {
			$previlege = array (
				$previlege
			);
		}
		foreach ($resourceId as $resource) {
			$this->_checkResourceId($resource);
			foreach ($previlege as $prev) {
				$this->_previleges[$prev] = array ();
				$this->_rules[] = array (
					'role' => $roleId,
					'resource' => $resource,
					'previlege' => $prev
				);
			}
		}
		return $this;
	}

	public function isAllowed($roleId, $resourceId = null, $previlege = null) {
		$is_allowed_role = false;
		$is_allowed_resource = false;
		$is_allowed_previlege = false;

		$this->_checkRoleId($roleId)->_checkResourceId($resourceId)->_checkPrevilege($previlege);
		foreach ($this->_rules as $rule) {

			$checkRoleId = $roleId;
			$checkResourceId = $resourceId;

			//检查当前角色是否比规则权限高
			do {
				if ($checkRoleId == $rule['role']) {
					$is_allowed_role = true;
					break;
				}
				$checkRoleId = ($parent = $this->_roles[$checkRoleId]['parent']) ? $parent->getRoleId() : false;
			} while ($checkRoleId);

			//检查当前资源是否比规则权限高
			if ($rule['resource'] && $checkResourceId) {
				do {
					if ($checkResourceId == $rule['resource']) {
						$is_allowed_resource = true;
						break;
					}
					$checkResourceId = ($parent = $this->_resources[$checkResourceId]['parent']) ? $parent->getResourceId() : false;
				} while ($checkResourceId);

			} else {
				$is_allowed_resource = true;
			}

			//检查当前权限操作
			if ($rule['previlege'] == $previlege || !$rule['previlege'])
				$is_allowed_previlege = true;

			if ($is_allowed_role && $is_allowed_resource && $is_allowed_previlege)
				return true;
		}
		return false;
	}

	protected function _checkRoleId($roleId) {
		if (!isset ($this->_roles[$roleId]))
			throw new Exception("Undefine role '$roleId'.");
		return $this;
	}

	protected function _checkResourceId($resourceId) {
		if ($resourceId && !isset ($this->_resources[$resourceId]))
			throw new Exception("Undefine resource '$resourceId'.");
		return $this;
	}

	protected function _checkPrevilege($previlege) {
		if ($previlege && !isset ($this->_previleges[$previlege]))
			throw new Exception("Undefine previlege '$previlege'.");
		return $this;
	}
}
?>