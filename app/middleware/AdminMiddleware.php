<?php namespace app\middleware;

class AdminMiddleware
{
	public function run()
	{
		if (user('role_id') !== '0') {
			echo '<meta charset="utf-8">';
			exit('คุณไม่มีสิทธิ์ที่จะเข้าใช้งานส่วนนี้');
		}
	}
}