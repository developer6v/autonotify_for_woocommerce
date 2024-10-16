<?php

function save_token_database ($token) {
    return ABSPATH . '/wp-admin/includes/upgrade.php'  . $token;
}