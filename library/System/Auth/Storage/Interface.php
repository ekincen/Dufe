<?php
/*
 * Created on 2011-3-11
 *
 * @author yijian.cen
 *
 */
 interface System_Auth_Storage_Interface{

    public function isEmpty();

    public function read();

    public function write($contents);

    public function clear();
 }
?>