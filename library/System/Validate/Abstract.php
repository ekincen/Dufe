<?php
/*
 * Created on 2011-3-16
 *
 * @author yijian.cen
 *
 */
 abstract class System_Validate_Abstract{

 	protected $_errorMessage;

 	public function getErrorMessage(){
 		return $this->_errorMessage;
 	}
 }
?>