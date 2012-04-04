<?php
/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
 abstract class System_Plugin_Renderer_Abstract{

 	public $view;

 	public function __construct($view){
 		$this->view=$view;
 	}

 	public function preRenderLayout(){
 	}

 	public function postRenderLayout(){
 	}
 }
?>