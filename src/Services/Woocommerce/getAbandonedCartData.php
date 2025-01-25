<?php

ini_set('log_errors', 'On');
ini_set('error_log', $logFile);
ini_set('display_errors', 'On'); 
error_reporting(E_ALL);

function getAbandonedCartData($cart) {
    file_put_contents('debug-carrinho-teste.log', 'getAbandonedCart' . PHP_EOL, FILE_APPEND);
    $customerId = $cart['user_id'] ?? null;
    $customerEmail = $cart['user_email'] ?? '';
    $cartValue = $cart['cart_total'] ?? '';
    $cartContents = !empty($cart['cart_contents']) ? json_decode($cart['cart_contents'], true) : [];
    $products = [];
    
    if (!empty($cartContents)) {
        foreach ($cartContents as $item) {
            $products[] = [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'line_total' => $item['line_total']
            ];
        }
    }

    $customerName = '';
    $customerPhone = '';
    $address = '';
    if ($customerId) {
        $user = new WC_Customer($customerId); 
        if ($user) {
            $customerName = $user->get_first_name() . ' ' . $user->get_last_name();
            $customerEmail = $customerEmail ?: $user->get_email();

            $customerPhone = $user->get_billing_phone();
            $address = $user->get_billing_address_1() . ', ' .
                       $user->get_billing_city() . ', ' .
                       $user->get_billing_state() . ' - ' .
                       $user->get_billing_postcode();
        }
    }
    file_put_contents('debug-carrinho-teste.log', 'getAbandonedCart1' . PHP_EOL, FILE_APPEND);

    // Gerar a URL do carrinho com base nos produtos
    $base_url = home_url('/'); // Base para a URL do carrinho
    $url_params = '';

    if (!empty($products)) {
        foreach ($products as $product) {
            $url_params .= '&add-to-cart=' . $product['product_id'] . '&quantity=' . $product['quantity'];
        }
    }

    $cartUrl = $base_url . '?' . ltrim($url_params, '&');

    // Montar os dados finais do carrinho
    $data = [ 
        "address" => $address,
        "customername" => $customerName,
        "customeremail" => $customerEmail,
        "customerphone" => $customerPhone,
        "phone" => $customerPhone, 
        "customerid" => $customerId,
        "date" => date('Y-m-d', strtotime($cart['created_at'])),
        "hour" => date('H:i:s', strtotime($cart['created_at'])),
        "cart_url" => $cartUrl,
        "cart_value" => $cartValue,
        "order_products" => $products,
    ];

    return $data;
}
