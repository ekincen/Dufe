<?php
/*
 * Created on 2011-3-6
 *
 * @author yijian.cen
 *
 */
define('ROOT_PATH', realpath('./..'));
define('DS', DIRECTORY_SEPARATOR);
define('SYS_PATH', ROOT_PATH . DS . 'system');
require SYS_PATH . DS . 'bootstrap.php';
Bootstrap :: run();
?>