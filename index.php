<?php

/**
 * index.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */
define('APP_PATH', dirname(__FILE__).'/');

require_once APP_PATH.'system/autoload.php';

$app = new system\Main;
$app->run();
