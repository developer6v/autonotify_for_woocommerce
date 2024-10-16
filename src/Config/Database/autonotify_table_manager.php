<?php


function autonotify_table_manager () {
    global $wpdb;
    $table_name = $wpdb->prefix . 'autonotify_config';
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id int(11) NOT NULL auto_increment,
            token varchar(60) NOT NULL,
            status varchar(60) NOT NULL,
            PRIMARY KEY id (id) 
        ) $charset_collate";


		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
    }
}

?>