<?php namespace system;

/**
 * Widget.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

 class Widget extends Core
{

	public function __construct() {}

	public function view($path, $array = null)
	{
		return $this->loadClass('system\View')->make($path, $array);
	}

}