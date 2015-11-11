<?php namespace system;

/**
 * Session.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

 class Session
{

	public $config = array();

	public function __construct()
	{
		$this->config['app'] = Config::parseConfig('app',true);
	}

	public function sessionStart($limit = 0, $path = '/', $domain = null, $secure = null)
	{
		session_name($this->config['app']->session_name);
		$https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
		session_save_path(ROOT_PATH . $this->config['app']->session_path);
		session_set_cookie_params($limit, $path, $domain, $https, true);
		if (empty($_COOKIE[$this->config['app']->session_name]))
			session_id(str_rand(60));
		session_start();
		if (self::preventHijecking()) {
			setcookie($this->config['app']->session_name, null, -1);
			self::regenerateSession();
			$_SESSION = array();
			$_SESSION['IPaddress'] = md5($_SERVER['REMOTE_ADDR']);
			$_SESSION['userAgent'] = md5($_SERVER['HTTP_USER_AGENT']);			
		} if (self::validateSession(10800)) {
			$_SESSION = array();
			session_destroy();
			setcookie($this->config['app']->session_name, null, -1);
		}
	}

	public static function regenerateSession()
	{
		session_write_close();
		session_regenerate_id(true);
		session_id(str_rand(60));
		session_start();
	}

	protected static function validateSession($expires = 60)
	{
		if (empty($_SESSION['expires'])) {
			$_SESSION['expires'] = time() + $expires;
			return false;
		} elseif ($_SESSION['expires'] < time()) {
			return true;
		} else {
			return false;
		}
	}

	protected static function preventHijecking()
	{
		if (empty($_SESSION['IPaddress']) || empty($_SESSION['userAgent'])) {
			$_SESSION['IPaddress'] = md5($_SERVER['REMOTE_ADDR']);
			$_SESSION['userAgent'] = md5($_SERVER['HTTP_USER_AGENT']);
			return false;
		} elseif ($_SESSION['IPaddress'] !== md5($_SERVER['REMOTE_ADDR']) || $_SESSION['userAgent'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
			return true;
		}
	}

}