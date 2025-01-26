$(function($){
    var customFileBox = function(container, options){
        this.container = container;
        this.options = options;

        this.init();
    };

    customFileBox.prototype = {
        init: function(){
            this.label = this.container.next('label');
            this.title = this.label.find('span');

            this.watch();
        },
        watch: function(){
            var self = this;

            self.container.change(function(){
                var files = this.files;

                if(files.length > 1){
                    var name = '';

                    for(var i = 0; i < files.length; i++){
                        name += files[i].name+'\n';
                    }

                    self.title.text(files.length+' '+messages.filebox.selected).attr('title', name);
                }else if(files.length == 1){
                    self.title.text(files[0].name).attr('title', files[0].name);
                }else{
                    self.title.text(messages.filebox.title).removeAttr('title');
                }
            });
        }
    };

    $.fn.customFileBox = function(option){
        var options = $.extend({}, option);

        return this.each(function() {
            $.data(this, "customFileBox", new customFileBox($(this), options));
        });
    }
}(jQuery));