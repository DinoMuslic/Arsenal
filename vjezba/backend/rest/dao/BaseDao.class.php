<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class BaseDao {
    protected $connection;
    private $table;

    public function __construct($table) {
        $this->table = $table;

        $DB_HOST = "127.0.0.1";
        $DB_NAME = "vjezba";
        $DB_PORT = 3306;
        $DB_USER = "root";
        $DB_PASSWORD = "password";

        try {
            $this->connection = new PDO(
                "mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME . ";port=" . $DB_PORT,
                $DB_USER,
                $DB_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ] 
            );
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            throw $e;
        }
    }

    protected function query($query, $params) {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params) {
        $results = $this->query($query, $params);
        return reset($results);
    }

    protected function execute($query, $params) {
        $prepared_statement = $this->connection->prepare($query);
        if($params) {
            foreach($params as $key => $param) {
                $prepared_statement->bindValue($key, $param);
            }
        }
        $prepared_statement->execute();
        
        return $prepared_statement;
    }

    public function insert($table, $entity) {
        $query = "INSERT INTO {$table} (";
        foreach($entity as $column => $value) {
            $query .= $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach($entity as $column => $value) {
            $query .= ":" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ")";

        $statement = $this->connection->prepare($query);
        $statement->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();

        return $entity;
    }
}