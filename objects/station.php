<?php 
include_once ($_SERVER['DOCUMENT_ROOT'].'/config/config.php');

class Station{
	private $db;
	private $conn;
	public $id;
	public $adress;
	public $settings= array();
	public $status;


	function __construct($id){
		$this->db = new Database();
		$this->conn = $this->db->getConnection();

		$sql = "SELECT * FROM ".DB_TABLE_STATIONS." WHERE id = ".$this->conn->quote($id);
		$sql = $this->db->query($sql)->fetchAll(PDO::FETCH_BOTH)[0];
		$this->adress = $sql['adress'];
		$this->status = $sql['status'];
		$this->id = $id;
		$sql2 = "SELECT * FROM ".DB_TABLE_STATIONS_SETIINGS." as ss INNER JOIN ".DB_TABLE_STATIONS_SETIINGS_TYPE." as st ON st.id = ss.setting_type WHERE ss.station_id = ".$this->conn->quote($this->id);
		$sql2 = $this->db->query($sql2)->fetchAll(PDO::FETCH_BOTH);
		foreach ($sql2 as $setting) {
			$this->settings[$setting['setting_type']] = ['value' => $setting['value'], 'date' => $setting['date']];
		}

	}

	function set_status($status){
		$sql = "UPDATE ".DB_TABLE_STATIONS_SETIINGS." SET value = :new_status WHERE setting_type = '4' AND station_id = :id";
		$params = ['new_status' => $status, 'id' => $this->id ];
		var_dump($params);
		echo $sql;
		$this->db->diod_query($sql, $params);

	}
}


?>