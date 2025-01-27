<?php

function getResetPasswordData($user_login, $key) {
    $user = get_user_by( 'login', $user_login );
    $customer_phone = get_user_meta($user->ID, 'billing_phone', true);
    if (empty($customer_phone)) {
        $customer_phone = get_user_meta($user->ID, 'shipping_phone', true);
    }

    $reset_url = add_query_arg(
        [
            'key'   => $key,
            'login' => rawurlencode( $user_login )
        ],
        wp_lostpassword_url()
    );

    $address_1 = get_user_meta($user->ID, 'billing_address_1', true);
    $city = get_user_meta($user->ID, 'billing_city', true);
    $state = get_user_meta($user->ID, 'billing_state', true);
    $address = $address_1 . ' - ' . $city . '/' . $state;

    $customer_name = $user->display_name;
    $customer_email = $user->user_email;
    $customer_id = $user->ID;

    $data = [
        "passwordreseturl" => $reset_url,
        "date" => gmdate("d/m/Y"),
        "hour" => gmdate("H:i:s"),
        "address" => $address,                                  
        "customername" => $customer_name,                        
        "customeremail" => $customer_email,                     
        "customerphone" => $customer_phone,
        "phone" => $customer_phone,  
        "customerid" => $customer_id,                      
    ];

    return $data;
}

?>
