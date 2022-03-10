<?php 
	include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
	if(!$user->is_auth){
		go_to_page(AUTH);
	}

$move = $_GET['move'];

if($move == '1'){
	$station_id = $_GET['station_id'];
	$station = new Station($station_id);
	echo json_encode([$station->settings, $station->adress]);
}

if($move == '2'){
	$station_id = $_GET['station_id'];
	$status = $_GET['status'];
	$station = new Station($station_id);
	$station->set_status($status);
}

if($move=='3'){
	echo json_encode(get_all_diagnostics());
}

?>