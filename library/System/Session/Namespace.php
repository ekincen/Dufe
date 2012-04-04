<?php
/*
 * Created on 2011-3-11
 *
 * @author yijian.cen
 *
 */
 class System_Session_Namespace{

 	protected $_namespace;

 	public function __construct($namespace='Default'){
 		System_Session::start();
 		if(!isset($_SESSION[$namespace]))$_SESSION[$namespace]=array();
 		$this->_namespace=$namespace;
 	}

 	public function __set($index,$value){
 		$_SESSION[$this->_namespace][$index]=$value;
 	}

 	public function __get($index){
 		return $_SESSION[$this->_namespace][$index];
 	}

 	public function __isset($index){
 		return isset($_SESSION[$this->_namespace][$index]);
 	}

 	public function __unset($index){
 		unset($_SESSION[$this->_namespace][$index]);
 	}
 }
?>