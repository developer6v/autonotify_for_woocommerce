<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action ('rest_api_init', 'autonotify_manage_endpoints');

function autonotify_manage_endpoints () {
    register_rest_route(
        'autonotify/v1',
        '/token',
        array(
            'methods' => 'POST',
            'callback' => 'autonotify_endpoint_token',
            'permission_callback' => function() {
                return current_user_can( 'manage_options');
            }
        )
    );

    register_rest_route(
        'autonotify/v1',
        '/guest_abandoned_cart',
        array(
            'methods' => 'POST',
            'callback' => 'autonotify_endpoint_abandoned_cart',
            'permission_callback' => function( $request ) {
                $nonce = $request->get_header( 'X-WP-Nonce' );
                if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
                    return new WP_Error(
                        'rest_forbidden',
                        esc_html__( 'Nonce inválido', 'autonotify-for-woocommerce' ),
                        array( 'status' => 403 )
                    );
                }
                return true;
            }
        )
    );

}