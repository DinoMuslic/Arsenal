<?php 

require_once __DIR__ . '/BaseDao.class.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function add_user($user) {
        return $this->insert('users', $user);
    }

    public function get_all_users() {
        $query = "SELECT * FROM users";
        return  $this->query($query, []);
    }

    public function get_user_city($user_id) {
        return $this->query_unique(
                    "SELECT c.name FROM cities c 
                     JOIN users u ON c.city_id = u.city_id 
                     WHERE u.id = :id", ['id' => $user_id]);
    }
}