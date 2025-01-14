<?php
// Mudança de Status de Pedido
add_action('woocommerce_order_status_changed', 'manage_order_status', 10, 3);
function manage_order_status ($order_id, $old_status, $new_status) {
    $data = getOrderData($order_id);
    sendAutonotify([str_replace("-", "_", $new_status)], $data);
}

// Pedido Criado
add_action('woocommerce_checkout_order_created', 'newordermanager', 10, 3);
function newordermanager ($order) {
    $data = getOrderData($order->get_id());
    $new_status = $order->get_status();
    sendAutonotify([str_replace("-", "_", $new_status), 'new_order_admin'], $data);
}

// Senha trocada
add_action( 'woocommerce_reset_password_notification', 'custom_password_reset_email_sent', 10, 3 );
function custom_password_reset_email_sent( $user_login, $key ) {
    $data = getResetPasswordData ($user_login, $key);
    sendAutonotify(['password_reset'], $data);
}


// Carrinho Abandonado
define('DEBUG_LOG_FILE', WP_CONTENT_DIR . '/debug-carrinho.log');

add_action('check_abandoned_carts', 'process_abandoned_carts');

function process_abandoned_carts() {
    global $wpdb;

    $current_time = time();
    $cutoff_time = $current_time - ( 20 * MINUTE_IN_SECONDS ); 

    $sessions = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT session_id, session_value FROM {$wpdb->prefix}woocommerce_sessions WHERE session_expiry < %d",
            $cutoff_time
        )
    );

    foreach ( $sessions as $session ) {
        $cart_data = maybe_unserialize( $session->session_value );

        if ( isset( $cart_data['cart'] ) && ! empty( $cart_data['cart'] ) ) {
            log_carrinho_abandonado( $session->session_id );
        }
    }
}

function log_carrinho_abandonado( $session_id ) {
    $log_message = "Carrinho abandonado encontrado - Sessão ID: {$session_id}\n";
    file_put_contents( DEBUG_LOG_FILE, $log_message, FILE_APPEND );
}

?>