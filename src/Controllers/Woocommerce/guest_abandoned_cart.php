<?php

function autonotify_endpoint_abandoned_cart( WP_REST_Request $request ) {
    try {
        $data = json_decode( $request->get_body(), true );
        $abandoned_cart = new WC_Abandoned_Cart_Hook();
        $abandoned_cart->autonotify_track_cart_on_checkout_guest($data);
        return new WP_REST_Response(array('message' => 'Carrinho rastreado com sucesso.'), 200);
    } catch (Exception $e) {
        return new WP_REST_Response(array('message' => 'Ocorreu um erro: ' . $e->getMessage()), 500);
    }
}