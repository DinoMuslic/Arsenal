<?php 

require_once __DIR__ . '/BaseDao.class.php';

class CityDao extends BaseDao {
    public function __construct() {
        parent::__construct('cities');
    }

    public function add_city($city) {
        $query = "INSERT INTO cities (name, zip_code)
                  VALUES (:name, :zip_code)";

        
        //unset($user['id']);

        // Debugging output
        // echo "Query: " . $query . "<br>";
        // echo "Parameters: " . print_r($user, true) . "<br>";

        $statement = $this->connection->prepare($query);
        $statement->execute($city);
        $city['id'] = $this->connection->lastInsertId();

        return $city;
    }

    public function get_all_cities() {
        $query = "SELECT * FROM cities";
        return  $this->query($query, []);
    }
}