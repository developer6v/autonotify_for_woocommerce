<?php

add_action('woocommerce_order_status_changed', 'manage_order_status', 10, 3);

function manage_order_status ($order_id, $old_status, $new_status) {
    $data = getOrderData($order_id);
    sendAutonotify([str_replace("-", "_", $new_status)], $data);
}


add_action('woocommerce_checkout_order_created', 'newordermanager', 10, 3);

function newordermanager ($order) {
    $data = getOrderData($order->get_id());
    $new_status = $order->get_status();
    sendAutonotify([str_replace("-", "_", $new_status), 'new_order_admin'], $data);
}

?>