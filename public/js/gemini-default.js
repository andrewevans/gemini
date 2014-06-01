/**
 * Created by vesper on 5/31/14.
 */

resize_carousel();

$( window ).resize(function() {
    resize_carousel()
});

function resize_carousel()
{
    carousel_height = $( window ).height() - parseInt($('body').css('padding-top')) - 58;
    if (carousel_height > 800) carousel_height = 800;
    $('.carousel').css('height', carousel_height);
    $('.carousel .item').css('height',carousel_height);
}