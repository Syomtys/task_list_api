<?

class send_question_api{
	private function get_params(){
		$links =[
			'get_task_list' => 'http://test.host1864842.hostland.pro/test_ytip/api/task/get_task_list/',
			'create' => 'http://test.host1864842.hostland.pro/test_ytip/api/task/create_task/',

		];
		$par = $_POST['par'];
		$data = $_POST['data'];
		return [
			'url' => $links[$par],
			'data' => $data
		];
	}
	
	private function curl_send($par){
		$headers = [
			'Authorization: W9PLcfm7ADQpJKshuTpVOfIF'
		];
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl,CURLOPT_URL, $par['url']);
		curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
		curl_setopt($curl,CURLOPT_HEADER, false);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($par['data']));
		$out = curl_exec($curl);
		curl_close($curl);
		print_r($out);
	}
	
	public function start(){
		$par = $this->get_params();
		$this->curl_send($par);
		// print_r(json_encode($par['data']));
	}
}
$start = new send_question_api();
$start->start();



