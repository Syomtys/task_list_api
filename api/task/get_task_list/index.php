<?
include('../../api_father.php');
class GetTaskList extends api_father{
	
	// 'id' => 3,
	// 'limit' => 5,
	// 'title' => 'title',
	// 'task' => 'task',
	// 'priority' => 0,
	// 'task_from' => 'd',
	// 'task_from' => 'task_for',
	// 'date_create' => '2023-11-16',//Y-m-d format
	private function create_sql($data){
		$query = "SELECT * FROM task_list WHERE 1=1";
		
		if (isset($data['id'])) {
			$query .= " AND id=:id";
		}
		if (isset($data['title'])) {
			$query .= " AND title=:title";
		}
		if (isset($data['task'])) {
			$query .= " AND task=:task";
		}
		if (isset($data['priority'])) {
			$query .= " AND priority=:priority";
		}
		if (isset($data['task_from'])) {
			$query .= " AND task_from=:task_from";
		}
		if (isset($data['task_for'])) {
			$query .= " AND task_for=:task_for";
		}
		if (isset($data['status'])) {
			$query .= " AND status=:status";
		}
		if (isset($data['date_create'])) {
			$query .= " AND DATE(date_create)=:date_create";
		}
		if (isset($data['limit'])) {
			$query .= " LIMIT " . $data['limit'];
		}
		
		return $query;
	}
	
	public function stat(){
		$get_data = $this->get_data_params();
		// print_r($get_data['data']);
		$user = $this->check_login_get_user($get_data['header']['Authorization']);
		if ($user) {
			$sql = $this->create_sql($get_data['data']['get']);
			// echo $sql;
			$return_data = $this->query_db($sql,$get_data['data']['get'],'get');
			if (!$return_data) {
				$user = false;
				$return_data = ['message'=>'invalid query'];
			} else {
				$user = true;
			}
		} else {
			$return_data = ['message' => 'invalid api key'];
		}
		$this->return_json($get_data,$user,$return_data);
	}
}

$started = new GetTaskList;
$started->stat();



