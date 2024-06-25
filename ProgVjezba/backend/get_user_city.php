<?php 

require_once __DIR__ . '/rest/services/UserService.class.php';


$user_id = (int)$_REQUEST['id'];


$user_service = new UserService();
$user = $user_service->get_user_city($user_id);

echo json_encode(["message" => "Users sucessfully fetched", "data" => $user]);