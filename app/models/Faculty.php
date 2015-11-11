<?php namespace app\models;

/**
 * Faculty.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Model;

class Faculty extends Model
{

	public $table = 'faculty';

	public $table2 = 'department';

	public $table3 = 'major';

	public function getFaculty() {
		return $this->db->select('*', $this->table)->get();
	}

	public function getMajor($id) {
		return $this->db->select('*', $this->table3)
			->where(['faculty' => $id])
			->get();
	}

	public function getAllMajor()
	{
		return $this->db->select('*', $this->table3)->get();
	}

	public function getMajorData($id)
	{
		$db_cache = $this->db->select('*', $this->table3)
			->where(['id' => $id])
			->get();
		if ( ! empty($db_cache)) {
			return $db_cache['0'];
		}
		return [];
	}

	public function getData()
	{
		$faculty = $this->db->select('*', $this->table)->get();
		$department = $this->db->select('*', $this->table2)->get();
		$array = array();
		foreach ($faculty as $k1 => $v1) {
			$array[$v1['id']] = $v1;
			foreach ($department as $v2) {
				if ($v2['faculty'] === $v1['id']) {
					$array[$v1['id']]['sub'][] = $v2;
				}
			}
		}
		return $array;
	}

	public function getAll()
	{
		$faculty = $this->db->select('*', $this->table)->get();
		$department = $this->db->select('*', $this->table2)->get();
		$major = $this->db->select('*', $this->table3)->get();
		$array = array();
		foreach ($faculty as $k1 => $v1) {
			$array[$v1['id']] = $v1;
			foreach ($department as $v2) {
				if ($v2['faculty'] === $v1['id']) {
					$array[$v1['id']]['sub'][$v2['id']] = $v2;
					foreach ($major as $v3) {
						if ($v3['department'] === $v2['id']) {
							$array[$v1['id']]['sub'][$v2['id']][] = $v3;
						}
					}
				}
			}
		}
		return $array;
	}

}