jQuery(document).on('ready', function (){
    $('#autonotify_validate_token').click(function(){
        $('.autonotify_loading').fadeIn();
        setTimeout (function() {
            $('.autonotify_loading').fadeOut();
        }, 3000);
    });
});