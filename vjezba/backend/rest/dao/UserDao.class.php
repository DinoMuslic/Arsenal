<?php 

require_once __DIR__ . "/BaseDao.class.php";

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function add_user($user) {
        return $this->insert('users', $user);
    }

    public function count_users_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM users
                  WHERE LOWER(first_name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(last_name) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%')";
        
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_users_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT * 
                  FROM users
                  WHERE LOWER(first_name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(last_name) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function get_user_by_id($id) {
        return $this->query_unique("SELECT * FROM users WHERE id = :id", ['id' => $id]);
    }

    public function delete_user_by_id($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $this->execute($query, ['id' => $id]);
    }

    public function edit_user($id, $user) {
        $query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email
                  WHERE id = :id";
        $this->execute($query, [
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'id' => $id
        ]);
    }

    public function get_all_users() {
        $query = "SELECT * FROM users";
        return  $this->query($query, []);
    }

    public function get_users_with_first_letter($letter) {
        $query = "SELECT * FROM users WHERE first_name LIKE :letter";
        return  $this->query($query, ['letter' => $letter . '%']);
    }
}