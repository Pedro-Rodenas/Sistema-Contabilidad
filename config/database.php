<?php
    class Database{
        private $host = "localhost";
        private $db_name = "sistema_contabilidad";
        private $username = "root";
        private $password = "";
        public $conn;

        public function connect(){
            $this->conn = null;
            
            try{
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                    $this->username,
                    $this->password
                );
                $this->conn->exec("Set names utf8");
            } catch(PDOException $execption){
                echo "Error en la conexion" . $execption->getMessage();
            }
            return $this->conn;
        }
    }
?>