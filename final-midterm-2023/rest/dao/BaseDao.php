<?php

class BaseDao {

    private $conn;

    /**
    * constructor of dao class
    */
    public function __construct(){
        try {

        /** TODO
        * List parameters such as servername, username, password, schema. Make sure to use appropriate port
        */
        $DB_HOST = "127.0.0.1";
          $DB_NAME = "final_midterm2";
          $DB_PORT = 3306;
          $DB_USER = "root";
          $DB_PASSWORD = "password";


        /*options array neccessary to enable ssl mode - do not change*/
        $options = array(
        	PDO::MYSQL_ATTR_SSL_CA => 'https://drive.google.com/file/d/1zqyqk92mI4A4cAW43nhnCWxEveGSkY7k/view?usp=sharing',
        	PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,

        );

        /** TODO
        * Create new connection
        * Use $options array as last parameter to new PDO call after the password
        */
        $this->conn = new PDO(
            "mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME . ";port=" . $DB_PORT,
            $DB_USER,
            $DB_PASSWORD,
        );

        // set the PDO error mode to exception
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    }

    protected function query($query, $params) {
      $statement = $this->conn->prepare($query);
      $statement->execute($params);
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params) {
        $results = $this->query($query, $params);
        return reset($results);
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

      $statement = $this->conn->prepare($query);
      $statement->execute($entity);
      $entity['id'] = $this->conn->lastInsertId();

      return $entity;
  }

}
?>
