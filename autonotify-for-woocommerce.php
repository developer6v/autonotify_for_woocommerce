<?php

/**
 * Plugin Name: Autonotify For Woocommerce
 * Plugin URI: https://github.com/developer6v/autonotify_for_woocommerce
 * Description: Integration between Autonotify and Woocommerce
 * Version: 1.0
 * Author: Sourei
 * Author URI: https://sourei.com.br/
 */





require_once 'src/Views/tabs-layout.php';
require_once 'src/Config/Database/autonotify_table_manager.php';

// Ativação do Plugin - Cria Tabela
register_activation_hook(__FILE__, 'autonotify_table_manager');

// Adiciona Menu no Wordpress
add_action('admin_menu', 'autonotify_menu_manager', 50);

// Carrega o JS e o CSS 
wp_enqueue_script (plugins_url( 'homeScript', 'public/js/home.js', __FILE__ ););
wp_enqueue_style (plugins_url('homeStyle',  'public/css/home.css', __FILE__ ););


// Configuração Menu
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
}
 


?>