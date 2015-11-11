<?php namespace app\models;

/**
 * User.php.
 * Model
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Model;

class User extends Model
{
	public function validate($email, $pass)
	{
		$gU_Check = $this->db->select('*', 'user')->where(['email' => $email])->get();
		if ( ! empty($gU_Check)) {
			$gU = $gU_Check['0'];
			if (password_verify($pass, $gU['password'])) {
				return $gU;
			}
		}
		return array();
	}

	public function getActiveData($user_id)
	{
		return $this->db->select('id, active', 'user')->where(['id' => $user_id])->get()['0'];
	}

	public function getDetail($user_id)
	{
		return $this->db->select('*', 'user_detail')->where(['user_id' => $user_id])->get()['0'];
	}

	public function setAvatar($id, $name)
	{
		$this->db->update('user_detail', ['user_id' => $id], ['avatar' => $name]);
	}

	public function uActive($id)
	{
		return $this->db->update('user', ['id' => $id], ['active' => 1]);
	}

	public function setPass($id, $pass)
	{
		return $this->db->update('user', ['id' => $id], [
				'password' => password_hash($pass, PASSWORD_BCRYPT),
				'updated_at' => date('Y-m-d H:i:s')
			]);
	}

	public function setDetail($id, $data)
	{
		$this->db->update('user_detail', ['user_id' => $id], $data);
	}

	public function delUser($id)
	{
		$this->db->delete('user',['id' => $id]);
		$this->db->delete('user_detail',['user_id' => $id]);
	}

	public function setCover($id, $name)
	{
		$this->db->update('user_detail', ['user_id' => $id], ['cover' => $name]);
	}

	public function getById($id)
	{
		$user = $this->db->select('*', 'user')->where(['id' => $id])->get();
		if ( ! empty($user)) {
			$user_detail = $this->db->select('*', 'user_detail')->where(['user_id' => $id])->get();
			$user = $user['0'];
			$user_detail = $user_detail['0'];
			return compact('user','user_detail');
		}
		return null;
	}

	public function checkExistUser($email)
	{
		return empty($this->db->select('*', 'user')->where(['email' => $email])->get());
	}

	public function getMembers($cp = false)
	{
		if ($cp) : $where_raw = 'major=' . user('major') . ' AND role_id IN (1,2,3,4)';
		else : $where_raw = 'major=' . user('major');
		endif;
		return $this->db->select('user.active, detail.id, detail.user_id, detail.role_id, detail.firstname, detail.nickname, detail.avatar', 'user_detail AS detail')
			->raw(" LEFT JOIN bl_user AS user ON detail.user_id=user.id")
			->where_raw($where_raw)
			->orderBy('role_id', 'asc')
			->get();
	}

	public function createUser($arr, $arr2)
	{
		$arr['created_at'] = date('Y-m-d H:i:s');
		$last_id = $this->db->insert('user', $arr, true);
		$arr2['user_id'] = $last_id;
		$arr2['role_id'] = 5;
		return $this->db->insert('user_detail', $arr2);
	}
}