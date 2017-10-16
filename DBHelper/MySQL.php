<?php

class MySQL extends Database
{
    
    private $connection = null;
    
    public function __construct($login, $password, $database, $hostname)
    {
        parent::__construct($login, $password, $database, $hostname);
        $this->connect();
    }
    
    public function connect()
    {
        if (!is_null($this->connection)) {
            return;
        }
        $connection = new PDO(sprintf('mysql:host=%s;dbname=%s', $this->hostname, $this->database), $this->login, $this->password, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ));
        
        if (!$connection) {
            throw new DatabaseException(sprintf('Cannot connect to database. new PDO to %s with login %s fails', $this->hostname, $this->login));
        } else {
            return $connection;
        }
        
        return false;
    }
    
}

?>