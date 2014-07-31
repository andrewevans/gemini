/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
        { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'links' },
        { name: 'insert' },
        { name: 'forms' },
        { name: 'tools' },
        { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others' },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'styles' },
        { name: 'colors' },
        { name: 'about' }
    ];

    // Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

    /*
//    config.toolbar = 'DetailedDescriptions';
    config.toolbar_DetailedDescriptions = [
        [ 'Source', '-', 'Bold', 'Italic' ]
    ];
    */

    config.toolbar = 'OneLiner';
    config.toolbar_OneLiner = [
        [ 'Source', '-', 'Bold', 'Italic' ]
    ];

    config.enterMode = CKEDITOR.ENTER_BR;

    config.language = 'en';

    //config.forcePasteAsPlainText = true;

    config.removeFormatTags = 'b,big,code,del,dfn,em,font,i,ins,kbd,br';

    config1.enterMode = CKEDITOR.ENTER_P;
    config1.allowedContent = 'p i b blockquote u del em a ul ol li sup sub br caption cite figure figcaption embed img noscript object strong';

    config.allowedContent = 'sup sub';

    config.width = "50%";
    config.height = "7em";
    config.font_style =
    {
        element		: 'span',
        styles		: { 'font-family' : 'serif' },
        overrides	: [ { element : 'font', attributes : { 'face' : null } } ]
    };

    config.fontSize_defaultLabel = '20px';
};


