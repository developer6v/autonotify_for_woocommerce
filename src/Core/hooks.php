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
    error_log('key0, ', $key);
    $user = get_user_by( 'login', $user_login );
    $data = getResetPasswordData ($user);
    sendAutonotify(['password_reset'], $data);
}
?>