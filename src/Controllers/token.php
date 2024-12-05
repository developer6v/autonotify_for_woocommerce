<?php 

require_once __DIR__ . '/../Services/Database/save_token_database.php';
require_once __DIR__ . '/../Services/Api/validate_token.php';

$token = $_POST['token'] ?? null;

if ($token) {
    $status = validate_token ($token);
    if ($status == 'Access granted') {
        echo save_token_database ($token, $status);
    } else {
        echo 'Token Inválido!' . $status;
    }
}  else {
    echo "Erro na requisição (Token Não Encontrado)!";
}
