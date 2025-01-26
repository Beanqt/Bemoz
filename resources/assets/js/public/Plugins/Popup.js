(function($){
    var customPopup = function(container, option){
        this.container = container;
        this.option = option;
        this.init();
    };

    customPopup.prototype = {
        init: function(){
            this.html = '';
            this.current = 0;
            this.images = [];
            this.watch();
        },
        watch: function(){
            var self = this;

            if(this.option.type == 'image'){
                this.container.click(function(e){
                    e.preventDefault();
                    var el = $(this);
                    var image = el.attr('href');
                    var title = el.attr('title');

                    self.html = '<img src="'+image+'">'+(title.length ? '<div class="custom-info"><div class="title">'+title+'</div></div>' : '');
                    self.open();
                });
            }else if(this.option.type == 'gallery'){
                this.images = this.container.find('a').not('.default-link');
                this.container.find('.first-image').click(function(e){
                    e.preventDefault();
                    var el = $(this);
                    var image = el.attr('href');
                    var title = el.attr('title');

                    self.current = self.images.index(el);
                    self.html = '<img src="'+image+'"><span class="custom-popup-action custom-popup-prev"><i class="fas fa-angle-left"></i></span><span class="custom-popup-action custom-popup-next"><i class="fas fa-angle-right"></i></span><div class="custom-info">'+(title.length ? '<div class="title">'+title+'</div>' : '')+'<div class="number"><span>'+(self.current+1)+'</span>/'+self.images.length+'</div></div>';
                    self.open();
                });
            }else if(this.option.type == 'iframe'){
                this.container.click(function(e){
                    e.preventDefault();
                    var el = $(this);
                    var href = el.attr('href').replace(/http:|https:/, '').replace(/watch\?v=(.*)/, 'embed/$1?autoplay=1');

                    self.html = '<div class="custom-iframe-box"><iframe src="'+href+'" frameborder="0" allowfullscreen></iframe></div>';
                    self.open();
                });
            }else if(this.option.type == 'video'){
                this.container.click(function(e){
                    e.preventDefault();
                    var el = $(this);
                    var href = el.attr('href');
                    var webm = el.attr('data-webm');

                    self.html = '<video autoplay controls><source src="'+href+'" type="video/mp4">'+(webm.length ? '<source src="'+webm+'" type="video/webm">' : '')+'</video>';
                    self.open();
                });
            }else if(this.option.type == 'audio'){
                this.container.click(function(e){
                    e.preventDefault();
                    var el = $(this);
                    var href = el.attr('href');

                    self.html = '<audio autoplay controls><source src="'+href+'" type="audio/mpeg"></audio>';
                    self.open();
                });
            }
        },
        open: function(){
            var self = this;
            app.body.addClass('overflow');
            app.body.append('<div class="custom-popup"><div class="loader loading"></div><div class="custom-popup-inside"><i class="custom-popup-close fas fa-times"></i>'+this.html+'</div></div></div>');

            this.popup = app.body.find('.custom-popup');
            this.popup.img = this.popup.find('img');
            this.popup.title = this.popup.find('.title');
            this.popup.find('.custom-popup-close').click(function(){
                self.close();
            });

            this.popup.click(function(e){
                if(e.target.className == 'custom-popup'){
                    self.close();
                }
            });

            if(this.option.type == 'gallery'){
                this.popup.number = this.popup.find('.number span');
                this.popup.find('.custom-popup-prev').click(function(){
                    self.prev();
                });
                this.popup.find('.custom-popup-next').click(function(){
                    self.next();
                });
            }
        },
        close: function(){
            this.popup.remove();
            app.body.removeClass('overflow');

            this.popup.find('.custom-popup-close').unbind("click");
            this.popup.unbind("click");
            this.popup = null;
        },
        prev: function(){
            if(this.current > 0){
                this.current--;
                this.load(this.images.eq(this.current));
            }
        },
        next: function(){
            if(this.current < this.images.length-1){
                this.current++;
                this.load(this.images.eq(this.current));
            }
        },
        load: function(current){
            this.popup.img.attr('src', current.attr('href'));
            this.popup.number.text(this.current+1);
            if(current.attr('title').length){
                this.popup.title.show().text(current.attr('title'));
            }else{
                this.popup.title.hide();
            }
        }
    };

    $.fn.customPopup = function(option) {
        option = $.extend({
            type: 'image'
        }, option);

        return this.each(function() {
            $.data(this, "customPopup", new customPopup($(this), option));
        });
    };
}(jQuery));