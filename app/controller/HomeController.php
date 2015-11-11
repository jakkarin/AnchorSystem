<?php namespace app\controller;

/**
 * HomeController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;

Class HomeController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->middleware('Auth');
		$this->loadHelper('User');
	}

	public function index()
	{
		$title = 'หน้าแรก';
		return $this->view('index', compact('title'));
	}

	public function getJson()
	{
		$news = cache_remember('p.getJson.news.' . user('major'), function() {
			$news = new \app\models\News;
			return json_encode($news->getNewsList());
		});
		$user = cache_remember('user.get.members.' . user('major'), function() {
			$user = new \app\models\User;
			return json_encode($user->getMembers(true));
		});
		$gbnews = cache_remember('home.gbnews', function() {
			$gbnews = new \app\models\GbNews;
			return json_encode($gbnews->lists(6));
		});
		echo '{ "news":' . $news . ', "users":' . $user . ', "gbnews":' . $gbnews . ' }';
	}

	public function ledger($install)
	{
		if ($install === 'install') {
			$_path = APP_PATH . 'contents/users/ledger/' . auth('id') . '/install.lock';
			if ( ! file_exists($_path))
				file_put_contents($_path, '');
			redirect('ledger');
		} else if ($install === 'uninstall') {
			$files_get = glob(APP_PATH . 'contents/users/ledger/' . auth('id') . '/*');
			foreach ($files_get as $value) {
				@unlink($value);
			}
		}
	}

}