<?php namespace app\widgets;

/**
 * Topnav.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Widget;

class Topnav extends Widget
{

	public function run()
	{
		return $this->view('layouts/top-nav');
	}

}