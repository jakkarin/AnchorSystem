<?php namespace app\widgets;

/**
 * LoginBox.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Widget;

class LoginBox extends Widget
{

	public function run()
	{
		if (role_check(0)) {
			$data = cache_remember('admin.major.list', function() {
				$major = new \app\models\Faculty;
				return $major->getAllMajor();
			});
			return $this->view('layouts/loginbox', compact('data'));
		}
		return $this->view('layouts/loginbox');
	}

}