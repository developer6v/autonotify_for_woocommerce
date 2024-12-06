<?php

function getOrderData($orderId) {
    global $wpdb;
    $table_name = $wpdb->prefix . "autonotify_config";
    $sqlInstanceKey = $wpdb->prepare("SELECT instance_key FROM $table_name WHERE id = %d", 1);


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

    $address = $address_1 . ' - ' . $city . '/' . $state;

 
    $items = [];
    foreach ($order->get_items() as $item_id => $item) {
        $items[] = $item->get_name(); 
    }
    $items_string = implode(', ', $items);


    $admin_order_url = admin_url('post.php?post=' . $orderId . '&action=edit');
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
        "phone" => $customer_phone,  
        "customerid" => $customer_id,                    
        "ordertotal" => number_format($order->get_total(), 2, ',', ''),
        "status" => $order->get_status(),                    
        "createdaat" => $order->get_date_created()->date('Y-m-d H:i:s'), 
        "items" => $items_string, 
        "date" => date("d/m/Y"),
        "hour" => date("H:i:s")
    ];



    return $data; 
}

?>
