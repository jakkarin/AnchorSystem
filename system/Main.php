<?php namespace system;

/**
 * main.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

class Main extends Core
{

	public function run()
	{
		$this->loadClass('system\Route')->run();
	}

}