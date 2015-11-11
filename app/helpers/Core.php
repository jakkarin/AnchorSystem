<?php

/**
 * Core.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

if ( ! function_exists('elapsed_time')) {
	function elapsed_time() {
		return round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 4);
	}
}

/**
 *
 * Cache function.
 *
 */

if ( ! function_exists('cache_remember')) {
	function cache_remember($name, $func, $time = 0, $path = null, $hash = true) {
		$hash_name = $hash ? md5($name) : $name;
		$cache_path = is_null($path) ? APP_PATH . 'app/caches/' : $path;
		if ( ! file_exists($cache_path . $hash_name)) {
			$arr = array(
				'exp'		=> $time ? time() + ($time * 60) : null,
				'content'	=> call_user_func($func)
			);
			if ($arr['content'] !== false) {
				$op = @fopen($cache_path . $hash_name, 'w');
				if (flock($op, LOCK_EX)) {
					fwrite($op, json_encode($arr));
					fflush($op); 
					flock($op, LOCK_UN);
				}	fclose($op);
				return $arr['content'];
			} return null;
		} else {
			$fp = json_decode(file_get_contents($cache_path . $hash_name), true);
			if ( ! is_null($fp['exp']) && $fp['exp'] < time()) {
				@unlink($cache_path . $hash_name);
			}
			return $fp['content'];
		}
	}
}

if ( ! function_exists('cache_forgot')) {
	function cache_forgot($name) {
		$hash_name = md5($name);
		$cache_path = APP_PATH . 'app/caches/';
		if (file_exists($cache_path . $hash_name)) {
			@unlink($cache_path . $hash_name);
		}
	}
}

/**
 *
 * view (template) function.
 *
 */

 if ( ! function_exists('import')) {
	function import($path) {
		$arg = func_get_args();
		include TEMPLATE_PATH . $path . '.blade.php';
	}
}

if ( ! function_exists('asset')) {
	function asset($path) {
		return ASSET_URL . $path;
	}
}

if ( ! function_exists('content')) {
	function content($path) {
		return CONTENT_URL . $path;
	}
}

if ( ! function_exists('url')) {
	function url($url) {
		$slash = $url === '' ? '' : '/';
		return APP_URL . $url . $slash;
	}
}

if (! function_exists('is_post')) {
	function is_post($val = null) {
		if (is_null($val)) {
			return $_SERVER['REQUEST_METHOD'] === 'POST';
		} else {
			return empty($_POST[$val]);
		}
	}
}

if ( ! function_exists('spchar')) {
	function spchar($string) {
		return htmlspecialchars($string);
	}
}

if ( ! function_exists('e')) {
	function e($string) {
		return htmlentities($string);
	}
}

if ( ! function_exists('widget')) {
	function widget($name) {
		$className = 'app\widgets\\' . ucfirst($name);
		$widget = new $className;
		return $widget->run();
	}
}

if ( ! function_exists('redirect')) {
	function redirect($to) {
		if ($to === 'back') {
			header("location:javascript://history.go(-1)");
		} else {
			header('location: ' . url($to));
		}
		exit();
	}
}

if ( ! function_exists('csrf_token')) {
	function csrf_token() {
		return $_SESSION['csrf_token'];
	}
}

/**
 *
 * string function.
 *
 */

if ( ! function_exists('str_rand')) {
	function str_rand($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

if ( ! function_exists('request_uri')) {
	function request_uri() {
		return $request_uri = str_replace(REG_URI, '', rawurldecode($_SERVER['REQUEST_URI']));
	}
}

if ( ! function_exists('is_active')) {
	function is_active($uri, $bool = false) {
		if (request_uri() === $uri || request_uri() === $uri . '/') {
			if ($bool) return true;
			return 'class="active"';
		}
		if ($bool) return false;
		return '';
	}
}

if ( ! function_exists('strip_tags_content')) {
	function strip_tags_content($text, $tags = '', $invert = FALSE) { 
		preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags); 
		$tags = array_unique($tags[1]); 
		if(is_array($tags) && count($tags) > 0) { 
			if($invert == FALSE) { 
				return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text); 
			} else { 
				return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text); 
			} 
		} elseif($invert == FALSE) { 
			return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text); 
		} 
		return null; 
	} 
}

/**
 *
 * session function.
 *
 */

if ( ! function_exists('get_session')) {
	function get_session($session) {
		return $_SESSION[$session];
	}
}

if ( ! function_exists('auth')) {
	function auth($arg = null) {
		if ( ! empty($_SESSION['auth'])) {
			if (empty($arg)) {
				return $_SESSION['auth'];
			} else {
				return $_SESSION['auth'][$arg];
			}
		}
	}
}

if ( ! function_exists('user')) {
	function user($arg = null) {
		if ( ! empty($_SESSION['user'])) {
			if (empty($arg)) {
				return $_SESSION['user'];
			} else {
				return $_SESSION['user'][$arg];
			}
		}
	}
}