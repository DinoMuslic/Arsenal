<?php

class MidtermDao {

    private $conn;

    /**
    * constructor of dao class
    */
    public function __construct(){
        try {

          $DB_HOST = "127.0.0.1";
          $DB_NAME = "midterm1";
          $DB_PORT = 3306;
          $DB_USER = "root";
          $DB_PASSWORD = "password";

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

    /** TODO
    * Implement DAO method used to get cap table
    */
    public function cap_table(){
      $query = "
          SELECT 
              sc.description AS class,
              scc.description AS category,
              CONCAT(i.first_name, ' ', i.last_name) AS investor,
              ct.diluted_shares
          FROM 
              cap_table ct
          JOIN 
              share_classes sc ON ct.share_class_id = sc.id
          JOIN 
              share_class_categories scc ON ct.share_class_category_id = scc.id
          JOIN 
              investors i ON ct.investor_id = i.id
          ORDER BY 
              sc.description, scc.description, investor
      ";
      $statement = $this->conn->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Organize the result into nested structure
      $capTable = [];
      foreach ($result as $row) {
          $class = $row['class'];
          $category = $row['category'];
          $investor = $row['investor'];
          $diluted_shares = $row['diluted_shares'];

          // Find or create the class entry
          if (!isset($capTable[$class])) {
              $capTable[$class] = [
                  'class' => $class,
                  'categories' => []
              ];
          }

          // Find or create the category entry within the class
          if (!isset($capTable[$class]['categories'][$category])) {
              $capTable[$class]['categories'][$category] = [
                  'category' => $category,
                  'investors' => []
              ];
          }

          // Add the investor to the category
          $capTable[$class]['categories'][$category]['investors'][] = [
              'investor' => $investor,
              'diluted_shares' => $diluted_shares
          ];
      }

      // Convert the associative arrays to indexed arrays
      foreach ($capTable as &$classData) {
          $classData['categories'] = array_values($classData['categories']);
      }
      $capTable = array_values($capTable);

      return $capTable;
  }

    /** TODO
    * Implement DAO method used to get summary
    */
    public function summary(){
      $query = "
                SELECT 
                    COUNT(DISTINCT investor_id) AS total_investors, 
                    SUM(diluted_shares) AS total_shares 
                FROM cap_table;
            ";
      $statement = $this->conn->prepare($query);
      $statement->execute();
      return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method to return list of investors with their total shares amount
    */
    public function investors(){
      $query = "
            SELECT 
                i.company AS company,
                i.first_name AS first_name,
                i.last_name AS last_name,
                SUM(ct.diluted_shares) AS total_diluted_shares
            FROM 
                cap_table ct
            JOIN 
                investors i ON ct.investor_id = i.id
            GROUP BY 
                i.company, i.first_name, i.last_name, i.id
        ";
        $statement = $this->conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
