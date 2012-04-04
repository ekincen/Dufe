<?php
/*
 * Created on 2011-4-4
 *
 * @author yijian.cen
 *
 */
 interface System_View_Element_Interface{
 	public function setOptions();
 	public function getHtml();
 	protected function _getTitle();
 	protected function _getContent();
 	protected function _getTips();
 	protected function _setDefaultOptions();
 }
?>