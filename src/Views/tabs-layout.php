<?php

function autonotify_layout() {
    global $wpdb;
    $table_name = $wpdb->prefix . "sr_autonotify_config";

    $token = $wpdb->get_var($wpdb->prepare("SELECT token FROM %i WHERE id = %d", [$table_name, 1]));
    $status = $wpdb->get_var($wpdb->prepare("SELECT status FROM %i WHERE id = %d", [$table_name, 1]));

    echo "<div class='autonotify-header'>
        <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/autonotify.svg') . "' alt='' class=''/>
    </div>
    <div class='autonotify-body' data-status='" . esc_attr($status) . "'>

        <div class='div_autonotify_title'>
            <span class='autonotify_title'>Configurações</span>
            <span class='autonotify_subtitle' title='Configure o seu AutoNotify.'>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/circle-info-solid.svg') . "' alt='Informação' class='autonotify-icon'/>
            </span>    
        </div>

        <div class='autonotify_body_active'>
            <span class='autonotify_token_label'>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/key-solid.svg') . "' alt='Chave' class='autonotify-icon'/> Token
            </span>
            <div class='autonotify_input_div'>
                <input readonly value='" . esc_attr($token) . "' class='autonotify_token' placeholder='Informe seu token de integração Autonotify.' type='text'/>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/circle-check-solid.svg') . "' alt='Verificado' class='tokencheckedicon'/>
            </div>
            <button class='autonotify_edit_token'>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/pen-to-square-solid.svg') . "' alt='Editar' class='autonotify-icon'/> Redefinir Token
            </button>        
        </div>

        <div class='autonotify_body_inactive'>
            <span class='autonotify_token_label'>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/key-solid.svg') . "' alt='Chave' class='autonotify-icon'/> Token
            </span>
            <div class='autonotify_input_div'>
                <input value='" . esc_attr($token) . "' class='autonotify_token' placeholder='Informe seu token de integração Autonotify.' type='text'/>
            </div>    
            <button id='autonotify_validate_token' class='autonotify_validate_token'>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/plug-circle-check-solid.svg') . "' alt='Validar' class='autonotify-icon'/> Validar Token
            </button>    
            <img class='autonotify_loading' src='" . esc_url(plugins_url('/public/gif/loading.gif', __FILE__)) . "' alt='' class=''/>

        </div>

    </div>

    <div class='autonotify_warning_div'>
        <div class='autonotify_token_saved'>
            <span>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/circle-check-solid.svg') . "' alt='Sucesso' class='autonotify-icon'/> Token Validado!
            </span>
        </div>
        
        <div class='autonotify_token_failed'>
            <span>
                <img src='" . esc_url(AUTONOTIFY_PLUGIN_URL . '/public/img/circle-exclamation.svg') . "' alt='Erro' class='autonotify-icon'/> Token Inválido!
            </span>
        </div>
    </div>";
}

?>
