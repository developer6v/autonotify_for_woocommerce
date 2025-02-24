<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Configuração Menu
function autonotify_menu_manager() {
    add_menu_page(
        __( 'AutoNotify', 'autonotify-for-woocommerce' ),
        __( 'AutoNotify', 'autonotify-for-woocommerce' ),
        'manage_options',                          
        'whatsapp-settings',                         
        'autonotify_layout',     
        'dashicons-update',                       
        55                                          
    );
}


add_action('admin_menu', 'autonotify_menu_manager', 50);

 

?>