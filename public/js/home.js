jQuery(document).ready(function($){
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
                $('.autonotify_token_saved').fadeIn();
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
                $('.autonotify_warning_div').fadeOut();
            }, 3000);
        });
    });
});