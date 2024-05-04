<?php
class Database
{
    private $db;
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_port;
    
    protected $pdo;

    public function __construct()
    {
        $this->db = DATABASE;
        $this->db_host = DB_HOST;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        $this->db_name = DB_NAME;
        $this->db_port = DB_PORT;
        $this->connect();
        
    }
    public function connect()
    {
        try {
            $this->pdo = new PDO("$this->db:host=$this->db_host;dbname=$this->db_name;port=$this->db_port", $this->db_user, $this->db_pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}