var notifyManager = function(){};

notifyManager.prototype = {
    init: function(){
        this.container = $('.messages').find('ul');
    },
    remove: function(element){
        element.removeClass('active');

        setTimeout(function(){
            element.remove();
        }, 300);
    }
};

notifyManager.prototype.add = function(type, string){
    var self = this;

    self.container.append('<li class="'+type+'">'+string+'</li>');
    var element = self.container.find('li').last();

    setTimeout(function(){
        element.addClass('active');
    }, 600);

    setTimeout(function(){
        self.remove(element);
    }, 4000);
};