/* MUSLI jQuery plugin */
/* Version: 0.7 */
/* Author: ziemekpr0@gmail.com */
/* Plugin homepage: http://musli.newdivide.pl */
/* Last update: 2014-11-03 */

(function($) {
    $.fn.musli = function(options) {

    var settings = $.extend({
        animationAction: 'hover',
        animationSpeed: 1000,
        musliPosition: 'right',
        animationEasing: 'linear',
        autohide: 'off',
        autohideAfter: 5000,
        autoopenAfter: 5000
    }, options );

    var tab = this.children('li');

    if(tab.hasClass('musli-open'))
    {
        var animationBegin = {};

        if(settings.musliPosition == 'top' || settings.musliPosition == 'bottom'){
            animationBegin[settings.musliPosition] = $('.musli-open').children('div').outerHeight();
        }
        else{
            animationBegin[settings.musliPosition] = $('.musli-open').children('div').outerWidth();
        }

        $('.musli-open').stop(true, true).animate(animationBegin, parseInt(settings.animationSpeed), settings.animationEasing); 

        if(settings.autohide == 'on'){
            setTimeout(function(){
                var animationEnd = {};
                animationEnd[settings.musliPosition] = "0";
                $('.musli-open').stop().animate(animationEnd, parseInt(settings.animationSpeed), settings.animationEasing).removeClass('musli-open');
            }, parseInt(settings.autohideAfter));
        }
    }

    if(tab.hasClass('musli-autoopen'))
    {
        var animationBegin = {};

        if(settings.musliPosition == 'top' || settings.musliPosition == 'bottom'){
            animationBegin[settings.musliPosition] = $('.musli-autoopen').children('div').outerHeight();
        }
        else{
            animationBegin[settings.musliPosition] = $('.musli-autoopen').children('div').outerWidth();
        }

        $('.musli-autoopen').stop().delay(parseInt(settings.autoopenAfter)).animate(animationBegin, parseInt(settings.animationSpeed), settings.animationEasing)
        .addClass('musli-open').removeClass('musli-autoopen');
    }

    if(settings.animationAction == 'click')
    {
         tab.children().click(function(){
            if(! $(this).parent('li').hasClass('musli-open')) {
                var animationBegin = {};

                if(settings.musliPosition == 'top' || settings.musliPosition == 'bottom'){
                    animationBegin[settings.musliPosition] = $(this).siblings('div').outerHeight();
                }
                else{
                    animationBegin[settings.musliPosition] = $(this).siblings('div').outerWidth();
                }

                $(this).parent('li').animate(animationBegin, parseInt(settings.animationSpeed), settings.animationEasing).addClass('musli-open');
            }
            else {
                var animationEnd = {};
                animationEnd[settings.musliPosition] = "0";
                $(this).parent('li').animate(animationEnd, parseInt(settings.animationSpeed), settings.animationEasing).removeClass('musli-open');
            }
        });
    }
    else
    {
        tab.hover(
            function(){
                var animationBegin = {};

                if(settings.musliPosition == 'top' || settings.musliPosition == 'bottom'){
                    animationBegin[settings.musliPosition] = $(this).children('div').outerHeight();
                }
                else{
                    animationBegin[settings.musliPosition] = $(this).children('div').outerWidth();
                }

                $(this).stop().animate(animationBegin, parseInt(settings.animationSpeed), settings.animationEasing);
            },
            function(){
                var animationEnd = {};
                animationEnd[settings.musliPosition] = "0";

                $(this).stop().animate(animationEnd, parseInt(settings.animationSpeed), settings.animationEasing); 
            }
        );
    }
}
}(jQuery));

jQuery(function(){
    jQuery('#musli').musli({ 
        musliPosition:  musli_jq_params.musliPosition,
        animationAction:musli_jq_params.animationAction,
        animationSpeed: musli_jq_params.animationSpeed,
        animationEasing:musli_jq_params.animationEasing,
        autohide:       musli_jq_params.autohide,
        autohideAfter:  musli_jq_params.autohideAfter,
        autoopenAfter:  musli_jq_params.autoopenAfter
    });
});