<?php

/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 * @use PDO_mysql.so 
 */

class System_Db_Adapter_Mysql {

    protected $_db;
    protected $_sth;
    protected $_sql;
    protected $_bind;
    protected $_tblPrefix;

    const TABLE_PREFIX_FLAG = '#@__';

    public function connect($db_host, $db_user, $db_pwd, $db_name, $tbl_prefix) {
        $this->_db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pwd);
        $this->_db->exec("SET CHARACTER SET utf8");
        $this->_tblPrefix = $tbl_prefix;
        return $this;
    }

    public function select(array $fieldsArr, $calc = '') {
        $this->_bind = array();
        $this->_sql = 'SELECT ' . $calc;
        if (isset($fieldsArr[0])) { //single table
            $this->_sql .=implode(',', $fieldsArr);
        } else { //multiple join
            foreach ($fieldsArr as $as => $fields) {
                $as.='.';
                $this->_sql .=$as . implode(',' . $as, $fields) . ',';
            }
            $this->_sql = rtrim($this->_sql, ',');
        }
        return $this;
    }

    public function selectCal(array $fieldsArr) {
        return $this->select($fieldsArr, ' SQL_CALC_FOUND_ROWS ');
    }

    public function fetchTotal() {
        return $this->_db->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
    }

    public function from($table, $as = '') {
        $this->_sql.= ' FROM ' . $this->_transTblName($table) . ' ' . $as;
        return $this;
    }

    public function join($table, $as, $on, $type = 'INNER') {
        $this->_sql.=' ' . $type . ' JOIN ' . $this->_transTblName($table) . ' ' . $as . ' ON ' . $on;
        return $this;
    }

    public function where($cond, array $bindArr) {
        $this->_sql.=' WHERE ' . $cond;
        $this->_bind = $bindArr;
        return $this;
    }

    public function orderby($fields) {
        $this->_sql.=' ORDER BY ' . $fields;
        return $this;
    }

    public function limit($start, $limit) {
        $this->_sql.=' LIMIT ' . $start . ',' . $limit;
        return $this;
    }

    public function exec($fetchType = 'fetchAll', $fetch_style = PDO::FETCH_BOTH) {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->$fetchType($fetch_style);
    }

    public function query($sql,$fetchType='fetchAll',$fetch_style=PDO::FETCH_ASSOC) {
        $sth = $this->_db->prepare($this->_transTblName($sql));
        $sth->execute();
        return $sth->$fetchType($fetch_style);
    }

    public function insert($table, array $bind) {
        $count = count($bind);
        $count = $count * 2 - 1;
        $this->_sql = 'INSERT INTO ' . $this->_transTblName($table) . ' (`' . implode('`,`', array_keys($bind)) . '`) VALUES(' . str_pad('?', $count, ',?') . ');';
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute(array_values($bind));
        return $this->_db->lastInsertId();
    }

    public function update($table, $content, $cond, array $bindArr) {
        $this->_sql = 'UPDATE ' . $this->_transTblName($table) . ' SET ' . $content . ' WHERE ' . $cond;
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($bindArr);
        return $this->_sth->rowCount();
    }

    public function delete($table, $cond, array $bindArr) {
        $this->_sql = 'DELETE FROM ' . $this->_transTblName($table) . ' WHERE ' . $cond;
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($bindArr);
        return $this->_sth->rowCount();
    }

    /**
     * 取回结果集中所有字段的值,作为连续数组返回
     * */
    public function fetchNum() {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * 取回结果集中所有字段的值,作为关联数组返回
     * */
    public function fetchAssoc() {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 取回所有结果行的第n个字段名值
     * */
    public function fetchCol($index = 0) {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchAll(PDO::FETCH_COLUMN, $index);
    }

    /**
     * 只取回结果集的第一行
     * */
    public function fetchRow($fetch_style = PDO::FETCH_ASSOC) {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetch($fetch_style);
    }

    /**
     * 只取回第n个字段值
     * */
    public function fetchOne($index = 0) {
        $this->_sth = $this->_db->prepare($this->_sql);
        $this->_sth->execute($this->_bind);
        return $this->_sth->fetchColumn($index);
    }

    public function beginTransaction() {
        $this->_db->beginTransaction();
    }

    public function rollback() {
        $this->_db->rollback();
    }

    public function commit() {
        $this->_db->commit();
    }

    public function getDb() {
        return $this->_db;
    }

    protected function _transTblName($dbName) {
        return str_replace(self::TABLE_PREFIX_FLAG, $this->_tblPrefix, $dbName);
    }

}

?>