<?php namespace app\controller;

/**
 * LedgerController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;

Class LedgerController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->middleware('Auth');
		$this->middleware('Active');
		$this->loadHelper('User');
		$this->user_path = APP_PATH . 'contents/users/ledger/' . auth('id') . '/';
		$this->current_name = date('Y') . '.bl';
		$this->current_month = date('m');
		if ( ! file_exists($this->user_path))
			mkdir($this->user_path, 0755, true);
		if ( ! file_exists($this->user_path . 'install.lock')) redirect('home/ledger/install');
		if ( ! file_exists($this->user_path . $this->current_name))
			file_put_contents($this->user_path . $this->current_name, json_encode(['lists' => null]));
	}

	public function index()
	{
		$data = $this->read($this->current_name);
		if ( ! empty($data)) {
			$data = cache_remember('ledger.index.' . (string) auth('id'), function() use ($data) {
				$arr = array();
				foreach ($data as $key => $value) {
					$total_got = 0;
					$total_pay = 0;
					foreach ($value as $k2 => $v2) {
						$ex = explode(':|', $v2);
						if ($ex['0'] === '1') {
							$total_pay += intval($ex['2']);
						} else {
							$total_got += intval($ex['2']);
						}
					}
					$compute = ($total_got - $total_pay);
					$arr[$key] = array(
						'0' => array(
							'value' 	=> $compute,
							'color' 	=> ($compute < 0) ? '#F7464A' :'#0EA606',
							'highlight'	=> ($compute < 0) ? '#FF5A5E' :'#2EEC24',
							'label'		=> 'ยอดหักล้าง'
						),
						'1' => array(
							'value' 	=> $total_pay,
							'color' 	=> '#E97720',
							'highlight'	=> '#F98C38',
							'label'		=> 'รายจ่าย'
						),
						'2' => array(
							'value' 	=> $total_got,
							'color' 	=> '#0A4DB1',
							'highlight'	=> '#1365E1',
							'label'		=> 'รายรับ'
						),
					);
				}
				return json_encode($arr);
			});
		} else {
			$data = 'null';
		}
		return $this->view('ledger/index', compact('data'));
	}

	public function add()
	{
		if (is_post()) {
			$_data = array();
			foreach ($_POST as $key => $value) {
				$value['time'] = date('D, d M Y');
				$_data[] = implode(':|', $value);
			}
			if ($this->update($this->current_name, $_data)) {
				return redirect('ledger/summary');
			}
		} else {
			return $this->view('ledger/add');
		}
	}

	public function edit()
	{

	}

	public function del()
	{

	}

	public function summary($m = '')
	{
		$data = $this->read($this->current_name);
		$m = ($m !== '') ? $m : $this->current_month;
		if ( ! empty($data[$m])) {
			$cache = $data[$m];
			unset($data);
			$data[$m] = $cache;
		}
		return $this->view('ledger/summary', compact('data'));
	}

	private function delete($_filename, $_arrayField)
	{

	}

	private function update($_filename, $_data)
	{
		if (file_exists($this->user_path . $_filename)) {
			if (copy($this->user_path . $_filename, $this->user_path . $_filename . '.bak')) {
				$file_get = file_get_contents($this->user_path . $_filename);
				$arr = json_decode($file_get, true);
				if (is_null($arr['lists']))
					$arr['lists'] = array();
				if (empty($arr['lists'][$this->current_month]))
					$arr['lists'][$this->current_month] = array();
				$result = array_merge($arr['lists'][$this->current_month], $_data);
				$arr['lists'][$this->current_month] = $result;
				ksort($arr['lists']);
				ksort($arr['lists'][$this->current_month]);
				$op = @fopen($this->user_path . $_filename, 'w');
				if (flock($op, LOCK_EX)) {
					fwrite($op, json_encode($arr));
					fflush($op);
					flock($op, LOCK_UN);
				}	fclose($op);
				cache_forgot('ledger.index.' . (string) auth('id'));
			}
			return true;
		}
		return false;
	}

	private function read($_filename)
	{
		if (file_exists($this->user_path . $_filename)) {
			$file_get = file_get_contents($this->user_path . $_filename);
			$data = json_decode($file_get, true);
			return $data['lists'];
		}
	}

	private function recovery($_filename)
	{
		if (file_exists($this->user_path . $_filename . '.bak')) {
			if (copy($this->user_path . $_filename . '.bak', $this->user_path . $_filename)) {
				return true;
			}
		}
	}

	private function destroy()
	{
		$files_get = glob($this->user_path . '/*');
		foreach ($files_get as $value) {
			@unlink($value);
		}
	}
}