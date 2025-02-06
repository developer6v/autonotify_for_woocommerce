<?php



// Mudança de Status de Pedido
add_action('woocommerce_order_status_changed', 'autonotify_manage_order_status', 10, 3);
function autonotify_manage_order_status ($order_id, $old_status, $new_status) {
    $data = autonotify_getOrderData($order_id);
    $status = str_replace("-", "_", $new_status);
    $status_admin = $status . "_admin";
    autonotify_sendData([$status, $status_admin], $data);
}

// Pedido Criado
add_action('woocommerce_checkout_order_created', 'autonotify_newordermanager', 10, 3);
function autonotify_newordermanager ($order) {
    $data = autonotify_getOrderData($order->get_id());
    $new_status = $order->get_status(); 
    autonotify_sendData([str_replace("-", "_", $new_status), 'new_order_admin'], $data);
}

// Senha trocada
add_action( 'woocommerce_reset_password_notification', 'autonotify_password_reset', 10, 3 );
function autonotify_password_reset( $user_login, $key ) {
    $data = autonotify_getResetPasswordData ($user_login, $key);
    autonotify_sendData(['password_reset'], $data);
}


// Carrinho Abandonado
add_action('wc_abandoned_cart_detected', 'autonotify_handle_abandoned_cart', 10, 1);
function autonotify_handle_abandoned_cart($cart) {
    $data = autonotify_getAbandonedCartData ($cart);
    autonotify_sendData(['abandoned_cart'], $data);
}


// Guest - Carrinho Abandonado
add_action('wc_abandoned_cart_guest_detected', 'autonotify_handle_abandoned_guest_cart', 10, 1);
function autonotify_handle_abandoned_guest_cart ($cart) {
    $data = autonotify_getAbandonedCartDataGuest ($cart);
    autonotify_sendData(['abandoned_cart'], $data);
}


?>