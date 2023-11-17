<?
// include($_SERVER['DOCUMENT_ROOT'].'/test_ytip/config.php');

class api_father{
	private $db;
	
	public function __construct() {
		include($_SERVER['DOCUMENT_ROOT'].'/test_ytip/config.php');
		$this->db = $db;
	}

	
	public function get_data_params(){
		$data = [
			'data' => json_decode(file_get_contents('php://input'), true),
			'header' => getallheaders()
		];
		return $data;
	}
	
	public function check_login_get_user($key){
		$query = $this->db->prepare("SELECT api_key, username, user_id FROM api_keys
		INNER JOIN users
		ON api_keys.user_id = users.id
		WHERE api_key =:key");
		$query->bindParam(":key", $key, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}
	public function create_task($data){
		$query = $this->db->prepare("INSERT INTO task_list(status,priority,task_from,task_for,title,task,date_create) VALUES (:status,:priority,:task_from,:task_for,:title,:task,:date_create)");
		$query->bindParam(":status", $data['status']);
		$query->bindParam(":priority", $data['priority']);
		$query->bindParam(":task_from", $data['task_from']);
		$query->bindParam(":task_for", $data['task_for']);
		$query->bindParam(":title", $data['title']);
		$query->bindParam(":task", $data['task']);
		$query->bindParam(":date_create", $data['date_create']);
		$result = $query->execute();
		if ($result !== false) {
		  return 'write data';
		} else {
		  $errorInfo = $query->errorInfo();
		  return $errorInfo[2];
	  	}
	}
	
	public function query_db_update($sql,$data,$par){
		// print_r($data);
		// print_r($par);
		$query = $this->db->prepare($sql);
		foreach ($data as $key => $val){
			$query->bindValue(":data_$key", $val);
			// $sql = str_replace(":data_$key",$val,$sql);
		}
		foreach ($par as $key => $val){
			$query->bindValue(":par_$key",  $val);
			// $sql = str_replace(":par_$key",$val,$sql);
		}
		
		$result = $query->execute();;
		if ($result !== false) {
		  return ['message' => 'data edits'];
		} else {
		  $errorInfo = $this->db->errorInfo();
		  return ['message' => $errorInfo[2]];
		}
		// if ($result) {
		// 	return ['message' => $result];
		// } else {
		// 	return ['message' => 'no data'];
		// }
	}
	
	public function query_db($sql,$data,$par){
		$query = $this->db->prepare($sql);
		if (isset($data['id'])) {
			$query->bindParam(":id", $data['id']);
		}
		if (isset($data['title'])) {
			$query->bindParam(":title", $data['title']);
		}
		if (isset($data['task'])) {
			$query->bindParam(":task", $data['task']);
		}
		if (isset($data['priority'])) {
			$query->bindParam(":priority", $data['priority']);
		}
		if (isset($data['task_from'])) {
			$query->bindParam(":task_from", $data['task_from']);
		}
		if (isset($data['status'])) {
			$query->bindParam(":status", $data['status']);
		}
		if (isset($data['task_for'])) {
			$query->bindParam(":task_for", $data['task_for']);
		}
		if (isset($data['date_create'])) {
			$query->bindParam(":date_create", $data['date_create']);
		}

		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($result) {
			return $result;
		} else if ($par == 'dlt'){
			return ['message'=>'task delited'];
		} else {
			return ['message'=>'no data'];
		}
		// return ['message'=>'sql'];
	}
	
	public function return_json($data,$success,$return_data){
		$response = array(
		  'success' => $success,
		  'data' => $return_data
		  // 'params' => $data
		);
		header('Content-Type: application/json');
		// echo '<pre>';
		// var_dump(($response));
		// echo '<pre>';
		echo (json_encode($response));
	}
}