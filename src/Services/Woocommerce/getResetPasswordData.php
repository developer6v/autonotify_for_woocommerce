<?php

function getResetPasswordData($user) {
    
    $phone = get_user_meta( $user->ID, 'billing_phone', true );

    if ( $phone ) {
        $key = get_password_reset_key( $user );
        $reset_url = network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' );

        $mensagem = "Olá, " . $user->first_name . "! Recebemos sua solicitação para redefinir a senha da sua conta. Para continuar, clique no link abaixo:\n\n";
        $mensagem .= $reset_url . "\n\n";
        $mensagem .= "Se você não fez essa solicitação, entre em contato conosco imediatamente.";

        // Montar payload para a API do WhatsApp
        $payload = array(
            'to'      => $telefone,
            'message' => $mensagem,
        );

        // Fazer chamada à API do WhatsApp
        $url = 'https://sua-api-whatsapp.com/enviar-mensagem'; // Substitua pela URL da sua API

        $response = wp_remote_post( $url, array(
            'body'    => json_encode( $payload ),
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer SEU_TOKEN_DE_AUTENTICACAO' // Ajuste conforme sua API
            ),
            'method'  => 'POST'
        ));

        // Opcional: Log para verificar se a mensagem foi enviada
        if ( is_wp_error( $response ) ) {
            error_log( 'Erro ao enviar mensagem para WhatsApp: ' . $response->get_error_message() );
        } else {
            error_log( 'Mensagem enviada para WhatsApp com sucesso para: ' . $telefone );
        }
    } else {
        error_log( 'Telefone não encontrado para o usuário: ' . $user->user_email );
    }

}

?>
