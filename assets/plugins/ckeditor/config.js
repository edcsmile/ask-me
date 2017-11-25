/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 * edited by edcsmile | Coder Bing 2017
 */
 
CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'MyToolbar';
 
	config.toolbar_MyToolbar =
	[
		{ name: 'document', items : [ 'NewPage','Preview' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','PasteText','-','Undo','Redo' ] },
		{ name: 'links', items : [ 'Link','Unlink'] },
		{ name: 'insert', items : [ 'Image','CodeSnippet' ] },
		{ name: 'basicstyles', items : [ 'Bold','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList' ] }
	];
};