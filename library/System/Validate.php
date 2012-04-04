<?php
/*
 * Created on 2011-3-16
 *
 * @author yijian.cen
 *
 */
 class System_Validate{

 	private static $_instance;

 	protected $_validators;

 	const VALIDATOR_CLASS_PREFIX='System_Validate_';

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

 	public function getValidator($validator,$option=null){
 		if(!isset($this->_validators[$validator])){
 			$validatorClass=self::VALIDATOR_CLASS_PREFIX.$validator;
 			$this->_validators[$validator]=new $validatorClass($option);
 		}
 		return $this->_validators[$validator];
 	}
 }
?>