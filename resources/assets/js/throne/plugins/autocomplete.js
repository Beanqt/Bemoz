(function($){
    var customAutoComplete = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    customAutoComplete.prototype = {
        init: function(){
            this.container.next('.customAutoComplete').length ? this.container.next('.customAutoComplete').remove() : '';
            this.container.after('<div class="customAutoComplete"><input class="form-control"><ul></ul></div>');
            this.html = '';
            this.customBox = this.container.next('.customAutoComplete').first();
            this.input = this.customBox.find('input');
            this.items = this.customBox.find('ul');
            this.multi = typeof this.container.attr('data-multiple') != 'undefined' || false;
            this.autocomplete = typeof this.container.attr('data-autocomplete') != 'undefined' ? this.container.attr('data-autocomplete') : null;

            if(this.multi){
                this.customBox.addClass('multi-select');
            }

            this.container.addClass('hidden');
            this.render();
            this.watch();
        },
        render: function(){
            var self = this;

            if(self.autocomplete.length){
                var array = self.autocomplete.split('|');

                $.each(array, function(key, item){
                    self.items.append('<li>'+item+'</li>');
                });
            }

            self.input.val(self.container.val());
            self.input.attr('type', self.container.attr('type'));
        },
        watch: function(){
            var self = this;

            self.input.keyup(function(){
                self.items.find('.active').removeClass('active');
                self.container.val(this.value);

                if($(this).val() != '') {
                    self.items.find('li').addClass('hidden').removeClass('selected-searched');
                    self.items.find('li:containsIN("'+$(this).val()+'")').addClass('selected-searched').removeClass('hidden');
                }else{
                    self.items.find('.hidden').removeClass('hidden');
                }
            });

            if(!self.autocomplete || self.autocomplete.length == 0){
                return false;
            }

            self.input.focus(function(){
                self.customBox.addClass('open');
            });
            self.input.blur(function(){
                self.customBox.removeClass('open');
            });
            self.items.on('click', 'li:not(.disabled)', function(){
                if($(this).hasClass('active')) return false;
                self.selected($(this));
            });
        },
        selected: function(element){
            var self = this;

            self.items.find('.active').removeClass('active');
            self.input.val(element.html());
            self.container.val(element.html());
            self.customBox.removeClass('open');
            element.addClass('active');
        }
    };

    customAutoComplete.prototype.update = function(){
        this.autocomplete = this.container.attr('data-autocomplete');
        this.items.html('');
        this.render();
    };

    $.fn.customAutoComplete = function(option) {
        var options = $.extend({

        }, option);

        return this.each(function() {
            $.data(this, "customAutoComplete", new customAutoComplete($(this), options));
        });
    };
}(jQuery));