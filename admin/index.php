<?
//http://test.host1864842.hostland.pro/test_ytip/admin/?start_setting=start_create
include('../config.php');

class Start{
	public function check_get_params(){
		if ($_GET['start_setting'] == 'start_create') {
			return true;
		} else {
			return false;
		}
	}
	public function create_tables($db){
		$sql='CREATE TABLE `users` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`username` varchar(25) NOT NULL,
			`password` varchar(255) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `username` (`username`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
		$result = $db->exec($sql);
		if ($result !== false) {
		  echo 'create table users - ok<br>';
		} else {
		  $errorInfo = $db->errorInfo();
		  echo $errorInfo[2]."<br>";
		}
		$sql='CREATE TABLE `task_list` (
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`status` INT NOT NULL,
			`priority` INT NOT NULL,
			`task_from` varchar(25) NOT NULL,
			`task_for` varchar(25) NOT NULL,
			`title` TEXT NOT NULL,
			`task` TEXT NOT NULL,
			`date_create` DATETIME NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
		$result = $db->exec($sql);
		if ($result !== false) {
		  echo 'create  table task_list - ok<br>';
		} else {
		  $errorInfo = $db->errorInfo();
		  echo $errorInfo[2]."<br>";
		}
		$sql='CREATE TABLE api_keys (
			id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
			api_key VARCHAR(25) NOT NULL,
			user_id INT(10) UNSIGNED NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (user_id) REFERENCES users(id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';
		$result = $db->exec($sql);
		if ($result !== false) {
		  echo 'create  table api_keys - ok<br>';
		} else {
		  $errorInfo = $db->errorInfo();
		  echo $errorInfo[2]."<br>";
		}
	}
}

$start = new Start();
if ($start->check_get_params()) {
	echo 'key - ok<br>';
	$start->create_tables($db);
} else {
	exit;
}
//$connection
