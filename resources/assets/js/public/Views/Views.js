var Views = function(){};

Views.prototype.animate = function(option){
    var animate = $('.animate');
    if(animate.length){
        animate.customAnimate(option);
    }else{
        animate = null;
    }
};

Views.prototype.filebox = function(option){
    var filebox = $('.customFileBox');
    if(filebox.length){
        filebox.customFileBox(option);
    }else{
        filebox = null;
    }
};

Views.prototype.select = function(option){
    var select = $('.form-custom-select');
    if(select.length){
        select.customSelector(option);
    }else{
        select = null;
    }
};

Views.prototype.paginate = function(){
    app.document.on('click', '.pagination a', function(e){
        e.preventDefault();

        var el = $(this);
        var url = el.attr('href');
        var content = el.parents('.pagination').parent();

        content.addClass('loading');

        get(url, 'html').done(function(data){
            content.html(data);
            content.removeClass('loading');
            app.html.animate({scrollTop : content.offset().top-100},200);
        });
    });
};

Views.prototype.embed = function(){
    var embedClicked = {};

    window.addEventListener('popstate', function(e) {
        createView(e.state, false);
    });

    $('.image-popup').customPopup();
    $('.popup-gallery').customPopup({type: 'gallery'});
    $('.popup-youtube, .popup-vimeo').customPopup({type: 'iframe'});
    $('.popup-html5').customPopup({type: 'video'});
    $('.popup-audio').customPopup({type: 'audio'});

    $('.range').change(function(){
        var range = $(this).val();
        $(this).parent().find('.range-current').text(range);
    });

    app.document.on('click','.folder', function(){
        var id = $(this).data('id');
        var type = $(this).data('type');
        var box = $(this).parents('.embedBox');
        var embedType = box.data('embedtype');
        var boxId = box.data('embedid');
        var alert = box.find('.alert');

        box.find('.loader').addClass('active');
        alert.addClass('hidden');

        var start = '';
        if(typeof box.data('start') != 'undefined'){
            start = box.data('start');
        }

        var data = 'start='+start;
        if(typeof box.data('type') != 'undefined'){
            data += '&type=all';
        }

        if(typeof embedClicked[boxId] == 'undefined'){
            embedClicked[boxId] = true;
            createView({box: embedType, type: type, id: box.data('embedid'), data: data}, true);
        }

        createView({box: embedType, type: type, id: id, data: data}, true);

        ajaxFolder(box, type, id, data);
    });

    function createView(stateObject, pushHistory) {
        if(!pushHistory){
            if(stateObject) {
                var box = $('.' + stateObject.box);
                box.find('.loader').addClass('active');
                box.find('.alert').addClass('hidden');

                ajaxFolder(box, stateObject.type, stateObject.id, stateObject.data);
            }
        }else{
            history.pushState(stateObject, '', '')
        }
    }

    function ajaxFolder(box, type, id, data){
        get(route('api.embed', {type: type, id: id})+(data.length ? '?'+data : '')).done(function(data){
            box.find('.loader').removeClass('active');
            if(data.return){
                box.find('.embedBreadcrumb').html(data.breadcrumb);
                box.find('.elements').html(data.content);
                if(type=='gallery') {
                    box.find('.elements').find('.image-popup').customPopup();
                    box.find('.popup-gallery').customPopup({type: 'gallery'});
                }
                if(type=='video') {
                    box.find('.elements').find('.popup-youtube, .popup-vimeo').customPopup({type: 'iframe'});
                    box.find('.elements').find('.popup-html5').customPopup({type: 'video'});
                }
            }else{
                box.find('.alert').removeClass('hidden').html('<i class="fas fa-exclamation-triangle"></i> '+data.content);
            }
        }).fail(function(){
            box.find('.loader').removeClass('active');
            box.find('.alert').removeClass('hidden').html('<i class="fas fa-exclamation-triangle"></i> '+box.data('ajax-error'));
        });
    }
};

Views.prototype.widgetTab = function(option){
    var widget = $('.widgetTab');
    if(widget.length){
        widget.tabWidget(option);
    }
};