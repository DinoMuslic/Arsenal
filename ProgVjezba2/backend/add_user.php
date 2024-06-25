<?php 

require_once __DIR__ . '/rest/services/UserService.class.php';

$payload = $_REQUEST;

if($payload['name'] == null || $payload['name'] == '') {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(["error" => "Name field is missing!"]));
}

$user_service = new UserService();
$user = $user_service->add_user($payload);

echo json_encode(["message" => "You have successfully added a User", "data" => $user]);