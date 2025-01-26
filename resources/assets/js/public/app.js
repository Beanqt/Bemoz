app.watch(function(){
    app.document.on('click','.btn-load',function(){
        $(this).addClass('btn-loading').attr('disabled','disabled');
    });

    $('.pickerDate').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('.pickerTime').datetimepicker({
        format: 'HH:mm:ss'
    });
    $('.pickerDateTime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });

    $('form').validator().on('submit', function(e){
        var form = $(this);
        var loader = $(this).data('loader');

        if(isset(loader)){
            if(!e.isDefaultPrevented()) {
                var button = form.find('button[type="submit"]');

                if(isset(button.data('load'))){
                    button.addClass('disabled').attr('disabled','disabled').html(submit.data('load'));
                }else{
                    button.addClass('btn-load btn-loading').attr('disabled','disabled');
                }
            }
        }
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('#main_search').keyup(function(){
        var value = $(this).val();
        var seachBox = $('header .resultSearch');
        var searchList = seachBox.find('ul');
        var error = $(this).data('error');

        if(value.length > 2) {
            searchList.addClass('hidden');
            seachBox.addClass('show');
            seachBox.find('.loader').addClass('active');

            delay(function(){
                post(route('api.search'), {val: value, _token: app.csrf}).done(function(data){
                    seachBox.find('.loader').removeClass('active');
                    searchList.removeClass('hidden');

                    var list = '';
                    $.each(data.searched, function(key, item){
                        if(item.url != '') {
                            list += '<li><a href="' + item['url'] + '"><span class="tag '+(typeof item['color'] != 'undefined' ? item['color'] : '')+'">'+item['tag']+'</span> ' + item['title'] + '</a></li>';
                        }else{
                            list += '<li><span class="tag '+(typeof item['color'] != 'undefined' ? item['color'] : '')+'">'+item['tag']+'</span> ' + item['title'] + '</li>';
                        }
                    });
                    searchList.html(list);
                }).fail(function(){
                    seachBox.find('.loader').removeClass('active');
                    searchList.removeClass('hidden');
                    searchList.html('<li>' + error + '</li>');
                });
            }, 1000);
        }else{
            seachBox.removeClass('show');
        }
    });

    $('.resultSearch').on('click', 'a', function(){
        var input = $('#main_search');
        var value = input.val();
        var form = input.parents('form');

        post(route('api.save.search'), {val: value, _token: app.csrf});

        ga('send', 'pageview', form.attr('action')+'?s='+value);
    });

    $('.search-btn').click(function(){
        app.body.toggleClass('overflow');
        $(this).parents('form').toggleClass('active');
    });
    $('.search-close').click(function(){
        app.body.removeClass('overflow');
        $(this).parents('form').removeClass('active');
    });

    $('.mobil-dropdown').click(function(){
        $(this).parent().toggleClass('open');
    });

    $('.hambibox').find('button').click(function(){
        $('.menu').toggleClass('open');
        $('body').addClass('overflow');

    });
    $('.menu-close').click(function(){
        $('.menu').toggleClass('open');
        $('body').removeClass('overflow');
    });
});