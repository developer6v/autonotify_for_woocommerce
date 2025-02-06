<?php

/*
 * Plugin Name:       Autonotify For Woocommerce
 * Plugin URI:        https://github.com/developer6v/autonotify_for_woocommerce
 * Description:       Autonotify for WooCommerce is a plugin that seamlessly integrates WooCommerce with the Autonotify platform, enabling automated WhatsApp message notifications based on order statuses and abandoned cart.
 * Version:           1.0
 * Requires at least: 6.2
 * Requires PHP:      7.2
 * Author:            Sourei
 * Author URI:        https://sourei.com.br/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       autonotify-for-woocommerce
 * Requires Plugins:  woocommerce
 */
if ( ! defined( 'ABSPATH' ) ) exit; 
define( 'AUTONOTIFY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AUTONOTIFY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once AUTONOTIFY_PLUGIN_DIR . 'src/Config/index.php';

?>