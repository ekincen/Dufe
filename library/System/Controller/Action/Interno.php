<?php
/*
 * Created on 2011-3-7
 *
 * @author yijian.cen
 *
 */
class System_Controller_Action_Interno extends System_Controller_Action_Abstract {

	const RESPONSE_TYPE_FLAG = 'restype';

	const RESPONSE_TYPE_JS = 'js';

	const RESPONSE_TYPE_JS_ACTION = 'responseJs';

	public function __construct($action = null) {
		parent :: __construct($action);
		$this->view->setLayout = false;
		$this->_setStatus($action);
	}

	public function init() {
	}

	protected function _setStatus($action) {
		switch ($status = $this->_request->getGet(self :: RESPONSE_TYPE_FLAG)) {
			case self :: RESPONSE_TYPE_JS :
				$this->_action = self :: RESPONSE_TYPE_JS_ACTION;
				break;
			default :
				$this->_init();
		}
	}

	protected function _init() {
	}

	protected function _setAuth(){
		$this->_identity = System_Auth :: getInstance()->getIdentity();
		if (!System_Acl :: getInstance()->isAllowed($this->_identity->role, 'portal')){
			?>
			<script>window.top.location.href='/'</script>
			<?php
			exit();
		}
	}
}
?>