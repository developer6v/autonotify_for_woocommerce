<?php

function autonotify_getOrderData($orderId) {
    $order = wc_get_order($orderId);

    $customer_name = trim($order->get_billing_first_name() . ' ' . $order->get_billing_last_name());
    $customer_email = $order->get_billing_email();
    $customer_phone = $order->get_billing_phone();

    if (empty($customer_name)) {
        $customer_name = __('Cliente não informado', 'woocommerce');
    }
    if (empty($customer_email)) {
        $customer_email = __('Sem e-mail', 'woocommerce');
    }
    if (empty($customer_phone)) {
        $customer_phone = __('Sem telefone', 'woocommerce');
    }

    $address_1 = $order->get_billing_address_1(); 
    $address_2 = $order->get_billing_address_2();
    $city = $order->get_billing_city();
    $state = $order->get_billing_state();
    $postcode = $order->get_billing_postcode();
    $customer_id = $order->get_user_id();

    $address = trim("$address_1 $address_2 - $city/$state - $postcode");

    $items = [];
    foreach ($order->get_items() as $item) {
        $items[] = $item->get_name();
    }
    $items_string = implode(', ', $items);

    $admin_order_url = admin_url("post.php?post={$orderId}&action=edit");
    $customer_order_url = wc_get_endpoint_url('view-order', $orderId, wc_get_page_permalink('myaccount'));

    $companyname = get_bloginfo('name');

    $data = [
        "orderid" => $orderId,
        "companyname" => $companyname,
        "customerorderurl" => $customer_order_url,
        "adminorderurl" => $admin_order_url,
        "paymentmethod" => $order->get_payment_method_title(),
        "address" => $address,
        "customername" => $customer_name,
        "customeremail" => $customer_email,
        "customerphone" => $customer_phone,
        "customerid" => $customer_id,
        "ordertotal" => number_format($order->get_total(), 2, ',', ''),
        "status" => $order->get_status(),
        "createdaat" => $order->get_date_created() ? $order->get_date_created()->date('Y-m-d H:i:s') : '',
        "items" => $items_string,
        "date" => gmdate("d/m/Y"),
        "hour" => gmdate("H:i:s")
    ];

    return $data;
}

?>
