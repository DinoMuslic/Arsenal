<?php 

require_once __DIR__ . '/../services/UserService.class.php';

Flight::set("user_service", new UserService());

Flight::route("GET /users/all", function() {
    $users = Flight::get("user_service")->get_all_users();

    Flight::json(["data" => $users]);
});

Flight::route("GET /users/@letter", function($letter) {
    $users = Flight::get("user_service")->get_users_with_first_letter($letter);

    Flight::json(["data" => $users]);
});

Flight::route('POST /users/add', function() {
    $payload = Flight::request()->data->getData();

    if($payload['id'] != null && $payload['id'] != '') {
        $user = Flight::get('user_service')->edit_user($payload);
    } else {
        unset($payload['id']);
        $user = Flight::get('user_service')->add_user($payload);
    }

    Flight::json(['message' => "You have succesfully added the user", 'data' => $user]);
});

Flight::route('GET /users/get/@id', function($id) {
    $user = Flight::get('user_service')->get_user_by_id($id);
    Flight::json($user, 200);
});

Flight::route('GET /users', function() {
    $payload = Flight::request()->query;


    $params = [
        "start" => (int)$payload['start'],
        "search" => $payload['search']['value'],
        "draw" => $payload['draw'],
        "limit" => (int)$payload['length'],
        "order_column" => isset($payload['order']) ? $payload['order'][0]['name'] : 'id', // column umjesto name mozda :)
        "order_direction" => isset($payload['order']) ? $payload['order'][0]['dir'] : 'asc',
    ];


    // Count query
    $data = Flight::get('user_service')->get_users_paginated(
        $params['start'],
        $params['limit'],
        $params['search'],
        $params['order_column'],
        $params['order_direction']
    );

    foreach($data['data'] as $id => $user) {
        $data['data'][$id]['action'] = '<div class="d-flex justify-content-center"' . 
                                            '<div class="btn-group" role="group" aria-label="Actions">' .
                                                '<button style="margin-right: 10px;" type="button" class="btn btn-outline-primary" onClick="UserService.open_edit_user_modal('. $user['id'] .')">Edit</button>' .
                                                '<button type="button" class="btn btn-outline-danger" onClick="UserService.delete_user('. $user['id'] .')">Delete</button>' .
                                            '</div>' . 
                                        '</div>';    
    }

    // Response
    Flight::json([
        'draw' => $params['draw'],
        'data' => $data['data'],
        'recordsFiltered' => $data['count'],
        'recordsTotal' => $data['count'],
        'end' => $data['count']
    ], 200);
});

Flight::route('DELETE /users/delete/@id', function($id) {
    if($id == NULL || $id == '') {
        Flight::halt(500, "You have to provide valid user ID");
    }
   
    Flight::get('user_service') -> delete_user_by_id($id);

    Flight::json(['message' => "You have succesfully deleted the user"], 200);
}); 