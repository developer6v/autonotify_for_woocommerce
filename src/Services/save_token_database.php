<?php


function save_token_database ($token) {
    try {
        return "teste";
        /*
        $path = __FILE__ . '/../../../../../wp-admin/includes/upgrade.php';
        return "Tentando incluir: $path\n"; // Adicione isso para depuração
        //require_once $path;
        return 'deu certo'*/

    } catch (Exception $e) {
        return 'deu erro: ' . $e->getMessage();
    }
}