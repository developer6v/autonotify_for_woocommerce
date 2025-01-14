<?php

function getAbandonedCartData($session) {
    $cart_data = maybe_unserialize($session->session_value);

    $data = [
        "address" => "",
        "customername" => "",
        "customeremail" => "",
        "customerphone" => "",
        "customerid" => "",
        "date" => date('Y-m-d'),
        "hour" => date('H:i:s'),
        "cart_url" => "",
        "cart_value" => "",
        "order_products" => "",
    ];

    if (isset($cart_data['customer']) && is_array($cart_data['customer'])) {
        $customer = $cart_data['customer'];
        $data['address'] = $customer['address'] ?? 'Endereço não informado';
        $data['customername'] = trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? ''));
        $data['customeremail'] = $customer['email'] ?? 'Email não informado';
        $data['customerphone'] = $customer['phone'] ?? 'Telefone não informado';
        $data['customerid'] = $customer['id'] ?? 'ID não disponível';
    }

    if (isset($cart_data['cart']) && is_array($cart_data['cart'])) {
        $cart_items = $cart_data['cart'];
        $data['cart_url'] = generate_cart_url($cart_items);
        $data['cart_value'] = calculate_cart_value($cart_items);
        $data['order_products'] = format_cart_products($cart_items);
    }

    return $data; 
}

function generate_cart_url($cart_items) {
    $base_url = site_url('/cart/');
    return add_query_arg(['cart' => urlencode(serialize($cart_items))], $base_url);
}

function calculate_cart_value($cart_items) {
    $total = 0;
    foreach ($cart_items as $item) {
        $total += $item['line_total'] ?? 0;
    }
    return wc_price($total);
}

function format_cart_products($cart_items) {
    $products = [];
    foreach ($cart_items as $item) {
        $product = wc_get_product($item['product_id']);
        if ($product) {
            $products[] = $product->get_name() . ' x ' . ($item['quantity'] ?? 1);
        }
    }
    return implode(', ', $products);
}

?>
