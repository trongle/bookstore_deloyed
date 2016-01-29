/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language      = 'vi';
	config.skin          = 'office2013';
	config.toolbar_Basic =[
	{ name: 'document', items : [ 'Source','Preview'] },
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
	{ name: 'styles', items : ['Font' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
	{ name: 'tools', items : [ 'Maximize','About' ] }
	];
	config.toolbar       = "Basic";
	config.resize_dir    = 'vertical';//vertical
	config.removePlugins = "iframe";
};
