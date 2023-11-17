<?
include('../../api_father.php');
class CreateTask extends api_father{
	
	// title 	   => 1
	// task        => 1
	// priority    => 0
	// status      => 0
	// task_from   => auto
	// task_for    => 0
	// date_create => auto
	
	private function validate_add_data($not_valid,$user){
		$valid = [];
		$invalid = 0;
		// print_r($not_valid);
		
		if (isset($not_valid['title']) && ($not_valid['title'] != '')) {
			$valid['title'] = $not_valid['title'];
		} else {
			$invalid = 1;
		}
		
		if (isset($not_valid['task']) && ($not_valid['task'] != '')) {
			$valid['task'] = $not_valid['task'];
		} else {
			$invalid = 1;
		}
		
		if (isset($not_valid['priority']) && ($not_valid['priority'] !='')) {
			$valid['priority'] = $not_valid['priority'];
		} else {
			$valid['priority'] = 1;
		}
		
		if (isset($not_valid['status']) && ($not_valid['status'] !='')) {
			$valid['status'] = $not_valid['status'];
		} else {
			$valid['status'] = 1;
		}
		
		if (isset($not_valid['task_for']) && ($not_valid['task_for'] !='')) {
			$valid['task_for'] = $not_valid['task_for'];
		} else {
			$valid['task_for'] = $user['user_id'];
		}
		
		$valid['task_from'] = $user['user_id'];
		
		$valid['date_create'] = date('Y-m-d H:i:s');
		
		// print_r($valid);
		
		if ($invalid) {
			return false;
		} else {
			return $valid;
		}
	}

	private function add_item($not_valid_data,$user){
		$valid_data = $this->validate_add_data($not_valid_data['create'],$user);
		// print_r($user);
		// print_r($valid_data);
		if ($valid_data){
			$result = $this->create_task($valid_data);
			return ['message'=>$result];
		} else {
			return false;
		}
	}
	
	public function stat(){
		$get_data = $this->get_data_params();
		$user = $this->check_login_get_user($get_data['header']['Authorization']);
		if ($user) {//api_key, username, user_id
			$return_data = $this->add_item($get_data['data'],$user);
			if (!$return_data) {
				$user = false;
				$return_data = ['message'=>'data invalid'];
			} else {
				$user = true;
			}
		} else {
			$return_data = ['message' => 'invalid api key'];
		}
		$this->return_json($get_data,$user,$return_data);
	}
}

$started = new CreateTask;
$started->stat();