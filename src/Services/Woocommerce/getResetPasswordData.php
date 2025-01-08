<?php

function getResetPasswordData($user) {
    
    $customer_phone = get_user_meta( $user->ID, 'billing_phone', true );
    $key = get_password_reset_key( $user );
    $reset_url = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' );

    $address_1 = get_user_meta($user->ID, 'billing_address_1', true);
    $city = get_user_meta($user->ID, 'billing_city', true);
    $state = get_user_meta($user->ID, 'billing_state', true);
    $address = $address_1 . ' - ' . $city . '/' . $state;

    $customer_name = $user->display_name;
    $customer_email = $user->user_email;
    $customer_id = $user->ID;

    $data = [
        "reset_url" => $reset_url,
        "date" => date("d/m/Y"),
        "hour" => date("H:i:s"),
        "address" => $address,                                  
        "customername" => $customer_name,                        
        "customeremail" => $customer_email,                     
        "customerphone" => $customer_phone,
        "customerid" => $customer_id,                      
    ];
}

?>
