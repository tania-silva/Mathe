/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.toolbar = 'Pinzani';
	 
	config.toolbar_Pinzani =
	[
		{ name: 'document', items : [ 'Source','-','Undo','Redo', 'Paste', 'PasteText', 'PasteFromWord','RemoveFormat'] },
		{ name: 'editing', items : [ 'Bold', 'Italic', ,'-','NumberedList','BulletedList','-','Link', 'Unlink' ] },
	];
};