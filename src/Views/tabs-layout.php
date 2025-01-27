<?php

function autonotify_layout() {
    global $wpdb;
    $table_name = $wpdb->prefix . "autonotify_config";
    
    $token = $wpdb->get_var($wpdb->prepare("SELECT token FROM %i WHERE id = %d", $table_name, 1));

    $sqlStatus = $wpdb->prepare("SELECT status FROM %i WHERE id = %d", $table_name, 1);
    $status = $wpdb->get_var($sqlStatus);

    echo "<div class='autonotify-header'>
        <img src='" . esc_url(plugins_url('/public/img/autonotify.svg', __FILE__)) . "' alt='' class=''/>
    </div>

    <div class='autonotify-body' data-status='" . esc_attr($status) . "'>

        <div class='div_autonotify_title'>
            <span class='autonotify_title'>Configurações</span>
            <span class='autonotify_subtitle' title='Configure o seu AutoNotify.'><i class='fa-solid fa-circle-info'></i></span>    
        </div>

        <div class='autonotify_body_active'>
            <span class='autonotify_token_label'><i class='fa-solid fa-key'></i> Token</span>
            <div class='autonotify_input_div'>
                <input readonly value='" . esc_attr($token) . "' class='autonotify_token' placeholder='Informe seu token de integração Autonotify.' type='text'/>
                <i class='fa-solid fa-circle-check tokencheckedicon'></i>
            </div>
            <button class='autonotify_edit_token'><i class='fa-solid fa-pen-to-square'></i> Redefinir Token</button>        
        </div>

        <div class='autonotify_body_inactive'>
            <span class='autonotify_token_label'><i class='fa-solid fa-key'></i> Token</span>
            <div class='autonotify_input_div'>
                <input value='" . esc_attr($token) . "' class='autonotify_token' placeholder='Informe seu token de integração Autonotify.' type='text'/>
            </div>    
            <button id='autonotify_validate_token' class='autonotify_validate_token'><i class='fa-solid fa-check-to-slot'></i> Validar Token</button>    
            <img class='autonotify_loading' src='" . esc_url(plugins_url('/public/gif/loading.gif', __FILE__)) . "' alt='' class=''/>
        </div>

    </div>

    <div class='autonotify_warning_div'>
        <div class='autonotify_token_saved'>
            <span><i class='fa-solid fa-check'></i> Token Validado!</span>
        </div>
        <div class='autonotify_token_failed'>
            <span><i class='fa-solid fa-circle-exclamation'></i> Token Inválido!</span>
        </div>
    </div>";
}

?>
