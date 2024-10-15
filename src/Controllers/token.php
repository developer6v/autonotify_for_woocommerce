<?php

require_once __DIR__ . '/../Services/save_token_database.php';



$token = $_POST['token'] ?? null;

if ($token) {
    echo save_token_database ($token);
}  else {
    echo "token not found";
}

