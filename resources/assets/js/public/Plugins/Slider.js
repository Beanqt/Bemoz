(function($){
    var customSlider = function(container, option){
        this.container = container;
        this.option = option;
        this.init();
    };

    customSlider.prototype = {
        init: function(){
            this.timeout = {};

            this.watch();
        },
        watch: function(){
            var self = this;

            this.container.carousel({
                interval: false,
                pause: 'hover'
            });

            this.checkSlider();

            this.container.on('slid.bs.carousel', function () {
                if(self.video && !self.current_video.paused){
                    self.current_video.pause();
                    self.current_video.currentTime = 0;
                }
                clearTimeout(self.timeout);
                self.checkSlider();
            });

            this.container.find('.play').click(function(){
                var el = $(this);

                if(el.hasClass('fa-play')){
                    el.removeClass('fa-play').addClass('fa-pause');
                    self.current_video.play();
                }else{
                    el.removeClass('fa-pause').addClass('fa-play');

                    self.current_video.pause();
                    self.timeout = setTimeout(function(){
                        self.next();
                        self.current_video.currentTime = 0;
                    }, self.option.interval);
                }
            });
            this.container.find('.volume').click(function(){
                var el = $(this);

                if(el.hasClass('fa-volume-up')){
                    self.current_video.muted = true;
                    el.addClass('fa-volume-off').removeClass('fa-volume-up');
                }else{
                    self.current_video.muted = false;
                    el.addClass('fa-volume-up').removeClass('fa-volume-off');
                }
            });
        },
        checkSlider: function(){
            var self = this;

            this.current_item = this.container.find('.item.active');
            this.video = this.current_item.find('video');
            this.current_video = this.video.get(0);
            this.loader = this.current_item.find('.loader');
            this.loader.addClass('active');

            if(this.video.length) {
                this.startVideo(true);
            }else{
                this.video = null;
                this.current_video = null;
                clearTimeout(this.timeout);
                this.timeout = setTimeout(function(){
                    self.next();
                }, self.option.interval);
            }
        },
        startVideo: function(){
            var self = this;
            var isPlaying = this.current_video.duration > 0 && this.current_video.paused && !this.current_video.ended && this.current_video.readyState > 2;
            this.loader.removeClass('active');

            if(isPlaying) {
                self.loadVideo(true);
            }else{
                this.video.bind('loadeddata', function() {
                    self.loadVideo(true);
                });
            }
        },
        next: function(){
            this.container.carousel('next');
        },
        loadVideo: function(){
            var self = this;

            this.current_item.find('.play').removeClass('fa-play').addClass('fa-pause');
            this.current_video.play();

            this.current_video.onended = function(){
                self.current_video.pause();
                self.current_video.currentTime = 0;

                if(self.container.find('.item').length > 1) {
                    self.next();
                }else{
                    self.loadVideo(true);
                }
            };
        }
    };

    $.fn.customSlider = function(option) {
        var options = $.extend({
            interval: 7000
        }, option);

        return this.each(function() {
            $.data(this, "customSlider", new customSlider($(this), options));
        });
    };
}(jQuery));