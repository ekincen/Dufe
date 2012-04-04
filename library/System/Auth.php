<?php
/*
 * Created on 2011-3-11
 *
 * @author yijian.cen
 *
 */
 class System_Auth{

 	private static $_instance;

 	protected $_storage=null;

 	private function __construct(){
 	}

 	private function __clone(){
 	}

 	public static function getInstance(){
 		if(null===self::$_instance){
 			self::$_instance=new self();
 		}
 		return self::$_instance;
 	}

 	public function hasIdentity(){
 		return !$this->getStorage()->isEmpty();
 	}

 	public function getStorage(){
 		if(null==$this->_storage){
 			$this->setStorage(new System_Auth_Storage_Session());
 		}
 		return $this->_storage;
 	}

 	public function setStorage(System_Auth_Storage_Interface $storage){
 		$this->_storage=$storage;
 	}

 	public function setIdentity($bind=array()){
 		$identity=$this->getStorage()->read();
 		foreach($bind as $key=>$val){
 			$identity->$key=$val;
 		}
 		$this->getStorage()->write($identity);
 	}

 	public function clearIdentity(){
 		$this->getStorage()->clear();
 	}

 	public function getIdentity(){
 		return $this->getStorage()->read();
 	}
 }
?>