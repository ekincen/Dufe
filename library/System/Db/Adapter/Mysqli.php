<?php

/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */

class System_Db_Adapter_MysqliTest {

    protected $_dbLink;
    protected $_result;
    protected $_tablePrefix;
    protected $_sql;

    const TABLE_PREFIX_FLAG = '#@__';

    public function connect($db_host, $db_user, $db_pwd, $db_name, $tbl_prefix) {
        if (!extension_loaded('mysqli'))
            throw new Exception('No extension with mysqli');
        $this->_dbLink = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
        $this->_dbLink->set_charset('UTF8');
        $this->_tablePrefix = $tbl_prefix;
        return $this;
    }

    public function query($sql) {
        return mysqli_query($this->_dbLink, $this->_transSql($sql));
    }

    public function select($table, array $col, $where = '', $fetchMode = 'fetchAssoc', $orderby = '', $limit = '', $arg = '') {
        $col = '`' . implode('`,`', $col) . '`';
        $where = $where ? ' WHERE ' . $where : $where;
        $orderby = $orderby ? ' ORDER BY ' . $orderby : $orderby;
        $this->_sql = 'SELECT ' . $col . ' FROM ' . $table . $where . $orderby . $limit;
        return $this->$fetchMode($this->_sql, $arg);
    }

    public function selectTotal($table, $where, $col = 'Id') {
        $this->_sql = 'SELECT SQL_CALC_FOUND_ROWS `' . $col . '` FROM ' . $table . ' WHERE ' . $where;
        $this->query($this->_sql);
        return $this->fetchOne('SELECT FOUND_ROWS();');
    }

    public function insert($table, array $bind) {
        $this->_sql = 'INSERT into `' . $table . '`(`' . implode('`,`', array_keys($bind)) . '`)VALUES("' . implode('","', array_values($bind)) . '");';
        $this->query($this->_sql);
        return $this->getExecRows();
    }

    public function update($table, array $bind, $where, $incr = true) {
        $statement = array();
        if ($incr) {
            foreach ($bind as $col => $val) {
                $statement[] = '`' . $col . '` = ' . $val;
            }
        } else {
            foreach ($bind as $col => $val) {
                $statement[] = '`' . $col . '` = "' . $val . '"';
            }
        }
        $statement = implode(',', $statement);
        $this->_sql = 'UPDATE `' . $table . '` SET ' . $statement . ' WHERE ' . $where . ';';
        $this->query($this->_sql);
        return $this->getExecRows();
    }

    public function getInsertId() {
        return mysqli_insert_id($this->_dbLink);
    }

    public function getExecRows() {
        return ($rows = mysqli_affected_rows($this->_dbLink)) > 0 ? $rows : false;
    }

    public function delete($table, $where = '') {
        $this->_sql = 'DELETE FROM `' . $table . '` WHERE ' . $where;
        $this->query($this->_sql);
        return $this->getExecRows();
    }

    public function beginTransaction() {
        $this->_autocommit(false);
    }

    public function rollback() {
        mysqli_rollback($this->_dbLink);
        $this->_autocommit(true);
    }

    public function commit() {
        mysqli_commit($this->_dbLink);
        $this->_autocommit(true);
    }

    /**
     * 取回结果集中所有字段的值,作为连续数组返回
     * */
    public function fetchAll($sql) {
        $result = array();
        if ($this->_result = $this->query($sql)) {
            while ($row = mysqli_fetch_row($this->_result)) {
                $result[] = $row;
            }
            return $result;
        }
    }

    /**
     * 取回结果集中所有字段的值,作为关联数组返回
     * */
    public function fetchAssoc($sql) {
        $result = array();
        if ($this->_result = $this->query($sql)) {
            while ($row = mysqli_fetch_assoc($this->_result)) {
                $result[] = $row;
            }
            return $result;
        }
    }

    /**
     * 取回所有结果行的第一个字段名值
     * */
    public function fetchCol($sql) {
        $result = array();
        if ($this->_result = $this->query($sql)) {
            while ($row = mysqli_fetch_row($this->_result)) {
                $result[] = $row[0];
            }
        }
        return $result;
    }

    /**
     * 只取回结果集的第一行
     * */
    public function fetchRow($sql) {
        return mysqli_fetch_array($this->query($sql), MYSQLI_ASSOC);
    }

    /**
     * 只取回第一个字段值
     * */
    public function fetchOne($sql) {
        $row = mysqli_fetch_row($this->query($sql));
        return $row[0];
    }

    public function getDb() {
        return $this->_dbLink;
    }

    protected function _transSql($sql) {
        return str_replace(self::TABLE_PREFIX_FLAG, $this->_tablePrefix, $sql);
    }

    protected function _autocommit($default = true) {
        mysqli_autocommit($this->_dbLink, $default);
    }

    public function __destruct() {
        if ($this->_result)
            mysqli_free_result($this->_result);
    }

}

?>