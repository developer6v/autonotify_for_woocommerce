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

add_action('woocommerce_cart_updated', 'salvar_carrinho_na_sessao');
function salvar_carrinho_na_sessao() {
    if (WC()->cart && !WC()->cart->is_empty()) {
        $cart_contents = WC()->cart->get_cart();
        WC()->session->set('carrinho_abandonado', json_encode($cart_contents));
        $mensagem = '[woocommerce_cart_updated] Carrinho atualizado: ' . json_encode($cart_contents);
        file_put_contents(DEBUG_LOG_FILE, $mensagem . PHP_EOL, FILE_APPEND);
    }
}

add_action('woocommerce_cleanup_sessions', 'verificar_carrinho_abandonado');
function verificar_carrinho_abandonado() {
    $carrinho = WC()->session->get('carrinho_abandonado');
    if ($carrinho) {
        $mensagem = '[woocommerce_shutdown] Carrinho abandonado detectado: ' . $carrinho;
        file_put_contents(DEBUG_LOG_FILE, $mensagem . PHP_EOL, FILE_APPEND);
    }
}

?>