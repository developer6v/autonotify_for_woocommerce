jQuery(document).ready(function($){
    // Gerenciamento Layout - Status
    var statusAunotify = $('.autonotify-body').data('status');
    if (statusAunotify == 'Access granted') {
        $('.autonotify_body_active').show();
    } else {
        $('.autonotify_body_inactive').show();
    }
 

    // Validar e Salvar Token
    $('#autonotify_validate_token').click(function() {
        $('.autonotify_loading').fadeIn();
        var token = $('.autonotify_token:visible').first().val();
        $.ajax ({
            url: autonotify_ajax_token.ajax_url,
            method: "POST",
            data: {
                "token" : token,
            }, 
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', autonotify_ajax_token.nonce);
            },
            success : function (response) {
                if (response != 'Token atualizado com sucesso.') {

                    $('.autonotify_token_failed').fadeIn();
                } else {
                    $('.autonotify_token_saved').fadeIn();
                    window.location.reload();
                }
            },
            error: function (response) {
                $('.autonotify_token_failed').fadeIn();
            }
        }).always (function() {
            setTimeout (function () {
                $('.autonotify_loading').fadeOut();
            }, 3000);

            setTimeout (function () {
                $('.autonotify_token_saved').fadeOut();
            }, 5000);

            setTimeout (function () {
                $('.autonotify_token_failed').fadeOut();
            }, 5000);
        });
    });



    // Redefinir Token
    $('.autonotify_edit_token').click(function () {
        $('.autonotify_body_active').hide();
        $('.autonotify_body_inactive').show();
    });
});