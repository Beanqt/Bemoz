(function($){
    var widgetCreator = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    widgetCreator.prototype = {
        init: function(){
            this.loader = this.container.find('>.loader');
            this.selector = this.container.find('.selector');
            this.shortCodeBox = this.container.find('.shortcodes-table');
            this.dynamicElements = this.container.parents('.dynamic-elements-box');
            this.panels = this.container.find('.panels');
            this.generalBtn = this.container.find('.shortcode-general');
            this.addWidgetBtn = this.container.find('.widget-add');
            this.sortable = this.dynamicElements.length != 0;

            this.watch();
        },
        watch: function(){
            var self = this;

            self.container.find('.widget-refresh').click(function(){
                var widget = $(this).data('type');
                var select = $(this).next('select');
                var parent = $(this).parent('.input-group');

                parent.addClass('load');
                $.ajax({
                    url: route('api.widget.refresh', {widget: widget}),
                    dataType: 'html',
                    success: function(data){
                        select.html(data);
                        select.data('customSelector').update();
                        parent.removeClass('load');
                    }
                });
            });

            self.selector.change(function(){
                var value= $(this).val();

                self.panels.find('.panel').removeClass('active');

                if(value.length > 0) {
                    self.panels.find('.' + value).addClass('active');
                }

                if(value=='content'){
                    self.selector.val('').data('customSelector').update();
                    self.dynamicElements.data('dynamicElements').add('content');
                }

                if(value=='grid'){
                    self.selector.val('').data('customSelector').update();
                    self.dynamicElements.data('dynamicElements').add('grid');
                }

                if(value == 'documents' || value == 'gallery' || value == 'video'){
                    var modal = $('.modal-'+value+'-manager');
                    var media = $('.media-'+value+'-manager');
                    $(this).append('<div class="loader active"></div>');

                    if(modal.find('.modal-body').find('>.loader').length){
                        modal.modal('show');

                        $.ajax({
                            url: route('api.media_manager.load', {type: value}),
                            method: 'get',
                            dataType: 'json',
                            success: function(data){
                                modal.find('.modal-body').html(data.content);
                                self.selector.val('').data('customSelector').update();
                            },
                            complete: function(){
                                media.mediaManager({
                                    content: self.dynamicElements,
                                    modal: '.modal-'+value+'-manager',
                                    shortcode: (!self.sortable ? self.shortCodeBox : null)
                                });
                            }
                        });
                    }else{
                        media.data('mediaManager').setContent(self.dynamicElements);
                        setTimeout(function(){
                            self.selector.val('').data('customSelector').update();
                        }, 500);
                    }

                    modal.modal('show');
                }
            });

            self.generalBtn.click(function(){
                var name = $(this).data('name');
                var value = '';

                if(name == 'email'){
                    value = self.getEmail();
                }
                if(name == 'button'){
                    value = self.getButton();
                }
                if(name == 'forms'){
                    self.selector.val('').data('customSelector').update();
                    var select = self.container.find('#shortcodes-forms');

                    if(!select.val()){
                        return false;
                    }

                    self.dynamicElements.data('dynamicElements').add('forms', function(element){
                        var href = element.find('.widgetItemAction').find('a');

                        href.attr('href', href.attr('href')+'/'+select.val());
                        element.find('input[data-name=id]').val(select.val());
                        element.find('.sub-title').text('#'+select.val()+' - '+select.find('option:selected').text());
                    });
                }

                if(value.length > 0){
                    self.shortCodeBox.append('<li>'+value+'<span class="close"><i class="fas fa-times"></i></span></li>');
                }
            });
            self.addWidgetBtn.click(function(){
                var el = $(this);
                var name = el.data('name');
                var select = el.parent().find('select');

                if(!self.sortable){
                    var main_name = self.selector.val().replace('widget-', '');

                    if(self.selector.val()){
                        self.shortCodeBox.append('<li>['+(main_name.charAt(0).toUpperCase() + main_name.slice(1))+'|'+select.val()+']<span class="close"><i class="fas fa-times"></i></span></li>');
                    }
                }else if(select.val()){
                    self.dynamicElements.data('dynamicElements').add('widget', function(element){
                        var href = element.find('.widgetItemAction').find('a');

                        href.attr('href', href.attr('href')+'/'+select.val());
                        element.find('.title').text(name);
                        element.find('input[data-name=id]').val(select.val());
                        element.find('.sub-title').text('#'+select.val()+' - '+select.find('option:selected').text());
                    });
                }
            });
        },
        getEmail: function(){
            var self = this;
            var email = self.container.find('#shortcode-email').val();
            var text = self.container.find('#shortcode-email-text').val();

            return '[EmailProtect|'+(email+'{+}'+text).replace('[','').replace(']','')+']';
        },
        getButton: function(){
            var self = this;
            var link = self.container.find('#shortcode-button-link').val();
            var text = self.container.find('#shortcode-button-text').val();
            var open = self.container.find('#shortcode-button-open').val();
            var event = self.container.find('#shortcode-button-event').val();
            if(event.length > 0){
                event = '{+}'+event;
            }
            var fulltext = link+'{+}'+text+event;

            return '[Button|'+fulltext.replace('[','').replace(']','')+'|'+open+']';
        }
    };

    $.fn.widgetCreator = function(option) {
        var options = $.extend({}, option);

        return this.each(function() {
            $.data(this, "widgetCreator", new widgetCreator($(this), options));
        });
    };
}(jQuery));