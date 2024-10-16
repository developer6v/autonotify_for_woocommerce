<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function save_token_database ($token) {
    try {
        require_once __DIR__ . '/../../../../../wp-load.php';
        require_once __DIR__ . '/../../../../../wp-admin/includes/upgrade.php';
        return 'deu certo';

    } catch (Exception $e) {
        return 'deu erro: ' . $e->getMessage();
    }
}