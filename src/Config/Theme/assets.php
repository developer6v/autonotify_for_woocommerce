<?php
function autonotify_enqueue_assets() {
    wp_enqueue_script('homeScript', plugins_url('autonotify-for-woocommerce/public/js/home.js'), array(), gmdate('YmdHis'), true);
    wp_enqueue_style('homeStyle', plugins_url('autonotify-for-woocommerce/public/css/home.css'), array(), gmdate('YmdHis'));
    // Font Awesome
    wp_enqueue_style('font-awesome', plugins_url('autonotify-for-woocommerce/public/css/all.min.css'), array(), gmdate('YmdHis'));
}

add_action('admin_enqueue_scripts', 'autonotify_enqueue_assets');
?>