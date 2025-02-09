<?php

function autonotify_getAbandonedCartData($cart) {

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
    $date = $createdAt ? gmdate('Y-m-d', strtotime($createdAt)) : '';
    $hour = $createdAt ? gmdate('H:i:s', strtotime($createdAt)) : '';

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
        "whatsapp_link" => "https://wa.me/" . preg_replace('/\D/', '', $customerPhone),
        
    ];

    return $data;
}




function autonotify_getAbandonedCartDataGuest ($cart) {

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


    $formDataJson = json_decode ($cart->form_data, true);
    $customerName = $formDataJson['billing_first_name'] . ' ' . $formDataJson['billing_last_name'];
    $customerEmail = $customerEmail ?: $formDataJson['billing_email'];
    $customerPhone = $cart->phone ?: $formDataJson['billing_phone'];
    $address = !empty($formDataJson['billing_address_1']) ? 
        ($formDataJson['billing_address_1'] . ', ' . $formDataJson['billing_city'] . ', ' . 
        $formDataJson['billing_state'] . ' - ' . $formDataJson['billing_postcode']) : 
        (!empty($formDataJson['shipping_address_1']) ? 
            ($formDataJson['shipping_address_1'] . ', ' . $formDataJson['shipping_city'] . ', ' . 
            $formDataJson['shipping_state'] . ' - ' . $formDataJson['shipping_postcode']) : 
            'Endereço Desconhecido');


    $base_url = home_url('/'); 
    $url_params = '';

    if (!empty($products)) {
        foreach ($products as $product) {
            $url_params .= '&add-to-cart=' . $product['product_id'] . '&quantity=' . $product['quantity'];
        }
    }

    $cartUrl = $base_url . '?' . ltrim($url_params, '&');

    $createdAt = $cart->created_at ?? null;
    $date = $createdAt ? gmdate('Y-m-d', strtotime($createdAt)) : '';
    $hour = $createdAt ? gmdate('H:i:s', strtotime($createdAt)) : '';

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
        "whatsapp_link" => "https://wa.me/" . preg_replace('/\D/', '', $customerPhone),
    ];

    return $data;
}
