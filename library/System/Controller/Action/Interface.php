<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
 interface System_Controller_Action_Interface{

 	public function __construct($action = null);

 	public function init();

 	public function render();

 	protected function _setBasicPath();
 }
?>