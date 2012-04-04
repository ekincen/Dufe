<?php
/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */
class System_Db_Adapter_Redis {

    protected $_redis;

    public function connect($hosts, $port) {
        $this->_redis = new Redis();
        $this->_redis->connect($hosts, $port);
        return $this->_redis;
    }
}
?>