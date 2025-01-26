(function($){
    var customAnimate = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    customAnimate.prototype = {
        init: function(){
            this.distance = isset(this.container.data('distance')) ? this.container.data('distance') : 1.2;
            this.startAnimationHeight = $(window).height()/this.distance;
            this.transform = isset(this.container.data('transform')) ? this.container.data('transform') : false;
            this.animation = isset(this.container.data('animation')) ? this.container.data('animation') : 'left';

            this.watch();
        },
        watch: function(){
            var self = this;
            var top = $(window).scrollTop();

            if(!self.transform && top > self.container.offset().top-self.startAnimationHeight){
                self.container.addClass('animated');
            }

            $(window).resize(function(){
                self.startAnimationHeight = $(window).height()/self.distance;
            });

            $(window).scroll(function(){
                top = $(this).scrollTop();

                if(self.transform){
                    if(self.animation == 'left'){
                        self.container.css({'transform' : 'translate(-'+top/self.transform+'px,0)'});
                    }else{
                        self.container.css({'transform' : 'translate('+top/self.transform+'px,0)'});
                    }
                }else{
                    if(top > self.container.offset().top-self.startAnimationHeight){
                        if(!self.container.hasClass('animated')){
                            self.container.addClass('animated');
                        }
                    }else{
                        self.container.removeClass('animated');
                    }
                }
            });
        }
    };

    $.fn.customAnimate = function(option) {
        var options = $.extend({
            mobile: true
        }, option);

        return this.each(function() {
            $.data(this, "customAnimate", new customAnimate($(this), options));
        });
    };
}(jQuery));