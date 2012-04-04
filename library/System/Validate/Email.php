<?php
/*
 * Created on 2011-3-17
 *
 * @author yijian.cen
 *
 */
 class System_Validate_Email extends System_Validate_Abstract{

 	protected $_errorMessage='邮件地址格式错误';

 	public function isValid($value){
 		return preg_match('/^[\w\.-]+@[\w-]+(\.[\w-]+)+/i',$value);
 	}
 }
?>