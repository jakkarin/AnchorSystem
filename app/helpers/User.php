<?php

/**
 * user.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

if ( ! function_exists('role_check')) {
	function role_check($plan = 3) {
		switch ($plan) {
			case 0:
				return user('role_id') === '0';
				break;

			case 1:
				return in_array(user('role_id'), ['0','1','2']);
				break;
			
			case 2:
				return in_array(user('role_id'), ['0','1','2','3']);
				break;

			case 3:
				return in_array(user('role_id'), ['0','1','2','3','4']);
				break;
		}
	}
}

if ( ! function_exists('position')) {
	function position($i) {
		switch ($i) {
			case 0:
				return 'ผู้ดูแลระบบ';
				break;

			case 1:
				return 'ประธาน';
				break;
			
			case 2:
				return 'รองประธาน';
				break;

			case 3:
				return 'เลขานุการ';
				break;

			case 4:
				return 'เหรัญญิก';
				break;
			
			case 5:
				return 'สมาชิก';
				break;
		}
	}
}