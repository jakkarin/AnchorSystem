<?php namespace system;

/**
 * config.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

class Config
{

	public static function parseConfig($config, $reConf = false)
	{
		$path = APP_PATH.'app/config/'.$config.'.php';
		if ($reConf) {
			return (object) @require $path;
		} else {
			return (object) @require_once $path;
		}
	}

}