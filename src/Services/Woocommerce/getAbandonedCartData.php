<?php

function getAbandonedCartData($session) {
    $cart_data = maybe_unserialize($session->session_value);

    $data = [
        "address" => "",
        "customername" => "",
        "customeremail" => "",
        "customerphone" => "",
        "phone" => "",
        "customerid" => "",
        "date" => date('Y-m-d'),
        "hour" => date('H:i:s'),
        "cart_url" => "",
        "cart_value" => "",
        "order_products" => "",
    ];

    if (isset($cart_data['customer']) && is_array($cart_data['customer'])) {
        $customer = $cart_data['customer'];

        $data['address'] = $customer['address_1'] ?? 'Endereço não informado';
        $data['customername'] = trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? ''));
        $data['customeremail'] = $customer['email'] ?? 'Email não informado';
        $data['customerphone'] = $customer['phone'] ?? 'Telefone não informado';
        $data['phone'] = $customer['phone'] ?? 'Telefone não informado';
        $data['customerid'] = $customer['id'] ?? 'ID não disponível';
    }

    if (isset($cart_data['cart_totals']) && is_string($cart_data['cart_totals'])) {
        $cart_totals = maybe_unserialize($cart_data['cart_totals']);

        if (isset($cart_totals['total'])) {
            $data['cart_value'] = $cart_totals['total'];
        }
    }

    if (isset($cart_data['cart']) && is_string($cart_data['cart'])) {
        $cart_items = maybe_unserialize($cart_data['cart']);
        if (is_array($cart_items)) {
            $data['cart_url'] = generate_cart_url($cart_items);
            $data['order_products'] = format_cart_products($cart_items);
        }
    }

    return $data;
}

function generate_cart_url($cart_items) {
    $base_url = get_site_url() . '/checkout/'; 
    $url_params = '';

    foreach ($cart_items as $item) {
        if (isset($item['product_id']) && isset($item['quantity'])) {
            $url_params .= '&add-to-cart=' . $item['product_id'] . '&quantity=' . $item['quantity'];
        }
    }

    return $base_url . '?' . ltrim($url_params, '&');
}

function format_cart_products($cart_items) {
    $products = [];
    foreach ($cart_items as $item) {
        if (isset($item['product_id'])) {
            $products[] = 'Produto ID: ' . $item['product_id'] . ', Quantidade: ' . $item['quantity'];
        }
    }
    return implode(", ", $products);
}
