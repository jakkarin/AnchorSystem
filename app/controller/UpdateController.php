<?php namespace app\controller;

/**
 * UpdateController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;
use system\Database;

Class UpdateController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->middleware('Auth');
		$this->middleware('Admin');
		$load = new Database;
		$this->db = $load->conn();
	}

	public function index()
	{
		echo '[DB] Updated bl_gbnews.';
		try {
			$this->db->query("ALTER TABLE `bl_gbnews` ADD `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `id`;");
			echo ' OK ! <br />';
		} catch (\PDOException $e) {
			echo ' fail ! <br />';
		}
	}
}