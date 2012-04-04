<?php
/*
 * Created on 2012-2-6
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_Substring extends System_View_Helper_Abstract {

	public function substring($string, $start = 0, $length = 40,$encoding='utf-8') {
		$string=preg_replace('/<[^>]+>/i',null,$string);
		return mb_strimwidth($string,$start,$length,'...',$encoding);
	}
}
?>