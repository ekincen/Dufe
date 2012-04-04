<?php
/*
 * Created on 2011-3-11
 *
 * @author yijian.cen
 *
 */
class System_Auth_Storage_Session implements System_Auth_Storage_Interface {

	protected $_member;

	protected $_session;

	protected $_namespace;

	const DEFAULT_NAMESPACE='System_Auth';

	const DEFAULT_MEMBER='storage';

	public function __construct($namespace = self::DEFAULT_NAMESPACE, $member = self::DEFAULT_MEMBER) {
        $this->_namespace = $namespace;
        $this->_member    = $member;
        $this->_session=new System_Session_Namespace($this->_namespace);
	}

	public function isEmpty() {
		return !isset($this->_session->{$this->_member });
	}

	public function read() {
		return $this->_session->{$this->_member };
	}

	public function write($contents) {
		$this->_session->{$this->_member }= $contents;
		return $this;
	}

	public function clear() {
		unset ($this->_session-> {$this->_member });
	}
}
?>