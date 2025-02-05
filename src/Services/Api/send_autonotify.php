<?php

function autonotify_sendData($hook, $data) {
    file_put_contents ('senddata.txt', json_encode($data));
    global $wpdb;
    $table_name = $wpdb->prefix . "sr_autonotify_config";

    $api_key = API_URL;
    $token = $wpdb->get_var($wpdb->prepare("SELECT token FROM %i WHERE id = %d", [$table_name, 1]));


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
        'body'      => wp_json_encode($postfiels), 
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
?>
