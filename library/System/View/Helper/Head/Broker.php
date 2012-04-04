<?php
/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_Head_Broker {

	private static $_instance;

	public $headMeta;

	public $headLink ;

	public $headScript;

	public $headTitle = array ();

	public $headTitleSeparator;

	private function __construct() {
		$this->headLink = array (
			System_View_Helper_HeadLink :: HEAD_SCRIPT_KEY=> null,
			System_View_Helper_HeadLink :: HEAD_LINK_KEY=> null
		);
	}

	private function __clone() {
	}

	public static function getInstance() {
		if (null === self :: $_instance) {
			self :: $_instance = new self();
		}
		return self :: $_instance;
	}

	public function getHeadTitle() {
		return '<title>' . implode($this->headTitleSeparator, $this->headTitle) . '</title>';
	}

	public function getHeadMeta() {
		return $this->headMeta;
	}

	public function getHeadLink() {
		return implode(null, $this->headLink);
	}

	public function getHeadScript(){
		return $this->headScript;
	}
}
?>