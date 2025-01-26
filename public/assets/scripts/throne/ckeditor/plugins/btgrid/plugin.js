(function(){
    CKEDITOR.plugins.add('btgrid', {
            lang: 'en,ru,fr,nl',
            requires: 'widget,dialog',
            icons: 'btgrid',
            init: function(editor) {
                var maxGridColumns = 12;
                var lang = editor.lang.btgrid;

                CKEDITOR.dialog.add('btgrid',  this.path + 'dialogs/btgrid.js');

                editor.addContentsCss( this.path + 'styles/editor.css');
                editor.ui.addButton('btgrid', {
                    label: lang.createBtGrid,
                    command: 'btgrid',
                    icon: this.path + 'icons/btgrid.png'
                });
                editor.widgets.add('btgrid',
                    {
                        allowedContent: 'div(!btgrid);div(!row,!row-*);div(!col-*-*);div(!content)',
                        parts: {
                            btgrid: 'div.row',
                        },
                        editables: {
                            content: '',
                        },
                        template:
                        '<div class="row inline-row">' +
                        '</div>',
                        //button: lang.createBtGrid,
                        dialog: 'btgrid',
                        defaults: {
                            //colCount: 2,
                            //rowCount: 1
                        },
                        upcast: function(element) {
                            return element.name == 'div' && element.hasClass('row');
                        },
                        init: function() {
                            var rowNumber= 1;
                            var rowCount = this.element.getChildCount();
                            for (rowNumber; rowNumber <= rowCount;rowNumber++) {
                                this.createEditable(maxGridColumns, rowNumber);
                            }
                        },
                        data: function() {
                            if (this.data.colCount && this.element.getChildCount() < 1) {
                                var colCount = this.data.colCount;
                                var rowCount = this.data.rowCount;

                                var row = this.parts['btgrid'];
                                for (var i= 1;i <= rowCount;i++) {
                                    this.createGrid(colCount, row, i);
                                }
                            }
                        },
                        createGrid: function(colCount, row, rowNumber) {
                            var content = '';

                            switch(colCount){
                                case '2':
                                    content = '<div class="inline-col col-sm-6 col-md-6">Col 6 content</div>' +
                                              '<div class="inline-col col-sm-6 col-md-6">Col 6 content</div>';
                                    break;
                                case '3':
                                    content = '<div class="inline-col col-sm-4 col-md-4">Col 4 content</div>' +
                                        '<div class="inline-col col-sm-4 col-md-4">Col 4 content</div>' +
                                        '<div class="inline-col col-sm-4 col-md-4">Col 4 content</div>';
                                    break;
                                case '4':
                                    content = '<div class="inline-col col-sm-6 col-md-3">Col 3 content</div>' +
                                        '<div class="inline-col col-sm-6 col-md-3">Col 3 content</div>' +
                                        '<div class="inline-col col-sm-6 col-md-3">Col 3 content</div>' +
                                        '<div class="inline-col col-sm-6 col-md-3">Col 3 content</div>';
                                    break;
                                case '5':
                                    content = '<div class="inline-col col-md-3">Col 3 content</div>' +
                                        '<div class="inline-col col-md-6">Col 6 content</div>' +
                                        '<div class="inline-col col-md-3">Col 3 content</div>';
                                    break;
                                case '6':
                                    content = '<div class="inline-col col-sm-9 col-md-9">Col 9 content</div>' +
                                        '<div class="inline-col col-sm-3 col-md-3">Col 3 content</div>';
                                    break;
                                case '7':
                                    content = '<div class="inline-col col-sm-3 col-md-3">Col 3 content</div>' +
                                        '<div class="inline-col col-sm-9 col-md-9">Col 9 content</div>';
                                    break;
                                case '8':
                                    content = '<div class="inline-col col-sm-8 col-md-8">Col 8 content</div>' +
                                        '<div class="inline-col col-sm-4 col-md-4">Col 4 content</div>';
                                    break;
                                case '9':
                                    content = '<div class="inline-col col-sm-4 col-md-4">Col 4 content</div>' +
                                        '<div class="inline-col col-sm-8 col-md-8">Col 8 content</div>';
                                    break;
                            }

                            row.appendHtml(content);
                            this.createEditable();
                        },
                        createEditable: function() {
                            var row = $(this.element.$);
                            var cols = row.find('.inline-col');

                            for (var i = 1; i <= cols.length; i++) {
                                this.initEditable( 'content' + i, {
                                    selector: '> .row > .inline-col:nth-child('+ i +')'
                                } );
                            }
                        }
                    }
                );
            }
        }
    );
})();
