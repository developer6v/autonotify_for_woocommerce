<?php
function autonotify_enqueue_assets() {
    wp_enqueue_script('homeScript', plugins_url('public/js/home.js', __FILE__), array(), date('YmdHis'), true);
    wp_enqueue_style('homeStyle', plugins_url('public/css/home.css', __FILE__), array(), date('YmdHis'));
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null);
}

add_action('admin_enqueue_scripts', 'autonotify_enqueue_assets');
?>