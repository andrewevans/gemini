/**
 * Created by vesper on 5/31/14.
 */

resize_carousel();

$( window ).resize(function() {
    resize_carousel()
});

function resize_carousel()
{
    dog = $( window ).height() - parseInt($('body').css('padding-top')) - 58;
    $('.carousel').css('height', dog);
    $('.carousel .item').css('height',dog);
}