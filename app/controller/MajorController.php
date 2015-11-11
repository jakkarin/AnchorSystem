<?php namespace app\controller;

/**
 * MajorController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;

Class MajorController extends Controller
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
		// no idea
	}

	public function pictures($action = null)
	{
		$_path = APP_PATH . 'contents/major/' . user('major') . '/';
		if (role_check()) {
			switch ($action) {
				case 'remove-all':
					if (chdir($_path)):
						$files = glob('*.*');
						foreach ($files as $key => $value):
							unlink($value);
							unlink('thumbs/' . preg_replace('/\.[A-z]+/', '', $value) . '.jpg');
							echo "Delete $value success. <br/>";
						endforeach;
					endif;
					break;

				case 'remove':
					if (is_post()):
						if (chdir($_path)):
							if (unlink($_POST['pic']) && unlink('thumbs/' . $_POST['name'] . '.jpg'))
								echo '1';
						endif;
					endif;
					break;
				
				default:
					if ( ! file_exists($_path)):
						mkdir($_path, 0777, true);
						mkdir($_path . 'thumbs', 0777, true);
					endif;
					if (chdir($_path)):
						$files = @glob('*.*', GLOB_BRACE);
						$data = array();
						foreach ($files as $key => $file):
							$data[$key] = array('name' => $file, 'size' => filesize($file));
						endforeach; unset($files);
						$json = json_encode($data);
						if (chdir(APP_PATH)):
							return $this->view('major/pictures', compact('json'));
						endif;
					endif;
					break;
			}
		}
	}
}