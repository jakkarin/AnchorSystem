<?php namespace system;

/**
 * View.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

 class View extends Core
{

	public function __construct($parent)
	{
		foreach ($parent as $key => $value) {
			$this->$key = $value;
		}
	}

	public function make($path, $array=null)
	{
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				$$key = $value;
			}
		}
		include TEMPLATE_PATH . $path . '.blade.php';
	}

}