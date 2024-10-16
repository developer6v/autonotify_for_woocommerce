<?php

function save_token_database ($token) {
    return dirname(__FILE__) . '/wp-admin/includes/upgrade.php'  . $token;
}