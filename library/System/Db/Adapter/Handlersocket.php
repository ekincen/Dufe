<?php

/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */

class System_Db_Adapter_Handlersocket {

    protected $_db;
    protected $_rdb;
    protected $_host;
    protected $_wrport;
    protected $_rport;
    protected $_dbname;
    protected $_tablePrefix;

    const TABLE_PREFIX_FLAG = '#@__';

    public function connect($db_host, $db_name, $tbl_prefix, $hs_port, $hs_rport) {
        $this->_host = $db_host;
        $this->_dbname = $db_name;
        $this->_wrport = $hs_port;
        $this->_rport = $hs_rport;
        $this->_tablePrefix = $tbl_prefix;
        return $this;
    }

    public function getInstance($readonly) {
        if ($readonly) {
            if (!$this->_rdb) {
                $this->_rdb = new HandlerSocket($this->_host, $this->_rport);
            }
            return $this->_rdb;
        } else {
            if (!$this->_db) {
                $this->_db = new HandlerSocket($this->_host, $this->_wrport);
            }
            return $this->_db;
        }
    }

    public function openIndex($type, $table, $fields, $index,$readonly = false) {
        $db = $this->getInstance($readonly);
        if (!$db->openIndex($type, $this->_dbname, $this->_transDbName($table), $index, $fields)) {
            throw new Exception($db->getError());
        }
        return $db;
    }

    public function fetchIn($table, $fields, $InArr, $index = HandlerSocket::PRIMARY) {
        return $this->openIndex(1, $table, $fields, $index,true)
                        ->executeSingle(1, '=', null, count($InArr), 0, null, null, null, 0, $InArr);
    }

    public function fetchRow($table, $fields, $valArr, $index = HandlerSocket::PRIMARY) {
        $res=$this->openIndex(1, $table, $fields, $index,true)
                        ->executeSingle(1, '=', $valArr, 1, 0);      
        return $res?$res[0]:$res;
    }

    public function fetchAll($table, $fields, $valArr, $limit, $offet = 0, $index = HandlerSocket::PRIMARY) {
        return $this->openIndex(1, $table, $fields, $index,true)
                        ->executeSingle(1, '=', $valArr, $limit, $offet);
    }
    
    public function update($table,$fields,$valArr,$indexVal,$index= HandlerSocket::PRIMARY) {
        return $this->openIndex(2, $table, $fields, $index)
                        ->executeUpdate(2, '=', array($indexVal), $valArr,1, 0);
    }

    public function insert($table, $fields, $valArr, $index = '') {
        return $this->openIndex(3, $table, $fields, $index)
                        ->executeInsert(3, $valArr);
    }

    public function delete($table, $val, $index = HandlerSocket::PRIMARY) {
        return $this->openIndex(4, $table, '', $index)
                        ->executeDelete(4, '=', array($val));
    }

    protected function _transDbName($tblname) {
        return str_replace(self::TABLE_PREFIX_FLAG, $this->_tablePrefix, $tblname);
    }
}

?>