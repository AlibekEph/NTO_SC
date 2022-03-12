<?php
session_start();


include($_SERVER['DOCUMENT_ROOT'] . "/objects/database.php");
include($_SERVER['DOCUMENT_ROOT'] . "/objects/user.php");
include($_SERVER['DOCUMENT_ROOT'] . "/objects/station.php");

$db = new Database();
$conn = $db->getConnection();
$user = new User($_SESSION);
auth_user();


function auth_user(){
	global $user;
	$user->init();
}

function is_admin(){
	global $user;
	if($user->user_type == '1'){
		return true;
	}else{
		return false;
	}
}


function go_to_page($page, $status=array()){
	if(!isset($status['type'])){
		header("Location: ".PROTOCOL."://".DOMAIN."/".$page);
	}
	else{
		if(!isset($status['hash'])){
		if($status['type'] != ''){
		$_SESSION['code'] = $status['type'];
		$_SESSION['msg_flag'] = '1';
		}
		header("Location: ".PROTOCOL."://".DOMAIN."/".$page);
		}else{
			if($status['type'] != ''){
		$_SESSION['code'] = $status['type'];
		$_SESSION['msg_flag'] = '1';
		}
		header("Location: ".PROTOCOL."://".DOMAIN."/".$page."#".$status['hash']);
		}
	}
}


function salt_pass($pass){
		return HASH_SALT.$pass;
	}


function get_users(){
	global $conn;
	global $db;
	$sql = "SELECT * FROM ".DB_TABLE_USERS;
	$sql = $db->query($sql)->fetchAll(PDO::FETCH_BOTH);
	return $sql;

}

function add_log($user_id, $move){
	global $db;
	$sql2 = "INSERT INTO `log` (`id`, `date`, `user_id`, `move`) VALUES (NULL, current_timestamp(), :user_id, :move)";
	$params2 = ['user_id' => $user_id, 'move' => $move];
	$db->diod_query($sql2, $params2);
}

function get_all_log(){
	global $db;
	$sql = "SELECT u.name as name, u.surname as surname, u.patronymic as patronymic, u.user_type as user_type_id, u_type.title as user_type, log.move as move, log.date as date, log.id as id  FROM ".DB_TABLE_LOGS." as log INNER JOIN ".DB_TABLE_USERS." as u ON log.user_id = u.id INNER JOIN ".DB_TABLE_USERS_TYPE." as u_type ON u_type.id = u.user_type ORDER BY date DESC";
	$sql = $db->query($sql)->fetchAll(PDO::FETCH_BOTH);
	return $sql;
}

function get_all_users(){
	global $db;
	global $conn;
	$sql = "SELECT id FROM ".DB_TABLE_USERS." WHERE user_type != '1' ORDER BY bonus DESC";
	$sql = $db->query($sql)->fetchAll(PDO::FETCH_BOTH);
	$res = [];
	foreach ($sql as $userr) {
		$us = new User([], false,$db,$conn);
		$us->pre_init($userr['id']);
		array_push($res, $us);
	}
	return $res;
}

function get_all_diagnostics(){
	global $db;
	$sql = "SELECT d.id as id, u.name as name, u.surname as surname,  u.patronymic as patronymic, d.date as date, d.content as content FROM ".DB_TABLE_DIAGNOSTIC." as d INNER JOIN ".DB_TABLE_USERS." as u ON u.id = d.user_id ORDER BY date DESC";

	$sql = $db->query($sql)->fetchAll(PDO::FETCH_BOTH);
	$res = [];
	for ($i=0; $i < count($sql); $i++) { 
	 	$sql[$i]['content'] = json_decode($sql[$i]['content']);
	 	array_push($res, $sql[$i]);
	 } 
	 return $res;
}

function add_diagnostic($content, $user_id){
	global $db;
	$sql = "INSERT INTO `dignostic` (`id`, `date`, `content`, `user_id`) VALUES (NULL, current_timestamp(),  :content, :user_id)";
	$params = ['content' => $content, 'user_id' => $user_id];
	$db->diod_query($sql, $params);
}

function get_user_by_rfid($rfid){
	global $db;
	global $conn;
	$sql = "SELECT id FROM ".DB_TABLE_USERS." WHERE rfid = ".$conn->quote($rfid);
	$sql = $db->query($sql)->fetchAll(PDO::FETCH_BOTH);
	if(count($sql) != 0){
		$us  = new User();
		$us->pre_init($sql[0]['id']);
		return $us;
	}else{
		return false;
	}

}

function update_settings($plastic, $paper, $glass){
	global $db;
	$sql = "UPDATE ".DB_TABLE_STATIONS_SETIINGS." SET value = :new_value WHERE setting_type = :set_type AND station_id = '1' ";
	$params = ['new_value' => $plastic, 'set_type' => '3'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $paper, 'set_type' => '2'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $glass, 'set_type' => '1'];
	$db->diod_query($sql, $params);
}

function start_work(){
	global $db;
	$sql = "UPDATE ".DB_TABLE_STATIONS_SETIINGS." SET value = :new_value WHERE setting_type = :set_type AND station_id = '1' ";
	$params = ['new_value' => 'Проверка персоналом тех. обслуживания', 'set_type' => '4'];
	$db->diod_query($sql, $params);
}

function stop_work(){
	global $db;
	$sql = "UPDATE ".DB_TABLE_STATIONS_SETIINGS." SET value = :new_value WHERE setting_type = :set_type AND station_id = '1' ";
	$params = ['new_value' => 'Работает', 'set_type' => '4'];
	$db->diod_query($sql, $params);
}

function set_ruch_moves($otsek1, $otsek2, $otsek3, $voda, $display){
	global $db;
	$sql = "UPDATE ".DB_TABLE_STATIONS_SETIINGS." SET value = :new_value WHERE setting_type = :set_type AND station_id = '1' ";
	$params = ['new_value' => $otsek1, 'set_type' => '5'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $otsek2, 'set_type' => '6'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $otsek3, 'set_type' => '7'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $voda, 'set_type' => '10'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $display, 'set_type' => '11'];
	$db->diod_query($sql, $params);
}

function set_add_moves($temp, $vandal){
	global $db;
	$sql = "UPDATE ".DB_TABLE_STATIONS_SETIINGS." SET value = :new_value WHERE setting_type = :set_type AND station_id = '1' ";
	$params = ['new_value' => $temp, 'set_type' => '8'];
	$db->diod_query($sql, $params);
	$params = ['new_value' => $vandal, 'set_type' => '9'];
	$db->diod_query($sql, $params);
}

function get_all_item(){
	global $db;
	$sql = "SELECT * FROM products";
	$sql = $db->query($sql)->fetchAll(PDO::FETCH_BOTH);
	return $sql;
}

function get_item($id){
	global $db;
	global $conn;
	$sql = "SELECT * FROM products WHERE id = ".$conn->quote($id);
	$sql  =$db->query($sql)->fetchAll(PDO::FETCH_BOTH)[0];
	return $sql;
}

function add_item_to_user($user_id, $item_id){
	global $db;
	$sql = "INSERT INTO `products_to_users` (`id`, `user_id`, `product_id`) VALUES (NULL, :user_id, :item_id)";
	$params = ['user_id' => $user_id, 'item_id' => $item_id];
	$db->diod_query($sql, $params);
	
}