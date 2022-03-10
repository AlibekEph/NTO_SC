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