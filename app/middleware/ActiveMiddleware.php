<?php namespace app\middleware;

class ActiveMiddleware
{
	public function run()
	{
		if (auth('active') === '0') {
			redirect('');
			exit();
		}
	}
}