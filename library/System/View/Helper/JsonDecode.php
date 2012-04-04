<?php
class System_View_Helper_JsonDecode extends System_View_Helper_Abstract {

	public function jsonDecode($data){
		return json_decode(trim($data,'()'));
	}
}
?>