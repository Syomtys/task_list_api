<?
session_start();
include('../config.php');
class Auth {
	private function get_post_data(){
		// return $_POST['select_auth'];
		return [
			'select_auth' => $_POST['select_auth'],
			'username' => $_POST['username'],
			'password' => $_POST['password'],
			'password_hash' => password_hash($_POST['password'], PASSWORD_BCRYPT)
		];	
	}
	
	private function create_api_key(){
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$key = '';
		for($i = 0; $i < 25; $i++) {
			$random_character = $permitted_chars[mt_rand(0, strlen($permitted_chars))];
			$key .= $random_character;
		}
		return $key;
	}
	
	private function add_api_key($db){
		$id = $db->lastInsertId();
		$query = $db->prepare("INSERT INTO api_keys(api_key,user_id) VALUES (:api_key,:user_id)");
		$query->bindParam("api_key", $this->create_api_key(), PDO::PARAM_STR);
		$query->bindParam("user_id", $id, PDO::PARAM_STR);
		$result = $query->execute();
	}
	private function sign_in($db, $data_post){
		$username = $data_post['username'];
		$password = $data_post['password'];
		$password_hash = $data_post['password_hash'];
		$query = $db->prepare("SELECT * FROM users WHERE username=:username");
		$query->bindParam("username", $username, PDO::PARAM_STR);
		$query->execute();
		if ($query->rowCount() > 0) {
			echo json_encode(['message' => 'данное имя занято', 'code' => 0]);
		} else if ($query->rowCount() == 0) {
			$query = $db->prepare("INSERT INTO users(username,password) VALUES (:username,:password_hash)");
			$query->bindParam("username", $username, PDO::PARAM_STR);
			$query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
			$result = $query->execute();
			if ($result) {
				$this->add_api_key($db);
				echo json_encode(['message' => 'регистрация прошла успешно', 'code' => 1]);
			} else {
				echo json_encode(['message' => 'ошибка', 'code' => 0]);
			}
		}
	}
	private function log_in($db, $data_post){
		$query = $db->prepare("SELECT * FROM users WHERE username=:username");
		$query->bindParam("username", $data_post['username'], PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if (!$result) {
			echo json_encode(['message' => 'Неверные пароль или имя пользователя', 'code' => 0]);
		} else {
			if (password_verify($data_post['password'], $result['password'])) {
				$_SESSION['user_id'] = $result['id'];
				echo json_encode(['message' => 'Поздравляем, вы прошли авторизацию', 'code' => 1]);
			} else {
				echo json_encode(['message' => 'Неверные пароль или имя пользователя', 'code' => 0]);
			}
		}
	}
	public function stat($db){
		$data_post = $this->get_post_data();
		if ($data_post['select_auth'] == 'log_in') {
			$this->log_in($db, $data_post);
		}
		if ($data_post['select_auth'] == 'sign_up') {
			$this->sign_in($db, $data_post);
		}
	}
	

}
$start = new Auth();
$start->stat($db);
// echo $data_post;