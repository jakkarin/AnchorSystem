<?php namespace system;

/**
 * main.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

class Route extends Core
{

	public function __construct($parent)
	{
		foreach ($parent as $key => $value) {
			$this->$key = $value;
		}
	}

	public function run()
	{
		$app = $this->config['app'];
		$reg_uri = $app->sub_folder . $app->index . '/';
		if ($reg_uri === '/'): $request_uri = ltrim(rawurldecode($_SERVER['REQUEST_URI']), '/');
		else: $request_uri = str_replace($reg_uri, '', rawurldecode($_SERVER['REQUEST_URI']));
		endif;
		define('REG_URI', $reg_uri);
		$controller = explode('/', $request_uri);
		if ($controller['0'] === '')
			$controller = array($this->config['app']->primary);
		return $this->parseRoute($controller);
	}

	public function parseRoute($controller) {

		if (file_exists(APP_PATH . 'app/controller/' . ucfirst($controller['0']) . 'Controller.php')) {
			$load = $this->loadClass('app\controller\\' . ucfirst($controller['0']) . 'Controller');
			if (empty($controller['1'])) {
				return $load->index();
				exit();
			} else {
				$method = $controller['1'];
				unset($controller['0']);
				unset($controller['1']);
				if (method_exists($load, $method)) {
					$reflectionMethod = new \ReflectionMethod($load, $method);
					$reflectionMethod->invokeArgs($load, $controller);
					return;
					exit();
				}
			}
		}
		die('404 page not found.');
		exit();
	}

}