<?php namespace app\controller;

/**
 * MigrateController.php.
 *
 * @author Jakkarin Yotapakdee <jakkarinwebmaster@gmail.com>
 * @link http://www.facebook.com/CoachRukThai
 * @copyright 2015
 * @license https://creativecommons.org/licenses/by/3.0/th/
 */

use system\Controller;
use system\Database;

Class MigrateController extends Controller
{
	public function __construct($parent)
	{
		parent::__construct($parent);
		if (file_exists(APP_PATH . 'install/lock'))
			exit('App is Installed.');
		$load = new Database;
		$this->db = $load->conn();
	}

	public function index()
	{
		echo 'Install DB';
		$sql = file_get_contents(APP_PATH . 'install/ku75.sql');
		try {
			$this->db->query($sql);
			echo ' OK <br />';
		} catch (\PDOException $e) {
			echo ' fail <br />';
			exit();
		}
		$this->admin();
		// $this->department();
		$this->faculty();
		$this->major();
		// $this->role();
		file_put_contents(APP_PATH . 'install/lock', '');
	}

	public function admin()
	{
		$this->db->insert('user',[
			'email' => 'admin@admin.com',
			'username' => 'admin',
			'password' => password_hash(hash('sha256','admin'), PASSWORD_BCRYPT),
			'active'	=> 1,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$this->db->insert('user_detail',[
			'user_id' => 1,
			'role_id' => 0,
			'firstname' => 'admin',
			'lastname' => 'administartor',
			'nickname'	=> 'adminza',
			'major' => 1
		]);
	}

	public function faculty()
	{
		$this->db->insert('faculty',[
			'name' => 'วิทยาศาสตร์และวิศวะกรรมศาสตร์'
		]);
	}

	public function department()
	{
		// $this->db->insert('department',[
		// 	'name' => 'วิทยาการคอมพิวเตอร์และสารสนเทศ',
		// 	'faculty' => 1
		// ]);
	}

	public function role()
	{
		// $this->db->insert('role_user',[
		// 	'role_name' => 'ประธาน'
		// ]);
		// $this->db->insert('role_user',[
		// 	'role_name' => 'รองประธาน'
		// ]);
		// $this->db->insert('role_user',[
		// 	'role_name' => 'เลขานุการ'
		// ]);
		// $this->db->insert('role_user',[
		// 	'role_name' => 'เหรัญญิก'
		// ]);
		// $this->db->insert('role_user',[
		// 	'role_name' => 'สมาชิก'
		// ]);
	}

	public function major()
	{
		$this->db->insert('major',[
			'name' => 'วิทยาการคอมพิวเตอร์',
			'faculty' => 1
		]);
		$this->db->insert('major',[
			'name' => 'เทคโนโลยีสารสนเทศ',
			'faculty' => 1
		]);
	}
}
