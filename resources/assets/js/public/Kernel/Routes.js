var Routes = function(prefix){
    this.url = window.location.pathname;
    this.routes = {};
    this.current_route = null;
    this.group_url = null;
};

Routes.prototype.add = function(url, name, controller, onload){
    this.routes[name] = {
        name: name,
        url: this.group_url+url,
        controller: isset(controller) ? controller : '',
        onload: isset(onload) ? onload : true
    };

    if(this.routes[name].url != '/'){
        this.routes[name].url = this.routes[name].url.replace(/\/$/, '');
    }
};

Routes.prototype.group = function(url, callable){
    this.group_url = url;
    callable();
    this.group_url = null;
};

Routes.prototype.route = function(name, variables){
    return isset(this.routes[name]) ? this.changeRoute(this.routes[name].url, variables) : null;
};

Routes.prototype.getCurrentRouteName = function(){
    return this.current_route.name;
};

Routes.prototype.getCurrentRoute = function(){
    return this.current_route;
};

Routes.prototype.changeRoute = function(route, variables){
    if(typeof variables == 'object') {
        $.each(variables, function (key, index) {
            route = route.replace('{' + key + '}', index);
        });
    }

    return route;
};

Routes.prototype.run = function(){
    var self = this;
    var keys = Object.keys(this.routes).sort(function(a, b){
        return self.routes[a].url.length < self.routes[b].url.length ? 1 : -1;
    });

    for(var i in keys) {
        var current = this.routes[keys[i]];

        if(current.url == '/' && this.url != '/'){
            continue;
        }

        var regex = current.url.replace(/{(.*?)}/g, '(.+)').replace('/','\/');
        var matches = this.url.match('^'+regex);

        if(matches != null){
            this.current_route = current;
            this.current_route.parameters = Array.prototype.slice.call(matches, 1);
            break;
        }
    }


    if(this.current_route != null){
        if(typeof this.current_route.controller == 'function'){
            this.current_route.controller();
        }else if(this.current_route.controller.length){
            var array = this.current_route.controller.split('@');
            var script = document.createElement('script');
            script.src = '/assets/scripts/controllers/'+array[0]+'.js';
            script.crossorigin = 'anonymous';
            script.onload = function(){
                var controller = new window[array[0]]();

                if(self.current_route.onload){
                    $(function(){
                        controller[array[1]](self.current_route.parameters);
                    });
                }else{
                    controller[array[1]](self.current_route.parameters);
                }
            };
            app.head[0].appendChild(script);
        }
    }
};