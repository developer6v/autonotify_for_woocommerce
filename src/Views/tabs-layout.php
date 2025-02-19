<?php

function autonotify_layout() {
    global $wpdb;
    $table_name = $wpdb->prefix . "sr_autonotify_config";

    $token = $wpdb->get_var($wpdb->prepare("SELECT token FROM %i WHERE id = %d", [$table_name, 1]));
    $status = $wpdb->get_var($wpdb->prepare("SELECT status FROM %i WHERE id = %d", [$table_name, 1]));

    echo "<div class='autonotify-header'>
        <img src='" . esc_url(plugins_url('/public/img/autonotify.svg', __FILE__)) . "' alt='' class=''/>
    </div>
    <div class='autonotify-body' data-status='" . esc_attr($status) . "'>

        <div class='div_autonotify_title'>
            <span class='autonotify_title'>Configurações</span>
            <span class='autonotify_subtitle' title='Configure o seu AutoNotify.'>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='autonotify-icon'>
                    <path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z'/>
                </svg>
            </span>    
        </div>

        <div class='autonotify_body_active'>
            <span class='autonotify_token_label'>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='autonotify-icon'>
                    <path d='M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z'/>
                </svg>
                Token
            </span>
            <div class='autonotify_input_div'>
                <input readonly value='" . esc_attr($token) . "' class='autonotify_token' placeholder='Informe seu token de integração Autonotify.' type='text'/>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='tokencheckedicon'>
                    <path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z'/>
                </svg>
            </div>
            <button class='autonotify_edit_token'>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='autonotify-icon'>
                    <path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z'/>
                </svg>
                Redefinir Token
            </button>        
        </div>

        <div class='autonotify_body_inactive'>
            <span class='autonotify_token_label'>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='autonotify-icon'>
                    <path d='M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z'/>
                </svg>
                Token
            </span>
            <div class='autonotify_input_div'>
                <input value='" . esc_attr($token) . "' class='autonotify_token' placeholder='Informe seu token de integração Autonotify.' type='text'/>
            </div>    
            <button id='autonotify_validate_token' class='autonotify_validate_token'>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512' class='autonotify-icon autonotifyboxicon'>
                    <path d='M96 0C78.3 0 64 14.3 64 32l0 96 64 0 0-96c0-17.7-14.3-32-32-32zM288 0c-17.7 0-32 14.3-32 32l0 96 64 0 0-96c0-17.7-14.3-32-32-32zM32 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l0 32c0 77.4 55 142 128 156.8l0 67.2c0 17.7 14.3 32 32 32s32-14.3 32-32l0-67.2c12.3-2.5 24.1-6.4 35.1-11.5c-2.1-10.8-3.1-21.9-3.1-33.3c0-80.3 53.8-148 127.3-169.2c.5-2.2 .7-4.5 .7-6.8c0-17.7-14.3-32-32-32L32 160zM576 368a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6l72-72c6.2-6.2 16.4-6.2 22.6 0l40 40z'/>
                </svg>
                Validar Token
            </button>    
            <img class='autonotify_loading' src='" . esc_url(plugins_url('/public/gif/loading.gif', __FILE__)) . "' alt='' class=''/>
        </div>

    </div>

    <div class='autonotify_warning_div'>
        <div class='autonotify_token_saved'>
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='autonotify-icon autonotifyboxicon'>
                <path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z'/>
            </svg>
            Token Validado!
        </div>
        <div class='autonotify_token_failed'>
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='autonotify-icon autonotifyboxicon'>
                <path d='M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM192 176c0-13.3 10.7-24 24-24h80c13.3 0 24 10.7 24 24v160c0 13.3-10.7 24-24 24h-80c-13.3 0-24-10.7-24-24V176zM256 48c-22.1 0-40 17.9-40 40 0 22.1 17.9 40 40 40 22.1 0 40-17.9 40-40C296 65.9 278.1 48 256 48z'/>
            </svg>
            Token Inválido!
        </div>
    </div>";
}

?>
