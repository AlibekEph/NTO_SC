<?php
include_once('functions.php');

function process_query(){
global $conn;
global $user;

//AUTH
if($_GET['move'] == '1'){
		$_SESSION['form'] = array('login' => $_POST['login'], 'type' => 'auth' );
	if($_POST['password'] == '' || $_POST['login'] == ''){
		$status = array('status'=> False, 'type'=> 'ERROR_AUTH_EMPTY_DATA');
		return [AUTH ,$status];
	}
	$auth_param = array('login' => $_POST['login'], 'password' => md5(salt_pass($_POST['password'])));
	$user = new User($auth_param);
	$status = $user->init();
	if($status['status']){
	 	$_SESSION['login'] = $user->login;
		$_SESSION['password'] = $user->password;
		return [INDEX ,$status];
	 }
	 else{
	 	return [AUTH ,$status];
	 }
	}
} 



function routing($data){
	if(!isset($_POST['test'])){
	go_to_page($data[0], $data[1]);
	}
}

routing(process_query());