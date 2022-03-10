<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
class User {
	public $name;
	public $surname;
	public $patronymic;
	private $db;
	public $id;
	private $conn;
	public $is_auth=false;
	public $data;
	public $rfid;
	public $login;
	public $user_type;
	public $password;
	public $logs;
	public $ip;
	public $bonus;
	public $adress;
	public $photo;


	function __construct($data=array(), $close=false, $db='', $conn=''){
		if($db == ''){
		$this->db = new Database();
		$this->conn = $this->db->getConnection();
		}else{
			$this->db = $db;
			$this->conn = $conn;
		}
		$this->data = $data;

		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = @$_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
		elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
		else $ip = $remote;
		$this->ip = $ip;
	}

	public function init(){
			if(!isset($this->data['login']) || !isset($this->data['password'])){
				return array('status' => False);
			}
			$user = $this->check_auth($this->data['login'], $this->data['password']);
			if($user){
				$this->id = $user['id'];
				$this->name = $user['name'];
				$this->login = $user['login'];
				$this->rfid = $user['rfid'];
				$this->password = $user['password'];
				$this->user_type = $user['user_type'];
				$this->photo = $user['photo'];
				$this->adress = $user['adress'];
				$this->bonus = $user['bonus'];
				$this->surname = $user['surname'];
				$this->patronymic = $user['patronymic'];
				$this->is_auth = true;
				return ['status' => true, 'type' => 'SUCCESS_MESSAGE_USER_INIT'];
			}
			return ['status' => false, 'type' => 'ERROR_MESSAGE_USER_DONT_EXIST'];
		
	}

	public function pre_init($id){
		$sql = "SELECT * FROM ".DB_TABLE_USERS." WHERE id = ".$this->conn->quote($id);
		$user = $this->db->query($sql)->fetchAll(PDO::FETCH_BOTH);
		if(count($user) != 0){
		$user = $user[0];
		$this->id = $user['id'];
		$this->name = $user['name'];
		$this->rfid = $user['rfid'];
		$this->user_type = $user['user_type'];
		$this->photo = $user['photo'];
		$this->adress = $user['adress'];
		$this->bonus = $user['bonus'];
		$this->surname = $user['surname'];
		$this->patronymic = $user['patronymic'];
		return ['status' => true, 'type' => 'SUCCESS_MESSAGE_USER_PRE_INIT'];
		}
		return ['status' => false, 'type' => 'ERROR_MESSAGE_USER_PRE_INIT'];
	}

	public function check_auth($login, $password){
			$sql = "SELECT * FROM ".DB_TABLE_USERS." WHERE login = ".$this->conn->quote($login)." AND password = ".$this->conn->quote($password)."";
			$sql = $this->db->query($sql);
			$res = $sql->fetchAll(PDO::FETCH_BOTH);
			if(count($res) == 0){
				return false;
			}

			return $res[0];
		}


	public function create_user(){
			$sql = "INSERT INTO `".DB_TABLE_USERS."` (`id`, `name`, `rfid`, `password`, `login`) VALUES (NULL, :name, :rfid, :password, :login)";
			$params = ['name' => $this->data['name'], 'rfid' => $this->data['rfid'], 'password' => $this->data['password'], 'login' => $this->data['login']];
			$this->db->diod_query($sql, $params);
			return ['status' => true, 'type' => 'SUCCESS_MESSAGE_USER_CREATE'];
		
	}

	public function get_user_type(){
		return USERS_TYPES[$this->user_type];
	}


	public function plus_bonus($count){
		$sql = "UPDATE ".DB_TABLE_USERS." SET bonus = bonus + :bonus_add WHERE id = :id";
		$params = ['bonus_add' => $count, 'id' => $this->id];
		$this->db->diod_query($sql, $params);
		add_log($this->id, 'Начисление '.(String)$count." баллов");
	}	


	public function minus_bonus($count){
		if((Int)$count <= 0){
			return ['status' => false, 'type' => 'ERROR_MESSAGE_USER_PAY'];
		}
		if((Int)$this->bonus - (Int)$count > 0){
			$sql = "UPDATE ".DB_TABLE_USERS." SET bonus = bonus - :bonus_add WHERE id = :id";
			$params = ['bonus_add' => $count, 'id' => $this->id];
			$this->db->diod_query($sql, $params);
			add_log($this->id, 'Списание '.(String)$count." баллов");
			$this->bonus = (String)((Int)$this->bonus - (Int)$count);
			return ['status' => true, 'type' => 'SUCCESS_MESSAGE_USER_PAY'];
		}else{
			return ['status' => false, 'type' => 'ERROR_MESSAGE_USER_PAY'];
		}
	}

	public function get_user_log(){
		$sql = "SELECT u.name as name, u.surname as surname, u.patronymic as patronymic, u.user_type as user_type_id, u_type.title as user_type, log.move as move, log.date as date, log.id as id  FROM ".DB_TABLE_LOGS." as log INNER JOIN ".DB_TABLE_USERS." as u ON log.user_id = u.id INNER JOIN ".DB_TABLE_USERS_TYPE." as u_type ON u_type.id = u.user_type WHERE log.user_id = ".$this->conn->quote($this->id)." ORDER BY date DESC";
		$sql = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		return $sql;
	}	



}
?>