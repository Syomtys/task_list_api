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
	private function create_sql($data,$par){
		$query = "UPDATE task_list SET ";
		$setParams = [];
		
		if (isset($par) && is_array($par)) {
			foreach ($par as $key => $value) {
				$setParams[] = "$key = :par_$key";
			}
			$query .= implode(", ", $setParams);
		}
		// foreach ($par as $key => $val){
		// 	$query .= "$key = :data_$key,";
		// }
		
		$query .= " WHERE 1=1";
		
		// foreach ($data as $key => $val){
		// 	$query .= " AND $key = :data_$key";
		// }
		if (isset($data) && is_array($data)) {
			foreach ($data as $key => $value) {
				$query .= " AND $key = :data_$key";
			}
		}
		
		return $query;
	}
	
	public function stat(){
		$get_data = $this->get_data_params();
		// print_r($get_data['data']);
		$user = $this->check_login_get_user($get_data['header']['Authorization']);
		if ($user) {
			$sql = $this->create_sql($get_data['data']['get'],$get_data['data']['new_data']);
;			$return_data = $this->query_db_update($sql,$get_data['data']['get'],$get_data['data']['new_data']);
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



