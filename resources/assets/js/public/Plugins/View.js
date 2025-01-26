(function($){
    var View = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    View.prototype = {
        init: function(){
            this.url = this.container.data('url');
            this.loader = this.container.find('.loader');
            this.limitBox = this.container.find('.limit-box');
            this.limit_actions = this.limitBox.find('[data-limit]');
            this.view_actions = this.container.find('[data-view]');
            this.content = $('.view-content');

            this.watch();
        },
        watch: function(){
            var self = this;

            self.limit_actions.click(function(){
                var limit = $(this).data('limit');

                self.loader.addClass('active');
                self.content.addClass('loading');

                get(self.url, {limit: limit}).done(function(data){
                    self.limitBox.find('.title').html(limit);
                    self.content.html(data.content);

                    self.loader.removeClass('active');
                    self.content.removeClass('loading');
                }).fail(function(){
                    self.loader.removeClass('active');
                    self.content.removeClass('loading');
                });
            });

            self.view_actions.click(function(){
                var el = $(this);
                var view = el.data('view');

                self.loader.addClass('active');
                self.content.addClass('loading');

                get(self.url, {view: view}).done(function(){
                    if(view == 'list'){
                        self.content.addClass('lists');
                    }else{
                        self.content.removeClass('lists');
                    }

                    self.view_actions.removeClass('active');
                    el.addClass('active');

                    self.loader.removeClass('active');
                    self.content.removeClass('loading');
                }).fail(function(){
                    self.loader.removeClass('active');
                    self.content.removeClass('loading');
                });
            });
        },
    };

    $.fn.View = function(option) {
        var options = $.extend({}, option);

        return this.each(function() {
            $.data(this, "View", new View($(this), options));
        });
    };
}(jQuery));