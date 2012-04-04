<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */
class autoloader{

	private static $_filePath;

	const FILE_EXT = '.php';

	public function run() {
		self :: _setIncludePath();
		spl_autoload_register(array (
			'autoloader',
			'autoload'
		));
	}

	public static function autoload($classname) {
		self :: $_filePath = str_replace('_', DIRECTORY_SEPARATOR, $classname);
		include self :: $_filePath.self::FILE_EXT;
	}

	protected static function _setIncludePath() {
		set_include_path(implode(PATH_SEPARATOR, array (
		get_include_path(), LIBRARY_PATH)));
	}
}
?>