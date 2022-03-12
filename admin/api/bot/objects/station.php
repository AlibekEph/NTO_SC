<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");



function query(){
$status = ['status'=>'', 'error' => '', 'data' => ''];
$move = $_GET['move'];

if($move=='1'){
	if(isset($_GET['otsek1']) && isset($_GET['otsek2']) && isset($_GET['otsek3']) && isset($_GET['voda']) && isset($_GET['display'])){
		$send_arr = [
			'otsek1' => $_GET['otsek1'],
			'otsek2' => $_GET['otsek2'],
			'otsek3' => $_GET['otsek3'],
			'voda' => $_GET['voda'],
			'display' => $_GET['display']
		];

		set_ruch_moves($_GET['otsek1'], $_GET['otsek2'], $_GET['otsek3'], $_GET['voda'], $_GET['display']);

	$status['status'] = 'success';
	$status['data'] = ['msg' => 'Данные успешно переданы','data' => $send_arr];
	return $status;
	}else{
		$status['status'] = 'error';
		$status['error'] = 'Нет некоторых параметров';
		return $status;
	}

}

if($move=='2'){
	$glass = [
		'color' => $_GET['glass_color'],
		'zaslonka' => $_GET['glass_zaslonka'],
		'zapolnyaem' => $_GET['glass_zapolnyaem']
	];
	$paper = [
		'color' => $_GET['paper_color'],
		'zaslonka' => $_GET['paper_zaslonka'],
		'zapolnyaem' => $_GET['paper_zapolnyaem']
	];
	$plastic = [
		'color' => $_GET['plastic_color'],
		'zaslonka' => $_GET['plastic_zaslonka'],
		'zapolnyaem' => $_GET['plastic_zapolnyaem']
	];

	$res = ['glass' => $glass, 'paper' => $paper,'plastic' => $plastic];
	$res = json_encode($res, true);
	add_diagnostic($res, '3');
	stop_work();
	$status['status'] = 'success';
	$status['data'] = 'Отчет успешно добавлен';
	return $status;
}
}

function response(){
	$res = query();

	echo json_encode($res, true);
}
response();



?>