<?php
/*
 * Created on 2011-3-1
 *
 * @author yijian.cen
 *
 */
interface System_Db_Adapter_Interface {

	public function connect($config);

	public function query();

	public function select();

	public function insert();

	public function delete();

	public function update();

	public function fetchAll();

	public function fetchAssoc();

	public function fetchField();

	public function fetchOne();

	public function fetchCol();
}
?>