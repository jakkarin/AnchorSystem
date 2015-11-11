<?php namespace app\controller;

/**
 * AuthController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;
use app\models\User;

Class AuthController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->user = new User;
	}

	public function index()
	{
		return redirect('');
	}

	public function signin($redirect = null)
	{
		if (auth()) return redirect('');
		if (is_post()) {
			$this->loadHelper('Validator');
			if (captcha()) {
				$email = $_POST['email'];
				$pass = $_POST['login_token'];
				$validate = $this->user->validate($email, $pass);
				if ( ! empty($validate)) {
					$_SESSION['auth'] = $validate;
					$_SESSION['user'] = $this->user->getDetail($validate['id']);
					$_csrf_token = str_rand(32);
					$_SESSION['csrf_token'] = $_csrf_token;
					setcookie('csrf_token', $_csrf_token, 0, '/', '', false, true);
					echo '1';
					return;
				}
			}
			echo '0';
			return;
		} else {
			return $this->view('login', compact('redirect'));
		}
	}
	
	public function getD()
	{
		$Faculty = new \app\models\Faculty;
		$faculty = $Faculty->getFaculty();
		echo json_encode($faculty);
	}

	public function getM($id)
	{
		$Faculty = new \app\models\Faculty;
		$faculty = $Faculty->getMajor($id);
		echo json_encode($faculty);
	}

	public function checkExistUser()
	{
		if (is_post()) {
			if ($this->user->checkExistUser($_POST['email']))
				echo '1';
			echo '0';
		}
	}

	public function register()
	{
		if (is_post()) {
			$this->loadHelper('Validator');
			if (captcha()) {
				$data = [
					'email'		=> validate('email', 'email'),
					'username'	=> validate('required', 'username'),
					'password'	=> password_hash(validate('required', 'register_token'), PASSWORD_BCRYPT),
					'token'		=> str_rand(40)
				];
				if (validator($data)) {
					if ($this->user->checkExistUser($data['email'])) {
						$data2 = [
							'firstname'		=> validate('required', 'firstname'),
							'lastname'		=> validate('required', 'lastname'),
							'nickname'		=> validate('required', 'nickname'),
							'major'			=> validate('required', 'major')
						];
						if (validator($data2)) {
							$this->user->createUser($data, $data2);
							$validate = $this->user->validate($data['email'], $_POST['register_token']);
							if ( ! empty($validate)) {
								$_SESSION['auth'] = $validate;
								$_SESSION['user'] = $this->user->getDetail($validate['id']);
								cache_forgot('user.members.' . user('major'));
								cache_forgot('user.get.members.' . user('major'));
							}
						}
					}
				}
			}
		}
		return redirect('');
	}

	public function signout()
	{
		session_destroy();
		redirect('');
	}
}