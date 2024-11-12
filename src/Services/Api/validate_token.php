<?php

function validate_token ($token) {

    require_once __DIR__ . '/../../../../../../wp-load.php';

    global $wpdb;
    $table_name = $wpdb->prefix . 'autonotify_config';


    $response = [
        'instance_key' => 'teste123'
    ];

    if (isset($response['instance_key'])) {
        $sql = $wpdb->prepare("UPDATE $table_name SET instance_key = %s WHERE id = %d", $response['instance_key'], 1);
        $result = $wpdb->query($sql);
    }

    return 'active';
}