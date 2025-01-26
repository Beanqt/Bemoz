(function($){
    var mediaManager = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    mediaManager.prototype = {
        init: function(){
            this.current_ajax = '';
            this.selected = {document: [], folder: []};
            this.content = this.container.find('.media-content');
            this.breadcrumb = this.container.find('.media-breadcrumbs');
            this.view = this.container.find('.manager-view');
            this.searchBox = this.container.find('.manager-search');
            this.searchInput = this.container.find('.manager-search-input');
            this.modal = $('.modal-manager');
            this.dropzone = this.container.find('.dropzone');
            this.pasteBtn = this.container.find('.manager-paste');

            if(this.options.modal){
                this.modal.addClass('modal-bg');
            }

            this.watch();
        },
        watch: function(){
            var self = this;

            self.dropzone.dropzone({
                url: route('api.media_manager.fileupload', {type: self.container.attr('data-type')}),
                method: 'post',
                paramName: "file",
                maxFilesize: self.dropzone.attr('data-maxsize'),
                addRemoveLinks: false,
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 10000,
                timeout: 30000000,
                dictDefaultMessage: self.dropzone.attr('data-msg'),
                dictResponseError: 'Server not Configured',

                init : function() {
                    var myDropzone = this;

                    myDropzone.on("addedfile", function(file) {
                        file.boss = self.container.attr('data-boss');
                    });
                    myDropzone.on("sending", function(file, xhr, formData){
                        if(isset(file.fullPath)){
                            formData.append('folder', file.fullPath);
                        }
                        formData.append('boss', file.boss);
                    });
                    myDropzone.on("success", function(file, response) {
                        myDropzone.removeFile(file);
                        if(file.boss == self.container.attr('data-boss')){
                            self.content.append(response);
                            self.content.find('.manager-empty').remove();
                        }
                    });
                }
            });

            self.container.on('click', '.manager-folder', function(e){
                e.preventDefault();

                self.content.addClass('active');
                self.createView({boss: $(this).attr('data-folder')}, $(this).attr('href'));

                self.current_ajax = self.ajax(route('api.media_manager.get', {type: self.container.attr('data-type')}), {folder: $(this).attr('data-folder')});
                self.current_ajax.done(function(data){
                    self.container.attr('data-boss', data.boss);
                    self.content.html(data.content);
                    self.renderBreadcrumb(data.breadcrumbs);
                    self.content.removeClass('active');
                    self.searchInput.val('');

                    $.each(self.selected.document, function(key, item){
                        self.content.find('.manager-file-'+item).addClass('selected');
                    });
                    $.each(self.selected.folder, function(key, item){
                        self.content.find('.manager-folder-'+item).addClass('selected');
                    });
                }).fail(function(data){
                    app.notify.add('error', data.responseText);
                    self.content.removeClass('active');
                });
            });

            self.view.find('button').click(function(){
                var button = $(this);

                self.view.find('button').removeClass('active');
                button.addClass('active');

                self.content.removeClass('view-grid view-list');
                self.content.addClass('view-'+button.attr('data-type'));

                self.current_ajax = self.ajax(route('api.media_manager.view'), {view: button.attr('data-type')});
            });

            self.container.find('.new-dropzone').click(function(){
                self.dropzone.slideToggle(400);
            });

            self.container.on('click', '.download-zip', function(e){
                var url = $(this).attr('data-href');
                var boss = self.container.attr('data-boss');

                window.location.href = url.replace('%5Bboss%5D', boss);
            });

            self.container.on('click', '.modal-link', function(e){
                e.preventDefault();
                var btn = $(this);
                var url = btn.attr('data-href');
                var boss = self.container.attr('data-boss');

                self.current_ajax = self.ajax(url.replace('%5Bboss%5D', boss));
                self.current_ajax.done(function(data){
                    self.modal.find('.modal-title').html(data.title);
                    self.modal.find('.modal-body').html(data.content);
                    self.modal.find('.modal-body').find('.slim').slim();
                    self.modal.find('.modal-body').find('.form-custom-select').customSelector();

                    self.checkForm();

                    self.modal.modal('show');
                    btn.removeClass('btn-loading').removeAttr('disabled').tooltip('hide');
                }).fail(function(data){
                    app.notify.add('error', data.responseText);
                    btn.removeClass('btn-loading').removeAttr('disabled').tooltip('hide');
                });
            });

            self.container.on('click', '.manager-add-element', function(){
                var el = $(this);
                var type = el.attr('data-type');
                var id = el.attr('data-id');
                var title = el.attr('data-title');
                var content = isset(self.options.content) ? self.options.content : null;
                var selected = isset(self.options.selected) ? self.options.selected : false;

                if(selected){
                    var html = '<div class="image-box"><i class="fas fa-folder"></i></div><div class="preview-title">'+title+'</div>';
                    if(type == 'images'){
                        html = '<div class="image-box"><img class="img-responsive" src="'+el.attr('data-image')+'"></div><div class="preview-title">'+title+'</div>';
                    }
                    content.find('.preview-inside').html(html);
                    content.addClass('active');
                    content.find('[data-name="option-background-id"]').val(id);
                    content.find('[data-name="option-background-type"]').val(type);

                    var tab = content.find('.grid-background-tab');

                    tab.not('.grid-background-'+type).slideUp(200);
                    content.find('.grid-background-'+type).slideDown(200);
                }else{
                    if(isset(self.options.shortcode) && self.options.shortcode){
                        self.options.shortcode.append('<li>['+(type.charAt(0).toUpperCase() + type.slice(1))+'|'+id+']<span class="close"><i class="fas fa-times"></i></span></li>');
                    }else{
                        content.data('dynamicElements').add(type, function(element){
                            element.find('input[data-name=id]').val(id);
                            element.find('.sub-title').text('#'+id+' - '+title);
                            if(type == 'images'){
                                element.find('.show-image').attr('data-image', el.attr('data-image'));
                            }
                        });
                    }
                }
            });

            self.container.on('click', '.modal-manager-close', function(){
                $(this).closest('.modal').modal('hide');
            });

            self.searchInput.keyup(function(){
                self.search($(this).val());
            });
            self.searchBox.find('.input-group-addon').click(function(){
                self.search(self.searchInput.val());
            });

            self.container.on('click', '.manager-select', function(){
                var element = $(this);
                var parent = element.parents('li');
                var type = element.attr('data-type');
                var id = element.attr('data-id');

                parent.toggleClass('selected');

                if(parent.hasClass('selected')){
                    self.selected[type].push(id);
                }else{
                    array_remove(self.selected[type], id);
                }

                if(self.selected['document'].length + self.selected['folder'].length == 0){
                    self.pasteBtn.find('span').text('');
                    self.pasteBtn.addClass('hidden');
                }else{
                    self.pasteBtn.find('span').text('('+(self.selected['document'].length + self.selected['folder'].length)+')');
                    self.pasteBtn.removeClass('hidden');
                }
            });

            self.container.on('click', '.manager-paste', function(){
                var element = $(this);
                var url = element.attr('data-href');
                var boss = self.container.attr('data-boss');

                self.content.addClass('active');
                self.current_ajax = self.ajax(url.replace('%5Bboss%5D', boss), {folders: JSON.stringify(self.selected.folder), documents: JSON.stringify(self.selected.document)}, 'post');
                self.current_ajax.done(function(data){
                    self.content.html(data.content);
                    self.selected = {document: [], folder: []};
                    self.pasteBtn.find('span').text('');
                    self.pasteBtn.addClass('hidden');
                    element.removeClass('btn-loading').removeAttr('disabled').tooltip('hide');
                    self.content.removeClass('active');
                    self.searchInput.val('');
                }).fail(function(data){
                    app.notify.add('error', data.responseText);
                    element.removeClass('btn-loading').removeAttr('disabled').tooltip('hide');
                    self.content.removeClass('active');
                });
            });
        },
        search: function(value){
            var self = this;

            self.content.addClass('active');
            delay(function(){
                self.current_ajax = self.ajax(route('api.media_manager.search', {type: self.container.attr('data-type')}), {search: value, folder: self.container.attr('data-boss')});
                self.current_ajax.done(function(data){
                    self.content.html(data.content);
                    self.content.removeClass('active');
                }).fail(function(data){
                    app.notify.add('error', data.responseText);
                    self.content.removeClass('active');
                });
            }, 1100);
        },
        ajax: function(url, data, method, dataType){
            return $.ajax({
                url: url,
                method: typeof method == 'undefined' ? 'get' : method,
                data: data,
                dataType: typeof dataType == 'undefined' ? 'json' : dataType,
            });
        },
        renderBreadcrumb: function(breadcrumbs){
            var self = this;
            self.breadcrumb.find('li').not('.home').remove();

            $.each(breadcrumbs, function(){
                self.breadcrumb.append('<li><a href="'+this.url+'" class="manager-folder default-link" data-folder="'+this.id+'">'+this.title+'</a></li>');
            });
        },
        createView: function(stateObject, pushHistory) {
            var self = this;

            if(!pushHistory){
                if(stateObject) {
                    self.content.addClass('active');
                    self.current_ajax = self.ajax(route('api.media_manager.get', {type: self.container.attr('data-type')}), {folder: stateObject.boss});
                    self.current_ajax.done(function(data){
                        self.container.attr('data-boss', data.boss);
                        self.content.html(data.content);
                        self.renderBreadcrumb(data.breadcrumbs);
                        self.content.removeClass('active');
                    });
                }
            }else{
                history.pushState(stateObject, '', self.options.modal ? '' : pushHistory);
            }
        },
        append: function(data){
            if(data.type == 'folder'){
                if(isset(data.element_id)){
                    this.content.find('.manager-folder-'+data.element_id).replaceWith(data.item);
                }else{
                    var folder = this.content.find('.manager-folder-box').last();
                    if(folder.length){
                        folder.after(data.item);
                    }else{
                        this.content.prepend(data.item);
                    }
                }
            }else{
                if(isset(data.element_id)){
                    this.content.find('.manager-file-'+data.element_id).replaceWith(data.item);
                }else{
                    this.content.append(data.item);
                }
            }
            this.content.find('.manager-empty').remove();
        },
        checkForm: function(){
            var self = this;
            var form = self.modal.find('.modal-body').find('form');

            setTimeout(function(){
                form.find('[data-focus]').focus();
            }, 300);

            form.validator().on('submit', function(e){
                if(!e.isDefaultPrevented()) {
                    $(this).find('button[type="submit"]').addClass('btn-load btn-loading').attr('disabled','disabled');

                    var form = $(this);
                    var data = form.serialize();

                    if (isset(form.attr('enctype'))) {
                        data = new FormData($(this)[0]);

                        self.current_ajax = $.ajax({
                            url: form.attr('action'),
                            method: 'post',
                            data: data,
                            contentType: false,
                            processData: false,
                            dataType: 'json'
                        });
                    } else {
                        self.current_ajax = self.ajax(form.attr('action'), data, 'post');
                    }

                    self.current_ajax.done(function (data) {
                        if(data.message){
                            app.notify.add(data.message.type, data.message.msg);
                        }
                        if (!isset(data.close)) {
                            self.append(data);

                            self.modal.find('.modal-title').html(data.title);
                            self.modal.find('.modal-body').html(data.content);

                            self.modal.find('.modal-body').find('.slim').slim();
                            self.modal.find('.modal-body').find('.form-custom-select').customSelector();

                            self.checkForm();
                        } else {
                            self.append(data);
                            self.modal.modal('hide').find('.modal-body').html('');
                        }
                    });
                }

                e.preventDefault();
            });
        }
    };

    mediaManager.prototype.setContent = function(content, selected){
        this.options.content = content;
        this.options.selected = isset(selected) ? selected : false;
    };

    $.fn.mediaManager = function(option) {
        return this.each(function() {
            $.data(this, "mediaManager", new mediaManager($(this), $.extend({
                modal: false
            }, option)));
        });
    };
}(jQuery));