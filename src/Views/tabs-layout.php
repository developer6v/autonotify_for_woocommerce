<?php

function autonotify_layout () {

    global $wpdb;
    $table_name = $wpdb->prefix . "autonotify_config";
    $sqlToken = $wpdb->prepare("SELECT token FROM $table_name WHERE id = %d", 1);
    $token = $wpdb->get_var($sqlToken);
    $sqlStatus = $wpdb->prepare("SELECT status FROM $table_name WHERE id = %d", 1);
    $status = $wpdb->get_var($sqlStatus);

    if ($status == 'active') {

    } else {

    }

    echo "<div class='autonotify-header'>
        <img src='../wp-content/plugins/autonotify-for-woocommerce/public/img/autonotify.svg' alt='' class=''/>
    </div>
    
    <div class='autonotify-body'>
        <div class='div_autonotify_title'>
            <span class='autonotify_title'>Configurações</span>
            <span class='autonotify_subtitle' title='Configure o seu AutoNotify.'><i class='fa-solid fa-circle-info'></i></span>    
        </div>

        <div class='autonotify_body_active'>
            <span class='autonotify_token_label'><i class='fa-solid fa-key'></i> Token</span>
            <div class='autonotify_input_div'>
                <input readonly value = '" . $token  ."' id = 'autonotify_token' placeholder='Informe seu token de integração Autonotify.' type = 'text'/>
                <i class='fa-solid fa-circle-check tokencheckedicon'></i>
            </div>
            <button class='autonotify_edit_token'><i class='fa-solid fa-pen-to-square'></i> Redefinir Token</button>        
        </div>

        <div class='autonotify_body_inactive'>
            <span class='autonotify_token_label'><i class='fa-solid fa-key'></i> Token</span>
            <div class='autonotify_input_div'>
                <input value = '" . $token  ."' id = 'autonotify_token' placeholder='Informe seu token de integração Autonotify.' type = 'text'/>
            </div>    
            <button id='autonotify_validate_token' class='autonotify_validate_token'><i class='fa-solid fa-check-to-slot'></i> Validar Token</button>    
            <img class='autonotify_loading' src='../wp-content/plugins/autonotify-for-woocommerce/public/gif/loading.gif' alt='' class=''/>
        </div>
    </div>

    <div class='autonotify_warning_div'>
        <div class='autonotify_token_saved'>
            <span><i class='fa-solid fa-check'></i> Token Validado!</span>
        </div>

        <div class='autonotify_token_failed'>
            <span><i class='fa-solid fa-circle-exclamation'></i> Token Inválido!</span>
        </div>
    </div>
    ";
} 

?>