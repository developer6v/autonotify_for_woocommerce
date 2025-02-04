<?php

if (!defined('ABSPATH')) {
    exit;
}

class WC_Abandoned_Cart_Hook {
    
    public function __construct() {
        $this->autonotify_create_abandoned_cart_table();
        
        add_action('woocommerce_before_checkout_form', array($this, 'autonotify_track_cart_on_checkout'));
        add_action('woocommerce_checkout_order_created', array($this, 'autonotify_remove_completed_cart'));
        
        if (!wp_next_scheduled('check_abandoned_carts')) {
            wp_schedule_event(time(), 'every_20_minutes', 'check_abandoned_carts');
        }
        
        add_action('check_abandoned_carts', array($this, 'autonotify_process_abandoned_carts'));
    }
    
    public static function autonotify_register_cron_schedule($schedules) {
        $schedules['every_20_minutes'] = array(
            'interval' => 20 * 60, 
            'display'  => 'A cada 20 minutos'
        );
        return $schedules;
    }
    
    public function autonotify_create_abandoned_cart_table() {
        global $wpdb;
        $table_name = esc_sql($wpdb->prefix . 'sr_wc_abandoned_carts');
        $charset_collate = $wpdb->get_charset_collate();
        
        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                id BIGINT(20) NOT NULL AUTO_INCREMENT,
                user_id BIGINT(20) NULL,
                user_email VARCHAR(100) NULL,
                phone VARCHAR(100) NULL,
                is_guest BOOLEAN NULL,
                form_data TEXT NULL,
                cart_contents LONGTEXT NULL,
                cart_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                last_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                recovered TINYINT(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (id)
            ) $charset_collate;";
    
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }
    
    public function autonotify_track_cart_on_checkout() {
        global $wpdb;
        $table_name = esc_sql($wpdb->prefix . 'sr_wc_abandoned_carts');
        
        $user_id = get_current_user_id();
        $user_email = $user_id > 0 ? get_userdata($user_id)->user_email : WC()->session->get('customer_email');
        
        if (empty($user_email)) {
            return;
        }
        
        $cart_contents = WC()->cart->get_cart_contents();
        $cart_total = WC()->cart->get_cart_contents_total();
        
        $existing_cart = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE user_email = %s AND recovered = 0",
            $user_email
        ));
        
        if ($existing_cart) {
            $wpdb->update(
                $table_name,
                array(
                    'cart_contents' => wp_json_encode($cart_contents),
                    'cart_total' => $cart_total,
                ),
                array('id' => $existing_cart),
                array('%s', '%f'),
                array('%d')
            );
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    'user_id' => $user_id,
                    'is_guest' => false, 
                    'user_email' => $user_email,
                    'cart_contents' => wp_json_encode($cart_contents),
                    'cart_total' => $cart_total,
                    'recovered' => 0
                ),
                array('%d', '%d', '%s', '%s', '%f', '%d')  
            );
        }
    }
    

    
    public function autonotify_track_cart_on_checkout_guest($data) {
        if (is_user_logged_in()) {
            return;
        }
        global $wpdb;
        $table_name = esc_sql($wpdb->prefix . 'sr_wc_abandoned_carts');
        
        $user_email = $data['billing_email'];
        $phone = $data['billing_phone'];
        
        if (empty($phone) || empty($user_email)) {
            return;
        }
        
        $cart_contents = WC()->cart->get_cart_contents();
        $cart_total = WC()->cart->get_cart_contents_total();
        
        $existing_cart = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE user_email = %s AND recovered = 0",
            $user_email
        ));
          
        if ($existing_cart) {
            $wpdb->update(
                $table_name,
                array(
                    'cart_contents' => wp_json_encode($cart_contents),
                    'cart_total' => $cart_total,
                ),
                array('id' => $existing_cart),
                array('%s', '%f'),
                array('%d')
            );
            
        } else {
            $wpdb->insert(
                $table_name,
                array(
                    'user_id' => -1,
                    'is_guest' => true,
                    'user_email' => $user_email,
                    'phone' => $phone,
                    'form_data' => wp_json_encode($data),
                    'cart_contents' => wp_json_encode($cart_contents),
                    'cart_total' => $cart_total,
                    'recovered' => 0
                ),
                array(
                    '%d', 
                    '%d', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%s', 
                    '%f',
                    '%d' 
                )
            );
            
        }
    }


    public function autonotify_remove_completed_cart($order_id) {
        global $wpdb;
        $table_name = esc_sql($wpdb->prefix . 'sr_wc_abandoned_carts');
        
        $order = wc_get_order($order_id);
        if ($order) {
            $user_email = $order->get_billing_email();
            $wpdb->update(
                $table_name,
                array('recovered' => 1),
                array('user_email' => $user_email, 'recovered' => 0),
                array('%d'),
                array('%s', '%d')
            );
        }
    }
    
    public function autonotify_process_abandoned_carts() {
        global $wpdb;
        $table_name = esc_sql($wpdb->prefix . 'sr_wc_abandoned_carts');
        
        $abandoned_threshold = gmdate('Y-m-d H:i:s', strtotime('-20 minutes', strtotime(current_time('mysql'))));

        $abandoned_carts = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} WHERE recovered = 0 AND created_at <= %s",
                $abandoned_threshold
            )
        );

        foreach ($abandoned_carts as $cart) {
            if ($cart->is_guest) {
                do_action('wc_abandoned_cart_guest_detected', $cart);
            } else {
                do_action('wc_abandoned_cart_detected', $cart);
            }
            $wpdb->update(
                $table_name,
                array('recovered' => 1),
                array('id' => $cart->id), 
                array('%d'), 
                array('%d') 
            );
        }
    }
}


add_filter('cron_schedules', array('WC_Abandoned_Cart_Hook', 'autonotify_register_cron_schedule'));
new WC_Abandoned_Cart_Hook();
