<?php
	define('USER', '');
	define('PASSWORD', '');
	define('HOST', '');
	define('DATABASE', '');
	try {
		$db = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
	} catch (PDOException $e) {
		exit("Error: " . $e->getMessage());
	}
?>