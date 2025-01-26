var pageManager = function(options){
    this.options = options;
    this.modals = {};
};

pageManager.prototype = {
    init: function(){
        this.menu = $('.menu');
        this.menu.active = this.menu.find('.active');
        this.content = $('.content');
        this.modals.deleted = $('.modal-delete');
        this.beforeSends = [];

        this.watch();
        this.content.trigger('mounted');
    },
    loadPlugins: function(){
        var self = this;

        self.content.find('form').not('.default-form').validator().on('submit', function(e) {
            if(!e.isDefaultPrevented()) {
                for(var i = 0; i < self.beforeSends.length; i++){
                    self.beforeSends[i]();
                }
                self.beforeSends = [];

                if(!config.ajax){
                    return true;
                }
                e.preventDefault();

                var el = $(this);
                var url = isset(el.attr('action')) ? el.attr('action') : window.location;
                var buttons = el.find('button[type="submit"]');
                var data;
                var ajax;

                for(instance in CKEDITOR.instances){
                    CKEDITOR.instances[instance].updateElement();
                }

                data = el.serialize();
                buttons.addClass('btn-load btn-loading').attr('disabled','disabled');

                if(isset(el.attr('enctype'))){
                    data = new FormData(el.get(0));

                    ajax = $.ajax({
                        url: url,
                        method: 'post',
                        data: data,
                        dataType: 'json',
                        contentType: false,
                        processData: false
                    });
                }else{
                    ajax = $.post(url, data, function(){}, "json");
                }

                ajax.done(function(data){
                    if(!empty(data.reload)){
                        if(!empty(data.url)){
                            window.location.href = data.url;
                        }else{
                            window.location.reload();
                        }

                        return false;
                    }

                    self.content.trigger('beforeDelete').html(data.content).addClass('open').trigger('mounted');
                    app.html.animate({scrollTop : 0}, 200);

                    if(!empty(data.url)){
                        history.pushState('', '', data.url);
                    }
                    if(!empty(data.notify)){
                        for (var key in data.notify){
                            app.notify.add(key, data.notify[key]);
                        }
                    }
                }).fail(function(){
                    buttons.removeClass('btn-load btn-loading').removeAttr('disabled');
                    app.notify.add('error', messages.ajax.error);
                });
            }
        });

        this.content.find('.widget-creator').widgetCreator();
        this.content.find('.form-custom-select').customSelector();
        this.content.find('textarea[maxlength]').characterLength();
        //this.content.find('.scheduleWeek').scheduleWeek();
        this.content.find('.dynamic-elements-box').dynamicElements();
        this.content.find('.customFileBox').customFileBox();
        this.content.find('.slim').not('.ignore').slim();
        this.content.find('.color-picker').colorpicker();
        this.content.find('.form-autocomplete').customAutoComplete();

        var nestable = this.content.find('.dd');
        if(nestable.length > 0) {
            var nested = nestable.data('nested');
            var drag = nestable.data('drag');

            if (typeof drag === 'undefined') {
                drag = 'dd-dragel';
            }

            nestable.nestable({
                maxDepth: nested,
                dragClass: drag
            }).on('change', function () {
                $('#nested').val(window.JSON.stringify(nestable.nestable('serialize')));
            });
        }

        app.document.on('click', '.slim-action i', function(){
            var element = $(this);
            var parent = element.parents('.slim').first();
            var slim_size = parent.prev('.slim-size');
            var size = element.data('size').split('x');

            element.parent().find('input').val(element.data('type'));
            parent.slim('setSize', {width: size[0], height: size[1]}, function(data){});
            parent.slim('setForceSize', {width: size[0], height: size[1]}, function(data){});
            parent.slim('setRatio', size[0]+':'+size[1], function(data){});

            slim_size.find('.width').text(size[0]);
            slim_size.find('.height').text(size[1]);
        });

        this.content.find('.panelMenu').find('li').click(function(){
            var target = $(this).parent('ul').data('target');
            var box = $(this).data('id');
            var panels;

            $(this).parents('.panelMenu').find('.active').removeClass('active');
            $(this).addClass('active');

            if(typeof target == 'undefined'){
                panels = $('.panel-'+box).parents('.panels').first();
            }else{
                panels = $(target);
            }

            panels.find('>.active').hide().removeClass('active');
            panels.find('.panel-'+box).show().addClass('active');
        });

        this.content.find('.datetimepicker').datetimepicker();

        this.content.find('.datetimepickermin').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        }).on("dp.change", function (e) {
            $(this).parents('.datetimerange').find('.datetimepickermax').data("DateTimePicker").minDate(e.date);
        });
        this.content.find('.datetimepickermax').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        }).on("dp.change", function (e) {
            $(this).parents('.datetimerange').find('.datetimepickermin').data("DateTimePicker").maxDate(e.date);
        });

        this.content.find('[data-focus]').focus();

        $('.modal').on('hidden.bs.modal',function(){
            if($('.modal').is('.in')){
                $('body').addClass('modal-open');
                $(window).resize();
            }
        });
    },
    watch: function(){
        var self = this;

        app.body.tooltip({
            selector: '[data-toggle="tooltip"]',
            trigger: "hover"
        });

        app.body.on('click', 'a:not(.default-link)', function(e){
            if(!config.ajax){
                return true;
            }
            e.preventDefault();
            var el = $(this);

            if(!isset(el.attr('href')) || isset(el.attr('disabled')) || el.attr('href').indexOf('javascript') != -1){
                return false;
            }
            el.attr('disabled', true);

            if(isset(el.attr('data-remove-menu'))){
                self.menu.find('.active').removeClass('active');
                self.menu.find('.dropdownBox').not(el.parents('.dropdownBox').first()).slideUp(200);
            }

            self.loadPage(el.attr('href'), !el.hasClass('no-follow')).done(function(){
                el.removeAttr('disabled');
            }).fail(function(){
                el.removeClass('btn-loading').removeAttr('disabled');
            });
        });

        app.document.on('click', '.modal-delete-btn', function(){
            var el = $(this);
            var ajax = el.attr('data-ajax');
            var href = el.attr('data-href');

            app.modal.open('.modal-delete', function(modal){
                modal.acceptBtn.attr('href', href);

                if(typeof ajax != 'undefined'){
                    modal.acceptBtn.addClass('default-link');
                }
            });

            if(typeof ajax != 'undefined') {
                app.modal.accept(function(modal) {
                    $.getJSON(href).done(function(data){
                        if(data.return){
                            $(ajax).remove();
                            app.notify.add('success', data.msg);
                        }else{
                            app.notify.add('error', data.msg);
                        }

                        modal.acceptBtn.removeClass('default-link');
                        modal.close();
                    });
                });
            }
        });

        self.menu.find('.dropdown').find('.dropdown-li').click(function(){
            if($(this).parent('.dropdown').hasClass('active')) {
                $(this).parent('.dropdown').removeClass('active').find('.dropdownBox').first().slideUp(200);
            }else{
                $(this).parent('.dropdown').addClass('active').find('.dropdownBox').first().slideDown(200);
            }
        });

        self.menu.on('click', 'a', function(){
            var el = $(this);
            if(isset(el.attr('disabled'))){
                return false;
            }
            self.menu.find('.active').removeClass('active');
            self.menu.find('.dropdownBox').not(el.parents('.dropdownBox').first()).slideUp(200);
            $(this).parents('li').addClass('active');
        });

        app.body.on('click','.change-status', function(){
            var el = $(this);
            var loader = el.find('.status-loader');
            var url = el.data('url');
            var parentStatus = el.parents('.parent-status');

            loader.addClass('active');

            $.getJSON(url).done(function(data){
                loader.removeClass('active');
                el.removeClass('btn-loading').removeAttr('disabled');

                if(data.return){
                    if(data.active){
                        el.addClass('status-active');
                        parentStatus.addClass('status-active');
                    }else{
                        el.removeClass('status-active');
                        parentStatus.removeClass('status-active');
                    }

                    app.notify.add('success', data.msg);
                }else{
                    app.notify.add('error', data.msg);
                }
            }).fail(function(){
                loader.removeClass('active');
                app.notify.add('error', messages.ajax.error);
            });
        });

        app.body.on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var loader = $('.loader-table');
            var form = $('.filterForm');
            var url = form.data('url');
            loader.addClass('active');

            $.getJSON(url+'?page='+page).done(function(data){
                form.find('table').find('tbody').html(data.content);
                app.html.animate({scrollTop : 0},200);
                loader.removeClass('active');
            }).fail(function(){
                loader.removeClass('active');
                app.notify.add('error', messages.ajax.error);
            });
        });

        app.body.on('keyup', 'input[name="title"]', function() {
            var el = $(this);
            var form = el.parents('form').not('.filterForm').first();

            if(form.length){
                var slug = form.find('input[name="slug"]');
                slug.val(el.val().toSlug()).trigger('blur');
            }
        });

        app.body.on('submit', '.filterForm', function(e){
            e.preventDefault();

            var el = $(this);
            var loader = el.find('.loader-table');
            var table = el.find('.table');
            var button = el.find('button[type="submit"]');
            var tbody = table.find('tbody');
            var cols = table.find('thead').find('tr').first().find('th').length;

            loader.addClass('active');

            $.post(el.data('url'), el.serialize()).done(function(data){
                loader.removeClass('active');
                button.removeClass('btn-load').removeAttr('disabled');

                if(data.return){
                    tbody.html(data.content);
                }else{
                    tbody.html('<tr><td colspan="'+cols+'">'+data.msg+'</td></tr>');
                }

                if(typeof data.stat != 'undefined'){
                    $.each(data.stat, function(key, value){
                        $('.result-'+key).text(value);
                    });
                }
            }).fail(function(){
                loader.removeClass('active');
                button.removeClass('btn-load').removeAttr('disabled');
                tbody.html('<tr><td colspan="'+cols+'">'+messages.ajax.error+'</td></tr>');
            });
        });

        app.body.on('click','.btn-load:not(.disabled)',function(){
            $(this).addClass('btn-loading').attr('disabled','disabled');
        });

        self.content.on('beforeDelete', function(){
            if(typeof self.beforeDelete == 'function') {
                self.beforeDelete();
                self.beforeDelete = null;
            }
        });

        self.content.on('mounted', function(){
            if(typeof self.mounted == 'function') {
                self.mounted(self);
                self.mounted = null;
            }

            app.help.load();
            self.loadPlugins();
            self.modals.deleted.modal('hide').find('.modal-footer').find('a').removeClass('btn-loading').removeAttr('disabled');
        });
    }
};

pageManager.prototype.beforeSend = function(callback){
    this.beforeSends.push(callback);
};

pageManager.prototype.loadPage = function(url, hist){
    var self = this;
    hist = typeof hist == 'undefined' ? true : hist;

    self.content.removeClass('open');

    return $.getJSON(url).done(function(data){
        if(!empty(data.reload)){
            window.location.reload();
            return false;
        }
        if(!empty(data.url)){
            history.pushState({menu: app.page.menu.find('.active').find('a').first().attr('href')}, '', data.url);
        }else if(hist){
            history.pushState({menu: app.page.menu.find('.active').find('a').first().attr('href')}, '', url);
        }

        app.html.animate({scrollTop : 0},200);
        self.content.trigger('beforeDelete').html(data.content).addClass('open').trigger('mounted');

        if(!empty(data.notify)){
            for (var key in data.notify){
                app.notify.add(key, data.notify[key]);
            }
        }
    }).fail(function(data) {
        var code = data.status;
        data = isset(data.responseJSON) ? data.responseJSON : {};
        if(isset(data.redirect)){
            window.location = data.redirect;
            return false;
        }
        self.content.addClass('open');
        app.notify.add('error', isset(data.content) && code != 404 ? data.content : messages.ajax.error);
    });
};