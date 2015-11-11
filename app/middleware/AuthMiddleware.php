<?php namespace app\middleware;

class AuthMiddleware
{
	public function run()
	{
		if (empty(auth())) {
			if ($_SERVER['REQUEST_URI'] === REG_URI):
				redirect('auth/signin');
				exit();
			endif;
			if (REG_URI === '/')
				$request = base64_encode(ltrim($_SERVER['REQUEST_URI'], '/'));
			else 
				$request = base64_encode(str_replace(REG_URI, '', $_SERVER['REQUEST_URI']));
			redirect('auth/signin/' . $request);
			exit();
		}
	}
}