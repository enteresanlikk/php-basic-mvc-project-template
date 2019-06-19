<?php

namespace App\Helpers;
use PDO;
use PDOException;

class DB {

    private $host = "localhost";
    private $username = "";
    private $password = "";
    private $database = "";
    private $charset = "utf8";
    public $db;

    public function connect() {
        try {
            $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->db->query('SET CHARACTER SET ' . $this->charset);
            $this->db->query('SET NAMES ' . $this->charset);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $error) {
            print_r($error->getMessage());
        }

        return $this->db;
    }
}