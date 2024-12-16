<?php

function sendAutonotify($hook, $data) {
    global $wpdb;
    $table_name = $wpdb->prefix . "autonotify_config";
    $sqlToken = $wpdb->prepare("SELECT token FROM $table_name WHERE id = %d", 1);

    $api_key = API_URL;
    $token = $wpdb->get_var($sqlToken);

    $headers = [
        "Content-Type" => "application/json",
        "Authorization" => "Bearer " . $token
    ];

    $postfiels = [
        "keys" => $hook,
        "data" => $data,
    ];

    $response = wp_remote_post("$api_key/hooks/woocommerce", [
        'method'    => 'POST',
        'body'      => json_encode($postfiels), 
        'headers'   => $headers,            
        'timeout'   => 15,                   
    ]);

    $log_file = __DIR__ . '/debug.txt'; 
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        file_put_contents($log_file, "Request failed: $error_message" . PHP_EOL, FILE_APPEND); // Log de erro
        error_log("Request failed: $error_message");
    } else { 
        $response_body = wp_remote_retrieve_body($response);
        
        file_put_contents($log_file, "Response: $response_body" . PHP_EOL, FILE_APPEND);
        
        return $response_body;
    }
}
?>
