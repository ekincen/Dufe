<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */
 class Definer{
 	public function run(){
 		//define('ROOT_PATH',ROOT_PATH);
 		define('APP_PATH',ROOT_PATH.DS.'app');
 		define('LIBRARY_PATH',ROOT_PATH.DS.'library');
 		define('PUBLIC_PATH',ROOT_PATH.DS.'public');
 		define('UPLOAD_PATH',PUBLIC_PATH.DS.'upload');
 		define('MEDIA_PATH',UPLOAD_PATH.DS.'custom');
 		define('THEME_PATH',PUBLIC_PATH.DS.'theme');
 		define('JSLIB_PATH',PUBLIC_PATH.DS.'jslib');
 		define('JQUERY_PLUGIN_PATH',JSLIB_PATH.DS.'jquery'.DS.'plugin');
 	}
 }
?>