<?php
namespace models;

use PDO;

class Database extends PDO
{
    /*
     * @param string $host Hostname of the database server
     * @param string $db database name of the database server
     * @param string $user username of the database server
     * @param string $pass password of the database server
     */
    public function __construct(
        private string $host,
        private string $db,
        private string $user,
        private string $pass,
    ) {}

    public function createConnection(): PDO
    {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->db;", $this->user, $this->pass);
        return $conn;
    }
}
