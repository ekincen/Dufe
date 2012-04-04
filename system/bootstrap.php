<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 * @desc implement IBootstap
 */
class Bootstrap {

	public static function init() {
		self :: _loadClass();
	}

	public static function run() {
		self :: init();
		self :: route();
	}

	public static function route() {
		System_Controller_Front :: getInstance()
		->setApplicationPath(APP_PATH)
		->setThemePath(THEME_PATH)
		->setTemplate(System_Globals :: get('config')->TEMPLATE)
		->setDefaultComponent('home')
		->run();
	}

	protected static function _loadClass() {
		Invoker :: getInstance()
		->load('definer')
		->load('autoloader')
		->load('config')
		->load('errorHandler')
		->load('acl')
		->execute();
	}
}
//命令模式调用器
class Invoker {

	private $_classArr;

	private static $_instance;

	private function Invoker() {
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null === self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	public function load($classname) {
                require SYS_PATH.DS.'boot' . DS . 'class.' . $classname . '.php';
		$this->_classArr[] = new $classname;
		return $this;
	}

	public function execute() {
		foreach ($this->_classArr as $class) {
			$class->run();
		}
	}
}
?>