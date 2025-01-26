CKEDITOR.dialog.add( 'btgrid', function( editor ) {
  var lang = editor.lang.btgrid;
  var commonLang = editor.lang.common;

  // Whole-positive-integer validator.
  function validatorNum(msg) {
    return function() {
      var value = this.getValue(),
        pass = !!(CKEDITOR.dialog.validate.integer()(value) && value > 0);

      if (!pass) {
        alert(msg); // jshint ignore:line
      }

      return pass;
    };
  }
  return {
    title: lang.editBtGrid,
    minWidth: 270,
    minHeight: 300,
    onShow: function() {
      // Detect if there's a selected table.
      var selection = editor.getSelection(),
        ranges = selection.getRanges();
      var command = this.getName();

      var rowsInput = this.getContentElement('info', 'rowCount'),
        colsInput = this.getContentElement('info', 'colCount');
      if (command == 'btgrid') {
        var grid = selection.getSelectedElement();
        // Enable or disable row and cols.
        if (grid) {
          this.setupContent(grid);
          rowsInput && rowsInput.disable();
          colsInput && colsInput.disable();
        }
      }
    },
    contents: [
      {
        id: 'info',
        label: lang.infoTab,
        accessKey: 'I',
        elements: [
          {
            type: 'radio',
            id: 'customRadio_row1',
            label: lang.selNumCols,
            items: [
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:50%;line-height:40px;display:inline-block;text-align: center">6</span><span style="width:50%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">6</span></span>', 2],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:33.333333%;line-height:40px;display:inline-block;text-align: center">4</span><span style="width:33.333333%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">4</span><span style="width:33.333333%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">4</span></span>', 3],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:25%;line-height:40px;display:inline-block;text-align: center">3</span><span style="width:25%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">3</span><span style="width:25%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">3</span><span style="width:25%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">3</span></span>', 4],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:25%;line-height:40px;display:inline-block;text-align: center">3</span><span style="width:50%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">6</span><span style="width:25%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">3</span></span>', 5],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:75%;line-height:40px;display:inline-block;text-align: center">9</span><span style="width:25%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">3</span></span>', 6],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:25%;line-height:40px;display:inline-block;text-align: center">3</span><span style="width:75%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">9</span></span>', 7],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:66.666666%;line-height:40px;display:inline-block;text-align: center">8</span><span style="width:33.333333%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">4</span></span>', 8],
              [ '<span style="border: 2px solid #ddd;width:70px;font-size:0;display: block;margin: auto"><span style="width:33.333333%;line-height:40px;display:inline-block;text-align: center">4</span><span style="width:66.666666%;line-height:40px;display:inline-block;text-align: center;border-left: 1px solid #ddd;">8</span></span>', 9],
            ],
            inputStyle: 'position:absolute; opacity: 0',
            labelStyle: 'display: block;text-align:center;margin-bottom: 10px;',
            default: 2,
            setup: function(widget){
              var parent = this.domId;
              $('#'+parent).addClass('customBox');
            },
            commit: function( widget ) {
              widget.setData( 'colCount', this.getValue());
            }
          },
          {
            id: 'rowCount',
            type: 'text',
            required: true,
            label: lang.genNrRows,
            default: '1',
            inputStyle: 'width: 50px;display: block;margin:auto;',
            labelStyle: 'display: block;text-align:center;margin-bottom: 4px;',
            validate: validatorNum(lang.numRowsError),
            commit: function( widget ) {
              widget.setData( 'rowCount', this.getValue());
            }
          }
        ]
      }
    ],
  };
});
