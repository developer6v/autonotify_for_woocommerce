<?php

require_once __DIR__ . '/../Services/save_token_database.php';
require_once __DIR__ . '/../Services/validate_token.php';



$token = $_POST['token'] ?? null;

if ($token) {
    $status = validate_token ($token);
    if ($status == 'active') {
        echo save_token_database ($token, $status);
    } else {
        'Token Inválido!';
    }
}  else {
    echo "Erro na requisição (Token Não Encontrado)!";
}

