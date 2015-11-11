<?php namespace app\controller;

/**
 * UserController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;
use app\models\User;

Class UserController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->middleware('Auth');
		$this->middleware('Active');
		$this->loadHelper('User');
	}

	public function index()
	{
		$this->view('user');
	}

	public function i($id)
	{
		$ex = explode('-', $id);
		if (preg_match('/^[0-9]+$/', $ex['0'])) {
			$get = cache_remember('user.i.' . $id, function() use ($id) {
				$user = new User;
				$data = $user->getById($id);
				if ( ! empty($data))
					return $data;
				return false;
			});
			if( ! empty($get) && $get['user_detail']['major'] === user('major'))
				return $this->view('member', $get);
		}
		return $this->view('errors/404');
	}

	public function e($select)
	{
		switch ($select) {
			case 'avatar':
				$this->eAvatar();
				cache_forgot('user.members.' . user('major'));
				break;
			
			case 'cover':
				$this->eCover();
				break;

			case 'user_detail':
				$this->eDetail();
				break;

			case 'chpass':
				$this->updatePass();
				break;

			case 'allow':
				if (role_check(1)):
					if (preg_match('/^[0-9]+$/', $_POST['id'])):
						$user = new User;
						$user->uActive($_POST['id']);
						cache_forgot('user.i.' . $_POST['id']);
						cache_forgot('user.inactive.' . $_POST['id']);
						cache_forgot('user.members.' . user('major'));
					endif;
				endif;
				break;

			case 'deny':
				if (role_check(1) && $_GET['id'] !== auth('id')):
					if (preg_match('/^[0-9]+$/', $_GET['id'])):
						$user = new User;
						$user->delUser($_GET['id']);
						cache_forgot('user.i.' . $_GET['id']);
					endif;
				endif;
				break;
		}
	}

	public function members()
	{
		$data = cache_remember('user.members.' . user('major'), function() {
			$user = new User;
			return $user->getMembers();
		}, 1440);
		return $this->view('members', compact('data'));
	}

	public function get($act)
	{
		switch ($act) {
			case 'members':
				echo cache_remember('user.get.members.' . user('major'), function() {
					$user = new User;
					return json_encode($user->getMembers(true));
				}, 1440);
				break;
		}
	}

	private function updatePass()
	{
		if (is_post()) {
			$this->loadHelper('Validator');
			$data = [
				'password'		=> hash('SHA256', validate('required', 'pastoken')),
				'oldpass'		=> validate('required', 'old_pass'),
			];
			if (validator($data)) {
				if (password_verify(hash('SHA256',$data['oldpass']), auth('password'))) {
					$user = new User;
					$user->setPass(auth('id'), $data['password']);
				}
			}
		}
	}

	private function eDetail()
	{
		if (is_post()) {
			$this->loadHelper('Validator');
			$data = [
				'firstname'		=> validate('required', 'firstname'),
				'lastname'		=> validate('required', 'lastname'),
				'nickname'		=> validate('required', 'nickname')
			];
			if (validator($data)) {
				$data['phone'] = $_POST['phone'];
				$data['facebook'] = $_POST['facebook'];
				$data['line'] = $_POST['line'];
				$data['signature'] = strip_tags_content($_POST['signature'], '<script><object>', true);
				$user = new User;
				$user->setDetail(auth('id'), $data);
				$_SESSION['user'] = $user->getDetail(auth('id'));
				cache_forgot('user.i.' . auth('id'));
			}
		}
	}

	private function eAvatar()
	{
		if ( ! empty($_FILES['avatar'])) {
			$img_w = 140;
			$img_h = 140;
			$jpeg_quality = 90;
			$dst_r = ImageCreateTrueColor($img_w, $img_h);
			$src = $_FILES['avatar']['tmp_name'];
			$img_r = $this->checkIMG(getimagesize($src)['mime'],$src);
			imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $img_w, $img_h, $_POST['w'], $_POST['h']);
			imagejpeg($dst_r, APP_PATH . 'contents/users/avatars/' . auth('id') . '.jpg', $jpeg_quality);
			imagedestroy($dst_r);
			imagedestroy($img_r);
			if (empty(user('avatar'))) {
				$user = new User;
				$user->setAvatar(auth('id'), auth('id') . '.jpg');
				$_SESSION['user']['avatar'] = auth('id') . '.jpg';
				cache_forgot('user.i.' . auth('id'));
			}
		}
	}

	private function eCover()
	{
		if ( ! empty($_FILES['cover'])) {
			$img_w = 900;
			$img_h = 200;
			$jpeg_quality = 90;
			$dst_r = ImageCreateTrueColor($img_w, $img_h);
			$src = $_FILES['cover']['tmp_name'];
			$getSize = getimagesize($src);
			$img_r = $this->checkIMG($getSize['mime'], $src);
			$dst_ratio = $getSize['0'] / $getSize['1'];
			$img_ratio = $img_w / $img_h;
			if ($dst_ratio >= $img_ratio) {
				$dst_h = $getSize['1'];
				$dst_w = $dst_h / $img_ratio;
				$dst_x = ($getSize['0'] - $dst_w) / 2;
				$dst_y = 0;
			} else {
				$dst_w = $getSize['0'];
				$dst_h = $dst_w / $img_ratio;
				$dst_x = 0;
				$dst_y = ($getSize['1'] - $dst_h) / 2;
			}
			imagecopyresampled($dst_r, $img_r, 0, 0, $dst_x, $dst_y, $img_w, $img_h, $dst_w, $dst_h);
			imagejpeg($dst_r, APP_PATH . 'contents/users/covers/' . auth('id') . '.jpg', $jpeg_quality);
			imagedestroy($dst_r);
			imagedestroy($img_r);
			if (empty(user('cover'))) {
				$user = new User;
				$user->setCover(auth('id'), auth('id') . '.jpg');
				$_SESSION['user']['cover'] = auth('id') . '.jpg';
				cache_forgot('user.i.' . auth('id'));
			}
		}
	}

	private function checkIMG($mime,$src)
	{
		switch ($mime) {
			case 'image/jpeg':
				return imagecreatefromjpeg($src);
				break;

			case 'image/png':
				return imagecreatefrompng($src);
				break;

			case 'image/bmp':
				return imagecreatefromwbmp($src);
				break;

			case 'image/gif':
				return imagecreatefromgif($src);
				break;
		}
	}

}