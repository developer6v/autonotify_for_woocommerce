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
require_once 'src/Core/hooks.php';


// Ativação do Plugin - Cria Tabela
register_activation_hook(__FILE__, 'autonotify_table_manager');

// Adiciona Menu no Wordpress
add_action('admin_menu', 'autonotify_menu_manager', 50);

// Carrega o JS e o CSS 
wp_enqueue_script('homeScript', plugins_url('public/js/home.js', __FILE__), array(),  date('YmdHis'));
wp_enqueue_style('homeStyle', plugins_url('public/css/home.css', __FILE__), array(),  date('YmdHis'));
wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null);

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