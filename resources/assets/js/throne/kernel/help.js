var helpMessages = function(){};

helpMessages.prototype = {
    init: function(){
        this.current_index = 0;
        this.helps = [];
        this.mask = $('<div class="helpMask"></div>');

        app.body.append(this.mask);
        this.watch();
    },
    watch: function(){
        var self = this;

        app.document.on('click', '.helpPrev:not(.disabled)', function(){
            self.prev();
        }).on('click', '.helpNext:not(.disabled)', function(){
            self.next();
        }).on('click', '.helpSkip', function(){
            self.skip();
        });
    },
    open: function(){
        $.ajax({url: route('help.saveStep', {name: this.helps[this.current_index].name})});
        helps.exeption[this.helps[this.current_index].name] = 'on';

        app.body.css('overflow', 'hidden');
        this.current = this.helps[this.current_index].el;
        this.current.fixParent = isset(this.current.fixParent) ? this.current.fixParent : isFixed(this.current);

        if(this.current.fixParent.length){
            this.current.fixParent.addClass('helpFixedMask');
        }
        this.current._parent = isset(this.current._parent) ? this.current._parent : this.current.parent();

        var prev = '<span class="btn btn-xs btn-primary helpPrev btn-load'+(!this.current_index ? ' disabled' : '')+'"'+(!this.current_index ? ' disabled' : '')+'><i class="fas fa-angle-left"></i> '+helps.elements.prev+'</span>';
        var next = '<span class="btn btn-xs btn-primary helpNext btn-load'+(this.current_index+1 == this.helps.length ? ' disabled' : '')+'"'+(this.current_index+1 == this.helps.length ? ' disabled' : '')+'>'+helps.elements.next+' <i class="fas fa-angle-right"></i></span>';

        if(!this.current_index && this.current_index+1 == this.helps.length){
            next = '';
            prev = '';
        }

        this.current.append('<div class="helpMessage '+this.helps[this.current_index].position+'">'+this.helps[this.current_index].desc+'\
            <div class="helpAction">\
                '+prev+'\
                '+next+'\
                <span class="btn btn-xs btn-danger helpSkip btn-load" data-toggle="tooltip" data-placement="bottom" title="'+helps.elements.close+'"><i class="fas fa-times-circle fa-fw"></i></span> \
            </div></div>');

        this.mask.fadeIn(200);
        this.current._parent.fadeIn(200).addClass('helpActive');
        this.current.find('.helpMessage').fadeIn(200).css('top', (parseInt(this.current.css('height').replace('px', ''))+20));

        app.html.animate({scrollTop : this.current.offset().top-80},800);
    },
    prev: function(){
        var self = this;

        this.current.find('.helpMessage').fadeOut(100, function(){
            self.close();

            self.current_index--;
            self.open();
        });
    },
    next: function(){
        var self = this;

        this.current.find('.helpMessage').fadeOut(100, function(){
            self.close();

            self.current_index++;

            if(self.current_index >= self.helps.length){
                self.mask.fadeOut(100);
            }else{
                self.open();
            }
        });
    },
    skip: function(){
        var self = this;
        this.mask.fadeOut(100);
        this.current.find('.helpMessage').fadeOut(100, function(){
            self.close();
        });
    },
    close: function(){
        app.body.css('overflow', '');
        this.current._parent.removeClass('helpActive');
        if(this.current.fixParent.length){
            this.current.fixParent.removeClass('helpFixedMask');
        }
        this.current.find('.helpMessage').remove();
    }
};

helpMessages.prototype.load = function(){
    var box = $('[data-help]');
    var unique = [];
    this.helps = [];
    this.current_index = 0;

    if(helps.enabled == 'on'){
        for(var i = 0; i < box.length; i++){
            var current = box.eq(i);
            var name = current.data('help');
            var position = current.data('position') ? current.data('position') : 'bottom';
            var array = name.split('|');

            for(var j = 0; j < array.length; j++){
                if(!isset(helps.exeption[array[j]]) && unique.indexOf(array[j]) == -1 && isset(helps.elements[array[j]]) && isset(helps.elements[array[j]].index)){
                    unique.push(array[j]);
                    this.helps.push({
                        el: current,
                        key: j,
                        name: array[j],
                        position: position,
                        index: helps.elements[array[j]].index,
                        title: helps.elements[array[j]].title,
                        desc: helps.elements[array[j]].desc
                    });
                }
            }
        }

        this.helps.sort(function(a, b){ return parseInt(a.index) == parseInt(b.index) ? (a.key < b.key ? 1 : -1) : (parseInt(a.index) > parseInt(b.index) ? 1 : -1)});

        if(this.helps.length){
            this.open();
        }
    }
};