<?php
/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */

class System_Db_Adapter_Sphinx {

    protected $_sphinx;

    public function connect($host, $port) {
        $this->_sphinx = new SphinxClient;
        $this->_sphinx->setServer($host, $port);
        return $this->_sphinx;
    }
}

?>