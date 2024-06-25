<?php 

require_once __DIR__ . '/../services/UserService.class.php';

Flight::set('user_service', new UserService());

Flight::route('GET /users', function() {
    //$user_service = new UserService();
    $users = Flight::get('user_service')->get_all_users();

    // echo json_encode(["message" => "Users sucessfully fetched", "data" => $users]);
    Flight::json(["message" => "Users sucessfully fetched", "data" => $users]);
});

Flight::route('GET /user_city_name', function() {
    $user_id = Flight::request()->query->id;

    // $user_service = new UserService();
    $user = Flight::get('user_service')->get_user_city($user_id);

    Flight::json(["message" => "Users sucessfully fetched", "data" => $user]);
});

Flight::route('POST /user/add', function () {
    $payload = Flight::request()->data->getData();

    if($payload['name'] == null || $payload['name'] == '') {
        // header("HTTP/1.1 500 Bad Request");
        // die(json_encode(["error" => "Name field is missing!"]));
        Flight::halt(500, "Name field is missing"); 
    }

    // $user_service = new UserService();
    $user = Flight::get('user_service')->add_user($payload);

    Flight::json(["message" => "You have successfully added a User", "data" => $user]);
});