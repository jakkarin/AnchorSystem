<?php namespace system;

/**
 * Model.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

class Model extends Core
{

	public $database = null;

	public $db;

	public function __construct()
	{
		$loadDB = new Database;
		$this->db = $loadDB->conn($this->database);
	}

}