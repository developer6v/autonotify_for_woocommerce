<?php
if ( ! defined( 'ABSPATH' ) ) exit; 

function autonotify_table_manager() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sr_autonotify_config';
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL auto_increment,
            token TEXT NULL,
            instance_key varchar(60) NULL,
            status varchar(60) NULL,
            PRIMARY KEY (id) 
        ) $charset_collate";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
        
        $data = array(
            'token' => '', 
            'status' => '',
            'instance_key' => ''
        );

        $wpdb->insert($table_name, $data);
    }
}

autonotify_table_manager();

?>
