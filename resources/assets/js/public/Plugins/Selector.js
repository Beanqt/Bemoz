(function($){
    $(document).on('click',function (e) {
        e.stopPropagation();

        if(!$(e.target).closest('.customSelect').length) {
            var name = $('.customSelect');
            if(name.hasClass('open')) {
                name.removeClass('open');
            }
        }
    });

    var customSelector = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    customSelector.prototype = {
        init: function(){
            this.container.next('.customSelect').length ? this.container.next('.customSelect').remove() : '';
            this.container.after('<div class="customSelect"><div class="current-selected form-control"></div><ul></ul></div>');
            this.haveSearch = isset(this.container.data('search')) ? true : this.options.search;
            this.disabled = isset(this.container.attr('disabled'));
            this.html = '';
            this.noOption = 'selected-no-option';
            this.customBox = this.container.next('.customSelect');
            this.currentSelected = this.customBox.find('.current-selected');
            this.items = this.customBox.find('ul');
            this.multi = typeof this.container.attr('multiple') != 'undefined' || false;
            this.placeholder = typeof this.container.attr('data-placeholder') != 'undefined' ? this.container.attr('data-placeholder') : '';

            if(this.multi){
                this.customBox.addClass('multi-select');
            }

            this.container.addClass('hidden');
            this.renderOptions();
            this.watch();
        },
        eachOptions: function(data){
            var self = this;

            data.each(function(key, e){
                var el = $(this);

                if(e.localName == 'optgroup'){
                    self.html += '<li class="'+self.noOption+' optgroup"><span>'+el.attr('label')+'</span><ul>';
                    self.eachOptions(el.find('>option'));
                    self.html += '</ul></li>';
                }else {
                    if(el.attr('selected')) {
                        if(self.multi) {
                            self.addTag(self.container.find('option').index(this), el.html());
                        }else {
                            self.currentSelected.html(el.html());
                        }
                    }
                    var option_class = "";
                    if(isset(el.attr('class'))){
                        option_class = el.attr('class');
                    }
                    if(el.attr('selected')){
                        option_class += (option_class.length ? ' ' : '')+'active';
                    }
                    if(el.attr('disabled') || self.disabled){
                        option_class += (option_class.length ? ' ' : '')+'disabled';
                    }
                    self.html += '<li'+(option_class.length ? ' class="'+option_class+'"' : '')+' data-value="' + $(this).attr('value') + '">' + $(this).html() + '</li>';
                }
            });
        },
        renderOptions: function(){
            var self = this;

            if(self.haveSearch) {
                self.items.append('<li class="'+self.noOption+' selected-search"><input type="text" data-validate="false"></li>');
                self.search = self.items.find('.selected-search');
            }

            self.eachOptions(self.container.find('>option, >optgroup'));
            self.items.append(self.html);

            if(!self.currentSelected.html().length){
                if (self.multi) {
                    self.currentSelected.html('<span class="custom-select-placeholder">'+self.placeholder+'</span>');
                }else{
                    self.currentSelected.html(self.placeholder);
                }
            }
        },
        addTag: function(index, value){
            if(!this.currentSelected.find('.selected-item').length){
                this.currentSelected.html('');
            }
            this.currentSelected.append('<span class="selected-item" data-index="'+index+'">'+value+'<span class="fas fa-times selected-close"></span></span>');
        },
        watch: function(){
            var self = this;

            self.currentSelected.on('click', function(){
                $('.customSelect').not($(this).parent()).removeClass('open');
                self.customBox.toggleClass('open');

                if(self.customBox.hasClass('open') && self.haveSearch){
                    setTimeout(function() { self.search.find('input').first().focus() }, 400);
                }
            });
            self.items.on('click', 'li:not(.'+self.noOption+'):not(.disabled)', function(){
                if($(this).hasClass('active')) return false;
                self.selected(this);
            });

            self.currentSelected.on('click', '.selected-close', function(){
                var index = $(this).parent().attr('data-index');
                $(this).parent().remove();

                self.container.find('option[value="'+index+'"]').prop('selected', false);
                self.items.find('li[data-value="'+index+'"]').not('.'+self.noOption).removeClass('active');
                self.container.trigger('change');

                if(!self.currentSelected.find('.selected-item').length){
                    self.currentSelected.html('<span class="custom-select-placeholder">'+self.placeholder+'</span>');
                }
            });

            if(self.haveSearch){
                self.items.on('keyup', '.selected-search input',function(){
                    if($(this).val() != '') {
                        self.items.find('li').not('.'+self.noOption).addClass('hidden').removeClass('selected-searched');
                        self.items.find('li:not(.'+self.noOption+'):containsIN("'+$(this).val()+'")').addClass('selected-searched').removeClass('hidden');
                        self.items.find('.focus').removeClass('focus');
                        self.items.find('.selected-searched').first().addClass('focus');

                        var optgroup = self.items.find('.optgroup');

                        self.items.find('.optgroup').each(function(){
                            if($(this).find('.selected-searched').length){
                                $(this).removeClass('hidden');
                            }else{
                                $(this).addClass('hidden');
                            }
                        });
                    }else{
                        self.items.find('li.hidden').removeClass('hidden');
                    }
                });
            }
        },
        selected: function(element){
            var self = this;
            var index = self.items.find('li').not('.'+self.noOption).index(element);
            self.container.find('option').eq(index).prop('selected', true);

            if(!self.multi){
                self.items.find('.active').removeClass('active');
                self.currentSelected.html($(element).html());
                self.customBox.removeClass('open');
            }else{
                self.addTag(index, $(element).html());
            }
            self.container.trigger('change');
            $(element).addClass('active');
        }
    };
    customSelector.prototype.reset = function(){
        var self = this;
        var selected = self.container.find('option:selected');

        self.currentSelected.html(selected.html());
        self.items.find('li').not('.'+self.noOption).removeClass('active');
        self.items.find('li').not('.'+self.noOption).eq(selected.index()).addClass('active');
    };

    customSelector.prototype.update = function(){
        var self = this;

        self.html = '';
        self.items.find('li').remove();
        self.renderOptions();
        self.reset();
    };

    customSelector.prototype.destroy = function(){
        this.customBox.remove();
        this.container.removeClass('hidden');

        this.options = '';
        this.noOption = '';
        this.html = '';
        this.search = '';
        this.customBox = '';
        this.currentSelected = '';
        this.items = '';
        this.multi = '';
        this.placeholder = '';

        this.init = '';
        this.eachOptions = '';
        this.renderOptions = '';
        this.addTag = '';
        this.watch = '';
    };

    $.fn.customSelector = function(option) {
        option = $.extend({
            search: false
        }, option);

        return this.each(function() {
            $.data(this, "customSelector", new customSelector($(this), option));
        });
    };
}(jQuery));