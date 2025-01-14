<?php
function getAbandonedCartData($session) {
    // Desserializa o valor da sessão
    $cart_data = maybe_unserialize($session->session_value);

    // Inicializa o array de dados
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

    // Verifica se os dados do cliente estão presentes
    if (isset($cart_data['customer']) && is_array($cart_data['customer'])) {
        $customer = $cart_data['customer'];

        // Preenche os dados do cliente
        $data['address'] = $customer['address_1'] ?? 'Endereço não informado';
        $data['customername'] = trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? ''));
        $data['customeremail'] = $customer['email'] ?? 'Email não informado';
        $data['customerphone'] = $customer['phone'] ?? 'Telefone não informado';
        $data['customerid'] = $customer['id'] ?? 'ID não disponível';
    }

    // Verifica se os totais do carrinho estão presentes
    if (isset($cart_data['cart_totals']) && is_string($cart_data['cart_totals'])) {
        $cart_totals = maybe_unserialize($cart_data['cart_totals']);

        // Preenche o valor do carrinho
        if (isset($cart_totals['total'])) {
            $data['cart_value'] = $cart_totals['total'];
        }
    }

    // Verifica se os itens do carrinho estão presentes
    if (isset($cart_data['cart']) && is_string($cart_data['cart'])) {
        $cart_items = maybe_unserialize($cart_data['cart']);

        // Preenche os dados do carrinho
        if (is_array($cart_items)) {
            $data['cart_url'] = generate_cart_url($cart_items);
            $data['order_products'] = format_cart_products($cart_items);
        }
    }

    return $data;
}

// Função para gerar a URL do carrinho
function generate_cart_url($cart_items) {
    $base_url = get_site_url() . '/cart/';
    $cart_hash = md5(json_encode($cart_items)); // Gerar um hash simples para identificação do carrinho
    return $base_url . '?cart=' . $cart_hash;
}

// Função para formatar os produtos do carrinho
function format_cart_products($cart_items) {
    $products = [];
    foreach ($cart_items as $item) {
        if (isset($item['product_id'])) {
            $products[] = 'Produto ID: ' . $item['product_id'] . ', Quantidade: ' . $item['quantity'];
        }
    }
    return implode(", ", $products);
}
