<?php 
	include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
	// if(!$user->is_auth){
	// 	go_to_page(AUTH);
	// }

$move = $_GET['move'];

if($move == '1'){
	$items = get_all_item();
	echo json_encode($items);
}

if($move == '2'){
	$item = get_item($_GET['item_id']);
	if((Int)$user->bonus - (Int)$item['coast'] > 0){
		$res = ['status' => 'success'];
		add_item_to_user($user->id, $item['id']);
		$user->minus_bonus($item['coast']);
		echo json_encode($res);
	}else{
		$res = ['status' => 'error'];
		echo json_encode($res);
	}
}


?>