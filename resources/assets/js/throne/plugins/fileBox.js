$(function($){
    $(document).on('click', '.modal-delete-file', function(e){
        e.preventDefault();
        var a = $('.modal-delete').find('.modal-footer').find('a');
        a.removeClass('modal-delete-file');

        a.data('element').data('customFileBox').destroy();
    });

    var customFileBox = function(container, options){
        this.container = container;
        this.options = options;

        this.init();
    };

    customFileBox.prototype = {
        init: function(){
            this.uploaded = this.container.find('.uploaded');
            this.preview = this.container.find('.preview');
            this.info = this.container.find('.custom-file-box-info');
            this.input = this.container.find('input');
            this.loader = this.container.find('.loader');
            this.upload = isset(this.container.data('upload')) ? this.container.data('upload') : null;
            this.delete = isset(this.container.data('delete')) ? this.container.data('delete') : null;
            this.output = isset(this.container.data('output')) ? this.container.data('output') == 'parent' ? this.container.parent().find('>input') : $(this.container.data('output')) : '';
            this.modal = $('.modal-delete');
            this.fileReader = new FileReader();

            this.watch();
        },
        watch: function(){
            var self = this;

            self.input.change(function(){
                var file = this.files[0];
                var size = (file.size/1024/1024).toFixed(2);

                self.preview.html('');

                if(self.upload){
                    self.loader.addClass('active');

                    var formData = new FormData();
                    formData.append('file', file);

                    $.ajax({
                        url: self.upload,
                        method: 'post',
                        processData: false,
                        contentType: false,
                        data: formData,
                        dataType: 'json',
                        success: function(data){
                            var img = self.preview.find('img');

                            self.info.find('.title').text(data.name);
                            self.info.find('.size').text(size+'MB');

                            if(!img.length){
                                self.preview.html('<img class="img-responsive" src="'+data.path+data.name+'">');
                            }else{
                                img.attr('src', data.path+data.name);
                            }
                            self.container.attr('data-name', data.name);

                            if(!empty(self.output)){
                                self.output.val(data.name);
                            }

                            self.container.addClass('active');
                            self.loader.removeClass('active');
                        },
                        error: function(data){
                            self.loader.removeClass('active');
                            messages.add('error', data.responseText);
                        }
                    });
                }else{
                    self.info.find('.title').text(file.name);
                    self.info.find('.size').text(size+'MB');

                    if(['image/jpeg','image/jpg','image/png'].indexOf(file.type) >= 0){
                        self.loader.addClass('active');
                        self.fileReader.readAsDataURL(file);

                        self.fileReader.onload = function(data) {
                            var img = self.preview.find('img');

                            if(!img.length){
                                self.preview.html('<img class="img-responsive" src="'+data.target.result+'">');
                            }else{
                                img.attr('src', data.target.result);
                            }

                            if(!empty(self.output)){
                                self.output.val(data.target.result);
                            }

                            self.container.addClass('active');
                            self.loader.removeClass('active');
                        };
                    }else{
                        self.preview.html('<i class="fas fa-file" aria-hidden="true"></i><span>.'+file.name.split('.').pop()+'</span>');
                        self.container.addClass('active');
                    }
                }
            });

            self.container.on('click','.custom-file-box-delete', function(){
                if(self.delete && !empty(self.container.attr('data-name'))){
                    self.modal.find('.modal-footer').find('a').addClass('modal-delete-file').data('element', self.container);
                    self.modal.modal('show');
                }else{
                    self.container.removeClass('active');

                    self.preview.html('');
                    self.input.val('');
                }
            });
        }
    };

    customFileBox.prototype.destroy = function(){
        var self = this;
        var a = self.modal.find('.modal-footer').find('a');

        $.ajax({
            url: self.delete,
            method: 'post',
            data: {delete: self.container.attr('data-name')},
            success: function(){
                self.modal.modal('hide');
                self.container.removeClass('active');

                self.preview.html('');
                self.input.val('');
                a.removeClass('btn-loading').removeAttr('disabled');
            },
            error: function(){
                a.removeClass('btn-loading').removeAttr('disabled');
            }
        });
    };

    $.fn.customFileBox = function(option){
        var options = $.extend({}, option);

        return this.each(function() {
            $.data(this, "customFileBox", new customFileBox($(this), options));
        });
    }
}(jQuery));