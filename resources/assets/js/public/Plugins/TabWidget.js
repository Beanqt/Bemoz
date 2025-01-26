(function($){
    var tabWidget = function(container, option){
        this.container = $(container);
        this.option = option;
        this.init()
    };

    tabWidget.prototype = {
        init: function(){
            this.menu = this.container.find('.tabs-menu');
            this.menuItems = this.menu.find('li');
            this.content = this.container.find('.tabs-content');
            this.contentItem = this.content.find('li');
            this.watch();
        },
        watch: function(){
            var self = this;

            self.menuItems.on('click', function(){
                var id = $(this).data('tab');
                var box = self.content.find('.item-'+id);

                self.contentItem.removeClass('active');
                box.addClass('active');

                self.menuItems.removeClass('active');
                $(this).addClass('active');
            });
        }
    };

    $.fn.tabWidget = function(option) {
        var options = $.extend({

        }, option);

        return this.each(function() {
            $.data(this, "tabWidget", new tabWidget($(this), options));
        });
    };
}(jQuery));