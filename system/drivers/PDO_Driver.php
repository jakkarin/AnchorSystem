<?php namespace system\drivers;

/**
 * pdo.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

Class PDO_Driver
{
	public $conn;

	public $prepare;

	public function __construct($parent, $db = null)
	{
		foreach ($parent as $key => $value) {
			$this->$key = $value;
		}
		$hostname = $this->config['db']->hostname;
		$dbname = empty($db) ? $this->config['db']->dbname : $db;
		$username = $this->config['db']->username;
		$password = $this->config['db']->password;
		try {
			$this->conn = new \PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
			$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->conn->exec('set names ' . $this->config['db']->charset);
		} catch(\PDOException $e) {
			die('Error: ' . $e->getMessage());
		}
	}

	public function query($query_string)
	{
		return $this->conn->exec($query_string);
	}

	public function select($field = '*', $table)
	{
		if (is_string($field)) {
			$this->prepare = 'SELECT ' . $field . ' FROM ' . $this->config['db']->prefix . $table;
		}
		return $this;
	}

	public function where($id)
	{
		if (is_array($id)) {
			$ids = '';
			$i = 0;
			foreach ($id as $key => $value) {
				$ids.= $i === 0 ? "$key='$value'" : ", $key='$value'";
				$i++;
			}
			$this->prepare.= " WHERE $ids";
			return $this;
		}
	}

	public function where_raw($str)
	{
		$this->prepare.= " WHERE $str";
		return $this;
	}

	public function raw($str)
	{
		$this->prepare.= "$str";
		return $this;
	}

	public function limit($int, $offset = null)
	{
		$this->prepare.= " LIMIT $int";
		if (!empty($offset)) {
			$this->prepare.= " OFFSET $offset";
		}
		return $this;
	}

	public function orderBy($column, $type = 'DESC')
	{
		$type = strtoupper($type);
		$this->prepare.= " ORDER BY $column $type";
		return $this;
	}

	public function get($obj = false)
	{
		$exec = $this->conn->prepare($this->prepare);
		$exec->execute();
		if ($obj)
			$exec->setFetchMode(\PDO::FETCH_OBJ);
		else
			$exec->setFetchMode(\PDO::FETCH_ASSOC);
		return $exec->fetchAll();
	}

	public function insert($table, $set = null, $andGet = false)
	{
		if (is_array($set)) {
			$field = '';
			$values = '';
			$i = 0;
			$arr = array();
			foreach ($set as $key => $value) {
				$field.= $i === 0 ? $key : ', ' . $key;
				$values.= $i === 0 ? ":$key" : ", :$key";
				$arr[$key] = $value;
				$i++;
			}
			$sql = 'INSERT INTO ' . $this->config['db']->prefix . $table . ' (' . $field . ') VALUES (' . $values . ')';
			$exec = $this->conn->prepare($sql);
			if ( ! $andGet) {
				return $exec->execute($arr);
			} else {
				$exec->execute($arr);
				return $this->conn->lastInsertId();
			}
		}
	}

	public function update($table, $id, $set = null)
	{
		$table = $this->config['db']->prefix . $table;
		if (is_array($set) && is_array($id)) {
			$values = '';
			$i = 0;
			$arr = [];
			foreach ($set as $key => $value) {
				$values.= $i === 0 ? "$key=:$key" : ", $key=:$key";
				$arr[$key] = $value;
				$i++;
			}
			$i = 0;
			$ids = '';
			foreach ($id as $key2 => $value2) {
				$ids.= $i === 0 ? "$key2='$value2'" : ", $key2='$value2'";
				$i++;
			}
			$sql = "UPDATE $table SET $values WHERE $ids";
			$exec = $this->conn->prepare($sql);
			return $exec->execute($arr);
		}
	}

	public function delete($table, $id) {
		if (is_array($id)) {
			$i = 0;
			$ids = '';
			$arr = [];
			foreach ($id as $key => $value) {
				$ids.= $i === 0 ? "$key=:$key" : ", $key=:$key";
				$arr[$key] = $value;
				$i++;
			}
			$table = $this->config['db']->prefix . $table;
			$sql = "DELETE FROM $table WHERE $ids";
			$exec = $this->conn->prepare($sql);
			return $exec->execute($arr);
		}
	}
}