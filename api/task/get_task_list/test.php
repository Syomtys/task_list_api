<?


$link = 'http://test.host1864842.hostland.pro/test_ytip/api/task/get_task_list/';
$access_token = 'W9PLcfm7ADQpJKshuTpVOfIF';

$headers = [
	'Authorization: ' . $access_token
];

// title 	   => 1
// task        => 1
// priority    => 0
// status      => 0
// task_from   => auto
// task_for    => 0
// date_create => auto

$data = [
	'get' => [
		// 'id' => 3,
		// 'limit' => 5,
		// 'title' => 'title',
		// 'task' => 'task',
		// 'priority' => 1,
		// 'status' => 1,
		// 'task_for' => '10',
		// 'task_from' => 'ee',
		// 'date_create' => '2023-11-16',//Y-m-d format
	]
];

$curl = curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
$out = curl_exec($curl);
curl_close($curl);
print_r($out);