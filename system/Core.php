<?php namespace system;

/**
 * core.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

class Core
{

	public $config = array();
	
	public function __construct()
	{
		$this->config['app'] = Config::parseConfig('app');
		define('TEMPLATE_PATH', APP_PATH . 'app/views/' . $this->config['app']->template . '/');
		define('APP_URL', $this->config['app']->url . (empty($this->config['app']->index) ? '' : $this->config['app']->index . '/'));
		define('ASSET_URL', $this->config['app']->url . 'app/views/' . $this->config['app']->template . '/');
		define('CONTENT_URL', $this->config['app']->url . 'contents/');
	}

	/**
	 * ใช้สำหรับสร้าง Class
	 *
	 * @param string $className ชื่อ class (CamelCase)
	 * @param mixed $param (option)
	 *
	 * @return stdClass
	 */
	public function loadClass($className, $param = null)
	{
		$obj = new $className($this, $param);
		return $obj;
	}

	public function loadHelper($helperName)
	{
		require_once APP_PATH . 'app/helpers/' . $helperName . '.php';
	}

}