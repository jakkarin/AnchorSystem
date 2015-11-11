<?php namespace app\controller;

/**
 * PController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;

Class PController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->middleware('Auth');
		$this->middleware('Active');
		$this->loadHelper('User');
	}

	public function index()
	{
		redirect('');
	}

	public function getJson($action)
	{
		switch ($action) {
			case 'news':
				echo cache_remember('p.getJson.news.' . user('major'), function() {
					$news = new \app\models\News;
					return json_encode($news->getNewsList());
				});
				break;
		}
	}

	public function e($act, $value = null)
	{
		if (role_check()) {
			switch ($act) {
				case 'news':
					$this->eNews($value);
					break;

				case 'del':
					if (is_post()):
						$this->loadHelper('Validator');
						$id = validate('required','id');
						if (preg_match('/^[0-9]+$/', $id)):
							$news = new \app\models\News;
							if ($news->delete($id)):
								cache_forgot('p.n.' . $id);
								cache_forgot('p.getJson.news.' . user('major'));
							endif;
						endif;
					endif;
					break;
			}
		}
	}

	public function a($_act = null)
	{
		switch ($_act) {
			case 'news':
				if (role_check()):
					if (is_post()):
						$news = new \app\models\News;
						$this->loadHelper('Validator');
						if ($news->countNews() < 15):
							$data = [
								'title' => strip_tags(validate('required', 'title')),
								'content' => validate('required', 'content')
							];
							if (validator($data)):
								$news->createNews($data);
								cache_forgot('p.getJson.news.' . user('major'));
							endif;
						endif;
						return redirect('');
					else :
						return $this->view('createNews');
					endif;				
				endif;
				return redirect('back');
				break;

			case 'know':
				if (is_post()):
					$this->loadHelper('Validator');
					$id = validate('required', 'token');
					if ( ! is_null($id)):
						$id = base64_decode($id);
						if (preg_match('/^[0-9]+$/', $id)):
							$data = cache_remember('p.n.' . $id, function() use ($id) {
								$news = new \app\models\News;
								$data = $news->getNews($id);
								if (! empty($data))
									return $data;
								return false;
							});
							if ( ! in_array(auth('id'), explode(',', $data['readIn']))):
								$news = new \app\models\News;
								$progress = ($data['readIn'] === '') ? auth('id') . ',' : $data['readIn'] . auth('id') . ',';
								if ($news->addKnow($id, ['readIn' => $progress])):
									echo '1';
									cache_forgot('p.n.' . $id);
									cache_forgot('p.getJson.news.' . user('major'));
									return;
								endif;
							endif;
						endif;
					endif;				
				endif;
				echo '0';
				return;
				break;
		}
	}

	public function n($id)
	{
		$ex = explode('-', $id);
		if (preg_match('/^[0-9]+$/', $ex['0'])) {
			$data = cache_remember('p.n.' . $ex['0'], function() use ($ex) {
				$news = new \app\models\News;
				$data = $news->getNews($ex['0']);
				if (! empty($data))
					return $data;
				return false;
			});
			if (! is_null($data) && $data['major_id'] === user('major'))
			return $this->view('news', compact('data'));
		}
		return $this->view('errors/404');
	}

	public function gbn($id)
	{
		$ex = explode('-', $id);
		if (preg_match('/^[0-9]+$/', $ex['0'])) {
			$data = cache_remember('p.gbn.' . $ex['0'], function() use ($ex) {
				$news = new \app\models\GbNews;
				return $news->getNews($ex['0']);
			});
			if ( ! is_null($data))
				return $this->view('gbnews', compact('data'));
		}
		return $this->view('errors/404');
	}

	private function eNews($id = null)
	{
		if (is_post()) {
			$this->loadHelper('Validator');
			$data = array(
				'title' => strip_tags(validate('required', 'title')),
				'content' => validate('required', 'content'),
				'updated_at' => date('Y-m-d H:i:s')
			); $id = validate('required', 'token');
			if (validator($data) && ! is_null($id)) {
				$id = base64_decode($id);
				if ( ! preg_match('/^[0-9]+$/', $id)) exit('401');
				$news = new \app\models\News;
				if ($_POST['c_readIn'] === 'on') $data['readIn'] = null;
				if ($news->updateNews($data, $id)) {
					cache_forgot('p.n.' . $id);
					cache_forgot('p.getJson.news.' . user('major'));
				} return redirect('');
			}
		} else {
			if (preg_match('/^[0-9]+$/', $id)) {
				$data = cache_remember('p.n.' . $id, function() use ($id) {
					$news = new \app\models\News;
					$data = $news->getNews($id);
					if (! empty($data))
						return $data;
					return false;
				});
				if (! is_null($data) && $data['major_id'] === user('major'))
					return $this->view('editNews', compact('data'));
			} return $this->view('errors/404');
		}
	}

}