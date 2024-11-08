<?php

function sendAutonotify($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . "autonotify_config";
    $sqlToken = $wpdb->prepare("SELECT token FROM $table_name WHERE id = %d", 1);
    $token = $wpdb->get_var($sqlToken);

    $headers = [
        "Content-Type" => "application/json",
        "Authorization" => "Bearer " . $token
    ];

    $response = wp_remote_post('https://webhook.site/bc6655e8-0cd2-460a-86dc-74fdc298e28b', [
        'method'    => 'POST',
        'body'      => json_encode($data), 
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

?>
