var pageNumber = function(container){
    this.container = $(container);
    this.init()
};

pageNumber.prototype = {
    init: function(){
        this.load = false;
        this.item = this.container.find('.widgetItem');
        this.stats = this.item.find('.stat-number');
        this.watch();
    },
    watch: function(){
        var self = this;

        this.scrolling();

        $(window).scroll(function(){
            self.scrolling();
        });
    },
    scrolling: function(){
        var self = this;
        var top = $(window).scrollTop();
        var height = ($(window).height()/2);
        var featured = self.container.offset().top-height-(self.container.height()/2);

        if(!self.load && top >= featured){
            self.load = true;

            self.stats.each(function(index){
                var number = $(this);
                var data = number.data('number');
                var current = 0;

                var interval = setInterval(function(){
                    if(data > 0){
                        if(data > 1000){
                            current = current+1001;
                            data = data-1001;
                        }else{
                            current++;
                            data--;
                        }
                        number.html(self.numberFormat(current));
                    }else{
                        clearInterval(interval);
                    }
                }, 2);
            });
        }
    },
    numberFormat: function(string){
        return string.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "");
    }
};

$(document).ready(function(){
    $.each($('.widgetCounter'), function () {
        new pageNumber(this);
    });
});