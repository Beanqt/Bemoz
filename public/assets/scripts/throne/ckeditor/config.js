/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.entities_latin = false;
    config.entities = false;
    config.language = 'hu';
    config.extraPlugins = 'btgrid';

    config.toolbar = [
        { name: 'basicstyles', items: ['Bold','Italic','Underline']},
        { name: 'justify', items: ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']},
        { name: 'paragraph', items: ['NumberedList','BulletedList','CreateDiv','Image']},
        { name: 'links', items: ['Link','Unlink']},
        { name: 'format', items: ['Format']},
        { name: 'insert', items: [ 'Table', 'HorizontalRule', 'Iframe', 'btgrid' ]},
        { name: 'document', items: ['Maximize','Source']}
    ];

    config.format_tags = 'p;h2;h3;h4';
};
