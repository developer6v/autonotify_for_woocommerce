<?php

require_once __DIR__ . '/../../../../../wp-load.php';
require_once __DIR__ . '/../Config/Woocommerce/abandoned-cart-hook.php';

if ( class_exists( 'WooCommerce' ) ) {
    $data = $_POST; 
    $abandoned_cart = new WC_Abandoned_Cart_Hook();
    $abandoned_cart->track_cart_on_checkout_guest($data);
    wp_send_json_success(array('message' => 'Carrinho rastreado com sucesso.'));
} else {
    wp_send_json_error( array( 'message' => 'WooCommerce não está ativado.' ) );
}
