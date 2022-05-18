require(['jquery', 'domReady!'], function($){
    $(document).on('click','body .action.primary.continue', function(){
        if($('.mage-error:visible:first').offset() !== undefined) {
            $('html, body').animate({
                scrollTop: $('.mage-error:visible:first').offset().top - 35
            }, 500);
        }
        if($('.field-error:visible:first').offset() !== undefined) {
            $('html, body').animate({
                scrollTop: $('.field-error:visible:first').offset().top - 100
            }, 500);
        }
    });
});