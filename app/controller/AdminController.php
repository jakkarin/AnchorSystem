<?php namespace app\controller;

/**
 * AdminController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;

Class AdminController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->middleware('Auth');
		$this->middleware('Admin');
	}

	public function index()
	{
		return $this->view('admin/index');
	}

	public function p($action = null, $id = null)
	{
		switch ($action) {
			case 'news':
				if (is_post()):
					$gbn = new \app\models\GbNews;
					$data = array(
						'title'		=> $_POST['title'],
						'content'	=> $_POST['content']
					);
					if ($_POST['active'] === 'on')
						$data['active'] = 1;
					else
						$data['active'] = 0;
					if ( ! empty($_POST['action'])):
						$data['id'] = $_POST['id'];
						$gbn->update($data);
						cache_forgot('home.gbnews');
						cache_forgot('p.gbn.' . $data['id']);
					else:
						$gbn->create($data);
						cache_forgot('home.gbnews');
					endif;
					return redirect('admin/p/news');
				else:
					$gbn = new \app\models\GbNews;
					$gbn = $gbn->all();
					$data = empty($gbn) ? array() : $gbn;
					return $this->view('admin/gbnews', compact('data'));
				endif;
				break;
			
				case 'write':
					if( ! empty($id)):
						$id = intval($id);
						$news = new \app\models\GbNews;
						$news = $news->getNews($id);
						if (empty($news))
							return $this->view('errors/404');
						return $this->view('admin/gbnews_write', compact('news'));
					endif;
					return $this->view('admin/gbnews_write');
					break;

				case 'destroy':
					echo $_POST['id'];
					if(is_post()):
						$news = new \app\models\GbNews;
						$news->remove($_POST['id']);
					endif;
					break;

			default:
				return redirect('admin');
				break;
		}
	}

	public function chMajor()
	{
		$_SESSION['user']['major'] = $_POST['mid'];
	}

	public function clCache()
	{
		$files = glob(APP_PATH . 'app/caches/*');
		foreach($files as $file){
			if(is_file($file))
				@unlink($file);
		}
		redirect('back');
	}

	public function clSession()
	{
		$files = glob(APP_PATH . 'app/session/*');
		foreach($files as $file){
			if(is_file($file))
				@unlink($file);
		}
		redirect('back');
	}
}