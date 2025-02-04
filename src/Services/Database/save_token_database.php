<?php

function autonotify_save_token_database($token, $status) {
    try {
        require_once __DIR__ . '/../../../../../../wp-load.php';

        global $wpdb;
        $table_name = $wpdb->prefix . 'sr_autonotify_config'; 

        $result = $wpdb->query($wpdb->prepare("UPDATE %i SET token = %s, status = %s WHERE id = %d", [$table_name, $token, $status, 1]));

        if ($result === false) {
            return 'Deu erro na atualização.';
        } else {
            return 'Token atualizado com sucesso.';
        }
        
    } catch (Exception $e) {
        return 'Deu erro: ' . $e->getMessage();
    }
}
