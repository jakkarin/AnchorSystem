<?php namespace app\controller;

/**
 * AuthController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;

Class ApiController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
	}

	public function index()
	{
		return redirect('');
	}

	public function share($code = '')
	{
		if ($code !== '') {
			$decode = base64_decode($code);
			if ($decode !== '') {
				$data = json_decode($decode, true);
				if ( ! is_null($data))
					return $this->view('api/share_fb', $data);
			}
		} return $this->view('errors/404');
	}

	public function upload()
	{
		$this->middleware('Auth');
		$this->loadHelper('User');
		if (role_check() && is_post()) {
			if ( ! empty($_FILES['image'])) {
				$_path = APP_PATH . 'contents/major/' . user('major') . '/';
				if ( ! file_exists($_path)) {
					mkdir($_path, 0755, true);
					mkdir($_path . 'thumbs', 0755, true);
				} $getSize = @glob($_path . '*.*', GLOB_BRACE);
				$size = (int) 0;
				foreach ($getSize as $list) {
					$size = $size + filesize($list);
				} unset($getSize, $list);
				$size = round(($size / 1000) / 1000);
				if ($size <= 50) {
					$file = $_FILES['image']['tmp_name'];
					$filesize = filesize($file) / 1000;
					if ($filesize <= 1024) {
						$thumbs_width = 125;
						$thumbs_height = 125;
						$mime = @getimagesize($file);
						switch ($mime['mime']) {
							case 'image/jpeg':
								$image = imagecreatefromjpeg($file);
								$ext = '.jpg';
								break;

							case 'image/png':
								$image = imagecreatefrompng($file);
								$ext = '.png';
								break;

							case 'image/bmp':
								$image = imagecreatefromwbmp($file);
								$ext = '.bmp';
								break;

							case 'image/gif':
								$image = imagecreatefromgif($file);
								$ext = '.gif';
								break;

							default:
								exit(' "{code": 0,"data":"Errors." }');
								break;
						}
						$thumbs = ImageCreateTrueColor($thumbs_width, $thumbs_height);
						$dst_ratio = $mime['0'] / $mime['1'];
						$img_ratio = $thumbs_width / $thumbs_height;
						if ($dst_ratio >= $img_ratio) {
							$dst_h = $mime['1'];
							$dst_w = $dst_h / $img_ratio;
							$dst_x = ($mime['0'] - $dst_w) / 2;
							$dst_y = 0;
						} else {
							$dst_w = $mime['0'];
							$dst_h = $dst_w / $img_ratio;
							$dst_x = 0;
							$dst_y = ($mime['1'] - $dst_h) / 2;
						}
						$img_name = str_rand(10);
						$thumbs_path = APP_PATH . 'contents/major/' . user('major') . '/thumbs/' . $img_name . '.jpg';
						$image_path = 'major/' . user('major') . '/' . $img_name . $ext;
						imagecopyresampled($thumbs, $image, 0, 0, $dst_x, $dst_y, $thumbs_width, $thumbs_height, $dst_w, $dst_h);
						imagejpeg($thumbs, $thumbs_path, 70);
						move_uploaded_file($file, APP_PATH . 'contents/' . $image_path);
						imagedestroy($thumbs);
						imagedestroy($image);
						echo '{ "code": 1,"data":"' . content($image_path) . '" }';
						exit();
					}
					echo '{ "code": 2,"data":"ขนาดไฟล์ใหญ่เกิน 1 Mb" }';
					exit();
				}
				echo '{ "code": 3,"data":"พื้นที่เก็บข้อมูลเต็ม" }';
				exit();
			}
		}
		echo '{ "code": 0,"data":"Errors." }';
	}

}
