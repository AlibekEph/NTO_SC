<?php 
	include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
	// if(!$user->is_auth){
	// 	go_to_page(AUTH);
	// }

$move = $_GET['move'];

if($move == '1'){
	$res = ['user_data' => 
				[
				'name' => $user->name,
				'surname' => $user->surname,
				'patronymic' => $user->patronymic,
				'adress' => $user->adress,
				'balance' => $user->bonus,
				'id' => $user->id
				],
			'products' => $user->get_products()
];
	echo json_encode($res);
}

// if($move == '2'){
// 	$item = get_item($_GET['item_id']);
// 	if((Int)$user->bonus - (Int)$item['coast'] > 0){
// 		$res = ['status' => 'success'];
// 		add_item_to_user($user->id, $item['id']);
// 		$user->minus_bonus($item['coast']);
// 		echo json_encode($res);
// 	}else{
// 		$res = ['status' => 'error'];
// 		echo json_encode($res);
// 	}
// }


?>