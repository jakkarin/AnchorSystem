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

class InActive extends Widget
{

	public function run()
	{
		$data = cache_remember('user.inactive.' . auth('id'), function() {
			$user = new \app\models\User;
			return $user->getActiveData(auth('id'));
		});
		if ($data['active'] === '1') {
			$_SESSION['auth']['active'] = '1';
			cache_forgot('user.inactive.' . auth('id'));
			echo '<div class="alert alert-success">คุณได้รับการยืนยันแล้วว่า ข้อมูลถูกต้องและเป็นสมาชิกของสาขานี้ กรุณา reload page</div>';
		}
	}

}