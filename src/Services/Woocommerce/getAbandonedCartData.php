<?php

ini_set('log_errors', 'On');
ini_set('error_log', $logFile);
ini_set('display_errors', 'On');
error_reporting(E_ALL);

function getAbandonedCartData($cart) {

    $customerId = $cart->user_id ?? null;
    $customerEmail = $cart->user_email ?? '';
    $cartValue = $cart->cart_total ?? '';
    $cartContents = !empty($cart->cart_contents) ? json_decode($cart->cart_contents, true) : [];
    $products = [];
    $orderProductsString = '';

    if (!empty($cartContents)) {
        foreach ($cartContents as $item) {
            $productId = $item['product_id'] ?? 0;
            $quantity = $item['quantity'] ?? 1;

            $productName = '';
            if ($productId) {
                $product = wc_get_product($productId); 
                $productName = $product ? $product->get_name() : 'Produto Desconhecido';
            }

            $products[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'line_total' => $item['line_total'] ?? 0,
            ];

            $orderProductsString .= $quantity . 'x ' . $productName . ', ';
        }
        $orderProductsString = rtrim($orderProductsString, ', ');
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

    $base_url = home_url('/'); 
    $url_params = '';

    if (!empty($products)) {
        foreach ($products as $product) {
            $url_params .= '&add-to-cart=' . $product['product_id'] . '&quantity=' . $product['quantity'];
        }
    }

    $cartUrl = $base_url . '?' . ltrim($url_params, '&');

    $createdAt = $cart->created_at ?? null;
    $date = $createdAt ? date('Y-m-d', strtotime($createdAt)) : '';
    $hour = $createdAt ? date('H:i:s', strtotime($createdAt)) : '';

    $data = [
        "address" => $address,
        "customername" => $customerName,
        "customeremail" => $customerEmail,
        "customerphone" => $customerPhone,
        "phone" => $customerPhone,
        "customerid" => $customerId,
        "date" => $date,
        "hour" => $hour,
        "cart_url" => $cartUrl,
        "cart_value" => $cartValue,
        "order_products" => $orderProductsString, 
    ];

    return $data;
}
