<?php namespace app\middleware;

class CsrfMiddleware
{
	public function run()
	{
		if (is_post()) {
			$pattern = '/(\/auth\/signin\/|\/auth\/register\/)/';
			if ( ! preg_match($pattern, $_SERVER['REQUEST_URI'])) {
				if (empty($_POST['csrf_token']) || empty($_COOKIE['csrf_token'])) {
					header("HTTP/1.0 401 Authorization Required");
					exit();
				} else if ($_POST['csrf_token'] !== $_COOKIE['csrf_token']) {
					header("HTTP/1.0 401 Authorization Required");
					exit();
				} unset($_POST['csrf_token']);
			}
		}
	}
}