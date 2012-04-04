<?php
/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */
class System_Db_Model{

	protected $_adapter='mysql';

	protected $_dbArr=array();

	protected $_db;

	protected $_helper;

	protected $_loader;

	protected $_component;

	public function __construct($component=null){
		$this->_setAdapter();
		$this->_helper=System_Db_Model_Helper::getInstance();
		$this->_component=$component;
		$this->init();
	}

	public final function getHelper($helper){
		return $this->_helper->getHelper($helper);
	}

	public function init(){
	}

	public final function getModel($model,$component=null) {
		$component=$component?$component:$this->_component;
		return $this->_getModelLoader()->getModel($model,$component);
	}

	protected function _setAdapter(){
		if(!$this->_db=System_Db_Adapter::getAdapter($this->_adapter)){
			$this->_db=System_Db_Adapter::connect($this->_adapter);
			$this->_dbArr[$this->_adapter]=$this->_db;
		}
	}

	protected function _getAdapter($adapter){
		if(!isset($this->_dbArr[$adapter])){
			return $this->_dbArr[$adapter]=System_Db_Adapter::connect($adapter);
		}else
		return $this->_dbArr[$adapter];
	}

	protected function _getModelLoader(){
		if(!$this->_loader){
			$this->_loader=System_Loader_App_Component :: getInstance();
		}
		return $this->_loader;
	}
}
?>