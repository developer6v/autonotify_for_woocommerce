<?php
function autonotify_enqueue_assets() {
    wp_enqueue_script('homeScript', plugins_url('autonotify-for-woocommerce/public/js/home.js'), array(), gmdate('YmdHis'), true);
    wp_enqueue_style('homeStyle', plugins_url('autonotify-for-woocommerce/public/css/home.css'), array(), gmdate('YmdHis'));
    // Font Awesome
    wp_enqueue_style('font-awesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), gmdate('YmdHis'));


    // Guest
    wp_enqueue_script(
        'srGuestCapture',
        plugins_url('autonotify-for-woocommerce/public/js/guest_capture.js'),
        array(),
        gmdate('YmdHis'),
        true
    );
    
}

add_action('admin_enqueue_scripts', 'autonotify_enqueue_assets');
?>