<?php

function autonotify_validate_token ($token) {
    require_once __DIR__ . '/../../../../../../wp-load.php';
    $api_key = API_URL;
    $headers = [
        "Content-Type" => "application/json",
        "Authorization" => "Bearer " . $token
    ];
    
    $response = wp_remote_post("$api_key/auth", [
        'method'    => 'POST',
        'headers'   => $headers,            
        'timeout'   => 15,                   
    ]);

    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
    } else {
        $response_body = wp_remote_retrieve_body($response);
        return $response_body;
    }
}