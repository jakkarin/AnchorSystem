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

class GbNews extends Model
{

	public $table = 'gbnews';

	public function create($array)
	{
		$array['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->insert($this->table, $array);
	}

	public function update($array)
	{
		$id = array('id' => $array['id']);
		unset($array['id']);
		$array['updated_at'] = date('Y-m-d H:i:s');
		return $this->db->update($this->table, $id, $array);
	}

	public function lists($num = 3)
	{
		return $this->db->select('id, title, updated_at', $this->table)
			->where(array('active' => 1))
			->orderBy('updated_at', 'desc')
			->limit($num)
			->get();
	}

	public function remove($id)
	{
		return $this->db->delete($this->table, array('id' => $id));
	}

	public function all()
	{
		$news = $this->db->select('id, title, updated_at', $this->table)
			->orderBy('updated_at', 'desc')
			->get();
		return empty($news) ? null : $news;
	}

	public function getNews($id)
	{
		$news = $this->db->select('*', $this->table)
			->where(array('id' => $id))
			->get();
		return empty($news['0']) ? null : $news['0'];
	}

}