<?php
/*
 * Created on 2011-3-16
 *
 * @author yijian.cen
 *
 */
 class System_Validate_NotEmpty extends System_Validate_Abstract{

 	protected $_errorMessage='该字段不能为空';

 	public function isValid($value){
 		return (bool)$value;
 	}
 }
?>