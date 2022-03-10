<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");



function query(){
$status = ['status'=>'', 'error' => '', 'data' => ''];
$move = $_GET['move'];

if($move=='1'){
	if(isset($_GET['rfid'])){
		$rfid = $_GET['rfid'];
		$u_status = get_user_by_rfid($rfid);
		if($u_status){
			$status['status'] = 'success';
			$status['data'] = [
				'exist' => '1',
				'name' => $u_status->name,
				'surname' => $u_status->surname,
				'patronymic' => $u_status->patronymic,
				'balance' => $u_status->bonus,
				'user_type_id' => $u_status->user_type,
				'user_type' => $u_status->get_user_type(),
				'msg' => "Авторизация прошла успешно"
			];
			return $status;
		}else{
			$status['status'] = 'error';
			$status['error'] = 'Такого пользователя не существует';
			return $status;
		}
	}else{
		$status['status'] = 'error';
		$status['error'] = 'Нет некоторых параметров';
		return $status;
	}
}

if($move=='2'){
	if(isset($_GET['user_id']) && isset($_GET['type'])){
		$user_id = $_GET['user_id'];
		$get_user = new User();
		$type = $_GET['type'];
		$u_status = $get_user->pre_init($user_id);
		if($u_status){
			$count = 0;
			switch ($type) {
				case '1':
					$count = '10';
					break;
				case '2':
					$count = '15';
					break;
				case '3':
					$count = '20';
					break;
			}
			$get_user->plus_bonus($count);
			$status['status'] = 'success';
			$status['data'] = [
				'msg' => '"успешно зачисленно '.(String)$count.' баллов'
			];
			return $status;
		}else{
			$status['status'] = 'error';
			$status['error'] = 'Такого пользователя не существует';
			return $status;
		}
	}else{
		$status['status'] = 'error';
		$status['error'] = 'Нет некоторых параметров';
		return $status;
	}
}
if($move == '3'){
	if(isset($_GET['plastic']) && isset($_GET['paper']) && isset($_GET['glass'])){
		$plastic = $_GET['plastic'];
		$glass = $_GET['glass'];
		$paper = $_GET['paper'];
		update_settings($plastic, $paper, $glass);
		$status['status'] = 'success';
		$status['data'] = ['msg' => "Данные успешно обработаны"];
		return $status;
	}else{
		$status['status'] = 'error';
		$status['error'] = 'Нет некоторых параметров';
		return $status;
	}
}

if($move=='4'){
	start_work();
	$status['status'] = 'success';
	$status['data'] = ['msg' => "Данные успешно обработаны"];
	return $status;
}

if($move == '5'){
	$station = new Station('1');
	$status['status'] = 'success';
	$status['data'] = ['station_status' => $station->settings]; 
	switch ($status['data']['station_status']['4']['value']) {
		case 'Временно не работает':
			$status['data']['station_status']['4']['id'] = '3';
			break;
		case 'На тех обслуживании':
			$status['data']['station_status']['4']['id'] = '2';
			break;
		case 'Работает':
			$status['data']['station_status']['4']['id'] = '1';
			break;
	}
	return $status;
}

}


function response(){
	$res = query();

	echo json_encode($res, true);
}
response();
