<?php

function getOrderData($orderId) {
    $order = new WC_Order($orderId);

    $customer_name = $order->get_meta('_billing_first_name') . ' ' . $order->get_meta('_billing_last_name');
    $customer_email = $order->get_meta('_billing_email');
    $customer_phone = $order->get_meta('_billing_phone');
    
    if (empty($customer_name)) {
        $customer_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
    }
    if (empty($customer_email)) {
        $customer_email = $order->get_billing_email();
    }
    if (empty($customer_phone)) {
        $customer_phone = $order->get_billing_phone();
    }

    $address_1 = $order->get_billing_address_1(); 
    $address_2 = $order->get_billing_address_2();
    $city = $order->get_billing_city();           
    $postcode = $order->get_billing_postcode();    
    $state = $order->get_billing_state();    
    $customer_id = $order->get_user_id();   

    $address = $address_1 . ', ' . $address_2 . ' - ' . $order->get_billing_neighborhood() . ' - ' . $city . '/' . $state;

 
    $items = [];
    foreach ($order->get_items() as $item_id => $item) {
        $items[] = $item->get_name(); 
    }
    $items_string = implode(', ', $items);

    $data = [
        "orderid" => $orderId,
        "paymentmethod" => $order->get_payment_method_title(),  
        "address" => $address,                                  
        "customername" => $customer_name,                        
        "customeremail" => $customer_email,                     
        "customerphone" => $customer_phone,  
        "customerid" => $customer_id,                    
        "ordertotal" => $order->get_total(),                  
        "status" => $order->get_status(),                    
        "createdaat" => $order->get_date_created()->date('Y-m-d H:i:s'), 
        "items" => $items_string,                                 
    ];

    return $data; 
}

?>
