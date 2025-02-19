<?php

// Admin
function autonotify_enqueue_assets() {
    wp_enqueue_script('homeScript', AUTONOTIFY_PLUGIN_URL . 'public/js/home.js', array(), gmdate('YmdHis'), true);
    wp_enqueue_style('homeStyle', AUTONOTIFY_PLUGIN_URL . 'public/css/home.css', array(), gmdate('YmdHis'));

    wp_localize_script('homeScript', 'autonotify_ajax_token', array(
        'ajax_url' => rest_url('autonotify/v1/token/'),  
        'nonce'    => wp_create_nonce('wp_rest'),             
    ));
}
add_action('admin_enqueue_scripts', 'autonotify_enqueue_assets');


// Usuário
add_action('wp_enqueue_scripts', function() {
    if (is_checkout()) {
        wp_enqueue_script(
            'srGuestCapture',
            AUTONOTIFY_PLUGIN_URL . 'public/js/guest_capture.js',
            array(),
            gmdate('YmdHis'),
            true
        );


        wp_localize_script('srGuestCapture', 'autonotify_ajax_abandoned_cart_guest', array(
            'ajax_url' => rest_url('autonotify/v1/guest_abandoned_cart/'),  
            'nonce'    => wp_create_nonce('wp_rest'),    
        ));
    }
});
?>