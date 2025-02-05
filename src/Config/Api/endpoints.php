<?php

add_action ('rest_api_init', 'autonotify_manage_endpoints');

function autonotify_manage_endpoints () {
    register_rest_route(
        'autonotify/v1',
        '/token',
        array(
            'methods' => 'POST',
            'callback' => 'autonotify_endpoint_token',
            'permission_callback' => '__return_true', 
        )
    );

    register_rest_route(
        'autonotify/v1',
        '/guest_abandoned_cart',
        array(
            'methods' => 'POST',
            'callback' => 'autonotify_endpoint_abandoned_cart',
            'permission_callback' => '__return_true', 
        )
    );

}