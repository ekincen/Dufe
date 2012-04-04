<?php

/*
 * Created on 2011-3-8
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_HeadTitle extends System_View_Helper_Abstract {

	protected $_headBroker;

	const DEFAULT_MODE='append';

	public function __construct() {
		$this->_headBroker = System_View_Helper_Head_Broker :: getInstance();
	}

	public function headTitle($title = null, $mode = self::DEFAULT_MODE) {
		if ($title !== null) {
			switch ($mode) {
				case 'append' :
					$this->appendTitle($title);
					break;
				case 'prepend' :
					$this->prependTitle($title);
					break;
				default :
					throw new Exception("No avalable mode for function 'headTitle' with '$mode'");
			}
		}
		return $this;
	}

	public function setSeparator($separator) {
		$this->_headBroker->headTitleSeparator = $separator;
		return $this;
	}

	public function appendTitle($title) {
		array_push($this->_headBroker->headTitle, $title);
		return $this;
	}

	public function prependTitle($title) {
		array_unshift($this->_headBroker->headTitle, $title);
		return $this;
	}
}
?>