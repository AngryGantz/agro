/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{

	// Define changes to default configuration here. For example:
	config.language = 'ru';
    config.image_previewText='';
    config.enterMode = CKEDITOR.ENTER_BR;
    config.scayt_autoStartup = false;
    config.toolbar = typeof(EDITOR_TB)!='undefined'?EDITOR_TB:'Default';
    config.toolbar_Default =
    [
    ['Source','Preview','Maximize','-'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-'],
    ['Undo','Redo','-','Find','Replace','RemoveFormat'],['Link','Unlink','Anchor'],
    ['Image','Flash','Table','HorizontalRule', '-'],['SpecialChar','Subscript','Superscript'],
    '/',
    ['Bold','Italic','Underline','Strike','-'],
    ['FontSize','Format'],['TextColor','BGColor'],
    ['BulletedList','-','Outdent','Indent'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']
    ];
	config.Normal=[
    ['PasteWord','PasteText','-','Bold','TextColor','FontSize','Link','Unlink','Image','Smiley','Table','SpecialChar','JustifyLeft','JustifyCenter','JustifyRight','FitWindow']
    ];
	config.toolbar_Basic=[
    ['Bold','TextColor','-','Link','Unlink','-','Image','JustifyLeft','JustifyCenter','JustifyRight']
    ];
    config.fontSize_sizes = '10/10px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;28/28px;32/32px;48/48px;';
	config.format_tags = 'p;h1;h2;h3;h4;h5;h6;div'
	config.removeButtons = 'Italic,Subscript,Superscript,Iframe,SpecialChar,Pagebreake,Preview';
	
};
