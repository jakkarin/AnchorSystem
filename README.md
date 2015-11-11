# ระบบประกาศข่าวสาขาหรือกลุ่ม

### ความต้องการของระบบ
- PHP 5 (5.4 - 5.6)
- PHP 5 PDO Support
- PHP GD

### วัตถุประสงค์
- ทำขึ้นเพื่อให้ผู้ที่สนใจอยากศึกษาการเขียนเว็บด้วย php mysql jqurey

### การเชื่อมต่อ Database และการติดตั้ง
 - ให้เข้าไปแก้ไขไฟล์
```
app/config/db.php
---------------------- ค้นหา ---------------------------
return [
	'driver'		=> 'pdo',
	'hostname'	    => '<Your host>',
	'dbname'		=> '<Your DB name>',
	'username'	    => '<Your username>',
	'password'	    => '<Your Password>',
	'prefix'		=> 'bl_',
	'charset'		=> 'utf8'
];
```
 - ตั้งค่ารหัสผ่าน admin
```
app/controller/MigrateController.php
---------------------- ค้นหา ---------------------------
public function admin()
{
	$this->db->insert('user',[
		'email' => '<Your email>',
		'username' => '<Your username>',
		'password' => password_hash(hash('sha256','<Your password>'), PASSWORD_BCRYPT),
		'active'	=> 1,
		'created_at' => date('Y-m-d H:i:s')
	]);
	$this->db->insert('user_detail',[
		'user_id' => 1,
		'role_id' => 0,
		'firstname' => '<Your firstname>',
		'lastname' => '<Your lastname>',
		'nickname'	=> '<Your nickname>',
		'major' => 1
	]);
}
```
- ตั้งค่า app
```
app/config/app.php
---------------------- ค้นหา ---------------------------
return [
	// ex. http://172.17.42.1/ or http://domain.com/
	'url'			=> '<Your-url>',
	// ถ้าอยู่ใน subfoler
	'sub_folder'	=> '',
	// ชื่อไฟล์หน้าแรกเช่น index.php ถ้าใช้งาน htaccess ไม่ต้องกรอก
	'index'			=> '',
	// Controller แรกที่จะทำงานหน้าแรกนั่นเองครับ
	'primary'		=> 'home',
	'template'		=> 'default',
	// Session
	'session_name'	=> '<Session name>',
	'session_path'	=> '/app/session'
];
```
- สร้าง ฐานข้อมูลให้เรียบร้อย
- จากนั้น เปิดหน้าเว็บ `http://<Your domain or IP>/migrate`

### การตั้งค่า Role
- แก้ไขไฟล์
```
app/helpers/User.php
---------------------- ค้นหา ---------------------------
if ( ! function_exists('position'))
// จากนั้นก็แก้ไขได้ตามต้องการครับ
```

### Nginx
- ตั้งค่าประมาณนี้ครับ
```
server {
        server_name <Your Domain>;
        root /var/www/<Your Path>;
        index index.html index.php;
        location ~* \.(ico|css|js|gif|jpe?g|png)(\?[0-9]+)?$ {
                expires max;
                log_not_found off;
        }
        location / {
                try_files $uri $uri/ /index.php;
        }
        location ~* \.(php|json)$ {
        	deny all;
        }
	location ~ /(app/caches|app/session) {
	   deny all;
	   return 404;
	}
	....
}
```
