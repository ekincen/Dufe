<?php
/*
 * Created on 2011-3-16
 *
 * @author yijian.cen
 *
 */
class System_Input {

	protected $_validateBroker;

	protected $_validators;

	protected $_data;

	protected $_result;

	protected $_boolResult=true;

	protected $_errorMessage = array ();

	public function __construct($validators, $data) {
		$this->_validators = (array) $validators;
		$this->_data = (array) $data;
		$this->_result=new stdClass();
	}

	public function isValid() {
		$this->_validateBroker = System_Validate :: getInstance();
		foreach ($this->_validators as $name => $options) {
			foreach ($options as $property => $val) {
				$validator = $this->_validateBroker->getValidator($val);
				if (!$validator->isValid($this->_data[$name])) {
					$this->_errorMessage[$name] = $validator->getErrorMessage();
					$this->_boolResult= false;
					break;
				}
				$this->_result->$name=$this->_data[$name];
			}
		}
		return $this->_boolResult;
	}

	public function getErrorMessages() {
		return $this->_errorMessage;
	}

	public function getErrorMessage($index) {
		return isset ($this->_errorMessage[$index]) ? $this->_errorMessage[$index] : null;
	}

	public function __get($index){
		if($this->_boolResult)return $this->_result->$index;
	}
}
?>