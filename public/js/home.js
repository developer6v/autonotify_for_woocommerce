jQuery(document).ready(function($){

    // Validar e Salvar Token
    $('#autonotify_validate_token').click(function() {
        $('.autonotify_loading').fadeIn();
        var token = $('#autonotify_token').val();
        $.ajax ({
            url: "../wp-content/plugins/autonotify-for-woocommerce/src/Controllers/token.php",
            method: "POST",
            data: {
                "token" : token,
            },
            success : function (response) {
                if (response != 'Token atualizado com sucesso.') {
                    $('.autonotify_token_failed').fadeIn();
                } else {
                    $('.autonotify_token_saved').fadeIn();
                    window.location.reload();
                }
                console.log (response);
            },
            error: function (response) {
                $('.autonotify_token_failed').fadeIn();
                console.log (response);
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