<?php namespace system;

/**
 * Database.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

class Database extends Core
{

	public function __construct()
	{
		$this->config['db'] = Config::parseConfig('db', true);
	}

	public function conn($database = null)
	{
		switch ($this->config['db']->driver) {
			case 'pdo':
				$className = 'PDO_Driver';
				break;
		}
		return $this->loadClass('system\drivers\\' . $className, $database);
	}

}