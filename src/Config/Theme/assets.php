<?php
function autonotify_enqueue_assets() {
    wp_enqueue_script('homeScript', plugins_url('autonotify-for-woocommerce/public/js/home.js'), array(), date('YmdHis'), true);
    wp_enqueue_style('homeStyle', plugins_url('autonotify-for-woocommerce/public/css/home.css'), array(), date('YmdHis'));
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null);
}

add_action('admin_enqueue_scripts', 'autonotify_enqueue_assets');
?>