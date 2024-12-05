<?php


function validate_token ($token) {
    require_once __DIR__ . '/../../../../../../wp-load.php';

    $headers = [
        "Content-Type" => "application/json",
        "Authorization" => "Bearer " . $token
    ];

    $response = wp_remote_post('https://8453-187-110-208-152.ngrok-free.app/auth', [
        'method'    => 'POST',
        'headers'   => $headers,            
        'timeout'   => 15,                   
    ]);


    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        error_log("Request failed: $error_message");
    } else {
        $response_body = wp_remote_retrieve_body($response);
        return $response_body;
    }
}