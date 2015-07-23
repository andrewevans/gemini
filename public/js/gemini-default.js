/**
 * Created by vesper on 5/31/14.
 */

var GART = {};

$('#myCarousel').carousel({
    interval: 4000
});

// handles the carousel thumbnails
$('[id^=carousel-selector-]').click( function(){
    var id_selector = $(this).attr("id");
    var id = id_selector.substr(id_selector.length -1);
    id = parseInt(id);
    $('#myCarousel').carousel(id);
    $('[id^=carousel-selector-]').removeClass('selected');
    $(this).addClass('selected');
});

// when the carousel slides, auto update
$('#myCarousel').on('slid', function (e) {
    var id = $('.item.active').data('slide-number');
    id = parseInt(id);
    $('[id^=carousel-selector-]').removeClass('selected');
    $('[id^=carousel-selector-'+id+']').addClass('selected');
});


resize_carousel();

$( window ).resize(function() {
    resize_carousel()
});

function resize_carousel()
{
    carousel_height = $( window ).height() - parseInt($('body').css('padding-top')) - 58;
    if (carousel_height > 600) carousel_height = 600;
    $('.carousel').css('height', carousel_height);
    $('.carousel .item').css('height',carousel_height);
    $('.carousel .item > div').css('height',carousel_height);
    $('.carousel .item .item-img img').css('max-height',carousel_height);
    $('#slider-thumbs ul').css('height', carousel_height);
}

/* search typeahead functionality */
var charMap = {'àáâããäå': 'a', 'èéêë': 'e', 'ç': 'c', 'ß': 'ss'};

var normalize = function(str) {
    $.each(charMap, function(chars, normalized) {
        var regex = new RegExp('[' + chars + ']', 'gi');
        str = str.replace(regex, normalized);
    });

    return str;
}

var queryTokenizer = function(q) {
    var normalized = normalize(q);
    return Bloodhound.tokenizers.whitespace(normalized);
};


var artworks_list = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: queryTokenizer,
    prefetch: {
        ttl: 0,
        url: '/api/v1/url/artworks'
    }
});

var artworks_id_list = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('guid'),
    queryTokenizer: queryTokenizer,
    prefetch: {
        ttl: 0,
        url: '/api/v1/url/artworks'
    }
});

var artists_list = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        ttl: 0,
        url: '/api/v1/url/artists'
    }
});

var artists_id_list = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('guid'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        ttl: 0,
        url: '/api/v1/url/artists'
    }
});

artworks_list.initialize();
artworks_id_list.initialize();
artists_list.initialize();
artists_id_list.initialize();

$('#multiple-datasets .typeahead').typeahead({
        highlight: true
    },
    {
        name: 'artworks-list',
        displayKey: 'value',
        source: artworks_list.ttAdapter(),
        templates: {
            header: '<h3 class="table-name">Artworks</h3>',
            empty: [
                '<div class="empty-message">',
                '<p>No artwork found.</p>',
                '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile('<a href="\{\{url\}\}" style="display: block"><table><tr><td style="80px"><img src="\{\{mfa_img_thumb_url\}\}" style="width: 80px; min-width:80px; overflow: hidden;"></td><td style="vertical-align: top"><p style="margin-left:5px; font-family: arial, sans-serif; font-size: 16px; color: #222;"><strong>\{\{value\}\}</strong><br />\{\{medium_short\}\}<br />\$\{\{\price}\}</p></td></tr></table></a>')
        }
    },
    {
        name: 'artists-list',
        displayKey: 'value',
        source: artists_list.ttAdapter(),
        templates: {
            header: '<h3 class="table-name">Artists</h3>',
            empty: [
                '<div class="empty-message">',
                '<p>No artists found.</p>',
                '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile('<p><strong>\{\{value\}\}</strong>  (\{\{year_begin\}\} - \{\{year_end\}\})</p>')
        }

    },
    {
        name: 'artworks-id-list',
        displayKey: 'guid',
        source: artworks_id_list.ttAdapter()
    },
    {
        name: 'artists-id-list',
        displayKey: 'guid',
        source: artworks_id_list.ttAdapter()
    }
);

var artworkItemSelectedHandler = function (eventObject, suggestionObject, suggestionDataset) {
    /* According to the documentation the following should work https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md#jquerytypeaheadval-val.
     However it causes the suggestion to appear which is not wanted */
    //employeeIdTypeahead.typeahead('val', suggestionObject.id);
    $('#q_id').val(suggestionObject.guid);
};

var artistItemSelectedHandler = function (eventObject, suggestionObject, suggestionDataset) {
    /* According to the documentation the following should work https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md#jquerytypeaheadval-val.
     However it causes the suggestion to appear which is not wanted */
    //employeeIdTypeahead.typeahead('val', suggestionObject.id);
    $('#q_id').val(suggestionObject.guid);
};


$('#multiple-datasets .typeahead').on('typeahead:selected', artworkItemSelectedHandler);
$('#multiple-datasets .typeahead').on('typeahead:selected', artistItemSelectedHandler);
/* END search typeahead */

$(function () {
    $("[data-toggle='tooltip']").tooltip();
});


function MM_swapImgRestore() { //v3.0
    var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }

function MM_preloadImages() { //v3.0
    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
    var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
    if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_findObj(n, d) { //v4.01
    var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
    if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

var quotables;
var $quotables = $('.quotables');

// Update quotable DOM elements with random quotable
GART.displayQuotable = function (quotables, self) {
    var quotable = quotables[Math.floor(Math.random() * quotables.length)];
    $(self).find('span.quotablesDescription').html(quotable.description);
    $(self).find('span.quotablesAuthor').html(quotable.author);
    var quotable_date = new Date(quotable.quotable_date).toLocaleDateString();
    $(self).find('span.quotablesDate').html(quotable_date);
}

// Make an ajax request for quotables JSON
$.getJSON( "/api/v1/url/quotables", function(data) {
    quotables = data;

    // Attach click event to each quotable element to show another random quotable
    $quotables.each(function () {
        var self = this;
        $(this).find('a.quotablesNext').on('click', function(e) {
            e.preventDefault();
            GART.displayQuotable(quotables, self);
        }).click(); // Simulate a click to show the first quotables
    });

    // Display quotables elements
    $quotables.css('display', 'inline-block');
});
