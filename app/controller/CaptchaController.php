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

Class CaptchaController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
	}

	public function index()
	{
		redirect('');
	}

	public function get($json = false)
	{
		$config = array(
			'width' => 240,
			'height' => 85,
			'random_bg_position' => true,
			'background' => true,
			'lang' => 'en',
			'line_size' => 2,
			'line_enabled' => true,
			'line_amount' => 2,
		);

		switch ($config['lang']) {
			case 'th':
				$characters = array('ก','ข','ค','ฆ','ง','จ','ฉ','ช','ซ','ช','ฌ','ญ','ฎ','ฏ','ฐ','ฑ','ฒ','ณ','ต','ถ','ท','ธ','น','บ','ป','ผ','พ','ภ','ม','ย','ร','ล','ว','ส','ห','ฬ','อ','ฮ','๑','๒','๓','๔','๕','๖','๗','๘','๙');
				break;
			
			default:
				$characters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
				break;
		}

		if ($json === 'true') {
			// ค้นหาภาพทั้งหมด
			$images = @glob(APP_PATH . 'contents/captcha/images/*.jpg');
			// ค้นหา font ทั้งหมด
			$fonts = @glob(APP_PATH . 'contents/captcha/fonts/*.ttf');
			// สุ่มภาพมา 1 ภาพ จาก ทั้งหมด
			$i_rand = array_rand($images);
			// สุ่ม font มา 1 font จากทั้งหมด
			$f_rand = array_rand($fonts);
			// สร้าง ภาพขึ้นมา
			$image = imagecreatetruecolor($config['width'], $config['height']);
			// นำเข้าภาพจากที่สุ่มมา
			$image2 = @imagecreatefromjpeg($images[$i_rand]);

			if ($config['line_enabled']) {
				// กำหนด สีของเส้น
				$line_color = imagecolorallocate($image, 240,240,240);
				// ทำให้เส้น smoooth ขึ้น
				if (function_exists('imageantialias')) {
					imageantialias($image, true);
				}
				// วาดเส้น
				for ($i = 0; $i < $config['line_amount'];$i++) {
					$y1 = rand() % 100;
					$y2 = rand() % 100;
					$x1 = 0;
					$x2 = $config['width'];
					imageline($image, $x1, $y1 , $x2, $y2, $line_color);
					if ($config['line_size'] > 1) {
						for($l = 1; $l <= $config['line_size'];$l++) {
							imageline($image, $x1, $y1+$l , $x2, $y2+$l, $line_color);
						}
					}
				}	
			}

			$letters = $characters;
			// กำหนดสีตัวอักษร
			$text_color = imagecolorallocate($image, 255,255,255);
			// เลือก font ที่สุ่มไว้แล้ว
			$font = $fonts[$f_rand];
			$cache = '';
			// เขียนตัวอักษร ทีละตัว
			for ($i = 0; $i< 6;$i++) {
				$letter = $letters[array_rand($letters)];
				$cache.= $letter;
				imagettftext($image, rand(38,48), rand(-20,20), 15+($i * 35), 55, $text_color, $font, $letter);
			}
			// นำ รหัส เข้า session
			$_SESSION['captcha'] = $cache;

			if ($config['background']) {
				$sx = 0; $sy = 0;
				// สำหรับภาพที่ขนาดไม่เท่ากับ captcha สุ่มตำแหน่ง ภาพพื้นหลัง
				if ($config['random_bg_position']) {
					$im = getimagesize($images[$i_rand]);
					$sx = rand(0, $im['0'] - $config['width']);
					$sy = rand(0, $im['1'] - $config['height']);
				}
				// ตั้งพื้นหลังให้กับ captcha
				imagecopymerge($image, $image2, 0, 0, rand(0,$sx), rand(0,$sy), $config['width'], $config['height'], 70);
			}
			ob_start();
				imagejpeg($image);
				imagedestroy($image);
				$contents = ob_get_contents();
			ob_end_clean();
			echo 'data:image/jpg;base64,' . base64_encode($contents);
		} else {
			if ( ! empty($_SESSION['captcha'])) {
				$arr = array(
					'0' => $_SESSION['captcha']
				);
				for ($i = 1; $i < 6;$i++) { 
					$cache = '';
					for ($j = 0; $j < 6;$j++) {
						$letter = $characters[array_rand($characters)];
						$cache.= $letter;
					}
					$arr[] = $cache;
				}
				shuffle($arr);
				echo json_encode($arr);
			}
		}
	}

}