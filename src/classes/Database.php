<?php
namespace App;

class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $port;
    private $connection;

    public function __construct() {
        $config = Config::get('database');
        
        $this->host     = $config['host'];
        $this->dbname   = $config['name'];
        $this->username = $config['user']; //'debian-sys-maint';
        $this->password = $config['pass']; //'Rg6OzvMTokW76fQM';
        $this->port     = $config['port']; //'3306';
        $this->connect();
    }

    private function connect() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};port={$this->port}",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection = null;
    }
}
?>