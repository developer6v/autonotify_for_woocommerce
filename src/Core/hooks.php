<?php

add_action('woocommerce_order_status_changed', 'testesoureiorderstatuschanged', 10, 3);

function testesoureiorderstatuschanged ($order_id,$old_status,$new_status) {
    $data = [
        "orderid" => $order_id,
        "old_status" => $old_status,
        "new_status" => $new_status,
    ];
    $ch = curl_init('https://webhook.site/bc6655e8-0cd2-460a-86dc-74fdc298e28b');
    curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode ($data, true));
    curl_setopt ($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);
}

?>