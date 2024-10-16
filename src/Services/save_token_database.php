<?php

function save_token_database ($token) {
    try {
        require_once __FILE__ . '/../../../../../wp-admin/includes/upgrade.php';
        return 'deu certo';

    } catch (Exception $e) {
        return 'deu erro';

    }

}