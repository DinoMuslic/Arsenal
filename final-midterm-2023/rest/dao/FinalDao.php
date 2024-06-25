<?php
require_once "BaseDao.php";

class FinalDao extends BaseDao {

    public function __construct(){
        parent::__construct();
    }

    /** TODO
    * Implement DAO method used login user
    */
    public function login($email){
        $query = "SELECT * FROM users
                  WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    /** TODO
    * Implement DAO method used add new investor to investor table and cap-table
    */
    public function investor(){
        
    }

    /** TODO
    * Implement DAO method to return list of all share classes from share_classes table
    */
    public function share_classes(){

    }

    /** TODO
    * Implement DAO method to return list of all share class categories from share_class_categories table
    */
    public function share_class_categories(){
        $query = "SELECT * FROM cap_table";
        return $this->query($query, []);
    }
}
?>
