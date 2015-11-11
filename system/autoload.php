<?php

/**
 * autoload.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

//เวลาเริ่มต้นในการประมวลผลเว็บไซต์
// define('APP_START', microtime(true));
// พาธของตั้งแต่ระดับราก
define('ROOT_PATH', str_replace('system/autoload.php', '', str_replace('\\', '/', __FILE__)));
// http or https
define('URL_SCHEME', ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://'));
// domain ของ Server เช่น http://domain.tld/
define('HOST_NAME', URL_SCHEME.(empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']).'/');

function autoload($className)
{
	$className = ltrim($className, '\\');
	$fileName = '';
	$namespace = '';
	if ($lastNsPos = strrpos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	//$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	$fileName .= $className . '.php';

	require_once $fileName;
}

spl_autoload_register('autoload');