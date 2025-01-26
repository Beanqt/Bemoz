var app = {};
app.document = $(document);
app.modal = new modalManager();
app.notify = new notifyManager();
app.help = new helpMessages();
app.page = new pageManager();

$(function(){
    app.html = $('html');
    app.body = $('body');
    app.notify.init();
    app.help.init();
    app.page.init();

    app.csrf = $('meta[name="csrf-token"]').attr('content');

    window.addEventListener('popstate', function(e) {
        if(e.state && e.state.menu){
            app.page.menu.find('.active').removeClass('active');
            app.page.menu.find('a[href="'+e.state.menu+'"]').parents('li').addClass('active');
        }else if(!e.state){
            app.page.menu.find('.active').removeClass('active');
            app.page.menu.find(app.page.menu.active).addClass('active');
        }

        app.page.loadPage(location.href, false);
    });
});