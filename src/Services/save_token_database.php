<?php

function save_token_database ($token) {
    try {
        require_once __DIR__ . '/../../../../../wp-load.php';

        global $wpdb;
        $table_name = $wpdb->prefix . 'autonotify_config';
        $sql = $wpdb->prepare("UPDATE $table_name SET token = %s WHERE id = %d", $token, 1);
        $wpdb->query($sql);

        $result = $wpdb->query($sql);
    
        if ($result === false) {
            return 'Deu erro na atualização.';
        } else {
            return 'Token atualizado com sucesso.';
        }
        
    } catch (Exception $e) {
        return 'deu erro: ' . $e->getMessage();
    }
}