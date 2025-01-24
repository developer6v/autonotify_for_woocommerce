<?php

if (!defined('ABSPATH')) {
    exit;
}

class WC_Abandoned_Cart_Hook {
    
    public function __construct() {
        $this->create_abandoned_cart_table();
        
        add_action('woocommerce_add_to_cart', array($this, 'track_cart_started'), 10, 6);
        add_action('woocommerce_cart_updated', array($this, 'update_cart_timestamp'));
        add_action('woocommerce_checkout_order_created', array($this, 'remove_completed_cart'));
        
        if (!wp_next_scheduled('check_abandoned_carts')) {
            add_filter('cron_schedules', function($schedules) {
                $schedules['every_minute'] = array(
                    'interval' => 60, 
                    'display'  => 'A cada minuto'
                );
                return $schedules;
            });
            
            wp_schedule_event(time(), 'every_minute', 'check_abandoned_carts');
        }
        add_action('check_abandoned_carts', array($this, 'process_abandoned_carts'));
    }
    
    public function create_abandoned_cart_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sr_wc_abandoned_carts';
        $charset_collate = $wpdb->get_charset_collate();
        if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {

            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                user_id bigint(20),
                user_email varchar(100),
                cart_contents longtext,
                cart_total decimal(10,2),
                created_at datetime DEFAULT CURRENT_TIMESTAMP,
                last_updated datetime DEFAULT CURRENT_TIMESTAMP,
                recovered boolean DEFAULT 0,
                PRIMARY KEY  (id)
            ) $charset_collate;";
            
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
    
    public function track_cart_started($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sr_wc_abandoned_carts';
        
        $user_id = get_current_user_id();
        $user_email = '';
        
        if ($user_id > 0) {
            $user = get_userdata($user_id);
            $user_email = $user->user_email;
        } else {
            if (WC()->session) {
                $user_email = WC()->session->get('customer_email');
            }
        }
        
        if (empty($user_email)) {
            return;
        }
        
        $existing_cart = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE user_email = %s AND recovered = 0",
            $user_email
        ));
        
        if (!$existing_cart) {
            $cart_contents = WC()->cart->get_cart_contents();
            $cart_total = WC()->cart->get_cart_contents_total();
            
            $wpdb->insert(
                $table_name,
                array(
                    'user_id' => $user_id,
                    'user_email' => $user_email,
                    'cart_contents' => json_encode($cart_contents),
                    'cart_total' => $cart_total
                ),
                array('%d', '%s', '%s', '%f')
            );
        }
    }
    
    public function update_cart_timestamp() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sr_wc_abandoned_carts';
        
        $user_email = '';
        $user_id = get_current_user_id();
        
        if ($user_id > 0) {
            $user = get_userdata($user_id);
            $user_email = $user->user_email;
        } elseif (WC()->session) {
            $user_email = WC()->session->get('customer_email');
        }
        
        if (!empty($user_email)) {
            $wpdb->update(
                $table_name,
                array('last_updated' => current_time('mysql')),
                array('user_email' => $user_email, 'recovered' => 0),
                array('%s'),
                array('%s', '%d')
            );
        }
    }
    
    public function remove_completed_cart($order_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sr_wc_abandoned_carts';
        
        $order = wc_get_order($order_id);
        $user_id = $order->get_user_id();
        if ($order) {
            $user_email = $order->get_billing_email();
            
            $wpdb->update(
                $table_name,
                array('recovered' => 1),
                array('user_id' => $user_id, 'recovered' => 0),
                array('%d'),
                array('%d', '%d')
            );
        }
    }
    
    public function process_abandoned_carts() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'sr_wc_abandoned_carts';
        
        $abandoned_threshold = date('Y-m-d H:i:s', strtotime('-1 minute'));
        
        $abandoned_carts = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name 
            WHERE recovered = 0 
            AND last_updated < %s",
            $abandoned_threshold
        ));
        
        foreach ($abandoned_carts as $cart) {
            do_action('wc_abandoned_cart_detected', $cart);
        }
    }
}

new WC_Abandoned_Cart_Hook();

