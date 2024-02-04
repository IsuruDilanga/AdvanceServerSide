<?php

namespace Example3Method2;

class Database {
    private $dbhost = "localhost:8889";
    private $dbuser = "root";
    private $dbpass = "root";
    private $dbname = "LEVEL6_Tutorial";
    private $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

        if(!$this->conn) {
            die('Could not connect: ' . mysqli_error($this->conn));
        }

        mysqli_select_db($this->conn, $this->dbname);
        echo "Connect successfully";
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        mysqli_close($this->conn);
    }
}