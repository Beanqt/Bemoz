(function($){
    var dynamicElements = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    dynamicElements.prototype = {
        init: function(){
            this.elements = this.container.find('.dynamic-elements');
            this.new = this.container.find('.btn-new');
            this.output = $(this.container.data('output'));
            this.templates = this.container.find('.template');
            this.close = isset(this.container.data('close')) ? this.container.data('close') : true;
            this.max = isset(this.container.data('max')) ? this.container.data('max') : null;
            this.editor = 1;
            this.editor_mod = isset(this.container.data('editor')) ? this.container.data('editor') : 'default';
            this.editor_config = {
                default: {
                    toolbar: [
                        { name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
                        { name: 'links', items: ['Link','Unlink']}
                    ],
                    height: 80,
                    removePlugins: 'elementspath',
                    resize_enabled: false,
                    autoParagraph: false,
                    enterMode: CKEDITOR.ENTER_BR,
                    shiftEnterMode: CKEDITOR.ENTER_BR
                },
                content: {
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold','Italic','Underline']},
                        { name: 'justify', items: ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']},
                        { name: 'paragraph', items: ['NumberedList','BulletedList','CreateDiv','Image']},
                        { name: 'links', items: ['Link','Unlink']},
                        { name: 'format', items: ['Format']},
                        { name: 'insert', items: [ 'Table', 'HorizontalRule', 'Iframe', 'btgrid' ]},
                        { name: 'document', items: ['Maximize','Source']}
                    ],
                    removePlugins: 'elementspath'
                }
            };

            this.watch();
        },
        watch: function(){
            var self = this;

            self.loadplugins(self.elements);
            self.initSortable(self.elements);

            self.container.on('click', '.option', function(){
                $(this).parents('.grid-elements').first().find('.option-box .modal').modal('show');
            });

            self.container.on('click', '.main-option', function(){
                $(this).parents('.widgetItem').first().find('>.modal').modal('show');
            });

            self.container.on('click', '.add-grid', function(){
                var template = self.templates.find('>.dynamic-element-grid-option');
                template.html(function(i, old) {
                    return old.replace(/\[KEY\]/g, new Date().getTime());
                });
                $(this).parents('.widgetItem').first().find('.grid-box').append(template.html());

                var last =  $(this).parents('.widgetItem').first().find('.grid-box .grid-elements').last();

                self.loadplugins(last);
                self.initSortable(last);
                self.initResizable(last);
            });

            self.container.on('click', '.close-option-box', function(){
                $(this).parents('.option-box').first().fadeOut(200);
            });

            self.container.on('click', '.delete', function(){
                var element = $(this).parents('.widgetItem, .grid-elements').first();

                app.modal.open('.modal-delete', function(widget){
                    widget.acceptBtn.addClass('default-link');
                }).accept(function(widget){
                    element.remove();
                    widget.close();
                });
            });

            self.container.on('mouseenter', '.show-image', function(){
                $(this).append('<span class="image-box"><img src="'+$(this).attr("data-image")+'"></span>')
            }).on('mouseleave', '.show-image', function(){
                $(this).find('.image-box').remove();
            });

            self.container.on('click','.edit', function(){
                var el = $(this);
                var parent = el.parents('.widgetItem, .grid-elements').first();
                var grid = el.parents('.dynamic-element-grid').first();

                if(grid.length){
                    var time = 0;
                    if(!parent.hasClass('open')){
                        grid.addClass('masked');
                        parent.addClass('active-grid-element').width(grid.innerWidth()-30).css('margin-left', (parent.offsetParent().offset().left-parent.offsetParent().offsetParent().offset().left)*-1);
                        time = 100;
                    }

                    setTimeout(function(){
                        parent.find('.inside').stop(true).slideToggle(200, function(){
                            parent.toggleClass('open');

                            if(!parent.hasClass('open')){
                                grid.removeClass('masked');
                                parent.removeClass('active-grid-element').width('').css('margin-left', '');
                            }
                        });
                    }, time);
                }else{
                    parent.find('.inside').stop(true).slideToggle(200, function(){
                        parent.toggleClass('open');
                    });
                }
            });

            self.container.on('click','.dynamic-element-choose-media', function(){
                var value = $(this).data('type');
                var el = $(this);
                var modal = $('.modal-'+value+'-manager');
                var media = $('.media-'+value+'-manager');

                if(modal.find('.modal-body').find('>.loader').length){
                    el.append('<div class="loader active"></div>');
                    modal.modal('show');

                    $.ajax({
                        url: route('api.media_manager.load', {type: value}),
                        method: 'get',
                        dataType: 'json',
                        success: function(data){
                            modal.find('.modal-body').html(data.content);
                            el.find('>.loader').remove();
                        },
                        complete: function(){
                            media.mediaManager({
                                content: el.parent(),
                                selected: true,
                                modal: '.modal-'+value+'-manager'
                            });
                        }
                    });
                }else{
                    media.data('mediaManager').setContent(el.parent(), true);
                }

                modal.modal('show');
            });

            self.container.on('click', '.dynamic-element-delete-media', function(){
                var el = $(this);
                var parent = el.parent();

                parent.find('.preview-inside').html('');
                parent.removeClass('active');
                parent.find('input[type="text"]').val('');
                parent.find('input, select, textarea').not('[type=checkbox]').not('[type=radio]').val('');
                parent.find('[type=checkbox], [type=radio]').prop('checked', false);
                parent.find('.grid-background-tab').slideUp(0);
            });

            self.container.on('click','.new-option', function(){
                var template = self.templates.find('>.dynamic-element-option');
                var li = template.clone();
                var content = $(this).parents('.widgetInsideBox').find('.options');

                content.append(li);

                var last_item = content.find('> .widgetItem').last();
                self.loadplugins(last_item);
            });

            app.page.beforeSend(function(){
                self.getJson();
            });

            $('.default-form').submit(function(){
                self.getJson();
            });

            self.new.click(function(){
                self.add($(this).data('type'), function(element){
                    app.html.animate({scrollTop: element.offset().top-100},300);
                });
            });

            self.container.on('keyup','.input-title', function(){
                var value = $(this).val();
                var title = $(this).parents('li').first().find('.title');
                if(value.length > 0) {
                    title.text(value);
                }else{
                    title.text(title.attr('data-title'));
                }
            });

            self.container.on('change', '.iconCheckBox-group [type=radio]', function(){
                var el = $(this);
                var parent = el.parents('.iconCheckBox-group');

                parent.find('[data-name=mode]').val(el.val());
                parent.find('[type=radio]').prop('checked', false);
                el.prop('checked', true);
            });
        },
        initSortable: function(elements){
            var self = this;

            elements.sortable({
                items: ".widgetItem",
                handle: ".handle",
                connectWith: ".sortable",
                over: function(event, ui) {
                    ui.helper.css('width', ui.placeholder.width()+20);
                },
                start: function(event, ui){
                    ui.helper.removeClass('open').height(40).find('.inside').slideUp(300);

                    self.elements.find('.widgetItem').addClass('inactive');
                    self.removeCkeditor(ui.item.find('.ck_textarea').attr('id'));
                },
                stop: function(event, ui){
                    self.elements.find('.widgetItem').removeClass('inactive');

                    if(ui.item.hasClass('dynamic-element-grid') && ui.item.parents('.box').first().hasClass('dynamic-element-grid')){
                        $(ui.helper).sortable('cancel');
                        return false;
                    }

                    self.replaceCkeditor(ui.item.find('.ck_textarea').attr('id'));
                    if(!ui.item.parents('.grid-box').length){
                        ui.item.addClass('open').height('').find('.inside').slideDown(300);
                    }
                },
            }).disableSelection();
        },
        initResizable: function(elements){
            elements.resizable({
                handles: 'e',
                resize: function(e, ui) {
                    var el = $(this);
                    var container = el.parent();
                    var cellPercentWidth = 100 * ui.originalElement.outerWidth() / container.outerWidth();
                    var column = Math.round(0.12*cellPercentWidth);
                    column = column < 3 ? 3 : column;

                    el.css('width', '');
                    el.removeClass("col-sm-0 col-sm-1 col-sm-2 col-sm-3 col-sm-4 col-sm-5 col-sm-6 col-sm-7 col-sm-8 col-sm-9 col-sm-10 col-sm-11 col-sm-12").addClass('col-sm-' + column);
                    el.find(".grid-title").text('col-sm-' + column);
                    el.find("[data-name='column']").val(column);
                }
            });
        },
        getJson: function(){
            var self = this;
            var array = [];
            var template = $('#template');

            self.elements.find('>.widgetItem').each(function(){
                var li = $(this);

                if(li.hasClass('dynamic-element-grid')){
                    var grids_array = {'grids': []};
                    grids_array.options = self.getInputJson(li.find('>.option-box .group-options'));
                    grids_array.styles = self.getInputJson(li.find('>.option-box .group-styles'));

                    li.find('.sortable').each(function(){
                        var grid_array = {'items': []};

                        $(this).find('>.widgetItem').each(function(){
                            grid_array.items.push(self.getInputJson($(this)));
                        });

                        grid_array.options = self.getInputJson($(this).find('>.option-box .group-options'));
                        grid_array.styles = self.getInputJson($(this).find('>.option-box .group-styles'));
                        grids_array.grids.push(grid_array);
                    });

                    array.push(grids_array);
                }else {
                    array.push(self.getInputJson(li));
                }
            });

            if(template.length){
                array.push({template: template.val()});
            }

            self.output.val(JSON.stringify(array));
        },
        getInputJson: function(li){
            var options = li.find('.options');
            var sub_array = {};

            li.find('input, select, textarea').not('[type=checkbox]').not('[type=radio]').each(function(){
                var el = $(this);

                if(!el.parents('.options').length){
                    var name = el.data('name');

                    if(!isset(name)){
                        name = el.attr('name');
                    }

                    if(isset(name)){
                        var val = el.val();

                        if(el.hasClass('ck_textarea')){
                            var id = el.attr('id');
                            var editorInstance = CKEDITOR.instances[id];
                            val = editorInstance.getData();
                        }

                        if(val.length){
                            sub_array[name] = val;
                        }
                    }
                }
            });

            li.find('input[type=checkbox]:checked, input[type=radio]:checked').each(function(){
                if(isset($(this).data('name'))){
                    sub_array[$(this).data('name')] = $(this).val() ? $(this).val() : true;
                }
            });

            if(options.length){
                sub_array.options = [];
                options.find('>li').each(function(){
                    var option = {};

                    $(this).find('input, select, textarea').not('[type=checkbox]').not('[type=radio]').each(function(){
                        var name = $(this).data('name');

                        if(!isset(name)){
                            name = $(this).attr('name');
                        }

                        if(isset(name)){
                            if($(this).hasClass('ck_textarea')){
                                var id = $(this).attr('id');
                                var editorInstance = CKEDITOR.instances[id];
                                option[name] = editorInstance.getData();
                            }else{
                                option[name] = $(this).val();
                            }
                        }
                    });

                    $(this).find('input[type=checkbox], input[type=radio]').each(function(){
                        option[$(this).data('name')] = $(this).is(':checked');
                    });

                    sub_array.options.push(option);
                });
            }

            return sub_array;
        },
        removeCkeditor: function(id){
            if (typeof id != 'undefined') {
                var editorInstance = CKEDITOR.instances[id];
                editorInstance.destroy();
                CKEDITOR.remove(id);
            }
        },
        replaceCkeditor: function(id){
            if (typeof id != 'undefined') {
                var editor = CKEDITOR.replace(id, this.editor_config[this.editor_mod]);
                if(this.editor_mod == 'content'){
                    CKFinder.setupCKEditor(editor, {basePath : '/assets/scripts/throne/ckfinder/'});
                }
            }
        },
        loadplugins: function(el){
            var self = this;

            el.find('.slim').slim();
            el.find('.form-dynamic-select').customSelector();
            el.find('.color-picker').colorpicker();
            el.find('.form-dynamic-autocomplete').customAutoComplete();
            el.find('.pickerDate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            el.find(".options").sortable().disableSelection();

            self.initSortable(el.find(".sortable"));
            self.initResizable(el.find('.grid-elements'));

            if(el.find('.checkbox-group').length){
                el.find('.checkbox-group').find('input[type=checkbox]').change(function(){
                    var element = $(this);

                    element.parents('.checkbox-group').find('input[type=hidden]').val(element.val());
                });
            }

            if(el.find('.ck_textarea').length){
                $.each(el.find('.ck_textarea'), function(){
                    $(this).attr('id', 'ckeditor'+self.editor).trigger("change");
                    self.replaceCkeditor('ckeditor'+self.editor);
                    self.editor++;
                });
            }
        }
    };

    dynamicElements.prototype.add = function(type, callback){
        var template = this.templates.find('.dynamic-element-'+type);
        if((template.length && this.max == null) || (this.max != null && this.max >= this.container.find('.widgetItem').length)){
            var li = template.clone();

            if(this.close){
                this.elements.find('.widgetItem').removeClass('open');
            }
            this.elements.append(li);

            var last_item = this.elements.find('> .widgetItem').last();
            if(typeof callback === "function"){
                callback(last_item);
            }
            this.loadplugins(last_item);
        }
    };

    dynamicElements.prototype.destroy = function(){

    };

    $.fn.dynamicElements = function(option) {
        var options = $.extend({}, option);

        return this.each(function() {
            $.data(this, "dynamicElements", new dynamicElements($(this), options));
        });
    };
}(jQuery));