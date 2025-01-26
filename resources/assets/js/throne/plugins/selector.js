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

    $(window).keydown(function(e) {
        if($('.customSelect').hasClass('open')){
            var selector = $('.customSelect.open');

            if(e.which === 40 || e.which === 38 || e.which === 13){
                e.preventDefault();
            }

            if(e.which === 40) {
                selector.prev('select').data('customSelector').down();
            }else if(e.which === 38) {
                selector.prev('select').data('customSelector').up();
            }else if(e.which === 13) {
                selector.prev('select').data('customSelector').enter();
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
            this.order = isset(this.container.attr('data-order')) ? $(this.container.attr('data-order')) : '';
            this.placeholder = isset(this.container.attr('data-placeholder')) ? this.container.attr('data-placeholder') : '';
            this.max_selected = isset(this.container.attr('data-max')) ? this.container.attr('data-max') : 0;
            this.currect_selected = 0;
            this.current_elements = [];

            if(this.multi){
                this.customBox.addClass('multi-select');
            }

            this.container.addClass('visible-hide');
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
                    if(el.is(':selected')){
                        if(self.multi) {
                            if(!self.order){
                                self.addTag(el.val(), el.html());
                            }
                        }else {
                            self.currentSelected.html(el.html());
                        }
                    }
                    var option_class = "";
                    if(isset(el.attr('class'))){
                        option_class = el.attr('class');
                    }
                    if(el.is(':selected')){
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
                self.items.append('<li class="'+self.noOption+' selected-search"><input type="text"></li>');
                self.search = self.items.find('.selected-search');
            }

            self.eachOptions(self.container.find('>option, >optgroup'));
            self.items.append(self.html);

            if(this.order && this.order.val()){
                $.each(this.order.val().split(','), function(key, value){
                    var el = self.container.find('option[value="'+value+'"]');

                    self.addTag(value, el.html());
                });
            }

            if(!self.currentSelected.html().length){
                if(self.multi){
                    self.currentSelected.html('<span class="custom-select-placeholder">'+self.placeholder+'</span>');
                }else{
                    self.currentSelected.html(self.placeholder);
                }
            }
        },
        addTag: function(index, value){
            if(this.order){
                this.current_elements.push(index.toString());
                this.order.val(this.current_elements.join());
            }

            if(!this.currentSelected.find('.selected-item').length){
                this.currentSelected.html('');
            }
            this.currect_selected++;
            this.currentSelected.append('<span class="selected-item" data-index="'+index+'">'+value+'<span class="fas fa-times selected-close"></span></span>');
        },
        watch: function(){
            var self = this;

            self.container.focus(function(){
                self.currentSelected.trigger('click');
            });

            self.container.blur(function(e){
                if(e.relatedTarget && !$(e.relatedTarget).parent().hasClass('selected-search')){
                    $('.customSelect').not($(this).parent()).removeClass('open');
                }
            });

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
                self.currect_selected--;

                if(self.current_elements.indexOf(index) > -1){
                    self.current_elements.splice(self.current_elements.indexOf(index), 1);
                    self.order.val(self.current_elements.join());
                }
                if(!self.currentSelected.find('.selected-item').length){
                    self.currentSelected.html('<span class="custom-select-placeholder">'+self.placeholder+'</span>');
                }
            });

            if(self.haveSearch){
                self.items.on('keydown', '.selected-search input',function(e){
                    if(e.which === 9 && e.shiftKey){
                        $('input:visible, select:visible, textarea:visible')[$('input:visible, select:visible, textarea:visible').index(this)-1].focus();
                    }
                });
                self.items.on('keyup', '.selected-search input',function(e){
                    if($(this).val() != '') {
                        self.items.find('li').not('.'+self.noOption).addClass('hidden').removeClass('selected-searched');
                        self.items.find('li:not(.'+self.noOption+'):containsIN("'+$(this).val()+'")').addClass('selected-searched').removeClass('hidden');
                        self.items.find('.focus').removeClass('focus');
                        self.items.find('.selected-searched').first().addClass('focus');

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
            var selected = false;
            var self = this;
            var index = self.items.find('li').not('.'+self.noOption).index(element);

            if(!self.multi){
                self.items.find('.active').removeClass('active');
                self.currentSelected.html($(element).html());
                self.customBox.removeClass('open');
                selected = true;
            }else if(self.max_selected == 0 || self.currect_selected < self.max_selected){
                self.addTag($(element).data('value'), $(element).html());
                selected = true;
            }

            if(selected){
                self.container.find('option').eq(index).prop('selected', true);
                self.container.trigger('change');
                $(element).addClass('active');
            }
        }
    };

    customSelector.prototype.up = function(){
        var self = this;
        var prev;

        if(self.haveSearch){
            self.search.find('input').first().blur();
        }

        if(self.items.find('.focus').length){
            var current = self.items.find('.focus').removeClass('focus');
            prev = current.prevAll('li').not('.hidden').not('.selected-search').first().addClass('focus');

            if(current.parents('.optgroup').length && !prev.length){
                prev = current.parents('.optgroup').prevAll('li').not('.hidden').first().addClass('focus');
            }
            if(prev.hasClass('optgroup')){
                prev = prev.removeClass('focus').find('li').not('.hidden').last().addClass('focus');
            }
        }else{
            prev = self.items.find('li').not('.'+self.noOption).not('.hidden').last().addClass('focus');
        }

        if(prev.length){
            self.items.first().scrollTop(self.items.first().scrollTop() + self.items.find('.focus').position().top-(current ? parseInt(current.css('height')) : 0)-(self.haveSearch ? parseInt(self.search.css('height')) : 0));
        }else{
            self.items.first().scrollTop(0);
        }
    };

    customSelector.prototype.down = function(){
        var self = this;
        var next;

        if(self.haveSearch){
            self.search.find('input').first().blur();
        }

        if(self.items.find('.focus').length){
            var current = self.items.find('.focus').removeClass('focus');
            next = current.nextAll('li').not('.hidden').not('.selected-search').first().addClass('focus');

            if(current.parents('.optgroup').length && !next.length){
                next = current.parents('.optgroup').nextAll('li').not('.hidden').first().addClass('focus');
            }
            if(next.hasClass('optgroup')){
                next = next.removeClass('focus').find('li').not('.hidden').first().addClass('focus');
            }
        }else{
            next = self.items.find('li').not('.'+self.noOption).not('.hidden').first().addClass('focus');
        }

        if(next.length){
            self.items.first().scrollTop(self.items.first().scrollTop() + self.items.find('.focus').position().top-(current ? parseInt(current.css('height')) : 0)-(self.haveSearch ? parseInt(self.search.css('height')) : 0));
        }else{
            self.items.first().scrollTop(0);
        }
    };

    customSelector.prototype.enter = function(){
        var self = this;
        var focus = self.items.find('.focus').not('.'+self.noOption).not('.active').not('.disabled');

        if(focus.length){
            self.selected(focus.first());
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
        var options = $.extend({
            search: false
        }, option);

        return this.each(function() {
            $.data(this, "customSelector", new customSelector($(this), options));
        });
    };
}(jQuery));