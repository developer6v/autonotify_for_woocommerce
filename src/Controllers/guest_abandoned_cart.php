<?php

require_once __DIR__ . '/../../../../../wp-load.php';

// Verificar se o WooCommerce está disponível
if ( class_exists( 'WooCommerce' ) ) {

    // Obter o valor do carrinho
    $cart_total = WC()->cart->get_total( 'raw' ); // Obtém o valor total sem formatação

    // Para um valor com a moeda formatada:
    // $cart_total_formatted = WC()->cart->get_total();

    // Agora você pode salvar ou usar o valor conforme necessário
    // Exemplo: Registrar ou enviar para outro sistema
    error_log( 'Total do Carrinho: ' . $cart_total );
    
    // Caso você queira retornar a informação via AJAX para o frontend
    wp_send_json_success( array( 'cart_total' => $cart_total ) );
} else {
    wp_send_json_error( array( 'message' => 'WooCommerce não está ativado.' ) );
}
