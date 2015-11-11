<?php namespace system;

/**
 * Controller.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

 class Controller extends Core
{

	public function __construct($parent)
	{
		foreach ($parent as $key => $value) {
			$this->$key = $value;
		} $this->loadHelper('Core');
		$this->middleware('Csrf');
		$this->session = $this->loadClass('system\Session');
		$this->session->sessionStart();
	}

	protected function view($path, $array = null)
	{
		return $this->loadClass('system\View')->make($path, $array);
	}

	protected function middleware($middleware)
	{
		$this->loadClass('app\middleware\\' . $middleware . 'Middleware')->run();
	}

}