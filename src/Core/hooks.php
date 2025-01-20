<?php

define('DEBUG_LOG_FILE_STATUS', WP_CONTENT_DIR . '/debug-order.log');


// Mudança de Status de Pedido
add_action('woocommerce_order_status_changed', 'manage_order_status', 10, 3);
function manage_order_status ($order_id, $old_status, $new_status) {
    $data = getOrderData($order_id);
    $status = str_replace("-", "_", $new_status);
    $status_admin = $status . "_admin";
    sendAutonotify([$status, $status_admin], $data);
    file_put_contents(DEBUG_LOG_FILE, json_encode($data));
}

// Pedido Criado
add_action('woocommerce_checkout_order_created', 'newordermanager', 10, 3);
function newordermanager ($order) {
    $data = getOrderData($order->get_id());
    $new_status = $order->get_status(); 
    sendAutonotify([str_replace("-", "_", $new_status), 'new_order_admin'], $data);
    file_put_contents(DEBUG_LOG_FILE, json_encode($data));
}

// Senha trocada
add_action( 'woocommerce_reset_password_notification', 'custom_password_reset_email_sent', 10, 3 );
function custom_password_reset_email_sent( $user_login, $key ) {
    $data = getResetPasswordData ($user_login, $key);
    sendAutonotify(['password_reset'], $data);
    file_put_contents(DEBUG_LOG_FILE, json_encode($data));
}


define('DEBUG_LOG_FILE', WP_CONTENT_DIR . '/debug-carrinho.log');

// Carrinho Abandonado
add_action('check_abandoned_carts', 'process_abandoned_carts');
function process_abandoned_carts() {
    global $wpdb;
    $current_time = time();
    $cutoff_time = $current_time - ( 10 * MINUTE_IN_SECONDS ); 
    $sessions = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT session_id, session_value FROM {$wpdb->prefix}woocommerce_sessions",
        )
    );
    foreach ($sessions as $session) {
        $data = getAbandonedCartData($session);
        file_put_contents(DEBUG_LOG_FILE, json_encode($data));
        sendAutonotify(['abandoned_cart'], $data);
    }
}

?>