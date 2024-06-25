<?php 

require_once __DIR__ . '/rest/services/CityService.class.php';

$payload = $_REQUEST;

if($payload['name'] == null || $payload['name'] == '') {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(["error" => "Name field is missing!"]));
}

$city_service = new CityService();
$city = $city_service->add_city($payload);

echo json_encode(["message" => "You have successfully added a City", "data" => $city]);