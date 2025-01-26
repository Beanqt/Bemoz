(function($){
    var scheduleWeek = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    scheduleWeek.prototype = {
        init: function(){
            this.options.output = $(this.options.output);

            this.watch();
        },
        watch: function(){
            var self = this;

            if(input = isJson(self.options.output.val())){
                $.each(input, function(day, item){
                    $.each(item.original, function(key, time){
                        if(time == 1){
                            self.container.find('.day').eq(day).find('.schedule-time').eq(key).addClass('selected');
                        }
                    });
                });
            }

            self.container.selectable({
                filter: ".schedule-time",
                selected: function( event, ui ) {
                    $(ui.selected).addClass('selected');
                },
                selecting: function( event, ui ) {
                    var element = $(ui.selecting);
                    if(element.hasClass('selected')){
                        element.removeClass('selected').removeClass('ui-selected').removeClass('ui-selecting');
                    }
                }
            });

            self.container.parents('form').submit(function(){
                var output = self.options.output;
                var array = [];

                $.each(self.container.find('.day'), function(){
                    var sub_array = {original: [], simple: []};
                    var start;

                    $.each($(this).find('li'), function(){
                        var element = $(this);
                        var selected = element.hasClass('selected');

                        if(selected){
                            if(element.next().hasClass('selected') && typeof start == 'undefined'){
                                start = element.data('start-time');
                            }else if(typeof start == 'undefined'){
                                sub_array.simple.push([element.data('start-time')+'-'+element.data('end-time')]);
                            }else if(!element.next().hasClass('selected')){
                                sub_array.simple.push([start+'-'+element.data('end-time')]);
                                start = undefined;
                            }
                        }

                        sub_array.original.push(selected ? 1 : 0);
                    });

                    array.push(sub_array);
                });

                output.val(JSON.stringify(array));
            });
        }
    };

    scheduleWeek.prototype.destroy = function(){
        this.container.remove();
        this.container = null;
        this.options = null;
    };

    $.fn.scheduleWeek = function(option) {
        var options = $.extend({
            output: '.schedule-json'
        }, option);

        return this.each(function() {
            $.data(this, "scheduleWeek", new scheduleWeek($(this), options));
        });
    };
}(jQuery));