<?php

/**
 * Plugin Name: Autonotify For Woocommerce
 * Plugin URI: https://github.com/developer6v/autonotify_for_woocommerce
 * Description: Integration between Autonotify and Woocommerce
 * Version: 1.0
 * Author: Sourei
 * Author URI: https://sourei.com.br/
 */


// Inicialização dos arquivos necessários
require_once 'src/Views/tabs-layout.php';
require_once 'src/Config/Database/autonotify_table_manager.php';


register_activation_hook(__FILE__, 'autonotify_table_manager');

add_action('admin_menu', 'autonotify_menu_manager', 50);

function autonotify_menu_manager() {
    add_menu_page(
        __( 'AutoNotify', 'woocommerce' ),
        __( 'AutoNotify', 'woocommerce' ),
        'manage_options',                          
        'whatsapp-settings',                         
        'autonotify_layout',     
        'dashicons-update',                       
        55                                          
    );

    /*add_submenu_page( 
        'whatsapp-settings',                       l
        __( 'Status', 'woocommerce' ),       
        __( 'Status', 'woocommerce' ),       
        'manage_options',                           
        'autonotify_status',                             
        'sourei_display_autonotify_status_page'     
    );*/
}
 


?>