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
                console.log (response);
            },
            error: function (response) {
                console.log (response);
            }
        }).always (function() {
            setTimeout (function () {
                $('.autonotify_loading').fadeOut();
            }, 3000);
        });
    });
});