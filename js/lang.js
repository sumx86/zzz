(function($){
    $(document).ready(function(){
        $('.lang').click(function(){
            set_cookie('lang', $(this).find('span').text().toLowerCase(), "/", 365), location = location.href;
        });
    });
})(jQuery);