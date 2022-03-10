<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth ){
	go_to_page(AUTH);
}

$move = $_GET['move'];
if($move == '1'){
	if(is_admin()){
		echo json_encode(get_all_log());
	}else{
		echo json_encode($user->get_user_log());
	}
}

if($move == '2' && is_admin()){
	$res = [];
	foreach (get_all_users() as $user) {
		$el = [
		'id' => $user->id,
		'name' => $user->name,
		'surname' => $user->surname,
		'patronymic' => $user->patronymic,
		'adress' => $user->adress,
		'balance' => $user->bonus,
		'photo' => $user->photo,
		'user_type' => $user->get_user_type()
		];
		array_push($res, $el);
	}
	echo json_encode($res);

}

?>