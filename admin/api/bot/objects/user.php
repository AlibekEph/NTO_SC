<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");


function query(){
$status = ['status'=>'', 'error' => '', 'data' => ''];
$move = $_GET['move'];
if($move=='1'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$get_user = new User();
		$u_status = $get_user->pre_init($user_id);
		if($u_status){
			$status['status'] = 'success';
			$status['data'] = [
				'name' => $get_user->name,
				'surname' => $get_user->surname,
				'patronymic' => $get_user->patronymic,
				'bonus' => $get_user->bonus,
				'adress' => $get_user->adress,
				'user_type_id' => $get_user->user_type,
				'user_type' => $get_user->get_user_type(),
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
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$get_user = new User();
		$u_status = $get_user->pre_init($user_id);
		if($u_status['status']){
			$status['status'] = 'success';
			$status['data'] = $get_user->get_user_log();
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

if($move=='3'){
	if(isset($_GET['user_id']) && isset($_GET['minus_count']) ){
		$user_id = $_GET['user_id'];
		$minus_count = $_GET['minus_count'];
		$get_user = new User();
		$u_status = $get_user->pre_init($user_id);
		if($u_status['status']){
			$p_status = $get_user->minus_bonus($minus_count);
			if($p_status['status']){
				$status['status'] = 'success';
				$status['data'] = ['msg' => "Бонусы успешно списаны",'balance' => $get_user->bonus];
				return $status;
 			}else{
				$status['status'] = 'error';
				$status['error'] = 'Недостаточно средств на балансе';
				return $status;
			}
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

}

function response(){
	$res = query();

	echo json_encode($res, true);
}
response();