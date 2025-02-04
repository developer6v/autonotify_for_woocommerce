<?php 



function autonotify_endpoint_token (WP_REST_Request $request) {
    $token = $request->get_param('token');

    if ($token) {
        $status = autonotify_validate_token($token);

        if ($status === 'Access granted') {
            $result = autonotify_save_token_database($token, $status);
            return new WP_REST_Response($result, 200);
        } else {
            return new WP_REST_Response('Token Inválido! ' . $status, 403);
        }
    } else {
        return new WP_REST_Response("Erro na requisição (Token Não Encontrado)!", 400);
    }
}
