var code = lang==default_lang ? '' : lang;
var routes = new Routes();

routes.group((code ? '/'+code : ''), function(){
    routes.add('/', 'home', 'HomeController@index');
    routes.add('/'+messages.feeds.slug, 'feeds.lists', 'FeedController@lists');
});

routes.group('/api/'+(code ? code+'/' : ''), function(){
    routes.add('{type}/{id}', 'api.embed');
    routes.add('search', 'api.search');
    routes.add('save-search', 'api.save.search');
});

routes.run();