<?php

require_once BASE_PATH . '/src/utils/loadEnv.php';


class Database {

    private $host;
    private $port;
    private $user;
    private $pass;
    private $db;

    public $connection;

    // Constructor para inicializar las propiedades
    public function __construct() {
        $this->host = getenv('MYSQL_HOST');
        $this->port = getenv('MYSQL_PORT');
        $this->user = getenv('MYSQL_USER');
        $this->pass = getenv('MYSQL_PASSWORD');
        $this->db   = getenv('MYSQL_DATABASE');
    }

    public function getConnection(){
        $this->connection = null;
        try {
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->db";
            $this->connection = new PDO($dsn, $this->user, $this->pass);
            $this->connection->exec("set names utf8");
        } catch (PDOException $exep) {
            echo 'Error: '.$exep->getMessage();
        }

        return $this->connection;
    }

}
