<?php
/*
 * Created on 2011-2-24
 *
 * @author yijian.cen
 *
 */
class System_Globals extends ArrayObject {

	private static $_instance;

	protected static $_globals;

	public static function getInstance() {
		if (null == self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	public static function set($index, $value) {
		$instance = self :: getInstance();
		$instance->offsetSet($index, $value);
	}

	public static function get($index) {
		$instance = self :: getInstance();
		return new self($instance->offsetGet($index));
	}

	public function __construct($array = array (), $flags = parent :: ARRAY_AS_PROPS) {
		parent :: __construct($array, $flags);
	}
}
?>