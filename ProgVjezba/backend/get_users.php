<?php 

require_once __DIR__ . '/rest/services/UserService.class.php';


$user_service = new UserService();
$users = $user_service->get_all_users();

echo json_encode(["message" => "Users sucessfully fetched", "data" => $users]);
