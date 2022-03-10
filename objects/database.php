<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
class Database {

    // укажите свои учетные данные базы данных 
    public $conn;
    // получаем соединение с БД 
    public function getConnection($type=0){

        $this->conn = null;
            switch ($type) {
                case 0:
                    $this->conn = new PDO('mysql:host='.DB_ADRESS.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
                    break;              
            }

        return $this->conn;
    }
    
    public function query($sql){
            return $this->conn->query($sql);
    }

    public function diod_query($sql, $params){
            $stmt = $this->conn->prepare($sql);

            $stmt->execute($params);
       
    }

    public function close(){
        $this->conn = null;
                   
    }
}
?>