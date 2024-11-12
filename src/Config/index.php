<?php

// FrontEnd
require_once dirname(__FILE__) . '/../Views/index.php';
require_once 'Theme/assets.php';
require_once 'Theme/menu.php'; 

//Backend
require_once 'Database/autonotify_table_manager.php';
require_once dirname(__FILE__) . '/../Core/hooks.php';
require_once dirname(__FILE__) . '/../Services/index.php';


function autonotify_table_manager() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'autonotify_config';
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL auto_increment,
            token varchar(60) NULL,
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

register_activation_hook(__FILE__, 'autonotify_table_manager');

?>