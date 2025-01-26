(function($){
    var characterLength = function(container, options){
        this.container = container;
        this.options = options;
        this.init();
    };

    characterLength.prototype = {
        init: function(){
            this.container.after('<div class="characters"></div>');
            this.max = this.container.attr('maxlength');
            this.content = this.container.next('.characters');
            this.content.html('<div class="characters-inside"><span class="current-character">'+this.container.val().length+'</span>/<span class="max-character">'+this.max+'</span></div>');
            this.current = $(this.content).find('.current-character');

            this.watch();
        },
        watch: function(){
            var self = this;
            self.checkColor(this.container.val().length);

            self.container.keyup(function(){
                var value = $(this).val().length;

                self.current.html(value);
                self.checkColor(value);
            });
        },
        checkColor: function(value){
            var self = this;

            if(self.max == value){
                self.content.addClass('character-full');
                self.content.removeClass('character-warning');
            }else if(value >= self.max - self.max*0.1){
                self.content.addClass('character-warning');
                self.content.removeClass('character-full');
            }else{
                self.content.removeClass('character-full');
                self.content.removeClass('character-warning');
            }
        }
    };

    $.fn.characterLength = function(option) {
        var options = $.extend({}, option);

        return this.each(function() {
            $.data(this, "characterLength", new characterLength($(this), options));
        });
    };
}(jQuery));