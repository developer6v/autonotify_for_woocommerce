<?php

function autonotify_layout () {
    echo "<div class='autonotify-header'>
        <img src='../wp-content/plugins/autonotify-for-woocommerce/public/img/autonotify.svg' alt='' class=''/>
    </div>
    
    <div class='autonotify-body'>
        <div class='div_autonotify_title'>
            <span class='autonotify_title'><i class='fa-solid fa-wrench'></i> Configurações</span>
            <span class='autonotify_subtitle'><i class='fa-solid fa-circle-info'></i></span>    
        </div>
        <input id = 'autonotify_token' placeholder='Informe seu token de integração Autonotify.' type = 'text'/>
        <button class='autonotify_validate_token'><i class='fa-solid fa-check-to-slot'></i> Validar Token</button>    
    </div>
    ";
}


?>