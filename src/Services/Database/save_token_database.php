<?php

function save_token_database ($token, $status) {
    try {
        require_once __DIR__ . '/../../../../../../wp-load.php';

        global $wpdb;
        $table_name = $wpdb->prefix . 'autonotify_config';
        $sql = $wpdb->prepare("UPDATE $table_name SET token = %s, status = %s WHERE id = %d", $token, $status, 1);
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