<?


$link = 'http://test.host1864842.hostland.pro/test_ytip/api/task/create_task/';
$access_token = 'W9PLcfm7ADQpJKshuTpVOfIF';

$headers = [
	'Authorization: ' . $access_token
];

function rad_str(){
	$permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
	$key = '';
	for($i = 0; $i < rand(5,15); $i++) {
		$random_character = $permitted_chars[mt_rand(0, strlen($permitted_chars))];
		$key .= $random_character;
	}
	return $key;
}

function rand_pr(){
	$words = rand(5, 25);
	$str = '';
	for($i = 0; $i < $words; $i++) {
		$str = $str.' '.rad_str();
	}
	return $str;
}

for($i = 0; $i < 10; $i++) {
$data = [
	'create' => [
		'title' => rand_pr(),
		'task' => rand_pr(),
		'priority' => rand(1,3),
		'status' => rand(1,3),
		'task_from' => rand(1,4),
		'task_for' => rand(1,4)
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
}