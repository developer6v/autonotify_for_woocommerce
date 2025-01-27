<?php 

require_once __DIR__ . '/../Services/Database/save_token_database.php';
require_once __DIR__ . '/../Services/Api/validate_token.php';
require_once __DIR__ . '/../../../../../wp-load.php';

$token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : null;

if ($token) {
    $status = validate_token($token);

    if ($status === 'Access granted') {
        $result = save_token_database($token, $status);
        echo esc_html($result);
    } else {
        echo esc_html('Token Inválido! ' . $status);
    }
} else {
    echo esc_html("Erro na requisição (Token Não Encontrado)!");
}
