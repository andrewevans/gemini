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
    if (carousel_height > 650) carousel_height = 650;
    $('.carousel').css('height', carousel_height);
    $('.carousel .item').css('height',carousel_height);
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
