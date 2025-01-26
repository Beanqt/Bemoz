var routes = {
    'api.widget.refresh': '/throne/api/widget/{widget}/refresh',
    'api.widget.add': '/throne/api/widget/{type}/add',
    'api.media_manager.fileupload': '/throne/api/media-manager/fileUpload/{type}',
    'api.media_manager.get': '/throne/api/media-manager/get/{type}',
    'api.media_manager.view': '/throne/api/media-manager/view',
    'api.media_manager.load': '/throne/api/media-manager/load/{type}',
    'api.media_manager.search': '/throne/api/media-manager/search/{type}',
    'help.saveStep': '/throne/saveStep/{name}',
    'online.users': '/throne/user_online',
    'api.slug': '/throne/slugger',
};

function route(name, variables){
    if(isset(routes[name])){
        return changeRoute(routes[name], variables);
    }

    return false;
}

function changeRoute(route, variables){
    if(typeof variables == 'object') {
        $.each(variables, function (key, index) {
            route = route.replace('{' + key + '}', index);
        });
    }

    return route;
}