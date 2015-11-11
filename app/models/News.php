<?php namespace app\models;

/**
 * News.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Model;

class News extends Model
{

	public $table = 'news';

	public function createNews($array)
	{
		$array['major_id'] = user('major');
		$array['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->insert($this->table, $array);
	}

	public function getNewsList($num = 15)
	{
		return $this->db->select('id, title, readIn, updated_at', $this->table)
			->where(['major_id' => user('major')])
			->orderBy('updated_at', 'desc')
			->limit($num)
			->get();
	}

	public function countNews()
	{
		$count = $this->db->select('COUNT(id) AS count', $this->table)
			->where(['major_id' => user('major')])
			->get();
		return (int) $count['0']['count'];
	}

	public function addKnow($id, $set)
	{
		return $this->db->update('news', ['id' => $id], $set);
	}

	public function delete($id)
	{
		return $this->db->delete('news',['id' => $id]);
	}

	public function getNews($id)
	{
		$data = $this->db->select('*', $this->table)
			->where(['id' => $id])
			->get();

		return empty($data['0']) ? [] : $data['0'];
	}

	public function updateNews($set, $id)
	{
		return $this->db->update('news', ['id' => $id], $set);
	}

}