<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function save_token_database ($token) {
    try {
        $path = __FILE__ . '/../../../../../wp-admin/includes/upgrade.php';
        return "Tentando incluir: $path\n"; // Adicione isso para depuração
        //require_once $path;
        return 'deu certo'

    } catch (Exception $e) {
        return 'deu erro: ' . $e->getMessage();
    }
}