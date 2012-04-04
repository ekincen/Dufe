<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */
interface IBootstrap {
	public static function init();

	public static function run();

	public static function route();
}
?>