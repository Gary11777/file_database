<?php

declare(strict_types=1);

class MySQL
{
	public function getLabelData() : array 
	{
		$connection = new PDO('mysql:host=' . CONFIG_DB_HOST . '; dbname=' . CONFIG_DB_NAME . '; charset=' . CONFIG_DB_CHAR, 
			CONFIG_DB_USER, 
			CONFIG_DB_PASS, 
			array( PDO::ATTR_PERSISTENT => false));

		$cashLabel = [];
		foreach($connection->query('SELECT `l_key`, `l_value` FROM label') as $row) {
			$k = $row['l_key'];
			$v = $row['l_value'];
			$cashLabel[$k] = $v;
		}
		return $cashLabel;
		// Закрываем соединение
		$connection = null;
	}
	
		public function getConstData() : array 
	{
		$connection = new PDO('mysql:host=' . CONFIG_DB_HOST . '; dbname=' . CONFIG_DB_NAME . '; charset=' . CONFIG_DB_CHAR, 
			CONFIG_DB_USER, 
			CONFIG_DB_PASS, 
			array( PDO::ATTR_PERSISTENT => false));

		$cashConst = [];
		foreach($connection->query('SELECT `c_key`, `c_value` FROM const') as $row) {
			$k = $row['c_key'];
			$v = $row['c_value'];
			$cashConst[$k] = $v;
		}
		return $cashConst;
		// Закрываем соединение
		$connection = null;
	}
	
	public function getButtonData() : array 
	{
		$connection = new PDO('mysql:host=' . CONFIG_DB_HOST . '; dbname=' . CONFIG_DB_NAME . '; charset=' . CONFIG_DB_CHAR, 
			CONFIG_DB_USER, 
			CONFIG_DB_PASS, 
			array( PDO::ATTR_PERSISTENT => false));

		$cashButton = [];
		foreach($connection->query('SELECT `b_key`, `b_value` FROM button') as $row) {
			$k = $row['b_key'];
			$v = $row['b_value'];
			$cashButton[$k] = $v;
		}
		return $cashButton;
		// Закрываем соединение
		$connection = null;
	}
	
}